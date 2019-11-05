<?php

namespace App\Models\Eloquents;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    protected $table = 'privilege';
    protected $primaryKey = 'pid';
    public $timestamps = false;
}
