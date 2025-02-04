<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageBookingServiceLogs extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_number',
        'customer_package_service_id',
        'package_status',
        'package_description',
        'created_by',
        'updated_by',
        'is_active',
        'is_blocked',
        'created_at',
        'uppdated_at',
    ];
}
