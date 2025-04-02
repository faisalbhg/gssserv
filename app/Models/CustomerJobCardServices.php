<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerJobCardServices extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_number',
        'job_id',
        'item_id',
        'item_code',
        'company_code',
        'category_id',
        'sub_category_id',
        'brand_id',
        'bar_code',
        'item_name',
        'description',
        'extra_note',
        'service_item_type',
        'division_code',
        'department_code',
        'section_name',
        'department_name',
        'section_code',
        'station',
        'is_package',
        'package_code',
        'package_number',
        'customer_discount_id',
        'discount_id',
        'discount_unit_id',
        'discount_code',
        'discount_title',
        'discount_percentage',
        'discount_amount',
        'discount_start_date',
        'discount_end_date',
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
        'wash_service_time_out',
        'tinting_service',
        'tinting_time_in',
        'tinting_time_out',
        'service_time_in',
        'service_time_out',
        'is_added',
        'is_removed',
        'is_updated',
        'created_by',
        'updated_by',
        'is_active',
        'is_blocked',
        'created_at',
        'uppdated_at',
        
    ];

    public function jobInfo()
    {
        return $this->belongsTo(CustomerJobCards::class, 'job_number', 'job_number');
    }

    public function customerJobServiceLogs()
    {
        return $this->hasMany(CustomerJobCardServiceLogs::class,'customer_job__card_service_id','id');
    }
}
