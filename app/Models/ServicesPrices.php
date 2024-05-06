<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicesPrices extends Model
{
    use HasFactory;

    protected $table = 'services_prices';

    protected $fillable = [
        'service_id',
        'service_code',
        'customer_type',
        'vehicle_type',
        'unit_price',
        'min_price',
        'max_price',
        'discount_type',
        'discount_value',
        'discount_amount',
        'final_price_after_dicount',
        'start_date',
        'end_date',
        'department_id',
        'section_id',
        'station_id',
        'created_by',
        'updated_by',
        'is_active',
        'is_deleted',
        'created_at',
        'updated_at',
    ];

    public function serviceInfo()
    {
        return $this->belongsTo(ServiceMaster::class,'service_id','id')->with(['serviceGroup','serviceSectionGroup']);
    }
    
    public function customerType()
    {
        return $this->belongsTo(Customertype::class,'customer_type','id');
    }

    public function stationInfo()
    {
        return $this->belongsTo(Stationcode::class,'station_id','id');
    }
}
