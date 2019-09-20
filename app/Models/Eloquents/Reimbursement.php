<?php

namespace App\Models\Eloquents;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reimbursement extends Model
{
    use SoftDeletes;

    public static function details($id)
    {
        $r = static::find($id);
        if(empty($r)){
            return null;
        }
        $organization = Organization::find($r->organization_id)->name;
        $department   = Department::find($r->department_id)->name;

        return [
            'title'               => $r->title,
            'content'             => $r->content,
            'money'               => $r->money,
            'organization'        => $organization,
            'department'          => $department,
            'invoice'             => $r->invoice,
            'transaction_voucher' => $r->transaction_voucher,
            'declaration'         => $r->declaration,
            'status'              => $r->status
        ];
    }

    public function logs()
    {
        return $this->hasMany(\App\Models\Eloquents\ReimbursementLog::class);
    }

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
