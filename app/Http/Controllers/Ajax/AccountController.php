<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\ResponseModel;
use App\Models\AccountModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Auth;

class AccountController extends Controller
{
    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required',
        ]);
        $email = $request->input('email');
        $old_password = $request->input('old_password');
        $new_password = $request->input('new_password');
        $confirm_password = $request->input('confirm_password');
        $accountmodel = new AccountModel();
        if($new_password != $confirm_password){
            return ResponseModel::err(2011);
        }
        if(strlen($new_password) < 8){
            return ResponseModel::err(2012);
        }
        if(md5($old_password)!=$accountmodel->getPassword($email)){
            return ResponseModel::err(2009);
        }
        $accountmodel->updatePassword($email, $new_password);
        return ResponseModel::success();
    }
}
