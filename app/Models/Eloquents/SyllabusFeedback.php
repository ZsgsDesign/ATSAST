<?php

namespace App\Models\Eloquents;

use Illuminate\Database\Eloquent\Model;

class SyllabusFeedback extends Model
{
    protected $table = 'syllabus_feedback';
    protected $primaryKey = 'cfid';
    public $timestamps = false;
}
