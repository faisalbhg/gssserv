<?php

namespace App\Exports;

use App\Models\Stationcode;
use Maatwebsite\Excel\Concerns\FromCollection;

class StationExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Stationcode::all();
    }
}
