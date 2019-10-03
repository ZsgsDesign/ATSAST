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
}
