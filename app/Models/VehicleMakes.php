<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleMakes extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_name',
    ];
}
