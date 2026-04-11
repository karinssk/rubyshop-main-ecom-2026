<?php

namespace App\Http\Controllers;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Facades\MetaBox;
use Botble\Ecommerce\Models\Product;
use Botble\Ecommerce\Services\Products\GetProductBySlugService;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Theme\Facades\Theme;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ProductLandingController extends Controller
{
    protected array $defaultLandingSections = [
        ['type' => 'hero_section_v2', 'title' => '4 คน ฉาบได้เท่า 8 คน — เร็วขึ้น 5 เท่า', 'content' => 'คืนทุนภายใน 3 เดือน พร้อมระบบผสมอัตโนมัติ ทำงานต่อเนื่อง ไม่สะดุด'],
        ['type' => 'primary_cta', 'title' => 'Get Started Now', 'content' => ''],
        ['type' => 'trust_indicators', 'title' => 'Trusted by Professionals', 'content' => ''],
        ['type' => 'problem_section', 'title' => 'Common Problems', 'content' => ''],
        ['type' => 'solution_overview', 'title' => 'Our Solution', 'content' => ''],
        ['type' => 'key_benefits', 'title' => 'Key Benefits', 'content' => ''],
        ['type' => 'product_features_specifications', 'title' => 'Features & Specifications', 'content' => ''],
        ['type' => 'how_it_works', 'title' => 'How It Works', 'content' => ''],
        ['type' => 'before_after_results', 'title' => 'Before / After Results', 'content' => ''],
        ['type' => 'video_demo', 'title' => 'Live Demonstration', 'content' => ''],
        ['type' => 'testimonials_reviews', 'title' => 'Customer Reviews', 'content' => ''],
        ['type' => 'comparison', 'title' => 'Why Rubyshop', 'content' => ''],
        ['type' => 'use_cases', 'title' => 'Who It’s For', 'content' => ''],
        ['type' => 'pricing_offer', 'title' => 'Pricing & Offer', 'content' => ''],
        ['type' => 'risk_reversal', 'title' => 'Warranty & Guarantee', 'content' => ''],
        ['type' => 'faq_section', 'title' => 'FAQ', 'content' => ''],
        ['type' => 'secondary_cta', 'title' => 'Need More Details?', 'content' => ''],
        ['type' => 'urgency_scarcity', 'title' => 'Limited Time Offer', 'content' => ''],
        ['type' => 'contact_section', 'title' => 'Contact Us', 'content' => ''],
        ['type' => 'final_cta', 'title' => 'Ready to Order?', 'content' => ''],
        ['type' => 'footer_basic_legal', 'title' => 'Legal & Company Info', 'content' => ''],
    ];

    public function index(): RedirectResponse
    {
        $product = Product::query()
            ->wherePublished()
            ->where('is_variation', 0)
            ->orderByDesc('is_featured')
            ->orderByDesc('created_at')
            ->with('slugable')
            ->firstOrFail();

        return redirect()->route('landing.product', ['slug' => $product->slug]);
    }

    public function show(string $slug, Request $request, GetProductBySlugService $getProductBySlugService): string
    {
        $product = $getProductBySlugService->handle($slug, [
            'with' => [
                'slugable',
                'brand',
                'categories',
                'categories.slugable',
                'specificationAttributes',
                'specificationTable',
                'productLabels',
                'tags',
            ],
            'withCount' => ['reviews'],
        ]);

        abort_unless($product, 404);

        $gallery = collect([$product->image, ...$product->images])
            ->filter()
            ->unique()
            ->values();

        $specifications = $product->specificationAttributes
            ->where('pivot.hidden', false)
            ->sortBy('pivot.order')
            ->values();

        $relatedProducts = Product::query()
            ->wherePublished()
            ->where('is_variation', 0)
            ->where('id', '!=', $product->id)
            ->when($product->brand_id, function ($query) use ($product): void {
                $query->where('brand_id', $product->brand_id);
            })
            ->orderByDesc('is_featured')
            ->orderByDesc('created_at')
            ->take(4)
            ->with(['slugable', 'brand'])
            ->get();

        if ($relatedProducts->isEmpty()) {
            $relatedProducts = Product::query()
                ->wherePublished()
                ->where('is_variation', 0)
                ->where('id', '!=', $product->id)
                ->orderByDesc('created_at')
                ->take(4)
                ->with(['slugable', 'brand'])
                ->get();
        }

        $categoryNames = $product->categories->pluck('name')->filter()->values();
        $landingQuery = $request->query();
        $productUrlWithQuery = $product->url . (! empty($landingQuery) ? ('?' . http_build_query($landingQuery)) : '');
        $productsUrlWithQuery = route('public.products', $landingQuery);
        $landingSections = $this->getLandingSections($product);

        Theme::layout('full-width');
        Theme::set('pageTitle', $product->name . ' | Rubyshop');
        Theme::set('hasBreadcrumb', false);

        SeoHelper::setTitle($product->name . ' | Rubyshop')
            ->setDescription(BaseHelper::clean(strip_tags((string) $product->description)));

        return Theme::scope('custom.product-landing', [
            'product' => $product,
            'gallery' => $gallery,
            'specifications' => $specifications,
            'relatedProducts' => $relatedProducts,
            'categoryNames' => $categoryNames,
            'productUrlWithQuery' => $productUrlWithQuery,
            'productsUrlWithQuery' => $productsUrlWithQuery,
            'landingSections' => $landingSections,
        ])->render();
    }

    protected function getLandingSections(Product $product): array
    {
        $rawValue = MetaBox::getMetaData($product, 'landing_sections', true);

        if (is_string($rawValue)) {
            $decoded = json_decode($rawValue, true);
            $rawSections = is_array($decoded) ? $decoded : [];
        } elseif (is_array($rawValue)) {
            $rawSections = $rawValue;
        } else {
            $rawSections = [];
        }

        $sections = collect($rawSections)
            ->filter(fn ($section) => is_array($section))
            ->map(function (array $section): array {
                return [
                    'type' => (string) ($section['type'] ?? 'custom_text'),
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

        return ! empty($sections) ? $sections : $this->defaultLandingSections;
    }
}
