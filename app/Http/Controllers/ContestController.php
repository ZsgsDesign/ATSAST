<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContestModel;
use Illuminate\Http\Request;

class ContestController extends Controller
{
    public function index(Request $request)
    {
        $contestmodel = new ContestModel();
        $ret = $contestmodel->list();
        $list = $ret['list'];
        $paginator = $ret['paginator'];
        return view('contests.index', [
            'page_title'=>"活动",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Contests",
            'result'=>$list,
            'paginator'=>$paginator,
        ]);
    }
}
