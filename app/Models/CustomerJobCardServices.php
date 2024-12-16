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
        'section_code',
        'station',
        'customer_discount_id',
        'discount_id',
        'discount_unit_id',
        'discount_code',
        'discount_title',
        'discount_percentage',
        'discount_amount',
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
    ];

    public function customerJobServiceLogs()
    {
        return $this->hasMany(CustomerJobCardServiceLogs::class,'customer_job__card_service_id','id');
    }
}
