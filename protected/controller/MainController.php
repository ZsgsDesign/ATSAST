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
        if (!is_null(arg("page"))) {
            $page=intval(arg("page"));
        } else {
            $page=1;
        }
        $result=$db->findAll(null, "cid asc", '*', array($page, 9, 5));
        $this->pager = $db->page;
        $this->result=$result;
    }

    public function actionCourse()
    {
        $this->jump("{$this->ATSAST_DOMAIN}/courses");
    }
    
    public function actionSystem()
    {
        $this->jump("{$this->ATSAST_DOMAIN}/system/logs");
    }

    public function actionContests()
    {
        $this->url="contests";
        $this->title="赛事";
        $contest=new Model("contest");
        $register=new Model("contest_register");
        if ($this->islogin) {
            $userdb=new Model("users");
            $result=$userdb->find(["uid=:uid", ":uid"=>$this->userinfo['uid']]);
            $sid=$result['SID'];
        }
        $result=$contest->query("select contest_id,c.name,creator,`desc`,type,start_date,end_date,`status`,due_register,image,o.`name` creator_name from contest c left join organization o on c.creator = o.oid where c.status=1");
        foreach ($result as &$r) {
            if ($r["start_date"]==$r["end_date"]) {
                $r["parse_date"]=$r["start_date"];
            } else {
                $r["parse_date"]=$r["start_date"]." ~ ".$r["end_date"];
            }
            if ($this->islogin) {
                $r['is_register']=false;
                $result2=$register->find(["contest_id=:coid and uid=:uid", ":coid"=>$r['contest_id'], ":uid"=>$this->userinfo['uid']]);
                if (!empty($result2)) {
                    $r['is_register']=true;
                } else {
                    $result2=$register->find(["contest_id=:coid and info like :info", ":coid"=>$r['contest_id'], ":info"=>'%"SID":"'.$sid.'"%']);
                    if (!empty($result2)) {
                        $r['is_register']=true;
                    }
                }
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
            $this->jump("{$this->ATSAST_DOMAIN}/");
        } else {
            $this->keyword=$keyword;
        }
    }

    public function actionAccount()
    {
        $this->jump("{$this->ATSAST_DOMAIN}/account/");
    }

    public function actionAdmin()
    {
        $this->jump("{$this->ATSAST_DOMAIN}/admin/");
    }
}
