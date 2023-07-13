<?php

namespace App\Http\Livewire;

use Livewire\Component;

use thiagoalessio\TesseractOCR\TesseractOCR; 

use Illuminate\Http\Request;
use Livewire\WithFileUploads;

use App\Models\Customers;
use App\Models\Vehicles;
use App\Models\CustomerVehicle;
use App\Models\Customertype;
use App\Models\Vehicletypes;
use App\Models\Services;
use App\Models\ServicesType;
use App\Models\ServicesGroup;
use App\Models\Customerjobs;
use App\Models\Customerjobservices;
use App\Models\Customerjoblogs;
use App\Models\StateList;
use App\Models\ServiceItemsPrice;
use App\Models\CustomerBasket;
use App\Models\ServiceChecklist;
use App\Models\VehicleChecklistEntry;

use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Http;
use LaravelPayfort\Facades\Payfort;
use Illuminate\Support\Facades\Hash;

class Dashboard extends Component
{
    use WithFileUploads;

    public $showDashboard = true;

    //Customer Data
    public $showCustomerSearch=true;
    public $showSearchMobile=true;
    public $showCustomerForm=false;
    public $updateCustomerFormDiv = false;
    public $mobile, $name, $email, $customer_type, $customerTypeList, $customer_id_image;

    //Customer Vehicle
    public $showVehicleForm=true;
    public $numberPlateAddForm = true;
    public $otherVehicleDetailsForm=false;
    public $plate_state, $plate_code, $plate_number, $plate_number_final, $vehicle_image, $vehicleTypesList, $vehicle_type, $vehiclesMakeList, $make, $vehiclesModelList, $model, $chassis_number,$vehicle_km,$plate_number_image,$chaisis_image;

    //Search Vehicles
    public $showVehicleAvailable=false;

    //Selected Customer and Vehilces
    public $selectedCustomerVehicle = false;
    public $sCtmrVhlvehicle_id, $sCtmrVhlvehicle_image, $sCtmrVhlvehicleName, $sCtmrVhlmake_model, $sCtmrVhlplate_number, $sCtmrVhlchassis_number, $sCtmrVhlvehicle_km, $sCtmrVhlname, $sCtmrVhlcustomerType, $sCtmrVhlemail, $sCtmrVhlmobile;
    public $vehicleNewKM = false;
    public $customer_id, $vehicle_id, $new_vehicle_km, $showVehicleNewKM = false;
    
    
    //Service and itemms
    public $showServiceGroup = false;
    public $showServiceType = false;
    public $showServicesitems = false;
    public $selectServicesitems = false;
    public $service_group_id, $service_group_name, $service_group_code, $station;
    
    //Customer Basket
    public $total,$tax,$grand_total, $paymentMethode, $job_number, $job_service_number,$selected_vehicle_id, $cartItemCount=0, $cartItems = [], $quantity;
    public $cardShow=false;

    //Checkout and Checklist
    public $showCheckout = false;
    public $showCheckList=false;
    public $showGSCheckList=false;
    public $showQLCheckList=false;
    public $markCarScratch = false;
    public $checklistLabels = [];
    public $checklistLabel = [],$fuel,$scratchesFound, $scratchesNotFound, $vImageR1,$vImageR2,$vImageF,$vImageB,$vImageL1,$vImageL2,$customerSignature;
    public $successPage=false;
    

    
    public $customers = [];
    public $servicesTypesList = [];
    public $serviceItemsList = [];


    /*public $showVehicleResult=false;
    public $showVehicleDiv = false;
    public $showVehicleFormDiv = false;
    
    public $otherVehicleForm = false;
    public $showCustomerFormDiv = false;
    public $selectedCustomerVehicle = false;
    public $showServiceType = false;
    public $newVehicleAdd = false;
    public $vehicleNewKM = false;
    public $updateCustomerFormDiv = false;
    public $showServicesitems = false;
    public $selectServicesitems = false;
    public $showServiceGroup = false;
    public $showCheckout = false;*/

    public $search_job_bumber = "";
    public $records;
    public $empDetails;

    public $customerjobservices =array();
    public $customerjoblogs = array();
    public $job_date_time, $customerType, $payment_status=0, $payment_type=0, $job_status, $job_departent, $total_price, $vat;

    public $service_search = "";

    public $turn_key_on_check_for_fault_codes, $start_engine_observe_operation, $reset_the_service_reminder_alert, $stick_update_service_reminder_sticker_on_b_piller, $interior_cabin_inspection_comments, $check_power_steering_fluid_level, $check_power_steering_tank_cap_properly_fixed, $check_brake_fluid_level, $brake_fluid_tank_cap_properly_fixed, $check_engine_oil_level, $check_radiator_coolant_level, $check_radiator_cap_properly_fixed, $top_off_windshield_washer_fluid, $check_windshield_cap_properly_fixed, $underHoodInspectionComments, $check_for_oil_leaks_engine_steering, $check_for_oil_leak_oil_filtering, $check_drain_lug_fixed_properly, $check_oil_filter_fixed_properly, $ubi_comments;



    //Payment

    //Success

