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
use App\Models\ServicesSectionsGroup;
use App\Models\ServiceMaster;
use App\Models\ServicesPrices;

use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Http;
use LaravelPayfort\Facades\Payfort;
use Illuminate\Support\Facades\Hash;

class Dashboard extends Component
{
    use WithFileUploads;
    public $newVehicleSearch=true, $newcustomeoperation=false, $showSearchModelView=false, $showCustomerSearch=false;
    public $mobile,$plate_state, $plate_code, $plate_number;
    public $name, $email, $customer_type=23, $customer_id_image;
    public $plate_number_final, $vehicle_image,$listVehiclesMake, $vehicle_type, $make, $vehiclesModelList, $model, $chassis_number,$vehicle_km,$plate_number_image,$chaisis_image;
    public $showDashboard = true, $showSearchMobile=true, $showVehicleAvailable=false, $showCustomerForm=false, $otherVehicleDetailsForm=false, $numberPlateAddForm = true, $showVehicleForm=true, $showServiceGroup = false, $showFormBoxClose=false;
    public $customers, $stateList, $customerTypeList, $vehicleTypesList, $servicesGroupList;
    public $customer_id, $vehicle_id;
    public $selectedCustomerVehicle = false;
    public $selectedVehicleInfo, $sCtmrVhlcustomer_vehicle_id, $sCtmrVhlvehicle_image, $sCtmrVhlvehicleName, $sCtmrVhlmake_model, $sCtmrVhlplate_number, $sCtmrVhlchassis_number, $sCtmrVhlvehicle_km, $sCtmrVhlname, $sCtmrVhlcustomerType, $sCtmrVhlemail, $sCtmrVhlmobile;
    public $editCustomerAndVehicle=false;
    public $cartItemsInService;

    public function newVehicleOpen(){

        $this->selectedVehicleInfo = null;
        $this->editCustomerAndVehicle=false;
        $this->customer_id=null;
        $this->selected_vehicle_id = null;
        $this->customer_id = null;
        $this->customer_type = null;
        $this->mobile = null;
        $this->name = null;
        $this->email = null;
        $this->plate_state = null;
        $this->plate_code = null;
        $this->plate_number = null;
        //$this->vehicle_image = null;
        $this->vehicle_type = null;
        $this->make = null;
        $this->model = null;
        $this->plate_number_image = null;
        $this->chaisis_image = null;
        $this->chassis_number = null;
        $this->vehicle_km = null;

        $this->newcustomeoperation=true;
        $this->showSearchModelView=false;
        $this->showCustomerSearch=true;
        $this->showDashboard=false;

        $this->selectedCustomerVehicle=false;
        $this->cardShow=false;
        $this->showServiceGroup=false;
        $this->showCheckList=false;
        $this->showCheckout=false;
        $this->successPage=false;

        $this->showCustomerForm=false;
        $this->otherVehicleDetailsForm=false;


        
        //Get all service group list
        //$this->servicesGroupList = ServicesGroup::where(['is_active'=>1])->get();
    }

