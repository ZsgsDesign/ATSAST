<?php

namespace App\Models\Eloquents;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    protected $table = 'contest';
    protected $primaryKey = 'contest_id';
    public $timestamps = false;

    public function organization()
    {
        return $this->belongsTo('App\Models\Eloquents\Organization','creator','oid');
    }

    public function registers()
    {
        return $this->hasMany('App\Models\Eloquents\ContestRegister','contest_id','contest_id');
    }

    public function details()
    {
        return $this->hasMany('App\Models\Eloquents\ContestDetail','contest_id','contest_id');
    }

    public function getParseDateAttribute()
    {
        if($this->start_date == $this->end_date) {
            return $this->start_date;
        }else{
            return $this->start_date.'~'.$this->end_date;
        }
    }

    public function getRequirementsAttribute()
    {
        return explode(',', $this->require_register);
    }

    public function userIsRegister($user_id)
    {
        $user = User::find($user_id);
        if(!empty($user)){
            return $this->registers()->where('uid', $user->id)
                ->orWhere('info','like',$user->SID)->count();
        }else{
            return false;
        }
    }
}
