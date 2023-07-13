<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleChecklistEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_number',
        'job_id',
        'checklist',
        'fuel',
        'scratches_found',
        'scratches_notfound',
        'vehicle_image',
        'signature',
        'is_active',
        'is_status',
        'created_by',
        'updated_by',
    ];
}
