<?php
class ContestController extends BaseController
{
    public function actionIndex()
    {
        if (arg("contest_id")) {
            $this->jump("/contest/".arg("contest_id")."/detail");
        } else {
            $this->jump("/contest");
        }
    }

    public function actionDetail()
    {
        $this->url="contest/detail";
        $this->title="活动详情";
        $this->bg="";

        if (arg("contest_id")) {
            $contest_id=arg("contest_id");
            if (is_numeric($contest_id)) {
                $this->contest_id=$contest_id;
                $contest=new Model("contest");
                $contest_detail=new Model("contest_detail");

                $basic_info=$contest->query("select contest_id,c.name,creator,`desc`,type,start_date,end_date,`status`,due_register,image,o.`name` creator_name from contest c left join organization o on c.creator = o.oid where c.status=1 and c.contest_id=:contest_id",array(":contest_id"=>$contest_id));
                if(empty($basic_info))$this->jump("/contest");
                $basic_info=$basic_info[0];
                if ($basic_info["start_date"]==$basic_info["end_date"]) {
                    $basic_info["parse_date"]=$basic_info["start_date"];
                } else {
                    $basic_info["parse_date"]=$basic_info["start_date"]." ~ ".$basic_info["end_date"];
                }
                $this->basic_info=$basic_info;

                $contest_detail_info=$contest_detail->findAll(array("contest_id=contest_id and status=1",":contest_id"=>$contest_id));
                foreach ($contest_detail_info as &$c) {
                    if ($c['type']==0) {
                        $c['content_slashed'] = str_replace('\\', '\\\\', $c['content']);
                        $c['content_slashed'] = str_replace("\r\n", "\\n", $c['content_slashed']);
                        $c['content_slashed'] = str_replace("\n", "\\n", $c['content_slashed']);
                        $c['content_slashed'] = str_replace("\"", "\\\"", $c['content_slashed']);
                        $c['content_slashed'] = str_replace("<", "\<", $c['content_slashed']);
                        $c['content_slashed'] = str_replace(">", "\>", $c['content_slashed']);
                    }
                }
                $this->contest_detail_info=$contest_detail_info;
            } else {
                $this->jump("/contest");
            }
        } else {
            $this->jump("/contest");
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

}
