@push('custom_css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style type="text/css">
    .select2-container--default .select2-selection--single{
        border: 1px solid #d2d6da !important;
        border-radius: 0.5rem !important;
    }
    .select2-container .select2-selection--single
    {
        height: 40px;
    }
</style>
@endpush

<main class="main-content position-relative  border-radius-lg">
    <div class="container-fluid py-2">
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
            <span class="alert-icon"><i class="ni ni-like-2"></i></span>
            <span class="alert-text"><strong>Success!</strong> {{ $message }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        @endif
        @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
            <span class="alert-icon"><i class="ni ni-like-2"></i></span>
            <span class="alert-text"><strong>Error!</strong> {{ $message }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        @endif

        @if($searchby)
        <div class="d-flex mt-0 mb-3 mx-0">
            <div class=" d-flex">
                <h5 class="mb-1 text-gradient text-dark">
                    <a href="javascript:;">Search By: </a>
                </h5>
                <div class="px-2 position-relative ">
                    <button wire:click="clickSearchBy('1')" class="btn @if($searchByMobileNumberBtn) bg-gradient-primary @else bg-gradient-default @endif  mb-0" data-toggle="modal" data-target="#new-board-modal">
                        Mobile Number
                    </button>
                    <hr class="vertical dark mt-2">
                </div>
                <div class="px-2 position-relative ">
                    <button wire:click="clickSearchBy('2')" class="btn @if($searchByPlateBtn) bg-gradient-primary @else bg-gradient-default @endif mb-0" data-toggle="modal" data-target="#new-board-modal">
                        Plate Number
                    </button>
                    <hr class="vertical dark mt-2">
                </div>
                <div class="px-2">
                    <button wire:click="clickSearchBy('3')" class="btn @if($searchByChaisisBtn) bg-gradient-primary @else bg-gradient-default @endif mb-0" data-toggle="modal" data-target="#new-board-modal">
                        Chaisis Number
                    </button>
                </div>
            </div>
        </div>
        @endif
        @if($selectedCustomerVehicle)
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-4">
                        <div class="card card-profile card-plain">
                            <div class="position-relative">
                                <div class="blur-shadow-image">
                                    <img class="w-100 rounded-3 shadow-lg" src="{{url("public/storage/".$selectedVehicleInfo["vehicle_image"])}}">
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="card card-profile card-plain">
                            <div class="card-body text-left p-0">
                                <div class="p-md-0 pt-3">
                                    <h5 class="font-weight-bolder mb-0">{{$selectedVehicleInfo['plate_number_final']}}</h5>
                                    <p class="text-uppercase text-sm font-weight-bold mb-2">{{isset($selectedVehicleInfo->makeInfo)?$selectedVehicleInfo->makeInfo['vehicle_name']:''}}, {{isset($selectedVehicleInfo->modelInfo['vehicle_model_name'])?$selectedVehicleInfo->modelInfo['vehicle_model_name']:''}}</p>
                                </div>
                                @if($selectedVehicleInfo['customerInfoMaster']['TenantName'])
                                    @if($selectedVehicleInfo['customerInfoMaster']['TenantName'])
                                    <p class="mb-0">{{$selectedVehicleInfo['customerInfoMaster']['TenantName']}}</p>
                                    @endif
                                    @if($selectedVehicleInfo['customerInfoMaster']['Mobile'])
                                    <p class="mb-0">{{$selectedVehicleInfo['customerInfoMaster']['Mobile']}}</p>
                                    @endif
                                    @if($selectedVehicleInfo['customerInfoMaster']['Email'])
                                    <p class="mb-1">{{$selectedVehicleInfo['customerInfoMaster']['Email']}}</p>
                                    @endif
                                @else
                                <p class="mb-0">Customer Guest</p>
                                @endif
                                @if($selectedVehicleInfo['chassis_number'])
                                <p class="mb-1"><b>Chaisis:</b> {{$selectedVehicleInfo['chassis_number']}}</p>
                                @endif
                                @if($selectedVehicleInfo['vehicle_km'])
                                <b>KM Reading:</b> {{$selectedVehicleInfo['vehicle_km']}}</p>
                                @endif
                                <div>
                                    <button type="button" class="btn bg-gradient-primary btn-tooltip btn-sm" title="Edit Customer/Discount/Vehicle" wire:click="editCustomer()">Edit</button>
                                    <button type="button" class="btn bg-gradient-primary btn-tooltip btn-sm" title="Add Customer/Discount/Vehicle"  wire:click="addNewVehicle()">New Vehicle</button>
                                    <button type="button" class="btn bg-gradient-info btn-tooltip btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Apply Discount Group" data-container="body" data-animation="true" wire:click="clickDiscountGroup()">Discount Group</button>
                                    <button class="btn bg-gradient-info btn-sm" wire:click="openServiceGroup">Services</button>
                                    @if(@$customerSelectedDiscountGroup['groupType']==2)
                                    <button class="btn bg-gradient-danger btn-sm mb-0" wire:click.prevent="removeDiscount()">Remove Discount - {{strtolower(str_replace("_"," ",$customerDiscontGroupCode))}}</button>
                                    @endif

                                    @if(@$customerSelectedDiscountGroup['groupType']==3)
                                    {{$engineOilDiscountPercentage}}
                                    <button class="btn bg-gradient-success btn-sm mb-0" wire:click.prevent="applyEngineOilDiscount()">Apply {{$engineOilDiscountPercentage}}% Discount</button>
                                    @endif

                                    <br>
                                    <div wire:loading wire:target="applyEngineOilDiscount">
                                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                            <div class="la-ball-beat">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:loading wire:target="editCustomer">
                                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                            <div class="la-ball-beat">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:loading wire:target="addNewVehicle">
                                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                            <div class="la-ball-beat">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:loading wire:target="clickDiscountGroup">
                                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                            <div class="la-ball-beat">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:loading wire:target="saveSelectedDiscountGroup">
                                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                            <div class="la-ball-beat">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- @if($customerDiscontGroupCode)
                                    <button class="btn bg-gradient-info text-white ms-0 py-1 px-3 m-0" wire:click.prevent="applyDiscountGroup()">Apply {{$customerDiscontGroupCode}} Discount Group</button> 
                                    <button type="button" wire:click="removeDiscount()" class="btn btn-danger btn-simple btn-lg mb-0 p-1">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                    @endif -->
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        @if(count($selectedVehicleInfo['customerDiscountLists'])>0)
            @if($discountApplyMessage)
                <p class="text-gradient-danger">{{$discountApplyMessage}}</p>
            @endif
            <div class="row">
                @forelse($selectedVehicleInfo['customerDiscountLists'] as $customerDiscount)
                <div class="col-3">
                    <div class="card">
                        <div class="card-body p-2 text-left">
                            
                            <a href="javascript:;" class="card-title h5 d-block text-darker text-capitalize">
                                {{strtolower($customerDiscount->discount_title)}}
                            </a>
                            <?php $end = \Carbon\Carbon::parse($customerDiscount->discount_card_validity);?>
                            @if($customerDiscount->discount_id==8 || $customerDiscount->discount_id==9)
                                <div class="author align-items-center">
                                    <div class="name ps-0">
                                        <span>{{strtolower($customerDiscount->employee_name)}}</span>
                                        
                                    </div>
                                </div>
                            @else
                                <div class="author align-items-center">
                                    <div class="name ps-3">
                                        <span>{{$customerDiscount->discount_card_number}}</span>
                                        <div class="stats">
                                            <small>Expired in: {{ $diff = Carbon\Carbon::parse($customerDiscount->discount_card_validity)->diffForHumans(Carbon\Carbon::now()) }}   </small>
                                        </div>
                                    </div>
                                </div>
                            
                            @endif
                            
                            @if(\Carbon\Carbon::now()->diffInDays($end, false)>=0)
                                @if($customerDiscontGroupId!=$customerDiscount->discount_id)
                                    <button class="btn bg-gradient-success btn-sm mb-0" wire:click.prevent="applyDiscountGroup({{$customerDiscount}})"><i class="fa-solid fa-check fa-xl"></i> Apply Now</button>
                                @else
                                    <button class="btn bg-gradient-danger btn-sm mb-0" wire:click.prevent="removeDiscount()"><i class="fa-solid fa-check"></i>Remove</button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                @endforelse
            </div>
        @endif
        <div class="row">
            
            <!-- Modal -->
            <style type="text/css">
                .modal-body{
                    max-height: calc(100vh - 300px);
                    overflow-y: auto;
                }
            </style>
            <div class="modal fade" id="discountGroupModal" tabindex="-1" role="dialog" aria-labelledby="discountGroupModalLabel" aria-hidden="true" wire:ignore.self style="z-index:99999;" >
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width:90%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="discountGroupModalLabel">Discount Groups</h5>
                            
                            <button type="button" class="btn-close text-dark " data-bs-dismiss="modal" aria-label="Close" style="font-size: 2.125rem !important;" >
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body py-0">
                            <div class="row mt-2">
                                <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header p-0">
                                        @error('$selectedDiscountId') <span class="text-danger">{{ $message }}</span> @enderror
                                        
                                    </div>
                                    <div class="card-body p-3">
                                        @if($discountSearch)
                                        <div class="row">
                                            @foreach($laborCustomerGroupLists as $listCustDiscGrp)
                                            <div class="col-lg-2 col-sm-4 my-2">
                                                <div wire:click="selectDiscountGroup({{$listCustDiscGrp}})" class="card h-70 cursor-pointer">
                                                    <div class="card-body">
                                                        <h6 class="mt-3 mb-0 font-weight-bold text-capitalize">{{strtolower(str_replace("_"," ",$listCustDiscGrp->Title))}}</h6>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            
                                        </div>
                                        @else
                                        <div class="row">
                                            @if($selectedDiscountTitle)
                                            <div><label class="badge badge-sm bg-gradient-dark text-light text-bold text-sm mb-0 float-end cursor-pointer" style="white-space: normal; text-transform: capitalize;" wire:click="clickDiscountGroup()">View All Discount Group</label>
                                            </div>
                                            <div class="col-lg-2 col-sm-4 my-2">
                                                <div class="card bg-primary h-100 cursor-pointer">
                                                    <div class="card-body">
                                                        <p class="mt-4 mb-0 font-weight-bold text-white">{{str_replace("_"," ",strtolower($selectedDiscountTitle))}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="col-lg-10 col-sm-8 text-center">
                                                <div class="row">
                                                    <p class="badge bg-gradient-danger text-light text-bold text-lg mb-0">{{$staffavailable}}</p>
                                                    @if($discountForm)
                                                        @if($searchStaffId)
                                                            
                                                            <div class="row mb-0">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="employeeId">Employee Id</label>
                                                                        <input type="text" class="form-control" wire:model="employeeId" id="employeeId" placeholder="Staff/Employee Id">
                                                                        @error('employeeId') <span class="text-danger">{{ $message }}</span> @enderror
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-12">
                                                                    <button type="button" class="btn bg-gradient-primary" wire:click="checkStaffDiscountGroup()">Check Employee</button>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if($discountCardApplyForm)
                                                            <div class="row mb-0">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="discountCardImgae">Discount Card Imgae</label>
                                                                        <input type="file" class="form-control" wire:model.defer="discount_card_imgae">
                                                                        @error('discount_card_imgae') <span class="text-danger">{{ $message }}</span> @enderror
                                                                        @if ($discount_card_imgae)
                                                                        <img class="img-fluid border-radius-lg w-30" src="{{ $discount_card_imgae->temporaryUrl() }}">
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="discountCardNumber">Discount Card Number</label>
                                                                        <input type="text" class="form-control" wire:model="discount_card_number" placeholder="Discount Card Number">
                                                                        @error('discount_card_number') <span class="text-danger">{{ $message }}</span> @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="discountCardValidity">Discount Card Validity</label>
                                                                        <input type="date" class="form-control" id="discountCardValidity" wire:model="discount_card_validity" name="discountCardValidity" placeholder="Discount Card Validity" min="<?php echo date("Y-m-d"); ?>">
                                                                        @error('discount_card_validity') <span class="text-danger">{{ $message }}</span> @enderror
                                                                    </div>
                                                                </div>
                                                            
                                                                <div class="col-md-12">
                                
                                                                    <button type="button" class="btn bg-gradient-secondary " data-bs-dismiss="modal">Close</button>
                                                                    <button type="button" class="btn bg-gradient-primary " wire:click="saveSelectedDiscountGroup()">Save changes</button>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if($engineOilDiscountForm)
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-6 my-2">
                                                                <div wire:click="selectEngineOilDiscount(10)" class="card bg-cover text-center cursor-pointer" style="background-image: url('https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/curved-images/curved1.jpg')">
                                                                    <div class="card-body z-index-2 py-2">
                                                                        <h2 class="text-white">10%</h2>
                                                                        <p class="text-white">
                                                                        10% Discount on Special Selected Engine Oil & Selected Wash Service</p>
                                                                        <btn class="btn bg-gradient-dark text-light">Select & Apply</btn>
                                                                    </div>
                                                                    <div class="mask bg-gradient-primary border-radius-lg"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 my-2">
                                                                <div wire:click="selectEngineOilDiscount(15)" class="card bg-cover text-center cursor-pointer" style="background-image: url('https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/curved-images/curved1.jpg')">
                                                                    <div class="card-body z-index-2 py-2">
                                                                        <h2 class="text-white">15%</h2>
                                                                        <p class="text-white">
                                                                        15% Discount on Special Selected Engine Oil & Selected Wash Service</p>
                                                                        <btn class="btn bg-gradient-dark text-light">Select & Apply</btn>
                                                                    </div>
                                                                    <div class="mask bg-gradient-primary border-radius-lg"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 my-2">
                                                                <div wire:click="selectEngineOilDiscount(20)" class="card bg-cover text-center cursor-pointer" style="background-image: url('https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/curved-images/curved1.jpg')">
                                                                    <div class="card-body z-index-2 py-2">
                                                                        <h2 class="text-white">20%</h2>
                                                                        <p class="text-white">
                                                                        20% Discount on Special Selected Engine Oil & Selected Wash Service</p>
                                                                        <btn class="btn bg-gradient-dark text-light">Select & Apply</btn>
                                                                    </div>
                                                                    <div class="mask bg-gradient-primary border-radius-lg"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 my-2">
                                                                <div wire:click="selectEngineOilDiscount(25)" class="card bg-cover text-center cursor-pointer" style="background-image: url('https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/curved-images/curved1.jpg')">
                                                                    <div class="card-body z-index-2 py-2">
                                                                        <h2 class="text-white">25%</h2>
                                                                        <p class="text-white">
                                                                        25% Discount on Special Selected Engine Oil & Selected Wash Service</p>
                                                                        <btn class="btn bg-gradient-dark text-light">Select & Apply</btn>
                                                                    </div>
                                                                    <div class="mask bg-gradient-primary border-radius-lg"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div wire:loading wire:target="selectEngineOilDiscount">
                                                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                                <div class="la-ball-beat">
                                                                    <div></div>
                                                                    <div></div>
                                                                    <div></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    @endif
                                                    
                                                </div>

                                                
                                            </div>
                                            
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="numberPlateModal" tabindex="-1" role="dialog" aria-labelledby="numberPlateModalLabel" aria-hidden="true" wire:ignore.self style="z-index:99999;" >
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width:90%;">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="numberPlateModalLabel">Plate Number</h5>
                            <button type="button" class="btn-close text-dark " data-bs-dismiss="modal" aria-label="Close" style="font-size: 2.125rem !important;" >
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body py-0">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12 mt-4 mt-lg-0 ">
                                    <div class="card my-2" ">
                                        <div class="card-body p-3 cursor-pointer ">
                                            <img src="{{url('storage/'.$selectedVehicleInfo['plate_number_image'])}}" class="w-100" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="discountImageModal" tabindex="-1" role="dialog" aria-labelledby="discountImageModalLabel" aria-hidden="true" wire:ignore.self style="z-index:99999;" >
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width:90%;">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="discountImageModalLabel">Discount Card Image</h5>
                            <button type="button" class="btn-close text-dark " data-bs-dismiss="modal" aria-label="Close" style="font-size: 2.125rem !important;" >
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body py-0">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12 mt-4 mt-lg-0 ">
                                    <div class="card my-2" ">
                                        <div class="card-body p-3 cursor-pointer ">
                                            <img src="{{url('public/storage/'.$shoe_discound_popup_image)}}" class="w-100" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 my-2">
                @if(count($cartItems)>0)
                    <div class="card card-profile card-plain">
                        <h6 class="text-uppercase text-body text-lg font-weight-bolder mt-2">Pricing Summary <span class="float-end text-sm text-danger text-capitalize">{{ count($cartItems) }} Services selected</span></h6>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card h-100">
                                    
                                    <div class="card-body p-3 pb-0">
                                        <ul class="list-group">
                                            <?php $total = 0;$totalDiscount=0; ?>
                                            @foreach ($cartItems as $item)
                                                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                    
                                                    <div class="d-flex flex-column">
                                                        <h6 class="mb-1 text-dark font-weight-bold text-sm">
                                                            {{ $item->item_name }}
                                                        </h6>
                                                        <span class="text-xs">#{{ $item->item_code }}</span>
                                                        @if($item->extra_note)
                                                            <span class="text-xs text-dark">Note: {{ $item->extra_note }}</span>
                                                        @endif
                                                        @if($item->customer_group_code)
                                                        <p class="mb-0"><span class="text-sm text-dark">Discount Group: {{ $item->customer_group_code }} <label class="badge bg-gradient-info">{{ $item->discount_perc }}% Off</label></span></p>
                                                        @endif
                                                        <a href="#" class="p-0 text-danger bg-red-600" wire:click.prevent="removeCart('{{$item->id}}')"><i class="fa fa-trash"></i></a>
                                                    </div>
                                                    <div class="d-flex align-items-center text-sm">
                                                        @if($item->quantity>1)<span class="px-2 cursor-pointer" wire:click="cartSetDownQty({{ $item->id }})">
                                                            <i class="fa-solid fa-square-minus fa-xl"></i>
                                                        </span>
                                                        @endif
                                                        {{$item->quantity}}
                                                        <span class="px-2 cursor-pointer" wire:click="cartSetUpQty({{ $item->id }})">
                                                            <i class="fa-solid fa-square-plus fa-xl"></i>
                                                        </span>

                                                        
                                                        <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4" @if($item->customer_group_code) style="text-decoration: line-through;" @endif >{{config('global.CURRENCY')}} {{custom_round($item->unit_price)}}</button>

                                                        @if($item->customer_group_code)
                                                        <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4">{{config('global.CURRENCY')}} {{ custom_round($item->unit_price-(($item->discount_perc/100)*($item->unit_price))) }}</button>
                                                        @endif

                                                    </div>

                                                </li>
                                                <hr class="horizontal dark mt-0 mb-2">
                                                <?php
                                                $total = $total+$item->unit_price*$item->quantity;
                                                if($item->discount_perc){
                                                    $totalDiscount = $totalDiscount+custom_round((($item->discount_perc/100)*$item->unit_price)*$item->quantity);
                                                    //echo $totalDiscount;
                                                }
                                                ?>
                                            @endforeach
                                            <?php
                                            $totalAfterDisc = $total - $totalDiscount;
                                            $tax = $totalAfterDisc * (config('global.TAX_PERCENT') / 100);
                                            $grand_total = $totalAfterDisc+$tax;
                                            ?>
                                        </ul>
                                        
                                        <button class="btn bg-gradient-danger btn-sm float-end" wire:click.prevent="clearAllCart">Remove All Cart</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12 ms-auto">
                                <h6 class="mb-3">Order Summary</h6>
                                <div class="d-flex justify-content-between">
                                    <span class="mb-2 text-sm">
                                    Product Price:
                                    </span>
                                    <span class="text-dark font-weight-bold ms-2">{{config('global.CURRENCY')}} {{custom_round($total)}}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="mb-2 text-sm">
                                    Discount:
                                    </span>
                                    <span class="text-dark ms-2 font-weight-bold">{{config('global.CURRENCY')}} {{custom_round($totalDiscount)}}</span>
                                </div>
                                <hr class="horizontal dark my-2">
                                <div class="d-flex justify-content-between mt-2">
                                    <span class="mb-2 text-md text-dark text-bold">
                                    Total:
                                    </span>
                                    <span class="text-dark text-lg ms-2 font-weight-bold">{{config('global.CURRENCY')}} {{custom_round($totalAfterDisc)}}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-sm">
                                    Taxes:
                                    </span>
                                    <span class="text-dark ms-2 font-weight-bold">{{config('global.CURRENCY')}} {{custom_round($tax)}}</span>
                                </div>
                                <hr class="horizontal dark my-2">
                                <div class="d-flex justify-content-between mt-2">
                                    <span class="mb-2 text-lg text-dark text-bold">
                                    Grand Total:
                                    </span>
                                    <span class="text-dark text-lg ms-2 font-weight-bold">{{config('global.CURRENCY')}} {{custom_round($grand_total)}}</span>
                                </div>
                                <button type="button" class="btn bg-gradient-success btn-sm float-end" wire:click="submitService()">Confirm & Continue</button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @endif
        
        
        <div wire:loading wire:target="submitService">
            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                <div class="la-ball-beat">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        

        <div wire:loading wire:target="applyDiscountGroup">
            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                <div class="la-ball-beat">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        <div wire:loading wire:target="removeDiscount">
            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                <div class="la-ball-beat">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        
        <div wire:loading wire:target="openServiceGroup,selectDiscountGroup,checkStaffDiscountGroup,openServiceGroup">
            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                <div class="la-ball-beat">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        <div wire:loading wire:target="openServiceItems,openPackages,getSectionServices,addtoCartItem,addtoCart,cartSetDownQty,cartSetUpQty">
            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                <div class="la-ball-beat">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        @include('components.newcustomeoperation')
        @include('components.modals.customerSignatureModel')
    </div>
</main>

@push('custom_script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    window.addEventListener('mobile0Remove',event=>{
        $("#mobilenumberInput").on("input", function() {
            if (/^0/.test(this.value)) {
                this.value = this.value.replace(/^0/, "")
            }
        });
    });

    window.addEventListener('scrolltop',event=>{
        $(document).ready(function(){
            $('html, body').animate({
                scrollTop: $("#servceGroup").offset().top - 100
            }, 100);
        });
    });


    window.addEventListener('scrolltopQl',event=>{
        $(document).ready(function(){
            $('html, body').animate({
                scrollTop: $("#serviceQlItems").offset().top - 100
            }, 100);
        });
    });

    window.addEventListener('scrollToSearchVehicle',event=>{
        $(document).ready(function(){
            $('html, body').animate({
                scrollTop: $("#searchVehicleDiv").offset().top - 100
            }, 100);
        });
    });
    
    window.addEventListener('showPopUpDiscountImage',event=>{
        $('#discountImageModal').modal('show');
    });

    window.addEventListener('openServicesListModal',event=>{
        $('#servicePriceModal').modal('show');
    });
    window.addEventListener('closeServicesListModal',event=>{
        $('#servicePriceModal').modal('hide');
    });

    window.addEventListener('opennumberPlateModal',event=>{
        $('#numberPlateModal').modal('show');
    });
    window.addEventListener('closenumberPlateModal',event=>{
        $('#numberPlateModal').modal('hide');
    });

    window.addEventListener('openDiscountGroupModal',event=>{
        $('#discountGroupModal').modal('show');
    });
    window.addEventListener('closeDiscountGroupModal',event=>{
        $('#discountGroupModal').modal('hide');
    });

    window.addEventListener('openPckageAddOnsModal',event=>{
        $('#pckageAddOnsModal').modal('show');
    });
    window.addEventListener('closePckageAddOnsModal',event=>{
        $('#pckageAddOnsModal').modal('hide');
    });

    window.addEventListener('selectSearchEvent',event=>{
        $(document).ready(function () {
            $('#newVehicleKMClick').click(function(){
                //alert('5');
                $('.signaturePadDiv').hide();
            });
            $('#customerTypeSelect').select2();
            $('#plateState').select2();
            $('#vehicleTypeInput').select2();
            $('#vehicleMakeInput').select2();
            $('#vehicleModelInput').select2();
            $('#seachByCategory').select2();
            $('#seachBySubCategory').select2();
            $('#seachByBrand').select2();
            $('#plateCode').select2();

            $('#customerTypeSelect').on('change', function (e) {
                var customerTypeVal = $('#customerTypeSelect').select2("val");
                @this.set('customer_type', customerTypeVal);
            });
            $('#plateState').on('change', function (e) {
                var plateStateVal = $('#plateState').select2("val");
                @this.set('plate_state', plateStateVal);
            });
            $('#vehicleTypeInput').on('change', function (e) {
                var vehicleTypeVal = $('#vehicleTypeInput').select2("val");
                @this.set('vehicle_type', vehicleTypeVal);
            });
            $('#vehicleMakeInput').on('change', function (e) {
                var makeVal = $('#vehicleMakeInput').select2("val");
                @this.set('make', makeVal);
            });
            $('#vehicleModelInput').on('change', function (e) {
                var modelVal = $('#vehicleModelInput').select2("val");
                @this.set('model', modelVal);
            });
            $('#seachByCategory').on('change', function (e) {
                var catVal = $('#seachByCategory').select2("val");
                @this.set('ql_search_category', catVal);
            });
            $('#seachBySubCategory').on('change', function (e) {
                var subCatVal = $('#seachBySubCategory').select2("val");
                @this.set('ql_search_subcategory', subCatVal);
            });
            $('#seachByBrand').on('change', function (e) {
                var BrandVal = $('#seachByBrand').select2("val");
                @this.set('ql_search_brand', BrandVal);
            });
            $('#plateCode').on('change', function (e) {
                var stateCodeVal = $('#plateCode').select2("val");
                @this.set('plate_code', stateCodeVal);
            });


        });
    });

    

</script>

<!-- Signature Script -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/signature_pad@3.0.0-beta.3/dist/signature_pad.umd.min.js"></script>

<script type="text/javascript">
window.addEventListener('showSignature',event=>{
    $('#customerSignatureModal').modal('show');
    var signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
        backgroundColor: 'rgba(255, 255, 255, 0)',
        penColor: 'rgb(0, 0, 0)'
    });
    var saveButton = document.getElementById('saveSignature');
    var cancelButton = document.getElementById('clearSignature');
    saveButton.addEventListener('click', function (event) {
        var data = signaturePad.toDataURL('image/png');
        console.log(data);
        @this.set('customerSignature', data);
        $('#customerSignatureModal').modal('hide');
        // Send data to server instead...
        //window.open(data);
    });
    cancelButton.addEventListener('click', function (event) {
        signaturePad.clear();
    });

    

});

window.addEventListener('imageUpload',event=>{
    $('#vehicleImage').click(function(){
        $("#vehicleImageFile").trigger('click');
    });
    $('#plateImage').click(function(){
        $("#plateImageFile").trigger('click');
    });
    $("#upfile1").click(function () {
        $("#file1").trigger('click');
    });
    $("#upfile2").click(function () {
        $("#file2").trigger('click');
    });
    $("#upfile3").click(function () {
        $("#file3").trigger('click');
    });
    $("#upfile4").click(function () {
        $("#file4").trigger('click');
    });
    $("#upfile5").click(function () {
        $("#file5").trigger('click');
    });
    $("#upfile6").click(function () {
        $("#file6").trigger('click');
    });
});
</script>
@endpush