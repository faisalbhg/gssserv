<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customerjobservices extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_number',
        'job_id',
        'service_group_id',
        'service_group_code',
        'service_group_name',
        'service_type_id',
        'service_type_code',
        'service_type_name',
        'service_item',
        'item_id',
        'item_code',
        'item_name',
        'brand_id',
        'brand_name',
        'category_id',
        'category_name',
        'item_group_id',
        'product_group_name',
        'coupon_used',
        'coupon_type',
        'coupon_code',
        'coupon_amount',
        'total_price',
        'quantity',
        'vat',
        'grand_total',
        'job_status',
        'job_departent',
        'is_added',
        'is_removed',
        'created_by',
        'updated_by',
        'is_active',
        'is_blocked',
        'created_at',
        'uppdated_at',
        'pre_finishing',
        'pre_finishing_time_in',
        'pre_finishing_time_out',
        'finishing',
        'finishing_time_in',
        'finishing_time_out',
        'glazing',
        'glazing_time_in',
        'glazing_time_out',
        'seat_cleaning',
        'seat_cleaning_time_in',
        'seat_cleaning_time_out',
        'interior',
        'interior_time_in',
        'interior_time_out',
        'oil_change',
        'oil_change_time_in',
        'oil_change_time_out',
        'wash_service',
        'wash_service_time_in',
        'wash_service_time_out'
    ];

    public function customerJobServiceLogs()
    {
        return $this->hasMany(Customerjoblogs::class,'customer_job_service_id','id');
    }
}
