<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantMasterCustomers extends Model
{
    use HasFactory;

    protected $table = 'TenantMaster';
    protected $primaryKey = 'TenantId';
    public $timestamps = false;

    protected $fillable = [
        "TenantId",
        "TenantCode",
        "ReferenceCode",
        "Category",
        "Salutation",
        "TenantType",
        "Abbreviation",
        "TenantName",
        "TenantName_AR",
        "ContactPerson",
        "ContactPerson_AR",
        "Nationality",
        "Telephone",
        "Mobile",
        "HomeCountryContact",
        "Fax",
        "POBox",
        "Email",
        "Website",
        "Address",
        "Address_AR",
        "TotalOccupant",
        "OccupantName",
        "OccupantContact",
        "DOB",
        "Occupation",
        "Occupation_AR",
        "Profession",
        "Profession_AR",
        "Children",
        "ProspectCode",
        "VATAccountNo",
        "TenantRate",
        "UserID",
        "Password",
        "Active",
        "CreatedBy",
        "Creationdate",
        "ModifiedBy",
        "ModifiedDate",
        "IsVIP",
        "CategoryI",
        "CategoryC",
        "Paymethod",
        "Staff",
        "CompanyId",
    ];

    public function customerVehicleDetails()
    {
        return $this->hasMany(CustomerVehicle::class,'customer_id','TenantId');
    }
}
