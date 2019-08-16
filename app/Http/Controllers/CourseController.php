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
}
