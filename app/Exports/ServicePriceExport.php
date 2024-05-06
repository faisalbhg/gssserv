<?php

namespace App\Exports;

use App\Models\ServicesPrices;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ServicePriceExport implements FromCollection, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ServicesPrices::select('services_prices.service_code', 'customertypes.customer_type', 'services_prices.unit_price', 'services_prices.min_price', 'services_prices.max_price', 'services_prices.discount_type', 'services_prices.discount_value', 'services_prices.discount_amount', 'services_prices.final_price_after_dicount', 'services_prices.start_date', 'services_prices.end_date', 'stationcodes.station_code', 'services_prices.is_active')
        ->join('stationcodes','stationcodes.id','=','services_prices.station_id')
        ->join('customertypes','customertypes.id','=','services_prices.customer_type')
        ->take(2)->get();
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["service_code", "customer_types", "unit_price", "min_price", "max_price", "discount_type", "discount_value", "discount_amount", "final_price_after_dicount", "start_date", "end_date", "station_code", "is_active"];
    }

    

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:Z1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12)->setBold(true);
            },
        ];
    }
}
