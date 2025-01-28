<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerVehicle extends Model
{
    use HasFactory;


    protected $fillable = [
        'customer_id',
        'vehicle_type',
        'make',
        'vehicle_image',
        'model',
        'plate_country',
        'plate_state',
        'plate_category',
        'plate_code',
        'plate_number',
        'plate_number_final',
        'chassis_number',
        'vehicle_km',
        'plate_number_image',
        'chaisis_image',
        'is_active',
        'created_by',
        'updated_by',
        'created_at',
        'uppdated_at'
    ];

    /**
     * Get the post that owns the comment.
     *  
     * Syntax: return $this->belongsTo(Post::class, 'foreign_key', 'owner_key');
     *
     * Example: return $this->belongsTo(Post::class, 'post_id', 'id');
     * 
     */

    public function customerInfoMaster()
    {
        return $this->belongsTo(TenantMasterCustomers::class,'customer_id','TenantId');
    }

    public function customerInfo()
    {
        return $this->belongsTo(Customers::class,'customer_id','id');
    }

    public function user()
    {
        return $this->belongsTo(Customers::class);
    }

    public function makeInfo()
    {
        return $this->belongsTo(VehicleMakes::class,'make','id');
    }

    public function modelInfo()
    {
        return $this->belongsTo(VehicleModels::class,'model','id');
    }

    public function customerDiscountLists()
    {
        return $this->hasMany(CustomerDiscountGroup::class,'customer_id','customer_id');
    }

    public function countryInfo(){
        return $this->belongsTo(Country::class,'plate_country','CountryCode');
    }

    
    
}
