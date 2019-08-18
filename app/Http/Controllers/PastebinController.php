<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PastebinModel;
use Illuminate\Http\Request;

class PastebinController extends Controller
{
    public function index(Request $request)
    {
        return view('pastebin.index', [
            'page_title'=>"PasteBin",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Pastebin",
        ]);
    }

    public function view($code)
    {
        $pastebinModel=new PastebinModel();
        $detail=$pastebinModel->detail($code);
        return view('pastebin.view', [
            'page_title' => "详情",
            'site_title' => "PasteBin",
            'navigation' => "Pastebin",
            'result' => $detail
        ]);
    }
}
