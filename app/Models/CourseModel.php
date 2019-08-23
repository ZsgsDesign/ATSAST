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
        return DB::table('courses')->where('cid','=',$cid)->get()->first();
    }
}