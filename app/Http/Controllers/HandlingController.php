<?php

namespace App\Http\Controllers;

use App\Models\ItemModel;
use Illuminate\Http\Request;

class HandlingController extends Controller
{
    public function index(){
        $itemModel = new ItemModel();
        $items = $itemModel->getItems();

        return view('handling.index',[
            'page_title'=>"借还",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Handling",
            'items'=>$items,
        ]);
    }

    public function publish(){
        return view('handling.publish',[
            'page_title'=>"发布物品",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Handling"
        ]);
    }

    public function cart(){
        return view('handling.cart',[
            'page_title'=>"购物车",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Handling"
        ]);
    }

    public function detail($itemId){
        return view('handling.detail',[
            'page_title'=>"物品详情",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Handling"
        ]);
    }

    public function order(){
        return view('handling.order',[
            'page_title'=>"我的订单",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Handling"
        ]);
    }

    public function orderCreate(){
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
