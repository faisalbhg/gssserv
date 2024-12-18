<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlateCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'plateCategoryId',
        'plateEmiratesId',
        'plateColorTitle',
        'plateColorDescription',
        'is_active',
        'is_deleted',
        'created_by',
        'updated_by',
    ];
}
