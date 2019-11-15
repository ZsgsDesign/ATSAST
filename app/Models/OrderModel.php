<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderModel extends Model
{
    protected $table='order';
    protected $primaryKey = 'oid';
    public $timestamps = false;
    
    public function create()
    {
        DB::table('order')->insert([
            "iid"
        ]);
    }

    public function list($uid)
    {
        $paginator = DB::table('order as o')
        ->select('o.*','i.iid','i.name','i.owner','i.location','i.dec','i.need_return','u.real_name','u.avatar','renter.real_name as renter_real_name','renter.avatar as renter_avatar')
        ->join('item as i','o.item_id','=','i.iid')
        ->join('users as u','u.id','=','i.owner')
        ->join('users as renter','renter.id','=','o.renter_id')
        ->where('o.renter_id','=',$uid)
        ->orWhere('i.owner','=',$uid)
        ->paginate(20);
        $list = $paginator->all();
        return [
            'paginator'=>$paginator,
            'list'=>$list,
        ];
    }

    public function operateOrder($oid,$operation)
    {
        $ret = DB::table('order')->where('oid','=',$oid)->get()->first();
        $item = DB::table('item')->where('iid','=',$ret->item_id)->get()->first();
        if($ret->scode==1&&$operation=="confirm"){
            DB::table('order')->where('oid','=',$oid)->update([
                "scode"=>2
            ]);
            return true;
        }elseif($ret->scode==1&&$operation=="cancel"){
            DB::table('order')->where('oid','=',$oid)->update([
                "scode"=>0
            ]);
            DB::table('item')->where('iid','=',$item->iid)->update([
                "count"=>$ret->count+$item->count
            ]);
            return true;
        }elseif($ret->scode==2&&$operation=="return"){
            DB::table('order')->where('oid','=',$oid)->update([
                "scode"=>3 //留了后门，方便我还东西
            ]);
            DB::table('item')->where('iid','=',$item->iid)->update([
                "count"=>$ret->count+$item->count,
                "order_count"=>$item->order_count+1
            ]);
            return true;
        }else{
            return null;
        }
    }

    public function isOwner($oid,$uid){
        return DB::table('order')->join('item','order.item_id','=','item.iid')->where('oid','=',$oid)->where('owner','=',$uid)->count();
    }

    public function isRenter($oid,$uid){
        return DB::table('order')->where('oid','=',$oid)->where('renter_id','=',$uid)->count();
    }
}
