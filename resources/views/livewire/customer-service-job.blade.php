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
        @endif
        @if($showServiceGroup)
            <div class="row" id="servceGroup">
                @if(!$servicesGroupList->isEmpty())
                    @foreach($servicesGroupList as $servicesGroup)
                        <div class="col-sm-4 col-md-3 col-lg-2 col-xl-2 my-2">
                            <div class="card h-100" >
                                <a wire:click="serviceGroupForm({{$servicesGroup}})" href="javascript:;">
                                    <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('{{asset("img/".str_replace(" ","-",$servicesGroup->department_name).".jpg")}}');">
                                        @if($service_group_id == $servicesGroup->id)
                                        <span class="mask bg-gradient-dark opacity-4"></span>
                                        @else
                                        <span class="mask bg-gradient-dark opacity-9"></span>
                                        @endif
                                        <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
                                            <h5 class="@if($service_group_id == $servicesGroup->id) text-primary @else text-white @endif font-weight-bolder mb-4 pt-2">{{$servicesGroup->department_name}}</h5>
                                            <!-- <p class="text-white">Wealth creation is an evolutionarily recent positive-sum game. It is all about who take the opportunity first.</p> -->
                                            <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:;">
                                                <button wire:click="serviceGroupForm({{$servicesGroup}})" class="btn @if($service_group_id == $servicesGroup->id) bg-gradient-primary @else btn-outline-light @endif" type="button" >Select</button>
                                            </a>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                    <div wire:loading wire:target="serviceGroupForm">
                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                            <div class="la-ball-beat">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-3 col-lg-2 col-xl-2 my-2">
                        <div class="card h-100" >
                            <a wire:click="openServiceItems()" href="javascript:;">
                                <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('{{asset("img/PP00039item.jpg")}}');">
                                    @if($selectServiceItems)
                                    <span class="mask bg-gradient-dark opacity-4"></span>
                                    @else
                                    <span class="mask bg-gradient-dark opacity-9"></span>
                                    @endif
                                    <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
                                        <h5 class="@if($selectServiceItems) text-primary @else text-white @endif font-weight-bolder mb-4 pt-2">Items</h5>
                                        <!-- <p class="text-white">Wealth creation is an evolutionarily recent positive-sum game. It is all about who take the opportunity first.</p> -->
                                        <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:;">
                                            <button wire:click="openServiceItems()" class="btn @if($selectServiceItems) bg-gradient-primary @else btn-outline-light @endif" type="button" >Select</button>
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-3 col-lg-2 col-xl-2 my-2">
                        <div class="card h-100" >
                            <a wire:click="openPackages()" href="javascript:;">
                                <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('{{asset("img/service-item-products.jpg")}}');">
                                    @if($selectPackageMenu)
                                    <span class="mask bg-gradient-dark opacity-4"></span>
                                    @else
                                    <span class="mask bg-gradient-dark opacity-9"></span>
                                    @endif
                                    <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
                                        <h5 class="@if($selectPackageMenu) text-primary @else text-white @endif font-weight-bolder mb-4 pt-2">Packages</h5>
                                        <!-- <p class="text-white">Wealth creation is an evolutionarily recent positive-sum game. It is all about who take the opportunity first.</p> -->
                                        <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:;">
                                            <button wire:click="openPackages()" class="btn @if($selectPackageMenu) bg-gradient-primary @else btn-outline-light @endif" type="button" >Select</button>
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
            @if($showSectionsList)
                <div class="row mt-2 mb-2">
                    @foreach($sectionsLists as $sectionsList)
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3 my-2 cursor-pointer" wire:click="getSectionServices({{$sectionsList}})">
                            <div class="card bg-gradient-primary">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-8 p-0">
                                            <div class="numbers">
                                            <p class="text-white text-sm mb-0 opacity-7">{{$service_group_name}}</p>
                                            <h5 class="text-white font-weight-bolder mb-0">
                                            {{$sectionsList->PropertyName}}
                                            </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-white shadow text-center border-radius-md">
                                                <i class="cursor-pointer fa-solid fa-angles-down text-dark text-lg opacity-10"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif
        @if($showServiceSectionsList)
            <!-- Modal -->
            <style type="text/css">
                .modal-body{
                    max-height: calc(100vh - 300px);
                    overflow-y: auto;
                }
            </style>
            <div class="modal fade" id="servicePriceModal" tabindex="-1" role="dialog" aria-labelledby="servicePriceModalLabel" aria-hidden="true" wire:ignore.self style="z-index:99999;" >
                <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:90%;">
                    <div class="modal-content">
                        @if (session()->has('cartsuccess'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <span class="alert-icon text-light"><i class="ni ni-like-2"></i></span>
                                <span class="alert-text text-light"><strong>Success!</strong> {{ Session::get('cartsuccess') }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="modal-header">
                            <h5 class="modal-title" id="servicePriceModalLabel">{{$service_group_name}} - {{$selectedSectionName}}</h5>
                            <button type="button" class="btn-close text-dark " style="font-size: 2.125rem !important;" data-bs-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true" class="text-xl">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body py-0">
                            <div class="row">
                                @forelse($sectionServiceLists as $sectionServiceList)
                                <?php $priceDetails = $sectionServiceList['priceDetails']; ?>
                                <?php $discountDetails = $sectionServiceList['discountDetails']; ?>
                                @if($priceDetails->UnitPrice!=0)
                                <div class="col-md-6">
                                    
                                    <div class="bg-gray-100 my-3 p-2">
                                        <div class="d-flex">
                                            <h6>{{$priceDetails->ItemCode}} - {{$priceDetails->ItemName}}</h6>
                                            <div class="ms-auto">
                                                @if(!empty($discountDetails))
                                                    <span class="badge bg-gradient-info">{{round($discountDetails->DiscountPerc,2)}}%off</span>
                                                @endif
                                                
                                            </div>
                                        </div>
                                        
                                        
                                        <p class="d-none text-sm mb-0">The website was initially built in PHP, I need a professional ruby programmer to shift it.</p>
                                        <!-- <textarea style="padding-left: 5px !important;" class="form-control" placeholder="Notes..!" wire:model="extra_note.{{$priceDetails->ItemId}}"></textarea > -->
                                        <div class="d-flex border-radius-lg p-0 mt-2">
                                            
                                            <h4 class="my-auto me-2" @if($discountDetails != null) style="text-decoration: line-through;" @endif>{{config('global.CURRENCY')}} {{round($priceDetails->UnitPrice,2)}}
                                            </h4>
                                            @if($discountDetails != null)
                                            <h4 class="my-auto">
                                            <span class="text-secondary text-sm me-1">{{config('global.CURRENCY')}}</span>{{ round($priceDetails->UnitPrice-(($discountDetails->DiscountPerc/100)*$priceDetails->UnitPrice),2) }}
                                            </h4>
                                            
                                            @endif

                                            <a href="javascript:;" class="btn bg-gradient-primary mb-0 ms-auto btn-sm"  wire:click="addtoCart('{{$priceDetails}}','{{$discountDetails}}')">Add Now</a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @empty
                                @endforelse
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" class="btn bg-gradient-primary">Save changes</button> -->
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</main>