<?php
class AdminController extends BaseController
{
    public function actionIndex()
    {
        $this->title="管理工具";
        $this->url="admin/index";
        $this->bg=null;

        if ($this->islogin) {
            $OPENID=$_SESSION['OPENID'];
        } else {
            return $this->jump("/");
        }
        
        $detail=getuserinfo($OPENID);

        $privilege=new Model("privilege");
        $access_right=$privilege->find(array("uid=:uid and type='access' and type_value=1",":uid"=>$detail['uid']));

        if ($access_right) {
            ;
        } else {
            return $this->jump("/");
        }

        $courses=new Model("courses");
        $result=$courses->query("select * from privilege as p left join courses c on p.type_value = c.cid where p.type='cid' and p.clearance<>0 and p.uid=:uid order by c.cid asc", array(":uid"=>$detail['uid']));
        $this->result=$result;

        $contest=new Model("contest");
        $contest_result=$contest->query("select c.contest_id,c.name,creator,`desc`,c.type,start_date,end_date,due_register,image,o.`name` creator_name from privilege as p left join contest c on p.type_value=c.contest_id left join organization o on c.creator = o.oid where p.type='contest_id' and p.clearance<>0 and p.uid=:uid and c.status=1 order by c.contest_id asc",array(":uid"=>$this->userinfo['uid']));
        foreach ($contest_result as &$r) {
            if ($r["start_date"]==$r["end_date"]) {
                $r["parse_date"]=$r["start_date"];
            } else {
                $r["parse_date"]=$r["start_date"]." ~ ".$r["end_date"];
            }
            if($r["status"]==1) $r["parse_status"]='<span class="wemd-green-text"><i class="MDI checkbox-marked-circle-outline"></i> 已成功报名</span>';
            else if($r["status"]==0) $r["parse_status"]='<span class="wemd-light-blue-text"><i class="MDI timer-sand"></i> 已提交报名</span>';
            else if($r["status"]==-1) $r["parse_status"]='<span class="wemd-red-text"><i class="MDI alert-circle-outline"></i> 报名已被拒绝</span>';
        }
        $this->contest_result=$contest_result;
    }
}