    public function render(){
        $this->customerTypeList = Customertype::all();
        $this->vehicleTypesList = Vehicletypes::all();
        $this->vehiclesMakeList = Vehicles::select('vehicle_make')->distinct()->orderBy('vehicle_make','ASC')->get();
        $servicesGroup = ServicesGroup::where(['is_active'=>1])->get();
        
        $getCountSalesJob = Customerjobs::select(
            array(
                \DB::raw('count(DISTINCT(customer_id)) customers'),
                \DB::raw('count(job_number) jobs'),
                \DB::raw('count(case when job_status = 0 then job_status end) new'),
                \DB::raw('count(case when job_status = 1 then job_status end) working_progress'),
                \DB::raw('count(case when job_status = 2 then job_status end) work_finished'),
                \DB::raw('count(case when job_status = 3 then job_status end) ready_to_deliver'),
                \DB::raw('count(case when job_status = 4 then job_status end) delivered'),
                \DB::raw('count(case when job_status in (0,1,2,3,4) then job_status end) total'),
                \DB::raw('SUM(grand_total) as saletotal'),
            )
        )->first();

        $getAllSalesJob = Customerjobservices::select(
            array(
                \DB::raw("FORMAT(created_at, '%d-%M-%y') as job_date"),
                \DB::raw('count(service_type_id) as job_services'),
                \DB::raw('SUM(grand_total) as saletotal'),
            )
        )
        ->where(['is_removed'=>0])
        ->groupBy(\DB::raw("FORMAT(created_at, '%d-%M-%y')"))
        ->get();
        $dataLabels = [];
        $dataJobSalesValues = [];
        $totalJobServices=0;

        foreach($getAllSalesJob as $getAllSale)
        {
            $dataLabels[] = Carbon::createFromFormat('d-m-y', $getAllSale->job_date)
                             ->format('d-M-y');
            $dataJobSalesValues[]=round($getAllSale->saletotal, 2);
            $totalJobServices = $totalJobServices+$getAllSale->job_services;
        }
        $getAllSalesJobData['labels']=json_encode($dataLabels);
        $getAllSalesJobData['sales_values']=json_encode($dataJobSalesValues);
        $getAllSalesJobData['totalJobServices']=$totalJobServices;

        $customerjobs = Customerjobs::
            select(
                'customerjobs.id',
                'customerjobs.job_number',
                'customerjobs.job_date_time',
                'customerjobs.customer_id',
                'customerjobs.customer_type',
                'customerjobs.vehicle_id',
                'customerjobs.vehicle_type',
                'customerjobs.make',
                'customerjobs.vehicle_image',
                'customerjobs.model',
                'customerjobs.plate_number',
                'customerjobs.chassis_number',
                'customerjobs.vehicle_km',
                'customerjobs.station_id',
                'customerjobs.coupon_used',
                'customerjobs.coupon_type',
                'customerjobs.coupon_code',
                'customerjobs.coupon_amount',
                'customerjobs.total_price',
                'customerjobs.vat',
                'customerjobs.grand_total',
                'customerjobs.payment_type',
                'customerjobs.payment_status',
                'customerjobs.payment_link',
                'customerjobs.job_status',
                'customerjobs.job_departent',
                'customerjobs.created_by',
                'customerjobs.updated_by',
                'customerjobs.is_active',
                'customerjobs.is_blocked',
                'customerjobs.created_at',
                'customers.name','customers.email','customers.mobile','customertypes.customer_type as customerType')
            
            ->join('customers','customers.id','=','customerjobs.customer_id')
            ->join('customertypes','customertypes.id','=','customerjobs.customer_type')
            ->orderBy('customerjobs.id','DESC')
            ->where('customerjobs.job_number', 'like', "%{$this->search_job_bumber}%" )
            ->take(5)->get();

        
        $stateList = StateList::all();

        $data = [
            'servicesGroups' => $servicesGroup,
            'getCountSalesJob' => $getCountSalesJob,
            'getAllSalesJob' => $getAllSalesJobData,
            'customerjobs' => $customerjobs,
            'stateList' =>$stateList,
        ];

        $this->servicesTypesList = ServicesType::select(
            'services.*',

            'services_types.id AS service_type_id',
            'services_types.service_type_name',
            'services_types.service_type_code',
            'services_types.service_type_description',
            'services_types.service_group_id',
            'services_types.department_id',
            'services_types.section_id',
            'services_types.station_id',
            'services_groups.service_group_name',
            'services_groups.service_group_code',
        )
        ->join('services', 'services_types.id', '=', 'services.service_type_id')
        ->join('services_groups', 'services_groups.id', '=', 'services_types.service_group_id')
        ->where(
            [
                'services.customer_type'=> $this->customer_type,
                'services_types.service_group_id' => $this->service_group_id,
                'services_types.station_id'=>$this->station,
            ]
        )
        ->where('services_types.service_type_name', 'like', "%{$this->service_search}%")
        ->get();

        /*$this->cartItems = \Cart::getContent()->toArray();
        if(!empty($this->cartItems))
        {
            $this->cardShow=true;
        }*/
        /*$total = \Cart::getTotal();
        $this->tax = $total * (config('global.TAX_PERCENT') / 100);
        $this->grand_total = $total  * ((100 + config('global.TAX_PERCENT')) / 100);

        */

        $this->vehiclesModel = Vehicles::select('vehicle_model')->distinct()->where(['vehicle_make'=>$this->make])->get();


        $cartDetails = $this->cartItems;
        $this->cartItemCount = count($this->cartItems); 
        $this->total=0;
        foreach($cartDetails as $item)
        {
            $this->total = $this->total+($item->quantity*$item->price);
        }
        $this->tax = $this->total * (config('global.TAX_PERCENT') / 100);
        $this->grand_total = $this->total  * ((100 + config('global.TAX_PERCENT')) / 100);

        $this->dispatchBrowserEvent('selectSearchEvent'); 

        

        return view('livewire.dashboard',$data);
    }

    // Fetch records
    public function searchResult(){
        $this->showDashboard=false;
        
        if( (!empty($this->mobile))){
            $this->getVehicleCustomer();
            if(count($this->customers)>0)
            {
                $this->showSearchMobile=true;
                //$this->showVehicleForm=false;
                $this->showVehicleAvailable=true;
                $this->showCustomerForm=false;
                //$this->numberPlateAddForm=false;
                $this->otherVehicleDetailsForm=false;

                //dd($this->showVehicleForm);

                /*$this->showVehicleDiv = true;
                $this->showCustomerFormDiv=false;
                $this->selectedCustomerVehicle=false;
                $this->showVehicleFormDiv=false;
                $this->numberPlateAddForm=false;*/
            }
            else
            {
                $this->showSearchMobile=true;
                $this->showVehicleForm=true;
                $this->showVehicleAvailable=false;
                $this->showCustomerForm=true;
                $this->numberPlateAddForm=true;
                $this->otherVehicleDetailsForm=true;

                /*$this->showVehicleDiv = false;
                $this->showVehicleFormDiv=true;
                $this->showCustomerFormDiv=true;
                $this->selectedCustomerVehicle=false;
                $this->numberPlateAddForm=true;
                $this->otherVehicleForm=true;*/
            }
        }
        else if( (!empty($this->plate_state)) || (!empty($this->plate_code)) || (!empty($this->plate_number)) ){
            
            $validatedData = $this->validate([
                'plate_state' => 'required',
                'plate_code' => 'required',
                'plate_number' => 'required',
            ]);

            $this->getVehicleCustomer();
            if(count($this->customers)>0)
            {
                $this->showSearchMobile=false;
                $this->showVehicleForm=true;
                $this->showVehicleAvailable=true;
                $this->showCustomerForm=false;
                $this->numberPlateAddForm=true;
                $this->otherVehicleDetailsForm=false;


                /*$this->showVehicleDiv = true;
                $this->showVehicleFormDiv=false;
                $this->showCustomerFormDiv=false;
                $this->selectedCustomerVehicle=false;
                $this->showVehicleFormDiv=false;
                $this->otherVehicleForm=false;*/
                
                /*if((!empty($this->plate_state)) || (!empty($this->plate_code)) || (!empty($this->plate_number)))
                {
                    $this->numberPlateAddForm=true;
                }
                else
                {
                    $this->numberPlateAddForm=false;
                }*/
            }
            else
            {
                $this->showSearchMobile=true;
                $this->showVehicleForm=true;
                $this->showVehicleAvailable=false;
                $this->showCustomerForm=true;
                $this->numberPlateAddForm=true;
                $this->otherVehicleDetailsForm=true;

                /*$this->showVehicleDiv = false;
                $this->showVehicleFormDiv=true;
                $this->showCustomerFormDiv=true;
                $this->selectedCustomerVehicle=false;
                $this->numberPlateAddForm=true;
                $this->otherVehicleForm=true;*/
            }
        }
        else
        {
            $this->showSearchMobile=true;
            $this->showVehicleForm=true;
            $this->showVehicleAvailable=false;
            $this->showCustomerForm=false;
            $this->numberPlateAddForm=true;
            $this->otherVehicleDetailsForm=false;

            /*$this->showVehicleDiv = false;
            $this->showVehicleFormDiv=true;
            $this->showCustomerFormDiv=true;
            $this->selectedCustomerVehicle=false;
            $this->numberPlateAddForm=true;
            $this->otherVehicleForm=true;*/
        }

        $this->dispatchBrowserEvent('selectSearchEvent'); 
    }

