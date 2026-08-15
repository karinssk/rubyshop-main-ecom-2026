<?php

namespace App\Http\Controllers;

use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Theme\Facades\Theme;
use Illuminate\Support\Facades\DB;

class ToolHubController extends Controller
{
    private function fetchProducts(array $slugs): array
    {
        $products = [];
        foreach ($slugs as $slug) {
            $s = DB::table('slugs')->where('key', $slug)->where('reference_type', 'like', '%Product%')->first();
            if ($s) {
                $p = DB::table('ec_products')->where('id', $s->reference_id)->where('status', 'published')->first();
                if ($p) {
                    $products[] = [
                        'id' => $p->id, 'name' => $p->name, 'slug' => $slug,
                        'url' => url('/products/' . $slug),
                        'price' => number_format($p->price, 0),
                        'price_raw' => $p->price, 'image' => $p->image,
                    ];
                }
            }
        }
        return $products;
    }

    public function drywallSander()
    {
        SeoHelper::setTitle('เครื่องขัดผนัง ดูดฝุ่นในตัว ครบทุกรุ่น RubyShop | เลือกให้ตรงงาน');
        SeoHelper::setDescription('เปรียบเทียบเครื่องขัดผนัง RubyShop ทุกรุ่น RB-DWS180S RB-DWS225B DWS-225G ระบบดูดฝุ่นในตัว เตรียมผิวสกิมโค้ท งานเนียน ไม่ฝุ่น');
        SeoHelper::meta()->setUrl(url('/lp/drywall-sander'));
        $products = $this->fetchProducts([
            'rubyshop-dws-225g-1', 'rubyshop-rb-dws-225a-5',
            'rubyshop-floor-sander-cement-polishing-machine-rb-fp01',
            'rubyshop-paint-remover-1200w-rb-sp01',
        ]);
        $faqItems = [
            ['q' => 'เครื่องขัดผนังดูดฝุ่นในตัวคือรุ่นไหน?', 'a' => 'RubyShop มีหลายรุ่นที่มีระบบดูดฝุ่นในตัว เช่น RB-DWS225A, DWS-225G ทุกรุ่นมีถุงเก็บฝุ่น ทำให้สถานที่ทำงานสะอาด'],
            ['q' => 'เครื่องขัดผนังใช้กับสกิมโค้ทได้ไหม?', 'a' => 'ได้ครับ ออกแบบมาสำหรับงานขัดผิวสกิมโค้ท ปูนฉาบ ก่อนทาสี ใบขัดกลมช่วยให้ผิวงานเนียนสม่ำเสมอ'],
            ['q' => 'รุ่นมือจับสั้นกับด้ามยาวต่างกันอย่างไร?', 'a' => 'รุ่นมือจับสั้นเหมาะกับพื้นที่แคบ น้ำหนักเบา ส่วนรุ่นด้ามยาวเหมาะกับงานพื้นที่สูงเช่นเพดาน ไม่ต้องใช้นั่งร้าน'],
            ['q' => 'กระดาษทรายต้องใช้เบอร์ไหน?', 'a' => 'เริ่มด้วยเบอร์ 80 สำหรับขัดหยาบ 120-150 สำหรับขัดละเอียด 180-240 สำหรับขัดเก็บผิวก่อนทาสี'],
            ['q' => 'เครื่องขัดผนัง RubyShop เหมาะกับงานรับเหมาไหม?', 'a' => 'เหมาะมากครับ ออกแบบมาสำหรับการใช้งานหนักและต่อเนื่อง ช่วยลดเวลาขัดผิวก่อนทาสีได้มาก'],
        ];
        return Theme::scope('custom.lp-drywall-sander', compact('products', 'faqItems'))->render();
    }

