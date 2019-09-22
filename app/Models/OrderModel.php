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

    public function list()
    {
        $paginator = DB::table('order as o')
        ->join('item as i','o.item_id','=','i.iid')
        ->paginate(20);
        $list = $paginator->all();
        return [
            'paginator'=>$paginator,
            'list'=>$list,
        ];
    }
}
