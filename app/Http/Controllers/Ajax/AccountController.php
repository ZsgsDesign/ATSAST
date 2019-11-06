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
        if(md5($old_password)!=$accountmodel->getPassword($email)){
            return ResponseModel::err(2009);
        }
        if($new_password != $confirm_password){
            return ResponseModel::err(2011);
        }
        if(strlen($new_password) < 8){
            return ResponseModel::err(2012);
        }
        $accountmodel->updatePassword($email, $new_password);
        return ResponseModel::success();
    }

    public function updateInfo(Request $request)
    {
        $request->validate([
            'real_name' => 'required|string',
            'name' => 'required|string',
            'gender' => 'required',
            'SID' => 'required|string'
        ]);
        $real_name = $request->input('real_name');
        $name = $request->input('name');
        $gender = $request->input('gender');
        $avatar = $request->file('avatar');
        $SID = $request->SID;
        if($avatar && $avatar->isValid() && in_array($avatar->extension(),['jpg','jpeg','png'])){
            $url = Storage::url($avatar->store('/avatar','public'));
        }else{
            $url = null;
        }
        $accountmodel = new AccountModel();
        $ret = $accountmodel->updateInfo($real_name,$name,$gender,$url,$SID,Auth::user()->id);
        return ResponseModel::success();
    }

    public function sendActivateEmail(Request $request)
    {
        // TODO
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required',
        ]);
        $old_password = $request->input('old_password');
        $new_password = $request->input('new_password');
        $confirm_password = $request->input('confirm_password');
        $accountmodel = new AccountModel();
        if(md5($old_password)!=$accountmodel->getPasswordbyUid(Auth::user()->id)){
            return ResponseModel::err(2009);
        }
        if($new_password != $confirm_password){
            return ResponseModel::err(2011);
        }
        if(strlen($new_password) < 8){
            return ResponseModel::err(2012);
        }
        $accountmodel->changePassword(Auth::user()->id, $new_password);
        return ResponseModel::success();
    }

    public function applyAlbum(Request $request)
    {
        $request->validate([
            'album' => 'required',
        ]);
        $album = $request->input('album');
        $accountmodel = new AccountModel();
        $accountmodel->applyAlbum(Auth::user()->id,$album);
        return ResponseModel::success();
    }
}
