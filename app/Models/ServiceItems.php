<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceItems extends Model
{
    use HasFactory;

    protected $with = ['itemBrand','itemCategory','productGroup'];

    protected $fillable = [
        'item_code',
        'item_name',
        'item_slug',
        'item_description',
        'search_description',
        'item_image',
        'brand_id',
        'category_id',
        'sub_category_id',
        'product_group_id',
        'product_sub_group_id',
        'unit_messure',
        'is_vat_include',
        'vat',
        'cost_price',
        'sale_price',
        'size',
        'height',
        'width',
        'weight',
        'stock',
        'department_id',
        'section_id',
        'station_id',
        'is_active',
        'is_blocked',
        'created_at',
        'uppdated_at'
    ];



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
    
}
