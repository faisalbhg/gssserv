<style>
    .modal-dialog {
        max-width: 90%;
    }
    .modal{
        z-index: 99999;
    }
</style>

<!-- Modal -->
<div wire:ignore.self class="modal fade" id="serviceUpdateModal" tabindex="-1" role="dialog" aria-labelledby="serviceUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-header" style="display:inline !important;">
                <div class="d-sm-flex justify-content-between">
                    <div>
                      <h5 class=" modal-title" id="serviceUpdateModalLabel">#{{$jobcardDetails->job_number}}</h5>
                    </div>
                    <div class="d-flex">
                      <button wire:click="addNewServiceItem('{{$jobcardDetails->job_number}}')" type="button" class="btn bg-gradient-primary btn-sm mb-0 float-end">Add New Service/Items</button>
                      <a  class="cursor-pointer" data-bs-dismiss="modal"><i class="text-danger fa-solid fa-circle-xmark fa-xxl" style="font-size:2rem;"></i></a>
                    </div>
                </div>
                
            </div>
            
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <a href="javascript:;" class="">
                            <div class="card card-background move-on-hover mb-4" style="align-items: inherit;">
                                <div class="full-background" style="background-image: url('{{url("storage/".$jobcardDetails->vehicle_image)}}')"></div>
                                <div class="card-body pt-5">
                                    @if($jobCustomerInfo['name'])
                                        <h4 class="text-white mb-0 pb-0">{{$jobCustomerInfo['name']}}</h4>
                                        <p class="mt-0 pt-0"><small>{{$jobCustomerInfo['mobile']}}<br> {{$jobCustomerInfo->email}}</small></p>
                                        <!--ID image-->
                                    @else
                                    Guest
                                    @endif
                                    <hr class="horizontal dark mt-3">
                                    <p class="mb-0">{{$jobcardDetails->make}}, {{$jobcardDetails->model}}</p>
                                    <p>{{$jobcardDetails->plate_number}}</p>
                                    <p class="mb-0">Chassis Number: {{$jobcardDetails->chassis_number}}</p>
                                    <p>K.M Reading: {{$jobcardDetails->vehicle_km}}</p>
                                    <ul class="list-group">
                                        <li class="list-group-item border-0  p-2 mb-2 bg-gray-100 border-radius-lg">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="float-start icon icon-shape icon-xs rounded-circle {{config('global.jobs.status_btn_class')[$job_status]}} shadow text-center m-2">
                                                        <i class="fa-solid fa-car-on  opacity-10" aria-hidden="true"></i>
                                                    </div>
                                                    @if($jobcardDetails->job_status)
                                                    <h6 class="my-2 text-sm">
                                                        Job Status: <span class="text-sm {{config('global.jobs.status_text_class')[$jobcardDetails->job_status]}} pb-2">{{config('global.jobs.status')[$jobcardDetails->job_status]}}</span> 
                                                    </h6>
                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item border-0  p-2 mb-2 bg-gray-100 border-radius-lg">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    
                                                    <div class="float-start icon icon-shape icon-xs rounded-circle {{config('global.payment.status_class')[$jobcardDetails->payment_status]}} shadow text-center m-2">
                                                        <i class="{{config('global.payment.icons')[$jobcardDetails->payment_type]}} opacity-10" aria-hidden="true"></i>
                                                    </div>
                                                    <h6 class="my-2 text-sm">
                                                        Payment Status: <span class="text-sm {{config('global.payment.text_class')[$jobcardDetails->payment_type]}} pb-2">{{config('global.payment.type')[$jobcardDetails->payment_type]}}</span> - <span class=" {{config('global.payment.status_class')[$jobcardDetails->payment_status]}} text-gradient text-sm">{{config('global.payment.status')[$jobcardDetails->payment_status]}}</span>
                                                    </h6>
                                                    
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">

                                                    @if($jobcardDetails->payment_status==0 && $jobcardDetails->payment_type!=1)
                                                    <div class=" float-start">
                                                        @foreach(config('global.payment.status_update') as $pskey => $paymentStatus)
                                                        <button wire:click="updatePayment('{{$job_number}}','{{$pskey}}')" class="btn btn-sm {{config('global.payment.status_class')[$pskey]}} btn-sm px-2">{{config('global.payment.status_update')[$pskey]}}</button>
                                                        @endforeach
                                                    </div>
                                                    @else
                                                    <div class=" float-start">
                                                        @if($jobcardDetails->payment_type==1 && $jobcardDetails->payment_status==0)
                                                        <button type="button" wire:click="resendPaymentLink('{{$job_number}}')" class="mt-2 btn btn-sm bg-gradient-success px-2">Re send Payment link</button>
                                                        <button type="button" wire:click="checkPaymentStatus('{{$jobcardDetails->job_number}}','1')" class="mt-2 btn btn-sm bg-gradient-info px-2">Check Payment Status</button>
                                                        @endif
                                                        @if ($message = Session::get('paymentLinkStatusSuccess'))
                                                            <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
                                                                <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                                                                <span class="alert-text"><strong>Success!</strong> {{ $message }}</span>
                                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                        @endif
                                                        @if ($message = Session::get('paymentLinkStatusError'))
                                                            <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                                                                <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                                                                <span class="alert-text"><strong>Success!</strong> {{ $message }}</span>
                                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                        @endif

                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-profile card-plain">
                                    <div class="row">
                                        <div class="col-xxs-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                            <div class="card-body p-0 text-left">
                                                <ul class="list-group">
                                                    <li class="list-group-item border-0  p-2 mb-2 border-radius-lg">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="card h-100 mb-4">
                                                                    <div class="card-header pb-0 p-2">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <h6 class="mb-0">Billing Summary</h6>
                                                                            </div>
                                                                            <div class="col-md-6 d-flex justify-content-end align-items-center">
                                                                                <i class="far fa-calendar-alt me-2" aria-hidden="true"></i>
                                                                                <small>{{ \Carbon\Carbon::parse($job_date_time)->format('dS M Y H:i A') }}</small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="card-body pt-4 p-2">
                                                                        <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Items/Services</h6>
                                                                        <ul class="list-group">
                                                                            <?php $discountPS=0;?>
                                                                            @foreach($customerjobservices as $serviceItems)
                                                                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                                                <div class="d-flex align-items-center">
                                                                                    <button class="btn btn-icon-only btn-rounded  mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-right" aria-hidden="true"></i></button>
                                                                                    <div class="d-flex flex-column">
                                                                                        <h6 class="mb-1 text-dark text-sm">{{$serviceItems->item_name}}</h6>
                                                                                        <span class="text-xs">{{$serviceItems->item_code}}<br>{{$serviceItems->department_code}}-</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                                                                                {{config('global.CURRENCY')}} {{round($serviceItems->grand_total,2)}}
                                                                                </div>
                                                                            </li>
                                                                            <?php $discountPS = $discountPS+$serviceItems->discount_amount; ?>
                                                                            @endforeach
                                                                            
                                                                        </ul>
                                                                        <h6 class="text-uppercase text-body text-xs font-weight-bolder my-3">Other</h6>
                                                                        <ul class="list-group">
                                                                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                                                <div class="d-flex align-items-center">
                                                                                    <button class="btn btn-icon-only btn-rounded mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-right" aria-hidden="true"></i></button>
                                                                                    <div class="d-flex flex-column">
                                                                                        <h6 class="mb-1 text-dark text-sm">Total Price</h6>
                                                                                        <span class="text-xs">total price description</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                                                                                {{config('global.CURRENCY')}} {{$total_price}}
                                                                                </div>
                                                                            </li>
                                                                            @if($discountPS>0)
                                                                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                                                <div class="d-flex align-items-center">
                                                                                    <button class="btn btn-icon-only btn-rounded mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-right" aria-hidden="true"></i></button>
                                                                                    <div class="d-flex flex-column">
                                                                                        <h6 class="mb-1 text-dark text-sm">Discount</h6>
                                                                                        <span class="text-xs">discount description</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                                                                                {{config('global.CURRENCY')}} {{round($discountPS,2)}}
                                                                                </div>
                                                                            </li>
                                                                            @endif
                                                                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                                                <div class="d-flex align-items-center">
                                                                                    <button class="btn btn-icon-only btn-rounded mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-right" aria-hidden="true"></i></button>
                                                                                    <div class="d-flex flex-column">
                                                                                        <h6 class="mb-1 text-dark text-sm">Vat</h6>
                                                                                        <span class="text-xs">Vat 5%</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                                                                                {{config('global.CURRENCY')}} {{round($vat,2)}}
                                                                                </div>
                                                                            </li>
                                                                            <hr class="horizontal dark mt-3">

                                                                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                                                <div class="d-flex align-items-center">
                                                                                    <button class="btn btn-icon-only btn-rounded mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-right" aria-hidden="true"></i></button>
                                                                                    <div class="d-flex flex-column">
                                                                                        <h6 class="mb-1 text-dark text-md">Grand Total</h6>
                                                                                        <span class="text-xs"></span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="d-flex align-items-center text-success text-gradient text-md font-weight-bold">
                                                                                {{config('global.CURRENCY')}} {{round(($total_price+$vat),2)}}
                                                                                </div>
                                                                            </li>
                                                                            
                                                                            
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- <h6 class="mb-0">Services Information</h6>
                         <hr class="mt-0">
                         --><ul class="list-group">
                            @forelse( $customerjobservices as $services)
                            <li class="list-group-item border-0  p-2 mb-2 border-radius-lg">
                                <div class="card">
                                    <div class="card-body p-2">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="d-none float-start icon icon-shape icon-xs rounded-circle {{config('global.jobs.status_btn_class')[$services->job_status]}} shadow text-center mx-2">
                                                    @if($services->service_item)
                                                    <i class="fa-solid fa-shopping-cart  opacity-10" aria-hidden="true"></i>@else
                                                    <i class="{{config('global.job_status_icon')[$services->job_status]}} opacity-10" aria-hidden="true"></i>
                                                    @endif
                                                </div>
                                                <h6 class="mb-0 text-md">
                                                    @if($services->quantity>1)
                                                    {{$services->quantity.' x '}}
                                                    @endif
                                                    @if($services->service_item)
                                                    {{$services->item_name}}
                                                    @else
                                                    {{$services->item_name}}
                                                    @endif
                                                    @if(!$services->service_item)
                                                    <span class=" bg-gradient-dark text-gradient text-sm font-weight-bold">({{$services->department_code}})</span>
                                                    @endif
                                                </h6>
                                                <div class="float-start icon icon-shape icon-xs rounded-circle {{config('global.jobs.status_btn_class')[$job_status]}} shadow text-center m-2">
                                                    <i class="fa-solid fa-car-on  opacity-10" aria-hidden="true"></i>
                                                </div>
                                                @if($jobcardDetails->job_status)
                                                <h6 class="my-2 text-sm">
                                                    Job Status: <span class="text-sm {{config('global.jobs.status_text_class')[$jobcardDetails->job_status]}} pb-2">{{config('global.jobs.status')[$jobcardDetails->job_status]}}</span> 
                                                </h6>
                                                @endif
                                                
                                                <!-- <p class="text-sm font-weight-bold mb-0">
                                                    <span class="mb-2 text-xs">Price: <span class="text-dark ms-2 font-weight-bold">AED {{round($services->total_price,2)}}</span></span>
                                                </p>
                                                <p class="text-sm font-weight-bold mb-0">
                                                    <span class="text-xs">VAT: <span class="text-dark ms-2 font-weight-bold">AED {{round($services->vat,2)}}</span></span>
                                                </p>
                                                <p class="text-sm font-weight-bold mb-2">
                                                    <span class="text-md text-dark">Grand Total: <span class="text-dark ms-2 font-weight-bold">AED {{round($services->grand_total,2)}}</span></span>
                                                </p> -->
                                            </div>
                                            <div class="col-md-4">
                                                @if($services->job_status!=4)
                                                <a class="btn btn-link text-dark p-0 m-0" wire:click="updateQwService({{$services}})">
                                                    <button class="mt-4 btn btn-sm {{config('global.jobs.status_btn_class')[$services->job_status+1]}}">{{config('global.jobs.status')[$services->job_status+1]}}</button>
                                                </a>
                                                @endif
                                                @if($services->is_removed==1)
                                                <span class="mt-4 badge badge-md bg-gradient-danger"> <i class="fas fa-trash text-white me-2" aria-hidden="true"></i> Removeed</span>
                                                @else
                                                    
                                                    <!-- @if($services->job_status==1)
                                                    <a class="btn btn-link text-dark px-3 mb-0 float-end" wire:click="removeService('{{$services}}')"><span class="mt-4 badge badge-md bg-gradient-danger"> <i class="fas fa-trash text-white me-2" aria-hidden="true"></i> Remove Now</span></a>
                                                    @endif -->
                                                    <!-- @if($services->job_status==4)
                                                    <span class="mt-2 badge badge-md {{config('global.item_status_text_class')[$services->job_status]}} float-end">{{config('global.item_status')[$services->job_status]}}</span>
                                                    @else
                                                    <a class="btn btn-link text-dark p-0 mb-0" wire:click="updateService('{{$services}}')"><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Update to: <span class="mt-4 badge badge-md {{config('global.item_status_text_class')[$services->job_status+1]}}">{{config('global.item_status')[$services->job_status+1]}}</span></a>
                                                    @endif -->
                                                
                                                    @if($services->is_removed==0 && $services->job_status==0)
                                                    <a class="btn btn-link text-dark px-3 mb-0 float-end" wire:click="removeService('{{$services}}')"><span class="mt-4 badge badge-md bg-gradient-danger"> <i class="fas fa-trash text-white me-2" aria-hidden="true"></i> Remove</span></a>
                                                    @endif
                                                    @if($services->job_status==4)
                                                    <span class="mt-2 mb-2 badge badge-md {{config('global.jobs.status_btn_class')[$services->job_status]}} ">{{config('global.jobs.status')[$services->job_status]}}</span>
                                                    @endif
                                                    
                                                @endif
                                            </div>
                                        </div>
                                        <hr class="horizontal dark mt-0 mb-1">
                                        @if($services->department_code=='PP/00035')

                                            @if($services->job_status==1)
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="card m-2">
                                                        <div class="card-header p-2">
                                                            <h4 class="mb-2 text-sm text-left">Front Side</h4>
                                                        </div>
                                                        <div class="card-body p-2">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="frontSideBumperCheck" wire:model="frontSideBumperCheck" >
                                                                <label class="form-check-label" for="frontSideBumperCheck">Bumper</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="frontSideGrillCheck" wire:model="frontSideGrillCheck" >
                                                                <label class="form-check-label" for="frontSideGrillCheck">Grill</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="frontSideNumberPlateCheck" wire:model="frontSideNumberPlateCheck" >
                                                                <label class="form-check-label" for="frontSideNumberPlateCheck">Number Plate</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="frontSideHeadLampsCheck" wire:model="frontSideHeadLampsCheck" >
                                                                <label class="form-check-label" for="frontSideHeadLampsCheck">Head Lamps</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="frontSideFogLampsCheck" wire:model="frontSideFogLampsCheck" >
                                                                <label class="form-check-label" for="frontSideFogLampsCheck">Fog Lamps</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="frontSideHoodCheck" wire:model="frontSideHoodCheck" >
                                                                <label class="form-check-label" for="frontSideHoodCheck">Hood</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card m-2">
                                                        <div class="card-header p-2">
                                                            <h4 class="mt-3 text-sm text-left">Rear Side</h4>
                                                        </div>
                                                        <div class="card-body p-2">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="rearSideBumperCheck" wire:model="rearSideBumperCheck" >
                                                                <label class="form-check-label" for="rearSideBumperCheck">Bumper</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="rearSideMufflerCheck" wire:model="rearSideMufflerCheck" >
                                                                <label class="form-check-label" for="rearSideMufflerCheck">Muffler</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="rearSideNumberPlateCheck" wire:model="rearSideNumberPlateCheck" >
                                                                <label class="form-check-label" for="rearSideNumberPlateCheck">Number Plate</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="rearSideTrunkCheck" wire:model="rearSideTrunkCheck" >
                                                                <label class="form-check-label" for="rearSideTrunkCheck">Trunk</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="rearSideLightsCheck" wire:model="rearSideLightsCheck" >
                                                                <label class="form-check-label" for="rearSideLightsCheck">Lights</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="rearSideRoofTopCheck" wire:model="rearSideRoofTopCheck" >
                                                                <label class="form-check-label" for="rearSideRoofTopCheck">Roof Top</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card m-2">
                                                        <div class="card-header p-2">
                                                            <h4 class="mb-2 text-sm text-left">Left Side</h4>
                                                        </div>
                                                        <div class="card-body p-2">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="leftSideWheelCheck" wire:model="leftSideWheelCheck" >
                                                                <label class="form-check-label" for="leftSideWheelCheck">Wheel</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="leftSideFenderCheck" wire:model="leftSideFenderCheck" >
                                                                <label class="form-check-label" for="leftSideFenderCheck">Fender</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="leftSideSideMirrorCheck" wire:model="leftSideSideMirrorCheck" >
                                                                <label class="form-check-label" for="leftSideSideMirrorCheck">Side Mirror</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="leftSideDoorGlassInOutCheck" wire:model="leftSideDoorGlassInOutCheck" >
                                                                <label class="form-check-label" for="leftSideDoorGlassInOutCheck">Door Glass In & Out</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="leftSideDoorHandleCheck" wire:model="leftSideDoorHandleCheck" >
                                                                <label class="form-check-label" for="leftSideDoorHandleCheck">Door Handle</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="leftSideSideStepperCheck" wire:model="leftSideSideStepperCheck" >
                                                                <label class="form-check-label" for="leftSideSideStepperCheck">Side Stepper</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="card">
                                                        <div class="card-header p-2">
                                                            <h4 class="mt-3 text-sm text-lefft">Right Side</h4>
                                                        </div>
                                                        <div class="card-body p-2">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="rightSideWheelCheck" wire:model="rightSideWheelCheck" >
                                                                <label class="form-check-label" for="rightSideWheelCheck">Wheel</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="rightSideFenderCheck" wire:model="rightSideFenderCheck" >
                                                                <label class="form-check-label" for="rightSideFenderCheck">Fender</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="rightSideSideMirrorCheck" wire:model="rightSideSideMirrorCheck" >
                                                                <label class="form-check-label" for="rightSideSideMirrorCheck">Side Mirror</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="rightSideDoorGlassInOutCheck" wire:model="rightSideDoorGlassInOutCheck" >
                                                                <label class="form-check-label" for="rightSideDoorGlassInOutCheck">Door Glass In & Out</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="rightSideDoorHandleCheck" wire:model="rightSideDoorHandleCheck" >
                                                                <label class="form-check-label" for="rightSideDoorHandleCheck">Door Handle</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="rightSideSideStepperCheck" wire:model="rightSideSideStepperCheck" >
                                                                <label class="form-check-label" for="rightSideSideStepperCheck">Side Stepper</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card m-2">
                                                        <div class="card-header p-2">
                                                            <h4 class="mb-2 text-sm text-left">Inner Cabin</h4>
                                                        </div>
                                                        <div class="card-body p-2">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="innerCabinSmellCheck" wire:model="innerCabinSmellCheck" >
                                                                <label class="form-check-label" for="innerCabinSmellCheck">Smell</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="innerCabinWindshieldFRRRCheck" wire:model="innerCabinWindshieldFRRRCheck" >
                                                                <label class="form-check-label" for="innerCabinWindshieldFRRRCheck">Windshield FR & RR</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="innerCabinSteeringWheelCheck" wire:model="innerCabinSteeringWheelCheck" >
                                                                <label class="form-check-label" for="innerCabinSteeringWheelCheck">Steering Wheel</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="innerCabinGearKnobCheck" wire:model="innerCabinGearKnobCheck" >
                                                                <label class="form-check-label" for="innerCabinGearKnobCheck">Gear Knob</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="innerCabinCentreConsoleCheck" wire:model="innerCabinCentreConsoleCheck" >
                                                                <label class="form-check-label" for="innerCabinCentreConsoleCheck">Centre Console</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="innerCabinAshTryCheck" wire:model="innerCabinAshTryCheck" >
                                                                <label class="form-check-label" for="innerCabinAshTryCheck">Ash Try</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="innerCabinDashboardCheck" wire:model="innerCabinDashboardCheck" >
                                                                <label class="form-check-label" for="innerCabinDashboardCheck">Dashboard</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="innerCabinACVentsFRRRCheck" wire:model="innerCabinACVentsFRRRCheck" >
                                                                <label class="form-check-label" for="innerCabinACVentsFRRRCheck">AC Vents FR & RR</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="innerCabinInteriorTrimCheck" wire:model="innerCabinInteriorTrimCheck" >
                                                                <label class="form-check-label" for="innerCabinInteriorTrimCheck">Interior Trim</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="innerCabinFloorMatCheck" wire:model="innerCabinFloorMatCheck" >
                                                                <label class="form-check-label" for="innerCabinFloorMatCheck">Floor Mat</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="innerCabinRearViewMirrorCheck" wire:model="innerCabinRearViewMirrorCheck" >
                                                                <label class="form-check-label" for="innerCabinRearViewMirrorCheck">Rear View Mirror</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="innerCabinLuggageCompCheck" wire:model="innerCabinLuggageCompCheck" >
                                                                <label class="form-check-label" for="innerCabinLuggageCompCheck">Luggage Comp</label>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="innerCabinRoofTopCheck" wire:model="innerCabinRoofTopCheck" >
                                                                <label class="form-check-label" for="innerCabinRoofTopCheck">Roof Top</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    
                                                </div>
                                            </div>
                                            @endif

                                        @endif


                                        
                                        @if( ($services->department_code=='PP/00036' || $services->department_code=='PP/00037')) 
                                            @if($services->job_status==1)
                                            <div class="row">
                                                @if($services->department_code=='PP/00036')
                                                
                                                <div class="col-md-4 mb-4">
                                                    <div class="card">
                                                        <div class="card-header text-center pt-4 pb-3">
                                                            <h5 class="font-weight-bold mt-2">Pre-Finishing</h5>
                                                        </div>
                                                        <div class="card-body text-center pt-0">
                                                            <div class="row">
                                                                @if($services->pre_finishing==null)
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <button class="btn btn-icon btn-3 btn-info" type="button" wire:click="clickQlOperation('start','pre_finishing','{{$services->id}}')">
                                                                            <span class="btn-inner--icon"><i class="ni ni-button-play"></i></span>
                                                                            <span class="btn-inner--text">Start</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                @elseif($services->pre_finishing == 1)
                                                                <div class="col-md-6">
                                                                    <label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->pre_finishing_time_in)->format('dS M Y H:i A') }}</label>
                                                                    <div class="form-group">
                                                                        <button class="btn btn-icon btn-3 btn-primary" type="button" wire:click="clickQlOperation('stop','pre_finishing','{{$services->id}}')">
                                                                            <span class="btn-inner--icon"><i class="ni ni-button-pause"></i></span>
                                                                            <span class="btn-inner--text">Stop</span>
                                                                        </button>
                                                                        
                                                                    </div>
                                                                </div>
                                                                @else
                                                                <div class="col-md-12">
                                                                    <p class="mb-0"><label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->pre_finishing_time_in)->format('dS M Y H:i A') }}</label></p>
                                                                    <p class="mb-0"><label for="example-time-input" class="form-control-label">Ends at: {{ \Carbon\Carbon::parse($services->pre_finishing_time_out)->format('dS M Y H:i A') }}</label></p>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-4">
                                                    <div class="card">
                                                        <div class="card-header text-center pt-4 pb-3">
                                                            <h5 class="font-weight-bold mt-2">Finishing</h5>
                                                        </div>
                                                        <div class="card-body text-center pt-0">
                                                            <div class="row">
                                                                @if($services->finishing==null)
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <button class="btn btn-icon btn-3 btn-info" type="button" wire:click="clickQlOperation('start','finishing','{{$services->id}}')">
                                                                            <span class="btn-inner--icon"><i class="ni ni-button-play"></i></span>
                                                                            <span class="btn-inner--text">Start</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                @elseif($services->finishing == 1)
                                                                <div class="col-md-12">
                                                                    <label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->finishing_time_in)->format('dS M Y H:i A') }}</label>
                                                                    <div class="form-group">
                                                                        <button class="btn btn-icon btn-3 btn-primary" type="button" wire:click="clickQlOperation('stop','finishing','{{$services->id}}')">
                                                                            <span class="btn-inner--icon"><i class="ni ni-button-pause"></i></span>
                                                                            <span class="btn-inner--text">Stop</span>
                                                                        </button>
                                                                        
                                                                    </div>
                                                                </div>
                                                                @else
                                                                <div class="col-md-12">
                                                                    <p class="mb-0"><label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->finishing_time_in)->format('dS M Y H:i A') }}</label></p>
                                                                    <p class="mb-0"><label for="example-time-input" class="form-control-label">Ends at: {{ \Carbon\Carbon::parse($services->finishing_time_out)->format('dS M Y H:i A') }}</label></p>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-4">
                                                    <div class="card">
                                                        <div class="card-header text-center pt-4 pb-3">
                                                            <h5 class="font-weight-bold mt-2">Glazing</h5>
                                                        </div>
                                                        <div class="card-body text-center pt-0">
                                                            <div class="row">
                                                                @if($services->glazing==null)
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <button class="btn btn-icon btn-3 btn-info" type="button" wire:click="clickQlOperation('start','glazing','{{$services->id}}')">
                                                                            <span class="btn-inner--icon"><i class="ni ni-button-play"></i></span>
                                                                            <span class="btn-inner--text">Start</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                @elseif($services->glazing == 1)
                                                                <div class="col-md-12">
                                                                    <label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->glazing_time_in)->format('dS M Y H:i A') }}</label>
                                                                    <div class="form-group">
                                                                        <button class="btn btn-icon btn-3 btn-primary" type="button" wire:click="clickQlOperation('stop','glazing','{{$services->id}}')">
                                                                            <span class="btn-inner--icon"><i class="ni ni-button-pause"></i></span>
                                                                            <span class="btn-inner--text">Stop</span>
                                                                        </button>
                                                                        
                                                                    </div>
                                                                </div>
                                                                @else
                                                                <div class="col-md-12">
                                                                    <p class="mb-0"><label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->glazing_time_in)->format('dS M Y H:i A') }}</label></p>
                                                                    <p class="mb-0"><label for="example-time-input" class="form-control-label">Ends at: {{ \Carbon\Carbon::parse($services->glazing_time_out)->format('dS M Y H:i A') }}</label></p>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-4">
                                                    <div class="card">
                                                        <div class="card-header text-center pt-4 pb-3">
                                                            <h5 class="font-weight-bold mt-2">Seat Cleaning</h5>
                                                        </div>
                                                        <div class="card-body text-center pt-0">
                                                            <div class="row">
                                                                @if($services->seat_cleaning==null)
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <button class="btn btn-icon btn-3 btn-info" type="button" wire:click="clickQlOperation('start','seat_cleaning','{{$services->id}}')">
                                                                            <span class="btn-inner--icon"><i class="ni ni-button-play"></i></span>
                                                                            <span class="btn-inner--text">Start</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                @elseif($services->seat_cleaning == 1)
                                                                <div class="col-md-12">
                                                                    <label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->seat_cleaning_time_in)->format('dS M Y H:i A') }}</label>
                                                                    <div class="form-group">
                                                                        <button class="btn btn-icon btn-3 btn-primary" type="button" wire:click="clickQlOperation('stop','seat_cleaning','{{$services->id}}')">
                                                                            <span class="btn-inner--icon"><i class="ni ni-button-pause"></i></span>
                                                                            <span class="btn-inner--text">Stop</span>
                                                                        </button>
                                                                        
                                                                    </div>
                                                                </div>
                                                                @else
                                                                <div class="col-md-12">
                                                                    <p class="mb-0"><label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->seat_cleaning_time_in)->format('dS M Y H:i A') }}</label></p>
                                                                    <p class="mb-0"><label for="example-time-input" class="form-control-label">Ends at: {{ \Carbon\Carbon::parse($services->seat_cleaning_time_out)->format('dS M Y H:i A') }}</label></p>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-4">
                                                    <div class="card">
                                                        <div class="card-header text-center pt-4 pb-3">
                                                            <h5 class="font-weight-bold mt-2">Interior Cleaning</h5>
                                                        </div>
                                                        <div class="card-body text-center pt-0">
                                                            <div class="row">
                                                                @if($services->interior==null)
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <button class="btn btn-icon btn-3 btn-info" type="button" wire:click="clickQlOperation('start','interior','{{$services->id}}')">
                                                                            <span class="btn-inner--icon"><i class="ni ni-button-play"></i></span>
                                                                            <span class="btn-inner--text">Start</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                @elseif($services->interior == 1)
                                                                <div class="col-md-12">
                                                                    <label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->interior_cleaning_time_in)->format('dS M Y H:i A') }}</label>
                                                                    <div class="form-group">
                                                                        <button class="btn btn-icon btn-3 btn-primary" type="button" wire:click="clickQlOperation('stop','interior','{{$services->id}}')">
                                                                            <span class="btn-inner--icon"><i class="ni ni-button-pause"></i></span>
                                                                            <span class="btn-inner--text">Stop</span>
                                                                        </button>
                                                                        
                                                                    </div>
                                                                </div>
                                                                @else
                                                                <div class="col-md-12">
                                                                    <p class="mb-0"><label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->interior_cleaning_time_in)->format('dS M Y H:i A') }}</label></p>
                                                                    <p class="mb-0"><label for="example-time-input" class="form-control-label">Ends at: {{ \Carbon\Carbon::parse($services->interior_cleaning_time_out)->format('dS M Y H:i A') }}</label></p>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-4">
                                                    <div class="card">
                                                        <div class="card-header text-center pt-4 pb-3">
                                                            <h5 class="font-weight-bold mt-2">Oil Change</h5>
                                                        </div>
                                                        <div class="card-body text-center pt-0">
                                                            <div class="row">
                                                                @if($services->oil_change==null)
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <button class="btn btn-icon btn-3 btn-info" type="button" wire:click="clickQlOperation('start','oil_change','{{$services->id}}')">
                                                                            <span class="btn-inner--icon"><i class="ni ni-button-play"></i></span>
                                                                            <span class="btn-inner--text">Start</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                @elseif($services->oil_change == 1)
                                                                <div class="col-md-12">
                                                                    <label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->oil_change_time_in)->format('dS M Y H:i A') }}</label>
                                                                    <div class="form-group">
                                                                        <button class="btn btn-icon btn-3 btn-primary" type="button" wire:click="clickQlOperation('stop','oil_change','{{$services->id}}')">
                                                                            <span class="btn-inner--icon"><i class="ni ni-button-pause"></i></span>
                                                                            <span class="btn-inner--text">Stop</span>
                                                                        </button>
                                                                        
                                                                    </div>
                                                                </div>
                                                                @else
                                                                <div class="col-md-12">
                                                                    <p class="mb-0"><label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->oil_change_time_in)->format('dS M Y H:i A') }}</label></p>
                                                                    <p class="mb-0"><label for="example-time-input" class="form-control-label">Ends at: {{ \Carbon\Carbon::parse($services->oil_change_time_out)->format('dS M Y H:i A') }}</label></p>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-4">
                                                    <div class="card">
                                                        <div class="card-header text-center pt-4 pb-3">
                                                            <h5 class="font-weight-bold mt-2">Wash Service</h5>
                                                        </div>
                                                        <div class="card-body text-center pt-0">
                                                            <div class="row">
                                                                @if($services->wash_service==null)
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <button class="btn btn-icon btn-3 btn-info" type="button" wire:click="clickQlOperation('start','wash_service','{{$services->id}}')">
                                                                            <span class="btn-inner--icon"><i class="ni ni-button-play"></i></span>
                                                                            <span class="btn-inner--text">Start</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                @elseif($services->wash_service == 1)
                                                                <div class="col-md-12">
                                                                    <label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->wash_service_time_in)->format('dS M Y H:i A') }}</label>
                                                                    <div class="form-group">
                                                                        <button class="btn btn-icon btn-3 btn-primary" type="button" wire:click="clickQlOperation('stop','wash_service','{{$services->id}}')">
                                                                            <span class="btn-inner--icon"><i class="ni ni-button-pause"></i></span>
                                                                            <span class="btn-inner--text">Stop</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                @else
                                                                <div class="col-md-12">
                                                                    <p class="mb-0"><label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->wash_service_time_in)->format('dS M Y H:i A') }}</label></p>
                                                                    <p class="mb-0"><label for="example-time-input" class="form-control-label">Ends at: {{ \Carbon\Carbon::parse($services->wash_service_time_out)->format('dS M Y H:i A') }}</label></p>
                                                                </div>

                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                @endif
                                                
                                                <div class="col-md-4 mb-4">
                                                    <div class="card">
                                                        <div class="card-header text-center pt-4 pb-3">
                                                            <h5 class="font-weight-bold mt-2">Oil Change</h5>
                                                        </div>
                                                        <div class="card-body text-center pt-0">
                                                            <div class="row">
                                                                @if($services->oil_change==null)
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <button class="btn btn-icon btn-3 btn-info" type="button" wire:click="clickQlOperation('start','oil_change','{{$services->id}}')">
                                                                            <span class="btn-inner--icon"><i class="ni ni-button-play"></i></span>
                                                                            <span class="btn-inner--text">Start</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                @elseif($services->oil_change == 1)
                                                                <div class="col-md-12">
                                                                    <label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->oil_change_time_in)->format('dS M Y H:i A') }}</label>
                                                                    <div class="form-group">
                                                                        <button class="btn btn-icon btn-3 btn-primary" type="button" wire:click="clickQlOperation('stop','oil_change','{{$services->id}}')">
                                                                            <span class="btn-inner--icon"><i class="ni ni-button-pause"></i></span>
                                                                            <span class="btn-inner--text">Stop</span>
                                                                        </button>
                                                                        
                                                                    </div>
                                                                </div>
                                                                @else
                                                                <div class="col-md-12">
                                                                    <p class="mb-0"><label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->oil_change_time_in)->format('dS M Y H:i A') }}</label></p>
                                                                    <p class="mb-0"><label for="example-time-input" class="form-control-label">Ends at: {{ \Carbon\Carbon::parse($services->oil_change_time_out)->format('dS M Y H:i A') }}</label></p>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-4">
                                                    <div class="card">
                                                        <div class="card-header text-center pt-4 pb-3">
                                                            <h5 class="font-weight-bold mt-2">Wash Service</h5>
                                                        </div>
                                                        <div class="card-body text-center pt-0">
                                                            <div class="row">
                                                                @if($services->wash_service==null)
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <button class="btn btn-icon btn-3 btn-info" type="button" wire:click="clickQlOperation('start','wash_service','{{$services->id}}')">
                                                                            <span class="btn-inner--icon"><i class="ni ni-button-play"></i></span>
                                                                            <span class="btn-inner--text">Start</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                @elseif($services->wash_service == 1)
                                                                <div class="col-md-12">
                                                                    <label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->wash_service_time_in)->format('dS M Y H:i A') }}</label>
                                                                    <div class="form-group">
                                                                        <button class="btn btn-icon btn-3 btn-primary" type="button" wire:click="clickQlOperation('stop','wash_service','{{$services->id}}')">
                                                                            <span class="btn-inner--icon"><i class="ni ni-button-pause"></i></span>
                                                                            <span class="btn-inner--text">Stop</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                @else
                                                                <div class="col-md-12">
                                                                    <p class="mb-0"><label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->wash_service_time_in)->format('dS M Y H:i A') }}</label></p>
                                                                    <p class="mb-0"><label for="example-time-input" class="form-control-label">Ends at: {{ \Carbon\Carbon::parse($services->wash_service_time_out)->format('dS M Y H:i A') }}</label></p>
                                                                </div>

                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                            </div>
                                            @endif
                                            @if($services->job_status!=4)
                                            <div class="row">
                                                <div class="col-md-12">
                                                    @if($services->service_group_code=='PP/00036')

                                                    <a class="btn btn-link text-dark p-0 mb-0 float-end" wire:click="updateGSService({{$services->id}})">
                                                        <button class="mt-4 btn btn-sm {{config('global.jobs.status_btn_class')[$services->job_status+1]}}">{{config('global.jobs.status')[$services->job_status+1]}}</button>
                                                    </a>
                                                    @elseif($services->service_group_code=='PP/00037')
                                                    <a class="btn btn-link text-dark p-0 mb-0 float-end" wire:click="updateQLService('{{$services}}')">
                                                        <button class="mt-4 btn btn-sm {{config('global.jobs.status_btn_class')[$services->job_status+1]}}">{{config('global.jobs.status')[$services->job_status+1]}}</button>
                                                    </a>
                                                    @endif
                                                </div>

                                            </div>
                                            @endif
                                        @endif
                                        <div class="row">
                                            <div class="col-md-12" >
                                                <div class="card h-100 my-2">
                                                    <div class="card-header p-2">
                                                        <h6>Service History overview</h6>
                                                        <!-- <p class="text-sm">
                                                            <span class="font-weight-bold">#{{$job_number}}</span>
                                                        </p> -->
                                                        <hr class="m-0">
                                                    </div>
                                                    <div class="card-body p-2">
                                                        <div class="timeline timeline-one-side">
                                                            @forelse( $services->customerJobServiceLogs as $logs)
                                                            <div class="timeline-block mb-3">
                                                                <span class="timeline-step">
                                                                    <i class="fa fa-arrow-up text-success text-gradient"></i>
                                                                </span>
                                                                <div class="timeline-content">
                                                                    <span class="badge badge-sm {{config('global.job_status_text_class')[$logs->job_status]}}">{{config('global.job_status')[$logs->job_status]}}</span>
                                                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{ \Carbon\Carbon::parse($job_date_time)->format('d M Y H:i A') }}</p>
                                                                </div>
                                                            </div>
                                                            @empty
                                                            <p class="text-danger">Empty..!</p>
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @empty
                            <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="mb-3 text-sm text-danger">Empty..!</h6>
                                    
                                </div>
                            </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="d-none col-xxs-12 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-4">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="card">
                                    <div class="card-header text-center pt-4 pb-3">
                                        <h5 class="font-weight-bold mt-2">Pre-Finishing</h5>
                                    </div>
                                    <div class="card-body text-left pt-0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="example-time-input" class="form-control-label">Time In</label>
                                                    <input class="form-control" type="time" value="10:30:00" id="example-time-input">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="example-time-input" class="form-control-label">Time Out</label>
                                                    <input class="form-control" type="time" value="10:30:00" id="example-time-input">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="card">
                                    <div class="card-header text-center pt-4 pb-3">
                                        <h5 class="font-weight-bold mt-2">Finishing</h5>
                                    </div>
                                    <div class="card-body text-left pt-0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="example-time-input" class="form-control-label">Time In</label>
                                                    <input class="form-control" type="time" value="10:30:00" id="example-time-input">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="example-time-input" class="form-control-label">Time Out</label>
                                                    <input class="form-control" type="time" value="10:30:00" id="example-time-input">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="card">
                                    <div class="card-header text-center pt-4 pb-3">
                                        <h5 class="font-weight-bold mt-2">Glazing</h5>
                                    </div>
                                    <div class="card-body text-left pt-0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="example-time-input" class="form-control-label">Time In</label>
                                                    <input class="form-control" type="time" value="10:30:00" id="example-time-input">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="example-time-input" class="form-control-label">Time Out</label>
                                                    <input class="form-control" type="time" value="10:30:00" id="example-time-input">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-none col-xxs-12 col-xs-12 col-sm-6 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-4">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header text-center pt-4 pb-3">
                                        <h5 class="font-weight-bold mt-2">Seat Cleaning</h5>
                                    </div>
                                    <div class="card-body text-left pt-0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="example-time-input" class="form-control-label">Time In</label>
                                                    <input class="form-control" type="time" value="10:30:00" id="example-time-input">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="example-time-input" class="form-control-label">Time Out</label>
                                                    <input class="form-control" type="time" value="10:30:00" id="example-time-input">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header text-center pt-4 pb-3">
                                        <h5 class="font-weight-bold mt-2">Interior Cleaning</h5>
                                    </div>
                                    <div class="card-body text-left pt-0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="example-time-input" class="form-control-label">Time In</label>
                                                    <input class="form-control" type="time" value="10:30:00" id="example-time-input">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="example-time-input" class="form-control-label">Time Out</label>
                                                    <input class="form-control" type="time" value="10:30:00" id="example-time-input">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header text-center pt-4 pb-3">
                                        <h5 class="font-weight-bold mt-2">Oil Change</h5>
                                    </div>
                                    <div class="card-body text-left pt-0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="example-time-input" class="form-control-label">Time In</label>
                                                    <input class="form-control" type="time" value="10:30:00" id="example-time-input">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="example-time-input" class="form-control-label">Time Out</label>
                                                    <input class="form-control" type="time" value="10:30:00" id="example-time-input">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header text-center pt-4 pb-3">
                                        <h5 class="font-weight-bold mt-2">Wash Service</h5>
                                    </div>
                                    <div class="card-body text-left pt-0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="example-time-input" class="form-control-label">Time In</label>
                                                    <input class="form-control" type="time" value="10:30:00" id="example-time-input">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="example-time-input" class="form-control-label">Time Out</label>
                                                    <input class="form-control" type="time" value="10:30:00" id="example-time-input">
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
