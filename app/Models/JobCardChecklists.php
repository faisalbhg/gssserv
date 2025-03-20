<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCardChecklists extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_number',
        'job_Service_id',
        'checklist',
        'checklist_notes',
        'created_by',
        'updated_by'
    ];
}
