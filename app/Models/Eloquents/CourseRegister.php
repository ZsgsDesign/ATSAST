<?php

namespace App\Models\Eloquents;

use Illuminate\Database\Eloquent\Model;

class CourseRegister extends Model
{
    protected $table = 'course_register';
    protected $primaryKey = 'rid';
    public $timestamps = false;

    public function user(){
        return $this->belongsTo('App\User','uid','id');
    }
}
