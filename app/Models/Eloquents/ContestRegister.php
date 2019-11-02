<?php

namespace App\Models\Eloquents;

use Illuminate\Database\Eloquent\Model;

class ContestRegister extends Model
{
    protected $table = 'contest_register';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    public function getInfoAttribute($value)
    {
        return json_decode($value);
    }

    public function setInfoAttribute($value)
    {
        $this->attributes['info'] = json_encode($value);
    }

    public function leader()
    {
        $this->belongsTo('App\User','uid');
    }
}
