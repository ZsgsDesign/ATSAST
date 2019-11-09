<?php

namespace App\Models\Eloquents;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'cid';
    public $timestamps = false;

    protected $fillable = ['course_name','course_creator','course_logo','course_desc','course_type','course_suitable','course_color'];

    public function organization()
    {
        return $this->belongsTo('App\Models\Eloquents\Organization','course_creator','oid');
    }

    public function syllabus()
    {
        return $this->hasMany('App\Models\Eloquents\Syllabus','cid','cid');
    }

    public function instructors()
    {
        return $this->hasMany('App\Models\Eloquents\Instructor','cid','cid');
    }

    public function details()
    {
        return $this->hasMany('App\Models\Eloquents\CourseDetail','cid','cid');
    }

    public function feedbacks()
    {
        return $this->hasMany('App\Models\Eloquents\SyllabusFeedback','cid','cid');
    }

    public function registers()
    {
        return $this->hasMany('App\Models\Eloquents\CourseRegister','cid','cid');
    }

    public function privileges()
    {
        return $this->hasMany('App\Models\Eloquents\Privilege','type_value','cid')->where('type','cid');
    }

    public function getInstructorEmailsAttribute()
    {
        $emails = [];
        $instructors = $this->instructors;
        foreach ($instructors as $instructor) {
            array_push($emails,$instructor->user->email);
        }
        return $emails;
    }

    public function is_manager($user_id)
    {
        $privilege = $this->privileges()->where('uid',$user_id)->first();
        return !empty($privilege);
    }
}
