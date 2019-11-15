<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ContestRegistersExport implements WithMultipleSheets
{
    use Exportable;

    private $contest;

    public function __construct($contest)
    {
        $this->contest   = $contest;
    }

    public function sheets() : array {
        return [
            new ContestRegistersSheet($this->contest,  true, '审核通过'),
            new ContestRegistersSheet($this->contest, false, '所有')
        ];
    }
}
