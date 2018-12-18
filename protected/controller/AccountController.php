<?php
class AccountController extends BaseController
{
    private function account_err_report($msg, $current=1)
    {
        $this->current=$current;
        return $this->msg1=$msg;
    }

    public function actionIndex()
    {
        $this->current=0;
        if ($this->islogin) {
            $this->jump("{$this->ATSAST_DOMAIN}/account/profile");
        } else {
            $this->title="登录 / 注册";
        }
        $this->url="ucenter";
        $this->msg1=$this->msg2="";
        $action=arg("action");
        if ($action==="register") { //如果是注册

            $db=new Model("users");
            $password=arg("password");
            $email=arg("email");
            $pattern="/^(\w){6,20}$/";
            if (empty($password) || empty($email)) {
                return self::account_err_report("请不要皮这个系统");
            }
            if (!preg_match($pattern, $password)) {
                return self::account_err_report("请设置6位以上100位以下密码，只能包含字母、数字及下划线");
            }

            if (filter_var($email, FILTER_VALIDATE_EMAIL)==false) {
                return self::account_err_report("请输入合法的邮箱");
            }

            $username=strtoupper(explode('@', $email)[0]);
            $SID=$username;
            $email_domain=explode('@', $email)[1];

            if ($email_domain!="njupt.edu.cn") {
                return self::account_err_report("请使用NJUPT校内邮注册");
            }

            $result=$db->find(array("email=:email",":email"=>$email));

            if ($result) {
                return self::account_err_report("邮箱已被使用");
            }

            $ip=getIP();
            $rtime=date("Y-m-d H:i:s");
            $OPENID=sha1(strtolower($email)."@SAST+1s".md5($password));
            $user=array(
                'rtime'=>$rtime,
                'name'=>$username,
                'SID'=>$SID,
                'password'=>md5($password),
                'email'=>$email,
                'ip'=>$ip,
                'album'=>"bing",
                'cloud_size'=>5,
                'OPENID'=>$OPENID,
                'avatar'=>"https://static.1cf.co/img/avatar/default.png",
                'gender'=>0
            );
            $uid=$db->create($user);
            if (!file_exists("/home/wwwroot/main/domain/static.1cf.co/web/img/atsast/upload/$uid")) {
                mkdir("/home/wwwroot/main/domain/static.1cf.co/web/img/atsast/upload/$uid", 0777, true);
            }
            $_SESSION['OPENID']=$OPENID;
            @sendActivateEmail($email, $OPENID, $this->ATSAST_DOMAIN);
            $this->jump("{$this->ATSAST_DOMAIN}/");

        //echo json_encode($output);
        } elseif ($action==="login") { //如果是登录

            $email=arg("email");
            $password=arg("password");

            if (empty($password) || empty($email)) {
                return self::account_err_report("请不要皮这个系统", 0);
            }

            $OPENID=sha1(strtolower($email)."@SAST+1s".md5($password));
            $db=new Model("users");
            $result=$db->find(array("OPENID=:OPENID",":OPENID"=>$OPENID));
            if (empty($result)) {
                return self::account_err_report("邮箱或密码错误", 0);
            } else {
                $_SESSION['OPENID']=$OPENID;
                $this->jump("{$this->ATSAST_DOMAIN}/");
            }
        }
    }

    public function actionLogout()
    {
        session_unset();
        session_destroy();
        $this->jump("{$this->ATSAST_DOMAIN}/");
    }
    
