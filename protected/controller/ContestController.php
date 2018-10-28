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
        $this->url="contest/register";
        $this->title="赛事报名";

        if (arg("contest_id") && is_numeric(arg("contest_id")) && $this->islogin) {
            $coid=arg("contest_id");
            $this->coid=$coid;
            $courses=new Model("contest");
            $types=new Model("contest_require_info");
            $userdb=new Model("users");
            $tmpdata=new Model("user_temp_info");
            $result=$courses->find(array("contest_id=:contest_id",":contest_id"=>$coid));
            if (empty($result)) $this->jump("/contest");
            $this->contest_name=$result['name'];
            $requirements=explode(',',$result['require_register']);
            $fields=array();
            $result=$types->findAll();
            // var_dump($result);
            foreach($result as $type) {
                $type['fixed']=$type['name']=='SID';
                if (in_array($type['name'],$requirements)) {
                    $type['required']=false;
                    $fields[$type['name']]=$type;
                } elseif (in_array('*'.$type['name'],$requirements)) {
                    $type['required']=true;
                    $fields[$type['name']]=$type;
                    $requirements[array_search('*'.$type['name'],$requirements)]=$type['name'];
                }
            }
            $result=$userdb->find(array("uid=:uid",":uid"=>$this->userinfo['uid']));
            if (in_array('SID',$requirements)) $fields['SID']['value']=$result['SID'];
            if (in_array('real_name',$requirements)) $fields['real_name']['value']=$result['real_name'];
            $result=$tmpdata->findAll(array("uid=:uid",":uid"=>$this->userinfo['uid']));
            foreach($result as $pair) {
                if (isset($fields[$pair['key']])) {
                    $fields[$pair['key']]['value']=$pair['value'];
                }
            }
            $this->requirements=$requirements;
            $this->fields=$fields;
        } else {
            $this->jump("/contest");
        }
    }

}
