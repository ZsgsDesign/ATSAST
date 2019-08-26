<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ItemModel extends Model
{
    protected $table='item';

    public function getItems(){
        $paginator = DB::table($this->table)->orderBy('create_time', 'desc')->paginate(12);
        $list = $paginator->all();
        return [
            'paginator'=>$paginator,
            'list'=>$list,
        ];
    }
}
