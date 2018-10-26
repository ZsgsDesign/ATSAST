<?php
class UserController extends BaseController {
  function actionInfo() {
    if (arg("uid")) {
      $uid=arg("uid");
      $db=new Model("users");
      $result=$db->find(
        array(
          "uid=:uid",
          ":uid"=>$uid
        )
      );
      @$result['rate']=round($result['cor']/$result['ans']*100,2);
      $uid=$result['uid'];
      $log_db=new Model("log");
      $this->newuserinfo=$result;
      $result=$log_db->query(
        "select count(distinct(gid)) 'cnt' from log where uid=:uid and gid<>0",
        array(":uid"=>$uid)
      );
		  $this->donatecount=$result[0]['cnt'];
    }
  }

}