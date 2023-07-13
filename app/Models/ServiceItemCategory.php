<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceItemCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_code',
        'category_name',
        'category_description',
        'parent_id',
        'category_image',
        'is_active',
        'is_blocked',
        'created_at',
        'uppdated_at'
    ];

    protected $guarded = [];

    public function sub_category()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function parent_category()
    {
        return $this->hasMany(self::class, 'id', 'parent_id');
    }
}
