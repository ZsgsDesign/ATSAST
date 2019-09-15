<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eloquents\Reimbursement;
use Auth;

class FinanceController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $list = Reimbursement::where('user_id',$user_id)
        ->select('id','title','money','status','created_at')
        ->orderBy('updated_at','desc')
        ->orderBy('status','desc')
        ->paginate(15);
        return view('finance.index',[
            'page_title'=>"报销",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Finance",
            'list'      =>$list
        ]);
    }

    public function details($id)
    {
        $r = Reimbursement::find($id);
        if(empty($r)){
            return redirect('/finance');
        }
        return view('finance.details',[
            'page_title'=>"报销",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Finance",
            'id'        =>$id,
            'status'    =>$r->status
        ]);
    }

    public function initiate()
    {
        return view('finance.initiate',[
            'page_title'=>"报销",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Finance"
        ]);
    }

    public function edit($id)
    {
        $r = Reimbursement::find($id);
        if(empty($r)){
            return redirect('/finance');
        }
        if($r->status != 0 && $r->status != 1){
            return redirect('/finance/details/'.$id);
        }
        return view('finance.edit',[
            'page_title'=>"报销",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Finance",
            'id'=>$id
        ]);
    }

}
