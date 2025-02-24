<style>
    .modal-dialog {
        max-width: 90% !important;
    }
    .modal{
        z-index: 99999;
    }
</style>

<!-- Modal -->
<div wire:ignore.self class="modal fade" id="addServiceItemsModal" tabindex="-1" role="dialog" aria-labelledby="addServiceItemsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="addServiceItemsModalLabel">#{{$job_number}} Update</h5>
                <div class="float-end">
                    <b>Job Status: <span class="text-sm {{config('global.jobs.status_text_class')[$job_status]}} pb-2">{{config('global.jobs.status')[$job_status]}}</span> </b>
                </div>
            </div>
            <div class="modal-body">
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
                                        </div>
                                        
                                    </div>
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
                                                        $totalDiscount = $totalDiscount+custom_round((($item->discount_perc/100)*($item->unit_price*$item->quantity)));
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
                            
                            
                            @if($service_group_name=='Quick Lube')
                                @if($qlFilterOpen)
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4">
                                            <label for="seachByBrand">Engine Oil Brand</label>
                                            <div class="form-group">
                                                <select class="form-control" id="seachByBrand" wire:model="ql_search_brand" style="padding-left:5px !important;">
                                                    <option value="">-Select-</option>
                                                    @foreach($qlBrandsLists as $qlBrand)
                                                    <option value="{{$qlBrand->BrandId}}">{{$qlBrand->Description}}</option>
                                                    @endforeach
                                                </select>
                                                @error('ql_search_brand') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label></label>
                                            <div class="form-group pt-1">
                                                <button class="btn bg-gradient-primary me-2" wire:click="qlItemkmRange(5000)">5K</button>
                                                <button class="btn bg-gradient-primary" wire:click="qlItemkmRange(10000)">10K</button>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label for="seachByCategory">Category</label>
                                                <select class="form-control" id="seachBy Category" wire:model="ql_search_category" wire:change="qlCategorySelect" style="padding-left:5px !important;">
                                                    <option value="">-Select-</option>
                                                    @foreach($itemQlCategories as $itemQlCategory)
                                                    <option value="{{$itemQlCategory->CategoryId}}">{{$itemQlCategory->Description}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:loading wire:target="qlItemkmRange,qlCategorySelect">
                                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                            <div class="la-ball-beat">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-8 col-sm-8">
                                            <div class="form-group">
                                                <label for="seachByItemBrand">Items Name</label>
                                                <input type="text" wire:model.defer="quickLubeItemSearch" name="" class="form-control">
                                            </div>
                                            @error('quickLubeItemSearch') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label></label>
                                            <div class="form-group pt-1">
                                                <!-- <input type="text" wire:model.defer="quickLubeItemSearch" name="" class="form-control"> -->
                                                <button class="btn bg-gradient-info" wire:click="searchQuickLubeItem">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:loading wire:target="searchQuickLubeItem">
                                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                            <div class="la-ball-beat">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if($showQlItems)
                                    <div class="row mt-4"  id="serviceQlItems">
                                        @if (session()->has('cartsuccess'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <span class="alert-icon text-light"><i class="ni ni-like-2"></i></span>
                                                <span class="alert-text text-light"><strong>Success!</strong> {{ Session::get('cartsuccess') }}</span>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif
                                        @forelse($quickLubeItemsList as $quickLubeItem)
                                            <?php $qlItemPriceDetails = $quickLubeItem['priceDetails']; ?>
                                            <?php $qlItemDiscountDetails = $quickLubeItem['discountDetails']; ?>
                                            @if($qlItemPriceDetails->UnitPrice!=0)
                                            <div class="col-md-4 col-sm-6 mb-4">
                                                <div class="card">
                                                    <div class="card-header text-center pt-4 pb-3">
                                                        <h6 class="font-weight-normal mt-2" style="text-transform: capitalize;">
                                                            {{ strtolower($qlItemPriceDetails->ItemName)}}

                                                        </h6>
                                                        <small>{{$qlItemPriceDetails->ItemCode}}</small>
                                                        <!-- <textarea style="padding-left: 5px !important;" class="form-control" placeholder="Notes..!" wire:model="extra_note.{{$qlItemPriceDetails->ItemId}}"></textarea > -->
                                                        <div class="ms-auto">
                                                            @if(!empty($qlItemDiscountDetails))
                                                                <span class="badge bg-gradient-info">{{custom_round($qlItemDiscountDetails->DiscountPerc)}}%off</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="card-body text-lg-left text-center pt-0">
                                                        <h4 class="my-auto me-2" @if($qlItemDiscountDetails != null) style="text-decoration: line-through;" @endif>{{config('global.CURRENCY')}} {{custom_round($qlItemPriceDetails->UnitPrice)}}
                                                        </h4>
                                                        @if($qlItemDiscountDetails != null)
                                                        <h4 class="my-auto">
                                                        <span class="text-secondary text-sm me-1">{{config('global.CURRENCY')}}</span>{{ custom_round($qlItemPriceDetails->UnitPrice-(($qlItemDiscountDetails->DiscountPerc/100)*$qlItemPriceDetails->UnitPrice)) }}
                                                        </h4>
                                                        @endif
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <input type="number" class="form-control w-30 m-auto" placeholder="Qty" wire:model.defer="ql_item_qty.{{$qlItemPriceDetails->ItemId}}" style="padding-left:5px !important;" />
                                                                <a href="javascript:;" class="btn bg-gradient-primary mb-0 ms-auto btn-sm"  wire:click="addtoCartItem('{{$qlItemPriceDetails}}','{{$qlItemDiscountDetails}}')">Add Now</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        @empty
                                            <div class="alert alert-danger text-white" role="alert">
                                                <strong>Empty!</strong> The Searched items are not in stock!</div>
                                        @endforelse 
                                    </div>
                                @endif
                                @forelse($sectionsLists as $sectionsList)
                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3 my-2 cursor-pointer" wire:click="getSectionServices({{$sectionsList}})">
                                    <!--  aria-hidden="true" data-bs-toggle="modal" data-bs-target="#exampleModal"-->
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
                                @empty
                                @endforelse
                            @else
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
                            @endif
                        </div>

                        @if($showServiceSectionsList)
                            @if (session()->has('cartsuccess'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <span class="alert-icon text-light"><i class="ni ni-like-2"></i></span>
                                    <span class="alert-text text-light"><strong>Success!</strong> {{ Session::get('cartsuccess') }}</span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <h5 class="modal-title" id="servicePriceModalLabel">{{$service_group_name}} - {{$selectedSectionName}}</h5>
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
                                                    <span class="badge bg-gradient-info">{{custom_round($discountDetails->DiscountPerc)}}%off</span>
                                                @endif
                                                
                                            </div>
                                        </div>
                                        
                                        
                                        <p class="d-none text-sm mb-0">The website was initially built in PHP, I need a professional ruby programmer to shift it.</p>
                                        <!-- <textarea style="padding-left: 5px !important;" class="form-control" placeholder="Notes..!" wire:model="extra_note.{{$priceDetails->ItemId}}"></textarea > -->
                                        <div class="d-flex border-radius-lg p-0 mt-2">
                                            
                                            <h4 class="my-auto me-2" @if($discountDetails != null) style="text-decoration: line-through;" @endif>{{config('global.CURRENCY')}} {{custom_round($priceDetails->UnitPrice)}}
                                            </h4>
                                            @if($discountDetails != null)
                                            <h4 class="my-auto">
                                            <span class="text-secondary text-sm me-1">{{config('global.CURRENCY')}}</span>{{ custom_round($priceDetails->UnitPrice-(($discountDetails->DiscountPerc/100)*$priceDetails->UnitPrice)) }}
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
                        @endif
                    @endif

                    @if($selectServiceItems)
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="seachByItemCategory">Category</label>
                                <select class="form-control" id="seachByItemCategory" wire:model="item_search_category">
                                    <option value="">-Select-</option>
                                    @foreach($itemCategories as $itemCategory)
                                    <option value="{{$itemCategory->CategoryId}}">{{$itemCategory->Description}}</option>
                                    @endforeach
                                </select>
                                @error('item_search_category') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="seachByItemSubCategory">Sub Category</label>
                                <select class="form-control" id="seachByItemSubCategory" wire:model="item_search_subcategory">
                                    <option value="">-Select-</option>
                                    @foreach($itemSubCategories as $itemSubCategory)
                                    <option value="{{$itemSubCategory->SubCategoryId}}">{{$itemSubCategory->Description}}</option>
                                    @endforeach
                                </select>
                                @error('item_search_subcategory') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4 d-none">
                            <div class="form-group">
                                <label for="seachByItemBrand">Brand</label>
                                <select class="form-control" id="seachByItemBrand" wire:model="item_search_brand">
                                    <option value="">-Select-</option>
                                    @foreach($itemBrandsLists as $itemBrand)
                                    <option value="{{$itemBrand->BrandId}}">{{$itemBrand->Description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="seachByItemBrand">Items Name</label>
                                <input type="text" wire:model.defer="itemSearchName" name="" class="form-control">
                                <button class=" mt-2 btn bg-gradient-info" wire:click="dearchServiceItems">Search</button>
                            </div>
                            
                        </div>
                    </div>
                    <div wire:loading wire:target="dearchServiceItems,addtoCartItem">
                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                <div class="la-ball-beat">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                        </div>
                    <div class="row mt-4">
                        @if($showItemsSearchResults)
                            @forelse($serviceItemsList as $servicesItem)
                                <?php $itemPriceDetails = $servicesItem['priceDetails']; ?>
                                <?php $itemDiscountDetails = $servicesItem['discountDetails']; ?>
                                @if($itemPriceDetails->UnitPrice!=0)
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <div class="card-header text-center pt-4 pb-3">
                                            <h4 class="font-weight-normal mt-2">
                                                {{$itemPriceDetails->ItemName}}
                                            </h4>
                                            <small>{{$itemPriceDetails->ItemCode}}</small>
                                            <h4 class="font-weight-bold mt-2">
                                                <small>AED</small>{{custom_round($itemPriceDetails->UnitPrice)}}
                                            </h4>
                                        </div>
                                        <div class="card-body text-lg-left text-center pt-0">
                                            <a href="javascript:;" class="btn btn-icon bg-gradient-primary d-lg-block mt-3 mb-0" wire:click="addtoCartItem('{{$itemPriceDetails}}','{{$itemDiscountDetails}}')">Buy Now<i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @empty
                                <div class="alert alert-danger text-white" role="alert">
                                                <strong>Empty!</strong> The Searched items are not in stock!</div>
                            @endforelse 
                        @endif
                    </div>
                    @endif
                    @if($showPackageList)
                    <div class="row mt-4">
                        <div class="container">
                            <div class="tab-content tab-space">
                                <div class="tab-pane active" id="monthly" role="tabpanel" aria-labelledby="tabs-iconpricing-tab-1">
                                    <div class="row">
                                        @foreach($servicePackage as $servicePkg)

                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-lg-0 mb-4">
                                                <div class="card">
                                                    <div class="card-header text-center pt-4 pb-3">
                                                        <span class="badge rounded-pill bg-light text-dark">{{$servicePkg->PackageName}}</span>
                                                        <p class="text-sm font-weight-bold text-dark mt-2 mb-0">Duration: {{$servicePkg->Duration}} Months</p>
                                                        <p class="text-sm font-weight-bold text-dark">{{$servicePkg->PackageKM}} K.M</p>
                                                        
                                                    </div>
                                                    <div class="card-body text-lg-start text-left pt-0">
                                                        <?php $totalPrice=0;?>
                                                        <?php $unitPrice=0;?>
                                                        <?php $discountedPrice=0;?>
                                                        @foreach($servicePkg->packageDetails as $packageDetails)
                                                            @if($packageDetails->isDefault==1)
                                                            <div class="d-flex justify-content-lg-start p-2">
                                                                
                                                                <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                                                    <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                                                </div>
                                                                <?php $totalPrice = $totalPrice+$packageDetails->TotalPrice; ?>
                                                                <?php $unitPrice = $unitPrice+$packageDetails->UnitPrice; ?>
                                                                <?php $discountedPrice = $discountedPrice+$packageDetails->DiscountedPrice; ?>
                                                                
                                                                <div>
                                                                    @if($packageDetails->ItemType=='S')
                                                                    <span class="ps-3">{{$packageDetails->labourItemDetails['ItemName']}}</span>
                                                                    @else
                                                                    <span class="ps-3">{{$packageDetails->inventoryItemDetails['ItemName']}}</span>
                                                                    @endif
                                                                    <p class="h6"><small><s>AED {{$packageDetails->UnitPrice}}</s> {{$packageDetails->DiscountedPrice}}</small></p>
                                                                </div>
                                                            </div>
                                                            @endif  
                                                        @endforeach
                                                        <!-- <div class="d-flex justify-content-lg-start p-2">
                                                            <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                                                                <i class="fas fa-minus" aria-hidden="true"></i>
                                                            </div>
                                                            <div>
                                                                <span class="ps-3">Integration help </span>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-lg-start p-2">
                                                            <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                                                                <i class="fas fa-minus" aria-hidden="true"></i>
                                                            </div>
                                                            <div>
                                                                <span class="ps-3">Sketch Files </span>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-lg-start  p-2">
                                                            <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                                                                <i class="fas fa-minus" aria-hidden="true"></i>
                                                            </div>
                                                            <div>
                                                                <span class="ps-3">API Access </span>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-lg-start p-2">
                                                            <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                                                                <i class="fas fa-minus" aria-hidden="true"></i>
                                                            </div>
                                                            <div>
                                                                <span class="ps-3">Complete documentation </span>
                                                            </div>
                                                        </div> -->
                                                        <h3 class="text-default font-weight-bold mt-2"></h3>
                                                        <p class="text-center h4"><s><small>AED</small> {{$unitPrice}}</s> <small>AED</small> {{$discountedPrice}}</p>
                                                        <div class="text-center align-center">
                                                            <a href="javascript:;" class="btn btn-icon bg-gradient-dark d-lg-block mt-3 mb-0 " wire:click="packageAddOnContinue({{$servicePkg}})">Continue<i class="fas fa-arrow-right ms-1" aria-hidden="true"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if($showPackageAddons)
                                        @include('components.modals.pckageAddOns')
                                        @endif
                                <!-- <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4  col-xs-6 mb-lg-0 mb-4">
                                  <div class="card">
                                    <div class="card-header text-center pt-4 pb-3">
                                      <span class="badge rounded-pill bg-light text-dark">Starter</span>
                                      <h1 class="font-weight-bold mt-2">
                                        <small>$</small>59
                                      </h1>
                                    </div>
                                    <div class="card-body text-lg-start text-center pt-0">
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">2 team members</span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">20GB Cloud storage </span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                                          <i class="fas fa-minus" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">Integration help </span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                                          <i class="fas fa-minus" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">Sketch Files </span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                                          <i class="fas fa-minus" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">API Access </span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                                          <i class="fas fa-minus" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">Complete documentation </span>
                                        </div>
                                      </div>
                                      <a href="javascript:;" class="btn btn-icon bg-gradient-dark d-lg-block mt-3 mb-0">
                                        Join
                                        <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
                                      </a>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4  col-xs-6 mb-lg-0 mb-4">
                                  <div class="card">
                                    <div class="card-header text-center pt-4 pb-3">
                                      <span class="badge rounded-pill bg-light text-dark">Premium</span>
                                      <h1 class="font-weight-bold mt-2">
                                        <small>$</small>89
                                      </h1>
                                    </div>
                                    <div class="card-body text-lg-start text-center pt-0">
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">10 team members</span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">40GB Cloud storage </span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">Integration help </span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">Sketch Files </span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                                          <i class="fas fa-minus" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">API Access </span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                                          <i class="fas fa-minus" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">Complete documentation </span>
                                        </div>
                                      </div>
                                      <a href="javascript:;" class="btn btn-primary btn-icon d-lg-block mt-3 mb-0">
                                        Try Premium
                                        <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
                                      </a>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4  col-xs-6 mb-lg-0 mb-4">
                                  <div class="card">
                                    <div class="card-header text-center pt-4 pb-3">
                                      <span class="badge rounded-pill bg-light text-dark">Enterprise</span>
                                      <h1 class="font-weight-bold mt-2">
                                        <small>$</small>99
                                      </h1>
                                    </div>
                                    <div class="card-body text-lg-start text-center pt-0">
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">Unlimited team members</span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">100GB Cloud storage </span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">Integration help </span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">Sketch Files </span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">API Access </span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">Complete documentation </span>
                                        </div>
                                      </div>
                                      <a href="javascript:;" class="btn btn-icon bg-gradient-dark d-lg-block mt-3 mb-0">
                                        Join
                                        <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
                                      </a>
                                    </div>
                                  </div>
                                </div> -->
                              </div>
                            </div>
                            <div class="tab-pane" id="annual" role="tabpanel" aria-labelledby="tabs-iconpricing-tab-2">
                              <div class="row">
                                <div class="col-lg-4 mb-lg-0 mb-4">
                                  <div class="card">
                                    <div class="card-header text-center pt-4 pb-3">
                                      <span class="badge rounded-pill bg-light text-dark">Starter</span>
                                      <h1 class="font-weight-bold mt-2">
                                        <small>$</small>119
                                      </h1>
                                    </div>
                                    <div class="card-body text-lg-start text-center pt-0">
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">2 team members</span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">20GB Cloud storage </span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                                          <i class="fas fa-minus" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">Integration help </span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                                          <i class="fas fa-minus" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">Sketch Files </span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                                          <i class="fas fa-minus" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">API Access </span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                                          <i class="fas fa-minus" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">Complete documentation </span>
                                        </div>
                                      </div>
                                      <a href="javascript:;" class="btn btn-icon bg-gradient-dark d-lg-block mt-3 mb-0">
                                        Join
                                        <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
                                      </a>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-lg-4 mb-lg-0 mb-4">
                                  <div class="card">
                                    <div class="card-header text-center pt-4 pb-3">
                                      <span class="badge rounded-pill bg-light text-dark">Premium</span>
                                      <h1 class="font-weight-bold mt-2">
                                        <small>$</small>159
                                      </h1>
                                    </div>
                                    <div class="card-body text-lg-start text-center pt-0">
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">10 team members</span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">40GB Cloud storage </span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">Integration help </span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">Sketch Files </span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                                          <i class="fas fa-minus" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">API Access </span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                                          <i class="fas fa-minus" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">Complete documentation </span>
                                        </div>
                                      </div>
                                      <a href="javascript:;" class="btn btn-primary btn-icon d-lg-block mt-3 mb-0">
                                        Try Premium
                                        <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
                                      </a>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-lg-4 mb-lg-0 mb-4">
                                  <div class="card">
                                    <div class="card-header text-center pt-4 pb-3">
                                      <span class="badge rounded-pill bg-light text-dark">Enterprise</span>
                                      <h1 class="font-weight-bold mt-2">
                                        <small>$</small>399
                                      </h1>
                                    </div>
                                    <div class="card-body text-lg-start text-center pt-0">
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">Unlimited team members</span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">100GB Cloud storage </span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">Integration help </span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">Sketch Files </span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">API Access </span>
                                        </div>
                                      </div>
                                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                          <span class="ps-3">Complete documentation </span>
                                        </div>
                                      </div>
                                      <a href="javascript:;" class="btn btn-icon bg-gradient-dark d-lg-block mt-3 mb-0">
                                        Join
                                        <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
                                      </a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                    @endif
                @endif












                

            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <!-- <button type="submit" class="btn bg-gradient-primary">Submit</button> -->
            </div>
       </div>
    </div>
</div>
