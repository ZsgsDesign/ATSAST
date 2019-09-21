<?php

namespace App\Http\Controllers;

use App\Models\Eloquents\Privilege;
use Illuminate\Http\Request;
use App\Models\Eloquents\Reimbursement;
use Auth;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->all();
        $user_id = Auth::user()->id;
        $is_approver = !empty(
            Privilege::where([
                'uid'  => $user_id,
                'type' => 'reimbursement'
            ])->where('clearance','>','0')
            ->first()
        );
        if(isset($filter['approval']) && $filter['approval'] && $is_approver){
            $organizations = Privilege::where([
                    'uid'  => $user_id,
                    'type' => 'reimbursement'
                ])
                ->where('clearance','>','0')
                ->pluck('type_value');
            $list = Reimbursement::whereIn('organization_id',$organizations);
        }else{
            $list = Reimbursement::where('user_id',$user_id);
        }
        //filter
        if(isset($filter['hide_waiting']) && $filter['hide_waiting']) {
            $list = $list->where('status','<>','0');
        }
        if(isset($filter['hide_back']) && $filter['hide_back']) {
            $list = $list->where('status','<>','1');
        }
        if(isset($filter['hide_pass']) && $filter['hide_pass']) {
            $list = $list->where('status','<>','3');
        }
        if(isset($filter['hide_hang']) && $filter['hide_hang']) {
            $list = $list->where('status','<>','2');
        }

        //order
        $orderBy = [
            'status'        => '状态',
            'money'         => '金额',
            'department_id' => '部门',
            'created_at'    => '申报时间',
            'updated_at'    => '改动时间',
            'accepted_at'   => '通过时间',
        ];
        $order = [
            'desc'  => '<i class="MDI chevron-down"></i>',
            'asc'   => '<i class="MDI chevron-up"></i>'
        ];
        if(isset($filter['orderBy']) && in_array($filter['orderBy'],['status', 'money', 'department_id', 'created_at', 'updated_at', 'accepted_at'])) {
            if(isset($filter['order']) && $filter['order'] == 'desc') {
                $list = $list->orderBy($filter['orderBy'],'desc');
            }else{
                $list = $list->orderBy($filter['orderBy'],'asc');
            }
        }
        $list = $list->paginate(15);
        return view('finance.index',[
            'page_title' => "报销",
            'site_title' => "SAST教学辅助平台",
            'navigation' => "Finance",
            'list'       => $list,
            'filter'     => $filter,
            'orderBy'    => $orderBy,
            'order'      => $order,
            'is_approver'=> $is_approver
        ]);
    }

    public function details($id)
    {
        $user_id = Auth::user()->id;
        $r = Reimbursement::find($id);
        if(empty($r)){
            return redirect('/finance');
        }
        $l = $r->logs;
        $is_approver = !empty(
            Privilege::where([
                'uid'  => $user_id,
                'type' => 'reimbursement',
                'type_value' => $r->organization_id
            ])->where('clearance','>','0')
            ->first()
        );
        if($r->user_id!=$user_id && !$is_approver){
            return redirect('/finance');
        }
        $is_admin = !empty(
            Privilege::where([
                'uid'  => $user_id,
                'type' => 'reimbursement',
                'type_value' => $r->organization_id
            ])->where('clearance','>','1')
            ->first()
        );
        $opr_type = [
            0 => '发起',
            1 => '审批',
            2 => '修改',
            3 => '管理员修改',
            4 => '挂起',
            5 => '解除挂起'
        ];
        $status = [
            -1 => '未创建',
            0 => '待审批',
            1 => '被驳回',
            2 => '被挂起',
            3 => '已通过'
        ];
        return view('finance.details',[
            'page_title'   =>"报销",
            'site_title'   =>"SAST教学辅助平台",
            'navigation'   =>"Finance",
            'id'           =>$id,
            'status'       =>$r->status,
            'status_parse' =>$status,
            'logs'         =>$l,
            'opr_type'     =>$opr_type,
            'is_approver'  =>$is_approver,
            'is_admin'     =>$is_admin
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
        $user_id = Auth::user()->id;
        $is_approver = !empty(
            Privilege::where([
                'uid'  => $user_id,
                'type' => 'reimbursement',
                'type_value' => $r->organization_id
            ])->where('clearance','>','0')
            ->first()
        );
        if($r->status != 0 && $r->status != 1){
            return redirect('/finance/details/'.$id);
        }
        if($r->user_id!=$user_id && !$is_approver){
            return redirect('/finance');
        }
        return view('finance.edit',[
            'page_title'=>"报销",
            'site_title'=>"SAST教学辅助平台",
            'navigation'=>"Finance",
            'id'=>$id
        ]);
    }

}
