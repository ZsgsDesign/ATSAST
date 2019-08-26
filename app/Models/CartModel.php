<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CartModel extends Model
{
    protected $tableName='cart';

    public function add($uid, $iid, $count)
    {
        $ret = DB::table('cart')->where('user','=',$uid)->where('item_id','=',$iid)->get()->first();
        if(empty($ret)){
            return DB::table('cart')->insertGetId([
                'user'=>$uid,
                'item_id'=>$iid,
                'count'=>$count,
            ]);
        }else{
            DB::table('cart')->where('user','=',$uid)->where('item_id','=',$iid)->delete();
            return DB::table('cart')->insertGetId([
                'user'=>$uid,
                'item_id'=>$iid,
                'count'=>$count+$ret->count,
            ]);
        }
    }
}
