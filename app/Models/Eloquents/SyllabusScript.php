<?php

namespace App\Models\Eloquents;

use Illuminate\Database\Eloquent\Model;

class SyllabusScript extends Model
{
    protected $table = 'syllabus_script';
    protected $primaryKey = 'scid';
    public $timestamps = false;
}
