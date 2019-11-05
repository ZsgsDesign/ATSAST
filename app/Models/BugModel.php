<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Cache;
use Storage;

class BugModel extends Model
{
    public function add($data){
        return DB::table('bug')->insertGetId([
            'title' => $data['title'],
            'version' => version(),
            'uid' => $data['uid'],
            'desc' => $data['desc'],
            'status' => 0,
            'release_time' => date("Y-m-d H:i:s"),
        ]);
    }
}
