<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Cache;
use Storage;

class ContestModel extends Model
{
    public function list()
    {
        $paginator = DB::table('contest as c')
        ->leftJoin('organization as o', 'c.creator', '=', 'o.oid')
        ->select('contest_id', 'c.name', 'creator', 'desc', 'type', 'start_date', 'end_date', 'status', 'due_register', 'image', 'o.name as creator_name')
        ->paginate(5);
        $list = $paginator->all();
        // dd($list);
        foreach($list as $l){
            if ($l->start_date==$l->end_date) {
                $l->parse_date=$l->start_date;
            } else {
                $l->parse_date=$l->start_date." ~ ".$l->end_date;
            }
        }
        return [
            'paginator' => $paginator,
            'list' => $list
        ];
    }
}
