<?php

namespace App\Imports;

use App\Models\Stationcode;
use Maatwebsite\Excel\Concerns\ToModel;

class StationImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Stationcode([
            //
        ]);
    }
}
