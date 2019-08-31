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

    public static function history()
    {

    }
}
