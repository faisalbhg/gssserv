<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePackageDetail extends Model
{
    use HasFactory;

    protected $table ='ServicePackageDetails';

    public function labourItemDetails()
    {
        return $this->belongsTo(LaborItemMaster::class,'ItemCode','ItemCode');
    }

    public function inventoryItemDetails()
    {
        return $this->belongsTo(InventoryItemMaster::class,'ItemCode','ItemCode');
    }

    
    
}
