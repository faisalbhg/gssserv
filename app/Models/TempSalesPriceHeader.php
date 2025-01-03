<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempSalesPriceHeader extends Model
{
    use HasFactory;

    protected $table = 'sales_price_header';

    
    
    public function CustomerGroup(){
        return $this->belongsTo(LaborCustomerGroup::class,'CustomerGroupId','Id');
    }
}
