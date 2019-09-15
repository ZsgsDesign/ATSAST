<?php

namespace App\Models\Eloquents;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public static function id($name)
    {
        $ret = static::where('name',$name)->first();
        if(empty($ret)){
            return -1;
        }else{
            return $ret->id;
        }
    }
}
