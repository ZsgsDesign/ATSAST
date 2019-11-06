<?php

namespace App\Models\Eloquents;

use Illuminate\Database\Eloquent\Model;

class ContestDetail extends Model
{
    protected $table = 'contest_detail';
    protected $primaryKey = 'cdid';
    public $timestamps = false;

    protected $fillable = ['type','content','status'];

    public function getSlashContentAttribute()
    {
        $content = $this->content;
        $slash_map = [
            '\\'    => '\\\\',
            '\r\n'  => '\\n',
            '\n'    => '\\n',
            '\"'    => '\\\"',
            '<'     => '\<',
            '>'     => '\>'
        ];
        foreach($slash_map as $old => $new){
            $content = str_replace($old,$new,$content);
        }
        return $content;
    }
}
