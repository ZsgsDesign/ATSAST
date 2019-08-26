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
        return DB::table($this->table)->orderBy('create_time', 'desc')->paginate(12);
    }
}
