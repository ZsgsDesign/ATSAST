<?php

namespace App\Models\Eloquents;

use Illuminate\Database\Eloquent\Model;

class ContestRequireInfo extends Model
{
    protected $table = 'contest_require_info';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    public function getFixedAttribute()
    {
        return $this->name == 'SID';
    }
}
