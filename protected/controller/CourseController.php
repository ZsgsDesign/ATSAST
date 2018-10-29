<?php
class CourseController extends BaseController
{
    public function actionIndex()
    {
        if (arg("cid")) {
            $this->jump("/course/".arg("cid")."/detail");
        } else {
            $this->jump("/courses");
        }
    }
    public function actionDetail()
    {
        $this->url="course/detail";
        $this->title="课程详情";
        $this->bg="";

        if (arg("cid")) {
            $cid=arg("cid");
            if (is_numeric($cid)) {
                $this->cid=$cid;
                $db=new Model("courses");
                $organization=new Model("organization");
                $instructor=new Model("instructor");
                $course_details=new Model("course_details");
                $course_register=new Model("course_register");
                $syllabus=new Model("syllabus");
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                if (empty($result)) {
                    return $this->jump("/courses");
                }
                $creator=$organization->find(array("oid=:oid",":oid"=>$result['course_creator']));
                $details=$course_details->findAll(array("cid=:cid",":cid"=>$cid));
                $instructor_info=$instructor->query("select * from instructor as i left join users u on i.uid = u.uid where i.cid=:cid order by i.iid asc", array(":cid"=>$cid));
                $result['creator_name']=$creator['name'];
                $result['creator_logo']=$creator['logo'];
                $this->result=$result;
                $this->detail=$details;
                if ($this->islogin) {
                    $syllabus_info=$syllabus->query("select s.syid,s.cid,title,time,location,`desc`,signed,signid from syllabus as s left join sign u on s.syid = u.syid and u.uid=:uid where s.cid=:cid", array(":uid"=>$this->userinfo['uid'],":cid"=>$cid));
                } else {
                    $syllabus_info=$syllabus->findAll(array("cid=:cid",":cid"=>$cid));
                }
                if ($this->islogin) {
                    $register_status=$course_register->find(array("cid=:cid and uid=:uid",":cid"=>$cid,":uid"=>$this->userinfo['uid']));
                }
                if (empty($register_status)) {
                    $this->register_status=0;
                } else {
                    $this->register_status=$register_status['status'];
                }
                // var_dump($details);
                $this->instructor=$instructor_info;
                $this->syllabus=$syllabus_info;
                // var_dump($syllabus_info);
                $this->cid=$cid;
            } else {
                $this->jump("/courses");
            }
        } else {
            $this->jump("/courses");
        }
    }

    public function actionManage()
    {
        $this->url="course/manage";
        $this->title="课程管理";
        $this->bg="";

        if (arg("cid") && $this->islogin) {
            $cid=arg("cid");
            if (is_numeric($cid)) {
                $this->cid=$cid;
                $db=new Model("courses");
                $organization=new Model("organization");
                $instructor=new Model("instructor");
                $course_details=new Model("course_details");
                $course_register=new Model("course_register");
                $syllabus=new Model("syllabus");
                $privilege=new Model("privilege");
                $access_right=$privilege->find(array("uid=:uid and type='cid' and type_value=:cid and clearance>0",":uid"=>$this->userinfo['uid'],":cid"=>$cid));
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                if (empty($result) || empty($access_right)) {
                    return $this->jump("/courses");
                }
                $creator=$organization->find(array("oid=:oid",":oid"=>$result['course_creator']));
                $details=$course_details->findAll(array("cid=:cid",":cid"=>$cid));
                $instructor_info=$instructor->query("select * from instructor as i left join users u on i.uid = u.uid where i.cid=:cid order by i.iid asc", array(":cid"=>$cid));
                $result['creator_name']=$creator['name'];
                $result['creator_logo']=$creator['logo'];
                $this->result=$result;
                $this->detail=$details;
                $syllabus_info=$syllabus->query("select s.syid,s.cid,title,time,location,`desc`,signed,signid from syllabus as s left join sign u on s.syid = u.syid and u.uid=:uid where s.cid=:cid", array(":uid"=>$this->userinfo['uid'],":cid"=>$cid));
                $this->instructor=$instructor_info;
                $this->syllabus=$syllabus_info;
                // var_dump($syllabus_info);
                $this->cid=$cid;
            } else {
                $this->jump("/courses");
            }
        } else {
            $this->jump("/courses");
        }
    }

