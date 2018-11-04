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
            ERR::Catcher(2002);
        } else {
            SUCCESS::Catcher("登录成功", array(
                "details"=>$result,
                "timestamp"=>$submit_time
            ));
        }
    }
}
