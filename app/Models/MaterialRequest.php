<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialRequest extends Model
{
    use HasFactory;

    protected $table = 'MaterialRequest';
    protected $primaryKey = 'Id';
    protected $connection = 'mysql_second';
    public $timestamps = false;

    protected $fillable = [
        'sessionId',
        'ItemCode',
        'ItemName',
        'QuantityRequested',
        'Activity2Code',
    ];

}
