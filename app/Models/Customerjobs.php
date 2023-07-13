<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customerjobs extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_number',
        'job_date_time',
        'customer_id',
        'customer_type',
        'vehicle_id',
        'vehicle_type',
        'make',
        'vehicle_image',
        'model',
        'plate_number',
        'chassis_number',
        'vehicle_km',
        'station_id',
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
