<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountModel extends Model
{
    public function getPassword($email)
    {
        return DB::table('users')->where('email','=',$email)->get()->first()->password;
    }

    public function updatePassword($email, $password)
    {
        return DB::table('users')->where('email','=',$email)->update(['password'=>Hash::make($password)]);
    }

    public function profile($uid)
    {
        $detail = DB::table('users')->where('id','=',$uid)->get()->first();
        if (!is_null($detail->real_name) || $detail->real_name==="null") {
            $display=$detail->real_name;
        } else {
            $display=$detail->name;
        }
        $detail->display_name=$display;

        $result = DB::table('course_register as r')
        ->select('r.cid','course_name','course_logo','course_desc','course_color')
        ->leftJoin('courses as c','r.cid','=','c.cid')
        ->where('r.uid','=',$uid)
        ->where('status','=','1')
        ->paginate(2)->all();

        $contest_result = DB::table('contest_register as r')
        ->select('r.contest_id','c.name','creator','desc','type','start_date','end_date','r.status','due_register','image','o.name as creator_name')
        ->leftJoin('contest as c','r.contest_id','=','c.contest_id')
        ->leftJoin('organization as o','c.creator','=','o.oid')
        ->where('uid','=',$uid)
        ->where('c.status','=','1')
        ->paginate(2)->all();
        foreach ($contest_result as &$r) {
            if ($r->start_date==$r->end_date) {
                $r->parse_date=$r->start_date;
            } else {
                $r->parse_date=$r->start_date." ~ ".$r->end_date;
            }
            if ($r->status==1) {
                $r->parse_status='<span class="wemd-green-text"><i class="MDI checkbox-marked-circle-outline"></i> 已成功报名</span>';
            } elseif ($r->status==0) {
                $r->parse_status='<span class="wemd-light-blue-text"><i class="MDI timer-sand"></i> 已提交报名</span>';
            } elseif ($r->status==-1) {
                $r->parse_status='<span class="wemd-red-text"><i class="MDI alert-circle-outline"></i> 报名已被拒绝</span>';
            }
        }

        // $storage=array();
        // $storage["usage"]=getDirSize("/home/wwwroot/main/domain/static.1cf.co/web/img/atsast/upload/{$this->userinfo['uid']}");
        // $storage["usage_string"]=sizeConverter($storage["usage"]);
        // $storage["tot"]=$detail['cloud_size'];
        // $storage["percent"]=$storage["usage"] / ($storage["tot"] * 1024 * 1024) * 100;
        // if ($storage["percent"]>=90) {
        //     $storage["color"]="red";
        // } elseif ($storage["percent"]>=60) {
        //     $storage["color"]="amber";
        // } elseif ($storage["percent"]>=40) {
        //     $storage["color"]="lime";
        // } else {
        //     $storage["color"]="green";
        // }

        if ($detail->album=="bing") {
            $str = file_get_contents('http://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1&mkt=zh-CN');
            $array = json_decode($str);
            $imgurl="https://cn.bing.com/".$array->{"images"}[0]->{"url"};
        } else {
            $imgurl="{$this->ATSAST_CDN}/img/njupt.jpg";
        }

        return [
            'detail'=>$detail,
            'result'=>$result,
            'contest_result'=>$contest_result,
            'imgurl'=>$imgurl,
        ];
    }

    public function detail($uid)
    {
        return DB::table('users')->where('id','=',$uid)->get()->first();
    }

    public function updateInfo($real_name,$name,$gender,$url,$uid)
    {
        if($url){
            return DB::table('users')->where('id','=',$uid)->update(['real_name'=>$real_name,'name'=>$name,'gender'=>$gender,'avatar'=>$url]);
        }else{
            return DB::table('users')->where('id','=',$uid)->update(['real_name'=>$real_name,'name'=>$name,'gender'=>$gender]);
        }
    }

    public function getPasswordbyUid($uid)
    {
        return DB::table('users')->where('id','=',$uid)->get()->first()->password;
    }

    public function changePassword($uid,$password)
    {
        return DB::table('users')->where('id','=',$uid)->update(['password'=>Hash::make($password)]);
    }

    public function applyAlbum($uid,$album)
    {
        return DB::table('users')->where('id','=',$uid)->update(['album'=>$album]);
    }

    public function getRegisterContestResult($uid)
    {
        $ret = DB::table('contest_register as r')
        ->select('r.contest_id','c.name','creator','desc','type','start_date','end_date','r.status','due_register','image','o.name as creator_name')
        ->leftJoin('contest as c','r.contest_id','=','c.contest_id')
        ->leftJoin('organization as o','c.creator','=','o.oid')
        ->where('uid','=',$uid)
        ->where('c.status','=','1')->get();
        foreach ($ret as &$r) {
            if ($r->start_date==$r->end_date) {
                $r->parse_date=$r->start_date;
            } else {
                $r->parse_date=$r->start_date." ~ ".$r->end_date;
            }
            if ($r->status==1) {
                $r->parse_status='<span class="wemd-green-text"><i class="MDI checkbox-marked-circle-outline"></i> 已成功报名</span>';
            } elseif ($r->status==0) {
                $r->parse_status='<span class="wemd-light-blue-text"><i class="MDI timer-sand"></i> 已提交报名</span>';
            } elseif ($r->status==-1) {
                $r->parse_status='<span class="wemd-red-text"><i class="MDI alert-circle-outline"></i> 报名已被拒绝</span>';
            }
        }
        return $ret;
    }

    public function getAttendContestResult($uid)
    {
        $sid = DB::table('users')->where('id','=',$uid)->get()->first()->SID;
        $ret = DB::table('contest_register as r')
        ->select('r.contest_id','c.name','creator','desc','type','start_date','end_date','r.status','due_register','image','o.name as creator_name')
        ->leftJoin('contest as c','r.contest_id','=','c.contest_id')
        ->leftJoin('organization as o','c.creator','=','o.oid')
        ->where('uid','<>',$uid)
        ->where('info','LIKE','%"SID":"'.$sid.'"%')
        ->where('c.status','=','1')->get();
        foreach ($ret as &$r) {
            if ($r->start_date==$r->end_date) {
                $r->parse_date=$r->start_date;
            } else {
                $r->parse_date=$r->start_date." ~ ".$r->end_date;
            }
            if ($r->status==1) {
                $r->parse_status='<span class="wemd-green-text"><i class="MDI checkbox-marked-circle-outline"></i> 已成功报名</span>';
            } elseif ($r->status==0) {
                $r->parse_status='<span class="wemd-light-blue-text"><i class="MDI timer-sand"></i> 已提交报名</span>';
            } elseif ($r->status==-1) {
                $r->parse_status='<span class="wemd-red-text"><i class="MDI alert-circle-outline"></i> 报名已被拒绝</span>';
            }
        }
        return $ret;
    }
}
