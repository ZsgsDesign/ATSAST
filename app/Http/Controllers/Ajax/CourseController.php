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

    public function addInstructor(Request $request)
    {
        $request->validate([
            'cid' => 'required',
            'email' => 'required'
        ]);
        $cid = $request->input('cid');
        $email = $request->input('email');
        $coursemodel = new CourseModel();
        $ret = $coursemodel->addInstructor($cid,$email);
        if($ret==0){
            return ResponseModel::success(200, "添加讲师成功", $ret);
        }elseif($ret==1){
            return ResponseModel::success(200, "讲师权限提升成功", $ret);
        }else{
            return ResponseModel::err($ret);
        }
    }

    public function removeInstructor(Request $request)
    {
        $request->validate([
            'cid' => 'required',
            'iid' => 'required'
        ]);
        $cid = $request->input('cid');
        $iid = $request->input('iid');
        $coursemodel = new CourseModel();
        $ret = $coursemodel->removeInstructor($cid,$iid);
        if($ret==0){
            return ResponseModel::success(200, "讲师权限撤销成功", $ret);
        }else{
            return ResponseModel::err($ret);
        }
    }

    public function addSyllabusInfo(Request $request)
    {
        $request->validate([
            'cid' => 'required',
            'title' => 'required',
            'desc' => 'required',
            'location' => 'required',
            'time' => 'required',
            'endtime' => 'required'
        ]);
        $cid = $request->input('cid');
        $title = $request->input('title');
        $desc = $request->input('desc');
        $location = $request->input('location');
        $time = $request->input('time');
        $endtime = $request->input('endtime');
        $coursemodel = new CourseModel();
        $ret = $coursemodel->addSyllabusInfo($cid,$title,$desc,$location,$time,$endtime);
        if($ret==0){
            return ResponseModel::success(200, "新建成功", $ret);
        }else{
            return ResponseModel::err($ret);
        }
    }
}
