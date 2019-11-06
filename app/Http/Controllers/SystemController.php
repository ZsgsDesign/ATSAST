<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Auth;

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

    public function bugs(Request $request)
    {
        if(!Auth::Check()){
            return redirect(request()->ATSAST_DOMAIN.route('login',null,false));;
        }
        return view('system.bugs', [
            'page_title'=>"汇报BUG",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"System",
        ]);
    }
}
