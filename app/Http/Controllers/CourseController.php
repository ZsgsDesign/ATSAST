<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CourseModel;
use Illuminate\Http\Request;

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
}
