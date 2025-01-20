<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemMakeModel extends Model
{
    use HasFactory;
    protected $table = 'Item_MakeModel';

    public function itemInformation()
    {
        return $this->hasMany(InventoryItemMaster::class,'ItemCode','ItemCode')->with(['categoryInfo']);
    }

    public function itemDetails()
    {
        return $this->belongsTo(InventoryItemMaster::class,'ItemCode','ItemCode');
    }

    
}
