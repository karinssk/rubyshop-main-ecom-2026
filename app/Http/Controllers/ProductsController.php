<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ProductsController extends Controller
{
    // Map custom slugs to their corresponding view files
    private $BlogsMap = [
        'allproducts' => 'allproducts1',

    ];

    public function show($slug)
    {
        // Check if the slug exists in our map
        if (isset($this->BlogsMap[$slug])) {
            $viewName = $this->BlogsMap[$slug];
            $viewPath = 'allproducts.' . $viewName;
            
            if (View::exists($viewPath)) {
                return view($viewPath);
            }
        }
        
        // If we still want to support the old URL format
        $viewPath = 'allproducts.' . $slug;
        if (View::exists($viewPath)) {
            return view($viewPath);
        }
        
        return abort(404);
    }
}
