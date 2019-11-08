<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\ResponseModel;
use App\Models\CourseModel;
use App\Models\Eloquents\Instructor;
use App\Models\Eloquents\SyllabusFeedback;
use App\Models\Eloquents\SyllabusScript;
use Illuminate\Http\Request;
use Auth;

class CourseController extends Controller
{
    public function sign(Request $request)
    {
        $request->validate([
            'signed' => 'required',
            'cid' => 'required',
            'syid' => 'required',
        ]);
        if(!Auth::check()){
            return ResponseModel::err(2001);
        }
        $signed = $request->input('signed');
        $cid = $request->input('cid');
        $syid = $request->input('syid');
        $coursemodel = new CourseModel();
        $ret = $coursemodel->updateSignStatus($signed, $cid, $syid, Auth::user()->id);
        return ResponseModel::success(200, null, $ret);
    }

    public function edit(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'major' => 'required',
            'desc' => 'required',
            'color' => 'required',
            'suitable' => 'required',
            'type' => 'required',
        ]);
        $course = $request->course;
        $emails = explode(';',$request->email);
        foreach ($emails as &$email) {
            $user = User::where('email',$email)->first();
            if(empty($user)){
                return ResponseModel::err(2002,null,$email);
            }else{
                $email = [
                    'email' => $email,
                    'user_id' => $user
                ];
            }
        }
        //todo...

    }

    public function editSign(Request $request)
    {
        $syllabus = $request->syllabus;
        $sign_status = boolval($request->sign_status);
        if($sign_status) {
            $signed = $request->signed;
            $pattern='/^(\w){6}$/';
            if (!preg_match($pattern, $signed)) {
                return ResponseModel::err(1004);
            }
            $syllabus->signed = $signed;
            $syllabus->save();
        }else{
            $syllabus->signed = '0';
            $syllabus->save();
        }
        return ResponseModel::success();
    }

    public function editVideo(Request $request)
    {
        $syllabus = $request->syllabus;
        $video_status = boolval($request->video_status);
        if($video_status) {
            $video = $request->video;
            $pattern='/^((ht|f)tps?):\/\/[\w\-]+(\.[\w\-]+)+([\w\-.,@?^=%&:\/~+#]*[\w\-@?^=%&\/~+#])?$/';
            if (!preg_match($pattern, $video)) {
                return ResponseModel::err(1004);
            }
            $syllabus->video = $video;
            $syllabus->save();
        }else{
            $syllabus->signed = '0';
            $syllabus->save();
        }
        return ResponseModel::success();
    }

    public function editScript(Request $request)
    {
        $course   = $request->course;
        $syllabus = $request->syllabus;
        $script_status = boolval($request->script_status);
        if($script_status) {
            $syllabus->script = true;
            if(empty($syllabus->syllabus_script)){
                SyllabusScript::updateOrInsert([
                    'cid'     => $course->cid,
                    'syid'    => $syllabus->syid
                ],[
                    'content' => $request->script
                ]);
            }else{
                $syllabus->syllabus_script->content = $request->script;
                $syllabus->syllabus_script->save();
            }
            $syllabus->save();
        }else{
            $syllabus->script = false;
            $syllabus->save();
        }
        return ResponseModel::success();
    }

    public function editSyllabus(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'desc' => 'required',
            'location' => 'required',
            'time' => 'required|date',
        ]);
        $syllabus = $request->syllabus;
        $syllabus->title    = $request->title;
        $syllabus->desc     = $request->desc;
        $syllabus->location = $request->location;
        $syllabus->time     = date('Y-m-d H:i:s',strtotime($request->time));
        $syllabus->save();
        return ResponseModel::success();
    }

    public function editFeedback(Request $request)
    {
        $syllabus = $request->syllabus;
        $feedback_status = boolval($request->feedback_status);
        $syllabus->feedback = $feedback_status;
        $syllabus->save();
        return ResponseModel::success();
    }

    public function submitFeedBack(Request $request)
    {
        $request->validate([
            'cid'=>'required',
            'syid'=>'required',
            'rank'=>'required',
            'desc'=>'required',
        ]);
        $user     = Auth::user();
        $course   = $request->course;
        $syllabus = $request->syllabus;
        SyllabusFeedback::updateOrInsert([
            'cid'  => $course->cid,
            'syid' => $syllabus->syid,
            'uid'  => $user->id
        ],[
            'rank' => boolval($request->rank),
            'desc' => $request->desc,
            'feedback_time' => date('Y-m-d H:i:s')
        ]);
        return ResponseModel::success();
    }

    public function addInstructor(Request $request)
    {
        $request->validate([
            'cid' => 'required',
            'email' => 'required'
        ]);
        $cid = $request->input('cid');
        $email = $request->input('email');
        $coursemodel = new CourseModel();
        $ret = $coursemodel->addInstructor($cid,$email);
        if($ret==0){
            return ResponseModel::success(200, "添加讲师成功", $ret);
        }elseif($ret==1){
            return ResponseModel::success(200, "讲师权限提升成功", $ret);
        }else{
            return ResponseModel::err($ret);
        }
    }

    public function removeInstructor(Request $request)
    {
        $request->validate([
            'cid' => 'required',
            'iid' => 'required'
        ]);
        $cid = $request->input('cid');
        $iid = $request->input('iid');
        $coursemodel = new CourseModel();
        $ret = $coursemodel->removeInstructor($cid,$iid);
        if($ret==0){
            return ResponseModel::success(200, "讲师权限撤销成功", $ret);
        }else{
            return ResponseModel::err($ret);
        }
    }

    public function addSyllabusInfo(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'desc' => 'required|string',
            'location' => 'required|string',
            'time' => 'required|string'
        ]);
        $course = $request->course;
        $course->syllabus()->create([
            'title'    => $request->title,
            'desc'     => $request->desc,
            'location' => $request->location,
            'time'     => $request->time,
            'signed'   => substr(md5(uniqid(microtime(true), true)), 0, 6),
            'script'   => 0,
            'feedback' => 0,
            'video'    => 0,
            'homework' => 0
        ]);
        return ResponseModel::success(200);
    }

    public function addCourse(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'organization' => 'required',
            'major' => 'required',
            'desc' => 'required',
            'color' => 'required',
            'suitable' => 'required',
            'type' => 'required',
        ]);
        $name = $request->input('name');
        $email = $request->input('email');
        $organization = $request->input('organization');
        $major = $request->input('major');
        $desc = $request->input('desc');
        $color = $request->input('color');
        $suitable = $request->input('suitable');
        $type = $request->input('type');
        $coursemodel = new CourseModel();
        $ret = $coursemodel->addCourse($name,$email,$organization,$major,$desc,$color,$suitable,$type);
        if(is_array($ret)){
            return ResponseModel::success(200, "新建成功", $ret[1]);
        }else{
            return ResponseModel::err($ret);
        }
    }
}
