<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceBundleType extends Model
{
    use HasFactory;

    protected $table = 'ServiceBundleType';

    protected $primaryKey = 'TypeId';

    public function bundlesDetails()
    {
        return $this->hasMany(ServiceBundle::class,'BundleType', 'TypeId');
    }

    public function bundleDiscountedPrice()
    {
        return $this->hasMany(ServiceBundleDiscountedPrice::class,'Code', 'Code');
    }


}
