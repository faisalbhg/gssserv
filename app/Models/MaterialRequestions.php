<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialRequestions extends Model
{
    use HasFactory;

    protected $fillable = [
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
        'cart_item_type',
        'quantity_per_purchase',
        'is_package',
        'package_code',
        'package_number',
        'division_code',
        'department_code',
        'department_name',
        'section_name',
        'section_code',
        'price_id',
        'customer_group_id',
        'customer_group_code',
        'min_price',
        'max_price',
        'start_date',
        'end_date',
        'discount_perc',
        'unit_price',
        'quantity',
        'ml_quantity',
        'save_type',
        'created_by',
        'updated_by',
        'created_at',
        'uppdated_at'
    ];
}
