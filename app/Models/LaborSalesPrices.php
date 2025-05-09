<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaborSalesPrices extends Model
{
    use HasFactory;

    protected $table = 'Labor.SalesPrice';
    protected $primaryKey = 'PriceID';
    

    public function customerDiscountGroup()
    {
        return $this->belongsTo(LaborCustomerGroup::class,'CustomerGroupId','Id');
    }
}
