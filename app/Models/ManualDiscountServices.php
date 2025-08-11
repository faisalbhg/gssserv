<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManualDiscountServices extends Model
{
    use HasFactory;

    protected $fillable = [
        'manual_discount_ref_no',
        'item_id',
        'cart_id',
        'item_code',
        'item_name',
        'service_item_type',
        'department_code',
        'department_name',
        'section_code',
        'section_name',
        'unit_price',
        'quantity',
        'manual_discount_value',
        'manual_discount_percentage',
        'manual_discount_applied_by',
        'manual_discount_applied_datetime',
        'manual_discount_send_for_aproval',
        'discount_status',
        'created_by',
        'updated_by',
        'is_active',
    ];
}