    public function saveVehicleCustomer(){
        
        $validatedData = $this->validate([
            'customer_type' => 'required',
            'vehicle_image' => 'required|image|mimes:jpg,jpeg,png,svg,gif|max:10048',
            'vehicle_type' => 'required',
            'make' => 'required',
            'model'=> 'required',
            'plate_state'=> 'required',
            'plate_code'=> 'required',
            'plate_number'=> 'required',
        ]);
        
        $imagename['customer_id_image']='';
        if($this->customer_id_image)
        {
            $imagename['customer_id_image'] = $this->customer_id_image->store('customer_id', 'public');
        }

        $imagename['vehicle_image']='';
        if($this->vehicle_image)
        {
            $imagename['vehicle_image'] = $this->vehicle_image->store('vehicle', 'public');
        }

        $imagename['plate_number_image']='';
        if($this->plate_number_image)
        {
            $imagename['plate_number_image'] = $this->plate_number_image->store('plate_number', 'public');
        }

        $imagename['chaisis_image']='';
        if($this->chaisis_image)
        {
            $imagename['chaisis_image'] = $this->chaisis_image->store('chaisis_image', 'public');
        }

        if($this->customer_id)
        {
            $customerId = $this->customer_id;
        }
        else
        {
            $insertCustmoerData['mobile']=isset($this->mobile)?$this->mobile:'';
            $insertCustmoerData['name']=isset($this->name)?$this->name:'';
            $insertCustmoerData['email']=isset($this->email)?$this->email:'';
            $insertCustmoerData['customer_type']=isset($this->customer_type)?$this->customer_type:'';
            $insertCustmoerData['customer_id_image']=$imagename['customer_id_image'];
            $insertCustmoerData['is_active']=1;
            $customerInsert = Customers::create($insertCustmoerData);
            $customerId = $customerInsert->id;
        }


        $customerVehicleData['customer_id']=$customerId;
        $customerVehicleData['vehicle_type']=$this->vehicle_type;
        $customerVehicleData['make']=$this->make;
        $customerVehicleData['vehicle_image']=$imagename['vehicle_image'];
        $customerVehicleData['model']=$this->model;
        $customerVehicleData['plate_state']=$this->plate_state;
        $customerVehicleData['plate_code']=$this->plate_code;
        $customerVehicleData['plate_number']=$this->plate_number;
        $customerVehicleData['plate_number_final']=$this->plate_state.' '.$this->plate_code.' '.$this->plate_number;
        $customerVehicleData['chassis_number']=isset($this->chassis_number)?$this->chassis_number:'';
        $customerVehicleData['vehicle_km']=isset($this->vehicle_km)?$this->vehicle_km:'';
        $customerVehicleData['plate_number_image']=$imagename['plate_number_image'];
        $customerVehicleData['chaisis_image']=$imagename['chaisis_image'];
        $customerVehicleData['created_by']=Session::get('user')->id;
        CustomerVehicle::create($customerVehicleData);

        $this->showSearchMobile=false;
        $this->showVehicleForm=true;
        $this->showVehicleAvailable=true;
        $this->showCustomerForm=false;
        $this->numberPlateAddForm=true;
        $this->otherVehicleDetailsForm=false;

        
        /*$this->showVehicleFormDiv=false;
        $this->newVehicleAdd = false;
        $this->showVehicleDiv = true;
        $this->showCustomerFormDiv = false;

        $this->showVehicleFormDiv=false;
        $this->showCustomerFormDiv=false;
        $this->numberPlateAddForm=true;
        $this->otherVehicleForm=false;*/

        $this->getVehicleCustomer();
        session()->flash('success', 'Vehicle is Added  Successfully !');        
    }

