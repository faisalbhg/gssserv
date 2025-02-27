<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceBundle extends Model
{
    use HasFactory;

    protected $table = 'ServiceBundle';

    protected $primaryKey = 'Id';

    public function bundleDetails()
    {
        return $this->hasMany(ServicePackageDetail::class,'Code','Code')->with(['labourItemDetails','inventoryItemDetails']);
    }

    public function bundleTypes()
    {
        return $this->belongsTo(ServiceBundleType::class,'BundleType','TypeId');
    }

    public function serviceBundlePrice(){
        return $this->belongsTo(ServiceBundleDiscountedPrice::class,'Code','Code');
    }
}
