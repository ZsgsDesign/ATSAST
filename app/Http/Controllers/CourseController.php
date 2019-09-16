<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
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
        if(!$coursemodel->existCid($cid)){
            return Redirect::route('course');
        }
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
        $cid = $request->cid;
        $syid = $request->syid;
        $coursemodel = new CourseModel();
        if(!Auth::Check() || !$coursemodel->existCid($cid) || !$coursemodel->existSyid($cid,$syid)){
            return Redirect::route('course');
        }
        $sign_status = $coursemodel->signStatus($cid,$syid,Auth::user()->id);
        $syllabus = $coursemodel->syllabusInfo($cid,$syid);
        return view('courses.sign', [
            'page_title'=>"课程",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Courses",
            'cid'=>$cid,
            'syid'=>$syid,
            'sign_status'=>$sign_status,
            'syllabus'=>$syllabus,
        ]);
    }

    public function register(Request $request)
    {
        $cid = $request->cid;
        $coursemodel = new CourseModel();
        if(!Auth::Check() || !$coursemodel->existCid($cid)){
            return Redirect::route('course');
        }
        $register_status = $coursemodel->registerStatus($cid,Auth::user()->id);
        return view('courses.register', [
            'page_title'=>"课程",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Courses",
            'cid'=>$cid,
            'register_status'=>$register_status,
        ]);
    }

    public function script(Request $request)
    {
        $cid = $request->cid;
        $syid = $request->syid;
        $coursemodel = new CourseModel();
        if(!Auth::Check() || !$coursemodel->existCid($cid) || !$coursemodel->existSyidInScript($cid,$syid)){
            return Redirect::route('course');
        }
        $ret = $coursemodel->script($cid,$syid);
        $result = $ret['result'];
        $script = $ret['script'];
        $title = $ret['title'];
        return view('courses.script', [
            'page_title'=>$title,
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Courses",
            'cid'=>$cid,
            'result'=>$result,
            'script'=>$script,
        ]);
    }
}
