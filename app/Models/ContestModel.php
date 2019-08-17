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
}
