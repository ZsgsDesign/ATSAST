<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HandlingController extends Controller
{
    public function index(){
        return view('handling.index',[
            'page_title'=>"借还",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Handling"
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

    public function order($orderId){
        return view('handling.order',[
            'page_title'=>"我的订单",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Handling"
        ]);
    }
}
