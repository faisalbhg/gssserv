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

    public function departmentName(){
        return $this->belongsTo(Development::class,'DepartmentCode','DevelopmentCode');
    }

    public function sectionName(){
        return $this->belongsTo(Sections::class,'SectionCode','PropertyCode');
    }


}
