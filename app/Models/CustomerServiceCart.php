<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerServiceCart extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'vehicle_id',
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
        'division_code',
        'department_code',
        'section_name',
        'is_package',
        'package_code',
        'package_number',
        'department_name',
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
        'save_type',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    public function customerInfo()
    {
        //return $this->belongsTo(Customers::class,'customer_id','id');
        return $this->belongsTo(TenantMasterCustomers::class,'customer_id','TenantId');
    }

    public function vehicleInfo()
    {
        return $this->belongsTo(CustomerVehicle::class,'vehicle_id','id')->with(['makeInfo','modelInfo']);
    }

    
}
