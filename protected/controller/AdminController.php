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
    }
}