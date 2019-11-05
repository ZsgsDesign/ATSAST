<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Cache;
use Storage;
use Auth;

class PastebinModel extends Model
{
    protected $tableName='pastebin';

    public function generatePbCode($length=6)
    {
        $chars='abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789';

        $code='';
        for ($i=0; $i<$length; $i++) {
            $code.=$chars[mt_rand(0, strlen($chars)-1)];
        }
        return $code;
    }

    public function detail($code)
    {
        $basic=DB::table($this->tableName)->where(["code"=>$code])->first();
        if (empty($basic)) {
            return [];
        }
        $basic->userInfo=DB::table("users")->where(["id"=>$basic->uid])->first();
        return $basic;
    }

    public function generate($all_data)
    {
        $lang=$all_data["syntax"];
        $expire=intval($all_data["expiration"]);
        $display_author=$all_data["display_author"];
        $content=$all_data["content"];
        $uid=$all_data["uid"];

        if ($expire==0) {
            $expire_time=null;
        } elseif ($expire==1) {
            $expire_time=date("Y-m-d H:i:s", strtotime('+1 days'));
        } elseif ($expire==7) {
            $expire_time=date("Y-m-d H:i:s", strtotime('+7 days'));
        } elseif ($expire==30) {
            $expire_time=date("Y-m-d H:i:s", strtotime('+30 days'));
        }

        $code=$this->generatePbCode(6);
        $ret=$this->detail($code);
        if (empty($ret)) {
            DB::table($this->tableName)->insert([
                'lang' => $lang,
                'display_author' => $display_author,
                'uid' => $uid,
                'expire' => $expire_time,
                'content' => $content,
                'code' => $code,
            ]);
            return $code;
        } else {
            return null;
        }
    }
}
