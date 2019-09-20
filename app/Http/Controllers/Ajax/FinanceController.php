<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ResponseModel;
use App\Models\Eloquents\Reimbursement;
use App\Models\Eloquents\Organization;
use App\Models\Eloquents\Department;
use App\Models\Eloquents\ReimbursementLog;
use App\Models\Eloquents\Privilege;

use App\User;
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
            if($declaration->extension() != 'docx'){
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

        //insert log
        $rl = new ReimbursementLog;
        $rl->user_id = $user_id;
        $rl->reimbursement_id = $r_id;
        $rl->opr_type = 0;
        $rl->before_status = -1;
        $rl->save();
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
        $is_admin = !empty(
            Privilege::where([
                'uid'  => $user_id,
                'type' => 'reimbursement',
                'type_value' => $r->organization_id
            ])->where('clearance','>','1')
            ->first()
        );
        //clearance check
        if($user_id != $r->id && !$is_admin) {
            return ResponseModel::err(6009);
        }
        if(!$is_admin && $r->status != 0 && $r->status != 1){
            return ResponseModel::err(6010);
        }
        if($r->status == 2){
            return ResponseModel::err(6011);
        }
        //upload parm check
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
        //save files
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
            if($declaration->extension() != 'docx'){
                return ResponseModel::err(6005);
            }
            $r->declaration = Storage::url($declaration->store('/finance/declaration','public'));
        }

        $before_status = $r->status;
        //update
        $r->user_id           = $user_id;
        $r->organization_id   = $organization->oid;
        $r->department_id     = $department->id;
        $r->title             = $all_data['title'];
        $r->content           = $all_data['content'];
        $r->money             = $all_data['money'];
        $r->status            = 0;
        $r->save();
        //insert log
        $rl = new ReimbursementLog;
        $rl->user_id = $user_id;
        $rl->reimbursement_id = $r->id;
        if($r->user_id == $user_id) {
            $rl->opr_type = 2;
        }else{
            $rl->opr_type = 3;
        }
        $rl->before_status = $before_status;
        $rl->save();
        return ResponseModel::success();
    }

    public function approval(Request $request)
    {
        $request->validate([
            'id'                  => 'required|integer',
            'result'              => 'required|integer',
            'remarks'             => 'required|string',
        ]);
        $all_data = $request->all();
        $r = Reimbursement::find($all_data['id']);
        if(empty($r)){
            return ResponseModel::err(6000);
        }
        if($all_data['result'] != 0 && $all_data['result'] != 1){
            return ResponseModel::err(6006);
        }
        if($r->status != 0){
            return ResponseModel::err(6007);
        }
        $user_id = Auth::user()->id;
        $is_approver = !empty(
            Privilege::where([
                'uid'  => $user_id,
                'type' => 'reimbursement',
                'type_value' => $r->organization_id
            ])->where('clearance','>','0')
            ->first()
        );
        if(!$is_approver){
            return ResponseModel::err(6008);
        }
        //update rbm
        $r->status            = $all_data['result'] ? 3 : 1;
        $r->accepted_at       = date('Y-m-d H:i:s');
        $r->save();
        //insert log
        $rl = new ReimbursementLog;
        $rl->user_id          = $user_id;
        $rl->reimbursement_id = $r->id;
        $rl->opr_type         = 1;
        $rl->before_status    = 0;
        $rl->remarks          = $all_data['remarks'];
        $rl->save();
        return ResponseModel::success();
    }
}
