<?php

namespace Theme\Wowy\Http\Controllers\Admin;

use Botble\Base\Facades\MetaBox;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Ecommerce\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductLandingBuilderController extends BaseController
{
    public function index(Request $request)
    {
        $this->pageTitle('Landing Page Builder');

        $products = Product::query()
            ->where('is_variation', 0)
            ->select(['id', 'name', 'sku'])
            ->orderByDesc('created_at')
            ->limit(500)
            ->get();

        $productId = (int) $request->integer('product_id');
        $selectedProduct = $productId ? Product::query()->with('slugable')->find($productId) : null;
        $landingSections = [];

        if ($selectedProduct) {
            $rawLandingSections = MetaBox::getMetaData($selectedProduct, 'landing_sections', true);

            if (is_string($rawLandingSections)) {
                $decodedLandingSections = json_decode($rawLandingSections, true);
                $landingSections = is_array($decodedLandingSections) ? $decodedLandingSections : [];
            } elseif (is_array($rawLandingSections)) {
                $landingSections = $rawLandingSections;
            }
        }

        return view('plugins/ecommerce::landing-builder.index', compact('products', 'selectedProduct', 'landingSections'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'landing_sections' => ['nullable', 'array'],
            'landing_sections.*.type' => ['nullable', 'string', 'max:50'],
            'landing_sections.*.title' => ['nullable', 'string', 'max:255'],
            'landing_sections.*.content' => ['nullable', 'string'],
            'landing_sections.*.kicker_text' => ['nullable', 'string', 'max:255'],
            'landing_sections.*.image' => ['nullable', 'string', 'max:1000'],
            'landing_sections.*.text_color' => ['nullable', 'string', 'max:20'],
            'landing_sections.*.kicker_color' => ['nullable', 'string', 'max:20'],
            'landing_sections.*.headline_color' => ['nullable', 'string', 'max:20'],
            'landing_sections.*.subheadline_color' => ['nullable', 'string', 'max:20'],
            'landing_sections.*.backdrop_color' => ['nullable', 'string', 'max:20'],
            'landing_sections.*.backdrop_opacity' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'landing_sections.*.button_text' => ['nullable', 'string', 'max:255'],
            'landing_sections.*.button_url' => ['nullable', 'string', 'max:1000'],
        ]);

        $sectionsInput = $request->input('landing_sections', []);

        $landingSections = collect(is_array($sectionsInput) ? $sectionsInput : [])
            ->filter(fn ($section) => is_array($section))
            ->map(function (array $section): array {
                return [
                    'type' => trim((string) ($section['type'] ?? '')),
                    'title' => trim((string) ($section['title'] ?? '')),
                    'content' => (string) ($section['content'] ?? ''),
                    'kicker_text' => trim((string) ($section['kicker_text'] ?? '')),
                    'image' => trim((string) ($section['image'] ?? '')),
                    'text_color' => trim((string) ($section['text_color'] ?? '')),
                    'kicker_color' => trim((string) ($section['kicker_color'] ?? '')),
                    'headline_color' => trim((string) ($section['headline_color'] ?? '')),
                    'subheadline_color' => trim((string) ($section['subheadline_color'] ?? '')),
                    'backdrop_color' => trim((string) ($section['backdrop_color'] ?? '')),
                    'backdrop_opacity' => isset($section['backdrop_opacity']) && $section['backdrop_opacity'] !== ''
                        ? max(0, min(100, (int) $section['backdrop_opacity']))
                        : null,
                    'button_text' => trim((string) ($section['button_text'] ?? '')),
                    'button_url' => trim((string) ($section['button_url'] ?? '')),
                ];
            })
            ->filter(fn (array $section) => $section['type'] !== '')
            ->values()
            ->all();

        MetaBox::saveMetaBoxData($product, 'landing_sections', json_encode($landingSections, JSON_UNESCAPED_UNICODE));

        return redirect()
            ->route('ecommerce.landing-builder.index', ['product_id' => $product->id])
            ->with('status', 'Landing sections updated.');
    }
}