    public function wallChaser()
    {
        SeoHelper::setTitle('เครื่องกรีดผนัง เซาะร่อง Wall Chaser ทุกรุ่น RubyShop | เลือกให้เหมาะงาน');
        SeoHelper::setDescription('เปรียบเทียบเครื่องกรีดผนัง RubyShop ทุกรุ่น WALLCD-100A WALLCD-80B WALLCD-BL28 กรีดอิฐมวลเบา คอนกรีต ระบบน้ำ ไร้ฝุ่น เลือกให้เหมาะกับงาน');
        SeoHelper::meta()->setUrl(url('/lp/wall-chaser'));
        $products = $this->fetchProducts([
            'ruby-shop-wall-cutter-2500-wallcd-100a',
            'rubyshop-wallcd-1100-1100w',
            'ruby-shop-wall-cutter-1100w-wallcd-80b',
            'rubyshop-wallcd-620-1-24',
        ]);
        $faqItems = [
            ['q' => 'เครื่องกรีดผนังใช้กับอิฐมวลเบาได้ไหม?', 'a' => 'ได้ครับ รุ่น WALLCD-100A และ WALLCD-80B ออกแบบมาสำหรับอิฐมวลเบาโดยเฉพาะ กรีดได้ลึก คม และรวดเร็ว'],
            ['q' => 'กรีดผนังคอนกรีตต้องใช้รุ่นไหน?', 'a' => 'แนะนำ WALLCD-620-1 ขนาด 24 นิ้ว ระบบน้ำ เหมาะกับงานตัดผนังคอนกรีตและพื้น ใบตัดใหญ่ กำลังสูง'],
            ['q' => 'ระบบน้ำในเครื่องกรีดผนังทำงานอย่างไร?', 'a' => 'ระบบน้ำช่วยลดฝุ่นขณะกรีด ทำให้สถานที่ทำงานสะอาดขึ้น ลดความร้อนของใบตัด ทำให้ใบตัดอยู่ได้นานขึ้น'],
            ['q' => 'ความลึกในการกรีดปรับได้ไหม?', 'a' => 'ได้ครับ ทุกรุ่นมีระบบปรับความลึกได้ สำหรับงานเดินสายไฟ ท่อน้ำ หรืองานเซาะร่องตามความต้องการ'],
            ['q' => 'เครื่องกรีดผนัง RubyShop มีอะไหล่ให้ไหม?', 'a' => 'มีครับ RubyShop มีใบตัดและอะไหล่สำหรับทุกรุ่นพร้อมจำหน่าย สามารถติดต่อสั่งซื้อผ่าน LINE ได้เลย'],
        ];
        return Theme::scope('custom.lp-wall-chaser', compact('products', 'faqItems'))->render();
    }

    public function sprayGun()
    {
        SeoHelper::setTitle('ปืนพ่นสี Airless ทุกรุ่น RubyShop | เลือกให้ตรงงาน ราคาดี');
        SeoHelper::setDescription('เปรียบเทียบปืนพ่นสี Airless RubyShop ทุกรุ่น RB-G210 RB-G230 RB-SG07 SG08 SG09 สำหรับงานพ่นสี สกิมโค้ท ปูนซีเมนต์ เลือกให้เหมาะกับงาน');
        SeoHelper::meta()->setUrl(url('/lp/airless-spray-gun'));
        $products = DB::table('ec_products as p')
            ->join('slugs as s', function($j) {
                $j->on('s.reference_id', '=', 'p.id')
                  ->where('s.reference_type', 'like', '%Product%');
            })
            ->where('p.status', 'published')
            ->where('p.is_variation', 0)
            ->where(function($q) {
                $q->where('p.name', 'like', '%spray gun%')
                  ->orWhere('p.name', 'like', '%Spray Gun%')
                  ->orWhere('p.name', 'like', '%ปืนพ่นสี%')
                  ->orWhere('p.name', 'like', '%SG0%')
                  ->orWhere('p.name', 'like', '%RB-G2%')
                  ->orWhere('p.name', 'like', '%YM220%');
            })
            // ตัดสินค้าที่ไม่ใช่ airless spray gun ออก
            ->where('p.name', 'not like', '%Mortar%')
            ->where('p.name', 'not like', '%mortar%')
            ->where('p.name', 'not like', '%Filter%')
            ->where('p.name', 'not like', '%filter%')
            ->where('p.name', 'not like', '%Texture%')
            ->where('p.name', 'not like', '%texture%')
            ->where('p.name', 'not like', '%COMPRESSOR%')
            ->where('p.name', 'not like', '%compressor%')
            ->where('p.name', 'not like', '%ถัง%')
            ->where('p.price', '>', 0)
            ->orderByDesc('p.price')
            ->limit(20)
            ->get(['p.id', 'p.name', 'p.price', 'p.image', 's.key as slug'])
            ->map(function($p) {
                return [
                    'id'        => $p->id,
                    'name'      => $p->name,
                    'slug'      => $p->slug,
                    'url'       => url('/products/' . $p->slug),
                    'price'     => number_format($p->price, 0),
                    'price_raw' => $p->price,
                    'image'     => $p->image,
                ];
            })->toArray();
        $faqItems = [
            ['q' => 'ปืนพ่นสี Airless กับปืนพ่นสีแรงดันต่ำต่างกันอย่างไร?', 'a' => 'ปืนพ่นสี Airless ใช้แรงดันสูงพ่นสีโดยตรง ไม่ต้องใช้ลมอัด ทำให้สีเนียนกว่า ครอบคลุมพื้นที่กว้างกว่า และใช้กับสีหนืดได้ดีกว่าปืนพ่นสีแบบลม'],
            ['q' => 'ปืนพ่น RB-G210 vs RB-G230 ต่างกันอย่างไร?', 'a' => 'RB-G210 เหมาะกับงานทั่วไปราคาเข้าถึงได้ ส่วน RB-G230 มีแรงดันสูงกว่า รองรับสีหนืดได้ดีกว่า เหมาะกับงานรับเหมาและงานหนัก'],
            ['q' => 'ปืนพ่นสกิมโค้ทใช้ปืนรุ่นไหนดี?', 'a' => 'แนะนำ Spray Gun skim coat RB-02 หรือ MH6 ออกแบบมาเฉพาะสำหรับสกิมโค้ทและปูนฉาบ ให้ผิวงานเนียนสม่ำเสมอ'],
            ['q' => 'filter airless spray gun ต้องเปลี่ยนบ่อยแค่ไหน?', 'a' => 'ขึ้นอยู่กับความถี่การใช้งาน แนะนำตรวจสอบทุก 5-10 ถังสี หรือเมื่อสังเกตว่าแรงดันลดลงหรือสีพ่นไม่เรียบ RubyShop มี filter ทุกขนาดพร้อมจำหน่าย'],
            ['q' => 'ซื้อปืนพ่นสีได้ที่ไหน มีรับประกันไหม?', 'a' => 'สั่งซื้อได้โดยตรงที่ RubyShop มีรับประกันสินค้า อะไหล่พร้อมส่ง และทีมช่างเทคนิคให้คำแนะนำ'],
        ];
        return Theme::scope('custom.lp-spray-gun', compact('products', 'faqItems'))->render();
    }

