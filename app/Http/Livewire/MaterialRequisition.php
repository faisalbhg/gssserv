<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Http;
use LaravelPayfort\Facades\Payfort;
use Illuminate\Support\Facades\Hash;
use DB;
use Spatie\Image\Image;
use Livewire\WithPagination;

use App\Models\Development;
use App\Models\Sections;
use App\Models\InventoryItemMaster;
use App\Models\ItemCategories;
use App\Models\MaterialRequestions;


class MaterialRequisition extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $showServiceGroup=true, $showQWServiceMRItems=false, $showQWServiceMRSections=false;
    public $servicesGroupList,$sectionsLists, $service_group_id, $service_group_name, $service_group_code, $station, $propertyCode, $selectedSectionName;
    public $mt_serive_item_search, $serviceMRAddedMessgae=[],$mRCartItems = [], $mRCartItemCount, $mRCardShow=false, $mrItemQty, $confirming;
    public function render()
    {
        $this->getMRCartInfo();
        $data=[];
        $this->servicesGroupList = Development::select('DevelopmentCode as department_code','DevelopmentName as department_name','id','LandlordCode as station_code')->where(['Operation'=>true,'LandlordCode'=>auth()->user('user')['station_code']])->get();
        if($this->showQWServiceMRSections)
        {
            $this->sectionsLists = Sections::select('id','PropertyCode','DevelopmentCode','PropertyNo','PropertyName','Operation')
                ->where([
                    'DevelopmentCode'=>$this->service_group_code,
                    'Operation'=>true
                ])
                ->orderBy('SortIndex','ASC')
                ->get();
        }
        if($this->showQWServiceMRItems)
        {
            $this->showQWServiceMRItemsResults=true;
            $inventoryItemMasterLists = InventoryItemMaster::where('Active','=',1);
            if($this->mt_serive_item_search){
                $inventoryItemMasterLists = $inventoryItemMasterLists->where('ItemName','like',"%{$this->mt_serive_item_search}%")->orWhere('ItemCode','like',"%{$this->mt_serive_item_search}%");
            }
            //dd($inventoryItemMasterLists->paginate(1));
            $data['serviceItemsList']=$inventoryItemMasterLists->whereIn('CategoryId',['21',])->paginate(20);
            //dd($data);

        }

        return view('livewire.material-requisition',$data);
    }

    public function getMRCartInfo(){
        $this->mRCartItems = MaterialRequestions::where(['created_by'=>auth()->user('user')->id])->get();
        $this->mRCartItemCount = count($this->mRCartItems); 
        if($this->mRCartItemCount>0)
        {
            $this->mRCardShow=true;
        }
        else
        {
            $this->mRCardShow=false;
        }
    }

    public function serviceGroupForm($service){
        $this->service_group_id = $service['id'];
        $this->service_group_name = $service['department_name'];
        $this->service_group_code = $service['department_code'];
        $this->station = $service['station_code'];
        $this->showQWServiceMRSections=true;
    }

    public function getSectionServices($section)
    {
        $this->propertyCode=$section['PropertyCode'];
        $this->selectedSectionName = $section['PropertyName'];
        $this->showQWServiceMRItems = true;
        $this->dispatchBrowserEvent('openServicesListModal');
        
    }

    public function addtoCartItem($items)
    {
        $materialRequestBasketCheck = MaterialRequestions::where(['created_by'=>auth()->user('user')->id,'item_id'=>$items['ItemId']]);
        if($materialRequestBasketCheck->count())
        {
            $materialRequestBasketCheck->increment('quantity', 1);
            
            
        }
        else
        {
            $cartInsert = [
                'item_id'=>$items['ItemId'],
                'item_code'=>$items['ItemCode'],
                'company_code'=>$items['CompanyCode'],
                'category_id'=>$items['CategoryId'],
                'sub_category_id'=>$items['SubCategoryId'],
                'brand_id'=>$items['BrandId'],
                'bar_code'=>$items['BarCode'],
                'item_name'=>$items['ItemName'],
                'cart_item_type'=>2,
                'description'=>$items['Description'],
                'division_code'=>$this->station,
                'department_code'=>$this->service_group_code,
                'department_name'=>$this->service_group_name,
                'section_code'=>$this->propertyCode,
                'section_name'=>$this->selectedSectionName,
                'unit_price'=>$items['UnitPrice'],
                'ml_quantity'=>isset($this->mrItemQty[$items['ItemId']])?$this->mrItemQty[$items['ItemId']]:1,
                'created_by'=>auth()->user('user')['id'],
                'created_at'=>Carbon::now(),
            ];
            
            MaterialRequestions::insert($cartInsert);
        }
        $this->serviceMRAddedMessgae[$items['ItemCode']]=true;
        //dd($this->sectionServiceLists);
        /*$this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Added to Cart Successfully',
            'text' => 'service added..!',
            'cartitemcount'=>\Cart::getTotalQuantity()
        ]);*/
        session()->flash('cartsuccess', 'Service is Added to Cart Successfully !');
    
    }

    public function confirmDelete($id)
    {
        $this->confirming = $id;
    }

    public function kill($id,$item_id)
    {
        //dd($item_id);
        //dd($id);
        MaterialRequestions::where(['id'=>$id])->delete();
    }

    public function cartSetDownQty($cartId){
        MaterialRequestions::find($cartId)->decrement('quantity');
    }
    public function cartSetUpQty($cartId){
        MaterialRequestions::find($cartId)->increment('quantity');
    }

    public function removeCart($id)
    {
        MaterialRequestions::find($id)->delete();
    }

    public function clearAllCart()
    {
        MaterialRequestions::where(['created_by'=>auth()->user('user')->id])->delete();
        
        session()->flash('cartsuccess', 'All Service Cart Clear Successfully !');
    }

    
}
