<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderJob extends Model
{
    use HasFactory;

    protected $table = 'WorkOrder.Job';
    
    public $timestamps = false;


    protected $fillable = [
        "DocumentCode",
        "DocumentDate",
        "Status",
        "LandlordCode",
    ];
}
