<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobcardChecklistEntries extends Model
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
        'turn_key_on_check_for_fault_codes',
        'start_engine_observe_operation',
        'reset_the_service_reminder_alert',
        'stick_update_service_reminder_sticker_on_b_piller',
        'interior_cabin_inspection_comments',
        'check_power_steering_fluid_level',
        'check_power_steering_tank_cap_properly_fixed',
        'check_brake_fluid_level',
        'brake_fluid_tank_cap_properly_fixed',
        'check_engine_oil_level',
        'check_radiator_coolant_level',
        'check_radiator_cap_properly_fixed',
        'top_off_windshield_washer_fluid',
        'check_windshield_cap_properly_fixed',
        'underHoodInspectionComments',
        'check_for_oil_leaks_engine_steering',
        'check_for_oil_leak_oil_filtering',
        'check_drain_lug_fixed_properly',
        'check_oil_filter_fixed_properly',
        'ubi_comments',
        'is_active',
        'is_status',
        'created_by',
        'updated_by',
    ];
}
