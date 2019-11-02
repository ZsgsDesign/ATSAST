<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContestModel;
use App\Models\Eloquents\Contest;
use Illuminate\Http\Request;

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
            return Redirect::route('contest');
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
        $contestmodel = new ContestModel();
        if(!$contestmodel->existCid($cid)){
            return Redirect::route('contest');
        }
        $ret = $contestmodel->register($cid);
        if(!$ret){
            return Redirect::route('contest');
        }
        $coid=$ret['coid'];
        $basic_info=$ret['basic_info'];
        $contest_name=$ret['contest_name'];
        $minp=$ret['minp'];
        $maxp=$ret['maxp'];
        $group_name=$ret['group_name'];
        $fields=$ret['fields'];
        $members=$ret['members'];
        $registered=$ret['registered'];
        $isleader=$ret['isleader'];
        return view('contests.register', [
            'page_title'=>"活动报名",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Contests",
            'coid'=>$coid,
            'basic_info'=>$basic_info,
            'contest_name'=>$contest_name,
            'minp'=>$minp,
            'maxp'=>$maxp,
            'group_name'=>$group_name,
            'fields'=>$fields,
            'members'=>$members,
            'registered'=>$registered,
            'isleader'=>$isleader,
        ]);
    }
}
