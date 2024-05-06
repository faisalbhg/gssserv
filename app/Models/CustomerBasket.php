<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerBasket extends Model
{
    use HasFactory;

    protected $fillable = [

        'customer_id',
        'vehicle_id',
        'service_type_id',
        'service_type_name',
        'service_type_code',
        'service_group_id',
        'service_group_name',
        'service_group_code',
        'service_item',
        'item_id',
        'item_code',
        'item_name',
        'brand_id',
        'brand_name',
        'category_id',
        'category_name',
        'item_group_id',
        'item_group_name',
        'product_group_id',
        'section_id',
        'station_id',
        'department_id',
        'price',
        'quantity',
        'save_type',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    public function serviceItems()
    {
        return $this->belongsTo(ServiceItems::class,'item_id','id');
    }
    public function itemBrand()
    {
        return $this->belongsTo(ServiceItemBrand::class,'brand_id','id');
    }
    public function itemCategory()
    {
        return $this->belongsTo(ServiceItemCategory::class,'category_id','id');
    }
    public function productGroup()
    {
        return $this->belongsTo(ItemProductGroup::class,'product_group_id','id');
    }

    public function customerInfo()
    {
        return $this->belongsTo(Customers::class,'customer_id','id')->with(['customertype']);
    }

    public function vehicleInfo()
    {
        return $this->belongsTo(CustomerVehicle::class,'vehicle_id','id');
    }
}
