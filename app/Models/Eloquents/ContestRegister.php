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
        return json_decode($value,true);
    }

    public function setInfoAttribute($value)
    {
        $this->attributes['info'] = json_encode($value);
    }

    public function getTeamNameAttribute()
    {
        return $this->info['team_name'] ?? '';
    }

    public function getMembersAttribute()
    {
        $members = $this->info['members'];
        $requirements = $this->contest->register_require;
        foreach($members as &$member){
            foreach ($requirements as $requirement) {
                if(!isset($member[$requirement['name']])) {
                    $member[$requirement['name']] = '';
                }
            }
        }
        if(count($members) < $this->contest->max_participants) {
            foreach(range(count($members),$this->contest->max_participants-1) as $n) {
                array_push($members,$this->contest->empty_member);
            }
        }
        return $members;
    }

    public function leader()
    {
        return $this->belongsTo('App\User','uid');
    }

    public function contest()
    {
        return $this->belongsTo('App\Models\Eloquents\Contest','contest_id','contest_id');
    }
}
