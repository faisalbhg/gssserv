<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItemMaster extends Model
{
    use HasFactory;

    protected $table = 'Inventory.ItemMaster';
    protected $primaryKey = 'ItemId';

    
    public function categoryInfo()
    {
        return $this->belongsTo(ItemCategories::class,'CategoryId','CategoryId');
    }

    public function discountItemPrice()
    {
        return $this->belongsTo(InventorySalesPrices::class,'ItemId','ServiceItemId');
    }

    public function getStock(){
        return $this->belongsTo(ItemCurrentStock::class,'ItemCode','ItemCode');
    }


}
