<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageBookingServices extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_number',
        'package_id',
        'package_code',
        'item_id',
        'item_code',
        'unit_price',
        'discounted_price',
        'discount_percentage',
        'item_type',
        'frequency',
        'is_default',
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
        'section_name',
        'department_name',
        'station',
        'total_price',
        'quantity',
        'vat',
        'grand_total',
        'package_status',
        'is_added',
        'is_removed',
        'created_by',
        'updated_by',
        'is_active',
        'is_blocked',
        'created_at',
        'uppdated_at',
    ];

   
}
