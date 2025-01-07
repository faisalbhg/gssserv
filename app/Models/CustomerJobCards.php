<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerJobCards extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_number',
        'job_date_time',
        'customer_id',
        'vehicle_id',
        'vehicle_type',
        'make',
        'vehicle_image',
        'model',
        'plate_number',
        'chassis_number',
        'vehicle_km',
        'ql_km_range',
        'station',
        'customer_discount_id',
        'discount_id',
        'discount_unit_id',
        'discount_code',
        'discount_title',
        'discount_percentage',
        'discount_amount',
        'coupon_used',
        'coupon_type',
        'coupon_code',
        'coupon_amount',
        'total_price',
        'vat',
        'grand_total',
        'payment_type',
        'payment_status',
        'payment_request',
        'payment_response',
        'payment_link',
        'job_create_status',
        'job_status',
        'job_departent',
        'created_by',
        'updated_by',
        'is_active',
        'is_blocked',
        'created_at',
        'uppdated_at',
    ];

    public function customerInfo()
    {
        //return $this->belongsTo(Customers::class, 'customer_id', 'id');
        return $this->belongsTo(TenantMasterCustomers::class,'customer_id','TenantId');
    }

    public function customerVehicle()
    {
        return $this->belongsTo(CustomerVehicle::class,'vehicle_id','id')->with(['makeInfo','modelInfo']);
    }

    public function customerJobServices()
    {
        return $this->hasMany(CustomerJobCardServices::class,'job_id','id')->with(['customerJobServiceLogs']);
    }

    public function checklistInfo(){
        return $this->belongsTo(JobcardChecklistEntries::class,'job_number','job_number');

    }

    public function stationInfo()
    {
        return $this->belongsTo(Landlord::class,'station','LandlordCode');
    }

    public function makeInfo()
    {
        return $this->belongsTo(VehicleMakes::class,'make','id');
    }

    public function modelInfo()
    {
        return $this->belongsTo(VehicleModels::class,'model','id');
    }
}
