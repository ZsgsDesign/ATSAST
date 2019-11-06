<?php

namespace App\Models\Eloquents;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    protected $table = 'contest';
    protected $primaryKey = 'contest_id';
    public $timestamps = false;

    protected $fillable = ['name','creator','desc','start_date','end_date','due_register','type','require_register','image','min_participants','max_participants','status','tips'];

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

    public function getIsMultiplayerAttribute()
    {
        return $this->max_participants > 1;
    }

    public function getRegisterRequireAttribute()
    {
        $requirements = explode(',',$this->require_register);
        foreach ($requirements as $requirement) {
            if(substr($requirement,0,1) == '*'){
                $requires[] = [
                    'required' => true,
                    'name'     => substr($requirement,1)
                ];
            }else{
                $requires[] = [
                    'required' => false,
                    'name'     => $requirement
                ];
            }
        }
        return $requires;
    }

    public function getFieldsAttribute()
    {
        $requirements = $this->register_require;
        foreach($requirements as $requirement) {
            $require_info = ContestRequireInfo::where('name',$requirement['name'])->first();
            $fields[] = [
                'name'        => $require_info->name,
                'type'        => $require_info->type,
                'placeholder' => $require_info->placeholder,
                'help'        => $require_info->help,
                'fixed'       => $require_info->fixed,
                'required'    => $requirement['required']
            ];
        }
        return $fields;
    }

    public function getEmptyMemberAttribute()
    {
        $form = [];
        $requirements = $this->register_require;
        foreach($requirements as $requirement) {
            $form[$requirement['name']] = '';
        }
        return $form;
    }

    public function userEmptyMembers($user_id)
    {
        $user = User::find($user_id);
        if(empty($user)){
            return null;
        }
        $members = [$this->empty_member];
        $requirements = array_column($this->register_require,'name');
        foreach($requirements as $requirement){
            if($requirement == 'SID') {
                $members[0][$requirement] = $user->SID;
            }elseif($requirement == 'real_name') {
                $members[0][$requirement] = $user->real_name;
            }else{
                $members[0][$requirement] = '';
            }
        }
        if($this->max_participants > 1) {
            foreach(range(1,$this->max_participants - 1) as $n) {
                array_push($members,$this->empty_member);
            }
        }
        return $members;
    }

    public function userRegister($user_id)
    {
        $user = User::find($user_id);
        if(!empty($user)){
            return $this->registers()->where(function($query) use ($user) {
                $query->where('uid', $user->id)->orWhere('info','like','%"SID":"'.$user->SID.'"%');
            })->first();
        }else{
            return null;
        }
    }
}
