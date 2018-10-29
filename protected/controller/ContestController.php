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
                $register=new Model("contest_register");

                $basic_info=$contest->query("select contest_id,c.name,creator,`desc`,type,start_date,end_date,`status`,due_register,image,o.`name` creator_name from contest c left join organization o on c.creator = o.oid where c.status=1 and c.contest_id=:contest_id",array(":contest_id"=>$contest_id));
                if(empty($basic_info))$this->jump("/contest");
                $basic_info=$basic_info[0];
                if ($basic_info["start_date"]==$basic_info["end_date"]) {
                    $basic_info["parse_date"]=$basic_info["start_date"];
                } else {
                    $basic_info["parse_date"]=$basic_info["start_date"]." ~ ".$basic_info["end_date"];
                }
                if ($this->islogin) {
                    $userdb=new Model("users");
                    $result=$userdb->find(["uid=:uid", ":uid"=>$this->userinfo['uid']]);
                    $sid=$result['SID'];
                    $basic_info['is_register']=false;
                    $result2=$register->find(["contest_id=:coid and uid=:uid", ":coid"=>$basic_info['contest_id'], ":uid"=>$this->userinfo['uid']]);
                    if (!empty($result2)) {
                        $basic_info['is_register']=true;
                    } else {
                        $result2=$register->find(["contest_id=:coid and info like :info", ":coid"=>$basic_info['contest_id'], ":info"=>'%"SID":"'.$sid.'"%']);
                        if (!empty($result2)) {
                            $basic_info['is_register']=true;
                        }
                    }
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
        $this->url="contest/register";
        $this->title="赛事报名";

        if (arg("contest_id") && is_numeric(arg("contest_id")) && $this->islogin) {
            $coid=arg("contest_id");
            $this->coid=$coid;
            $courses=new Model("contest");
            $registerdb=new Model("contest_register");
            $types=new Model("contest_require_info");
            $userdb=new Model("users");
            $tmpdata=new Model("user_temp_info");
            // $result=$courses->find(array("contest_id=:contest_id",":contest_id"=>$coid));
            // if (empty($result)) $this->jump("/contest");

            $basic_info=$courses->query("select contest_id,c.name,creator,`desc`,type,start_date,end_date,`status`,due_register,image,o.`name` creator_name,require_register,min_participants,max_participants from contest c left join organization o on c.creator = o.oid where c.status=1 and c.contest_id=:contest_id",array(":contest_id"=>$coid));
            if(empty($basic_info))$this->jump("/contest");


            $basic_info=$basic_info[0];
            if ($basic_info["start_date"]==$basic_info["end_date"]) {
                $basic_info["parse_date"]=$basic_info["start_date"];
            } else {
                $basic_info["parse_date"]=$basic_info["start_date"]." ~ ".$basic_info["end_date"];
            }
            $this->basic_info=$basic_info;


            $this->contest_name=$basic_info['name'];
            $this->minp=$minp=$basic_info['min_participants'];
            $this->maxp=$maxp=$basic_info['max_participants'];
            $requirements=explode(',',$basic_info['require_register']);
            $fields=array();
            $result=$types->findAll();
            $types=array();
            $members=array();
            foreach($result as $type) {
                $type['fixed']=$type['name']=='SID';
                unset($type['Id']);
                $types[$type['name']]=$type;
            }
            for($i=0; $i<count($requirements); ++$i) {
                $require=$requirements[$i];
                $required=false;
                if (substr($require, 0, 1) == '*') {
                    $requirements[$i]=$require=substr($require, 1);
                    $required=true;
                }
                assert(isset($types[$require]));
                $types[$require]['required']=$required;
                $fields[$require]=$types[$require];
            }
            $result=$userdb->find(array("uid=:uid",":uid"=>$this->userinfo['uid']));
            $members[0]=array();
            $members[0]['SID']=$result['SID'];
            if (in_array('real_name',$requirements)) $members[0]['real_name']=$result['real_name'];
            $group_name='';
            $registered=false;
            $isleader=false;
            $result=$registerdb->find(array("uid=:uid and contest_id=:coid", ":uid"=>$this->userinfo['uid'], ":coid"=>$coid));
            if (!empty($result)) $registered=$isleader=true;
            elseif ($maxp>1) {
                $result=$registerdb->find(["contest_id=:coid and info like :info", ":coid"=>$coid, ":info"=>'%"SID":"'.$members[0]['SID'].'"%']);
                if (!empty($result)) $registered=true;
            }
            if (!empty($result)) {
                $values=json_decode($result['info'], true);
                if (isset($values['members'])) {
                    $members=$values['members'];
                    if ($maxp>1) $group_name=$values['team_name'];
                } else $members[0]=$values;
                for ($i=0;$i<$maxp;++$i) {
                    if (!isset($members[$i])) $members[$i]=array();
                    foreach($requirements as $req) if(empty($members[$i][$req])) $members[$i][$req]='';
                }
            } else {
                for ($i=0;$i<$maxp;++$i) {
                    if (!isset($members[$i])) $members[$i]=array();
                    foreach($requirements as $req) if(empty($members[$i][$req])) $members[$i][$req]='';
                }
                $result=$tmpdata->findAll(array("uid=:uid",":uid"=>$this->userinfo['uid']));
                foreach($result as $pair) {
                    $members[0][$pair['key']]=$pair['value'];
                }
            }
            $this->group_name=$group_name;
            $this->fields=$fields;
            $this->members=$members;
            $this->registered=$registered;
            $this->isleader=$isleader;
        } else {
            $this->jump("/contest");
        }
    }

}
