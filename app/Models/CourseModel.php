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

    public function manage($cid)
    {
        $access_right = DB::table('privilege')->where('uid','=',Auth::user()->id)->where('type','=','cid')->where('type_value','=',$cid)->where('clearance','>',0)->get()->first();
        $access_right = (array)$access_right;
        $result = DB::table('courses')->where('cid','=',$cid)->get()->first();
        $result = (array)$result;
        if (empty($result) || empty($access_right)) {
            return null;
        }
        $creator = DB::table('organization')->where('oid','=',$result['course_creator'])->get()->first();
        $creator = (array)$creator;
        $details = DB::table('course_details')->where('cid','=',$cid)->get()->all();
        foreach($details as &$r){
            $r = (array)$r;
        }
        $instructor_info = DB::table('instructor as i')->leftJoin('users as u','i.uid','=','u.id')->where('i.cid','=',$cid)->orderBy('i.iid','asc')->get()->all();
        foreach($instructor_info as &$r){
            $r = (array)$r;
        }
        $result['creator_name']=$creator['name'];
        $result['creator_logo']=$creator['logo'];
        $syllabus_info = DB::table('syllabus as s')
        ->select('s.syid','s.cid','title','time','location','desc','signed','signid','script','homework','feedback','video')
        ->leftJoin('syllabus_sign as u', function ($join) {
            $join->on('s.syid','=','u.syid')
            ->where('u.uid','=',Auth::user()->id);
        })
        ->where('s.cid','=',$cid)
        ->orderBy('time','asc')->get()->all();
        // 关联查询sign的原因：历史遗留
        foreach($syllabus_info as &$r){
            $r = (array)$r;
        }
        foreach ($syllabus_info as &$s) {
            $s["time"] = date('Y年m月d日 H时i分 开始', strtotime($s['time']));
        }
        return [
            'result'=>$result,
            'site'=>$result["course_name"],
            'detail'=>$details,
            'instructor'=>$instructor_info,
            'syllabus'=>$syllabus_info,
            'access_right'=>$access_right,
        ];
    }

    public function accessRightAdd($uid)
    {
        return DB::table('privilege')->where('uid','=',$uid)->where('type','=','system')->where('type_value','=','4')->count();
    }

    public function accessRightViewSign($uid,$cid)
    {
        return DB::table('privilege')->where('uid','=',$uid)->where('type','=','cid')->where('type_value','=',$cid)->where('clearance','>',0)->count();
    }

    public function viewSign($cid,$syid)
    {
        $this->cid=$cid;
        $this->syid=$syid;
        $result = DB::table('courses')->where('cid','=',$cid)->get()->first();
        $result = (array)$result;
        $access_right = DB::table('privilege')->where('uid','=',Auth::user()->id)->where('type','=','cid')->where('type_value','=',$cid)->where('clearance','>',0)->get()->first();
        $access_right = (array)$access_right;
        if (empty($access_right)) {
            return null;
        }
        $syllabus_info = DB::table('syllabus')->where('cid','=',$cid)->where('syid','=',$syid)->get()->first();
        $syllabus_info = (array)$syllabus_info;
        $syllabus_info["time"] = date('Y年m月d日 H时i分 开始', strtotime($syllabus_info['time']));
        if (empty($result) || empty($syllabus_info)) {
            return null;
        }
        $creator = DB::table('organization')->where('oid','=',$result['course_creator'])->get()->first();
        $creator = (array)$creator;
        $result['creator_name']=$creator['name'];
        $result['creator_logo']=$creator['logo'];
        $sign_details = DB::table('syllabus_sign as s')
        ->leftJoin('users as u','s.uid','=','u.id')
        ->where('s.cid','=',$cid)
        ->where('s.syid','=',$syid)
        ->orderBy('s.stime','asc')->get()->all();
        foreach($sign_details as &$r){
            $r = (array)$r;
        }
        return [
            'sign_details'=>$sign_details,
            'result'=>$result,
            'syllabus_info'=>$syllabus_info
        ];
    }

    public function viewRegister($cid)
    {
        $result = DB::table('courses')->where('cid','=',$cid)->get()->first();
        $result = (array)$result;
        $access_right = DB::table('privilege')->where('uid','=',Auth::user()->id)->where('type','=','cid')->where('type_value','=',$cid)->where('clearance','>',0)->get()->first();
        $access_right = (array)$access_right;
        if (empty($access_right)) {
            return null;
        }
        $creator = DB::table('organization')->where('oid','=',$result['course_creator'])->get()->first();
        $creator = (array)$creator;
        $result['creator_name']=$creator['name'];
        $result['creator_logo']=$creator['logo'];
        $course_register_details = DB::table('course_register as c')
        ->leftJoin('users as u','c.uid','=','u.id')
        ->where('c.cid','=',$cid)
        ->orderBy('c.rid','asc')->get()->all();
        foreach($course_register_details as &$r){
            $r = (array)$r;
        }
        if(!empty($course_register_details) && $course_register_details[0]['uid']==0){
            unset($course_register_details[0]); //这里有一个神奇的bug
        }
        return [
            'register_details'=>$course_register_details,
            'result'=>$result,
        ];
    }

    public function addSyllabus($cid)
    {
        $result = DB::table('courses')->where('cid','=',$cid)->get()->first();
        $result = (array)$result;
        $access_right = DB::table('privilege')->where('uid','=',Auth::user()->id)->where('type','=','cid')->where('type_value','=',$cid)->where('clearance','>',0)->get()->first();
        $access_right = (array)$access_right;
        if (empty($access_right) || empty($result)) {
            return null;
        }
        $creator = DB::table('organization')->where('oid','=',$result['course_creator'])->get()->first();
        $creator = (array)$creator;
        $result['creator_name']=$creator['name'];
        $result['creator_logo']=$creator['logo'];
        return $result;
    }

    public function addInstructor($cid,$email){
        $access_right = DB::table('privilege')->where('uid','=',Auth::user()->id)->where('type','=','cid')->where('type_value','=',$cid)->where('clearance','>',0)->get()->first();
        $access_right = (array)$access_right;
        if (empty($access_right) || $access_right["clearance"]<4) {
            return 2003;
        }
        $email_user = DB::table('users')->where('email','=',$email)->get()->first();
        $email_user = (array)$email_user;
        if (empty($email_user)) {
            return 2002;
        }
        $email_uid=$email_user["id"];
        $email_user_instructor = DB::table('instructor')->where('uid','=',$email_uid)->where('cid','=',$cid)->get()->first();
        $email_user_instructor = (array)$email_user_instructor;
        $email_user_access_course = DB::table('privilege')->where('uid','=',$email_uid)->where('type','=','cid')->where('type_value','=',$cid)->get()->first();
        $email_user_access_course = (array)$email_user_access_course;
        $email_user_access = DB::table('privilege')->where('uid','=',$email_uid)->where('type','=','access')->where('type_value','=','1')->get()->first();
        $email_user_access = (array)$email_user_access;
        if ($email_user_instructor) {
            return 2005;
        }
        DB::table('instructor')->insert([
            'uid'=>$email_uid,
            'cid'=>$cid,
            'course_title'=>"讲师"
        ]);
        if (empty($email_user_access_course)) {
            DB::table('privilege')->insertGetId([
                'uid'=>$email_uid,
                'type_value'=>$cid,
                'type'=>"cid",
                'clearance'=>1,
            ]);
            if (empty($email_user_access)) {
                DB::table('privilege')->insertGetId([
                    'uid'=>$email_uid,
                    'type_value'=>1,
                    'type'=>"access"
                ]);
            }
            return 0;
        } elseif ($email_user_access_course["clearance"]==0) {
            DB::table('privilege')->where('uid','=',$email_uid)->where('type','=','cid')->where('type_value','=',$cid)->update(['clearance'=>1]);
            if (empty($email_user_access)) {
                DB::table('privilege')->insertGetId([
                    'uid'=>$email_uid,
                    'type_value'=>1,
                    'type'=>"access"
                ]);
            }
            return 1;
        } else {
            return 2005;
        }
    }

    public function removeInstructor($cid,$iid)
    {
        $access_right = DB::table('privilege')->where('uid','=',Auth::user()->id)->where('type','=','cid')->where('type_value','=',$cid)->where('clearance','>',0)->get()->first();
        $access_right = (array)$access_right;
        if (empty($access_right) || $access_right["clearance"]<4) {
            return 2003;
        }
        $instructor_info = DB::table('instructor')->where('iid','=',$iid)->get()->first();
        $instructor_info = (array)$instructor_info;
        if ($instructor_info["cid"]!=$cid) {
            return 2003;
        }
        if (empty($instructor_info)) {
            return 2002;
        }
        if ($instructor_info["uid"]==Auth::user()->id) {
            return 2006;
        }
        DB::table('instructor')->where('iid','=',$iid)->delete();
        DB::table('privilege')->where('uid','=',$instructor_info["uid"])->where('type','=','cid')->where('type_value','=',$cid)->where('clearance','>',0)->delete();
        return 0;
    }

    public function addSyllabusInfo($cid,$title,$desc,$location,$time,$endtime)
    {
        $access_right = DB::table('privilege')->where('uid','=',Auth::user()->id)->where('type','=','cid')->where('type_value','=',$cid)->where('clearance','>',0)->get()->first();
        $access_right = (array)$access_right;
        if (empty($access_right)) {
            return 2003;
        }
        $result = DB::table('courses')->where('cid','=',$cid)->get()->first();
        $result = (array)$result;
        if (empty($result)) {
            return 3002;
        }
        $creator=$result['course_creator'];
        $period='';
        $signed=substr(md5(uniqid(microtime(true), true)), 0, 6);
        $preg = '/^([12]\d\d\d)-(0?[1-9]|1[0-2])-(0?[1-9]|[12]\d|3[0-1]) ([0-1]\d|2[0-4]):([0-5]\d)(:[0-5]\d)?$/';
        if (!preg_match($preg, $time)) {
            return 1004;
        }
        if (!preg_match($preg, $endtime)) {
            return 1004;
        }
        if ($creator == 1) {
            $locs = ['大学生活动中心 青柚汇客厅', '三牌楼教学楼（57人）', '三牌楼教学楼（105人）', '三牌楼教学楼（153人）', '三牌楼教学楼（200人）', '三牌楼教学楼（250人）', '仙林教学楼（57人）', '仙林教学楼（120人）', '仙林教学楼（172人）', '仙林教学楼（234人）', '大学生活动中心 会议室', '大学生活动中心 青柚创新汇', '大学生活动中心 208'];
            if (!in_array($location, $locs)) {
                return 1004;
            }
            if (substr($location, -3) == '）') { // 教学楼
                if (!arg('period')) {
                    return 1003;
                }
                $period = arg('period');
                $periods = ['第一大节', '第二大节', '第三大节', '第四大节', '第五大节', '上午', '下午'];
                if (!in_array($period, $periods)) {
                    return 1004;
                }
            }
        }
        DB::table('syllabus')->insertGetId([
            'cid'=>$cid,
            'title'=>$title,
            'desc'=>$desc,
            'location'=>$location,
            'time'=>$time,
            'endtime'=>$endtime,
            // 'period'=>$period,
            'signed'=>$signed,
            'script'=>0,
            'homework'=>0,
            'feedback'=>0,
            // 'confirmed'=>0,
            'video'=>0
        ]);
        return 0;
    }
}