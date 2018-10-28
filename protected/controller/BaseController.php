<?php

class BaseController extends Controller
{
    public $layout = "layout.html";
    public function init()
    {
        $this->version_info=array(
            "author"=>"John Zhang",
            "organization"=>"SAST of NJUPT",
            "developer"=>"John Zhang",
            "version"=>"0.3.0 Beta",
            "subversion"=>"201810281706",
        );
        $this->title="";
        // $this->bg="https://1cf.co/searchEngine/img/bg.jpg";
        $this->bg="";
        session_start();
        // error_reporting(0);
        header("Content-type: text/html; charset=utf-8");
        require(APP_DIR.'/protected/include/functions.php');
        $this->islogin=is_login();
        $this->url="";
        if ($this->islogin) {
            $userinfo=getuserinfo(@$_SESSION['OPENID']);
            if (!is_null($userinfo['real_name']) || $userinfo['real_name']==="null") {
                $display=$userinfo['real_name'];
            } else {
                $display=$userinfo['name'];
            }
            $userinfo['display_name']=$display;
            $privilege=new Model("privilege");
            $userinfo['access_admin']=$privilege->find(array("uid=:uid and type='access' and type_value=1",":uid"=>$userinfo['uid']));
            $this->userinfo=$userinfo;
        }
        $current_hour=date("H");
        if ($current_hour<6) {
            $this->greeting="凌晨了";
        } elseif ($current_hour<11) {
            $this->greeting="早上好";
        } elseif ($current_hour<13) {
            $this->greeting="中午好";
        } elseif ($current_hour<18) {
            $this->greeting="下午好";
        } elseif ($current_hour<22) {
            $this->greeting="晚上好";
        } else {
            $this->greeting="深夜了";
        }
    }

    public function tips($msg, $url)
    {
        $url = "location.href=\"{$url}\";";
        echo "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"><script>function sptips(){alert(\"{$msg}\");{$url}}</script></head><body onload=\"sptips()\"></body></html>";
        exit;
    }
    public function jump($url, $delay = 0)
    {
        echo "<html><head><meta http-equiv='refresh' content='{$delay};url={$url}'></head><body></body></html>";
        exit;
    }
    
    public static function err404($controller_name, $action_name)
    {
        header("HTTP/1.0 404 Not Found");
        $controlObj = new BaseController;
        $controlObj->display("404/index.html");
        exit;
    }
}
