<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class PromotionController extends Controller
{
    // Map custom slugs to their corresponding view files
    private $promotionMap = [
     
        'rb-1009-rubyshop' => 'promotion30',
        
    ];

    public function show($slug)
    {
        // Check if the slug exists in our map
        if (isset($this->promotionMap[$slug])) {
            $viewName = $this->promotionMap[$slug];
            $viewPath = 'promotion.' . $viewName;
            
            if (View::exists($viewPath)) {
                return view($viewPath);
            }
        }
        
        // If we still want to support the old URL format
        $viewPath = 'promotion.' . $slug;
        if (View::exists($viewPath)) {
            return view($viewPath);
        }
        
        return abort(404);
    }
}
