<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Eloquents\Carousel;
use App\Models\ToolModel;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function home()
    {
        $carousels = Carousel::where('available',1)->get();
        return view('home', [
            'page_title' => "发现",
            'site_title' => "SAST教学辅助平台",
            'navigation' => "Home",
            'carousels'  =>  $carousels
        ]);
    }
}
