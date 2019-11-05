<?php

namespace App\Models\Eloquents;

use Illuminate\Database\Eloquent\Model;

class CourseDetail extends Model
{
    protected $table = 'course_details';
    protected $primaryKey = 'cdid';
    public $timestamps = false;
}
