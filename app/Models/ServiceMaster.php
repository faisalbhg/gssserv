<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceMaster extends Model
{
    use HasFactory;

    protected $table = 'service_masters';

    protected $fillable = [
        'service_name',
        'service_code',
        'service_description',
        'cost_price',
        'sale_price',
        'vat_included',
        'service_section_group_id',
        'service_section_group_code',
        'service_group_id',
        'service_group_code',
        'vehicle_type',
        'created_by',
        'updated_by',
        'is_active',
        'is_deleted',
        'created_at',
        'updated_at',
    ];

    public function serviceGroup()
    {
        return $this->belongsTo(ServicesGroup::class,'service_group_id','id');
    }

    public function serviceSectionGroup()
    {
        return $this->belongsTo(ServicesSectionsGroup::class,'service_section_group_id','id')->with(['serviceGroup']);
    }
}
