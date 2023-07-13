<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemProductGroup extends Model
{
    use HasFactory;

    public function sub_group()
    {
        return $this->belongsTo(self::class, 'parent_product_group_id', 'id');
    }

    public function parent_group()
    {
        return $this->hasMany(self::class, 'id', 'parent_product_group_id');
    }
}
