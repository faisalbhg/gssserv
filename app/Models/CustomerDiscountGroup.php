<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDiscountGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'vehicle_id',
        'discount_id',
        'discount_unit_id',
        'discount_code',
        'discount_title',
        'discount_card_imgae',
        'discount_card_number',
        'discount_card_validity',
        'employee_code',
        'employee_name',
        'groupType',
        'is_active',
        'is_default',
        'is_deleted',
        'deleted_at',
        'created_at',
        'updated_at',
    ];
}
