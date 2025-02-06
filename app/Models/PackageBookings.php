<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageBookings extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_number',
        'package_name',
        'package_code',
        'package_id',
        'package_duration',
        'package_description',
        'package_type',
        'package_km',
        'package_date_time',
        'customer_id',
        'otp_code',
        'otp_verify',
        'customer_name',
        'customer_mobile',
        'customer_email',
        'customer_trn',
        'vehicle_id',
        'vehicle_type',
        'make',
        'vehicle_image',
        'model',
        'plate_number',
        'chassis_number',
        'vehicle_km',
        'station',
        'total_price',
        'vat',
        'grand_total',
        'payment_type',
        'payment_status',
        'payment_request',
        'payment_response',
        'payment_link',
        'package_status',
        'created_by',
        'updated_by',
        'is_active',
        'is_blocked',
        'created_at',
        'uppdated_at',
    ];

    public function customerPackageServices()
    {
        return $this->hasMany(PackageBookingServices::class,'package_id','id');
    }

    public function customerInfo()
    {
        //return $this->belongsTo(Customers::class, 'customer_id', 'id');
        return $this->belongsTo(TenantMasterCustomers::class,'customer_id','TenantId');
    }

    public function customerVehicle()
    {
        return $this->belongsTo(CustomerVehicle::class,'vehicle_id','id')->with(['makeInfo','modelInfo']);
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
