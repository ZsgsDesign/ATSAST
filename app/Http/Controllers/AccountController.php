<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function update(Request $request)
    {
        return view('auth.update', [
            'page_title'=>"更新密码",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Account",
        ]);
    }
}
