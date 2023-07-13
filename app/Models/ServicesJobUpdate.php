<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicesJobUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_number',
        'job_id',
        'service_group_id',
        'service_group_code',
        'service_group_name',
        'service_type_id',
        'service_type_code',
        'service_type_name',
        'service_item',
        'job_status',
        'job_departent',
        'pre_finishing_time_in',
        'pre_finishing_time_out',
        'finishing_time_in',
        'finishing_time_out',
        'glazing_time_in',
        'glazing_time_out',
        'seat_cleaning_time_in',
        'seat_cleaning_time_out',
        'interior_time_in',
        'interior_time_out',
        'oil_change_time_in',
        'oil_change_time_out',
        'wash_service_time_in',
        'wash_service_time_out',
        'created_by',
        'updated_by',
        'created_at',
        'uppdated_at',
    ];
}
