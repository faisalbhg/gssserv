<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaborItemMaster extends Model
{
    use HasFactory;

    protected $table = 'Labor.ItemMaster';
    protected $primaryKey = 'ItemId';

    public function customerDiscount()
    {
        return $this->belongsTo(LaborSalesPrices::class,'ItemId','ServiceItemId');
    }

    public function discountPriceList()
    {
        return $this->hasMany(LaborSalesPrices::class,'ServiceItemCode','ItemCode');
    }

    public function discountServicePrice(){
        return $this->belongsTo(LaborSalesPrices::class,'ItemId','ServiceItemId');
    }

    public function discountServicePriceList(){
        return $this->hasMany(LaborSalesPrices::class,'ServiceItemId','ItemId');
    }
}
