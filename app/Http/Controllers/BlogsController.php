<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class BlogsController extends Controller
{
    // Map custom slugs to their corresponding view files
    private $BlogsMap = [
        '5เครื่องมือช่างที่ช่างมืออาชีพต้องมี' => 'blog1',

    ];

    public function show($slug)
    {
        // Check if the slug exists in our map
        if (isset($this->BlogsMap[$slug])) {
            $viewName = $this->BlogsMap[$slug];
            $viewPath = 'blogs.' . $viewName;
            
            if (View::exists($viewPath)) {
                return view($viewPath);
            }
        }
        
        // If we still want to support the old URL format
        $viewPath = 'blogs.' . $slug;
        if (View::exists($viewPath)) {
            return view($viewPath);
        }
        
        return abort(404);
    }
}
