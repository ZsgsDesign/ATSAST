<?php

namespace App\Models\Eloquents;

use Illuminate\Database\Eloquent\Model;

class Syllabus extends Model
{
    protected $table = 'syllabus';
    protected $primaryKey = 'syid';
    public $timestamps = false;

    protected $fillable = ['title','time','location','desc','signed','script','homework','feedback','video'];

    public function feedbacks()
    {
        return $this->hasMany('App\Models\Eloquents\SyllabusFeedback','syid','syid');
    }

    public function signs()
    {
        return $this->hasMany('App\Models\Eloquents\SyllabusSign','syid','syid');
    }

    public function syllabus_script()
    {
        return $this->hasOne('App\Models\Eloquents\SyllabusScript','syid','syid');
    }
}