    public function searchResult(){
        $this->showDashboard=false;
        
        if( (!empty($this->mobile))){
            $this->getVehicleCustomer();
            if(count($this->customers)>0)
            {
                $this->showVehicleAvailable=true;
                $this->showCustomerForm=false;
                $this->otherVehicleDetailsForm=false;
            }
            else
            {
                $this->showVehicleForm=true;
                $this->showVehicleAvailable=false;
                $this->showCustomerForm=true;
                $this->numberPlateAddForm=true;
                $this->otherVehicleDetailsForm=true;
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
            }
            else
            {
                $this->showSearchMobile=true;
                $this->showVehicleForm=true;
                $this->showVehicleAvailable=false;
                $this->showCustomerForm=true;
                $this->numberPlateAddForm=true;
                $this->otherVehicleDetailsForm=true;
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

        }

        $this->dispatchBrowserEvent('selectSearchEvent'); 
    }

    public function getVehicleCustomer(){
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

        $this->selectedCustomerVehicle=true;
        $this->newcustomeoperation=false;

        $this->showVehicleAvailable=true;

        /*$this->showSearchMobile=false;
        $this->showVehicleForm=true;
        $this->showVehicleAvailable=true;
        $this->showCustomerForm=false;
        $this->numberPlateAddForm=true;
        $this->otherVehicleDetailsForm=false;*/

        
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
        //dd($customers);

        $this->selectedCustomerVehicle=true;
        $this->newcustomeoperation=true;
        $this->showServiceGroup = true;
        $this->showCustomerSearch=false;
        $this->showVehicleAvailable = false;
        $this->showDashboard=false;

        $this->selectedVehicleInfo=$customers;
        /*$this->sCtmrVhlcustomer_vehicle_id = $customers->customer_vehicle_id;
        $this->sCtmrVhlvehicle_image =  $customers->vehicle_image;
        $this->sCtmrVhlvehicleName =  $customers->vehicleName;
        $this->sCtmrVhlmake_model =  $customers->model;
        $this->sCtmrVhlplate_number =  $customers->plate_number_final;
        $this->sCtmrVhlchassis_number =  $customers->chassis_number;
        $this->sCtmrVhlvehicle_km =  $customers->vehicle_km;
        $this->sCtmrVhlname =  $customers->name;
        $this->sCtmrVhlcustomerType =  $customers->customerType;
        $this->sCtmrVhlemail =  $customers->email;
        $this->sCtmrVhlmobile =  $customers->mobile;*/

        $this->selected_vehicle_id = $customers['customer_vehicle_id'];
        $this->customer_id = $customers['customer_id'];
        $this->customer_type = $customers['customer_type'];
        $this->mobile = $customers['mobile'];
        $this->name = $customers['name'];
        $this->email = $customers['email'];
        
        $this->cartItems = CustomerBasket::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id])->get();
        //dd($this->cartItems);
        $this->cartItemCount = count($this->cartItems); 
        if(count($this->cartItems)>0)
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
            //dd($pendingjob);

