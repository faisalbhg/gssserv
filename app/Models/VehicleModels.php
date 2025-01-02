<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleModels extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'vehicle_make_id',
        'vehicle_make_name',
        'vehicle_model_name'
    ];
}
