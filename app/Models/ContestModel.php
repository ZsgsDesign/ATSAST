<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Cache;
use Storage;
use Auth;

class ContestModel extends Model
{
    public function list()
    {
        $paginator = DB::table('contest as c')
        ->leftJoin('organization as o', 'c.creator', '=', 'o.oid')
        ->select('contest_id', 'c.name', 'creator', 'desc', 'type', 'start_date', 'end_date', 'status', 'due_register', 'image', 'o.name as creator_name')
        ->orderBy('contest_id', 'desc')
        ->paginate(5);
        $list = $paginator->all();
        foreach($list as $l){
            if ($l->start_date==$l->end_date) {
                $l->parse_date=$l->start_date;
            } else {
                $l->parse_date=$l->start_date." ~ ".$l->end_date;
            }
        }
        if (Auth::check()) {
            $result = DB::table('users')->where('id','=',Auth::user()->id)->get()->first();
            $sid=$result->SID;
            foreach($list as $l){
                $l->is_register=false;
                $result2 = DB::table('contest_register')->where('contest_id','=',$l->contest_id)->where('uid','=',Auth::user()->id)->get()->first();
                if (!empty($result2)) {
                    $l->is_register=true;
                } else {
                    $result2 = DB::table('contest_register')->where('contest_id','=',$l->contest_id)->where('info','like',$sid.'%')->get()->first();
                    if (!empty($result2)) {
                        $l->is_register=true;
                    }
                }
            }
        }
        return [
            'paginator' => $paginator,
            'list' => $list
        ];
    }

    public function existCid($cid)
    {
        return DB::table('contest')->where('contest_id','=',$cid)->count();
    }

    public function detail($contest_id)
    {
        $basic_info = DB::table('contest as c')
        ->select('contest_id','c.name','creator','desc','type','start_date','end_date','status','due_register','image','o.name as creator_name')
        ->leftJoin('organization as o','c.creator','=','o.oid')
        ->where('c.status','=','1')
        ->where('c.contest_id','=',$contest_id)->get()->first();
        if (empty($basic_info)) {
            return null;
        }
        if ($basic_info->start_date==$basic_info->end_date) {
            $basic_info->parse_date=$basic_info->start_date;
        } else {
            $basic_info->parse_date=$basic_info->start_date." ~ ".$basic_info->end_date;
        }
        if (Auth::check()) {
            $result = DB::table('users')->where('id','=',Auth::user()->id)->get()->first();
            $sid=$result->SID;
            $basic_info->is_register=false;
            $result2 = DB::table('contest_register')->where('contest_id','=',$basic_info->contest_id)->where('uid','=',Auth::user()->id)->get()->first();
            if (!empty($result2)) {
                $basic_info->is_register=true;
            } else {
                $result2 = DB::table('contest_register')->where('contest_id','=',$basic_info->contest_id)->where('info','LIKE','%"SID":"'.$sid.'"%')->get()->first();
                if (!empty($result2)) {
                    $basic_info->is_register=true;
                }
            }
        }

        $contest_detail_info = DB::table('contest_detail')->where('contest_id','=',$contest_id)->where('status','=','1')->get();
        foreach ($contest_detail_info as &$c) {
            if ($c->type==0) {
                $c->content_slashed = str_replace('\\', '\\\\', $c->content);
                $c->content_slashed = str_replace("\r\n", "\\n", $c->content_slashed);
                $c->content_slashed = str_replace("\n", "\\n", $c->content_slashed);
                $c->content_slashed = str_replace("\"", "\\\"", $c->content_slashed);
                $c->content_slashed = str_replace("<", "\<", $c->content_slashed);
                $c->content_slashed = str_replace(">", "\>", $c->content_slashed);
            }
        }
        return [
            'contest_id'=>$contest_id,
            'basic_info'=>$basic_info,
            'contest_detail_info'=>$contest_detail_info,
        ];
    }

