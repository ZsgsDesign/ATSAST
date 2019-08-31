<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ResponseModel;
use App\Models\Eloquents\Reimbursement;
use App\Models\Eloquents\Organization;
use App\Models\Eloquents\Department;
use Auth;
use Storage;

class FinanceController extends Controller
{
    public function initiate(Request $request)
    {
        $request->validate([
            'title'               => 'required|string',
            'content'             => 'required|string',
            'money'               => 'required|integer|min:0|max:999',
            'organization'        => 'required|string',
            'department'          => 'required|string',
            'invoice'             => 'file',
            'transaction_voucher' => 'file',
            'declaration'         => 'file',
        ]);

        $user_id             = Auth::user()->id;
        $all_data            = $request->all();
        $invoice             = $request->file('invoice');
        $transaction_voucher = $request->file('transaction_voucher');
        $declaration         = $request->file('declaration');

        if($all_data['money'] >= 200 && (empty($transaction_voucher) || !$transaction_voucher->isValid())){
            return ResponseModel::err(6001);
        }
        if($all_data['money'] >= 500 && (empty($declaration) || !$declaration->isValid())){
            return ResponseModel::err(6002);
        }
        $organization = Organization::where('name',$all_data['organization'])->first();
        if(empty($organization)){
            return ResponseModel::err(5001);
        }
        $department   = Department::where('name',$all_data['department'])->first();
        if(empty($department)){
            return ResponseModel::err(5002);
        }
        if(!$organization->hasDepartment($department->id)){
            return ResponseModel::err(5003);
        }

        $r = new Reimbursement;

        if(!empty($invoice)){
            if($invoice->extension() != 'pdf'){
                return ResponseModel::err(6003);
            }
            $r->invoice = Storage::url($invoice->store('/finance/invoice','public'));
        }
        if(!empty($transaction_voucher)){
            if($transaction_voucher->extension() != 'jpg' && $transaction_voucher->extension() != 'jpeg' && $transaction_voucher->extension() != 'png'){
                return ResponseModel::err(6004);
            }
            $r->transaction_voucher = Storage::url($transaction_voucher->store('/finance/transaction_voucher','public'));
        }
        if(!empty($declaration)){
            if($declaration->extension() != 'pdf'){
                return ResponseModel::err(6005);
            }
            $r->declaration = Storage::url($declaration->store('/finance/declaration','public'));
        }
        $r->user_id           = $user_id;
        $r->organization_id   = $organization->oid;
        $r->department_id     = $department->id;
        $r->title             = $all_data['title'];
        $r->content           = $all_data['content'];
        $r->money             = $all_data['money'];

        $r->status            = 0;
        $r_id = $r->save();

        return ResponseModel::success(200,null,[
            'id' => $r_id
        ]);
    }

    public function details(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);
        $result = Reimbursement::details($request->input('id'));
        if(empty($result)){
            return ResponseModel::err(6000);
        }
        return ResponseModel::success(200,'Successful!',$result);
    }

    public function edit(Request $request)
    {
        $request->validate([
            'id'                  => 'required|integer',
            'title'               => 'required|string',
            'content'             => 'required|string',
            'money'               => 'required|integer|min:0|max:999',
            'organization'        => 'required|string',
            'department'          => 'required|string',
            'invoice'             => 'file',
            'transaction_voucher' => 'file',
            'declaration'         => 'file',
        ]);

        $r_id                = $request->input('id');
        $r                   = Reimbursement::find($r_id);
        if(empty($r)){
            return ResponseModel::err(6000);
        }

        $user_id             = Auth::user()->id;
        $all_data            = $request->all();
        $invoice             = $request->file('invoice');
        $transaction_voucher = $request->file('transaction_voucher');
        $declaration         = $request->file('declaration');

        if($all_data['money'] >= 200 && (empty($transaction_voucher) || !$transaction_voucher->isValid())){
            return ResponseModel::err(6001);
        }
        if($all_data['money'] >= 500 && (empty($declaration) || !$declaration->isValid())){
            return ResponseModel::err(6002);
        }
        $organization = Organization::where('name',$all_data['organization'])->first();
        if(empty($organization)){
            return ResponseModel::err(5001);
        }
        $department   = Department::where('name',$all_data['department'])->first();
        if(empty($department)){
            return ResponseModel::err(5002);
        }
        if(!$organization->hasDepartment($department->id)){
            return ResponseModel::err(5003);
        }
        if(!empty($invoice)){
            if($invoice->extension() != 'pdf'){
                return ResponseModel::err(6003);
            }
            $r->invoice = Storage::url($invoice->store('/finance/invoice','public'));
        }
        if(!empty($transaction_voucher)){
            if($transaction_voucher->extension() != 'jpg' && $transaction_voucher->extension() != 'jpeg' && $transaction_voucher->extension() != 'png'){
                return ResponseModel::err(6004);
            }
            $r->transaction_voucher = Storage::url($transaction_voucher->store('/finance/transaction_voucher','public'));
        }
        if(!empty($declaration)){
            if($declaration->extension() != 'pdf'){
                return ResponseModel::err(6005);
            }
            $r->declaration = Storage::url($declaration->store('/finance/declaration','public'));
        }
        $r->user_id           = $user_id;
        $r->organization_id   = $organization->oid;
        $r->department_id     = $department->id;
        $r->title             = $all_data['title'];
        $r->content           = $all_data['content'];
        $r->money             = $all_data['money'];

        $r->status            = 0;
        $r->save();

        return ResponseModel::success();
    }
}
