<?php

namespace App\Http\Controllers;

use Botble\SeoHelper\Facades\SeoHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class BlogsController extends Controller
{
    // Map custom slugs to their corresponding view files
    private $BlogsMap = [
        '5เครื่องมือช่างที่ช่างมืออาชีพต้องมี' => 'blog1',

    ];

    // Optional per-blog SEO metadata
    private $BlogsMeta = [
        'blog1' => [
            'title'       => '5 เครื่องมือช่างที่ช่างมืออาชีพต้องมี | RubyShop',
            'description' => 'รวม 5 เครื่องมือช่างที่ช่างมืออาชีพทุกคนควรมีติดมือ พร้อมคำแนะนำการเลือกซื้อจาก RubyShop',
        ],
    ];

    public function show($slug)
    {
        // Check if the slug exists in our map
        if (isset($this->BlogsMap[$slug])) {
            $viewName = $this->BlogsMap[$slug];
            $viewPath = 'blogs.' . $viewName;

            if (View::exists($viewPath)) {
                $meta = $this->BlogsMeta[$viewName] ?? [];
                SeoHelper::setTitle($meta['title'] ?? 'บทความ | RubyShop');
                SeoHelper::setDescription($meta['description'] ?? 'อ่านบทความเครื่องมือช่างจาก RubyShop');
                SeoHelper::meta()->setUrl(url()->current());

                return view($viewPath);
            }
        }

        // If we still want to support the old URL format
        $viewPath = 'blogs.' . $slug;
        if (View::exists($viewPath)) {
            $meta = $this->BlogsMeta[$slug] ?? [];
            SeoHelper::setTitle($meta['title'] ?? 'บทความ | RubyShop');
            SeoHelper::setDescription($meta['description'] ?? 'อ่านบทความเครื่องมือช่างจาก RubyShop');
            SeoHelper::meta()->setUrl(url()->current());

            return view($viewPath);
        }

        return abort(404);
    }
}
