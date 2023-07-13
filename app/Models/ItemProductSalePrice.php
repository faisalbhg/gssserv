<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemProductSalePrice extends Model
{
    use HasFactory;

    public function customertype()
    {
        return $this->belongsTo(Customertype::class,'customer_types','id');
    }
    public function serviceItems()
    {
        return $this->belongsTo(ServiceItems::class,'item_id','id');
    }
}
