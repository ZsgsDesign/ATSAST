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
        $str = file_get_contents('http://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1&mkt=zh-CN');
        $array = json_decode($str);
        $imgurl="https://cn.bing.com/".$array->{"images"}[0]->{"url"};
        return view('home', [
            'page_title'=>"发现",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Home",
            'imgurl'=>$imgurl,
        ]);
    }
}
