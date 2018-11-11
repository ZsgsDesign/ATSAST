<?php

class ApiController extends BaseController
{
    public function actionVersion()
    {
        $submit_time=date("Y-m-d H:i:s");
        SUCCESS::Catcher("ATSAST General Application Programming Interface", array(
            "name"=>"AGAPI ".$this->version_info["version"],
            "version_info"=>$this->version_info,
            "timestamp"=>$submit_time
        ));
    }

    public function actionLogin()
    {
        $email=arg("email");
        $password=arg("password");
        $submit_time=date("Y-m-d H:i:s");
        
        if (empty($password) || empty($email)) {
            ERR::Catcher(1003);
        }

        $OPENID=sha1(strtolower($email)."@SAST+1s".md5($password));
        $db=new Model("users");
        $result=$db->find(array("OPENID=:OPENID",":OPENID"=>$OPENID));
        if (empty($result)) {
            ERR::Catcher(2004);
        } else {
            SUCCESS::Catcher("登录成功", array(
                "details"=>$result,
                "timestamp"=>$submit_time
            ));
        }
    }

    public function actionBatchRegister(){
        // exit("Forbidden");

        $tmp=new Model("temp");
        $tmp_all=$tmp->findAll();
        foreach ($tmp_all as $temp) {
            $users=new Model("users");
            $userinfo=$users->find(array("SID=:SID",":SID"=>$temp['SID']));
            $uid=$userinfo['uid'];
            $coid=1;
            $datas=array();
            $contest=new Model("contest");
            $tmpdb=new Model("user_temp_info");
            $typedb=new Model("contest_require_info");
            $registerdb=new Model("contest_register");
            $result=$registerdb->find(array('contest_id=:coid and info like :info and uid<>:uid', ":coid"=>$coid, ":info"=>'%"SID":"'.$temp['SID'].'"%', ":uid"=>$uid));
            if (empty($result)) {

                $inserts=array(
                    array(
                        "SID"=>$temp['SID'],
                        "real_name"=>$userinfo['real_name'],
                        "phone"=>$temp['phone'],
                        "qq"=>$temp['qq'],
                        "contact_email"=>$temp['contact_email'],
                    )
                );

                $datas=array();
                $datas['members']=$inserts;

                $result=$registerdb->create(array(
                    "uid"=>$uid,
                    "contest_id"=>$coid,
                    "info"=>json_encode($datas),
                    "status"=>1,
                    "register_time"=>date("Y-m-d H:i:s"),
                ));
            }
        }
    }
}
