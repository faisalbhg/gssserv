<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicesType extends Model
{
    use HasFactory;

    public function services()
    {
        return $this->hasMany(Services::class, 'id', 'service_type_id');
    }
    public function servicesGroup()
    {
        return $this->belongsTo(ServicesGroup::class,'service_group_id','id');
    }
}
