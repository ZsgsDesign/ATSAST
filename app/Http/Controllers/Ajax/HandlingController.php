<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\ItemModel;
use App\Models\CartModel;
use App\Models\ResponseModel;
use Illuminate\Http\Request;
use Auth;
use Storage;

class HandlingController extends Controller
{
    public function publishItem(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'count' => 'required',
            'dec' => 'required',
            'pic' => 'required|file',
            'location' => 'required',
            'need_return' => 'required',
        ]);

        $pic = $request->file('pic');
        if($pic->isValid() && in_array($pic->extension(),['jpg','jpeg','png'])){
            $url = Storage::url($pic->store('/handling/image','public'));
        }
        if($request->input('count') > 400000){
            return ResponseModel::err(7008);
        }

        $itemModel = new ItemModel;

        $itemModel->name = $request->input('name');
        $itemModel->count = $request->input('count');
        $itemModel->dec = $request->input('dec');
        $itemModel->pic = $url;
        $itemModel->location = $request->input('location');
        $itemModel->need_return = $request->input('need_return')=='on' ? 1 : 0;

        $itemModel->owner = Auth::id();
        $itemModel->scode = 1;
        $itemModel->create_time = date('Y-m-d h:i:s');
        $itemModel->order_count = 0;

        $itemModel->save();

        return ResponseModel::success(200,null,$itemModel->id);
    }

    public function AddToCart(Request $request)
    {
        $request->validate([
            'iid' => 'required|integer',
            'count' => 'required|integer',
        ]);
        $iid = $request->iid;
        $count = $request->count;
        if (!Auth::check()) {
            return ResponseModel::err(2009);
        }

        $cartmodel = new CartModel();
        $itemModel = new ItemModel();
        if(!$itemModel->existIid($iid)){
            return ResponseModel::err(7002);
        }
        $cartmodel->add(Auth::user()->id, $iid, $count);
        return ResponseModel::success();
    }

    public function removeItem(Request $request)
    {
        $request->validate([
            'iid' => 'required|integer',
        ]);
        $iid = $request->iid;
        if(!Auth::check()){
            return ResponseModel::err(2009);
        }
        $itemModel = new ItemModel();
        if(!$itemModel->existIid($iid)){
            return ResponseModel::err(7002);
        }
        $item_info = $itemModel->detail($iid);
        if($item_info->owner!=Auth::user()->id){
            return ResponseModel::err(2003);
        }
        if($item_info->scode==-1){
            return ResponseModel::err(7003);
        }
        $ret = $itemModel->removeItem($iid);
        return ResponseModel::success(200,null,$ret);
    }

    public function restoreItem(Request $request)
    {
        $request->validate([
            'iid' => 'required|integer',
        ]);
        $iid = $request->iid;
        if(!Auth::check()){
            return ResponseModel::err(2009);
        }
        $itemModel = new ItemModel();
        if(!$itemModel->existIid($iid)){
            return ResponseModel::err(7002);
        }
        $item_info = $itemModel->detail($iid);
        if($item_info->owner!=Auth::user()->id){
            return ResponseModel::err(2003);
        }
        if($item_info->scode>=0){
            return ResponseModel::err(7007);
        }
        $ret = $itemModel->restoreItem($iid);
        return ResponseModel::success(200,null,$ret);
    }

    public function deleteFromCart(Request $request)
    {
        $request->validate([
            'iid' => 'required|integer',
        ]);
        $iid = $request->iid;
        if(!Auth::check()){
            return ResponseModel::err(2009);
        }
        $cartmodel = new CartModel();
        if(!$cartmodel->existIid($iid,Auth::user()->id)){
            return ResponseModel::err(7009);
        }
        $ret = $cartmodel->deleteFromCart($iid,Auth::user()->id);
        return ResponseModel::success(200,null,$ret);
    }

    public function operateOrder(Request $request)
    {
        $request->validate([
            'oid' => 'required|integer',
            'operation' => 'required|string',
        ]);
    }
}
