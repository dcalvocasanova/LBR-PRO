<?php

namespace App\Exports;

use App\Macroprocess;
use Maatwebsite\Excel\Concerns\FromCollection;

class MacroprocessesTemplateExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Macroprocess::all();
    }
}
