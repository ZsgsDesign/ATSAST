<?php

namespace App\Models\Eloquents;

use Illuminate\Database\Eloquent\Model;

class ReimbursementLog extends Model
{
    protected $table = 'reimbursement_logs';

    public function username() {
        $u = \App\User::find($this->user_id);
        if(!empty($u)){
            if(!empty($u->real_name)){
                return $u->real_name;
            }else{
                return $u->name;
            }
        }else{
            return '未知';
        }
    }
}
