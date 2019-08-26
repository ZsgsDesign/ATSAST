<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\ItemModel;
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
}
