<?php

namespace App\Http\Controllers;

use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Theme\Facades\Theme;
use Illuminate\Support\Facades\DB;

class AirlessHubController extends Controller
{
    private function fetchProducts(array $slugs): array
    {
        $products = [];
        foreach ($slugs as $slug) {
            $s = DB::table("slugs")->where("key", $slug)->where("reference_type", "like", "%Product%")->first();
            if ($s) {
                $p = DB::table("ec_products")->where("id", $s->reference_id)->where("status", "published")->first();
                if ($p) {
                    $products[] = [
                        "id" => $p->id, "name" => $p->name, "slug" => $slug,
                        "url" => url("/products/" . $slug),
                        "price" => number_format($p->price, 0),
                        "price_raw" => $p->price, "image" => $p->image,
                        "description" => strip_tags($p->description ?? ""),
                    ];
                }
            }
        }
        return $products;
    }

    public function index()
    {
        SeoHelper::setTitle("เครื่องพ่นสีแรงดันสูง (Airless Sprayer) ราคาและรุ่นที่เหมาะกับงานคุณ | RubyShop");
        SeoHelper::setDescription("เปรียบเทียบเครื่องพ่นสีแรงดันสูง RubyShop ทุกรุ่น RB899 RB5300 RB360S สเปก ราคา และเหมาะกับงานแบบไหน พร้อมคำแนะนำจากผู้เชี่ยวชาญ");
        SeoHelper::meta()->setUrl(url("/lp/airless-sprayer-thailand"));
        $products = $this->fetchProducts(["ruby-shop-rb899", "ruby-shop-rb5300-inverter", "rb-360s"]);
        $faqItems = [
            ["q" => "เครื่องพ่นสีแรงดันสูงต่างจากกาพ่นสีไฟฟ้าอย่างไร?", "a" => "เครื่องพ่นสีแรงดันสูง (Airless) ใช้ปั๊มแรงดันสูงดันสีออกโดยตรง ไม่ผสมอากาศ ทำให้พ่นได้เร็ว ครอบคลุมพื้นที่กว้าง เหมาะกับงานขนาดใหญ่และงานรับเหมา"],
            ["q" => "รุ่นไหนเหมาะกับงานทาสีบ้าน?", "a" => "สำหรับงานบ้านทั่วไป แนะนำ RB-360S เพราะขนาดเล็ก น้ำหนักเบา ราคาเข้าถึงได้ง่าย ถ้างานใหญ่กว่านั้น RB5300 Inverter เหมาะสมกว่า"],
            ["q" => "เครื่องพ่นสีแรงดันสูง RubyShop รับประกันกี่ปี?", "a" => "สินค้า RubyShop รับประกันจากศูนย์ มีทีมช่างเทคนิคให้บริการหลังการขาย สอบถามได้ผ่าน LINE"],
            ["q" => "ใช้กับสีประเภทไหนได้บ้าง?", "a" => "ใช้ได้กับสีน้ำ สีน้ำมัน สียางคลอริเนต สีอีพ็อกซี่ ขึ้นอยู่กับรุ่นและขนาดหัวทิป"],
            ["q" => "ต้องการอะไหล่หรือหัวทิป หาได้ที่ไหน?", "a" => "RubyShop มีอะไหล่และหัวทิปทุกขนาด (515, 517, 519, 521) พร้อมส่ง สั่งซื้อได้ผ่านเว็บหรือติดต่อทีมงานโดยตรง"],
            ["q" => "สั่งซื้อแล้วส่งได้เร็วแค่ไหน?", "a" => "สินค้าพร้อมส่งจัดส่งภายใน 1-3 วันทำการ สามารถรับสินค้าที่ร้านได้เช่นกัน"],
        ];
        return Theme::scope("custom.lp-airless-sprayer", compact("products", "faqItems"))->render();
    }

    public function priceGuide()
    {
        SeoHelper::setTitle("ราคาเครื่องพ่นสีแรงดันสูง เปรียบเทียบทุกรุ่น RubyShop 2567 | RubyShop");
        SeoHelper::setDescription("เปรียบเทียบราคาเครื่องพ่นสีแรงดันสูง RubyShop ทุกรุ่น ตั้งแต่รุ่นเล็กราคาหมื่นต้น ถึงรุ่นอุตสาหกรรม เลือกให้ตรงงบและประเภทงาน");
        SeoHelper::meta()->setUrl(url("/lp/airless-sprayer-price"));
        $products = $this->fetchProducts(["rubyshop-rb999s", "ruby-shop-rb899", "ruby-shop-rb5300-inverter", "rb-360s"]);
        $faqItems = [
            ["q" => "เครื่องพ่นสีแรงดันสูงราคาถูกสุดในไลน์ RubyShop คือรุ่นอะไร?", "a" => "RB-360S ราคาเริ่มต้นประมาณ 14,900 บาท เหมาะกับงานบ้านขนาดเล็กหรือทดลองใช้ครั้งแรก"],
            ["q" => "งบสามหมื่นถึงห้าหมื่นควรเลือกรุ่นไหน?", "a" => "แนะนำ RB5300 Inverter (25,500 บาท) สำหรับงานรีโนเวท หรือ RB899 (43,000 บาท) สำหรับงานรับเหมาขนาดกลาง"],
            ["q" => "เครื่องพ่นสีแรงดันสูงราคาแพงกว่า คุ้มค่ากว่าจริงไหม?", "a" => "รุ่นราคาสูงให้แรงดันสูงกว่า พ่นสีหนืดได้ดีกว่า รองรับงานหนักและต่อเนื่องได้ดีกว่า คุ้มค่ากว่าในระยะยาว"],
            ["q" => "มีโปรโมชั่นหรือราคาพิเศษไหม?", "a" => "ติดต่อผ่าน LINE เพื่อสอบถามราคาล่าสุดและโปรโมชั่นพิเศษ"],
            ["q" => "ซื้อเครื่องพ่นสีแรงดันสูงที่ไหนดี?", "a" => "ซื้อตรงจาก RubyShop ผู้นำเข้าและจำหน่ายโดยตรง ได้ราคาดี มีรับประกัน มีทีมช่างเทคนิค"],
        ];
        return Theme::scope("custom.lp-airless-price", compact("products", "faqItems"))->render();
    }
}
