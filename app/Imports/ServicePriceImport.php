<?php

namespace App\Imports;

use App\Models\ServicesPrices;
use App\Models\ServiceMaster;
use App\Models\Customertype;
use App\Models\Stationcode;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMappedCells;


use Carbon\Carbon;
use Session;


class ServicePriceImport implements ToModel, WithHeadingRow
{
    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
        return new ServicesPrices([
            'service_id' => ServiceMaster::where('service_code', $row['service_code'])->pluck('id')->first(),
            'service_code' => $row['service_code'],
            'customer_type' => Customertype::where('customer_type', $row['customer_types'])->pluck('id')->first(),
            'unit_price' => $row['unit_price'],
            'min_price' => $row['min_price'],
            'max_price' => $row['max_price'],
            'discount_type' => $row['discount_type'],
            'discount_value' => $row['discount_value'],
            'discount_amount' => $row['discount_amount'],
            'final_price_after_dicount' => $row['final_price_after_dicount'],
            'start_date'=> Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['start_date']))->format('Y-m-d H:i:s'),
            'end_date'=> Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['end_date']))->format('Y-m-d H:i:s'),
            'station_id'=> Stationcode::where('station_code', $row['station_code'])->pluck('id')->first(),
            'is_active'=> $row['is_active'],
            'created_by'=> Session::get('user')->id,
            'created_at'=> Carbon::now(),
        ]);
    }
}
