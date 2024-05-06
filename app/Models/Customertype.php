<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customers;
class Customertype extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customersList()
    {
        return $this->hasMany(Customers::class,'customer_type','id');
    }
    
}
