<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;

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
        return DB::table('cart as c')
        ->select('c.*','i.name','i.owner','i.scode','i.count as item_count','i.pic')
        ->join('item as i','c.item_id','=','i.iid')
        ->get();
    }

    public function existIid($iid,$uid)
    {
        return DB::table('cart')->where('item_id','=',$iid)->where('user','=',$uid)->count();
    }

    public function deleteFromCart($iid,$uid)
    {
        return DB::table('cart')->where('item_id','=',$iid)->where('user','=',$uid)->delete();
    }

    public function getCount($iid,$uid){
        return DB::table('cart')->where('item_id','=',$iid)->where('user','=',$uid)->get()->first()->count;
    }
}
