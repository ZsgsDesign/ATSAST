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
            return ResponseModel::success(200, null, 0);
        }
        $signed = $request->input('signed');
        $cid = $request->input('cid');
        $syid = $request->input('syid');
        $coursemodel = new CourseModel();
        $ret = $coursemodel->updateSignStatus($signed, $cid, $syid, Auth::user()->id);
        return ResponseModel::success(200, null, $ret);
    }
}
