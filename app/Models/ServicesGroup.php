<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicesGroup extends Model
{
    use HasFactory;

    protected $table = 'services_groups';

    public function servicesSectionGroup()
    {
        return $this->hasMany(ServicesSectionsGroup::class, 'id', 'service_group_id');
    }
}
