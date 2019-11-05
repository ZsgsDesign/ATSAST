<?php

namespace App\Models\Eloquents;

use Illuminate\Database\Eloquent\Model;

class HomeworkSubmit extends Model
{
    protected $table = 'homework_submit';
    protected $primaryKey = 'hsid';
    public $timestamps = false;
}
