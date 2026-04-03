<?php

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Page\Models\Page;
use Botble\Slug\Facades\SlugHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('pages')) {
            return;
        }

        $page = Page::query()->firstOrCreate(
            ['name' => 'RubyShop RB-M30L Motor Sprayer'],
            [
                'content' => '',
                'template' => 'rubyshop-m30l-motarsprayer',
                'status' => BaseStatusEnum::PUBLISHED,
                'user_id' => 1,
            ]
        );

        SlugHelper::createSlug($page, (string) Str::slug('rubyshop-m30l-motarsprayer'));
    }

    public function down(): void
    {
        if (! Schema::hasTable('pages')) {
            return;
        }

        $page = Page::query()
            ->where('template', 'rubyshop-m30l-motarsprayer')
            ->where('name', 'RubyShop RB-M30L Motor Sprayer')
            ->first();

        if ($page) {
            DB::table('slugs')
                ->where('reference_type', Page::class)
                ->where('reference_id', $page->getKey())
                ->delete();

            $page->delete();
        }
    }
};
