<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolModel extends Model
{
    public static function bing_img_url()
    {
        $str = file_get_contents('http://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1&mkt=zh-CN');
        $array = json_decode($str);
        $imgurl=$array->{"images"}[0]->{"url"};
        return $imgurl;
    }
}