    public function actionRegister()
    {
        $this->url="course/register";
        $this->title="报名";

        if (!($this->islogin)) {
            return $this->jump("/courses");
        }
        if (arg("cid")) {
            $cid=arg("cid");
            if (is_numeric($cid)) {
                $this->cid=$cid;
                $db=new Model("courses");
                $course_register=new Model("course_register");
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                if (empty($result)) {
                    return $this->jump("/courses");
                }
                $register_status=$course_register->find(array("cid=:cid and uid=:uid",":cid"=>$cid,":uid"=>$this->userinfo['uid']));
                if (empty($register_status)) {
                    //报名
                    $newrow = array(
                        'uid' => $this->userinfo['uid'],
                        'cid' => $cid,
                        'status' => 1
                    );
                    $course_register->create($newrow);
                    $this->register_status=1;
                } else {
                    $this->register_status=0;
                }
                $this->cid=$cid;
            } else {
                $this->jump("/courses");
            }
        } else {
            $this->jump("/courses");
        }
    }

    public function actionAdd()
    {
        $this->url="course/add";
        $this->title="新增课程";
        $this->bg="";
        if (!($this->islogin)) {
            return $this->jump("/courses");
        }
    }

    public function actionScript()
    {
        $this->url="course/script";
        $this->title="教学讲义";
        $this->bg="";

        if (!($this->islogin)) {
            return $this->jump("/courses");
        }

        if (arg("cid") && arg("syid")) {
            $db=new Model("courses");
            $cid=arg("cid");
            $syid=arg("syid");
            if (is_numeric($cid) && is_numeric($syid)) {
                $this->cid=$cid;
                $script=new Model("script");
                $organization=new Model("organization");
                $syllabus=new Model("syllabus");
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                $course_register=new Model("course_register");
                if ($this->islogin) {
                    $register_status=$course_register->find(array("cid=:cid and uid=:uid",":cid"=>$cid,":uid"=>$this->userinfo['uid']));
                }
                if (empty($register_status)) {
                    return $this->jump("/course/$cid/detail");
                }
                $syllabus_info=$syllabus->find(array("cid=:cid",":cid"=>$cid));
                if (empty($result) || empty($syllabus_info)) {
                    return $this->jump("/courses");
                }
                $creator=$organization->find(array("oid=:oid",":oid"=>$result['course_creator']));
                $result['creator_name']=$creator['name'];
                $result['creator_logo']=$creator['logo'];
                $result2=$script->find(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid));

                if (empty($result2)) {
                    return $this->jump("/courses");
                }

                $this->result=$result;

                $result2['content_slashed'] = str_replace('\\', '\\\\', $result2['content']);
                $result2['content_slashed'] = str_replace("\r\n", "\\n", $result2['content_slashed']);
                $result2['content_slashed'] = str_replace("\n", "\\n", $result2['content_slashed']);
                $result2['content_slashed'] = str_replace("\"", "\\\"", $result2['content_slashed']);
                $result2['content_slashed'] = str_replace("<", "\<", $result2['content_slashed']);
                $result2['content_slashed'] = str_replace(">", "\>", $result2['content_slashed']);

                $this->script=$result2;
            } else {
                $this->jump("/courses");
            }
        } else {
            $this->jump("/courses");
        }
    }

    public function actionHomework()
    {
        $this->url="course/homework";
        $this->title="作业提交";
        $this->bg="";
        if (!($this->islogin)) {
            return $this->jump("/courses");
        }

        if (arg("cid") && arg("syid")) {
            $db=new Model("courses");
            $cid=arg("cid");
            $syid=arg("syid");
            if (is_numeric($cid) && is_numeric($syid)) {
                $this->cid=$cid;
                $this->syid=$syid;
                $homework=new Model("homework");
                $homework_submit=new Model("homework_submit");
                $organization=new Model("organization");
                $syllabus=new Model("syllabus");
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                $course_register=new Model("course_register");
                if ($this->islogin) {
                    $register_status=$course_register->find(array("cid=:cid and uid=:uid",":cid"=>$cid,":uid"=>$this->userinfo['uid']));
                }
                if (empty($register_status)) {
                    return $this->jump("/course/$cid/detail");
                }
                $syllabus_info=$syllabus->find(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid));
                if (empty($result) || empty($syllabus_info)) {
                    return $this->jump("/courses");
                }
                $creator=$organization->find(array("oid=:oid",":oid"=>$result['course_creator']));
                $result['creator_name']=$creator['name'];
                $result['creator_logo']=$creator['logo'];
                $homework_details=$homework->findAll(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid));
                if (empty($homework_details)) {
                    return $this->jump("/courses");
                }
                foreach ($homework_details as &$h) {
                    $h['homework_content_slashed'] = str_replace('\\', '\\\\', $h['homework_content']);
                    $h['homework_content_slashed'] = str_replace("\r\n", "\\n", $h['homework_content_slashed']);
                    $h['homework_content_slashed'] = str_replace("\n", "\\n", $h['homework_content_slashed']);
                    $h['homework_content_slashed'] = str_replace("\"", "\\\"", $h['homework_content_slashed']);
                    $h['homework_content_slashed'] = str_replace("<", "\<", $h['homework_content_slashed']);
                    $h['homework_content_slashed'] = str_replace(">", "\>", $h['homework_content_slashed']);
                }
                $homework_submit_status=$homework_submit->findAll(array("cid=:cid and syid=:syid and uid=:uid",":cid"=>$cid,":syid"=>$syid,":uid"=>$this->userinfo['uid']));
                $this->result=$result;
                $this->syllabus_info=$syllabus_info;
                $this->homework=$homework_details;
                if (empty($homework_submit_status)) {
                    $this->homework_submit=array();
                } else {
                    $homework_submit_info=array();
                    foreach ($homework_submit_status as $r) {
                        $r['submit_content_slashed'] = str_replace('\\', '\\\\', $r['submit_content']);
                        $r['submit_content_slashed'] = str_replace("\r\n", "\\n", $r['submit_content_slashed']);
                        $r['submit_content_slashed'] = str_replace("\n", "\\n", $r['submit_content_slashed']);
                        $r['submit_content_slashed'] = str_replace("\"", "\\\"", $r['submit_content_slashed']);
                        $r['submit_content_slashed'] = str_replace("<", "\<", $r['submit_content_slashed']);
                        $r['submit_content_slashed'] = str_replace(">", "\>", $r['submit_content_slashed']);
                        $homework_submit_info[$r['hid']]=$r;
                    }
                    $this->homework_submit=$homework_submit_info;
                }

                if (arg("action")=="submit") {
                    $submit_time=date("Y-m-d H:i:s");
                    $newrow=array(
                        "cid"=>$cid,
                        "syid"=>$syid,
                        "uid"=>$this->userinfo['uid'],
                        "submit_content"=>arg("content"),
                        "submit_time"=>$submit_time,
                    );
                    $homework_submit->create($newrow);
                    return $this->jump("/course/$cid/detail");
                }
            } else {
                $this->jump("/courses");
            }
        } else {
            $this->jump("/courses");
        }
    }

    public function actionSign()
    {
        $this->url="course/sign";
        $this->title="签到";
        if (!($this->islogin)) {
            return $this->jump("/courses");
        }

        if (arg("cid") && arg("syid")) {
            $db=new Model("courses");
            $cid=arg("cid");
            $syid=arg("syid");
            if (is_numeric($cid) && is_numeric($syid)) {
                $this->cid=$cid;
                $sign=new Model("sign");
                $organization=new Model("organization");
                $syllabus=new Model("syllabus");
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                $course_register=new Model("course_register");
                if ($this->islogin) {
                    $register_status=$course_register->find(array("cid=:cid and uid=:uid",":cid"=>$cid,":uid"=>$this->userinfo['uid']));
                }
                if (empty($register_status)) {
                    return $this->jump("/course/$cid/detail");
                }
                $syllabus_info=$syllabus->find(array("cid=:cid",":cid"=>$cid));
                if (empty($result) || empty($syllabus_info)) {
                    return $this->jump("/courses");
                }
                $sign_status=$sign->find(array("cid=:cid and syid=:syid and uid=:uid",":cid"=>$cid,":syid"=>$syid,":uid"=>$this->userinfo['uid']));
                if (empty($sign_status)) {
                    $sign_status=0;
                } else {
                    return $this->sign_status=-1;
                }
                $this->sign_status=$sign_status;
                $this->syllabus=$syllabus_info;
            } else {
                $this->jump("/courses");
            }

            if (arg("password")) {
                $password=arg("password");
                $result=$syllabus->find(array("cid=:cid and syid=:syid and signed=:signed",":cid"=>$cid,":syid"=>$syid,":signed"=>$password));
                if (empty($result)) {
                    $sign_status=-2;
                } else {
                    $stime=date("Y-m-d H:i:s");
                    $sign->create(array(
                        "syid"=>$syid,
                        "cid"=>$cid,
                        "uid"=>$this->userinfo['uid'],
                        "stime"=>$stime
                    ));
                    $sign_status=1;
                }
                $this->sign_status=$sign_status;
            }
        } else {
            $this->jump("/courses");
        }
    }

    public function actionView_Homework()
    {
        $this->url="course/view_homework";
        $this->title="查看作业提交";
        $this->bg="";
        if (!($this->islogin)) {
            return $this->jump("/courses");
        }

        if (arg("cid") && arg("syid")) {
            $db=new Model("courses");
            $cid=arg("cid");
            $syid=arg("syid");
            if (is_numeric($cid) && is_numeric($syid)) {
                $this->cid=$cid;
                $this->syid=$syid;
                $homework=new Model("homework");
                $homework_submit=new Model("homework_submit");
                $organization=new Model("organization");
                $syllabus=new Model("syllabus");
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                $privilege=new Model("privilege");
                $access_right=$privilege->find(array("uid=:uid and type='cid' and type_value=:cid and clearance>0",":uid"=>$this->userinfo['uid'],":cid"=>$cid));

                if (empty($access_right)) {
                    return $this->jump("/course/$cid/");
                }

                $syllabus_info=$syllabus->find(array("cid=:cid",":cid"=>$cid));

                if (empty($result) || empty($syllabus_info)) {
                    return $this->jump("/courses");
                }

                $creator=$organization->find(array("oid=:oid",":oid"=>$result['course_creator']));
                $result['creator_name']=$creator['name'];
                $result['creator_logo']=$creator['logo'];
                $homework_details=$homework->findAll(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid));

                if (empty($homework_details)) {
                    return $this->jump("/courses");
                }

                foreach ($homework_details as &$h) {
                    $h['homework_content_slashed'] = str_replace('\\', '\\\\', $h['homework_content']);
                    $h['homework_content_slashed'] = str_replace("\r\n", "\\n", $h['homework_content_slashed']);
                    $h['homework_content_slashed'] = str_replace("\n", "\\n", $h['homework_content_slashed']);
                    $h['homework_content_slashed'] = str_replace("\"", "\\\"", $h['homework_content_slashed']);
                    $h['homework_content_slashed'] = str_replace("<", "\<", $h['homework_content_slashed']);
                    $h['homework_content_slashed'] = str_replace(">", "\>", $h['homework_content_slashed']);
                }
                
                $homework_submit_users=$homework_submit->query("SELECT DISTINCT(h.uid),u.SID,u.avatar,u.real_name from homework_submit as h left join users u on h.uid = u.uid where h.cid=:cid and h.syid=:syid",array(":cid"=>$cid,":syid"=>$syid));
                $this->result=$result;
                $this->syllabus_info=$syllabus_info;
                $this->homework=$homework_details;
                if (empty($homework_submit_users)) {
                    $this->homework_submit=array();
                } else {
                    $this->homework_submit=$homework_submit_users;
                }
            } else {
                $this->jump("/courses");
            }
        } else {
            $this->jump("/courses");
        }
    }

    public function actionView_Homework_Details()
    {
        $this->url="course/view_homework_details";
        $this->title="查看作业提交详情";
        $this->bg="";
        if (!($this->islogin)) {
            return $this->jump("/courses");
        }

        if (arg("cid") && arg("syid") && arg("uid")) {
            $db=new Model("courses");
            $cid=arg("cid");
            $syid=arg("syid");
            $uid=arg("uid");
            if (is_numeric($cid) && is_numeric($syid) && is_numeric($uid)) {
                $this->cid=$cid;
                $this->syid=$syid;
                $users=new Model("users");
                $homework=new Model("homework");
                $homework_submit=new Model("homework_submit");
                $organization=new Model("organization");
                $syllabus=new Model("syllabus");
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                $course_register=new Model("course_register");

                $privilege=new Model("privilege");
                $access_right=$privilege->find(array("uid=:uid and type='cid' and type_value=:cid and clearance>0",":uid"=>$this->userinfo['uid'],":cid"=>$cid));
                $this->user_details=$users->find(array("uid=:uid",":uid"=>$uid));

                if (empty($access_right)) {
                    return $this->jump("/course/$cid/detail");
                }

                $syllabus_info=$syllabus->find(array("cid=:cid",":cid"=>$cid));

                if (empty($result) || empty($syllabus_info)) {
                    return $this->jump("/courses");
                }
                $creator=$organization->find(array("oid=:oid",":oid"=>$result['course_creator']));
                $result['creator_name']=$creator['name'];
                $result['creator_logo']=$creator['logo'];
                $homework_details=$homework->findAll(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid));
                if (empty($homework_details)) {
                    return $this->jump("/courses");
                }
                foreach ($homework_details as &$h) {
                    $h['homework_content_slashed'] = str_replace('\\', '\\\\', $h['homework_content']);
                    $h['homework_content_slashed'] = str_replace("\r\n", "\\n", $h['homework_content_slashed']);
                    $h['homework_content_slashed'] = str_replace("\n", "\\n", $h['homework_content_slashed']);
                    $h['homework_content_slashed'] = str_replace("\"", "\\\"", $h['homework_content_slashed']);
                    $h['homework_content_slashed'] = str_replace("<", "\<", $h['homework_content_slashed']);
                    $h['homework_content_slashed'] = str_replace(">", "\>", $h['homework_content_slashed']);
                }
                $homework_submit_status=$homework_submit->findAll(array("cid=:cid and syid=:syid and uid=:uid",":cid"=>$cid,":syid"=>$syid,":uid"=>$uid));
                $this->result=$result;
                $this->syllabus_info=$syllabus_info;
                $this->homework=$homework_details;
                if (empty($homework_submit_status)) {
                    $this->homework_submit=array();
                } else {
                    $homework_submit_info=array();
                    foreach ($homework_submit_status as $r) {
                        $r['submit_content_slashed'] = str_replace('\\', '\\\\', $r['submit_content']);
                        $r['submit_content_slashed'] = str_replace("\r\n", "\\n", $r['submit_content_slashed']);
                        $r['submit_content_slashed'] = str_replace("\n", "\\n", $r['submit_content_slashed']);
                        $r['submit_content_slashed'] = str_replace("\"", "\\\"", $r['submit_content_slashed']);
                        $r['submit_content_slashed'] = str_replace("<", "\<", $r['submit_content_slashed']);
                        $r['submit_content_slashed'] = str_replace(">", "\>", $r['submit_content_slashed']);
                        $homework_submit_info[$r['hid']]=$r;
                    }
                    $this->homework_submit=$homework_submit_info;
                }
            } else {
                $this->jump("/courses");
            }
        } else {
            $this->jump("/courses");
        }
    }
}
