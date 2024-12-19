<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventorySubCategory extends Model
{
    use HasFactory;

    protected $table = 'Inventory.SubCategory';
    protected $primaryKey = "SubCategoryId";
}
