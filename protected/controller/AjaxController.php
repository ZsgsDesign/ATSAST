<?php
class AjaxController extends BaseController
{
    public function actionSubmitCodes()
    {
        if (!($this->islogin)) {
            ERR::Catcher(2001);
        }
        if (arg("cid") && arg("syid") && arg("hid")) {
            $db=new Model("courses");
            $cid=arg("cid");
            $syid=arg("syid");
            $hid=arg("hid");
            if (is_numeric($cid) && is_numeric($syid)) {
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
                    ERR::Catcher(3001);
                }
                $syllabus_info=$syllabus->find(array("cid=:cid",":cid"=>$cid));
                if (empty($result) || empty($syllabus_info)) {
                    ERR::Catcher(3003);
                }
                $creator=$organization->find(array("oid=:oid",":oid"=>$result['course_creator']));
                $result['creator_name']=$creator['name'];
                $result['creator_logo']=$creator['logo'];
                $homework_details=$homework->find(array("hid=:hid and cid=:cid and syid=:syid",":hid"=>$hid,":cid"=>$cid,":syid"=>$syid));
                if (empty($homework_details)) {
                    ERR::Catcher(3004);
                }
                $homework_submit_status=$homework_submit->find(array("hid=:hid and cid=:cid and syid=:syid and uid=:uid",":hid"=>$hid,":cid"=>$cid,":syid"=>$syid,":uid"=>$this->userinfo['uid']));

                if (arg("action")=="submit") {
                    $due_time=date("Y-m-d H:i:s",strtotime($homework_details['due_submit']));
                    $submit_time=date("Y-m-d H:i:s");

                    if(strtotime($submit_time) > strtotime($due_time)){
                        ERR::Catcher(3006);
                    }

                    if (empty($homework_submit_status)) {
                        $newrow=array(
                            "cid"=>$cid,
                            "hid"=>$hid,
                            "syid"=>$syid,
                            "uid"=>$this->userinfo['uid'],
                            "submit_content"=>arg("content"),
                            "submit_time"=>$submit_time,
                        );
                        $homework_submit->create($newrow);
                        return SUCCESS::Catcher("提交成功", array("time"=>$submit_time));
                    } else {
                        $homework_submit->update(
                            array(
                                "hid=:hid and cid=:cid and syid=:syid and uid=:uid",
                                ":cid"=>$cid,
                                ":hid"=>$hid,
                                ":syid"=>$syid,
                                ":uid"=>$this->userinfo['uid']
                            ),
                            array(
                                "submit_content"=>arg("content"),
                                "submit_time"=>$submit_time,
                            )
                        );
                        SUCCESS::Catcher("重新提交成功", array("time"=>$submit_time));
                    }
                }
            } else {
                ERR::Catcher(1004);
            }
        } else {
            ERR::Catcher(1003);
        }
    }
    
    public function actionSubmitBugs()
    {
        if (!($this->islogin)) {
            ERR::Catcher(2001);
        }
        if (arg("title") && arg("desc")) {
            $title=arg("title");
            $desc=arg("desc");
            if ((!empty($title) || (is_numeric($title) && $title==0)) && (!empty($title) || (is_numeric($desc) && $desc==0))) {
                $bug=new Model("bug");
                $submit_time=date("Y-m-d H:i:s");
                $newrow=array(
                    "version"=>$this->version_info['version'],
                    "subversion"=>$this->version_info['subversion'],
                    "uid"=>$this->userinfo['uid'],
                    "desc"=>$desc,
                    "title"=>$title,
                    "status"=>0,
                    "release_time"=>$submit_time,
                );
                $bug->create($newrow);
                SUCCESS::Catcher("提交成功");
            } else {
                ERR::Catcher(1004);
            }
        } else {
            ERR::Catcher(1003);
        }
    }

    public function actionSubmitFeedBack()
    {
        if (!($this->islogin)) {
            ERR::Catcher(2001);
        }
        if ( !is_null(arg("rank")) && !is_null(arg("cid")) && !is_null(arg("syid")) ) {
            $rank=intval(arg("rank"));
            $desc=arg("desc");
            $cid=arg("cid");
            $syid=arg("syid");
            if ( $rank===0 || $rank===1 ) {
                $feedback=new Model("syllabus_feedback");
                $syllabus=new Model("syllabus");
                $course_register=new Model("course_register");
                $register_status=$course_register->find(array("cid=:cid and uid=:uid",":cid"=>$cid,":uid"=>$this->userinfo['uid']));
                $feedback_submit_status=$feedback->find(array("cid=:cid and syid=:syid and uid=:uid",":cid"=>$cid,":syid"=>$syid,":uid"=>$this->userinfo['uid']));

                if (empty($register_status)) {
                    ERR::Catcher(3001);
                }

                $submit_time=date("Y-m-d H:i:s");
                if (empty($feedback_submit_status)) {
                    $feedback->create(array(
                        "cid"=>$cid,
                        "syid"=>$syid,
                        "uid"=>$this->userinfo['uid'],
                        "desc"=>$desc,
                        "rank"=>$rank,
                        "feedback_time"=>$submit_time,
                    ));
                    SUCCESS::Catcher("提交成功");
                } else {
                    $feedback->update(
                        array(
                            "cid=:cid and syid=:syid and uid=:uid",
                            ":cid"=>$cid,
                            ":syid"=>$syid,
                            ":uid"=>$this->userinfo['uid']
                        ),
                        array(
                            "desc"=>$desc,
                            "rank"=>$rank,
                            "feedback_time"=>$submit_time,
                        )
                    );
                    SUCCESS::Catcher("重新提交成功");
                }
            } else {
                ERR::Catcher(1004);
            }
        } else {
            ERR::Catcher(1003);
        }
    }
    
    public function actionchangeAlbum()
    {
        if (!($this->islogin)) {
            ERR::Catcher(2001);
        }
        if (arg("album")) {
            $album=arg("album");
            if ($album=="bing" || $album=="njupt") {
                $users=new Model("users");
                $users->update(array("uid=:uid",":uid"=>$this->userinfo['uid']), array('album'=>$album));
                SUCCESS::Catcher("提交成功");
            } else {
                ERR::Catcher(1004);
            }
        } else {
            ERR::Catcher(1003);
        }
    }
    
    public function actionUpdateInfo()
    {
        if (!($this->islogin)) {
            ERR::Catcher(2001);
        }
        if (arg("real_name") && arg("name") && (arg("gender") || arg("gender")==0)) {
            $real_name=arg("real_name");
            $name=arg("name");
            $gender=arg("gender");
            if (is_numeric($gender) && ($gender==0 || $gender==1 || $gender==2)) {
                $users=new Model("users");
                $users->update(array("uid=:uid",":uid"=>$this->userinfo['uid']), array('real_name'=>$real_name,'name'=>$name,'gender'=>$gender));
                SUCCESS::Catcher("提交成功");
            } else {
                ERR::Catcher(1004);
            }
        } else {
            ERR::Catcher(1003);
        }
    }

    public function actionUpdateSignSettings()
    {
        if (!($this->islogin)) {
            ERR::Catcher(2001);
        }
        if (arg("cid") && arg("syid")) {
            $cid=arg("cid");
            $syid=arg("syid");
            if (is_numeric($cid) && is_numeric($syid)) {
                $privilege=new Model("privilege");
                $access_right=$privilege->find(array("uid=:uid and type='cid' and type_value=:cid and clearance>0",":uid"=>$this->userinfo['uid'],":cid"=>$cid));

                if (empty($access_right)) {
                    ERR::Catcher(2003);
                }

                $sign_status=intval(arg("sign_status"));
                $signed=arg("signed");

                if($sign_status!=1 && $sign_status!=0) ERR::Catcher(1004);

                if($sign_status){
                    $pattern="/^(\w){6}$/";
                    if (!preg_match($pattern, $signed)) {
                        ERR::Catcher(1004);
                    }
                    $syllabus=new Model("syllabus");
                    $syllabus->update(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid), array('signed'=>$signed));
                    SUCCESS::Catcher("提交成功");
                }else{
                    $syllabus=new Model("syllabus");
                    $syllabus->update(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid), array('signed'=>0));
                    SUCCESS::Catcher("提交成功");
                }
            } else {
                ERR::Catcher(1004);
            }
        } else {
            ERR::Catcher(1003);
        }
    }

    public function actionUpdateScript()
    {
        if (!($this->islogin)) {
            ERR::Catcher(2001);
        }
        if (arg("cid") && arg("syid")) {
            $cid=arg("cid");
            $syid=arg("syid");
            if (is_numeric($cid) && is_numeric($syid)) {
                $privilege=new Model("privilege");
                $access_right=$privilege->find(array("uid=:uid and type='cid' and type_value=:cid and clearance>0",":uid"=>$this->userinfo['uid'],":cid"=>$cid));

                if (empty($access_right)) {
                    ERR::Catcher(2003);
                }

                $script_status=intval(arg("script_status"));
                $code=arg("script");

                if($script_status!=1 && $script_status!=0) ERR::Catcher(1004);

                $syllabus=new Model("syllabus");
                $syllabus->update(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid), array('script'=>$script_status));

                $script=new Model("syllabus_script");
                $script_exist=$script->find(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid));
                if($script_exist){
                    $script->update(array("cid=:cid and syid=:syid",":cid"=>$cid,":syid"=>$syid), array('content'=>$code));
                }else{
                    $script->create(array("cid"=>$cid,"syid"=>$syid,'content'=>$code));
                }
                SUCCESS::Catcher("提交成功");
            } else {
                ERR::Catcher(1004);
            }
        } else {
            ERR::Catcher(1003);
        }
    }
    
    public function actionUploadAvatar()
    {
        if (!($this->islogin)) {
            ERR::Catcher(2001);
        }
        $uid=$this->userinfo['uid'];
        $type = array("jpg", "gif", "bmp", "jpeg", "png");
        @$fileext = strtolower(substr(strrchr($_FILES['file']['name'], "."), 1));
        if (in_array($fileext, $type) && is_uploaded_file($_FILES['file']['tmp_name'])) {
            $image = $_FILES['file']['tmp_name']; // Original
            $imgstream = file_get_contents($image);
            $im = imagecreatefromstring($imgstream);
            $x = imagesx($im); // Get the width of the image
            $y = imagesy($im); // Get the height of the image
            
            $xx = 256;
            $yy = 256;
            
            if ($x>$y) {
                // h < w
                $sx = abs(($y-$x)/2);
                $sy = 0;
                $thumbw = $y;
                $thumbh = $y;
            } else {
                //h >= w
                $sy = abs(($x-$y)/2);
                $sx = 0;
                $thumbw = $x;
                $thumbh = $x;
            }

            if (function_exists("imagecreatetruecolor")) {
                $dim = imagecreatetruecolor($yy, $xx);
            } else {
                $dim = imagecreate($yy, $xx);
            }
            imageCopyreSampled($dim, $im, 0, 0, $sx, $sy, $yy, $xx, $thumbw, $thumbh);
            imageinterlace($dim, true);
            $stamp=time().rand(0, 9);
            if (!file_exists("/home/wwwroot/1cf/domain/1cf.co/web/i/img/atsast/upload/$uid")) {
                mkdir("/home/wwwroot/1cf/domain/1cf.co/web/i/img/atsast/upload/$uid", 0777, true);
            }
            imagejpeg($dim, "/home/wwwroot/1cf/domain/1cf.co/web/i/img/atsast/upload/$uid/$stamp.jpg", 100);
            $avatar = "{$this->ATSAST_CDN}/img/atsast/upload/$uid/$stamp.jpg";
            $users = new Model("users");
            $result = $users -> find(array("uid = :uid", ':uid' => $uid));
            if ($result) {
                $result = $users -> update(array("uid = :uid", ':uid' => $uid), array("avatar" => $avatar));
            } else {
                ERR::Catcher(1002);
            }
            SUCCESS::Catcher("头像更新成功", array("path"=>$avatar));
        } else {
            ERR::Catcher(1005);
        }
    }

    public function actionSubmitFile()
    {
        if (!($this->islogin)) {
            ERR::Catcher(2001);
        }
        if (arg("cid") && arg("syid") && arg("hid")) {
            $db=new Model("courses");
            $cid=arg("cid");
            $syid=arg("syid");
            $hid=arg("hid");
            if (is_numeric($cid) && is_numeric($syid)) {
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
                    ERR::Catcher(3001);
                }
                $syllabus_info=$syllabus->find(array("cid=:cid",":cid"=>$cid));
                if (empty($result) || empty($syllabus_info)) {
                    ERR::Catcher(3003);
                }
                $creator=$organization->find(array("oid=:oid",":oid"=>$result['course_creator']));
                $result['creator_name']=$creator['name'];
                $result['creator_logo']=$creator['logo'];
                $homework_details=$homework->find(array("hid=:hid and cid=:cid and syid=:syid",":hid"=>$hid,":cid"=>$cid,":syid"=>$syid));
                if (empty($homework_details)) {
                    ERR::Catcher(3004);
                }
                $homework_submit_status=$homework_submit->find(array("hid=:hid and cid=:cid and syid=:syid and uid=:uid",":hid"=>$hid,":cid"=>$cid,":syid"=>$syid,":uid"=>$this->userinfo['uid']));

                if (arg("action")=="submit") {
                    $uid=$this->userinfo['uid'];
                    $type = array("7z","csv","dbf","doc","docx","dwg","gif","iso","jpg","pdf","png","ppt","pptx","psd","rar","rtf","svg","tiff","txt","xls","xlsx","xml","zip");
                    @$fileext = strtolower(substr(strrchr($_FILES['file']['name'], "."), 1));
                    if (in_array($fileext, $type) && is_uploaded_file($_FILES['file']['tmp_name'])) {
                        $file = $_FILES['file']['tmp_name']; // Original
                        $filestream = file_get_contents($file);
                        
                        $stamp=time().rand(0, 9);
                        if (!file_exists("/home/wwwroot/1cf/domain/1cf.co/web/i/img/atsast/upload/$uid")) {
                            mkdir("/home/wwwroot/1cf/domain/1cf.co/web/i/img/atsast/upload/$uid", 0777, true);
                        }
                        file_put_contents("/home/wwwroot/1cf/domain/1cf.co/web/i/img/atsast/upload/$uid/[$stamp]".$_FILES['file']['name'], $filestream);
                        $link="{$this->ATSAST_CDN}/img/atsast/upload/$uid/[$stamp]".$_FILES['file']['name'];
                    } else {
                        ERR::Catcher(1005);
                    }

                    if (empty($homework_submit_status)) {
                        $submit_time=date("Y-m-d H:i:s");
                        $newrow=array(
                            "cid"=>$cid,
                            "hid"=>$hid,
                            "syid"=>$syid,
                            "uid"=>$uid,
                            "submit_content"=>$link,
                            "submit_time"=>$submit_time,
                        );
                        $homework_submit->create($newrow);
                        return SUCCESS::Catcher("提交成功", array("time"=>$submit_time,"file_name"=>"[$stamp]".$_FILES['file']['name'],"file_extension"=>$fileext,"file_link"=>$link));
                    } else {
                        $submit_time=date("Y-m-d H:i:s");
                        $homework_submit->update(
                            array(
                                "hid=:hid and cid=:cid and syid=:syid and uid=:uid",
                                ":cid"=>$cid,
                                ":hid"=>$hid,
                                ":syid"=>$syid,
                                ":uid"=>$uid
                            ),
                            array(
                                "submit_content"=>$link,
                                "submit_time"=>$submit_time,
                            )
                        );
                        SUCCESS::Catcher("重新提交成功", array("time"=>$submit_time,"file_name"=>"[$stamp]".$_FILES['file']['name'],"file_extension"=>$fileext,"file_link"=>$link));
                    }
                }
            } else {
                ERR::Catcher(1004);
            }
        } else {
            ERR::Catcher(1003);
        }
    }

    public function actionRegisterContest()
    {
        if (!arg("contest_id")) ERR::Catcher(1003);
        if (!is_numeric(arg("contest_id"))) ERR::Catcher(1004);
        if (!$this->islogin) ERR::Catcher(2001);
        $uid=$this->userinfo['uid'];
        $coid=arg("contest_id");
        $datas=array();
        $contest=new Model("contest");
        $tmpdb=new Model("user_temp_info");
        $typedb=new Model("contest_require_info");
        $registerdb=new Model("contest_register");
        $result=$typedb->findAll();
        $types=array("contest_id"=>"number");
        $contest=$contest->find(array("contest_id=:coid", ":coid"=>$coid));
        if (empty($contest)) ERR::Catcher(1004);
        $fields=array();
        $requires=array();
        $defaultStatus=$contest['default_register_status'];
        foreach(explode(',',$contest['require_register']) as $require) {
            if (substr($require, 0, 1) == '*') {
                $foo=substr($require,1);
                array_push($fields, $foo);
                array_push($requires, $foo);
            } else {
                array_push($fields, $require);
            }
        }
        foreach($result as $type) {
            $types[$type['name']]=$type['type'];
        }
        $minp=$contest['min_participants'];
        $maxp=$contest['max_participants'];
        if ($maxp>1) {
            if (empty(arg('group_name'))) ERR::Catcher(4004);
            $result=$registerdb->find(array('contest_id=:coid and info like :info and uid<>:uid', ":coid"=>$coid, ":info"=>'%"team_name":"'.arg('group_name').'"%', ":uid"=>$uid));
            if (!empty($result)) ERR::Catcher(4002);
        }
        $inserts=array();
        for($i=0; $i<$maxp; ++$i) {
            if ($i>=$minp) {
                $empty=true;
                if (!isset($_POST[$i])) continue;
                foreach($fields as $field) if (!empty($_POST[$i][$field])) {
                    $empty=false;
                    break;
                }
                if ($empty) continue;
            }
            foreach($requires as $field) if (empty($_POST[$i][$field])) ERR::Catcher(4004);
            $foo=array();
            foreach($fields as $field) if (!empty($_POST[$i][$field])) {
                $foo[$field]=$_POST[$i][$field];
                if ($types[$field]=='number') {
                    if (!preg_match('/^\d+$/', $foo[$field])) ERR::Catcher(4005);
                } elseif ($types[$field]=='email') {
                    if (!preg_match('/^[A-Za-z\d]+([-_.][A-Za-z\d]+)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,4}$/', $foo[$field])) ERR::Catcher(4006);
                }
            }
            if ($i==0) {
                $users = new Model("users");
                $result=$users->find(array("uid=:uid",":uid"=>$uid));
                $foo['SID']=$result['SID'];
                foreach($fields as $field) if (!empty($foo[$field])) {
                    $result=$tmpdb->find(array("uid=:uid and `key`=:key", ":uid"=>$uid, ":key"=>$field));
                    if (empty($result)) {
                        $tmpdb->create(array(
                            "uid"=>$uid,
                            "key"=>$field,
                            "value"=>$foo[$field],
                        ));
                    } else {
                        $tmpdb->update(array(
                            "uid=:uid and `key`=:key",
                            ":uid"=>$uid,
                            ":key"=>$field,
                        ), array(
                            "value"=>$foo[$field],
                        ));
                    }
                }
            } else foreach($inserts as $insert) {
                if ($foo['SID']==$insert['SID']) ERR::Catcher(4003);
            }
            $result=$registerdb->find(array('contest_id=:coid and info like :info and uid<>:uid', ":coid"=>$coid, ":info"=>'%"SID":"'.$foo['SID'].'"%', ":uid"=>$uid));
            if (!empty($result)) ERR::Catcher(4003);
            array_push($inserts, $foo);
        }
        $datas=array();
        if ($maxp>1) $datas['team_name']=arg('group_name');
        $datas['members']=$inserts;
        $result=$registerdb->find(array("uid=:uid and contest_id=:coid", ":uid"=>$uid, ":coid"=>$coid));
        if (empty($result)) {
            $result=$registerdb->create(array(
                "uid"=>$uid,
                "contest_id"=>$coid,
                "info"=>json_encode($datas),
                "status"=>$defaultStatus,
                "register_time"=>date("Y-m-d H:i:s"),
            ));
            if (!$result) ERR::Catcher(1002);
            SUCCESS::Catcher("报名成功", "{$this->ATSAST_DOMAIN}/account/contests");
        }
        $result=$registerdb->update(array(
            "uid=:uid and contest_id=:coid",
            ":uid"=>$uid,
            ":coid"=>$coid,
        ), array(
            "info"=>json_encode($datas),
            "status"=>$defaultStatus,
            "register_time"=>date("Y-m-d H:i:s"),
        ));
        SUCCESS::Catcher("修改成功", "{$this->ATSAST_DOMAIN}/account/contests");
    }

    public function actionRetrievePassword(){
        if(!arg("email")) ERR::Catcher(1003);
        $email=arg("email");
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) ERR::Catcher(1004);
        $users=new Model("users");
        $user_info=$users->find(array("email=:email",":email"=>$email));
        if(empty($user_info)) ERR::Catcher(2002);
        $uid=$user_info['uid'];
        $OPENID=$user_info['OPENID'];
        @$result=AccountController::sendRetrievePasswordEmail($email,$uid,$OPENID,$this->ATSAST_DOMAIN);
        if($result) SUCCESS::Catcher("一封邮件已经发送至您的邮箱，请按照指示进一步操作。");
        else ERR::Catcher(1002);
    }

    public function actionExportContestRegisterInfo() {
        if (!arg('contest_id')) ERR::Catcher(1003);
        if(!$this->islogin) ERR::Catcher(2001);
        $privilege=new Model("privilege");
        $access_right=$privilege->find(array("uid=:uid and type='contest_id' and type_value=:contest_id and clearance>0",":uid"=>$this->userinfo['uid'],":contest_id"=>arg('contest_id')));
        if (empty($access_right)) {
            ERR::Catcher(2003);
        }
        $contest=new Model('contest');
        $result=$contest->find(['contest_id=:contest_id', ':contest_id'=>arg('contest_id')]);
        if (empty($result)) ERR::Catcher(1004);
        $contest_name=$result['name'];
        header('Content-Type: text/comma-separated-values; charset=GBK');
        header(iconv('utf-8', 'GBK', "Content-Disposition: attachment; filename=\"${contest_name}报名信息.csv\""));
        $response='';
        $requires=explode(',', $result['require_register']);
        $max=$result['max_participants'];
        $grouped=$max>1;
        $requirens=array();
        $result=(new Model('contest_require_info'))->findAll();
        foreach($result as $type) {
            $requirens[$type['name']]=$type['placeholder'];
        }
        foreach($requires as $i=>$require) {
            if (substr($require, 0, 1) == '*') $require=$requires[$i]=substr($require, 1);
            if (!$grouped) $response.=$requirens[$require].',';
        }
        if ($grouped) {
            $response.='团队名,状态';
            for($i=0; $i<$max; ++$i) {
                foreach($requires as $require) {
                    $response.=','.$requirens[$require];
                }
            }
        } else $response.='状态';
        $response.="\r\n";
        $registers=(new Model('contest_register'))->findAll(['contest_id=:contest_id', ':contest_id'=>arg('contest_id')]);
        $status=['1'=>'已通过','-1'=>'已拒绝','0'=>'未通过'];
        foreach($registers as $register) {
            $info=json_decode($register['info'], true);
            if (!$grouped && !isset($info['members'])) $info=['members'=>[$info]];
            if ($grouped) $response.=$info['team_name'].','.$status[$register['status']].',';
            foreach($info['members'] as $member) {
                foreach($requires as $require) {
                    if (!isset($member[$require])) $member[$require]='';
                    $response.=$member[$require].',';
                }
            }
            if (!$grouped) $response.=$status[$register['status']];
            $response.="\r\n";
        }
        echo iconv('utf-8', 'GBK', $response);
        exit;
    }
}
