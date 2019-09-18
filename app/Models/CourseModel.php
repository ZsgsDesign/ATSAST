<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Cache;
use Storage;
use Auth;

class CourseModel extends Model
{
    public function list()
    {
        $paginator = DB::table('courses')->orderBy('cid', 'desc')->paginate(9);
        $list = $paginator->all();
        return [
            'paginator' => $paginator,
            'list' => $list
        ];
    }

    public function detail($cid)
    {
        $result = DB::table('courses')->where('cid','=',$cid)->get()->first();
        if(empty($result)){
            return null;
        }
        $creator = DB::table('organization')->where('oid','=',$result->course_creator)->first();
        $detail = DB::table('course_details')->where('cid','=',$cid)->get();
        $instructor_info = DB::table('instructor as i')->leftJoin('users as u','i.uid','=','u.id')->where('i.cid','=',$cid)->orderBy('i.iid','asc')->get();
        $result->creator_name = $creator->name;
        $result->creator_logo = $creator->logo;
        if(Auth::check()){
            $syllabus_info = DB::table('syllabus as s')->leftJoin('syllabus_sign as u', function($join){
                $join->on('s.syid','=','u.syid')
                ->where('u.uid','=',Auth::user()->id);
            })->where('s.cid','=',$cid)->select('s.syid','s.cid','title','time','location','desc','signed','signid','script','homework','feedback','video')->orderBy("time",'asc')->get();
        }else{
            $syllabus_info = DB::table('syllabus')->where('cid','=',$cid)->orderBy("time",'asc')->get();
        }
        foreach($syllabus_info as &$s){
            $s->time = date('Y年m月d日 H时i分 开始', strtotime($s->time));
        }
        if(Auth::check()){
            $register_status = DB::table('course_register')->where('cid','=',$cid)->where('uid','=',Auth::user()->id)->get()->first();
        }
        if(empty($register_status)){
            $register_status = 0;
        }else{
            $register_status=$register_status->status;
        }
        $instructor=$instructor_info;
        $syllabus=$syllabus_info;
        return ([
            'creator'=>$creator,
            'detail'=>$detail,
            'result'=>$result,
            'register_status'=>$register_status,
            'instructor'=>$instructor,
            'syllabus'=>$syllabus,
        ]);
    }

    public function signStatus($cid, $syid, $uid)
    {
        $sign_status = DB::table('syllabus_sign')->where('cid','=',$cid)->where('syid','=',$syid)->where('uid','=',$uid)->first();
        if(empty($sign_status)){
            return 0;
        }else{
            return -1;
        }
    }

    public function syllabusInfo($cid, $syid)
    {
        if(Auth::check()){
            $syllabus_info = DB::table('syllabus as s')->leftJoin('syllabus_sign as u', function($join){
                $join->on('s.syid','=','u.syid')
                ->where('u.uid','=',Auth::user()->id);
            })->where('s.cid','=',$cid)->where('s.syid','=',$syid)->select('s.syid','s.cid','title','time','location','desc','signed','signid','script','homework','feedback','video')->orderBy("time",'asc')->get()->first();
        }else{
            $syllabus_info = DB::table('syllabus')->where('cid','=',$cid)->where('s.syid','=',$syid)->orderBy("time",'asc')->get()->first();
        }
        if(isset($syllabus_info)){
            $syllabus_info->time = date('Y年m月d日 H时i分 开始', strtotime($syllabus_info->time));
        }
        return $syllabus_info;
    }

    public function registerStatus($cid, $uid)
    {
        $ret = DB::table('course_register')->where('cid','=',$cid)->where('uid','=',$uid)->get()->first();
        if($ret==null){
            DB::table('course_register')->insertGetId([
                'uid'=>$uid,
                'cid'=>$cid,
                'status'=>1
            ]);
            return 1;
        }
        return 0;
    }

    public function existCid($cid)
    {
        return DB::table('courses')->where('cid','=',$cid)->count();
    }

    public function existSyid($cid, $syid)
    {
        return DB::table('syllabus')->where('cid','=',$cid)->where('syid','=',$syid)->count();
    }

    public function existScid($cid, $scid)
    {
        return DB::table('syllabus_script')->where('cid','=',$cid)->where('scid','=',$scid)->count();
    }

    public function existSyidInScript($cid, $syid)
    {
        return DB::table('syllabus_script')->where('cid','=',$cid)->where('syid','=',$syid)->count();
    }

    public function existFeedback($cid, $syid)
    {
        $ret = DB::table('syllabus')->where('cid','=',$cid)->where('syid','=',$syid)->get()->first();
        return ($ret==null) ? 0 : $ret->feedback;
    }

    public function syidByScid($scid)
    {
        $ret = DB::table('syllabus_script')->where('scid','=',$scid)->get()->first();
        if($ret==null){
            return $ret;
        }else{
            return $ret->syid;
        }
    }

