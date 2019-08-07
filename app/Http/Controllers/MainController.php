<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Show the Home Page.
     *
     * @param Request $request your web request
     *
     * @return Response
     */
    public function home(Request $request)
    {
        return view('home', [
            'page_title'=>"发现",
            'site_title'=>"SAST教学辅助平台",
            'navigation' => "Home",
        ]);
    }
}
