<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlateEmiratesCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'plateCategoryId',
        'plateEmiratesId',
        'plateCategoryTitle',
        'plateCategoryDesc',
        'is_active',
        'is_deleted',
        'created_by',
        'updated_by',
    ];
}
