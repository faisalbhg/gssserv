<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\PlateCode;
use App\Models\VehicleMakes;
use App\Models\VehicleModels;
use App\Models\Vehicletypes;
use App\Models\ServiceChecklist;

use thiagoalessio\TesseractOCR\TesseractOCR; 
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Http;
use LaravelPayfort\Facades\Payfort;
use Illuminate\Support\Facades\Hash;
use DB;
class CarsTaxi extends Component
{
    use WithFileUploads;
    public $mobile, $name, $ct_number, $meter_id, $plate_number_image, $plate_code, $plate_number, $vehicle_type, $make, $model, $checklistLabel, $fuel, $scratchesFound, $scratchesNotFound, $vImageR1, $vImageR2, $vImageF, $vImageB, $vImageL1, $vImageL2, $customerSignature,$roof_images=[], $dash_image1, $dash_image2, $passenger_seat_image, $driver_seat_image, $back_seat1, $back_seat2, $back_seat3, $back_seat4, $photo;
    public $plateEmiratesCodes=[], $vehicleTypesList=[], $listVehiclesMake=[], $vehiclesModelList=[], $checklistLabels=[];
    public function render()
    {
        $this->plateEmiratesCodes = PlateCode::where([
                'plateEmiratesId'=>2,
                'plateCategoryId'=>1,
                'is_active'=>1,
            ])->get();
        $this->vehicleTypesList = Vehicletypes::orderBy('type_name','ASC')->get();
        $this->listVehiclesMake = VehicleMakes::get();
        if($this->make){
            $this->vehiclesModelList = VehicleModels::where(['vehicle_make_id'=>$this->make])->get();
        }
        $this->checklistLabels = ServiceChecklist::get();
        
        $this->dispatchBrowserEvent('selectSearchEvent'); 
        return view('livewire.cars-taxi');
    }

    public function clickShowSignature()
    {
        $this->dispatchBrowserEvent('showSignature');

    }

    public function createJob()
    {
        $validatedData = $this->validate([
            'ct_number' => 'required',
            'meter_id' => 'required',
            'plate_code' => 'required',
            'plate_number' => 'required',
            'plate_number' => 'required',
        ]);
    }
}
