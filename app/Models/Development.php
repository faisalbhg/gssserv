<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Development extends Model
{
    use HasFactory;

    protected $table = 'development';

    protected $fillable = [
        "DevelopmentCode",
        "CompanyCode",
        "PortfolioCode",
        "LandlordCode",
        "DevelopmentNo",
        "Prefix",
        "DevelopmentName",
        "DevelopmentName_Ar",
        "MakaniNo",
        "CountryCode",
        "StateCode",
        "CityCode",
        "Address",
        "Address_Ar",
        "YearOfDevelopment",
        "DevelopmentDate",
        "Landmark",
        "PlotNo",
        "SectorNo",
        "DevelopmentTypeID",
        "NoOfFloors",
        "NoOfMezzanine",
        "NoOfParking",
        "ManagementFee",
        "ManagementFeePercent",
        "Remarks",
        "Status",
        "Active",
        "MaintenanceFeeType",
        "MaintenanceFee",
        "MaintenanceFeePeriod",
        "MaintenanceFeePeriodNo",
        "MaintenanceLatePayment",
        "CreatedBy",
        "Creationdate",
        "ModifiedBy",
        "ModificationDate",
        "ReportSequenceNo",
        "PremisesNo",
        "VATType",
        "LocationId",
        "Operation"
    ];

    
}
