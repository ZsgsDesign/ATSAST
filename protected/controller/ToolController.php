<?php
class ToolController extends BaseController
{
    public function actionInfo()
    {
        $this->title="系统信息";
        $this->url="admin/tool/info";
        $this->bg=null;

        if ($this->islogin) {
            $OPENID=$_SESSION['OPENID'];
        } else {
            return $this->jump("{$this->ATSAST_DOMAIN}/");
        }
        
        $detail=getuserinfo($OPENID);

        $privilege=new Model("privilege");
        $access_right=$privilege->find(array("uid=:uid and type='system' and type_value=1",":uid"=>$detail['uid']));

        if ($access_right) {
            ;
        } else {
            return $this->jump("{$this->ATSAST_DOMAIN}/");
        }

        $this->server_info=php_uname();
        $this->server_os=php_uname('s')." ".php_uname('r');
        $this->server_name=explode(" ", php_uname())[1];

        $sys_run_time='';
        if (false === ($str = @file("/proc/uptime"))) $sys_run_time="未知";
        else {
            $str = explode(" ", implode("", $str));
            $str = trim($str[0]);
            $min = $str / 60;
            $hours = $min / 60;
            $days = floor($hours / 24);
            $hours = floor($hours - ($days * 24));
            $min = floor($min - ($days * 60 * 24) - ($hours * 60));
            if ($days !== 0) {
                $sys_run_time .= $days."天";
            }
            if ($hours !== 0) {
                $sys_run_time .= $hours."小时";
            }
            if ($min !== 0) {
                $sys_run_time .= $min."分钟";
            }
        }

        $this->sys_run_time=$sys_run_time;

        $this->env_time=date("Y").'年'.date("m").'月'.date("d").'日 '.date("G").'时'.date("i").'分'.date("s").'秒';
        
        @$utc=fsockopen('time.nist.gov',13,$errno,$errstr,5);  
        @$utc_time=fread($utc,2010);
        if($utc_time)$this->utc_time=$utc_time;
        else $this->utc_time="请求时间服务器失败";

        $this->php_version=PHP_VERSION;
        $this->zend_version=Zend_Version();
        $this->php_sapi=php_sapi_name();
    }

    public function actionVerify()
    {
        $this->title="身份验证";
        $this->url="admin/tool/verify";
        $this->bg=null;

        if ($this->islogin) {
            $OPENID=$_SESSION['OPENID'];
        } else {
            return $this->jump("{$this->ATSAST_DOMAIN}/");
        }
        
        $detail=getuserinfo($OPENID);

        $privilege=new Model("privilege");
        $access_right=$privilege->find(array("uid=:uid and type='system' and type_value=2",":uid"=>$detail['uid']));

        if ($access_right) {
            ;
        } else {
            return $this->jump("{$this->ATSAST_DOMAIN}/");
        }

        $users=new Model("users");
        $this->verify_entry=$users->findAll(["title<>''","uid ASC"]);
    }

    public function actionColor()
    {
        $this->title="调色板";
        $this->url="admin/tool/color";
        $this->bg=null;

        if ($this->islogin) {
            $OPENID=$_SESSION['OPENID'];
        } else {
            return $this->jump("{$this->ATSAST_DOMAIN}/");
        }
        
        $detail=getuserinfo($OPENID);

        $privilege=new Model("privilege");
        $access_right=$privilege->find(array("uid=:uid and type='system' and type_value=3",":uid"=>$detail['uid']));

        if ($access_right) {
            ;
        } else {
            return $this->jump("{$this->ATSAST_DOMAIN}/");
        }
    }

    
    public function actionAdd_Course()
    {
        $this->title="新建课程";
        $this->url="admin/tool/add_course";
        $this->bg=null;

        if ($this->islogin) {
            $OPENID=$_SESSION['OPENID'];
        } else {
            return $this->jump("{$this->ATSAST_DOMAIN}/");
        }
        
        $detail=getuserinfo($OPENID);

        $privilege=new Model("privilege");
        $access_right=$privilege->find(array("uid=:uid and type='system' and type_value=4",":uid"=>$detail['uid']));

        if ($access_right) {
            ;
        } else {
            return $this->jump("{$this->ATSAST_DOMAIN}/");
        }
    }

    public function actionSast_schedule(){
        $this->title="SAST课程表工具";
        $this->url="admin/tool/sast_schedule";
        $this->bg=null;

        if ($this->islogin) {
            $OPENID=$_SESSION['OPENID'];
        } else {
            return $this->jump("{$this->ATSAST_DOMAIN}/");
        }
        
        $detail=getuserinfo($OPENID);

        $privilege=new Model("privilege");
        $access_right=$privilege->find(array("uid=:uid and type='system' and type_value=5",":uid"=>$detail['uid']));

        if ($access_right) {
            ;
        } else {
            return $this->jump("{$this->ATSAST_DOMAIN}/");
        }
        $this->time=date("Y-m-d");
        // $this->schedule=$privilege->query("select * from syllabus as s left join courses c on s.cid = c.cid");

    }
}