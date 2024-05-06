<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicesSectionsGroup extends Model
{
    use HasFactory;

    protected $table = 'services_sections_groups';

    protected $fillable = [
        'service_section_group_name',
        'service_section_group_code',
        'service_section_group_description',
        'service_group_id',
        'department_id',
        'section_id',
        'station_id',
        'created_by',
        'updated_by',
        'is_active',
        'is_blocked',
        'created_at',
        'updated_at',
    ];

    public function serviceGroup()
    {
        return $this->belongsTo(ServicesGroup::class,'service_group_id','id');
    }

    public function servicesSectionGroup()
    {
        return $this->hasMany(ServiceMaster::class, 'id', 'service_section_group_id');
    }
}
