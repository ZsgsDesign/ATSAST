<?php
class MainController extends BaseController
{
    public function actionIndex()
    {
        $this->url="index";
        $this->title="发现";

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
    }

    public function actionCourses()
    {
        $this->url="courses";
        $this->title="课程";
        $db=new Model("courses");
        $result=$db->findAll(null, "cid asc");
        $this->result=$result;
    }

    public function actionCourse()
    {
        $this->jump("/courses");
    }
    
    public function actionSystem()
    {
        $this->jump("/system/logs");
    }

    public function actionContests()
    {
        $this->url="contests";
        $this->title="赛事";
        $contest=new Model("contest");
        $result=$contest->query("select contest_id,c.name,creator,`desc`,type,start_date,end_date,`status`,due_register,image,o.`name` creator_name from contest c left join organization o on c.creator = o.oid where c.status=1");
        foreach ($result as &$r) {
            if ($r["start_date"]==$r["end_date"]) {
                $r["parse_date"]=$r["start_date"];
            } else {
                $r["parse_date"]=$r["start_date"]." ~ ".$r["end_date"];
            }
        }
        $this->result=$result;
    }

    public function actionSearch()
    {
        $this->url="search";
        $this->title="搜索结果";
        $keyword=arg("q");
        if (is_null($keyword)) {
            $this->jump("/");
        } else {
            $this->keyword=$keyword;
        }
    }

    public function actionAccount()
    {
        $this->jump("/account/");
    }

    public function actionAdmin()
    {
        $this->jump("/admin/");
    }
}