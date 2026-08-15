<?php

namespace App\Http\Controllers;

use Botble\Base\Facades\BaseHelper;
use Botble\Ecommerce\Models\Product;
use Botble\Ecommerce\Services\Products\GetProductBySlugService;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Theme\Facades\Theme;
use Illuminate\Http\Request;

class Rb360LandingController extends Controller
{
    public function show(Request $request, GetProductBySlugService $getProductBySlugService): string
    {
        $product = $this->resolveProduct($getProductBySlugService);

        abort_unless($product, 404);

        $gallery = collect([$product->image, ...$product->images])
            ->filter()
            ->unique()
            ->values();

        $specifications = $product->specificationAttributes
            ->where('pivot.hidden', false)
            ->sortBy('pivot.order')
            ->values();

        $faqItems = [
            [
                'q' => 'RB-360 ใช้กับสีประเภทไหนได้บ้าง?',
                'a' => 'รองรับงานพ่นสีทั่วไปหลายประเภท เช่น สีน้ำและสีน้ำมัน โดยควรเตรียมความหนืดให้เหมาะกับหัวพ่นและงานจริง',
            ],
            [
                'q' => 'RB-360 เหมาะกับใคร?',
                'a' => 'เหมาะกับช่างรับเหมา ทีมรีโนเวท และผู้ที่ต้องการเครื่องพ่นสีแรงดันสูงที่คล่องตัว น้ำหนักเบา พกพาหน้างานง่าย',
            ],
            [
                'q' => 'มีบริการหลังการขายไหม?',
                'a' => 'มีทีมแนะนำการใช้งานและบริการหลังการขายผ่านช่องทางโทรศัพท์และ LINE Official ของ Rubyshop',
            ],
            [
                'q' => 'สั่งซื้อหรือขอใบเสนอราคาได้อย่างไร?',
                'a' => 'กดปุ่มโทรหรือแชท LINE ในหน้านี้ได้ทันที หรือกดไปยังหน้าสินค้าเพื่อตรวจสอบรายละเอียดเพิ่มเติม',
            ],
        ];

        $lineUrl = 'https://page.line.me/rubyshop168?openQrModal=true';
        $contactPhoneDisplay = '089-666-7802';
        $contactPhone = '0896667802';
        $price = $product->front_sale_price_with_taxes;
        $oldPrice = $product->price_with_taxes;

        $description = BaseHelper::clean(strip_tags((string) ($product->description ?: $product->content)));
        $description = trim($description) !== '' ? $description : 'เครื่องพ่นสีแรงดันสูง RUBYSHOP รุ่น RB-360 น้ำหนักเบา ประสิทธิภาพสูง ใช้งานหน้างานได้คล่องตัว';

        // Determine canonical product URL based on resolved product slug
        $canonicalSlug = $product->slug ?: 'rubyshop-rb-360';
        $canonicalUrl = 'https://www.rubyshop.co.th/products/' . $canonicalSlug;

        Theme::layout('full-width');
        Theme::set('pageTitle', 'RB-360 เครื่องพ่นสีแรงดันสูง | หน้าโปรโมชันพิเศษ');
        Theme::set('hasBreadcrumb', false);

        SeoHelper::setTitle('RB-360 เครื่องพ่นสีแรงดันสูง | RUBYSHOP')
            ->setDescription($description)
            ->openGraph()
            ->setType('product')
            ->setTitle('RB-360 เครื่องพ่นสีแรงดันสูง | RUBYSHOP')
            ->setDescription($description)
            ->setImage($gallery->first() ?: $product->image);
        SeoHelper::meta()->setUrl($canonicalUrl);

        return Theme::scope('custom.landing-rb360', [
            'product' => $product,
            'gallery' => $gallery,
            'specifications' => $specifications,
            'faqItems' => $faqItems,
            'lineUrl' => $lineUrl,
            'contactPhone' => $contactPhone,
            'contactPhoneDisplay' => $contactPhoneDisplay,
            'price' => $price,
            'oldPrice' => $oldPrice,
            'trackingQuery' => $request->query(),
        ])->render();
    }

    protected function resolveProduct(GetProductBySlugService $getProductBySlugService): ?Product
    {
        $targetSlugs = ['rubyshop-rb-360-1', 'rubyshop-rb-360', 'rb-360'];

        foreach ($targetSlugs as $slug) {
            $product = $getProductBySlugService->handle($slug, [
                'with' => [
                    'slugable',
                    'brand',
                    'categories',
                    'specificationAttributes',
                    'specificationTable',
                ],
                'withCount' => ['reviews'],
            ]);

            if ($product) {
                return $product;
            }
        }

        return Product::query()
            ->wherePublished()
            ->where('is_variation', 0)
            ->where(function ($query): void {
                $query->where('name', 'like', '%RB-360%')
                    ->orWhere('name', 'like', '%rb 360%')
                    ->orWhere('sku', 'like', '%RB-360%');
            })
            ->with([
                'slugable',
                'brand',
                'categories',
                'specificationAttributes',
                'specificationTable',
            ])
            ->first();
    }
}