    public function script($cid, $syid)
    {
        $result = DB::table('courses')->where('cid','=',$cid)->get()->first();
        $register_status = DB::table('course_register')->where('cid','=',$cid)->where('uid','=',Auth::user()->id)->get()->first();
        if($register_status==null){
            return null;
        }
        $syllabus_info = DB::table('syllabus')->where('cid','=',$cid)->where('syid','=',$syid)->get()->first();
        if (empty($result) || empty($syllabus_info)) {
            return null;
        }
        if ($syllabus_info->script==0) {
            return null;
        }
        $syllabus_info->time = date('Y年m月d日 H时i分 开始', strtotime($syllabus_info->time));
        $creator = DB::table('organization')->where('oid','=',$result->course_creator)->get()->first();
        $result->creator_name = $creator->name;
        $result->creator_logo = $creator->logo;
        $result2 = DB::table('syllabus_script')->where('cid','=',$cid)->where('syid','=',$syid)->get()->first();
        if(empty($result2)){
            return null;
        }
        $title = $syllabus_info->title;
        $result2->content_slashed = str_replace('\\', '\\\\', $result2->content);
        $result2->content_slashed = str_replace("\r\n", "\\n", $result2->content_slashed);
        $result2->content_slashed = str_replace("\n", "\\n", $result2->content_slashed);
        $result2->content_slashed = str_replace("\"", "\\\"", $result2->content_slashed);
        $result2->content_slashed = str_replace("<", "\<", $result2->content_slashed);
        $result2->content_slashed = str_replace(">", "\>", $result2->content_slashed);
        return ([
            'result'=>$result,
            'script'=>$result2,
            'title'=>$title,
        ]);
    }

    public function updateSignStatus($signed, $cid, $syid, $uid)
    {
        $realSigned = DB::table('syllabus')->where('syid','=',$syid)->get()->first()->signed;
        if($signed != $realSigned){
            return -1;
        }
        $ret = DB::table('syllabus_sign')->where('syid','=',$syid)->where('uid','=',$uid)->get()->first();
        if($ret==null){
            DB::table('syllabus_sign')->insertGetId([
                'cid'=>$cid,
                'syid'=>$syid,
                'uid'=>$uid,
                'stime'=>date('Y-m-d H:i:s',time())
            ]);
            return 1;
        }
        return 0;
    }

    public function feedback($cid, $syid, $uid)
    {
        $result = DB::table('courses')->where('cid','=',$cid)->get()->first();
        $register_status = DB::table('course_register')->where('cid','=',$cid)->where('uid','=',Auth::user()->id)->get()->first();
        if($register_status==null){
            return null;
        }
        $syllabus_info = DB::table('syllabus')->where('cid','=',$cid)->where('syid','=',$syid)->get()->first();
        if (empty($result) || empty($syllabus_info)) {
            return null;
        }
        if ($syllabus_info->script==0) {
            return null;
        }
        $syllabus_info->time = date('Y年m月d日 H时i分 开始', strtotime($syllabus_info->time));
        $creator = DB::table('organization')->where('oid','=',$result->course_creator)->get()->first();
        $result->creator_name = $creator->name;
        $result->creator_logo = $creator->logo;
        $feedback_submit_status = DB::table('syllabus_feedback')->where('cid','=',$cid)->where('uid','=',$uid)->where('syid','=',$syid)->get()->first();
        $feedback_submit_status = $feedback_submit_status ? $feedback_submit_status : 0;
        return ([
            'result'=>$result,
            'register_status'=>$register_status,
            'syllabus_info'=>$syllabus_info,
            'feedback_submit_status'=>$feedback_submit_status,
        ]);
    }

    public function isRegister($cid, $uid)
    {
        return DB::table('course_register')->where('cid','=',$cid)->where('uid','=',$uid)->count();
    }

    public function submitFeedBack($cid, $syid, $rank, $desc, $uid)
    {
        $feedback_submit_status = DB::table('syllabus_feedback')->where('cid','=',$cid)->where('uid','=',$uid)->where('syid','=',$syid)->count();
        if(!$feedback_submit_status){
            return DB::table('syllabus_feedback')->insertGetId([
                "cid"=>$cid,
                "syid"=>$syid,
                "uid"=>$uid,
                "desc"=>$desc,
                "rank"=>$rank,
                "feedback_time"=>date("Y-m-d H:i:s"),
            ]);
        } else {
            return DB::table('syllabus_feedback')->where('cid','=',$cid)->where('uid','=',$uid)->where('syid','=',$syid)->update([
                "desc"=>$desc,
                "rank"=>$rank,
                "feedback_time"=>date("Y-m-d H:i:s"),
            ]);
        }
    }
}