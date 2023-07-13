<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'customer_type',
        'customer_id_image',
        'created_by',
        'updated_by',
        'is_active',
        'is_blocked',
        'created_at',
        'uppdated_at'
    ];

    protected $guarded = [];

    public function customertype()
    {
        return $this->belongsTo(Customertype::class,'customer_type','id');
    }

    public function customervehicle()
    {
        return $this->hasMany(CustomerVehicle::class,'customer_id','id');
    }
}
