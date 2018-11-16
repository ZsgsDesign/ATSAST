<?php
class UserController extends BaseController
{
    public function actionInfo()
    {
        $this->url="contests";
        $this->site="用户信息";

        if (arg("uid") && is_numeric(arg("uid"))) {
            $uid=intval(arg("uid"));
            $users=new Model("users");
            $instructor=new Model("instructor");
            $course_register=new Model("course_register");
            $contest_register=new Model("contest_register");
            $user_info=$users->find(["uid=:uid",":uid"=>$uid]);
            if (empty($user_info)) {
                return header("HTTP/1.0 404 Not Found");
            }
            if ($user_info["gender"]==1) {
                $user_info["gender_word"]="他";
            } elseif ($user_info["gender"]==2) {
                $user_info["gender_word"]="她";
            } else {
                $user_info["gender_word"]="Ta";
            }
            $user_info["instructor"]=$instructor->findCount(["uid"=>$uid]);
            $user_info["course_register"]=$course_register->findCount(["uid"=>$uid]);
            $user_info["contest_register"]=$contest_register->findCount(["uid"=>$uid]);
            if ($user_info['album']=="bing") {
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
            $this->user_info=$user_info;
        } else {
            $this->jump("{$this->ATSAST_DOMAIN}");
        }
    }
}
