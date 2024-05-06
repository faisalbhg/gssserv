<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;

    protected $table ='services';

    public function servicesType()
    {
        return $this->belongsTo(ServicesType::class,'service_type_id','id')->with(['servicesGroup']);
    }

    
}