            $this->job_number = $pendingjob->job_number;
            $this->total_price = $pendingjob->total_price;
            $this->vat = $pendingjob->vat;
            $this->grand_total = $pendingjob->grand_total;
            $this->showCheckList=false;
            $this->showCheckout =false;
            //$this->cardShow=false;
        }
        
        //dd($this->servicesGroupList);
    }

    public function updateVehicleCustomer()
    {
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
            $customerVehicleUpdate['vehicle_image']=$imagename['vehicle_image'];
        }

        $imagename['plate_number_image']='';
        if($this->plate_number_image)
        {
            $imagename['plate_number_image'] = $this->plate_number_image->store('plate_number', 'public');
            $customerVehicleUpdate['plate_number_image']=$imagename['plate_number_image'];
        }

        $imagename['chaisis_image']='';
        if($this->chaisis_image)
        {
            $imagename['chaisis_image'] = $this->chaisis_image->store('chaisis_image', 'public');
            $customerVehicleUpdate['chaisis_image']=$imagename['chaisis_image'];
        }

        if($this->customer_id)
        {
            $customerId = $this->customer_id;
        }
        

        $customerVehicleUpdate['customer_id']=$customerId;
        $customerVehicleUpdate['vehicle_type']=$this->vehicle_type;
        $customerVehicleUpdate['make']=$this->make;
        $customerVehicleUpdate['model']=$this->model;
        $customerVehicleUpdate['plate_state']=$this->plate_state;
        $customerVehicleUpdate['plate_code']=$this->plate_code;
        $customerVehicleUpdate['plate_number']=$this->plate_number;
        $customerVehicleUpdate['plate_number_final']=$this->plate_state.' '.$this->plate_code.' '.$this->plate_number;
        $customerVehicleUpdate['chassis_number']=isset($this->chassis_number)?$this->chassis_number:'';
        $customerVehicleUpdate['vehicle_km']=isset($this->vehicle_km)?$this->vehicle_km:'';
        $customerVehicleUpdate['created_by']=Session::get('user')->id;
        //dd($customerVehicleUpdate);
        CustomerVehicle::where(['id'=>$this->selected_vehicle_id])->update($customerVehicleUpdate);

        /*$this->selectedCustomerVehicle=true;
        $this->newcustomeoperation=false;*/

        $this->showCustomerFormDiv= false;
        $this->updateCustomerFormDiv= false;
        $this->showCustomerSearch=false;
        $this->selectedCustomerVehivleDetails($this->selected_vehicle_id);
        session()->flash('success', 'Customer vehicle details updated Successfully !');

    }













    
    
    //Customer Data
    public $showPayLaterCheckout=false;
    public $updateCustomerFormDiv = false;
    public $updateVehicleFormBtn = false;
    

    //Customer Vehicle
    

    //Search Vehicles
    
    //Selected Customer and Vehilces
    
    
    public $vehicleNewKM = false;
    
    
    
    //Service and itemms
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
    

    
    
    public $servicesTypesList = [];
    public $serviceItemsList = [];


    

    public $search_job_bumber = "";
    public $records;
    public $empDetails;

    public $customerjobservices =array();
    public $customerjoblogs = array();
    public $job_date_time, $customerType, $payment_status=0, $payment_type=0, $job_status, $job_departent, $total_price, $vat;

    public $service_search = "";

    public $turn_key_on_check_for_fault_codes, $start_engine_observe_operation, $reset_the_service_reminder_alert, $stick_update_service_reminder_sticker_on_b_piller, $interior_cabin_inspection_comments, $check_power_steering_fluid_level, $check_power_steering_tank_cap_properly_fixed, $check_brake_fluid_level, $brake_fluid_tank_cap_properly_fixed, $check_engine_oil_level, $check_radiator_coolant_level, $check_radiator_cap_properly_fixed, $top_off_windshield_washer_fluid, $check_windshield_cap_properly_fixed, $underHoodInspectionComments, $check_for_oil_leaks_engine_steering, $check_for_oil_leak_oil_filtering, $check_drain_lug_fixed_properly, $check_oil_filter_fixed_properly, $ubi_comments;

    public $showaddmorebtn = false;

    public $pendingCustomersCart=[];
    public $totalPL, $taxPL, $grand_totalPL;
    public $service_sort=1;


    //Payment

    //Success

    public function render(){
        if(Session::get('user')->user_type!=1){
            $this->showDashboard=false;
        }
        
        //Get Pending Customer
        $this->pendingCustomersCart =  CustomerBasket::with(['customerInfo','vehicleInfo'])->where(['created_by'=>Session::get('user')->id])->get();
        //dd($this->pendingCustomersCart[0]);

        //Get Vehicle Make List
        $this->listVehiclesMake = Vehicles::select('vehicle_make')->distinct()->orderBy('vehicle_make','ASC')->get();

        //Get Vehicle Model List
        $this->vehiclesModel = Vehicles::select('vehicle_model')->distinct()->where(['vehicle_make'=>$this->make])->get();

        //Get Dashboard Pending JObs
        $pendingjobs = Customerjobs::with(['customerInfo','customerVehicle'])->where(['job_create_status'=>0,'created_by'=>Session::get('user')->id])->get();

        //Get all service group list
        $this->servicesGroupList = ServicesGroup::where(['is_active'=>1])->get();

        //Get all Customer Types
        $this->customerTypeList = Customertype::all();

        //Get all state List
        $this->stateList = StateList::all();
        
        //Get all veicle type list
        $this->vehicleTypesList = Vehicletypes::orderBy('type_name','ASC')->get();


        //Get Dashboard Jobs Counts
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

        //Get Dashboard Customer Counts
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

        //GET Customer Jobs Graph
        $customerjobs = Customerjobs::with(['customerInfo'])->orderBy('id','DESC')->where('job_number', 'like', "%{$this->search_job_bumber}%" )->take(5)->get();

        $data = [
            'getCountSalesJob' => $getCountSalesJob,
            'getAllSalesJob' => $getAllSalesJobData,
            'customerjobs' => $customerjobs,
            'pendingjobs'=>$pendingjobs,
        ];

        if($this->selected_vehicle_id && $this->service_group_id)
        {
            $servicesTypesListQuery = ServicesPrices::with(['serviceInfo'])->where(['station_id'=>$this->station,'customer_type'=>$this->customer_type]);
            $servicesTypesListQuery = $servicesTypesListQuery->where(function ($query) {
                $query->whereRelation('serviceInfo', 'service_group_id', '=', $this->service_group_id);
            });

            switch($this->service_sort)
            {
                case 1:$servicesTypesListQuery = $servicesTypesListQuery->orderBy('id','DESC');break;
                case 2:$servicesTypesListQuery = $servicesTypesListQuery->orderBy('id','ASC');break;
                case 3:$servicesTypesListQuery = $servicesTypesListQuery->orderBy('sale_price','ASC');break;
                case 4:$servicesTypesListQuery = $servicesTypesListQuery->orderBy('sale_price','DESC');break;
            }
            $this->servicesTypesList = $servicesTypesListQuery->get();

            /*$servicesTypesListResultFin=[];
            if($this->customer_type!=23)
            {
                $servicesTypesListResult = $servicesTypesListQuery->get();
                foreach($servicesTypesListResult as $servicesTypesNWC)
                {
                    $custmerTypeBasedServiceSearch = ServicesPrices::with('serviceInfo')->where(['customer_type'=>$this->customer_type,'service_code'=>$servicesTypesNWC->service_code])->first();
                    if($custmerTypeBasedServiceSearch)
                    {
                        $servicesTypesListResultFin[]=$custmerTypeBasedServiceSearch;
                    }
                    else
                    {
                        $servicesTypesListResultFin[]=$servicesTypesNWC;
                    }
                }
            }
            else
            {
                $servicesTypesListResultFin = $servicesTypesListQuery->get();
            }
            $this->servicesTypesList = $servicesTypesListResultFin;*/
        }

        /*
        $servicesTypesListQuery = ServicesType::select(
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
        ->where('services_types.service_type_name', 'like', "%{$this->service_search}%");
        switch($this->service_sort)
        {
            case 1:$servicesTypesListQuery = $servicesTypesListQuery->orderBy('services_types.id','DESC');break;
            case 2:$servicesTypesListQuery = $servicesTypesListQuery->orderBy('services_types.id','ASC');break;
            case 3:$servicesTypesListQuery = $servicesTypesListQuery->orderBy('services_types.sale_price','ASC');break;
            case 4:$servicesTypesListQuery = $servicesTypesListQuery->orderBy('services_types.sale_price','DESC');break;
        }
        

        $this->servicesTypesList = $servicesTypesListQuery->get();*/

        


        $cartDetails = $this->cartItems;
        $this->cartItemCount = count($this->cartItems); 
        $this->total=0;
        foreach($cartDetails as $item)
        {
            $this->total = $this->total+($item->quantity*$item->price);
        }
        $this->tax = $this->total * (config('global.TAX_PERCENT') / 100);
        $this->grand_total = $this->total  * ((100 + config('global.TAX_PERCENT')) / 100);

        
        $cartServiceId = [];
        foreach($this->cartItems as $cartItems)
        {
            $cartServiceId[] = $cartItems->service_type_id;
        }
        $this->cartItemsInService = $cartServiceId;

        $this->dispatchBrowserEvent('selectSearchEvent'); 
        //dd($data['pendingjobs'][0]->customerInfo['name']);
        return view('livewire.dashboard',$data);
    }

    public function closeSearchNewCustomer(){
        $this->showCustomerSearch=false;
        $this->showVehicleAvailable=false;

        /*$this->newVehicleSearch=true;
        $this->newcustomeoperation=false;
        $this->showSearchModelView=false;
        $this->showCustomerSearch=false;
        $this->showDashboard=true;*/
    }

    

    // Fetch records
    

    

    public function selectPendingVehicle($customers){

        //$this->newVehicleOpen();
        
        
        

        $selectedPendingCustomer = [
            "id" => $customers['vehicle_id'],
            "name" => $customers['customer_info']['name'],
            "email" => $customers['customer_info']['email'],
            "mobile" => $customers['customer_info']['mobile'],
            "customer_type" => $customers['customer_info']['customer_type'],
            "customer_id_image" => $customers['customer_info']['customer_id_image'],
            "created_by" => $customers['customer_info']['created_by'],
            "updated_by" => $customers['customer_info']['updated_by'],
            "is_active" => $customers['customer_info']['is_active'],
            "is_blocked" => $customers['customer_info']['is_blocked'],
            "created_at" => $customers['customer_info']['created_at'],
            "updated_at" => $customers['customer_info']['updated_at'],
            "customer_vehicle_id" => $customers['vehicle_id'],
            "customer_id" => $customers['customer_id'],
            "vehicle_type" => $customers['vehicle_info']['vehicle_type'],
            "vehicle_image" => $customers['vehicle_info']['vehicle_image'],
            "vehicleName" => $customers['vehicle_info']['make'],
            "model" => $customers['vehicle_info']['model'],
            "plate_number_final" => $customers['vehicle_info']['plate_number_final'],
            "chassis_number" => $customers['vehicle_info']['chassis_number'],
            "vehicle_km" => $customers['vehicle_info']['vehicle_km'],
            "customerType" => $customers['customer_info']['customertype']['customer_type'],
        ];

        $this->selectVehicle($selectedPendingCustomer);

        

    }

    

    public function addMoreService(){
        $this->showServiceGroup = true;
        $this->showaddmorebtn = false;
        $this->showCheckList=false;
        $this->showQLCheckList=false;
        $this->markCarScratch=false;
        $this->cardShow=true;
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
        $this->showVehicleForm= true;
        $this->updateCustomerFormDiv= true;


        $this->showVehicleAvailable=false;
        $this->numberPlateAddForm=true;
        $this->otherVehicleDetailsForm=true;

        $this->updateVehicleFormBtn= true;

        $this->showFormBoxClose=true;
        $this->editCustomerAndVehicle=true;

        $editCustomerVehicle = CustomerVehicle::find($this->selected_vehicle_id);
        $this->plate_state = $editCustomerVehicle->plate_state; 
        $this->plate_code = $editCustomerVehicle->plate_code; 
        $this->plate_number = $editCustomerVehicle->plate_number; 
        //$this->vehicle_image = $editCustomerVehicle->vehicle_image; 
        $this->vehicle_type = $editCustomerVehicle->vehicle_type; 
        $this->make = $editCustomerVehicle->make; 
        $this->model = $editCustomerVehicle->model; 
        $this->plate_number_image = $editCustomerVehicle->plate_number_image; 
        $this->chaisis_image = $editCustomerVehicle->chaisis_image; 
        $this->chassis_number = $editCustomerVehicle->chassis_number; 
        $this->vehicle_km = $editCustomerVehicle->vehicle_km; 
        //dd($this);
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
        $customer = $this->selectedVehicleInfo;
        $this->customer_id = $customer['customer_id'];
        $this->mobile = $customer['mobile'];
        $this->name = $customer['email'];
        $this->email = $customer['email'];
        $this->customer_type = $customer['customer_type'];

        $this->showCustomerSearch=true;
        $this->showSearchMobile=false;
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
        $this->service_group_id = $service['id'];
        $this->service_group_name = $service['service_group_name'];
        $this->service_group_code = $service['service_group_code'];
        $this->station = $service['station_id'];
        $this->service_search='';

        $this->showVehicleDiv = false;
        $this->showVehicleFormDiv=false;
        $this->newVehicleAdd=false;
        $this->showCustomerFormDiv=false;
        $this->selectedCustomerVehicle=true;
        //dd($this);
        //$this->selectedCustomerVehivleDetails($this->selected_vehicle_id);

        $this->customer_id = $this->customer_id;
        $this->vehicle_id = $this->selectedVehicleInfo['customer_vehicle_id'];
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
        )
        ->where('services_types.service_type_name', 'like', "%{$this->service_search}%")
        ->get();
        $this->showServiceType = true;
        
    }

    
    public function addtoCartItem($items)
    {
        $items = json_decode($items);
        $itemsDetails = $items->service_items;
        $itemBrand = $itemsDetails->item_brand;
        $itemsCategory = $itemsDetails->item_category;
        $itemsGroup = $itemsDetails->product_group;
        if(CustomerBasket::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id,'item_id'=>$itemsDetails->id])->count())
        {
            CustomerBasket::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id,'item_id'=>$itemsDetails->id])->increment('quantity', 1);
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
                'created_at'=>Carbon::now(),
                'created_by'=>Session::get('user')->id,
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
        
        
        

        /*$this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Added to Cart Successfully',
            'text' => 'service added..!',
            'cartitemcount'=>1
        ]);*/

    }

    public function addtoCart($serviceType)
    {
        $customerBasketCheck = CustomerBasket::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id,'service_type_id'=>$serviceType['service_id']]);
        if($customerBasketCheck->count())
        {
            $customerBasketCheck->increment('quantity', 1);
        }
        else
        {
            $cartInsert = [
                'customer_id'=>$this->customer_id,
                'vehicle_id'=>$this->selected_vehicle_id,
                'service_type_id'=>$serviceType['service_id'],
                'service_type_name'=>$serviceType['service_info']['service_name'],
                'service_type_code'=>$serviceType['service_code'],
                'service_group_id'=>$serviceType['service_info']['service_group_id'],
                'service_group_name'=>$serviceType['service_info']['service_group_code'],
                'service_group_code'=>$serviceType['service_info']['service_group_code'],
                'service_item'=>false,
                'department_id' => $serviceType['department_id'],
                //'section_id'=>$serviceType->service_group_id,
                'station_id'=>$this->station,
                'price'=>$serviceType['final_price_after_dicount'],
                'quantity'=>1,
                'created_at'=>Carbon::now(),
                'created_by'=>Session::get('user')->id,
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
        /*$this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Added to Cart Successfully',
            'text' => 'service added..!',
            'cartitemcount'=>\Cart::getTotalQuantity()
        ]);*/
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
        
        /*$this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Service has removed',
            'text' => 'service added..!',
            'cartitemcount'=>\Cart::getTotalQuantity()
        ]);*/
        //session()->flash('cartsuccess', 'Service has removed !');
    }
    public function removeCartN($id)
    {
        CustomerBasket::where(['customer_id'=>$this->customer_id, 'vehicle_id'=>$this->selected_vehicle_id,'service_type_id'=>$id])->delete();
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
        
        /*$this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Service has removed',
            'text' => 'service added..!',
            'cartitemcount'=>\Cart::getTotalQuantity()
        ]);*/
        //session()->flash('cartsuccess', 'Service has removed !');
    }

    public function clearAllCart()
    {
        
        CustomerBasket::where(['customer_id'=>$this->customer_id, 'vehicle_id'=>$this->selected_vehicle_id])->delete();
        $this->cartItems = CustomerBasket::where(['customer_id'=>$this->customer_id, 'vehicle_id'=>$this->selected_vehicle_id])->get();
        $this->cartItemCount = count($this->cartItems); 
        
        /*$this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'All Service Cart Clear Successfully !',
            'text' => 'service added..!',
            'cartitemcount'=>\Cart::getTotalQuantity()
        ]);*/
        $this->cardShow=false;
        //session()->flash('cartsuccess', 'All Service Cart Clear Successfully !');
    }

    public function submitService(){
        
        $this->showaddmorebtn = true;
        $cartDetails = $this->cartItems;
        $this->cartItemCount = count($this->cartItems); 
        $this->total=0;
        
        $this->showVehicleAvailable=false;
        $showchecklist4=false;
        $showchecklist7=false;
        foreach($this->cartItems as $items)
        {
            if($this->station==null){
                $this->station = $items->station_id;
            }

            if($items->service_group_id==4 && $showchecklist4==false){
                $showchecklist4=true;
            }
            else if($items->service_item==false && ($items->service_group_id==7) && $showchecklist7==false){
                $showchecklist7=true;
            }
            $this->total = $this->total+($items->quantity*$items->price);
        }
        
        if($showchecklist4==true){
            $this->showCheckList=true;
            $this->showGSCheckList=true;
            $this->showServiceGroup=false;
            $this->cardShow=false;
            $this->showCheckout=false;
            $this->checklistLabels = ServiceChecklist::where(['service_group_id'=>4])->get();
            
        }
        else if($showchecklist7==true)
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
            //$this->createJob();
            $this->showCheckout=true;
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
        $this->showaddmorebtn = false;
        $this->dispatchBrowserEvent('saveSignature'); 
    }

    public function createJob(){
        //$this->job_number = Session::get('user')->stationName['station_code'].'-PSOF-'.Carbon::now()->format('y').Carbon::now()->format('m').Carbon::now()->format('d').'-'.$this->service_group_code.'123';
        
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
                'vImageR1' => 'required',
                'vImageR2' => 'required',
                'vImageF' => 'required',
                'vImageB' => 'required',
                'vImageL1' => 'required',
                'vImageL2' => 'required',
            ]);

            //$checkListEntryInsert = VehicleChecklistEntry::create($checkListEntryData);

            $this->showCheckList=false;
            $this->showCheckout =true;
        }


        
        $this->tax = $total * (config('global.TAX_PERCENT') / 100);
        $this->grand_total = $total  * ((100 + config('global.TAX_PERCENT')) / 100);
        $customerjobData = [
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
            'payment_updated_by'=>Session::get('user')->id,
        ];
        $customerjobId = Customerjobs::create($customerjobData);
        $this->job_number = Session::get('user')->stationName['station_code'].'-PSOF-'.Carbon::now()->format('y').Carbon::now()->format('m').Carbon::now()->format('d').'-'.$this->service_group_code.$customerjobId->id;
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
        $this->createJob();
        Customerjobs::where(['job_number'=>$this->job_number])->update(['job_create_status'=>0]);
        CustomerBasket::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id])->delete();
        $this->successPage=true;
        $this->showCheckout =false;
        $this->cardShow=false;
        $this->showServiceGroup=false;
    }

    public function pendingPaymentClick($pendingJob){
        $this->successPage=false;
        $pendingJob = json_decode($pendingJob);
    
        $this->showSearchModelView=false;
        $this->dispatchBrowserEvent('selectSearchEvent'); 
        $this->dispatchBrowserEvent('show-searchNewVehicle');

        $this->showCustomerSearch=false;
        $this->showPayLaterCheckout=true;

        
        $pendingjob = Customerjobs::where(['job_create_status'=>0,'customer_id'=>$pendingJob->customer_id,'vehicle_id'=>$pendingJob->vehicle_id])->first();
        if($pendingjob)
        {
            $this->job_number = $pendingjob->job_number;
            $this->totalPL = number_format($pendingjob->total_price,2);
            $this->taxPL = number_format($pendingjob->vat,2);
            $this->grand_totalPL = number_format($pendingjob->grand_total,2);
        }
        //dd($this);
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

    public function completePaymnet($mode){
        $this->successPage=false;
        //dd($mode);
        if($this->job_number==Null){
            $this->createJob();
        }
        $job_number = $this->job_number;
        
        $customerjobs = Customerjobs::
        select('customerjobs.*','customers.name','customers.email','customers.mobile','customertypes.customer_type as customerType')
        ->join('customers','customers.id','=','customerjobs.customer_id')
        ->join('customertypes','customertypes.id','=','customerjobs.customer_type')
        ->where(['customerjobs.job_number'=>$job_number])
        ->take(5)->first();
        
        $mobileNumber = '971'.substr($customerjobs->mobile, -9);
        //$mobileNumber = substr($customerjobs->mobile, -9);
        if($mode=='link')
        {
            //dd($customerjobs);
            $paymentLink = $this->sendPaymentLink($customerjobs);
            $paymentResponse = json_decode((string) $paymentLink->getBody()->getContents(), true);
            $merchant_reference = $paymentResponse['merchant_reference'];

            if(array_key_exists('payment_redirect_link', $paymentResponse))
            {
                //dd("https://mshastra.com/sendurlcomma.aspx?user=20092622&pwd=buhaleeba@123&senderid=BuhaleebaRE&CountryCode=971&mobileno=".$mobileNumber."&msgtext=".urlencode('Job Id #'.$job_number.' is processing, Please click complete payment '.$paymentResponse['payment_redirect_link']));
                //"http://mshastra.com/sendurlcomma.aspx?user=profileid&pwd=xxxx&senderid=ABC&CountryCode=91&mobileno=9911111111&msgtext=Hello"
                $response = Http::withBasicAuth('20092622', 'buhaleeba@123')->post("https://mshastra.com/sendurlcomma.aspx?user=20092622&pwd=buhaleeba@123&senderid=BuhaleebaRE&mobileno=".$mobileNumber."&msgtext=".urlencode('Job Id #'.$job_number.' is processing, Please click complete payment '.$paymentResponse['payment_redirect_link']));


                $customerjobId = Customerjobs::where(['job_number'=>$job_number])->update(['payment_type'=>1,'payment_link'=>$paymentResponse['payment_redirect_link'],'payment_response'=>json_encode($paymentResponse),'payment_request'=>'link_send','job_create_status'=>1]);

                CustomerBasket::where(['customer_id'=>$this->customer_id,'vehicle_id'=>$this->selected_vehicle_id])->delete();

                $this->successPage=true;
                $this->showCheckout =false;
                $this->cardShow=false;
                $this->showServiceGroup=false;
                $this->showPayLaterCheckout=false;
                
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
            $this->showPayLaterCheckout=false;
            
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
            $this->showPayLaterCheckout=false;
        }

        
        
    }

    public function sendPaymentLink($customerjobs)
    {
        //dd($customerjobs);
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

        /*$arrData    = [
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
        ];*/

        $arrData = [
                "paymnet_link_expiry"=>Carbon::now()->addDays(1)->format('Y-m-d H:i:s'),
                //"amount"=>$total,
                "amount"=>1,
                "emailAddress"=>$order_billing_email,
                "firstName"=>$order_billing_name,
                "customer_mobile"=>$order_billing_phone,
                "lastName"=>$order_billing_name,
                "address1"=>"Dubai",
                "city"=>"Bur Dubai",
                "countryCode"=>"UAE",
                "orderReference"=>$merchant_reference,
                "description"=>"GSS Service #".$merchant_reference
            ];
            //dd($arrData);
        $response = Http::withBasicAuth('onlinewebtutor', 'admin123')->post(config('global.paymenkLink_payment_url'),$arrData);
        return $response;
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
