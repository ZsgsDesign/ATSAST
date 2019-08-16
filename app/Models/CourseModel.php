<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Cache;
use Storage;

class CourseModel extends Model
{
    public function list()
    {
        $paginator = DB::table('courses')->paginate(9);
        $list = $paginator->all();
        return [
            'paginator' => $paginator,
            'list' => $list
        ];
    }
}
