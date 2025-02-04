<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePackage extends Model
{
    use HasFactory;

    protected $table ='ServicePackage';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    public function packageDetails()
    {
        return $this->hasMany(ServicePackageDetail::class,'Code','Code')->with(['labourItemDetails','inventoryItemDetails']);
    }
}
