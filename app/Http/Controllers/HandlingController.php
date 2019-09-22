<?php

namespace App\Http\Controllers;

use App\Models\CartModel;
use App\Models\ItemModel;
use Illuminate\Http\Request;
use Auth;

class HandlingController extends Controller
{
    public function index(){
        $itemModel = new ItemModel();
        $items = $itemModel->getItems();
        $paginator = $items['paginator'];
        $list = $items['list'];
        return view('handling.index',[
            'page_title'=>"借还",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Handling",
            'paginator'=>$paginator,
            'list'=>$list,
        ]);
    }

    public function publish(){
        if(!Auth::user()->vip){
            return redirect(route('handling.index'));
        }
        return view('handling.publish',[
            'page_title'=>"发布物品",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Handling"
        ]);
    }

    public function cart(){
        $cartmodel = new CartModel();
        $cart_items = $cartmodel->list(Auth::user()->id);
        return view('handling.cart',[
            'page_title'=>"购物车",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Handling",
            'cart_items'=>$cart_items
        ]);
    }

    public function detail($itemId){
        $itemModel = new ItemModel();
        $item_info = $itemModel->detail($itemId);
        if(empty($item_info)) return redirect(route('handling.index'));
        return view('handling.detail',[
            'page_title'=>"物品详情",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Handling",
            'item_info'=>$item_info
        ]);
    }

    public function order(){
        return view('handling.order',[
            'page_title'=>"我的订单",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Handling"
        ]);
    }

    public function orderCreate(Request $request){
        dd($request->iid);
        return view('handling.order_create',[
            'page_title'=>"创建订单",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Handling"
        ]);
    }

    public function orderDetail($orderId){
        return view('handling.order_detail',[
            'page_title'=>"订单详情",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Handling"
        ]);
    }
}
