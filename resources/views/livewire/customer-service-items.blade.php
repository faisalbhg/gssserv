@push('custom_css')

@endpush
<main class="main-content position-relative  border-radius-lg h-100">
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
                                        <img class="w-100 rounded-3 shadow-lg" src='{{url("public/storage/".$selectedVehicleInfo["vehicle_image"])}}'>
                                        <!-- <img class="w-100 rounded-3 shadow-lg" src="data:image/png;base64,{{$selectedVehicleInfo['vehicle_image_base64']}}"> -->
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="card card-profile card-plain">
                                <div class="card-body text-left p-0">
                                    <div class="p-md-0 pt-3">
                                        <h5 class="font-weight-bolder mb-0">
                                            {{$selectedVehicleInfo['plate_number_final']}}
                                        </h5>
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
                                        <button type="button" class="btn bg-gradient-primary btn-tooltip btn-sm" title="Edit Customer/Discount/Vehicle" wire:click="editCustomer()">Edit Customer/Vehicle Other Service</button>
                                        <div wire:loading wire:target="editCustomer">
                                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                <div class="la-ball-beat">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- @if(!empty($appliedDiscount))
                                        <button class="btn bg-gradient-info text-white ms-0 py-1 px-3 m-0" wire:click.prevent="applyDiscountGroup()">Apply {{$appliedDiscount['code']}} Discount Group</button> 
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
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 my-2" id="cartDisplayId">
                    @if($cardShow)
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
                                                            <label wire:click.prevent="removeLineDiscount({{$item->id}})" class="badge bg-gradient-info cursor-pointer">{{strtolower($item->customer_group_code)}} {{ $item->discount_perc }}% Off <i class="fa fa-trash text-danger"></i> </label>
                                                            @endif

                                                            @if($confirming===$item->id)
                                                            <p>
                                                                <label class="p-0 text-success bg-red-600 cursor-pointer float-start" wire:click.prevent="kill({{ $item->id }},{{ $item->item_id }})"><i class="fa fa-trash"></i> Yes</label>
                                                                <label class="p-0 text-info bg-red-600 cursor-pointer float-end" wire:click.prevent="safe({{ $item->id }})"><i class="fa fa-trash"></i> No</label>
                                                                <div wire:loading wire:target="kill">
                                                                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                                        <div class="la-ball-beat">
                                                                            <div></div>
                                                                            <div></div>
                                                                            <div></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div wire:loading wire:target="safe">
                                                                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                                        <div class="la-ball-beat">
                                                                            <div></div>
                                                                            <div></div>
                                                                            <div></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </p>

                                                            @else
                                                                
                                                                    <label class="p-0 text-danger bg-red-600 cursor-pointer" wire:click.prevent="confirmDelete({{ $item->id }})"><i class="fa fa-trash"></i> Remove</label>
                                                                
                                                            @endif

                                                        </div>
                                                        <div class="d-flex align-items-center text-sm">
                                                            <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4" @if($item->customer_group_code) style="text-decoration: line-through;" @endif >{{config('global.CURRENCY')}} {{custom_round($item->unit_price)}}</button>

                                                            @if($item->customer_group_code)
                                                            <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4">{{config('global.CURRENCY')}} {{ custom_round($item->unit_price-(($item->discount_perc/100)*($item->unit_price))) }}</button>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex align-items-center text-sm">
                                                            @if($item->item_code!='I09137')
                                                                @if($item->cart_item_type!=3)
                                                                    @if($item->quantity>1)
                                                                        <span class="px-2 cursor-pointer" wire:click="cartSetDownQty({{ $item->id }})">
                                                                            <i class="fa-solid fa-square-minus fa-xl"></i>
                                                                        </span>
                                                                    @endif
                                                                    {{$item->quantity}}
                                                                    <span class="px-2 cursor-pointer" wire:click="cartSetUpQty({{ $item->id }})">
                                                                        <i class="fa-solid fa-square-plus fa-xl"></i>
                                                                    </span>
                                                                @else
                                                                    {{$item->quantity}}
                                                                @endif    
                                                            @else
                                                                {{$item->quantity}}
                                                            @endif
                                                        </div>
                                                        <div class="d-flex align-items-center text-sm">
                                                            <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4">{{config('global.CURRENCY')}}
                                                            @if($item->customer_group_code)
                                                            {{ custom_round($item->unit_price-(($item->discount_perc/100)*($item->unit_price)))*$item->quantity }}
                                                            @else
                                                            {{custom_round($item->unit_price*$item->quantity)}}
                                                            @endif</button>

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

                                                if($selectedVehicleInfo['customerInfoMaster']['VatApplicable']==1){
                                                    $tax = $totalAfterDisc * (config('global.TAX_PERCENT') / 100);
                                                }
                                                else
                                                {
                                                    $tax = 0;
                                                }
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
                                    @if($cardShow)
                                    <button type="button" class="btn bg-gradient-success btn-sm float-end" wire:click="submitService()">Confirm & Continue</button>
                                    <div wire:loading wire:target="submitService">
                                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                            <div class="la-ball-beat">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div wire:loading wire:target="removeLineDiscount">
                                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                            <div class="la-ball-beat">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div wire:loading wire:target="removeCart">
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
                    @endif
                </div>
            </div>
            <div class="row" id="serviceItemsListDiv">
                <div class="col-md-12 col-sm-12">
                    <button type="button" class="btn bg-gradient-secondary btn-tooltip opacity-5" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Quick Lube Section" data-container="body" data-animation="true" wire:click="selectSection(1)">Quick Lube</button>
                    <button type="button" class="btn bg-gradient-secondary btn-tooltip opacity-5" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Mechanical Section" data-container="body" data-animation="true" wire:click="selectSection(2)">Mechanical</button>
                    <div wire:loading wire:target="selectSection">
                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                            <div class="la-ball-beat">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    @error('selected_section') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="seachByItemCategory">Category</label>
                        <select class="form-control" id="seachItemByCategory" wire:model="item_search_category">
                            <option value="">-Select-</option>
                            @foreach($itemCategories as $itemCategory)
                            <option value="{{$itemCategory->CategoryId}}">{{$itemCategory->Description}}</option>
                            @endforeach
                        </select>
                        @error('item_search_category') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div wire:loading wire:target="item_search_category">
                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                        <div class="la-ball-beat">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="seachByItemSubCategory">Sub Category</label>
                        <select class="form-control" id="seachItemBySubCategory" wire:model="item_search_subcategory">
                            <option value="">-Select-</option>
                            @foreach($itemSubCategories as $itemSubCategory)
                            <option value="{{$itemSubCategory->SubCategoryId}}">{{$itemSubCategory->Description}}</option>
                            @endforeach
                        </select>
                        @error('item_search_subcategory') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
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
                <div class="col-md-8 col-sm-6">
                    <div class="form-group">
                        <label for="seachByItemName">Items Name</label>
                        <input type="text" wire:model="item_search_name" name="" id="seachByItemName" class="form-control">
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="seachByItemName">Items Code</label>
                        <input type="text" wire:model="item_search_code" name="" id="seachByItemCode" class="form-control">
                    </div>
                </div>
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <button class="btn bg-gradient-info" wire:click="searchServiceItems">Search</button>
                    </div>
                </div>
                <div wire:loading wire:target="searchServiceItems">
                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                        <div class="la-ball-beat">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
            @if($showItemsSearchResults)
                <div class="row">
                    @forelse($inventoryItemMasterLists as $servicesItem)
                        <div class="col-md-4 col-sm-6">
                            <div class="card mt-2">
                                <div class="card-header text-center p-2">
                                    <p class="font-weight-normal mt-2 text-capitalize text-sm- font-weight-bold mb-0">
                                        {{strtolower($servicesItem->ItemName)}}<small>({{$servicesItem->ItemCode}})</small>
                                    </p>
                                    <h5 class="font-weight-bold mt-2" >
                                        <small>AED</small>{{custom_round($servicesItem->UnitPrice)}}
                                    </h5>
                                    
                                    <!-- <div class="ms-auto">
                                        
                                            <span class="badge bg-gradient-info">%off</span>
                                        
                                    </div> -->
                                </div>
                                <div class="card-body text-lg-left text-center p-2">
                                    <input type="number" class="form-control w-30 float-start" placeholder="Qty" wire:model.defer="ql_item_qty.{{$servicesItem->ItemId}}" style="padding-left:5px !important;" />
                                    <a href="javascript:;" class="btn btn-icon bg-gradient-primary d-lg-block m-0 float-end p-2" wire:click="addtoCartItem({{$servicesItem}})">Buy Now<i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
                                    </a>
                                    <div wire:loading wire:target="addtoCartItem">
                                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                            <div class="la-ball-beat">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(@$serviceAddedMessgae[$servicesItem->ItemCode])
                                    <div class="text-center">
                                        <span class="alert-icon"><i class="ni ni-like-2 text-success"></i></span>
                                        <span class="alert-text text-success"><strong>Success!</strong> Added serves!</span>
                                        <button type="button" class="btn-close text-success" data-bs-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                    @empty
                        <div class="alert alert-danger text-white" role="alert"><strong>Empty!</strong> The Searched items are not in stock!</div>
                    @endforelse

                    <div class="float-end mt-2">{{$inventoryItemMasterLists->onEachSide(0)->links()}}</div>
                </div>
            @endif
        @endif
    </div>
</main>
