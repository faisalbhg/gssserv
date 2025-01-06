<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateList extends Model
{
    use HasFactory;

    protected $table = 'Library.State';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'StateCode',
        'CountryCode',
        'StateName',
        'StateNameAR',
        'Active',
    ];
}
