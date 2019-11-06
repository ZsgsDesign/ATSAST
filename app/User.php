<?php

namespace App;

use App\Models\Eloquents\Privilege;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'album', 'cloud_size', 'cur_version',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function privileges()
    {
        return $this->hasMany('App\Models\Eloquents\Privilege','uid','id');
    }

    public function hasAccess($privilege)
    {
        if(in_array($privilege,array_keys(Privilege::$privilege_map))){
            $condition = Privilege::$privilege_map[$privilege];
            $p = Privilege::where($condition)->first();
            if(!empty($p)){
                return true;
            }
        }
        return false;
    }
}
