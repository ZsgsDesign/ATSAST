<?php

namespace App\Models\Eloquents;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $table = 'organization';
    protected $primaryKey = 'oid';

    public function hasDepartment($department_id)
    {
        return Department::where([
            'organization_id' => $this->oid,
            'id'              => $department_id
        ])->count();
    }

    public function departments()
    {
        return $this->hasMany('App\Models\Eloquents\Department');
    }
}
