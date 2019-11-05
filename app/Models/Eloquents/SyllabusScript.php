<?php

namespace App\Models\Eloquents;

use Illuminate\Database\Eloquent\Model;

class SyllabusScript extends Model
{
    protected $table = 'syllabus_script';
    protected $primaryKey = 'scid';
    public $timestamps = false;

    protected $fillable = ['cid','syid','content'];

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
