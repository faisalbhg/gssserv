<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\ServicesPrices;
use App\Models\Stationcode;
use App\Models\ServiceMaster;
use App\Models\Customertype;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Http\Request;
use URL;
use App\Exports\ServicePriceExport;
use App\Imports\ServicePriceImport;
use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Http;
use LaravelPayfort\Facades\Payfort;
use Illuminate\Support\Facades\Hash;

class ServicesPriceList extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $customertypesList=[];
    public $showSearchServiceInfo=false,$service_name_search, $servicesPricesResult, $servicesMasterResult, $servicesResults, $showSelectedServiceCustomerType=false, $showServiceSelected=false;
    public $serviceMasterList;
    public $selectedServicePriceId,$selectedServicePriceName, $selectedServicePriceCode, $selectedServicePriceVal;
    public $showServiceDiscountDetails=[],$customerTypeValue=[];
    public $showImportPannel=false;
    public $excelFile;
    public $fileName;
    public $isUploaded = false;
    public $showManualForm=false;
    public $new_service_code, $new_customer_type, $new_discount_type, $new_discount_value, $new_discount_amount, $new_final_price, $new_date_from, $new_date_to, $isAddedNew=false;

    public $search_service_code;

    public function render()
    {
        $servicePricesList = ServicesPrices::with(['serviceInfo','customerType','stationInfo']);
        if($this->service_name_search)
        {
            $servicePricesList->where(function ($query) {
                $query->orWhereRelation('serviceInfo', 'service_name', 'like', "%{$this->service_name_search}%")
                ->orWhereRelation('serviceInfo', 'service_code', 'like', "%{$this->service_name_search}%");
            });
        }
        if($this->search_service_code)
        {
            $servicePricesList->where(function ($query) {
                $query->orWhereRelation('serviceInfo', 'service_code', 'like', "%{$this->search_service_code}%");
            });
        }
        $data['servicePricesList'] = $servicePricesList->orderBy('id','DESC')->paginate(20);
        
        return view('livewire.services-price-list',$data);
    }

    public function searchServiceName(){
        $servicesPricesQuery = ServicesPrices::with(['ServiceInfo']);
        if($this->service_name_search)
        {
            $servicesPricesQuery->where(function ($query) {
                $query->orWhereRelation('ServiceInfo', 'service_name', 'like', "%{$this->service_name_search}%")
                ->orWhereRelation('ServiceInfo', 'service_code', 'like', "%{$this->service_name_search}%");
            });
        }
        $this->servicesResults = $servicesPricesQuery->where(['is_active'=>1])->get();
        //dd($this->servicesResults);
        if(count($this->servicesResults)>0)
        {
            //
        }
        else{
            $this->servicesResults = ServiceMaster::where('service_name','like',"%{$this->service_name_search}%")->get();
        }
        $this->showSearchServiceInfo=true;
    }

    public function selectedService($service)
    {
        $this->showSelectedServiceCustomerType=true;
        $this->showServiceSelected=true;
        $this->selectedServicePriceId[$service['id']]=$service['id'];
        $this->selectedServicePriceName[$service['id']]=$service['service_name'];
        $this->selectedServicePriceCode[$service['id']]=$service['service_code'];
        $this->selectedServicePriceVal[$service['id']]=$service['sale_price'];

        $this->customertypesList = Customertype::get();
        foreach($this->customertypesList as $customertypesListSh)
        {
            $this->showServiceDiscountDetails[$customertypesListSh->id]=false;
        }
        $this->servicesResults=[];
        $this->showSearchServiceInfo=false;
    }

    public function closeSearchResult()
    {
        $this->servicesResults=[];
        $this->showSearchServiceInfo=false;
    }

    public function removeSelectedService($id)
    {
        unset($this->selectedServicePriceId[$id]);
        unset($this->selectedServicePriceName[$id]);
        unset($this->selectedServicePriceCode[$id]);
        unset($this->selectedServicePriceVal[$id]);
        if(count($this->selectedServicePriceId)==0){
            $this->showSelectedServiceCustomerType=false;
        }
    }

    public function selectCustomerType($customerType){
        dd($customerType);

    }

    public function addNewImport(){
        $this->showImportPannel=true;
        $this->dispatchBrowserEvent('showServicePriceImportModel');
    }

    public function SubmitImport(){
        $this->validate(
            [
                'excelFile' => 'required'
            ]
        );

        
        
        $import = Excel::import(new ServicePriceImport,$this->excelFile);
        if($import){
            $this->isUploaded = true;
        }
        $this->fileName = '';
    }
    public function downloadExcelTemplate(){
        $serviceMasterQuery = [];
        return Excel::download(new ServicePriceExport($serviceMasterQuery), 'service_import'.date('YmdHis').'.xlsx');
    }

    public function addNewmanual(){
        $this->showManualForm=true;
        $this->customertypesList = Customertype::get();
    }

    public function saveManualForm(){
        $saveManualInsert = [
            'service_id'=>ServiceMaster::where('service_code', $this->new_service_code)->pluck('id')->first(),
            'service_code'=>$this->new_service_code,
            'customer_type'=>$this->new_customer_type,
            'unit_price'=>ServiceMaster::where('service_code', $this->new_service_code)->pluck('sale_price')->first(),
            'min_price'=>ServiceMaster::where('service_code', $this->new_service_code)->pluck('sale_price')->first(),
            'max_price'=>ServiceMaster::where('service_code', $this->new_service_code)->pluck('sale_price')->first(),
            'discount_type'=>$this->new_discount_type,
            'discount_value'=>$this->new_discount_value,
            'discount_amount'=>$this->new_discount_amount,
            'final_price_after_dicount'=>$this->new_final_price,
            'start_date'=>$this->new_date_from,
            'end_date'=>$this->new_date_to,
            'station_id'=>auth()->user('user')->station_id,
            'created_by'=>auth()->user('user')->station_id,
            'is_active'=>1,
            'created_at'=>Carbon::now(),
        ];
        //dd($saveManualInsert);
        ServicesPrices::create($saveManualInsert);
        $this->isAddedNew = true;
    }

    public function deletePriceMasterCT($id)
    {
        //ServicesPrices::truncate();
        ServicesPrices::where('id','=',$id)->delete();
    }


}
