<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
}
