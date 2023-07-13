<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicecart extends Model
{
    use HasFactory;

    protected $table = 'servicecarts';

    protected $fillable = [
        'customer_id',
        'vehicle_id',
        'service_id',
        'service_type_name',
        'service_type_group',
        'service_code',
        'station',
        'price',
        'quantity',
        'created_by',
        'updated_by',
    ];
}
