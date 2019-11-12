<?php

namespace App\Http\Controllers\Contest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManageController extends Controller
{
    public function index()
    {
        return view('contests.manage.index', [
            'page_title'       => "活动管理",
            'site_title'       => "SAST教学辅助平台",
            'navigation'       => "Contests",
        ]);
    }

    public function detail()
    {

    }

    public function edit()
    {

    }

    public function export()
    {

    }
}
