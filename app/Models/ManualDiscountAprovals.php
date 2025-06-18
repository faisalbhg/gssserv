<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManualDiscountAprovals extends Model
{
    use HasFactory;

    protected $fillable = [
        'manual_discount_value',
        'manual_discount_percentage',
        'manual_discount_applied_by',
        'manual_discount_applied_datetime',
        'customer_id',
        'vehicle_id',
        'customer_name',
        'customer_mobile',
        'customer_email',
        'customer_trn',
        'make',
        'vehicle_image',
        'model',
        'plate_number',
        'station',
        'discount_status',
        'created_by',
        'updated_by',
        'is_active',
    ];
}
