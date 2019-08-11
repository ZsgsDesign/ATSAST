<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use grubersjoe\BingPhoto;
use Cache;
use Storage;

class AccountModel extends Model
{
    public function getPassword($email)
    {
        return DB::table('users')->where('email','=',$email)->get()->first()->password;
    }

    public function updatePassword($email, $password)
    {
        return DB::table('users')->where('email','=',$email)->update(['password'=>Hash::make($password)]);
    }
}
