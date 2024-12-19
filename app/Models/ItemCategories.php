<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategories extends Model
{
    use HasFactory;

    protected $table = 'Inventory.Category';
    protected $primaryKey = "CategoryId";

    public function subCategoryList()
    {
        return $this->hasMany(InventorySubCategory::class,'CategoryId','CategoryId');
    }

    //InventorySubCategory
}
