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
        'Status',
        'ApprovalStatus',
        'Cancelled',
        'CancelledBy',
        'ItemCode',
        'ItemName',
        'QuantityRequested',
        'Activity2Code',
    ];

}