    public function actionProfile()
    {
        $this->title="用户中心";
        $this->url="account/profile";
        $this->bg=null;
        $users=new Model("users");

        if ($this->islogin) {
            $OPENID=$_SESSION['OPENID'];
        } else {
            return $this->jump("{$this->ATSAST_DOMAIN}/");
        }

        $detail=getuserinfo($OPENID);
        if (!is_null($detail['real_name']) || $detail['real_name']==="null") {
            $display=$detail['real_name'];
        } else {
            $display=$detail['name'];
        }
        $detail['display_name']=$display;
        $this->detail=$detail;

        $course_register=new Model("course_register");
        $result=$course_register->query("select r.cid,course_name,course_logo,course_desc,course_color from course_register as r left join courses c on r.cid = c.cid where r.uid=:uid and status=1 limit 2", array(":uid"=>$this->userinfo['uid']));
        $this->result=$result;

        $contest=new Model("contest");
        $contest_result=$contest->query("select r.contest_id,c.name,creator,`desc`,type,start_date,end_date,r.`status`,due_register,image,o.`name` creator_name from contest_register r left join contest c on r.contest_id=c.contest_id left join organization o on c.creator = o.oid where uid=:uid and c.status=1 limit 2", array(":uid"=>$this->userinfo['uid']));
        foreach ($contest_result as &$r) {
            if ($r["start_date"]==$r["end_date"]) {
                $r["parse_date"]=$r["start_date"];
            } else {
                $r["parse_date"]=$r["start_date"]." ~ ".$r["end_date"];
            }
            if ($r["status"]==1) {
                $r["parse_status"]='<span class="wemd-green-text"><i class="MDI checkbox-marked-circle-outline"></i> 已成功报名</span>';
            } elseif ($r["status"]==0) {
                $r["parse_status"]='<span class="wemd-light-blue-text"><i class="MDI timer-sand"></i> 已提交报名</span>';
            } elseif ($r["status"]==-1) {
                $r["parse_status"]='<span class="wemd-red-text"><i class="MDI alert-circle-outline"></i> 报名已被拒绝</span>';
            }
        }
        $this->contest_result=$contest_result;

        $storage=array();
        $storage["usage"]=getDirSize("/home/wwwroot/main/domain/static.1cf.co/web/img/atsast/upload/{$this->userinfo['uid']}");
        $storage["usage_string"]=sizeConverter($storage["usage"]);
        $storage["tot"]=$detail['cloud_size'];
        $storage["percent"]=$storage["usage"] / ($storage["tot"] * 1024 * 1024) * 100;
        if ($storage["percent"]>=90) {
            $storage["color"]="red";
        } elseif ($storage["percent"]>=60) {
            $storage["color"]="amber";
        } elseif ($storage["percent"]>=40) {
            $storage["color"]="lime";
        } else {
            $storage["color"]="green";
        }
        $this->storage=$storage;

        if ($detail['album']=="bing") {
            $str = file_get_contents('http://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1&mkt=zh-CN');
            $array = json_decode($str);
            $this->imgurl="https://cn.bing.com/".$array->{"images"}[0]->{"url"};
            $copyright=$array->{"images"}[0]->{"copyright"};
            $imginfo=explode(" (", $copyright);
            $this->imgcopyright=trim(rtrim(@$imginfo[1], ")"));
            $imgname=explode("，", $imginfo[0]);
            $this->imgname=@$imgname[0];
            $this->imglocation=@$imgname[1];
            $this->imgcopyrightlink=$array->{"images"}[0]->{"copyrightlink"};
        } else {
            $this->imgurl="{$this->ATSAST_CDN}/img/njupt.jpg";
        }
    }

    public function actionSettings()
    {
        $this->url="account/settings";
        $this->title="用户设置";
        $this->bg="";
        $users=new Model("users");
        if ($this->islogin) {
            $OPENID=$_SESSION['OPENID'];
        } else {
            return $this->jump("{$this->ATSAST_DOMAIN}/");
        }
        $detail=getuserinfo($OPENID);
        $this->detail=$detail;
    }

    public function actionContests()
    {
        $this->url="account/contests";
        $this->title="报名活动";
        $this->bg="";
        $users=new Model("users");

        if ($this->islogin) {
            $OPENID=$_SESSION['OPENID'];
        } else {
            return $this->jump("{$this->ATSAST_DOMAIN}/");
        }


        $detail=getuserinfo($OPENID);
        if (!is_null($detail['real_name']) || $detail['real_name']==="null") {
            $display=$detail['real_name'];
        } else {
            $display=$detail['name'];
        }
        $detail['display_name']=$display;
        $this->detail=$detail;


        $contest=new Model("contest");
        $register_contest_result=$contest->query("select r.contest_id,c.name,creator,`desc`,type,start_date,end_date,r.`status`,due_register,image,o.`name` creator_name from contest_register r left join contest c on r.contest_id=c.contest_id left join organization o on c.creator = o.oid where uid=:uid and c.status=1", array(":uid"=>$this->userinfo['uid']));
        foreach ($register_contest_result as &$r) {
            if ($r["start_date"]==$r["end_date"]) {
                $r["parse_date"]=$r["start_date"];
            } else {
                $r["parse_date"]=$r["start_date"]." ~ ".$r["end_date"];
            }
            if ($r["status"]==1) {
                $r["parse_status"]='<span class="wemd-green-text"><i class="MDI checkbox-marked-circle-outline"></i> 已成功报名</span>';
            } elseif ($r["status"]==0) {
                $r["parse_status"]='<span class="wemd-light-blue-text"><i class="MDI timer-sand"></i> 已提交报名</span>';
            } elseif ($r["status"]==-1) {
                $r["parse_status"]='<span class="wemd-red-text"><i class="MDI alert-circle-outline"></i> 报名已被拒绝</span>';
            }
        }
        $this->register_contest_result=$register_contest_result;
        
        $userdb=new Model("users");
        $sid=$userdb->find(["uid=:uid", ":uid"=>$this->userinfo['uid']])['SID'];
        $attend_contest_result=$contest->query("select r.contest_id,c.name,creator,`desc`,type,start_date,end_date,r.`status`,due_register,image,o.`name` creator_name from contest_register r left join contest c on r.contest_id=c.contest_id left join organization o on c.creator = o.oid where uid<>:uid and info like :info and c.status=1", array(":uid"=>$this->userinfo['uid'], ":info"=>'%"SID":"'.$sid.'"%'));
        foreach ($attend_contest_result as &$r) {
            if ($r["start_date"]==$r["end_date"]) {
                $r["parse_date"]=$r["start_date"];
            } else {
                $r["parse_date"]=$r["start_date"]." ~ ".$r["end_date"];
            }
            if ($r["status"]==1) {
                $r["parse_status"]='<span class="wemd-green-text"><i class="MDI checkbox-marked-circle-outline"></i> 已成功报名</span>';
            } elseif ($r["status"]==0) {
                $r["parse_status"]='<span class="wemd-light-blue-text"><i class="MDI timer-sand"></i> 已提交报名</span>';
            } elseif ($r["status"]==-1) {
                $r["parse_status"]='<span class="wemd-red-text"><i class="MDI alert-circle-outline"></i> 报名已被拒绝</span>';
            }
        }
        $this->attend_contest_result=$attend_contest_result;
    }

