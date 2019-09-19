<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ItemModel extends Model
{
    protected $table = 'item';
    const CREATED_AT = 'create_time';
    protected $primaryKey = 'iid';

    //scode: -1=>下架; -2=>删除;

    public function getItems(){
        $paginator = DB::table($this->table)->orderBy('order_count', 'desc')->paginate(12);
        $list = $paginator->all();
        return [
            'paginator'=>$paginator,
            'list'=>$list,
        ];
    }

    public function detail($iid)
    {
        return DB::table($this->table)->where('iid','=',$iid)->first();
    }

    public function existIid($iid)
    {
        return DB::table($this->table)->where('iid','=',$iid)->count();
    }

    public function removeItem($iid)
    {
        return DB::table($this->table)->where('iid','=',$iid)->update([
            'scode'=>'-1'
        ]);
    }

    public function restoreItem($iid)
    {
        $count = DB::table($this->table)->where('iid','=',$iid)->get()->first()->count;
        if($count==0){
            return DB::table($this->table)->where('iid','=',$iid)->update([
                'scode'=>'0'
            ]);
        }else{
            return DB::table($this->table)->where('iid','=',$iid)->update([
                'scode'=>'1'
            ]);
        }
    }
}
