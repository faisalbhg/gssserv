<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaborItemMaster extends Model
{
    use HasFactory;

    protected $table = 'Labor.ItemMaster';

    public function customerDiscount()
    {
        return $this->belongsTo(LaborSalesPrices::class,'ItemId','ServiceItemId');
    }

    public function discountPriceList()
    {
        return $this->hasMany(LaborSalesPrices::class,'ServiceItemCode','ItemCode');
    }
}
