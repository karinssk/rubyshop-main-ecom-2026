<?php

namespace App\Support;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Ecommerce\Enums\StockStatusEnum;
use Botble\Ecommerce\Models\Product;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PosStockSyncService
{
    public function syncFromCsv(string $file, array $options = []): array
    {
        if (! is_readable($file)) {
            throw new RuntimeException("POS stock file is not readable: {$file}");
        }

        $options = array_merge([
            'apply' => false,
            'source' => 'default',
            'name_column' => 'name',
            'quantity_column' => 'quantity',
            'pos_id_column' => 'pos_id',
        ], $options);

        $rows = $this->readCsv($file);

        return $this->syncRows($rows, $options + ['file' => $file]);
    }

    public function syncFromUltimatePosDatabase(string $database, array $options = []): array
    {
        if (! preg_match('/^[A-Za-z0-9_.-]+$/', $database)) {
            throw new RuntimeException("Invalid POS database name: {$database}");
        }

        $database = str_replace('`', '``', $database);
        $rows = DB::select("
            SELECT
                p.id AS pos_id,
                p.name AS name,
                COALESCE(SUM(vld.qty_available), 0) AS quantity
            FROM `{$database}`.`products` p
            LEFT JOIN `{$database}`.`variations` v
                ON v.product_id = p.id
                AND v.deleted_at IS NULL
            LEFT JOIN `{$database}`.`variation_location_details` vld
                ON vld.variation_id = v.id
            WHERE p.is_inactive = 0
                AND p.not_for_selling = 0
                AND p.enable_stock = 1
            GROUP BY p.id, p.name
            ORDER BY p.id
        ");

        $rows = collect($rows)
            ->mapWithKeys(fn (object $row, int $index) => [
                $index + 1 => [
                    'pos_id' => (string) $row->pos_id,
                    'name' => (string) $row->name,
                    'quantity' => (int) $row->quantity,
                ],
            ])
            ->all();

        return $this->syncRows($rows, array_merge([
            'source' => 'ultimatepos:' . $database,
            'file' => 'database:' . $database,
        ], $options));
    }

    public function syncFromSmaDatabase(string $database, array $options = []): array
    {
        if (! preg_match('/^[A-Za-z0-9_.-]+$/', $database)) {
            throw new RuntimeException("Invalid POS database name: {$database}");
        }

        $database = str_replace('`', '``', $database);
        $rows = DB::select("
            SELECT
                p.id AS pos_id,
                p.name AS name,
                COALESCE(SUM(wp.quantity), p.quantity, 0) AS quantity
            FROM `{$database}`.`sma_products` p
            LEFT JOIN `{$database}`.`sma_warehouses_products` wp
                ON wp.product_id = p.id
            WHERE p.track_quantity = 1
                AND p.hide = 0
                AND p.hide_pos = 0
            GROUP BY p.id, p.name, p.quantity
            ORDER BY p.id
        ");

        $rows = collect($rows)
            ->mapWithKeys(fn (object $row, int $index) => [
                $index + 1 => [
                    'pos_id' => (string) $row->pos_id,
                    'name' => (string) $row->name,
                    'quantity' => (int) $row->quantity,
                ],
            ])
            ->all();

        return $this->syncRows($rows, array_merge([
            'source' => 'sma:' . $database,
            'file' => 'database:' . $database,
        ], $options));
    }

    protected function syncRows(array $rows, array $options = []): array
    {
        $options = array_merge([
            'apply' => false,
            'source' => 'default',
            'name_column' => 'name',
            'quantity_column' => 'quantity',
            'pos_id_column' => 'pos_id',
            'file' => null,
        ], $options);

        $productIndex = $this->buildProductNameIndex();
        $productCodeIndex = $this->buildProductCodeIndex();
        $codeCandidates = $this->buildCodeCandidates($rows, $options, $productCodeIndex);

        $stats = [
            'file' => $options['file'],
            'apply' => (bool) $options['apply'],
            'source' => $options['source'],
            'rows' => count($rows),
            'mapped' => 0,
            'updated' => 0,
            'skipped' => 0,
            'errors' => [],
            'changes' => [],
        ];

        foreach ($rows as $line => $row) {
            $posName = trim((string) ($row[$options['name_column']] ?? ''));
            $quantityRaw = $row[$options['quantity_column']] ?? null;
            $posProductId = trim((string) ($row[$options['pos_id_column']] ?? '')) ?: null;

            if ($posName === '') {
                $this->skip($stats, $line, 'missing product name');
                continue;
            }

            if (! is_numeric($quantityRaw)) {
                $this->skip($stats, $line, 'missing or invalid quantity', $posName);
                continue;
            }

            $quantity = max(0, (int) $quantityRaw);
            $normalizedName = $this->normalizeName($posName);
            $mapping = $this->findMapping($options['source'], $posProductId, $normalizedName);

            if (! $mapping) {
                $matches = $productIndex[$normalizedName] ?? [];
                $matchedBy = $posProductId ? 'pos_id_or_name' : 'name';

                if (count($matches) !== 1) {
                    $candidate = $codeCandidates['by_line'][$line] ?? null;

                    if ($candidate && ($codeCandidates['product_counts'][$candidate->id] ?? 0) === 1) {
                        $matches = [$candidate];
                        $matchedBy = $posProductId ? 'pos_id_or_model_code' : 'model_code';
                    } else {
                        $reason = count($matches) > 1
                            ? 'ambiguous ecommerce product name'
                            : ($candidate ? 'model code collides with multiple POS rows' : 'no ecommerce product name match');
                        $this->skip($stats, $line, $reason, $posName);
                        continue;
                    }
                }

                $mapping = (object) [
                    'product_id' => $matches[0]->id,
                    'created' => true,
                ];

                if ($options['apply']) {
                    DB::table('pos_product_mappings')->updateOrInsert(
                        [
                            'source' => $options['source'],
                            'normalized_name' => $normalizedName,
                        ],
                        [
                            'pos_product_id' => $posProductId,
                            'pos_name' => $posName,
                            'product_id' => $matches[0]->id,
                            'matched_by' => $matchedBy,
                            'updated_at' => now(),
                            'created_at' => now(),
                        ]
                    );
                }

                $stats['mapped']++;
            }

            $product = Product::query()->find($mapping->product_id);
            if (! $product) {
                $this->skip($stats, $line, 'mapped ecommerce product missing', $posName);
                continue;
            }

            $oldQuantity = (int) $product->quantity;
            $oldStatus = (string) $product->stock_status;
            $newStatus = $quantity > 0 ? StockStatusEnum::IN_STOCK : StockStatusEnum::OUT_OF_STOCK;

            $stats['changes'][] = [
                'line' => $line,
                'pos_name' => $posName,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'old_quantity' => $oldQuantity,
                'new_quantity' => $quantity,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
            ];

            if ($options['apply']) {
                $product->forceFill([
                    'with_storehouse_management' => 1,
                    'quantity' => $quantity,
                    'stock_status' => $newStatus,
                ])->save();

                DB::table('pos_product_mappings')
                    ->where('source', $options['source'])
                    ->where('normalized_name', $normalizedName)
                    ->update([
                        'pos_product_id' => $posProductId,
                        'pos_name' => $posName,
                        'last_quantity' => $quantity,
                        'last_synced_at' => now(),
                        'updated_at' => now(),
                    ]);
            }

            $stats['updated']++;
        }

        return $stats;
    }

    public function normalizeName(string $name): string
    {
        $name = html_entity_decode(strip_tags($name), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $name = mb_strtolower($name, 'UTF-8');
        $name = preg_replace('/[^\p{L}\p{N}]+/u', ' ', $name) ?: '';

        return trim(preg_replace('/\s+/u', ' ', $name) ?: '');
    }

    protected function readCsv(string $file): array
    {
        $handle = @fopen($file, 'rb');
        if (! $handle) {
            throw new RuntimeException("Cannot open POS stock file: {$file}");
        }

        $header = fgetcsv($handle);
        if (! is_array($header)) {
            fclose($handle);
            throw new RuntimeException('CSV header row is missing.');
        }

        $header = array_map(fn ($value) => trim((string) $value), $header);
        $rows = [];
        $line = 1;

        while (($data = fgetcsv($handle)) !== false) {
            $line++;
            if ($data === [null] || $data === false) {
                continue;
            }

            $row = [];
            foreach ($header as $index => $column) {
                $row[$column] = $data[$index] ?? null;
            }

            $rows[$line] = $row;
        }

        fclose($handle);

        return $rows;
    }

    protected function buildProductNameIndex(): array
    {
        $index = [];

        Product::query()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->where('is_variation', 0)
            ->get(['id', 'name'])
            ->each(function (Product $product) use (&$index): void {
                $key = $this->normalizeName((string) $product->name);
                $index[$key] ??= [];
                $index[$key][] = $product;
            });

        return $index;
    }

    protected function buildProductCodeIndex(): array
    {
        $index = [];

        Product::query()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->where('is_variation', 0)
            ->get(['id', 'name'])
            ->each(function (Product $product) use (&$index): void {
                foreach ($this->extractModelCodes((string) $product->name) as $code) {
                    $index[$code] ??= [];
                    $index[$code][$product->id] = $product;
                }
            });

        return $index;
    }

    protected function buildCodeCandidates(array $rows, array $options, array $productCodeIndex): array
    {
        $byLine = [];
        $productCounts = [];

        foreach ($rows as $line => $row) {
            $posName = trim((string) ($row[$options['name_column']] ?? ''));
            if ($posName === '') {
                continue;
            }

            $matches = [];
            foreach ($this->extractModelCodes($posName) as $code) {
                foreach ($productCodeIndex[$code] ?? [] as $product) {
                    $matches[$product->id] = $product;
                }
            }

            if (count($matches) === 1) {
                $product = reset($matches);
                $byLine[$line] = $product;
                $productCounts[$product->id] = ($productCounts[$product->id] ?? 0) + 1;
            }
        }

        return [
            'by_line' => $byLine,
            'product_counts' => $productCounts,
        ];
    }

    protected function extractModelCodes(string $name): array
    {
        $name = mb_strtoupper($name, 'UTF-8');
        preg_match_all('/[A-Z]{1,8}[- ]?[A-Z]*[- ]?\d{2,5}[A-Z0-9-]*/u', $name, $matches);

        $codes = [];
        foreach ($matches[0] as $match) {
            $code = preg_replace('/[^A-Z0-9]/', '', $match) ?: '';
            if (strlen($code) >= 4) {
                $codes[$code] = true;
            }
        }

        return array_keys($codes);
    }

    protected function findMapping(string $source, ?string $posProductId, string $normalizedName): ?object
    {
        if ($posProductId) {
            $mapping = DB::table('pos_product_mappings')
                ->where('source', $source)
                ->where('pos_product_id', $posProductId)
                ->first();

            if ($mapping) {
                return $mapping;
            }
        }

        return DB::table('pos_product_mappings')
            ->where('source', $source)
            ->where('normalized_name', $normalizedName)
            ->first();
    }

    protected function skip(array &$stats, int $line, string $reason, ?string $name = null): void
    {
        $stats['skipped']++;
        $stats['errors'][] = array_filter([
            'line' => $line,
            'name' => $name,
            'reason' => $reason,
        ]);
    }
}
