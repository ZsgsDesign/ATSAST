<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\ResponseModel;
use App\Models\CourseModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Auth;

class CourseController extends Controller
{
    public function sign(Request $request)
    {
        $request->validate([
            'signed' => 'required',
            'cid' => 'required',
            'syid' => 'required',
        ]);
        if(!Auth::check()){
            return ResponseModel::err(2001);
        }
        $signed = $request->input('signed');
        $cid = $request->input('cid');
        $syid = $request->input('syid');
        $coursemodel = new CourseModel();
        $ret = $coursemodel->updateSignStatus($signed, $cid, $syid, Auth::user()->id);
        return ResponseModel::success(200, null, $ret);
    }

    public function submitFeedBack(Request $request)
    {
        $request->validate([
            'cid'=>'required',
            'syid'=>'required',
            'rank'=>'required',
            'desc'=>'required',
        ]);
        if(!Auth::check()){
            return ResponseModel::err(2001);
        }
        $rank = $request->input('rank');
        if($rank!=0 && $rank!=1){
            return ResponseModel::err(1004);
        }
        $coursemodel = new CourseModel();
        $cid = $request->input('cid');
        if(!$coursemodel->isRegister($cid, Auth::user()->id)){
            return ResponseModel::err(3001);
        }
        $syid = $request->input('syid');
        $desc = $request->input('desc');
        $ret = $coursemodel->submitFeedBack($cid, $syid, $rank, $desc, Auth::user()->id);
        return ResponseModel::success(200, null, $ret);
    }
}
