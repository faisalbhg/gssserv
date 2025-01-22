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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
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
                                                            
                                                        </div>
                                                        <div class="d-flex align-items-center text-sm">
                                                            {{$item->quantity}} x
                                                            

                                                            
                                                            <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4" @if($item->customer_group_code) style="text-decoration: line-through;" @endif >{{config('global.CURRENCY')}} {{round($item->unit_price,2)}}</button>

                                                            @if($item->customer_group_code)
                                                            <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4">{{config('global.CURRENCY')}} {{ round($item->unit_price-(($item->discount_perc/100)*($item->unit_price)),2) }}</button>
                                                            @endif

                                                        </div>

                                                    </li>
                                                    <hr class="horizontal dark mt-0 mb-2">
                                                    <?php
                                                    $total = $total+$item->unit_price*$item->quantity;
                                                    if($item->discount_perc){
                                                        $totalDiscount = $totalDiscount+round((($item->discount_perc/100)*$item->unit_price)*$item->quantity,2);
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
                                            
                                            <button class="btn bg-gradient-danger btn-sm float-end" wire:click.prevent="updateServiceItem">Update</button>
                                            <div wire:loading wire:target="updateServiceItem">
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
                                <div class="col-lg-4 col-12 ms-auto">
                                    <h6 class="mb-3">Order Summary</h6>
                                    <div class="d-flex justify-content-between">
                                        <span class="mb-2 text-sm">
                                        Product Price:
                                        </span>
                                        <span class="text-dark font-weight-bold ms-2">{{config('global.CURRENCY')}} {{round($total,2)}}</span>
                                    </div>
                                    @if($totalDiscount>0)
                                    <div class="d-flex justify-content-between">
                                        <span class="mb-2 text-sm">
                                        Discount:
                                        </span>
                                        <span class="text-dark ms-2 font-weight-bold">{{config('global.CURRENCY')}} {{round($totalDiscount,2)}}</span>
                                    </div>
                                    @endif
                                    <hr class="horizontal dark my-2">
                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="mb-2 text-md text-dark text-bold">
                                        Total:
                                        </span>
                                        <span class="text-dark text-lg ms-2 font-weight-bold">{{config('global.CURRENCY')}} {{round($totalAfterDisc,2)}}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-sm">
                                        Taxes:
                                        </span>
                                        <span class="text-dark ms-2 font-weight-bold">{{config('global.CURRENCY')}} {{round($tax,2)}}</span>
                                    </div>
                                    <hr class="horizontal dark my-2">
                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="mb-2 text-lg text-dark text-bold">
                                        Grand Total:
                                        </span>
                                        <span class="text-dark text-lg ms-2 font-weight-bold">{{config('global.CURRENCY')}} {{round($grand_total,2)}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        @if($showCheckout)
            <div class="row mt-3">
                <div class="col-md-12 mb-4" >
                    <div class="card p-2 mb-4">
                        <div class="card-header text-center pt-4 pb-3">
                            
                            <h1 class="font-weight-bold mt-2">
                                Payment Confirmation
                            </h1>
                            <hr>
                            
                        </div>
                        <div class="card-body text-lg-left text-center pt-0">
                            <p><span class="badge rounded-pill bg-light text-dark text-md">Total: <small>AED</small> {{ $total }}</span></p>
                            @if($totalDiscount>0 )
                            <p><span class="badge rounded-pill bg-light text-dark text-md">Discount: <small>AED</small> {{ $totalDiscount }}</span></p>
                            @endif
                            <p><span class="badge rounded-pill bg-light text-dark text-md">VAT: <small>AED</small> {{ $tax }}</span></p>
                            <p><span class="badge rounded-pill bg-dark text-light text-lg text-bold">Grand total: <small>AED</small> {{ $grand_total }}</span></p>
                            
                            
                        </div>
                        <div class="card-footer text-lg-left text-center pt-0">
                            <div class="d-flex justify-content-center p-2">
                                @if($mobile)
                                <div class="form-check">
                                    <a wire:click="completePaymnet('link')" class="btn btn-icon bg-gradient-info d-lg-block mt-3 mb-0">Pay By Link<i class="fa-solid fa-comments-dollar ms-1" ></i></a>
                                </div>
                                @endif
                            
                                <div class="form-check">
                                    <a wire:click="completePaymnet('card')" class="btn btn-icon bg-gradient-success d-lg-block mt-3 mb-0">Pay By Card<i class="fa-solid fa-credit-card ms-1" ></i></a>
                                </div>
                            
                                <div class="form-check">
                                    <a wire:click="completePaymnet('cash')" class="btn btn-icon bg-gradient-danger d-lg-block mt-3 mb-0">Cash Payment<i class="fa-solid fa-money-bill-1-wave ms-1" ></i></a>
                                </div>
                                <div class="form-check">
                                    <a wire:click="payLater('paylater')" class="btn btn-icon bg-gradient-secondary d-lg-block mt-3 mb-0">Pay Later<i class="fa-regular fa-money-bill-1 ms-1"></i></a>
                                </div>

                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div wire:loading wire:target="completePaymnet">
                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                    <div class="la-ball-beat">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <div wire:loading wire:target="payLater">
                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                    <div class="la-ball-beat">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
        @endif
        @if($successPage)
            <div class="row mt-3">
                <div class="col-md-12 mb-4" >
                    <div class="card p-2 mb-4 bg-cover text-center" style="background-image: url('https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/curved-images/curved1.jpg')">
                        <div class="card-body z-index-2 py-2">
                            <h2 class="text-white">Successful..!</h2>
                            <p class="text-white">The service in under processing</p>
                            <button type="button" class=" text-white btn bg-gradient-default selectVehicle py-2 " wire:click="dashCustomerJobUpdate('{{$job_number}}')"   >Job Number: {{$job_number}}</button>
                        </div>
                        <div class="mask bg-gradient-success border-radius-lg"></div>
                    </div>
                </div>
            </div>
            <div wire:loading wire:target="dashCustomerJobUpdate">
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
</main>
@push('custom_script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    window.addEventListener('refreshPage',event=>{
        location.reload();
    });
</script>
@endpush
