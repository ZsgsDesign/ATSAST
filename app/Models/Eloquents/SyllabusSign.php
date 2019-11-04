<?php

namespace App\Models\Eloquents;

use Illuminate\Database\Eloquent\Model;

class SyllabusSign extends Model
{
    protected $table = 'syllabus_sign';
    protected $primaryKey = 'signid';
    public $timestamps = false;
}
