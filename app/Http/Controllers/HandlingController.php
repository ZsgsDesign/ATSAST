<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaterialHandlingSystemController extends Controller
{
    public function index(){
        return view('handilng.index');
    }

    public function publish(){
        return view('handilng.publish');
    }

    public function cart(){
        return view('handilng.cart');
    }

    public function detail($itemId){
        return view('handilng.detail');
    }

    public function order($orderId){
        return view('handilng.order');
    }
}
