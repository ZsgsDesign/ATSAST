<?php

namespace App\Models\Eloquents;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'cid';
    public $timestamps = false;

    public function organization()
    {
        return $this->belongsTo('App\Models\Eloquents\Organization','course_creator','oid');
    }

    public function syllabus()
    {
        return $this->hasMany('App\Models\Eloquents\Syllabus','cid','cid');
    }

    public function is_manager($user_id)
    {
        return true;
    }
}
