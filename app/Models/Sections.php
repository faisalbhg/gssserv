<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    use HasFactory;

    protected $table = 'property';


    public function jobCards()
    {
        return $this->belongsToMany(CustomerJobCardServices::class)
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    /*protected $fillable = [
        'section_code',
        'section_name',
        'section_description',
        'is_active',
        'is_delete',
        'created_at',
        'uppdated_at',
    ];*/

    //PropertyCode,DevelopmentCode,PropertyNo,PropertyName,Operations
}