    public function airlessHose()
    {
        SeoHelper::setTitle('สายพ่นสีแรงดันสูง Airless Hose ทุกขนาด RubyShop | 5m 10m 15m พร้อมส่ง');
        SeoHelper::setDescription('เลือกสายพ่นสีแรงดันสูง RubyShop ทุกขนาด 5m 10m 15m ขนาด 1/4 และ 3/8 นิ้ว รองรับแรงดันสูง ทนทาน ใช้กับเครื่องพ่นสี Airless RubyShop ทุกรุ่น');
        SeoHelper::meta()->setUrl(url('/lp/airless-hose'));

        $products = DB::table('ec_products as p')
            ->join('slugs as s', function($j) {
                $j->on('s.reference_id', '=', 'p.id')
                  ->where('s.reference_type', 'like', '%Product%');
            })
            ->join('ec_product_category_product as pcp', 'pcp.product_id', '=', 'p.id')
            ->where('pcp.category_id', 89) // Airless Hose | สายพ่นสีแรงดันสูง
            ->where('p.status', 'published')
            ->where('p.is_variation', 0)
            ->where('p.price', '>', 0)
            ->orderByDesc('p.price')
            ->limit(20)
            ->get(['p.id', 'p.name', 'p.price', 'p.image', 'p.quantity', 's.key as slug'])
            ->map(function($p) {
                return [
                    'id'        => $p->id,
                    'name'      => $p->name,
                    'slug'      => $p->slug,
                    'url'       => url('/products/' . $p->slug),
                    'price'     => number_format($p->price, 0),
                    'price_raw' => $p->price,
                    'image'     => $p->image,
                    'quantity'  => $p->quantity,
                ];
            })->toArray();

        $faqItems = [
            ['q' => 'สายพ่นสีแรงดันสูง 1/4 กับ 3/8 ต่างกันอย่างไร?', 'a' => 'สาย 1/4 นิ้ว เบา ยืดหยุ่น เหมาะกับงานพ่นสีทั่วไปและงานในที่แคบ ส่วนสาย 3/8 นิ้ว ผ่านสีได้มากกว่า แรงดันสูงกว่า เหมาะกับงานพ่นสีพื้นที่ใหญ่และงานรับเหมา'],
            ['q' => 'ควรเลือกสายยาวเท่าไหร่?', 'a' => 'สาย 5m เหมาะกับงานในพื้นที่เล็กหรือทดลองใช้ สาย 10m เหมาะกับงานทั่วไป สาย 15m เหมาะกับงานพื้นที่กว้างและอาคารหลายชั้น ยิ่งสายยาวยิ่งลดการเคลื่อนย้ายเครื่อง'],
            ['q' => 'สายพ่นสี RubyShop ใช้กับเครื่องพ่นสีแบรนด์อื่นได้ไหม?', 'a' => 'สาย RB-PS ใช้ข้อต่อมาตรฐาน 1/4 และ 3/8 นิ้ว ใช้ร่วมกับเครื่องพ่นสี Airless ทั่วไปได้ แนะนำตรวจสอบข้อต่อก่อนใช้งาน หรือสอบถามทีมงาน RubyShop'],
            ['q' => 'สายพ่นสีต้องดูแลอย่างไร?', 'a' => 'หลังใช้งานควรล้างสายด้วยทินเนอร์หรือน้ำสะอาดตามประเภทสีที่ใช้ ม้วนเก็บอย่างระวัง ไม่งอพับแหลม เก็บในที่ร่ม หลีกเลี่ยงแสงแดดโดยตรงเพื่อยืดอายุการใช้งาน'],
            ['q' => 'ซื้อสายพ่นสีได้ที่ไหน มีรับประกันไหม?', 'a' => 'สั่งซื้อได้โดยตรงที่ RubyShop มีสต็อกพร้อมส่ง รับประกันคุณภาพ อะไหล่และข้อต่อครบ สอบถามเพิ่มเติมผ่าน LINE ได้ตลอดเวลา'],
        ];

        return Theme::scope('custom.lp-airless-hose', compact('products', 'faqItems'))->render();
    }
}