    public function actionActivate()
    {
        $this->url="account/activate";
        $this->title="激活账号";
        $this->bg="";

        $this->status="激活失败";
        $this->msg="抱歉，激活出了一些问题。";
        $this->color="danger";
        $this->icon="alert-circle-outline";
        if (arg("act")) {
            $act=arg("act");
            $db=new Model("users");
            $result=$db->find(array("OPENID=:act",":act"=>$act));
            if ($result) {
                $result=$db->update(array("OPENID=:act",":act"=>$act), array("verify_status"=>1,"cloud_size"=>100));
                $this->status="激活成功";
                $this->msg="恭喜，您的邮箱已经在OASIS激活成功。";
                $this->color="success";
                $this->icon="check-circle-outline";
            }
        }
    }

    public function actionRetrieve()
    {
        $this->url="account/retrieve";
        $this->title="找回密码";
        $this->bg="";

        if ($this->islogin) {
            return $this->jump("{$this->ATSAST_DOMAIN}/");
        }

        $password=arg("password");
        $this->step=1;
        $this->status="重置密码";
        $this->msg="请根据提示重置您的密码。";
        $this->color="info";
        $this->icon="lock-outline";
        $this->id=arg("id");
        $this->ret=arg("ret");
        $this->err=false;
        $pattern="/^(\w){6,20}$/";
        if (preg_match($pattern, $password)) {
            $this->step=2;
        } elseif (strlen($password)>0) {
            $this->err="请设置一个长度在6到20之间的密码！";
        }
        if (arg("id") && arg("ret")) {
            if ($this->step==2) {
                $uid=arg("id");
                $ret=arg("ret");
                $db=new Model("users");
                $result=$db->find(array("uid=:uid",":uid"=>$uid));
                if ($result && sha1($result['OPENID'].$uid)==$ret) {
                    $OPENID=sha1(strtolower($result['email'])."@SAST+1s".md5($password));
                    $result=$db->update(array("uid=:uid",":uid"=>$uid), array("OPENID"=>$OPENID,"insecure"=>0));
                    if ($result) {
                        $this->status="重置密码成功";
                        $this->msg="恭喜，您的密码已经在ATSAST重置成功。";
                        $this->color="success";
                        $this->icon="check-circle-outline";
                    }
                } else {
                    $this->status="重置密码失败";
                    $this->msg="抱歉，重置密码出了一些问题。";
                    $this->color="danger";
                    $this->icon="alert-circle-outline";
                }
            }
        } else {
            $this->step=0;
        }
    }
    
    public function actionInsecure()
    {
        $this->url="account/insecure";
        $this->title="修改密码";
        $this->bg="";

        if (!$this->islogin) {
            return $this->jump("{$this->ATSAST_DOMAIN}/");
        }

        $password=arg("password");
        $this->step=1;
        $this->status="修改密码";
        $this->msg="请设置一个新的面密码";
        $this->color="warning";
        $this->icon="account-alert";
        $this->err=false;
        if (strlen($password)>=6 && strlen($password)<=20) {
            $this->step=2;
        } elseif (strlen($password)>0) {
            $this->err="请设置一个长度在6到20之间的密码！";
        }
        if (arg("action")) {
            if ($this->step==2) {
                $uid=$this->userinfo['uid'];
                $db=new Model("users");
                
                $OPENID=sha1(strtolower($this->userinfo['email'])."@SAST+1s".md5($password));
                $result=$db->update(array("uid=:uid",":uid"=>$uid), array("OPENID"=>$OPENID,"insecure"=>0));
                
                if ($result) {
                    $this->status="修改密码成功";
                    $this->msg="恭喜，您的密码已经在ATSAST修改成功。";
                    $this->color="success";
                    $this->icon="check-circle-outline";
                }
            }
        } else {
            $this->step=0;
        }
    }
}
