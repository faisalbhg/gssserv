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

        @if($job_number)
            <button type="button" class="btn btn-danger">
                <span>Job Number: </span>
                <span class=" badge-primary text-xl">#{{$job_number}}</span>
            </button>
        @endif

        @if($showForms)
            @include('components.customer-services.vehicle-form')
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
                                        
                                        <button type="button" class="btn bg-gradient-primary btn-tooltip btn-sm" title="Edit Customer/Discount/Vehicle" wire:click="editCustomer()">Edit</button>
                                        <button type="button" class="btn bg-gradient-primary btn-tooltip btn-sm" title="Add Customer/Discount/Vehicle"  wire:click="addNewVehicle()">New Vehicle</button>
                                        <button type="button" class="d-none btn bg-gradient-info btn-tooltip btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Apply Discount Group" data-container="body" data-animation="true" wire:click="clickDiscountGroup()">Discount Group</button>
                                        <button class="btn bg-gradient-info btn-sm" wire:click="openServiceGroup">Services</button>
                                        <button class="btn bg-gradient-dark btn-sm" wire:click="openJobHistory">History</button>
                                        <div wire:loading wire:target="openJobHistory">
                                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                <div class="la-ball-beat">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:loading wire:target="openServiceGroup">
                                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                <div class="la-ball-beat">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </div>
                                        @if(!empty($appliedDiscount))
                                        <button class="d-none btn bg-gradient-danger btn-sm" wire:click.prevent="removeDiscount()">Remove Discount - {{strtolower(str_replace("_"," ",$appliedDiscount['code']))}}</button>
                                        <div wire:loading wire:target="removeDiscount">
                                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                <div class="la-ball-beat">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <!-- @if(@$appliedDiscount['groupType']==2)
                                        <button class="btn bg-gradient-danger btn-sm" wire:click.prevent="removeDiscount()">Remove Discount - {{strtolower(str_replace("_"," ",$appliedDiscount['title']))}}</button>
                                        @endif -->

                                        @if(@$appliedDiscount['groupType']==3)
                                        <button class="d-none btn bg-gradient-success btn-sm " wire:click.prevent="applyEngineOilDiscount()">Apply {{$engineOilDiscountPercentage}}% Discount</button>
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
                                        <!-- @if(!empty($appliedDiscount))
                                        <button class="btn bg-gradient-info text-white ms-0 py-1 px-3 m-0" wire:click.prevent="applyDiscountGroup()">Apply {{$appliedDiscount['code']}} Discount Group</button> 
                                        <button type="button" wire:click="removeDiscount()" class="btn btn-danger btn-simple btn-lg mb-0 p-1">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                        @endif -->
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mt-0">
                                            <div class="card card-blog card-plain">
                                                @if($customerSignature)
                                                <div class="position-relative">
                                                    <a class="d-block blur-shadow-image">
                                                        <img src="{{$customerSignature}}" alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
                                                    </a>
                                                </div>
                                                @endif
                                                <div class="card-body px-1 pt-3">
                                                    <button type="button" class="btn btn-outline-primary btn-sm" wire:click="clickShowSignature()">Customer Signature</button>
                                                    <div wire:loading wire:target="clickShowSignature">
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
                                        @if ($message = Session::get('cartsuccess'))
                                        <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
                                            <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                                            <span class="alert-text"><strong>Success!</strong> {{ $message }}</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        @endif
                                        @if ($message = Session::get('carterror'))
                                        <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                                            <span class="alert-text"><strong>!</strong> {{ $message }}</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        @endif
                                        <div class="card-body p-3 pb-0">
                                            <ul class="list-group">
                                                <?php
                                                    $total = 0;
                                                    $totalDiscount=0;
                                                    $package_job=false;
                                                    $manualDiscountAvailable=false;
                                                    $pendingSendManulDiscountRequest = false;
                                                    $waitingSendManulDiscountRequest=false;
                                                    $aprovedSendManulDiscountRequest=false;
                                                    $rejectedSendManulDiscountRequest=false;
                                                    
                                                ?>
                                                @foreach ($cartItems as $item)
                                                    
                                                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                        
                                                        <div class="d-flex flex-column">
                                                            <h6 class="mb-1 text-dark font-weight-bold text-sm">
                                                                {{ $item->item_name }}
                                                                <span class="text-xs">(#{{ $item->item_code }})</span>
                                                                @if($item->extra_note)
                                                                <br><span class="text-xs text-dark">Note: {{ $item->extra_note }}</span>
                                                                @endif
                                                            </h6>

                                                            @if($item->isWarranty)
                                                            <div><span class="badge bg-gradient-primary">{{$item->warrantyPeriod}} Months Warranty</span></div>
                                                            @endif

                                                            @if($item->customer_group_code != null && $item->manual_discount_status == null && $item->manual_discount_send_for_aproval==null)
                                                                <label wire:click.prevent="removeLineDiscount({{$item->id}})" class="badge bg-gradient-info cursor-pointer">{{strtolower($item->customer_group_code)}} {{ $item->discount_perc }}% Off <i class="fa fa-trash text-danger"></i> </label>
                                                            @elseif($item->customer_group_code != null && $item->manual_discount_status == 1)
                                                                <?php $manualDiscountAvailable=true; ?>
                                                                @if($item->manual_discount_send_for_aproval==null)
                                                                <?php
                                                                    $pendingSendManulDiscountRequest = true;
                                                                    //$manualDiscountRefNo = $item->manual_discount_ref_no;
                                                                ?>
                                                                <label wire:click.prevent="removeManualLineDiscount({{$item->id}})" class="badge bg-gradient-warning cursor-pointer">{{strtolower($item->customer_group_code)}} {{ $item->discount_perc }}% Off <i class="fa fa-trash text-danger"></i> </label>
                                                                @elseif($item->manual_discount_send_for_aproval==1)
                                                                <?php $waitingSendManulDiscountRequest = true; ?>
                                                                <label class="btn btn-sm {{config('global.manualDiscount.status_outline_class')[$item->manual_discount_status]}} ">{{strtolower($item->customer_group_code)}} {{ $item->discount_perc }}% Off - {{config('global.manualDiscount.status')[$item->manual_discount_status]}}  </label>
                                                                @endif
                                                            @elseif($item->customer_group_code != null && $item->manual_discount_status == 2)
                                                                <?php $aprovedSendManulDiscountRequest=true; ?>
                                                                <label class="btn btn-sm {{config('global.manualDiscount.status_outline_class')[$item->manual_discount_status]}} ">{{strtolower($item->customer_group_code)}} {{ $item->discount_perc }}% Off - {{config('global.manualDiscount.status')[$item->manual_discount_status]}}  </label>
                                                            @elseif($item->customer_group_code != null && $item->manual_discount_status == 3)
                                                                <?php $rejectedSendManulDiscountRequest=true;?>
                                                                <label class="btn btn-sm {{config('global.manualDiscount.status_outline_class')[$item->manual_discount_status]}} ">{{strtolower($item->customer_group_code)}} {{ $item->discount_perc }}% Off - {{config('global.manualDiscount.status')[$item->manual_discount_status]}}  </label>
                                                                <span><label wire:click.prevent="applyLineDiscount({{$item}})" class="badge bg-gradient-dark cursor-pointer">Apply Discount </label></span>
                                                            @else
                                                                @if($item->manual_discount_status == 3)
                                                                    <label class="btn btn-sm {{config('global.manualDiscount.status_outline_class')[$item->manual_discount_status]}} ">Manual Discount - {{config('global.manualDiscount.status')[$item->manual_discount_status]}}  </label>
                                                                @endif
                                                                <span><label wire:click.prevent="applyLineDiscount({{$item}})" class="badge bg-gradient-dark cursor-pointer">Apply Discount </label></span>
                                                            @endif


                                                            
                                                            


                                                            @if($confirming===$item->id)
                                                            <p>
                                                                <span><label wire:click.prevent="kill({{ $item->id }},{{ $item->item_id }})" class="badge bg-gradient-success cursor-pointer"><i class="fa fa-trash"></i> Yes</label></span>
                                                                <span><label wire:click.prevent="safe({{ $item->id }})" class="badge bg-gradient-info cursor-pointer"><i class="fa fa-trash"></i> No</label></span>
                                                                
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
                                                            @if($item->job_number==null)
                                                            <span><label wire:click.prevent="confirmDelete({{ $item->id }})" class="badge bg-gradient-danger cursor-pointer"><i class="fa fa-trash"></i> Remove </label></span>
                                                            @elseif(isset($item->current_job_status) || $item->current_job_status == 6 || $item->current_job_status == 1)

                                                            <label class="mt-0 me-2 {{config('global.jobs.status_outline_class')[$item->current_job_status]}}" >Current Status: {{config('global.jobs.status')[$item->current_job_status]}}</label><span><label wire:click.prevent="confirmDelete({{ $item->id }})" class="badge bg-gradient-danger cursor-pointer"><i class="fa fa-trash"></i> Remove </label></span>
                                                            @else
                                                            <span><label wire:click.prevent="confirmDelete({{ $item->id }})" class="badge bg-gradient-danger cursor-pointer"><i class="fa fa-trash"></i> Remove </label></span>
                                                            @endif
                                                            <div wire:loading wire:target="confirmDelete">
                                                                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                                    <div class="la-ball-beat">
                                                                        <div></div>
                                                                        <div></div>
                                                                        <div></div>
                                                                    </div>
                                                                </div>
                                                            </div>
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
                                                                    <label class="mb-0">{{$item->quantity}}</label>
                                                                    <span class="px-2 cursor-pointer" wire:click="cartSetUpQty({{ $item->id }})">
                                                                        <i class="fa-solid fa-square-plus fa-xl"></i>
                                                                    </span>
                                                                @else
                                                                    {{$item->quantity}}
                                                                @endif    
                                                            @else
                                                                {{$item->quantity}}
                                                            @endif
                                                            <div wire:loading wire:target="cartSetDownQty,cartSetUpQty">
                                                                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                                    <div class="la-ball-beat">
                                                                        <div></div>
                                                                        <div></div>
                                                                        <div></div>
                                                                    </div>
                                                                </div>
                                                            </div>
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
                                                    
                                                    if($item->is_package==1){
                                                        $package_job=true;

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

                                                if($package_job)
                                                {
                                                    $tax = 0;
                                                }
                                                $grand_total = $totalAfterDisc+$tax;
                                                ?>
                                            </ul>
                                            
                                            @if($confirmingRA)
                                            <p>
                                                <span><label wire:click.prevent="clearAllCart" class="badge bg-gradient-success cursor-pointer"><i class="fa fa-trash"></i> Yes</label></span>
                                                <span><label wire:click.prevent="safeRA" class="badge bg-gradient-info cursor-pointer"><i class="fa fa-trash"></i> No</label></span>
                                                
                                                <div wire:loading wire:target="clearAllCart">
                                                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                        <div class="la-ball-beat">
                                                            <div></div>
                                                            <div></div>
                                                            <div></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div wire:loading wire:target="safeRA">
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
                                            @if($item->job_number==null)
                                            <span><label wire:click.prevent="confirmDeleteRA" class="badge bg-gradient-danger cursor-pointer"><i class="fa fa-trash"></i> Remove All</label></span>
                                            @endif
                                            <div wire:loading wire:target="confirmDeleteRA">
                                                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                        <div class="la-ball-beat">
                                                            <div></div>
                                                            <div></div>
                                                            <div></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <button class="d-none btn bg-gradient-danger btn-sm float-end" wire:click.prevent="clearAllCart">Remove All Cart</button>
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
                                        @if($manualDiscountAvailable)
                                            @if($pendingSendManulDiscountRequest)
                                            <button type="button" class="btn bg-gradient-warning btn-sm float-end" wire:click="sendManualDiscountApproval({{$manualDiscountRefNo}})">Send for Manual Discount Approval</button>
                                            @elseif($waitingSendManulDiscountRequest)
                                            <button type="button" class="btn bg-gradient-warning btn-sm float-end" >Waiting Manual Discount Approval</button>
                                            @elseif($aprovedSendManulDiscountRequest)
                                            <button type="button" class="btn bg-gradient-success btn-sm float-end" wire:click="submitService()">Confirm & Continue</button>
                                            @endif
                                        @else
                                        <button type="button" class="btn bg-gradient-success btn-sm float-end" wire:click="submitService()">Confirm & Continue</button>
                                        @endif
                                    <div wire:loading wire:target="sendManualDiscountApproval">
                                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                            <div class="la-ball-beat">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
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
                                    <div wire:loading wire:target="removeManualLineDiscount">
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
        @endif

        @if($showServiceGroup)
            <div class="row" id="servceGroups">
                @if(!$servicesGroupList->isEmpty())
                    @foreach($servicesGroupList as $servicesGroup)
                        <div class="col-sm-3 col-md-3 col-lg-2 col-xl-2 my-2">
                            <div class="card h-100" >
                                <a wire:click="serviceGroupForm({{$servicesGroup}})" href="javascript:;">
                                    <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('{{asset("img/".str_replace(" ","-",$servicesGroup->department_name).".jpg")}}');">
                                        @if($service_group_id == $servicesGroup->id)
                                        <span class="mask bg-gradient-dark opacity-4"></span>
                                        @else
                                        <span class="mask bg-gradient-dark opacity-7"></span>
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
                    <!--Items-->
                    <div class="col-sm-3 col-md-3 col-lg-2 col-xl-2 my-2">
                        <div class="card h-100" >
                            <a wire:click="openServiceItems()" href="javascript:;">
                                <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('{{asset("img/PP00039item.jpg")}}');">
                                    @if($showServiceItems)
                                    <span class="mask bg-gradient-dark opacity-4"></span>
                                    @else
                                    <span class="mask bg-gradient-dark opacity-7"></span>
                                    @endif
                                    <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
                                        <h5 class="@if($showServiceItems) text-primary @else text-white @endif font-weight-bolder mb-4 pt-2">Items</h5>
                                        <!-- <p class="text-white">Wealth creation is an evolutionarily recent positive-sum game. It is all about who take the opportunity first.</p> -->
                                        <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:;">
                                            <button wire:click="openServiceItems()" class="btn @if($showServiceItems) bg-gradient-primary @else btn-outline-light @endif" type="button" >Select</button>
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!--Packages-->
                    <div class="col-sm-3 col-md-3 col-lg-2 col-xl-2 my-2">
                        <div class="card h-100" >
                            <a wire:click="openPackages()" href="javascript:;">
                                <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('{{asset("img/service-item-products.jpg")}}');">
                                    @if($selectPackageMenu)
                                    <span class="mask bg-gradient-dark opacity-4"></span>
                                    @else
                                    <span class="mask bg-gradient-dark opacity-7"></span>
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

                    <!--Bundles-->
                    <div class="col-sm-3 col-md-3 col-lg-2 col-xl-2 my-2">
                        <div class="card h-100" >
                            <a wire:click="openBundles()" href="javascript:;">
                                <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('{{asset("img/bundle-package.jpg")}}');">
                                    @if($selectBundleMenu)
                                    <span class="mask bg-gradient-dark opacity-4"></span>
                                    @else
                                    <span class="mask bg-gradient-dark opacity-7"></span>
                                    @endif
                                    <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
                                        <h5 class="@if($selectBundleMenu) text-primary @else text-white @endif font-weight-bolder mb-4 pt-2">Bundles</h5>
                                        <!-- <p class="text-white">Wealth creation is an evolutionarily recent positive-sum game. It is all about who take the opportunity first.</p> -->
                                        <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:;">
                                            <button wire:click="openBundles()" class="btn @if($selectBundleMenu) bg-gradient-primary @else btn-outline-light @endif" type="button" >Select</button>
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!--Advance Coupons-->
                    <div class="col-sm-3 col-md-3 col-lg-2 col-xl-2 my-2">
                        <div class="card h-100" >
                            <a wire:click="openAdvanceCoupons()" href="javascript:;">
                                <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('{{asset("img/advance-coupon-service.jpg")}}');">
                                    @if($selectAdvanceCouponMenu)
                                    <span class="mask bg-gradient-dark opacity-4"></span>
                                    @else
                                    <span class="mask bg-gradient-dark opacity-7"></span>
                                    @endif
                                    <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
                                        <h5 class="@if($selectAdvanceCouponMenu) text-primary @else text-white @endif font-weight-bolder mb-4 pt-2">Advance Coupons</h5>
                                        <!-- <p class="text-white">Wealth creation is an evolutionarily recent positive-sum game. It is all about who take the opportunity first.</p> -->
                                        <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:;">
                                            <button wire:click="openAdvanceCoupons()" class="btn @if($selectAdvanceCouponMenu) bg-gradient-primary @else btn-outline-light @endif" type="button" >Select</button>
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                @endif
            </div>
            <div wire:loading wire:target="serviceGroupForm">
                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                    <div class="la-ball-beat">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <div wire:loading wire:target="openServiceItems">
                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                    <div class="la-ball-beat">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <div wire:loading wire:target="openPackages">
                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                    <div class="la-ball-beat">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <div wire:loading wire:target="openBundles">
                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                    <div class="la-ball-beat">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <div wire:loading wire:target="openAdvanceCoupons">
                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                    <div class="la-ball-beat">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            
            @if($showQlItemSearch)
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <label for="qlSeachByBrand">Engine Oil Brand</label>
                        <div class="form-group">
                            <select class="form-control" id="qlSeachByBrand" wire:model="ql_search_brand" style="padding-left:5px !important;">
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
                            <label for="qlSeachByCategory">Category</label>
                            <select class="form-control" id="qlSeachByCategory" wire:model="ql_search_category" wire:change="qlCategorySelect" style="padding-left:5px !important;">
                                <option value="">-Select-</option>
                                @foreach($itemQlCategories as $itemQlCategory)
                                <option value="{{$itemQlCategory->CategoryId}}">{{$itemQlCategory->Description}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                    </div>

                </div>
                <div wire:loading wire:target="qlCategorySelect">
                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                        <div class="la-ball-beat">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>
                <div wire:loading wire:target="qlItemkmRange">
                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                        <div class="la-ball-beat">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>
                <div class="row d-none">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="seachByItemBrand">Items Name</label>
                            <input type="text" wire:model.defer="quickLubeItemSearch" name="" class="form-control">
                        </div>
                        @error('quickLubeItemSearch') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="seachByItemCode">Items Code</label>
                            <input type="text" wire:model.defer="quickLubeItemCode" name="" id="seachByItemCode" class="form-control">
                        </div>
                        @error('quickLubeItemCode') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label></label>
                        <div class="form-group pt-1">
                            <button class="btn bg-gradient-info" wire:click="searchQuickLubeItem">Search</button>
                            <div wire:loading wire:target="searchQuickLubeItem">
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
                
                <!-- serviceQlItems -->
                @if($showQlItemsList)
                    <div class="row"  id="serviceQlItems">
                        @forelse($quickLubeItemsList as $quickLubeItem)
                            <?php $qlItemPriceDetails = $quickLubeItem['priceDetails']; ?>
                            <?php $qlItemDiscountDetails = $quickLubeItem['discountDetails']; ?>
                            @if($qlItemPriceDetails->UnitPrice!=0)
                            <div class="col-md-4 col-sm-6">
                                <div class="card mt-2">
                                    <div class="card-header text-center p-2">
                                        <p class="font-weight-normal mt-2 text-capitalize text-sm- font-weight-bold mb-0">
                                            {{strtolower($qlItemPriceDetails->ItemName)}}<small>({{$qlItemPriceDetails->ItemCode}})</small>
                                        </p>
                                        <h5 class="font-weight-bold mt-2"  @if($qlItemDiscountDetails != null) style="text-decoration: line-through;" @endif>
                                            <small>AED</small>{{custom_round($qlItemPriceDetails->UnitPrice)}}
                                        </h5>
                                        @if($qlItemDiscountDetails != null)
                                        <h5 class="font-weight-bold mt-2">
                                            <span class="text-secondary text-sm me-1">{{config('global.CURRENCY')}}</span>{{ custom_round($qlItemPriceDetails->UnitPrice-(($qlItemDiscountDetails->DiscountPerc/100)*$qlItemPriceDetails->UnitPrice)) }}
                                        </h5>
                                        @endif
                                        <div class="ms-auto">
                                            @if(!empty($qlItemDiscountDetails))
                                                <span class="badge bg-gradient-info">{{custom_round($qlItemDiscountDetails->DiscountPerc)}}%off</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-body text-lg-left text-left p-2">
                                        <div class="row"> 
                                            @if($qlItemPriceDetails->ItemCode!='I09137')
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Qty:</label><input type="number" class="form-control w-50 float-start" placeholder="Qty" wire:model="ql_item_qty.{{$qlItemPriceDetails->ItemId}}" style="padding-left:5px !important;" />
                                                </div>
                                            </div>
                                            @endif
                                            <div class="col-6">
                                                <a href="javascript:;" class="btn btn-icon bg-gradient-primary d-lg-block m-0 float-end p-2" wire:click="addtoCartItem('{{$qlItemPriceDetails->ItemCode}}','{{$qlItemDiscountDetails}}')">Buy Now<i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @if(@$serviceAddedMessgae[$qlItemPriceDetails->ItemCode])
                                    <div class="text-center">
                                        <span class="alert-icon"><i class="ni ni-like-2 text-success"></i></span>
                                        <span class="alert-text text-success"><strong>Success!</strong> Added serves!</span>
                                        <button type="button" class="btn-close text-success" data-bs-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endif
                                    @if(@$serviceStockErrShow[$qlItemPriceDetails->ItemCode])
                                    <div class="text-center">
                                        <span class="alert-text text-danger"><strong>!</strong> Available Stock: {{$serviceStockErrMessgae[$qlItemPriceDetails->ItemCode]}}</span>
                                        <button type="button" class="btn-close text-danger" data-bs-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        @empty
                            <div class="alert alert-danger text-white" role="alert">
                                <strong>Empty!</strong> The Searched items are not in stock!</div>
                        @endforelse 
                    </div>
                @endif
            @endif
            @if($showSectionsList)
                <div class="row mt-2 mb-2" id="servceSectionsList">
                    @foreach($sectionsLists as $sectionsList)
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3 my-2 cursor-pointer" >
                            <div class="card bg-gradient-primary">
                                <div class="card-body p-2">
                                    <div class="row">
                                        <div class="col-md-8 col-sm-8">
                                            <div class="numbers">
                                            <p class="text-white text-sm mb-0 opacity-7">{{$service_group_name}}</p>
                                            <h6 class="text-white font-weight-bolder mb-0 text-capitalize">
                                            {{strtolower(str_replace("-"," ",$sectionsList->PropertyName))}}
                                            </h6>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 text-end">
                                            <div wire:click="getSectionServices('{{$sectionsList}}')" class="icon icon-shape bg-white shadow text-center border-radius-md">Open
                                                <i class="cursor-pointer fa-solid fa-angles-down text-dark text-lg opacity-10" style="top:0;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div wire:loading wire:target="getSectionServices">
                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                            <div class="la-ball-beat">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
        @endif
        
        @if($showServiceSectionsList)
            @include('components.modals.serviceSectionListModal')
        @endif

        @if($showLineDiscountItems)
            <!-- Modal -->
            <style type="text/css">
                .modal-body{
                    max-height: calc(100vh - 300px);
                    overflow-y: auto;
                }
            </style>
            <div class="modal fade" id="showPriceDiscountListModal" tabindex="-1" role="dialog" aria-labelledby="showPriceDiscountListModalLabel" aria-hidden="true" wire:ignore.self style="z-index:99999;" >
                <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:90%;">
                    <div class="modal-content">
                        
                        <div class="modal-header" id="topScrolledPlace">
                            <h5 class="modal-title" id="showPriceDiscountListModalLabel">{{$lineItemDetails['item_code']}} - {{$lineItemDetails['item_name']}}</h5>
                        </div>
                        <div class="modal-body py-0" id="scrollToDiscountTop" >
                            @if(count($selectedVehicleInfo->customerDiscountLists)>0)
                                <div class="row">
                                    <h6><u>Saved Customer Discounts</u></h6>
                                    @forelse($selectedVehicleInfo->customerDiscountLists as $customerDiscountLists)
                                        <?php $end = \Carbon\Carbon::parse($customerDiscountLists->discount_card_validity);?>
                                        @if($customerDiscountLists->discount_id==8 || $customerDiscountLists->discount_id==9)
                                        <div class="col-lg-2 col-sm-3 my-2">
                                            <div wire:click="savedCustomerLineDiscountGroup({{json_encode($lineItemDetails)}},{{$customerDiscountLists}})" class="card cursor-pointer bg-gradient-info">
                                                <div class="card-body  py-2">
                                                    <h6 class="font-weight-bold text-capitalize text-center text-sm text-light mb-0">{{strtolower(str_replace('_', ' ', $customerDiscountLists->discount_code))}}</h6>
                                                </div>
                                            </div>
                                        </div>
                                        @elseif(\Carbon\Carbon::now()->diffInDays($end, false)>=0)
                                        <div class="col-lg-2 col-sm-3 my-2">
                                            <div wire:click="savedCustomerLineDiscountGroup({{json_encode($lineItemDetails)}},{{$customerDiscountLists}})" class="card cursor-pointer bg-gradient-info">
                                                <div class="card-body  py-2">
                                                    <h6 class="font-weight-bold text-capitalize text-center text-sm text-light mb-0">{{strtolower(str_replace('_', ' ', $customerDiscountLists->discount_title))}}</h6>
                                                </div>
                                            </div>
                                            <small>Expired in: {{ $diff = Carbon\Carbon::parse($customerDiscountLists->discount_card_validity)->diffForHumans(Carbon\Carbon::now()) }}</small>
                                        </div>
                                        @endif
                                    @empty
                                    @endforelse
                                    <p class="badge bg-gradient-danger text-light text-bold text-lg mb-0">{{$discountAvailability}}</p>
                                    <div wire:loading wire:target="savedCustomerLineDiscountGroup">
                                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                            <div class="la-ball-beat">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            @endif
                            @if($showSelectedDiscount)
                            @include('components.customerDiscount')
                            @endif
                            
                            @if(empty($selectedDiscount))
                            <div class="row">
                                <?php $discountempty = false; ?>
                                @forelse($priceDiscountList as $priceDiscount)
                                    @if($priceDiscount->customerDiscountGroup['GroupType'] == 1 && $priceDiscount->EndDate == null)
                                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mt-4 mb-2">
                                            <div class="card card-profile mt-md-0 mt-5">
                                                <div class="card-body blur justify-content-center text-center mx-4 mb-4 border-radius-md p-2">
                                                    <h4 class="mb-0 text-capitalize">{{ strtolower(str_replace('_', ' ', $priceDiscount->customerDiscountGroup['Title'])) }}</h4>
                                                    <span class="badge bg-gradient-info">{{custom_round($priceDiscount->DiscountPerc)}}%off</span>
                                                    <div class="row justify-content-center text-center">
                                                        <div class="col-12 mx-auto">
                                                            <h4 class="mt-2 text-sm text-default mb-0" style="text-decoration: line-through;">{{config('global.CURRENCY')}} {{custom_round($lineItemDetails['unit_price'])}}</h4>
                                                            <h5 class="text-info mb-0"> {{config('global.CURRENCY')}} {{ custom_round($lineItemDetails['unit_price']-(($priceDiscount->DiscountPerc/100)*$lineItemDetails['unit_price'])) }}</h5>
                                                            
                                                            <a href="javascript:;" class="btn bg-gradient-primary mb-0 ms-auto btn-sm"  wire:click="applyLineDiscountSubmit('{{$lineItemDetails['id']}}',{{$priceDiscount}},{{$priceDiscount->customerDiscountGroup}})">Add Now</a>
                                                            
                                                                
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $discountempty = false; ?>
                                    @elseif($priceDiscount->customerDiscountGroup['GroupType']==2)
                                        <?php
                                        $endCampVali = \Carbon\Carbon::parse($priceDiscount->EndDate);
                                        if(\Carbon\Carbon::now()->diffInDays($endCampVali, false)>=0)
                                        {
                                        /*$givenDate = \Carbon\Carbon::parse($priceDiscount->EndDate); // Replace with your date
                                        $now = \Carbon\Carbon::now();
                                        if ($givenDate->isPast()) {
                                            //
                                        }
                                        else
                                        {*/
                                            ?>
                                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mt-4 mb-2">
                                                <div class="card card-profile mt-md-0 mt-5">
                                                    <div class="card-body blur justify-content-center text-center mx-4 mb-4 border-radius-md p-2">
                                                        <h4 class="mb-0 text-capitalize">{{ strtolower(str_replace('_', ' ', $priceDiscount->customerDiscountGroup['Title'])) }}</h4>
                                                        <span class="badge bg-gradient-info">{{custom_round($priceDiscount->DiscountPerc)}}%off</span>
                                                        <div class="row justify-content-center text-center">
                                                            <div class="col-12 mx-auto">
                                                                <h4 class="mt-2 text-sm text-default mb-0" style="text-decoration: line-through;">{{config('global.CURRENCY')}} {{custom_round($lineItemDetails['unit_price'])}}</h4>
                                                                <h5 class="text-info mb-0"> {{config('global.CURRENCY')}} {{ custom_round($lineItemDetails['unit_price']-(($priceDiscount->DiscountPerc/100)*$lineItemDetails['unit_price'])) }}</h5>
                                                                
                                                                <a href="javascript:;" class="btn bg-gradient-primary mb-0 ms-auto btn-sm"  wire:click="applyLineDiscountSubmit('{{$lineItemDetails['id']}}',{{$priceDiscount}},{{$priceDiscount->customerDiscountGroup}})">Add Now</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $discountempty = false; ?>
                                            <?php
                                        }
                                        
                                        ?>
                                        
                                    @else
                                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mt-4 mb-2">
                                            <div class="card card-profile mt-md-0 mt-5">
                                                <div class="card-body blur justify-content-center text-center mx-4 mb-4 border-radius-md p-2">
                                                    <h4 class="mb-0 text-capitalize">{{ strtolower(str_replace('_', ' ', $priceDiscount->customerDiscountGroup['Title'])) }}</h4>
                                                    <span class="badge bg-gradient-info">{{custom_round($priceDiscount->DiscountPerc)}}%off</span>
                                                    <div class="row justify-content-center text-center">
                                                        <div class="col-12 mx-auto">
                                                            <h4 class="mt-2 text-sm text-default mb-0" style="text-decoration: line-through;">{{config('global.CURRENCY')}} {{custom_round($lineItemDetails['unit_price'])}}</h4>
                                                            <h5 class="text-info mb-0"> {{config('global.CURRENCY')}} {{ custom_round($lineItemDetails['unit_price']-(($priceDiscount->DiscountPerc/100)*$lineItemDetails['unit_price'])) }}</h5>
                                                            
                                                            <a href="javascript:;" class="btn bg-gradient-primary mb-0 ms-auto btn-sm"  wire:click="applyLineDiscountSubmit('{{$lineItemDetails['id']}}',{{$priceDiscount}},{{$priceDiscount->customerDiscountGroup}})">Add Now</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $discountempty = false; ?>
                                    @endif
                                        
                                @empty
                                    <?php $discountempty = true; ?>
                                @endforelse
                                @if($lineItemDetails['cart_item_type']==1)
                                    @if(in_array($lineItemDetails['item_code'],config('global.engine_oil_discount_voucher')['services']))
                                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mt-4 mb-2">
                                            <div class="card card-profile mt-md-0 mt-5">
                                                <div class="card-body blur justify-content-center text-center mx-4 mb-4 border-radius-md p-2">
                                                    <h4 class="mb-0">ENGINE_OIL</h4>
                                                    <span class="badge bg-gradient-info">10%, 15%, 20%, 25% off</span>
                                                    <div class="row justify-content-center text-center">
                                                        <div class="col-12 mx-auto">
                                                            <a href="javascript:;" class="btn bg-gradient-primary mb-0 ms-auto btn-sm"  wire:click="applyEngineOilLineDiscountSubmit('{{$lineItemDetails['id']}}','{{$lineItemDetails['item_code']}}')">Add Now</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $discountempty = false; ?>
                                    @else
                                        <?php $discountempty = true; ?>
                                    @endif
                                @else
                                    @if(in_array($lineItemDetails['item_code'],config('global.engine_oil_discount_voucher')['items']))
                                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mt-4 mb-2">
                                            <div class="card card-profile mt-md-0 mt-5">
                                                <div class="card-body blur justify-content-center text-center mx-4 mb-4 border-radius-md p-2">
                                                    <h4 class="mb-0">ENGINE_OIL</h4>
                                                    <span class="badge bg-gradient-info">10%, 15%, 20%, 25% off</span>
                                                    <div class="row justify-content-center text-center">
                                                        <div class="col-12 mx-auto">
                                                            <a href="javascript:;" class="btn bg-gradient-primary mb-0 ms-auto btn-sm"  wire:click="applyEngineOilLineDiscountSubmit('{{$lineItemDetails['id']}}','{{$lineItemDetails['item_code']}}')">Add Now</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $discountempty = false; ?>
                                    @else
                                        <?php $discountempty = true; ?>
                                    @endif
                                @endif
                                    @if($applyManualDiscount)
                                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mt-4 mb-2">
                                            <div class="card card-profile mt-md-0 mt-5">
                                                <div class="card-body blur justify-content-center text-center mx-4 mb-4 border-radius-md p-2">
                                                    <h4 class="mb-0">Manual Discount</h4>
                                                    <span class="badge bg-gradient-info mb-2">Customized Manual Discount</span>
                                                    <div class="row justify-content-center text-center">
                                                        <div class="col-12 mx-auto">
                                                            <a href="javascript:;" class="btn bg-gradient-primary mb-0 ms-auto btn-sm"  wire:click="applyManualLineDiscountSubmit('{{$lineItemDetails['id']}}','{{$lineItemDetails['item_code']}}')">Apply Now</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $discountempty = false; ?>
                                    @endif
                                @if($discountempty)
                                <span class="text-danger text-center">Empty discount for this item..!</span>
                                @endif
                                <div wire:loading wire:target="applyManualLineDiscountSubmit">
                                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                        <div class="la-ball-beat">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                </div>
                                <div wire:loading wire:target="addtoCart">
                                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                        <div class="la-ball-beat">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                </div>
                                <div wire:loading wire:target="addtoCartCP">
                                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                        <div class="la-ball-beat">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                </div>
                                <div wire:loading wire:target="applyLineDiscountSubmit">
                                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                        <div class="la-ball-beat">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                </div>
                                <div wire:loading wire:target="applyLineDiscountSubmit">
                                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                        <div class="la-ball-beat">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" class="btn bg-gradient-primary">Save changes</button> -->
                        </div>
                    </div>
                </div>
            </div>
        @endif

        

        @if($showPackageList)
            <div class="row mt-4">
                <div class="container">
                    <div class="tab-content tab-space">
                        <div class="tab-pane active" id="monthly" role="tabpanel" aria-labelledby="tabs-iconpricing-tab-1">
                            @if ($message = Session::get('package_success'))
                            <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
                                <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                                <span class="alert-text"><strong>Success!</strong> {{ $message }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            @endif
                            @if ($message = Session::get('package_error'))
                            <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                                <span class="alert-text"><strong>Error!</strong> {{ $message }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            @endif
                            <div class="row mb-4" id="packageServiceListDiv">
                                <div class="col-md-12">
                                    <div class="card h-100">
                                        <div class="card-header text-left p-2 pb-0">
                                            <h5>Customer Purchased Packags</h5>
                                            <hr>
                                        </div>
                                        <div class="card-body text-lg-start text-left pt-0 p-2">
                                            <div class="row">
                                                @forelse($customerBookedPackages as $packBookd)
                                                    <?php
                                                    $packageBookedDateTime = new Carbon\Carbon($packBookd->package_date_time);
                                                    $endPackageDateTime = $packageBookedDateTime->addMonth($packBookd->package_duration);
                                                    ?>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="card bg-cover text-center my-2" >
                                                            <!-- style="background-image: url('https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/curved-images/curved1.jpg')" -->
                                                            <div class="card-body z-index-2 py-2 text-center">
                                                                <?php
                                                                    switch($packBookd->packageSubTypes['Description']){
                                                                        case 'SILVER':
                                                                            $buttontext = 'silver_button text-dark';
                                                                            break;
                                                                        case 'GOLD':
                                                                            $buttontext = 'gold_button text-white';
                                                                            break;
                                                                        case 'PLATINUM':
                                                                            $buttontext = 'platinum_button text-white';
                                                                            break;
                                                                        default:
                                                                            $buttontext = 'platinum_button text-white';
                                                                            break;
                                                                    }
                                                                ?>
                                                                <span class="badge rounded-pill bg-light {{$buttontext}}">{{$packBookd->packageSubTypes['Description']}}</span>
                                                                <h4 class="text-white">{{$packBookd->package_name}}</h4>

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <h6 class="mb-0 align-items-left text-light text-bold">Service/Item</h6>
                                                                    </div>
                                                                    <div class="col-md-6 d-flex justify-content-end align-items-right">
                                                                        <p class="mb-0 text-light text-bold">Balance</p>
                                                                    </div>
                                                                </div>

                                                                <ul class="list-group">
                                                                    @foreach($packBookd->customerPackageServices as $customerPackageServices)
                                                                    <li class="list-group-item border-0 d-flex justify-content-between ps-2 mb-2 border-radius-lg">
                                                                        <div class="d-flex align-items-left">
                                                                            <button class="btn btn-icon-only btn-rounded @if($customerPackageServices->package_service_use_count==$customerPackageServices->quantity) btn-outline-danger @else btn-outline-success @endif mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-right" aria-hidden="true"></i></button>
                                                                            <div class="d-flex flex-column">
                                                                                <h6 class="mb-1 text-dark text-left text-sm">{{$customerPackageServices->item_name}}</h6>
                                                                                <span class="text-xs">Qty: {{$customerPackageServices->quantity}}</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-flex align-items-center @if($customerPackageServices->package_service_use_count==$customerPackageServices->quantity) text-danger @else text-success @endif text-gradient text-sm font-weight-bold">
                                                                            {{$customerPackageServices->quantity-$customerPackageServices->package_service_use_count}}
                                                                        </div>
                                                                    </li>
                                                                    @endforeach
                                                                </ul>
                                                                
                                                                @if(\Carbon\Carbon::now()->diffInDays($endPackageDateTime, false)>=0 || $customerPackageServices->package_service_use_count<=$customerPackageServices->quantity)
                                                                    <button  wire:click="redeemPackageDetails({{$packBookd}})" class="btn bg-gradient-primary mb-2 btn-sm">Redeem</button>
                                                                @else
                                                                <button class="btn bg-gradient-dark mb-2 btn-sm opacity-7">Expired</button>
                                                                @endif
                                                            </div>
                                                            @if(\Carbon\Carbon::now()->diffInDays($endPackageDateTime, false)>=0)
                                                            <div class="mask bg-gradient-info border-radius-lg"></div>
                                                            @else
                                                            <div class="mask bg-gradient-danger border-radius-lg"></div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                    
                                                @empty
                                                    <span class="text-danger">empty..!</span>
                                                @endforelse
                                                <div class="col-md-6">
                                                    <div class="form-group p-2 text-center">
                                                        <label>Redeem Package with Package Number</label>
                                                        <input class="form-control" type="text" wire:model="package_number" id="redeemPackageNumber" placeholder="Redeem Package Number..!">
                                                        @error('package_number') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                                        <button  wire:click="validatePackageContinue()" class="btn bg-gradient-primary m-2 btn-sm">Redeem</button>
                                                    </div>
                                                    <div wire:loading wire:target="validatePackageContinue" >
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
                            <div class="row" >
                                @include('components.modals.pckageRedeem')
                                
                                @foreach($servicePackages as $servicePackage)
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-lg-4 mb-4">
                                        <div class="card h-100" >
                                            <div class="card-header text-center pt-4 pb-3">
                                                <?php
                                                switch($servicePackage->packageSubTypes['Description']){
                                                    case 'SILVER':
                                                        $buttontext = 'silver_button text-dark';
                                                        break;
                                                    case 'GOLD':
                                                        $buttontext = 'gold_button text-white';
                                                        break;
                                                    case 'PLATINUM':
                                                        $buttontext = 'platinum_button text-white';
                                                        break;
                                                    default:
                                                        $buttontext = 'platinum_button text-white';
                                                        break;
                                                }
                                                ?>
                                                <span class="badge rounded-pill bg-light {{$buttontext}}">{{$servicePackage->packageSubTypes['Description']}}</span>
                                                <h4>{{$servicePackage->PackageName}}</h4>
                                                @if($servicePackage->Duration)
                                                <p class="text-sm font-weight-bold text-dark mt-2 mb-0">Duration: {{$servicePackage->Duration}} Months</p>
                                                @endif
                                                @if($servicePackage->PackageKM)
                                                <p class="text-sm font-weight-bold text-dark">{{$servicePackage->PackageKM}} K.M</p>
                                                @endif
                                                
                                            </div>
                                            <div class="card-body text-lg-start text-left pt-0">
                                                <?php $totalPrice=0;?>
                                                <?php $unitPrice=0;?>
                                                <?php $discountedPrice=0;?>
                                                @foreach($servicePackage->packageDetails as $packageDetails)
                                                    @if($packageDetails->isDefault==1)
                                                    <div class="d-flex justify-content-lg-start p-2">
                                                        
                                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                                            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                                                        </div>
                                                        <?php $totalPrice = $totalPrice+($packageDetails->TotalPrice*$packageDetails->Quantity); ?>
                                                        <?php $unitPrice = $unitPrice+($packageDetails->UnitPrice*$packageDetails->Quantity); ?>
                                                        <?php $discountedPrice = $discountedPrice+($packageDetails->DiscountedPrice*$packageDetails->Quantity); ?>
                                                        
                                                        <div>
                                                            @if($packageDetails->ItemType=='S')
                                                            <span class="ps-3">{{$packageDetails->Quantity}} x {{$packageDetails->labourItemDetails['ItemName']}}</span>
                                                            @else
                                                            <span class="ps-3">{{$packageDetails->inventoryItemDetails['ItemName']}}</span>
                                                            @endif
                                                            <p class="ps-3 h6"><small><s>AED {{$packageDetails->UnitPrice}}</s> {{$packageDetails->DiscountedPrice}}</small></p>
                                                        </div>
                                                    </div>
                                                    @endif  
                                                @endforeach
                                                <h3 class="text-default font-weight-bold mt-2"></h3>
                                                <p class="text-center h4"><s><small>AED</small> {{$unitPrice}}</s> <small>AED</small> {{$discountedPrice}}</p>
                                                <div class="text-center align-center">
                                                    <a href="javascript:;" class="btn btn-icon bg-gradient-dark d-lg-block mt-3 mb-0 " wire:click="packageContinue({{$servicePackage->Id}})"   wire:navigate>Continue<i class="fas fa-arrow-right ms-1" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                
                                <div wire:loading wire:target="packageContinue" >
                                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                        <div class="la-ball-beat">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                </div>
                                @if($showPackageAddons)
                                @include('components.modals.pckageAddOns')
                                @endif
                        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($showBundleList)
            <div class="row mt-4">
                <div class="container">
                    <div class="tab-content tab-space">
                        <div class="tab-pane active" id="monthly" role="tabpanel" aria-labelledby="tabs-iconpricing-tab-1">
                            <div class="row mb-4" id="bundleServiceListDiv">
                                @foreach($bundlleLists as $bundlle)
                                    @if(count($bundlle->bundlesDetails)>0)
                                    <div class="col-md-4 col-sm-4 mb-4">
                                        <div class="card card-profile card-plain cursor-pointer" wire:click="openBundleListDetails('{{$bundlle}}')">
                                            <div class="card-body text-center bg-white shadow border-radius-lg p-3">
                                                <a href="javascript:;" class="d-none">
                                                    <img class="w-100 border-radius-md" src="./assets/img/kit/pro/anastasia.jpg">
                                                </a>
                                                <h5 class="mt-3 mb-3 text-danger text-gradient text-uppercase">{{$bundlle->Description}}</h5>
                                                
                                                <button type="button" class="btn btn-warning btn-sm"   wire:click="openBundleListDetails('{{$bundlle}}')">Open</button>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                                
                                <div wire:loading wire:target="openBundleListDetails" >
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
        @endif

        @if($showAdvanceCouponList)
            <div class="row mt-4">
                <div class="container">
                    <div class="tab-content tab-space">
                        <div class="tab-pane active" id="advance_coupon_monthly" role="tabpanel" aria-labelledby="tabs-iconpricing-tab-1">
                            @if ($message = Session::get('advance_coupon_success'))
                            <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
                                <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                                <span class="alert-text"><strong>Success!</strong> {{ $message }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            @endif
                            @if ($message = Session::get('advance_coupon_error'))
                            <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                                <span class="alert-text"><strong>Error!</strong> {{ $message }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            @endif
                            <div class="row" id="packageServiceListDiv">
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-lg-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-header text-left p-2 pb-0">
                                            <h5>Redeem Advance Coupon</h5>
                                        </div>
                                        <div class="card-body text-lg-start text-left pt-0 p-2">
                                            
                                            @if($showAdvanceCouponOtpVerify)
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 mb-0" >
                                                    <div class="card p-2 mb-4">
                                                        
                                                        <div class="card-body text-lg-left text-center pt-0">
                                                            <label for="packageOTPVerify">Package OTP Verify</label>
                                                            <div class="form-group">
                                                                <input type="numer" class="form-control" placeholder="Package OTP Verify..!" aria-label="Package OTP Verify..!" aria-describedby="button-addon4" id="packageOTPVerify" wire:model="package_otp">
                                                                <button class="btn btn-outline-success mb-0" type="button" wire:click="verifyPackageOtp">Verify</button>
                                                                <button class="btn btn-outline-info mb-0" type="button"  wire:click="resendPackageOtp">Resend</button>
                                                                <div wire:loading wire:target="verifyPackageOtp" >
                                                                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                                        <div class="la-ball-beat">
                                                                            <div></div>
                                                                            <div></div>
                                                                            <div></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div wire:loading wire:target="resendOtp" >
                                                                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                                        <div class="la-ball-beat">
                                                                            <div></div>
                                                                            <div></div>
                                                                            <div></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @error('package_otp') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                                            @if($package_otp_message)<span class="mb-4 text-danger">{{ $package_otp_message }}</span>@endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            
                                            <div class="form-group p-2 text-center">
                                                <input class="form-control" type="text" wire:model="advance_coupon_number" id="redeemAdvanceCouponNumber" placeholder="Redeem Advance Coupon..!">

                                                @error('package_number') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                                <button  wire:click="validateAdvanceCouponContinue()" class="btn bg-gradient-primary m-2 btn-sm">Redeem</button>
                                            </div>
                                            <div wire:loading wire:target="validateAdvanceCouponContinue" >
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
                </div>
            </div>
        @endif

        @if($showPackageServiceSectionsList)
            <!-- Modal -->
            <style type="text/css">
                .modal-body{
                    max-height: calc(100vh - 300px);
                    overflow-y: auto;
                }
            </style>
            <div class="modal fade" id="servicePackagePriceModal" tabindex="-1" role="dialog" aria-labelledby="servicePackagePriceModalLabel" aria-hidden="true" wire:ignore.self style="z-index:99999;" >
                <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:90%;">
                    <div class="modal-content">
                        
                        <div class="modal-header">
                            <h5 class="modal-title" id="servicePackagePriceModalLabel">{{$selectedSectionName}}</h5>
                            <input type="text" class="form-control w-30" name="" wire:model="section_service_search">
                            <div wire:loading wire:target="section_service_search">
                                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                    <div class="la-ball-beat">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn-close text-dark " style="font-size: 2.125rem !important;" data-bs-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true" class="text-xl">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body py-0">
                            <div class="row">
                                @forelse($sectionPackageServiceLists as $sectionServiceList)
                                <?php $priceDetails = $sectionServiceList['priceDetails']; ?>
                                <?php $package_quantity = $sectionServiceList['package_quantity']; ?>
                                <?php $package_quantity_used = $sectionServiceList['package_quantity_used']; ?>
                                <?php $discountDetails = $sectionServiceList['discountDetails']; ?>
                                @if($priceDetails->UnitPrice!=0)
                                <div class="col-md-6 col-sm-6">
                                    
                                    <div class="bg-gray-100 shadow my-3 p-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <p class="text-sm text-center font-weight-bold text-dark mb-0">{{$priceDetails->ItemCode}} - {{$priceDetails->ItemName}}</p>
                                                <p class="text-sm text-center">Balance: {{$package_quantity - $package_quantity_used}}</p>
                                                <!-- <textarea style="padding-left: 5px !important;" class="form-control" placeholder="Notes..!" wire:model="extra_note.{{$priceDetails->ItemId}}"></textarea > -->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="d-flex border-radius-lg p-0 mt-2">
                                                    <p class="w-100 text-md font-weight-bold text-dark my-auto me-2 float-start">
                                                        <span class="float-start" @if($discountDetails != null) style="text-decoration: line-through;" @endif>
                                                            <span class=" text-sm me-1">{{config('global.CURRENCY')}}</span> {{custom_round($priceDetails->UnitPrice)}}
                                                        </span>
                                                        @if($discountDetails != null)
                                                        <span  class="float-end">
                                                            <span class=" text-sm me-1">{{config('global.CURRENCY')}}</span> {{ custom_round($priceDetails->UnitPrice-(($discountDetails['DiscountPerc']/100)*$priceDetails->UnitPrice)) }}
                                                        </span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="d-flex border-radius-lg p-0 mt-2">
                                                    @if($package_quantity==$package_quantity_used)
                                                        <span class="badge bg-gradient-danger">Package Used</span>
                                                    @else
                                                        @if($discountDetails != null)
                                                        <span class="badge bg-gradient-info">{{custom_round($discountDetails['DiscountPerc'])}}%off</span>
                                                        @endif
                                                        <a href="javascript:;" class="btn bg-gradient-primary mb-0 ms-auto btn-sm"  wire:click="addtoCartPackage('{{$priceDetails}}','{{$discountDetails}}')">Add Now</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @if(@$serviceAddedMessgae[$priceDetails->ItemCode])
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
                                @endif
                                @empty
                                @endforelse
                                
                                <div wire:loading wire:target="addtoCartPackage">
                                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                        <div class="la-ball-beat">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                </div>
                                <div wire:loading wire:target="addtoCart">
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
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" class="btn bg-gradient-primary">Save changes</button> -->
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        @if($showBundleServiceSectionsList)
            @include('components.modals.bundleListing')
        @endif
        
        @if($showDiscountDroup)
            @include('components.modals.discountGroups')
        @endif

        @if($showAddMakeModelNew)
            @include('components.modals.addMakeModelNew')
        @endif
        @if($showPendingJobList)
            @include('components.modals.pendingJobListModal')
        @endif

        @if($showCustomerSignature)
            @include('components.modals.customerSignatureModel')
        @endif
        @if($shoeJobHistoryModal)
            @include('components.modals.jobHistoryModal')
        @endif
        <div wire:loading wire:target="applyLineDiscount">
            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                <div class="la-ball-beat">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        <div wire:loading wire:target="addtoCartItem">
            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                <div class="la-ball-beat">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>

        <div wire:loading wire:target="addMakeModel">
            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                <div class="la-ball-beat">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>

        <div wire:loading wire:target="redeemPackageDetails">
            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                <div class="la-ball-beat">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
    </div>
</main>
@push('custom_script')

<script type="text/javascript">

    


    @if($showPendingJobList)
        $(document).ready(function(){
            $('#pendingJobListModal').modal('show');   
        })
    @endif
    window.addEventListener('openJobHIstoryModal',event=>{
        $('#jobHIstoryModal').modal('show');
    });
    window.addEventListener('closeJobHIstoryModal',event=>{
        $('#jobHIstoryModal').modal('hide');
    });
    
    window.addEventListener('openPendingJobListModal',event=>{
        $('#pendingJobListModal').modal('show');
    });
    window.addEventListener('openServicesListModal',event=>{
        $('#servicePriceModal').modal('show');
    });
    window.addEventListener('closeServicesListModal',event=>{
        $('#servicePriceModal').modal('hide');
    });

    window.addEventListener('openBundleServicesListModal', event=>{
        $('#bundlePriceModelList').modal('show');
    });
    window.addEventListener('closeBundleServicesListModal', event=>{
        $('#bundlePriceModelList').modal('hide');
    });

    window.addEventListener('openServicesPackageListModal',event=>{
        $('#servicePackagePriceModal').modal('show');
    });
    window.addEventListener('closeServicesPackageListModal',event=>{
        $('#servicePackagePriceModal').modal('hide');
    });

    window.addEventListener('selectSearchEvent',event=>{
        $(document).ready(function () {

            $('#plateEmirates').on('change', function (e) {
                var plateStateVal = $('#plateEmirates').val();
                @this.set('plate_state', plateStateVal);
            });
            $('#vehicleTypeInput').on('change', function (e) {
                var vehicleTypeVal = $('#vehicleTypeInput').val();
                @this.set('vehicle_type', vehicleTypeVal);
            });
            $('#vehicleMakeInput').on('change', function (e) {
                var makeVal = $('#vehicleMakeInput').val();
                @this.set('make', makeVal);
            });
            $('#vehicleModelInput').on('change', function (e) {
                var modelVal = $('#vehicleModelInput').val();
                @this.set('model', modelVal);
            });
            $('#plateCode').on('change', function (e) {
                var stateCodeVal = $('#plateCode').val();
                @this.set('plate_code', stateCodeVal);
            });

            $('#seachItemByCategory').on('change', function (e) {
                var catVal = $('#seachItemByCategory').val();
                @this.set('item_search_category', catVal);
            });
            $('#seachItemBySubCategory').on('change', function (e) {
                var subCatVal = $('#seachItemBySubCategory').val();
                @this.set('item_search_subcategory', subCatVal);
            });
            $('#seachByItemBrand').on('change', function (e) {
                var BrandVal = $('#seachByItemBrand').val();
                @this.set('item_search_brand', BrandVal);
            });

            $('#qlSeachByBrand').on('change', function (e) {
                var BrandVal = $('#qlSeachByBrand').val();
                @this.set('ql_search_brand', BrandVal);
            });
        });
    });

    
    window.addEventListener('openDiscountGroupModal',event=>{
        $('#discountGroupModal').modal('show');
    });
    window.addEventListener('closeDiscountGroupModal',event=>{
        $('#discountGroupModal').modal('hide');
    });

    window.addEventListener('openAddMakeModel', event=>{
        $('#addMakeModelModel').modal('show');
    });
    window.addEventListener('closeAddMakeModel', event=>{
        $('#addMakeModelModel').modal('hide');
    });

    window.addEventListener('scrolltopQl',event=>{
        $(document).ready(function(){
            $('html, body').animate({
                scrollTop: $("#serviceQlItems").offset().top - 100
            }, 100);
        });
    });

    window.addEventListener('showPriceDiscountList',event=>{
        $('#showPriceDiscountListModal').modal('show');
    });
    window.addEventListener('closePriceDiscountList',event=>{
        $('#showPriceDiscountListModal').modal('hide');
    });

    window.addEventListener('showpckageRedeemModal',event=>{
        $('#pckageRedeemModal').modal('show');
    });
    window.addEventListener('closepckageRedeemModal',event=>{
        $('#pckageRedeemModal').modal('hide');
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
        @this.set('saveCustomerSignature', true);
        $('#customerSignatureModal').modal('hide');
        // Send data to server instead...
        //window.open(data);
    });
    cancelButton.addEventListener('click', function (event) {
        signaturePad.clear();
    });
});
</script>
<script type="text/javascript">
    window.addEventListener('imageUpload',event=>{
        $('#vehicleImage').click(function(){
            $("#vehicleImageFile").trigger('click');
        });
        $('#plateImage').click(function(){
            $("#plateImageFile").trigger('click');
        });
        $('#chaisisImage').click(function(){
            $("#chaisisImageFile").trigger('click');
        });

        
        
    });
    
</script>

@endpush