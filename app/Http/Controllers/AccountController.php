<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AccountModel;
use Illuminate\Http\Request;
use Auth;

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

    public function profile(Request $request)
    {
        $accountmodel = new AccountModel();
        $ret = $accountmodel->profile(Auth::user()->id);
        $detail = $ret['detail'];
        $result = $ret['result'];
        $contest_result = $ret['contest_result'];
        $imgurl = $ret['imgurl'];
        return view('account.profile', [
            'page_title'=>"用户中心",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Account",
            'detail'=>$detail,
            'result'=>$result,
            'contest_result'=>$contest_result,
            'imgurl'=>$imgurl,
        ]);
    }

    public function settings(Request $request)
    {
        $accountmodel = new AccountModel();
        $detail = $accountmodel->detail(Auth::user()->id);
        return view('account.settings', [
            'page_title'=>"用户设置",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Account",
            'detail'=>$detail,
        ]);
    }
}
