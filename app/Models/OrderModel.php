<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderModel extends Model
{
    protected $table='order';

    public function create()
    {
        
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
}
