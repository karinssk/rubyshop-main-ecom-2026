<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AboutCompanyController extends Controller
{
    // Map custom slugs to their corresponding view files
    private $BlogsMap = [
        'about-us' => 'aboutcompany1',

    ];

    public function show($slug)
    {
        // Check if the slug exists in our map
        if (isset($this->BlogsMap[$slug])) {
            $viewName = $this->BlogsMap[$slug];
            $viewPath = 'aboutcompany.' . $viewName;
            
            if (View::exists($viewPath)) {
                return view($viewPath);
            }
        }
        
        // If we still want to support the old URL format
        $viewPath = 'aboutcompany.' . $slug;
        if (View::exists($viewPath)) {
            return view($viewPath);
        }
        
        return abort(404);
    }
}
