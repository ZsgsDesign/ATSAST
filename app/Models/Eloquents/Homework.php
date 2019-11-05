<?php

namespace App\Models\Eloquents;

use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    protected $table = 'homework';
    protected $primaryKey = 'hid';
    public $timestamps = false;
}
