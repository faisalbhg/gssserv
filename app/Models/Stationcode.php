<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stationcode extends Model
{
    use HasFactory;

    protected $fillable = [
        'station_code',
        'station_name',
        'created_at',
        'uppdated_at',
    ];
}
