<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlateCategories extends Model
{
    use HasFactory;

    protected $fillable = [
        'plateCategoryTitle',
        'plateCategoryDesc',
        'is_active',
        'is_deleted',
        'created_by',
        'updated_by',
    ];
}
