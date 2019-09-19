<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ItemModel extends Model
{
    protected $table = 'item';
    const CREATED_AT = 'create_time';
    protected $primaryKey = 'iid';

    public function getItems(){
        $paginator = DB::table($this->table)->orderBy('order_count', 'desc')->paginate(12);
        $list = $paginator->all();
        return [
            'paginator'=>$paginator,
            'list'=>$list,
        ];
    }
}
