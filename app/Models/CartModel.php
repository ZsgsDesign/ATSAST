<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CartModel extends Model
{
    protected $table='cart';

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

    public function list($uid)
    {
        return DB::table('cart')->select(DB::raw("SELECT a.*,users.real_name FROM(select cart.*,item.`name`,item.`owner`,item.scode,item.count as item_count FROM cart JOIN item on cart.item_id=item.iid) AS a JOIN users ON a.`owner`=users.uid WHERE `user`=".Auth::user()->id.";"))->get();
    }
}
