<?php

namespace App\Models\Eloquents;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    protected $table = 'privilege';
    protected $primaryKey = 'pid';
    public $timestamps = false;

    protected $guarded = [];

    public static $privilege_map = [
        'course.add' => [
            'type'       => 'system',
            'type_value' => 4,
            'clearance'    => 1
        ],
        'contest.add' => [
            'type'       => 'system',
            'type_value' => 7,
            'clearance'    => 1
        ],
    ];
}
