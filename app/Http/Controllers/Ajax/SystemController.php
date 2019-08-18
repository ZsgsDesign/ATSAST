<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\ResponseModel;
use App\Models\BugModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Auth;

class SystemController extends Controller
{
    public function SubmitBugs(Request $request)
    {
        if (!Auth::check()) {
            return ResponseModel::err(2009);
        }
        $request->validate([
            'title' => 'required|string',
            'desc' => 'required|string'
        ]);
        $data['title'] = $request->title;
        $data['desc'] = $request->desc;
        $data['uid'] = Auth::user()->id;
        $bugmodel = new BugModel();
        $ret = $bugmodel->add($data);
        return ResponseModel::success(200,null,$ret);
    }
}
