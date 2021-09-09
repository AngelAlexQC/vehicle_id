<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class RecordsExport implements FromCollection
{
    private $records;

    public function __construct($records)
    {
        $this->records = $records;
    }

    public function collection()
    {
        return $this->records;
    }
}
