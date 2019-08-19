<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CourseModel;
use Illuminate\Http\Request;
use Auth;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $coursemodel = new CourseModel();
        $ret = $coursemodel->list();
        $list = $ret['list'];
        $paginator = $ret['paginator'];
        return view('courses.index', [
            'page_title'=>"课程",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Courses",
            'result'=>$list,
            'paginator'=>$paginator,
        ]);
    }

    public function detail(Request $request)
    {
        $cid = $request->cid;
        $coursemodel = new CourseModel();
        $ret = $coursemodel->detail($cid);
        $creator = $ret['creator'];
        $detail = $ret['detail'];
        $result = $ret['result'];
        $register_status = $ret['register_status'];
        $instructor = $ret['instructor'];
        $syllabus = $ret['syllabus'];
        return view('courses.detail', [
            'page_title'=>"课程",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Courses",
            'creator'=>$creator,
            'detail'=>$detail,
            'result'=>$result,
            'register_status'=>$register_status,
            'cid'=>$cid,
            'instructor'=>$instructor,
            'syllabus'=>$syllabus,
        ]);
    }

    public function sign(Request $request)
    {
        if(!Auth::Check()){
            return Redirect::route('course');
        }
        $cid = $request->cid;
        $syid = $request->syid;
        $coursemodel = new CourseModel();
        $sign_status = $coursemodel->signStatus($cid,$syid,Auth::user()->id);
        $syllabus = $coursemodel->syllabusInfo($cid,$syid);
        return view('courses.sign', [
            'page_title'=>"课程",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Courses",
            'cid'=>$cid,
            'sign_status'=>$sign_status,
            'syllabus'=>$syllabus,
        ]);
    }
}
