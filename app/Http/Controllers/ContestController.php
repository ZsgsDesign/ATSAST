<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContestModel;
use App\Models\Eloquents\Contest;
use Illuminate\Http\Request;
use Auth;

class ContestController extends Controller
{
    public function index()
    {
        $contests = Contest::with('organization')->orderBy('contest_id','DESC')->paginate(8);
        return view('contests.index', [
            'page_title' => "活动",
            'site_title' => "SAST教学辅助平台",
            'navigation' => "Contests",
            'contests'   => $contests,
        ]);
    }

    public function detail(Request $request)
    {
        $cid = $request->cid;
        $contest = Contest::with('details')->find($cid);
        if(empty($contest)){
            return redirect($request->ATSAST_DOMAIN.'/contest');
        }
        $details = $contest->details()->where('status',1)->get();
        return view('contests.detail', [
            'page_title' => "活动详情",
            'site_title' => "SAST教学辅助平台",
            'navigation' => "Contests",
            'contest'    => $contest,
            'details'    => $details
        ]);
    }

    public function register(Request $request)
    {
        $cid = $request->cid;
        if(!Auth::check()){
            return redirect($request->ATSAST_DOMAIN.'/login');
        }
        $user_id = Auth::user()->id;
        $contest = Contest::find($cid);
        if(empty($contest)){
            return redirect($request->ATSAST_DOMAIN.'/contest');
        }
        $contest_register = $contest->userRegister($user_id);
        return view('contests.register', [
            'page_title'       => "活动报名",
            'site_title'       => "SAST教学辅助平台",
            'navigation'       => "Contests",
            'contest'          => $contest,
            'members'          => empty($contest_register) ? $contest->userEmptyMembers($user_id)
                                                           : $contest_register->members,
            'fields'           => $contest->fields,
            'contest_register' => $contest_register
        ]);
    }
}
