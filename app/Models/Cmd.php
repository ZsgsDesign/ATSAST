<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Cmd extends Model
{
    public static function setSID()
    {
        $partten = '/^(B|Q)\d{8}$/i';
        $users = User::get();
        foreach($users as $user){
            $email = $user->email;
            $SID = strtoupper(substr($email,0,strpos($email,'@')));
            if(preg_match($partten,$SID)){
                $user->SID = $SID;
                $user->save();
            }
        }
    }
}
