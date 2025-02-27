<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceBundleDiscountedPrice extends Model
{
    use HasFactory;

    protected $table = 'ServiceBundleDiscountedPrice';

    protected $primaryKey = 'Id';
    public $timestamps = false;

    
}
