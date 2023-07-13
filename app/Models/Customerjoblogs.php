<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customerjoblogs extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_number',
        'customer_job_service_id',
        'job_status',
        'job_departent',
        'job_description',
        'created_by',
        'updated_by',
        'is_active',
        'is_blocked',
        'created_at',
        'uppdated_at',
    ];
}
