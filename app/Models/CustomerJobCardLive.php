<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerJobCardLive extends Model
{
    use HasFactory;

    protected $connection = 'mysql_third';
    protected $table = 'customer_job_cards';
    

    protected $fillable = [
        'job_number',
        'job_date_time',
        'customer_id',
        'customer_name',
        'customer_mobile',
        'customer_email',
        'customer_trn',
        'vehicle_id',
        'vehicle_type',
        'make',
        'vehicle_image',
        'model',
        'plate_number',
        'chassis_number',
        'vehicle_km',
        'ql_km_range',
        'is_contract',
        'contract_id',
        'contract_code',
        'validate_name',
        'validate_number',
        'validate_id',
        'ct_number',
        'meter_id',
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
        'vat',
        'grand_total',
        'payment_type',
        'payment_status',
        'payment_request',
        'payment_response',
        'meterialRequestResponse',
        'payment_link',
        'job_create_status',
        'job_status',
        'job_departent',
        'created_by',
        'updated_by',
        'is_active',
        'is_blocked',
        'created_at',
        'uppdated_at',
    ];
}
