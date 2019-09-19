<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\ItemModel;
use App\Models\CartModel;
use App\Models\ResponseModel;
use Illuminate\Http\Request;
use Auth;

class HandlingController extends Controller
{
    public function publishItem(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'need_return' => 'required',
            'location' => 'required',
            'count' => 'required',
            'pic' => 'required'
        ]);

        $itemModel = new ItemModel;

        $itemModel->name = $request->input('name');
        $itemModel->need_return = $request->input('need_return');
        $itemModel->location = $request->input('location');
        $itemModel->count = $request->input('count');
        $itemModel->pic = $request->file('pic')->store('handling_item_images');
        $itemModel->owner = Auth::id();

        $itemModel->save();

        return ResponseModel::success();
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
}
