<?php

namespace App\Models\Eloquents;

use Illuminate\Database\Eloquent\Model;

class Syllabus extends Model
{
    protected $table = 'syllabus';
    protected $primaryKey = 'syid';
    public $timestamps = false;
}
