<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessContestRegistersExport;
use App\Models\Eloquents\Contest;
use App\Models\Eloquents\ContestRequireInfo;
use App\Models\ResponseModel;
use Storage;

class ContestController extends Controller
{
    public function register(Request $request)
    {
        if (!$request->has('contest_id')) {
            return ResponseModel::err(1003);
        }
        if (!Auth::check()) {
            return ResponseModel::err(2001);
        }
        $uid=Auth::user()->id;
        $coid=$request->contest_id;
        $datas=[];
        $result=DB::table('contest_require_info')->get()->all();
        foreach($result as &$c) $c = (array)$c;
        $types=array("contest_id"=>"number");
        $contest=(array)DB::table('contest')->where('contest_id',$coid)->first();
        if (empty($contest)) {
            return ResponseModel::err(1004);
        }
        $fields=array();
        $requires=array();
        $defaultStatus=$contest['default_register_status'];
        foreach (explode(',', $contest['require_register']) as $require) {
            if (substr($require, 0, 1) == '*') {
                $foo=substr($require, 1);
                array_push($fields, $foo);
                array_push($requires, $foo);
            } else {
                array_push($fields, $require);
            }
        }
        foreach ($result as $type) {
            $types[$type['name']]=$type['type'];
        }
        $minp=$contest['min_participants'];
        $maxp=$contest['max_participants'];
        if ($maxp>1) {
            if (empty($request->group_name)) {
                return ResponseModel::err(4004);
            }
            $result=(array)DB::table('contest_register')
                ->where('contest_id',$coid)
                ->where('info','like','%"team_name":"'.$request->group_name.'"%')
                ->where('uid','<>',$uid)
                ->first();
            if (!empty($result)) {
                return ResponseModel::err(4002);
            }
        }
        $inserts=array();
        for ($i=0; $i<$maxp; ++$i) {
            if ($i>=$minp) {
                $empty=true;
                if (!isset($_POST[$i])) {
                    continue;
                }
                foreach ($fields as $field) {
                    if (!empty($_POST[$i][$field])) {
                        $empty=false;
                        break;
                    }
                }
                if ($empty) {
                    continue;
                }
            }
            foreach ($requires as $field) {
                if (empty($_POST[$i][$field])) {
                    return ResponseModel::err(4004);
                }
            }
            $foo=array();
            foreach ($fields as $field) {
                if (!empty($_POST[$i][$field])) {
                    $foo[$field]=$_POST[$i][$field];
                    if ($types[$field]=='number') {
                        if (!preg_match('/^\d+$/', $foo[$field])) {
                            return ResponseModel::err(4005);
                        }
                    } elseif ($types[$field]=='email') {
                        if (!preg_match('/^[A-Za-z\d]+([-_.][A-Za-z\d]+)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,4}$/', $foo[$field])) {
                            return ResponseModel::err(4006);
                        }
                    }
                }
            }
            if ($i==0) {
                $result=(array)DB::table('users')->where('id',$uid)->first();
                $foo['SID']=$result['SID'];
                foreach ($fields as $field) {
                    if (!empty($foo[$field])) {
                        $result=(array)DB::table('user_temp_info')->where([
                            'uid' => $uid,
                            'key' => $field
                        ])->first();
                        if (empty($result)) {
                            DB::table('user_temp_info')->insert([
                                "uid"=>$uid,
                                "key"=>$field,
                                "value"=>$foo[$field],
                            ]);
                        } else {
                            DB::table('user_temp_info')->where([
                                'uid' => $uid,
                                'key' => $field
                            ])
                            ->update([
                                "value"=>$foo[$field],
                            ]);
                        }
                    }
                }
            } else {
                foreach ($inserts as $insert) {
                    if ($foo['SID']==$insert['SID']) {
                        return ResponseModel::err(4003);
                    }
                }
            }
            $result=(array)DB::table('contest_register')->where('contest_id',$coid)
                ->where('info','like','%"SID":"'.$foo['SID'].'"%')
                ->where('uid','<>',$uid)
                ->first();
            if (!empty($result)) {
                return ResponseModel::err(4003);
            }
            array_push($inserts, $foo);
        }
        $datas=array();
        if ($maxp>1) {
            $datas['team_name']=$request->group_name;
        }
        $datas['members']=$inserts;
        $result=(array)DB::table('contest_register')->where([
                'uid' => $uid,
                'contest_id' => $coid
            ])->first();
        if (empty($result)) {
            DB::table('contest_register')->insert([
                "uid"=>$uid,
                "contest_id"=>$coid,
                "info"=>json_encode($datas),
                "status"=>$defaultStatus,
                "register_time"=>date("Y-m-d H:i:s"),
            ]);
            return ResponseModel::success(200,'成功',request()->ATSAST_DOMAIN.route('contest.index',[],false));
        }
        DB::table('contest_register')->where([
            'uid' => $uid,
            'contest_id' => $coid,
        ])->update([
            "info"=>json_encode($datas),
            "status"=>$defaultStatus,
            "register_time"=>date("Y-m-d H:i:s"),
        ]);
        return ResponseModel::success(200,'成功',request()->ATSAST_DOMAIN.route('contest.index',[],false));
    }

    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|string',
            'due_register' => 'required|string',
            'image' => 'required|file',
            'desc' => 'required|string',
            'minp' => 'required|integer',
            'maxp' => 'required|integer',
            'register_info' => 'required|string',
            'tips' => 'required|string',
            'type' => 'required|integer',
        ]);
        try{
            $start = strtotime($request->start_date);
            $end = strtotime($request->end_date);
            if($start > $end) {
                return ResponseModel::err(4007);
            }
            $start_date = date('Y-m-d',$start);
            $end_date = date('Y-m-d',$end);
            $due_register = date('Y-m-d h:i:s',strtotime($request->due_register));
        }catch(\Throwable $e){
            return ResponseModel::err(1004,$e->getMessage());
        }

        if($request->minp > $request->maxp) {
            return ResponseModel::err(4008);
        }

        $register_infos = explode(',',$request->register_info);
        $ris = [];
        foreach($register_infos as $register_info){
            if(substr($register_info,0,1) == '*') {
                $cri = ContestRequireInfo::where('name',substr($register_info,1))->first();
            }else{
                $cri = ContestRequireInfo::where('name',$register_info)->first();
            }
            if(empty($cri)) {
                return ResponseModel::err(4009);
            }
            $ris[] = $cri->name;
        }
        if(count($ris) != count(array_unique($ris))){
            return ResponseModel::err(4010);
        }

        $allow_extension = ['png','jpg','jpeg','bmp','gif'];
        if(!in_array($request->image->extension(),$allow_extension)){
            return ResponseModel::err(1005);
        }
        $image_path = Storage::url($request->image->store('/contest/image','public'));

        $contest = Contest::create([
            'name'    => $request->name,
            'creator' => $request->organization->oid,
            'desc' => $request->desc,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'due_register' => $due_register,
            'type' => boolval($request->type),
            'require_register' => $request->register_info,
            'image' => $image_path,
            'min_participants' => $request->minp,
            'max_participants' => $request->maxp,
            'status' => 1,
            'tips' => $request->tips
        ]);
        $contest->details()->create([
            'type' => 0,
            'content' => $request->desc,
            'status' => 1
        ]);
        return ResponseModel::success();
    }

    public function queryExport(Request $request)
    {
        $contest = $request->contest;
        $xlsx = $contest->xlsx;
        if(empty($xlsx)){
            return ResponseModel::success(200,null,[
                'status'    => 0,
                'url'       => null,
                'last_time' => null
            ]);
        }else{
            return ResponseModel::success(200,null,[
                'status'    => 1,
                'url'       => $request->ATSAST_DOMAIN.$xlsx,
                'last_time' => $contest->xlsx_time
            ]);
        }
    }

    public function requestExport(Request $request)
    {
        $contest = $request->contest;
        if(!empty($contest->xlsx)){
            Storage::disk('public')->delete(substr($contest->xlsx,8));
        }
        $contest->xlsx      = null;
        $contest->xlsx_time = null;
        $contest->save();

        ProcessContestRegistersExport::dispatch($contest)->onQueue('default');
        return ResponseModel::success(200,'已收到请求，xlsx表格文件将会在一分钟内为您生成(如果服务器够顶的话)');
    }
}
