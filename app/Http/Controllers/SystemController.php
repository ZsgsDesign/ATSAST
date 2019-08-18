<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    public function logs(Request $request)
    {
        return view('system.logs', [
            'page_title'=>"版本日志",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"System",
        ]);
    }
}
