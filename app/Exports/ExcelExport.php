<?php

namespace App\Exports;

use App\Models\CreateLead;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExcelExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CreateLead::all();
    }
}