    public function selectVehicle($customers){
        
        $customers = json_decode($customers);
        
        $this->showCustomerSearch=false;
        $this->selectedCustomerVehicle=true;
        $this->selectedCustomerVehicle=true;
        $this->showServiceGroup = true;
        $this->showVehicleAvailable = false;

        $this->sCtmrVhlcustomer_vehicle_id = $customers->customer_vehicle_id;
        $this->sCtmrVhlvehicle_image =  $customers->vehicle_image;
        $this->sCtmrVhlvehicleName =  $customers->vehicleName;
        $this->sCtmrVhlmake_model =  $customers->model;
        $this->sCtmrVhlplate_number =  $customers->plate_number_final;
        $this->sCtmrVhlchassis_number =  $customers->chassis_number;
        $this->sCtmrVhlvehicle_km =  $customers->vehicle_km;
        $this->sCtmrVhlname =  $customers->name;
        $this->sCtmrVhlcustomerType =  $customers->customerType;
        $this->sCtmrVhlemail =  $customers->email;
        $this->sCtmrVhlmobile =  $customers->mobile;

        $this->selected_vehicle_id = $customers->customer_vehicle_id;
        $this->customer_id = $customers->customer_id;
        $this->customer_type = $customers->customer_type;
        $this->mobile = $customers->mobile;
        $this->name = $customers->name;
        $this->email = $customers->email;
        
        $this->cartItems = CustomerBasket::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id])->get();
        $this->cartItemCount = count($this->cartItems); 
        if(count($this->cartItems))
        {
            $this->cardShow=true;
        }
        else
        {
            $this->cardShow=false;
        }
        
        $pendingjob = Customerjobs::where(['job_create_status'=>0,'customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id])->first();
        if($pendingjob)
        {
            $this->job_number = $pendingjob->job_number;
            $this->total_price = $pendingjob->total_price;
            $this->vat = $pendingjob->vat;
            $this->grand_total = $pendingjob->grand_total;
            $this->showCheckList=false;
            $this->showCheckout =true;
            $this->cardShow=false;
        }
        

    }

    public function showNewKM(){
        
        if($this->vehicleNewKM){
            $this->showVehicleNewKM= true;    
        }
        else{
            $this->showVehicleNewKM= false;
        }
        
    }

    public function editCustomer(){
        $this->showCustomerSearch=true;
        $this->showSearchMobile=true;
        $this->showCustomerForm=true;
        $this->showCustomerFormDiv= true;
        $this->updateCustomerFormDiv= true;
    }

    public function updateCustomer(){
        
        $validatedData = $this->validate([
            'mobile' => 'required|min:9|max:10',
            'name' => 'required',
            'email' => 'required|email',
            'customer_type' => 'required',
        ]);

        $customerUpdateData['mobile'] = $this->mobile;
        $customerUpdateData['name'] = $this->name;
        $customerUpdateData['email'] = $this->email;
        $customerUpdateData['customer_type'] = $this->customer_type;

        $imagename['customer_id_image']='';
        if($this->customer_id_image)
        {
            $imagename['customer_id_image'] = $this->customer_id_image->store('customer_id', 'public');
        }
        
        Customers::where(['id'=>$this->customer_id])->update($customerUpdateData);

        $this->showCustomerFormDiv= false;
        $this->updateCustomerFormDiv= false;
        $this->showCustomerSearch=false;
        $this->selectedCustomerVehivleDetails($this->selected_vehicle_id);
        session()->flash('success', 'Customer details updated Successfully !');
    }

    public function selectedCustomerVehivleDetails($customerVehiceId){
        
        $this->cartItems = CustomerBasket::where(['customer_id'=>$this->customer_id, 'vehicle_id'=>$this->selected_vehicle_id])->get();
        $this->cartItemCount = count($this->cartItems); 
        //dd($this);
        if(count($this->cartItems))
        {
            $this->cardShow=true;
        }
        else
        {
            $this->cardShow=false;
        }

        $selectedCustomerVehicleDetails = CustomerVehicle::select(
            'customers.*',
            'customer_vehicles.id as customer_vehicle_id',
            'customer_vehicles.customer_id',
            'customer_vehicles.vehicle_type',
            'customer_vehicles.vehicle_image',
            'customer_vehicles.make as vehicleName',
            'customer_vehicles.model',
            'customer_vehicles.plate_number_final',
            'customer_vehicles.chassis_number',
            'customer_vehicles.vehicle_km',
            'customertypes.customer_type as customerType',
        )
        ->join('customers', 'customer_vehicles.customer_id', '=', 'customers.id')
        ->join('customertypes', 'customertypes.id', '=', 'customers.customer_type')
        ->where(['customer_vehicles.id'=>$customerVehiceId])->first();
        //dd($selectedCustomerVehicleDetails);
        $this->sCtmrVhlcustomer_vehicle_id = $selectedCustomerVehicleDetails->customer_vehicle_id;
        $this->sCtmrVhlvehicle_image =  $selectedCustomerVehicleDetails->vehicle_image;
        $this->sCtmrVhlvehicleName =  $selectedCustomerVehicleDetails->vehicleName;
        $this->sCtmrVhlmake_model =  $selectedCustomerVehicleDetails->model;
        $this->sCtmrVhlplate_number =  $selectedCustomerVehicleDetails->plate_number_final;
        $this->sCtmrVhlchassis_number =  $selectedCustomerVehicleDetails->chassis_number;
        $this->sCtmrVhlvehicle_km =  $selectedCustomerVehicleDetails->vehicle_km;
        $this->sCtmrVhlname =  $selectedCustomerVehicleDetails->name;
        $this->sCtmrVhlcustomerType =  $selectedCustomerVehicleDetails->customerType;
        $this->sCtmrVhlemail =  $selectedCustomerVehicleDetails->email;
        $this->sCtmrVhlmobile =  $selectedCustomerVehicleDetails->mobile;
    }

    public function updatePayment($job_number, $payment_status){
        
        $this->payment_status = $payment_status;
        Customerjobs::where(['job_number'=>$job_number])->update(['payment_status'=>$payment_status]);
    }

    public function updateService($services){
        
        $services = json_decode($services);
        $jobServiceId = $services->id;
        $this->job_status = $services->job_status+1;
        $this->job_departent = $services->job_departent+1;
        
        $serviceJobUpdate = [
            'job_status'=>$this->job_status,
            'job_departent'=>$this->job_departent,
        ];
        Customerjobservices::where(['id'=>$jobServiceId])->update($serviceJobUpdate);

        $serviceJobUpdateLog = [
            'job_number'=>$services->job_number,
            'customer_job_service_id'=>$jobServiceId,
            'job_status'=>$this->job_status,
            'job_departent'=>$this->job_departent,
            'job_description'=>json_encode($this),
        ];
        Customerjoblogs::create($serviceJobUpdateLog);
        
        $customerJobServiceDetails = Customerjobservices::where(['job_number'=>$services->job_number])->get();
        $mainJobStatus=true;
        foreach($customerJobServiceDetails as $service)
        {
            if($service->job_status==1)
            {
                $mainJobStatus=false;
                break;
            }
            else
            {
                $mainJobStatus = true;
            }
        }
        if($mainJobStatus==true){
            Customerjobs::where(['job_number'=>$services->job_number])->update($serviceJobUpdate);
        }
        $this->customerjobservices = Customerjobservices::where(['job_number'=>$services->job_number])->get();
        
    }

    
    public function saveVehicleKmReading($id){
        
        $new_vehicle_km = $this->new_vehicle_km;
        CustomerVehicle::find($id)->update(['vehicle_km' => $new_vehicle_km]);
        $this->vehicle_km = $this->new_vehicle_km;
        $this->sCtmrVhlvehicle_km = $this->vehicle_km;
        $this->showServiceType = true;
        $this->vehicleNewKM=false;
        $this->showVehicleNewKM= true;
    }

    public function addNewVehicle($customer){
        
        $customer = json_decode($customer);
        $this->customer_id = $customer->customer_id;
        $this->mobile = $customer->mobile;
        $this->name = $customer->email;
        $this->email = $customer->email;
        $this->customer_type = $customer->customer_type;

        $this->showSearchMobile=true;
        $this->showVehicleForm=true;
        $this->showVehicleAvailable=false;
        $this->showCustomerForm=false;
        $this->numberPlateAddForm=true;
        $this->otherVehicleDetailsForm=true;


        /*$this->showCustomerFormDiv = true;
        $this->newVehicleAdd = true;
        $this->showVehicleDiv = false;*/
    }

    public function serviceGroupForm($service){
        
        //dd($service);
        $service = json_decode($service);
        $this->service_group_id = $service->id;
        $this->service_group_name = $service->service_group_name;
        $this->service_group_code = $service->service_group_code;
        $this->station = $service->station_id;
        $this->service_search='';

        $this->showVehicleDiv = false;
        $this->showVehicleFormDiv=false;
        $this->newVehicleAdd=false;
        $this->showCustomerFormDiv=false;
        $this->selectedCustomerVehicle=true;
        $this->selectedCustomerVehivleDetails($this->selected_vehicle_id);

        $this->customer_id = $this->customer_id;
        $this->vehicle_id = $this->vehicle_id;
        $this->customer_type = $this->customer_type;
        $this->mobile = $this->mobile;
        $this->name = $this->name;
        $this->email = $this->email;
        $this->showServiceType=true;
        $this->selectServicesitems=false;
        $this->showServicesitems=true;
    }

    
    public function showServiceItem(){
        
        //dd($this->customer_type);
        $this->serviceItemsList = ServiceItemsPrice::with('serviceItems')
                    ->where('customer_types','=',$this->customer_type)
                    ->where('start_date', '<=', Carbon::now())
                    ->where(function ($query) {
                            $query->orWhere('end_date', '>=', Carbon::now())
                        ->orWhere('end_date', '=', null ) ;
                        }
                    )
                    ->get();
        $this->showServicesitems=true;
        $this->selectServicesitems=true;
        $this->showServiceType=false;
        //dd($this->serviceItemsList[0]);
    }

    public function showServices(){
        
        $this->showServiceType=true;
        $this->selectServicesitems=false;
    }

    public function getPlateNumber($image){

        

        $plateNumberImage = $this->plateNumberImage->store('platenumber', 'public');

        dd((new TesseractOCR(storage_path().'/app/public/'.$plateNumberImage))->lang('eng')->run());

        /*$ocr = new TesseractOCR();
        $ocr->image(storage_path().'/app/platenumber/'.$plateNumberImage);*/
        $this->plate_number = $ocr->run();
    }

 
    public function saveCustomer(Request $request){
        

        $this->getVehicleCustomer();

        $validatedData = $this->validate([
            'mobile' => 'required|min:9|max:10',
            'name' => 'required',
            'email' => 'required|email',
            'customer_type' => 'required',
            'vehicle_image' => 'required|image|mimes:jpg,jpeg,png,svg,gif|max:10048',
        ]);
        //dd($this);

        
        if($this->make_model)
        $customerVehicle['imagename'] = $this->vehicle_image->store('vehicle', 'public');

        $customerInsert = Customers::create(
            [
                'mobile'=>$this->mobile,
                'name'=>$this->name,
                'email'=>$this->email,
                'customer_type'=>$this->customer_type,
                'is_active'=>1,
            ]
        );
        $customerId = $customerInsert->id;

        CustomerVehicle::create(
            [
                'customer_id'=>$customerId,
                'vehicle_type'=>$this->vehicle_type,
                'vehicle_image'=>$customerVehicle['imagename'],
                'make_model'=>$this->make_model,
                'plate_number'=>$this->plate_number,
                'chassis_number'=>$this->chassis_number,
                'vehicle_km'=>$this->vehicle_km,
                'created_by'=>Session::get('user')->id,
            ]
        );
        
        $this->newVehicleAdd = false;
        $this->showVehicleDiv = true;
        $this->showCustomerFormDiv = false;
        //$this->mobile = $this->mobile;
        //$this->dispatchBrowserEvent('close-form',['modelName'=>'quicklube']);
    }
    

    public function saveCustomerDetails()
    {
        
        $customerId = $this->customer_id;
        $updateData = [
            'mobile' => $this->mobile,
            'name' => $this->name,
            'email' => $this->email,
            'customer_type' => $this->customer_type,
        ];
        
        Customers::find($customerId)->update($updateData);
    }

    public function getVehicleCustomer()
    {
        
        $this->customers = CustomerVehicle::select(
                'customers.*',
                'customer_vehicles.id as customer_vehicle_id',
                'customer_vehicles.customer_id',
                'customer_vehicles.vehicle_type',
                'customer_vehicles.vehicle_image',
                'customer_vehicles.make as vehicleName',
                'customer_vehicles.model',
                'customer_vehicles.plate_number_final',
                'customer_vehicles.chassis_number',
                'customer_vehicles.vehicle_km',
                'customertypes.customer_type as customerType',
            )
            ->join('customers', 'customer_vehicles.customer_id', '=', 'customers.id')
            ->join('customertypes', 'customertypes.id', '=', 'customers.customer_type')
            ->where('customers.mobile', 'like', "%{$this->mobile}%")
            ->where('customer_vehicles.plate_state', 'like', "%{$this->plate_state}%")
            ->where('customer_vehicles.plate_code', 'like', "%{$this->plate_code}%")
            ->where('customer_vehicles.plate_number', 'like', "%{$this->plate_number}%")->get();
        //dd($this->customers);
    }
    
    public function getServiceType()
    {
        $this->servicesTypesList = ServicesType::select(
            'services.*',

            'services_types.id AS service_type_id',
            'services_types.service_type_name',
            'services_types.service_type_code',
            'services_types.service_type_description',
            'services_types.service_type_group',
            'services_types.department',
            'services_types.section',
            'services_types.station',
            'services_groups.service_group_name',
            'services_groups.service_group_code',
        )
        ->join('services', 'services_types.id', '=', 'services.service_type_id')
        ->join('services_groups', 'services_groups.id', '=', 'services_types.service_group_id')
        ->where(
            [
                'services.customer_type'=> $this->customer_type,
                'services_types.service_type_group' => $this->service_group_id,
                'services_types.station'=>$this->station,
            ]
        )->get();
        $this->showServiceType = true;
        
    }

    
    public function addtoCartItem($items)
    {
        $items = json_decode($items);
        $itemsDetails = $items->service_items;
        $itemBrand = $itemsDetails->item_brand;
        $itemsCategory = $itemsDetails->item_category;
        $itemsGroup = $itemsDetails->product_group;

        if(CustomerBasket::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id])->count())
        {
            CustomerBasket::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id])->increment('quantity', 1);
        }
        else
        {
            $cartInsert = [
                'customer_id'=>$this->customer_id,
                'vehicle_id'=>$this->selected_vehicle_id,
                'item_id'=>$itemsDetails->id,
                'item_code'=>$itemsDetails->item_code,
                'item_name' => $itemsDetails->item_name,
                'brand_id' => $itemBrand->id,
                'brand_name' => $itemBrand->brand_name,
                'category_id' => $itemsCategory->id,
                'category_name' => $itemsCategory->category_name,
                'item_group_id'=> $itemsGroup->id,
                'item_group_id'=> $itemsGroup->id,
                'item_group_name'=> $itemsGroup->product_group_name,
                'service_item'=>true,
                //'department_id' => $serviceType->department_id,
                //'section_id'=>$serviceType->service_group_id,
                'station_id'=>$this->station,
                'price'=>$items->sale_price,
                'quantity'=>1,
            ];
            CustomerBasket::insert($cartInsert);
        }
        $this->cartItems = CustomerBasket::where(['customer_id'=>$this->customer_id, 'vehicle_id'=>$this->selected_vehicle_id])->get();
        $this->cartItemCount = count($this->cartItems); 
        if(count($this->cartItems))
        {
            $this->cardShow=true;
        }
        else
        {
            $this->cardShow=false;
        }
        
        
        

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Added to Cart Successfully',
            'text' => 'service added..!',
            'cartitemcount'=>1
        ]);

    }

    public function addtoCart($serviceType)
    {
        
        $serviceType = json_decode($serviceType);
        //dd($serviceType->service_type_id);
        if(CustomerBasket::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id,'service_type_id'=>$serviceType->service_type_id])->count())
        {
            CustomerBasket::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id,'service_type_id'=>$serviceType->service_type_id])->increment('quantity', 1);
        }
        else
        {
            $cartInsert = [
                'customer_id'=>$this->customer_id,
                'vehicle_id'=>$this->selected_vehicle_id,
                'service_type_id'=>$serviceType->service_type_id,
                'service_type_name'=>$serviceType->service_type_name,
                'service_type_code'=>$serviceType->service_type_id,
                'service_group_id'=>$serviceType->service_group_id,
                'service_group_name'=>$serviceType->service_group_name,
                'service_group_code'=>$serviceType->service_group_code,
                'service_item'=>false,
                'department_id' => $serviceType->department_id,
                //'section_id'=>$serviceType->service_group_id,
                'station_id'=>$this->station,
                'price'=>$serviceType->unit_price,
                'quantity'=>1,
            ];
            CustomerBasket::insert($cartInsert);
        }
        $this->cartItems = CustomerBasket::where(['customer_id'=>$this->customer_id, 'vehicle_id'=>$this->selected_vehicle_id])->get();
        $this->cartItemCount = count($this->cartItems); 
        if(count($this->cartItems))
        {
            $this->cardShow=true;
        }
        else
        {
            $this->cardShow=false;
        }
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Added to Cart Successfully',
            'text' => 'service added..!',
            'cartitemcount'=>\Cart::getTotalQuantity()
        ]);
        //session()->flash('cartsuccess', 'Service is Added to Cart Successfully !');
    }


    public function updateCart()
    {
        
        \Cart::update($this->cartItems['id'], [
            'quantity' => [
                'relative' => false,
                'value' => $this->quantity
            ]
        ]);
        if(!empty($this->cartItems))
        {
            $this->cardShow=true;
        }
        else
        {
         $this->cardShow=false;   
        }
        //$this->getServiceType();
        $this->emit('cartUpdated');
    }

    public function removeCart($id)
    {
        
        CustomerBasket::find($id)->delete();
        $this->cartItems = CustomerBasket::where(['customer_id'=>$this->customer_id, 'vehicle_id'=>$this->selected_vehicle_id])->get();
        $this->cartItemCount = count($this->cartItems); 
        if(count($this->cartItems))
        {
            $this->cardShow=true;
        }
        else
        {
            $this->cardShow=false;
        }
        
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Service has removed',
            'text' => 'service added..!',
            'cartitemcount'=>\Cart::getTotalQuantity()
        ]);
        //session()->flash('cartsuccess', 'Service has removed !');
    }

    public function clearAllCart()
    {
        
        CustomerBasket::where(['customer_id'=>$this->customer_id, 'vehicle_id'=>$this->selected_vehicle_id])->delete();
        $this->cartItems = CustomerBasket::where(['customer_id'=>$this->customer_id, 'vehicle_id'=>$this->selected_vehicle_id])->get();
        $this->cartItemCount = count($this->cartItems); 
        
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'All Service Cart Clear Successfully !',
            'text' => 'service added..!',
            'cartitemcount'=>\Cart::getTotalQuantity()
        ]);
        $this->cardShow=false;
        //session()->flash('cartsuccess', 'All Service Cart Clear Successfully !');
    }

    public function submitService(){
        $cartDetails = $this->cartItems;
        $this->cartItemCount = count($this->cartItems); 
        $this->total=0;
        
        $this->showVehicleAvailable=false;
        foreach($this->cartItems as $items)
        {
            if($this->station==null){
                $this->station = $items->station_id;
            }

            if($items->service_group_id==4){
                $this->showCheckList=true;
                $this->showGSCheckList=true;
                $this->showServiceGroup=false;
                $this->cardShow=false;
                $this->showCheckout=false;
                $this->checklistLabels = ServiceChecklist::where(['service_group_id'=>4])->get();
            }
            else if($items->service_item==false && ($items->service_group_id==7))
            {
                $this->showCheckList=true;  
                $this->showQLCheckList=true;
                $this->showServiceGroup=false;
                $this->cardShow=false;
                $this->showCheckout=false;
            }
            else
            {
                $this->showCheckList=false;
                $this->showServiceGroup=false;
                $this->cardShow=false;
                $this->createJob();
                $this->showCheckout=true;
            }

            $this->total = $this->total+($items->quantity*$items->price);
        }
        $this->tax = $this->total * (config('global.TAX_PERCENT') / 100);
        $this->grand_total = $this->total  * ((100 + config('global.TAX_PERCENT')) / 100);


        $this->dispatchBrowserEvent('imageUpload');
        //$this->dispatchBrowserEvent('showSignature'); 
        
        //$this->dispatchBrowserEvent('showSignature'); 
        /*$this->showServiceGroup=false;
        $this->cardShow=false;
        $this->showCheckout=true;*/
        //dd($this->cartItems);
    }

    public function markScrach($imageId){
        $this->markCarScratch=true;
        $imageVal = '';
        $imageVal = $imageId;
        $this->dispatchBrowserEvent('loadCarImage',['imgId'=>$imageVal]);
    }

    public function closeMarkScrach(){
        $this->markCarScratch=false;
        $this->dispatchBrowserEvent('hideCarScratchImageh');
    }

    public function clickShowSignature()
    {
        $this->dispatchBrowserEvent('showSignature');

    }

    public function clearSignature(){
        $this->dispatchBrowserEvent('clearSignature'); 
    }

    public function saveSignature(){
        $this->dispatchBrowserEvent('saveSignature'); 
    }

    public function createJob(){
        
        $cartDetails = $this->cartItems;
        $this->cartItemCount = count($this->cartItems); 
        $customerVehicleId = $this->selected_vehicle_id;
        $customerId = $this->customer_id;
        $vehicleDetails = CustomerVehicle::find($customerVehicleId);
        
        $total=0;
        $serviceIncludeArray=[];
        $gsQlIn = false;
        foreach($cartDetails as $item)
        {
            $total = $total+($item->quantity*$item->price);
            if($item->service_group_code=='GS'  || $item->service_group_code=='QL')
            {
                $gsQlIn=true;
            }
        }
        if($gsQlIn==true)
        {
            $validatedData = $this->validate([
                'fuel' => 'required',
                'scratchesFound' => 'required',
                'scratchesNotFound' => 'required',
                /*'vImageR1' => 'required',
                'vImageR2' => 'required',
                'vImageF' => 'required',
                'vImageB' => 'required',
                'vImageL1' => 'required',
                'vImageL2' => 'required',*/
            ]);
        }

        
        $this->tax = $total * (config('global.TAX_PERCENT') / 100);
        $this->grand_total = $total  * ((100 + config('global.TAX_PERCENT')) / 100);
        
        
        $customerjobId = Customerjobs::create(
            [
                'job_number'=>$this->service_group_code.Carbon::now()->format('y').Carbon::now()->format('m').Carbon::now()->format('d').rand(1,1000),
                'job_date_time'=>Carbon::now(),
                'customer_id'=>$this->customer_id,
                'customer_type'=>$this->customer_type,
                'vehicle_id'=>$vehicleDetails->id,
                'vehicle_type'=>isset($vehicleDetails->vehicle_type)?$vehicleDetails->vehicle_type:0,
                'make'=>$vehicleDetails->make,
                'vehicle_image'=>$vehicleDetails->vehicle_image,
                'model'=>$vehicleDetails->model,
                'plate_number'=>$vehicleDetails->plate_number_final,
                'chassis_number'=>$vehicleDetails->chassis_number,
                'vehicle_km'=>$vehicleDetails->vehicle_km,
                'station_id'=>$this->station,
                'total_price'=>$total,
                'vat'=>$this->tax,
                'grand_total'=>$this->grand_total,
                'job_status'=>1,
                'job_departent'=>1,
                'payment_status'=>0,
                'created_by'=>Session::get('user')->id,
            ]
        );
        $this->job_number = $this->service_group_code.Carbon::now()->format('y').Carbon::now()->format('m').Carbon::now()->format('d').$customerjobId->id;
        Customerjobs::where(['id'=>$customerjobId->id])->update(['job_number'=>$this->job_number]);

        //dd($cartDetails);
        foreach($cartDetails as $cartData)
        {
            $serviceItemTax = $cartData->price * (config('global.TAX_PERCENT') / 100);
            $serviceGrandTotal = $cartData->price  * ((100 + config('global.TAX_PERCENT')) / 100);
            $customerJobServiceData = [
                'job_number'=>$this->job_number,
                'job_id'=>$customerjobId->id,
                'total_price'=>$cartData->price,
                'quantity'=>$cartData->quantity,
                'vat'=>$serviceItemTax,
                'grand_total'=>$serviceGrandTotal,
                'job_status'=>1,
                'job_departent'=>1,
                'is_added'=>0,
                'is_removed'=>0,
                'created_by'=>Session::get('user')->id,
            ];
            if($cartData->service_item==true)
            {
                $customerJobServiceData['service_item']=$cartData->service_item;
                $customerJobServiceData['item_id']=$cartData->item_id;
                $customerJobServiceData['item_code']=$cartData->item_code;
                $customerJobServiceData['item_name']=$cartData->item_name;
                $customerJobServiceData['brand_id']=$cartData->brand_id;
                $customerJobServiceData['brand_name']=$cartData->brand_name;
                $customerJobServiceData['category_id']=$cartData->category_id;
                $customerJobServiceData['category_name']=$cartData->category_name;
                $customerJobServiceData['item_group_id']=$cartData->item_group_id;
                $customerJobServiceData['product_group_name']=$cartData->product_group_name;
            }
            else
            {
                $customerJobServiceData['service_item']=$cartData->service_item;
                $customerJobServiceData['service_group_id']=$cartData->service_group_id;
                $customerJobServiceData['service_group_code']=$cartData->service_group_code;
                $customerJobServiceData['service_group_name']=$cartData->service_group_name;
                $customerJobServiceData['service_type_id']=$cartData->service_type_id;
                $customerJobServiceData['service_type_code']=$cartData->service_type_code;
                $customerJobServiceData['service_type_name']=$cartData->service_type_name;
            }

            $customerJobServiceId = Customerjobservices::create($customerJobServiceData);

            Customerjoblogs::create([
                'job_number'=>$this->job_number,
                'job_status'=>1,
                'job_departent'=>1,
                'job_description'=>json_encode($customerJobServiceData),
                'customer_job_service_id'=>$customerJobServiceId->id,
                'created_by'=>Session::get('user')->id,
            ]);
        }


        //dd($this);
        $vehicle_image = [
            'vImageR1'=>$this->vImageR1,
            'vImageR2'=>$this->vImageR2,
            'vImageF'=>$this->vImageF,
            'vImageB'=>$this->vImageB,
            'vImageL1'=>$this->vImageL1,
            'vImageL2'=>$this->vImageL2,
        ];

        $checkListEntryData = [
            'job_number'=>$this->job_number,
            'job_id'=>$customerjobId->id,
            'checklist'=>json_encode($this->checklistLabel),
            'fuel'=>$this->fuel,
            'scratches_found'=>$this->scratchesFound,
            'scratches_notfound'=>$this->scratchesNotFound,
            'vehicle_image'=>json_encode($vehicle_image),
            'signature'=>$this->customerSignature,
            //'created_by'=>Session::get('user')->id,
        ];
        $checkListEntryInsert = VehicleChecklistEntry::create($checkListEntryData);

        $this->showCheckList=false;
        $this->showCheckout =true;


    }
    
    public function payLater()
    {
        Customerjobs::where(['job_number'=>$this->job_number])->update(['job_create_status'=>0]);
        $this->successPage=true;
        $this->showCheckout =false;
        $this->cardShow=false;
        $this->showServiceGroup=false;
    }

    public function compleSubmitService(){
        
        $cartDetails = $this->cartItems;
        $this->cartItemCount = count($this->cartItems); 
        $customerVehicleId = $this->selected_vehicle_id;
        $customerId = $this->customer_id;
        $vehicleDetails = CustomerVehicle::find($customerVehicleId);
        
        $total=0;
        foreach($cartDetails as $item)
        {
            $total = $total+($item->quantity*$item->price);
        }
        $tax = $total * (config('global.TAX_PERCENT') / 100);
        $grand_total = $total  * ((100 + config('global.TAX_PERCENT')) / 100);
        
        
        $customerjobId = Customerjobs::create(
            [
                'job_number'=>$this->service_group_code.Carbon::now()->format('y').Carbon::now()->format('m').Carbon::now()->format('d').rand(1,1000),
                'job_date_time'=>Carbon::now(),
                'customer_id'=>$this->customer_id,
                'customer_type'=>$this->customer_type,
                'vehicle_id'=>$vehicleDetails->id,
                'vehicle_type'=>isset($vehicleDetails->vehicle_type)?$vehicleDetails->vehicle_type:0,
                'make'=>$vehicleDetails->make,
                'vehicle_image'=>$vehicleDetails->vehicle_image,
                'model'=>$vehicleDetails->model,
                'plate_number'=>$vehicleDetails->plate_number_final,
                'chassis_number'=>$vehicleDetails->chassis_number,
                'vehicle_km'=>$vehicleDetails->vehicle_km,
                'station_id'=>$this->station,
                'total_price'=>$total,
                'vat'=>$tax,
                'grand_total'=>$grand_total,
                'job_status'=>1,
                'job_departent'=>1,
                'payment_status'=>0,
                'created_by'=>Session::get('user')->id,
            ]
        );
        $this->job_number = $this->service_group_code.Carbon::now()->format('y').Carbon::now()->format('m').Carbon::now()->format('d').$customerjobId->id;
        Customerjobs::where(['id'=>$customerjobId->id])->update(['job_number'=>$this->job_number]);

        foreach($cartDetails as $cartData)
        {
            $serviceItemTax = $cartData['price'] * (config('global.TAX_PERCENT') / 100);
            $serviceGrandTotal = $cartData['price']  * ((100 + config('global.TAX_PERCENT')) / 100);
            $customerJobServiceData = [
                'job_number'=>$this->job_number,
                'job_id'=>$customerjobId->id,
                'total_price'=>$cartData['price'],
                'quantity'=>$cartData['quantity'],
                'vat'=>$serviceItemTax,
                'grand_total'=>$serviceGrandTotal,
                'job_status'=>1,
                'job_departent'=>1,
                'is_added'=>0,
                'is_removed'=>0,
                'created_by'=>Session::get('user')->id,
            ];
            if($cartData['attributes']['service_item']==true)
            {
                $customerJobServiceData['service_item']=$cartData['attributes']['service_item'];
                $customerJobServiceData['item_id']=$cartData['attributes']['item_id'];
                $customerJobServiceData['item_code']=$cartData['attributes']['item_code'];
                $customerJobServiceData['item_name']=$cartData['attributes']['item_name'];
                $customerJobServiceData['brand_id']=$cartData['attributes']['brand_id'];
                $customerJobServiceData['brand_name']=$cartData['attributes']['brand_name'];
                $customerJobServiceData['category_id']=$cartData['attributes']['category_id'];
                $customerJobServiceData['category_name']=$cartData['attributes']['category_name'];
                $customerJobServiceData['item_group_id']=$cartData['attributes']['item_group_id'];
                $customerJobServiceData['product_group_name']=$cartData['attributes']['product_group_name'];
            }
            else
            {
                $customerJobServiceData['service_item']=$cartData['attributes']['service_item'];
                $customerJobServiceData['service_group_id']=$cartData['attributes']['service_group_id'];
                $customerJobServiceData['service_group_code']=$cartData['attributes']['service_group_code'];
                $customerJobServiceData['service_group_name']=$cartData['attributes']['service_group_name'];
                $customerJobServiceData['service_type_id']=$cartData['id'];
                $customerJobServiceData['service_type_code']=$cartData['attributes']['service_type_code'];
                $customerJobServiceData['service_type_name']=$cartData['name'];
            }

            $customerJobServiceId = Customerjobservices::create($customerJobServiceData);

            Customerjoblogs::create([
                'job_number'=>$this->job_number,
                'job_status'=>1,
                'job_departent'=>1,
                'job_description'=>json_encode($customerJobServiceData),
                'customer_job_service_id'=>$customerJobServiceId->id,
                'created_by'=>Session::get('user')->id,
            ]);
        }
        $this->showServiceType=false;
        $this->showServicesitems =false;
        $this->showServiceGroup=false;
        $this->dispatchBrowserEvent('showPaymentPannel');
    }


    public function useSignature(){
        dd($this->customerSignature);
        $this->dispatchBrowserEvent('saveSignature'); 
    }

    public function saveCheckList(){
        dd($this->customerSignature);
    }

    public function resendPaymentLink($job_number){
        $customerjobs = Customerjobs::
            select('customerjobs.*','customers.name','customers.email','customers.mobile','customertypes.customer_type as customerType')
            ->join('customers','customers.id','=','customerjobs.customer_id')
            ->join('customertypes','customertypes.id','=','customerjobs.customer_type')
            ->where(['customerjobs.job_number'=>$job_number])
            ->take(5)->first();
        $response = Http::withBasicAuth('20092622', 'buhaleeba@123')->post("https://mshastra.com/sendurlcomma.aspx?user=20092622&pwd=buhaleeba@123&senderid=BuhaleebaRE&mobileno=971566993709&msgtext=".urlencode('Job Id #'.$customerjobs->job_number.' is processing, Please click complete payment '.$customerjobs->payment_link)."&CountryCode=ALL");
    }

    public function completePaymnet($mode,$job_number){
        $customerjobs = Customerjobs::
        select('customerjobs.*','customers.name','customers.email','customers.mobile','customertypes.customer_type as customerType')
        ->join('customers','customers.id','=','customerjobs.customer_id')
        ->join('customertypes','customertypes.id','=','customerjobs.customer_type')
        ->where(['customerjobs.job_number'=>$job_number])
        ->take(5)->first();

        $mobileNumber = '971'.substr($customerjobs->mobile, -9);
        if($mode=='link')
        {
            $paymentLink = $this->sendPaymentLink($customerjobs);
            //dd($paymentLink);
            $paymentResponse = (array)json_decode($paymentLink->data);
            if(array_key_exists('payment_link', $paymentResponse))
            {
                $response = Http::withBasicAuth('20092622', 'buhaleeba@123')->post("https://mshastra.com/sendurlcomma.aspx?user=20092622&pwd=buhaleeba@123&senderid=BuhaleebaRE&mobileno=".$mobileNumber."&msgtext=".urlencode('Job Id #'.$job_number.' is processing, Please click complete payment '.$paymentResponse['payment_link'])."&CountryCode=ALL");


                $customerjobId = Customerjobs::where(['job_number'=>$job_number])->update(['payment_type'=>1,'payment_link'=>$paymentResponse['payment_link'],'payment_response'=>json_encode($paymentResponse),'payment_request'=>'link_send','job_create_status'=>1]);

                CustomerBasket::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id])->delete();

                $this->successPage=true;
                $this->showCheckout =false;
                $this->cardShow=false;
                $this->showServiceGroup=false;
                
            }
            else
            {
                session()->flash('error', $paymentResponse['response_message']);

            }
            
        }
        else if($mode=='card')
        {
            $customerjobId = Customerjobs::where(['job_number'=>$job_number])->update(['payment_type'=>2,'payment_request'=>'card payment','job_create_status'=>1]);

            $response = Http::withBasicAuth('20092622', 'buhaleeba@123')->post("https://mshastra.com/sendurlcomma.aspx?user=20092622&pwd=buhaleeba@123&senderid=BuhaleebaRE&mobileno=".$mobileNumber."&msgtext=".urlencode('Job Id #'.$job_number.' is processing, Complete your payment and proceed. Visit '.url('qr/'.$job_number).' for the updates and gate pass')."&CountryCode=ALL");

            CustomerBasket::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id])->delete();

            $this->successPage=true;
            $this->showCheckout =false;
            $this->cardShow=false;
            $this->showServiceGroup=false;
            
        }
        else if($mode=='cash')
        {
            $customerjobId = Customerjobs::where(['job_number'=>$job_number])->update(['payment_type'=>3,'payment_request'=>'cash payment','job_create_status'=>1]);
            
            $response = Http::withBasicAuth('20092622', 'buhaleeba@123')->post("https://mshastra.com/sendurlcomma.aspx?user=20092622&pwd=buhaleeba@123&senderid=BuhaleebaRE&mobileno=".$mobileNumber."&msgtext=".urlencode('Job Id #'.$job_number.' is processing, Visit '.url('qr/'.$job_number).' for the updates and gate pass')."&CountryCode=ALL");
            
            CustomerBasket::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id])->delete();

            $this->successPage=true;
            $this->showCheckout =false;
            $this->cardShow=false;
            $this->showServiceGroup=false;
        }

        
        
    }

    public function sendPaymentLink($customerjobs)
    {
        
        $exp_date = Carbon::now('+10:00')->format('Y-m-d\TH:i:s\Z');
        $order_billing_name = $customerjobs->name;
        $order_billing_phone = $customerjobs->mobile;
        $order_billing_email = $customerjobs->email; 
        $total = round(($customerjobs->grand_total * 100),2);
        $merchant_reference = $customerjobs->job_number;
        $order_billing_phone = str_replace(' ', '', $order_billing_phone);
        if($order_billing_phone[0] != 0 and $order_billing_phone[1] != 0)
        {
            if($order_billing_phone[0] == '+')
            {
                $order_billing_phone = substr_replace($order_billing_phone, '00', 0, 1);
            }
            else
            {
               $order_billing_phone = preg_replace('/0/', '00971', $order_billing_phone, 1);
            }
        }

        $arrData    = [
            'service_command'=>'PAYMENT_LINK',
            'access_code'=>'CIjX6aY6Yc0FgGktyo4I',
            'merchant_identifier'=>'WQNoWgPx',
            'merchant_reference'=>$merchant_reference,
            'amount'=>$total,
            'currency'=>'AED',
            'language'=>'en',
            'customer_email'=>$order_billing_email,
            'request_expiry_date'=>$exp_date,
            'notification_type'=>'EMAIL,SMS',
            'order_description'=>'GSS Service #'.$merchant_reference,
            'customer_name'=>$order_billing_name,
            'customer_phone'=>$order_billing_phone,
            'return_url'=>url('order-response'),
        ];

        
        $response = Http::withBasicAuth('onlinewebtutor', 'admin123')->post('http://172.23.25.95/gssapi/api/new-payment-link',$arrData);
        return json_decode($response);
    }

    public function dashCustomerJobUpdate($job_number)
    {

        return redirect()->to('/customer-job-update/'.$job_number);
    }

    public function jobListPage($filter)
    {
        return redirect()->to('/jobs-filter/'.$filter);
    }
    
}
