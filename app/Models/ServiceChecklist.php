<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceChecklist extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_group_id',
        'checklist_label',
        'is_active',
        'is_blocked',
    ];

    public function service_group()
    {
        return $this->belongsTo(ServicesGroup::class,'service_group_id','id');
    }
}