    public function register($cid)
    {
        // $coid = $cid;
        // $basic_info = DB::table('contest as c')
        // ->select('contest_id','c.name','creator','desc','type','start_date','end_date','status','due_register','image','o.name as creator_name','require_register','min_participants','max_participants','tips')
        // ->leftJoin('organization as o','c.creator','=','o.oid')
        // ->where('c.status','=','1')
        // ->where('c.contest_id','=',$coid)->get()->first();
        // if (empty($basic_info)) {
        //     return null;
        // }
        // if ($basic_info->start_date==$basic_info->end_date) {
        //     $basic_info->parse_date=$basic_info->start_date;
        // } else {
        //     $basic_info->parse_date=$basic_info->start_date." ~ ".$basic_info->end_date;
        // }
        // $contest_name=$basic_info->name;
        // $minp=$basic_info->min_participants;
        // $maxp=$basic_info->max_participants;
        // $requirements=explode(',', $basic_info->require_register);
        // // $fields=array();
        // $result=DB::table('contest_require_info')->get();
        // $types=array();
        // // $members=array();
        // foreach ($result as $type) {
        //     $type->fixed=$type->name=='SID';
        //     unset($type->Id);
        //     $name = $type->name;
        //     $type->$name=$type;
        // }
        // for ($i=0; $i<count($requirements); ++$i) {
        //     $require=$requirements[$i];
        //     $required=false;
        //     if (substr($require, 0, 1) == '*') {
        //         $requirements[$i]=$require=substr($require, 1);
        //         $required=true;
        //     }
        //     $types[$require]['required']=$required;
        //     $fields[$require]=$types[$require];
        // }
        // $result = DB::table('users')->where('id','=',Auth::user()->id)->get()->first();
        // $members[0]=array();
        // $members[0]['SID']=$result->SID;
        // if (in_array('real_name', $requirements)) {
        //     $members[0]['real_name']=$result->real_name;
        // }
        // $group_name='';
        // $registered=false;
        // $isleader=false;
        // $result = DB::table('contest_register')->where('uid','=',Auth::user()->id)->where('contest_id','=',$coid)->get()->first();
        // if (!empty($result)) {
        //     $registered=$isleader=true;
        // } elseif ($maxp>1) {
        //     $result = DB::table('contest_register')->where('contest_id','=',$coid)->where('info','LIKE','%"SID":"'.$members[0]['SID'].'"%')->get()->first();
        //     if (!empty($result)) {
        //         $registered=true;
        //     }
        // }
        // if (!empty($result)) {
        //     $values=json_decode($result->info, true);
        //     if (isset($values['members'])) {
        //         $members=$values['members'];
        //         if ($maxp>1) {
        //             $group_name=$values['team_name'];
        //         }
        //     } else {
        //         $members[0]=$values;
        //     }
        //     for ($i=0;$i<$maxp;++$i) {
        //         if (!isset($members[$i])) {
        //             $members[$i]=array();
        //         }
        //         foreach ($requirements as $req) {
        //             if (empty($members[$i][$req])) {
        //                 $members[$i][$req]='';
        //             }
        //         }
        //     }
        // } else {
        //     for ($i=0;$i<$maxp;++$i) {
        //         if (!isset($members[$i])) {
        //             $members[$i]=array();
        //         }
        //         foreach ($requirements as $req) {
        //             if (empty($members[$i][$req])) {
        //                 $members[$i][$req]='';
        //             }
        //         }
        //     }
        //     $result = DB::table('user_temp_info')->where('uid','=',Auth::user()->id)->get();
        //     foreach ($result as $pair) {
        //         $members[0][$pair->key]=$pair->value;
        //     }
        // }

        $coid = $cid;
        $basic_info = DB::table('contest as c')
        ->select('contest_id','c.name','creator','desc','type','start_date','end_date','status','due_register','image','o.name as creator_name','require_register','min_participants','max_participants','tips')
        ->leftJoin('organization as o','c.creator','=','o.oid')
        ->where('c.status','=','1')
        ->where('c.contest_id','=',$coid)->get()->all();
        $basic_info = (array)$basic_info[0];
        if (empty($basic_info)) {
            return null;
        }
        if ($basic_info["start_date"]==$basic_info["end_date"]) {
            $basic_info["parse_date"]=$basic_info["start_date"];
        } else {
            $basic_info["parse_date"]=$basic_info["start_date"]." ~ ".$basic_info["end_date"];
        }
        $contest_name=$basic_info['name'];
        $minp=$minp=$basic_info['min_participants'];
        $maxp=$maxp=$basic_info['max_participants'];
        $requirements=explode(',', $basic_info['require_register']);
        $fields=array();
        $result=DB::table('contest_require_info')->get()->all();
        foreach($result as &$r){
            $r = (array)$r;
        }
        $types=array();
        $members=array();
        foreach ($result as $type) {
            $type['fixed']=$type['name']=='SID';
            unset($type['Id']);
            $types[$type['name']]=$type;
        }
        for ($i=0; $i<count($requirements); ++$i) {
            $require=$requirements[$i];
            $required=false;
            if (substr($require, 0, 1) == '*') {
                $requirements[$i]=$require=substr($require, 1);
                $required=true;
            }
            $types[$require]['required']=$required;
            $fields[$require]=$types[$require];
        }
        $result = DB::table('users')->where('id','=',Auth::user()->id)->get()->first();
        $result = (array)$result;
        $members[0]=array();
        $members[0]['SID']=$result['SID'];
        if (in_array('real_name', $requirements)) {
            $members[0]['real_name']=$result['real_name'];
        }
        $group_name='';
        $registered=false;
        $isleader=false;
        $result = DB::table('contest_register')->where('uid','=',Auth::user()->id)->where('contest_id','=',$coid)->get()->first();
        $result = (array)$result;
        if (!empty($result)) {
            $registered=$isleader=true;
        } elseif ($maxp>1) {
            $result = DB::table('contest_register')->where('contest_id','=',$coid)->where('info','LIKE','%"SID":"'.$members[0]['SID'].'"%')->get()->first();
            $result = (array)$result;
            if (!empty($result)) {
                $registered=true;
            }
        }
        if (!empty($result)) {
            $values=json_decode($result['info'], true);
            if (isset($values['members'])) {
                $members=$values['members'];
                if ($maxp>1) {
                    $group_name=$values['team_name'];
                }
            } else {
                $members[0]=$values;
            }
            for ($i=0;$i<$maxp;++$i) {
                if (!isset($members[$i])) {
                    $members[$i]=array();
                }
                foreach ($requirements as $req) {
                    if (empty($members[$i][$req])) {
                        $members[$i][$req]='';
                    }
                }
            }
        } else {
            for ($i=0;$i<$maxp;++$i) {
                if (!isset($members[$i])) {
                    $members[$i]=array();
                }
                foreach ($requirements as $req) {
                    if (empty($members[$i][$req])) {
                        $members[$i][$req]='';
                    }
                }
            }
            $result = DB::table('user_temp_info')->where('uid','=',Auth::user()->id)->get()->all();
            foreach($result as &$r){
                $r = (array)$r;
            }
            foreach ($result as $pair) {
                $members[0][$pair->key]=$pair->value;
            }
        }

        return [
            'coid'=>$coid,
            'basic_info'=>$basic_info,
            'contest_name'=>$contest_name,
            'minp'=>$minp,
            'maxp'=>$maxp,
            'group_name'=>$group_name,
            'fields'=>$fields,
            'members'=>$members,
            'registered'=>$registered,
            'isleader'=>$isleader,
        ];
    }
}
