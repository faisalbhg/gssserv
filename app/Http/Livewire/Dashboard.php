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
                \DB::raw('count(job_create_status) pendingjobs'),
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

        //dd($customerjobs);

        $data = [
            'getCountSalesJob' => $getCountSalesJob,
            'getAllSalesJob' => $getAllSalesJobData,
            'customerjobs' => $customerjobs,
            'pendingjobs'=>$pendingjobs,
        ];

        

        



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
    

    

    public function selectPendingVehicle($customer_id,$vehicle_id){
        //$this->newVehicleOpen();
        /*$selectedPendingCustomer = [
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
        $this->selectVehicle($selectedPendingCustomer);*/
        return redirect()->to('/job-card/'.$customer_id.'/'.$vehicle_id);
        

        

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

    public function pendingPaymentClick($job_number){
        return redirect()->to('/job-card/'.$job_number);
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
