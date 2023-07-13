<style>
    .modal-dialog {
        max-width: 100%;
    }
    .modal{
        z-index: 99999;
    }
</style>

<!-- Modal -->
<div wire:ignore.self class="modal fade" id="serviceUpdateModal" tabindex="-1" role="dialog" aria-labelledby="serviceUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="serviceUpdateModalLabel">#{{$job_number}}</h5>
                <button wire:click="addNewServiceItem('{{$job_number}}')" type="button" class="btn bg-gradient-info btn-sm float-end mb-0">Add New Service/Items</button>
                                        </h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mt-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-profile card-plain py-2">
                                    <div class="row">
                                        <div class="col-xxs-4 col-xs-4 col-sm-3 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                                            <a href="javascript:;">
                                                <div class="position-relative">
                                                <div class="blur-shadow-image">
                                                    <img class="w-100 rounded-3 shadow-lg" src="{{url('storage/'.$vehicle_image)}}">
                                                </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-xxs-8 col-xs-8 col-sm-9 col-md-9 col-lg-9 col-xl-9 col-xxl-9">
                                            <div class="card-body p-0 text-left">
                                                <div class="p-md-0 pt-0">
                                                    <h5 class="font-weight-bolder mb-0">{{$make}}</h5>
                                                    <p class="text-sm font-weight-bold mb-0">{{$model}} ({{$plate_number}})</p>
                                                    <p class="text-sm mb-0">Chassis Number: {{$chassis_number}}</p>
                                                    <p class="text-sm mb-3">K.M Reading: {{$vehicle_km}}</p>
                                                    <hr class="horizontal dark mt-3">
                                                </div>
                                                <div class="p-md-0 pt-3">
                                                    <p class="text-sm mb-0">Name: {{$name}}</p>
                                                    <p class="text-sm mb-0">Mobile: <a href="tel:{{$mobile}}">{{$mobile}}</a></p>
                                                    <p class="text-sm mb-0">Email: {{$email}}</p>
                                                    <hr class="horizontal dark mt-3">
                                                </div>


                                                <div class="p-md-0 pt-0">
                                                    <p class="text-sm font-weight-bolder font-weight-bold mb-0">Grand Total: {{config('global.CURRENCY')}} {{round(($total_price+$vat),2)}}</p>
                                                    <hr class="horizontal dark mt-3">
                                                </div>
                                                
                                                
                                                <ul class="list-group">
                                                    <li class="list-group-item border-0  p-2 mb-2 bg-gray-100 border-radius-lg">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="float-start icon icon-shape icon-xs rounded-circle {{config('global.jobs.status_btn_class')[$job_status]}} shadow text-center m-2">
                                                                    <i class="fa-solid fa-car-on  opacity-10" aria-hidden="true"></i>
                                                                </div>
                                                                <h6 class="my-2 text-sm">
                                                                    Job Status: <span class="text-sm {{config('global.jobs.status_text_class')[$job_status]}} pb-2">{{config('global.jobs.status')[$job_status]}}</span> 
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item border-0  p-2 mb-2 bg-gray-100 border-radius-lg">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="float-start icon icon-shape icon-xs rounded-circle {{config('global.payment.status_class')[$payment_status]}} shadow text-center m-2">
                                                                    <i class="{{config('global.payment.icons')[$payment_type]}} opacity-10" aria-hidden="true"></i>
                                                                </div>
                                                                <h6 class="my-2 text-sm">
                                                                    Payment Status: <span class="text-sm {{config('global.payment.text_class')[$payment_type]}} pb-2">{{config('global.payment.type')[$payment_type]}}</span> - <span class=" {{config('global.payment.status_class')[$payment_status]}} text-gradient text-sm">{{config('global.payment.status')[$payment_status]}}</span>
                                                                </h6>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                @if($payment_status==0 && $payment_type!=1)
                                                                <div class=" float-start">
                                                                    @foreach(config('global.payment.status_update') as $pskey => $paymentStatus)
                                                                    <button wire:click="updatePayment('{{$job_number}}','{{$pskey}}')" class="btn btn-sm {{config('global.payment.status_class')[$pskey]}} btn-sm px-2">{{config('global.payment.status_update')[$pskey]}}</button>
                                                                    @endforeach
                                                                </div>
                                                                @else
                                                                <div class=" float-end">
                                                                    @if($payment_type==1 && $payment_status==0)
                                                                    <button type="button" wire:click="resendPaymentLink('{{$job_number}}')" class="mt-2 btn btn-sm bg-gradient-success px-2">Re send Payment link</button>
                                                                    <button type="button" wire:click="checkPaymentStatus('{{$job_number}}','1')" class="mt-2 btn btn-sm bg-gradient-info px-2">Check Payment Status</button>
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
                                    </div>
                                </div>
                            </div>
                        
                            <div class="col-md-12">
                                <div class="card ">
                                    <div class="card-header pb-0 px-3">
                                        <h6 class="mb-0">Services Information
                                    </div>
                                    <hr class="mt-0">
                                    <div class="card-body pt-0 p-3">
                                        <ul class="list-group">
                                            @forelse( $customerjobservices as $services)
                                            <li class="list-group-item border-0  p-4 mb-2 bg-gray-100 border-radius-lg">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="float-start icon icon-shape icon-xs rounded-circle {{config('global.jobs.status_btn_class')[$services->job_status]}} shadow text-center mx-2">
                                                            @if($services->service_item)
                                                            <i class="fa-solid fa-shopping-cart  opacity-10" aria-hidden="true"></i>@else
                                                            <i class="{{config('global.job_status_icon')[$services->job_status]}} opacity-10" aria-hidden="true"></i>
                                                            @endif
                                                        </div>
                                                        <h6 class="mb-3 text-md">
                                                            @if($services->quantity>1)
                                                            {{$services->quantity.' x '}}
                                                            @endif
                                                            @if($services->service_item)
                                                            {{$services->item_name}}
                                                            @else
                                                            {{$services->service_type_name}}
                                                            @endif
                                                            @if(!$services->service_item)
                                                            <span class=" bg-gradient-dark text-gradient text-sm font-weight-bold">({{$services->service_group_name}})</span>
                                                            @endif
                                                        </h6>
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
                                                        <h6 class="text-md font-weight-bolder font-weight-bold mb-2">
                                                            @if($services->service_item)
                                                            <span class="text-sm {{config('global.item_status_text_class')[$services->job_status]}} text-gradient pb-2 px-0">{{config('global.item_status')[$services->job_status]}}</span> 
                                                            @else
                                                            <span class="badge text-sm {{config('global.jobs.status_btn_class')[$services->job_status]}} text-gradient pb-2 px-0">{{config('global.jobs.status')[$services->job_status]}}</span> 
                                                            @endif
                                                        </h6>
                                                        @if($services->is_removed==1)
                                                        <span class="mt-4 badge badge-md bg-gradient-danger"> <i class="fas fa-trash text-white me-2" aria-hidden="true"></i> Removeed</span>
                                                        @else
                                                            @if($services->service_item)
                                                                @if($services->job_status==1)
                                                                <a class="btn btn-link text-dark px-3 mb-0 float-end" wire:click="removeService('{{$services}}')"><span class="mt-4 badge badge-md bg-gradient-danger"> <i class="fas fa-trash text-white me-2" aria-hidden="true"></i> Remove Now</span></a>
                                                                @endif
                                                                @if($services->job_status==3)
                                                                <span class="mt-2 badge badge-md {{config('global.item_status_text_class')[$services->job_status]}} float-end">{{config('global.item_status')[$services->job_status]}}</span>
                                                                @else
                                                                <a class="btn btn-link text-dark p-0 mb-0 float-end" wire:click="updateService('{{$services}}')"><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Update to: <span class="mt-4 badge badge-md {{config('global.item_status_text_class')[$services->job_status+1]}}">{{config('global.item_status')[$services->job_status+1]}}</span></a>
                                                                @endif
                                                            @else
                                                                @if($services->job_status==0)
                                                                <a class="btn btn-link text-dark px-3 mb-0 float-end" wire:click="removeService('{{$services}}')"><span class="mt-4 badge badge-md bg-gradient-danger"> <i class="fas fa-trash text-white me-2" aria-hidden="true"></i> Remove</span></a>
                                                                @endif
                                                                @if($services->job_status==4)
                                                                <span class="mt-2 mb-2 badge badge-md {{config('global.jobs.status_btn_class')[$services->job_status]}} ">{{config('global.jobs.status')[$services->job_status]}}</span>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                                <hr class="horizontal dark mt-0 mb-3">
                                                @if($services->service_group_code=='QW')
                                                    @if($services->job_status==1)
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <h4 class="mb-2 text-sm text-left">Front Side</h4>
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

                                                            <h4 class="mt-3 text-sm text-left">Rear Side</h4>
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
                                                        <div class="col-md-4">
                                                            <h4 class="mb-2 text-sm text-left">Left Side</h4>
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

                                                            <h4 class="mt-3 text-sm text-lefft">Right Side</h4>
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
                                                        <div class="col-md-4">
                                                            <h4 class="mb-2 text-sm text-left">Inner Cabin</h4>
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
                                                            <!-- <a class="btn btn-link text-dark p-0 mb-0 float-end" wire:click="updateQwService('{{$services}}')">
                                                                <button class="mt-4 btn btn-sm {{config('global.jobs.status_btn_class')[$services->job_status+1]}}">{{config('global.jobs.status')[$services->job_status+1]}}</button>
                                                            </a> -->
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if($services->job_status!=4)
                                                    <a class="btn btn-link text-dark p-0 mb-0 float-end" wire:click="updateQwService('{{$services}}')">
                                                        <button class="mt-4 btn btn-sm {{config('global.jobs.status_btn_class')[$services->job_status+1]}}">{{config('global.jobs.status')[$services->job_status+1]}}</button>
                                                    </a>
                                                    @endif
                                                @endif


                                                
                                                @if( ($services->service_group_code=='GS' || $services->service_group_code=='QL')) 
                                                    @if($services->job_status==1)
                                                    <div class="row">
                                                        @if($services->service_group_code=='GS')
                                                        
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
                                                                                <button class="btn btn-icon btn-3 btn-info" type="button" wire:click="clickQlOperation('start','pre_finishing','{{$services}}')">
                                                                                    <span class="btn-inner--icon"><i class="ni ni-button-play"></i></span>
                                                                                    <span class="btn-inner--text">Start</span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        @elseif($services->pre_finishing == 1)
                                                                        <div class="col-md-6">
                                                                            <label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->pre_finishing_time_in)->format('dS M Y H:i A') }}</label>
                                                                            <div class="form-group">
                                                                                <button class="btn btn-icon btn-3 btn-primary" type="button" wire:click="clickQlOperation('stop','pre_finishing','{{$services}}')">
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
                                                                                <button class="btn btn-icon btn-3 btn-info" type="button" wire:click="clickQlOperation('start','finishing','{{$services}}')">
                                                                                    <span class="btn-inner--icon"><i class="ni ni-button-play"></i></span>
                                                                                    <span class="btn-inner--text">Start</span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        @elseif($services->finishing == 1)
                                                                        <div class="col-md-12">
                                                                            <label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->finishing_time_in)->format('dS M Y H:i A') }}</label>
                                                                            <div class="form-group">
                                                                                <button class="btn btn-icon btn-3 btn-primary" type="button" wire:click="clickQlOperation('stop','finishing','{{$services}}')">
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
                                                                                <button class="btn btn-icon btn-3 btn-info" type="button" wire:click="clickQlOperation('start','glazing','{{$services}}')">
                                                                                    <span class="btn-inner--icon"><i class="ni ni-button-play"></i></span>
                                                                                    <span class="btn-inner--text">Start</span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        @elseif($services->glazing == 1)
                                                                        <div class="col-md-12">
                                                                            <label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->glazing_time_in)->format('dS M Y H:i A') }}</label>
                                                                            <div class="form-group">
                                                                                <button class="btn btn-icon btn-3 btn-primary" type="button" wire:click="clickQlOperation('stop','glazing','{{$services}}')">
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
                                                                                <button class="btn btn-icon btn-3 btn-info" type="button" wire:click="clickQlOperation('start','seat_cleaning','{{$services}}')">
                                                                                    <span class="btn-inner--icon"><i class="ni ni-button-play"></i></span>
                                                                                    <span class="btn-inner--text">Start</span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        @elseif($services->seat_cleaning == 1)
                                                                        <div class="col-md-12">
                                                                            <label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->seat_cleaning_time_in)->format('dS M Y H:i A') }}</label>
                                                                            <div class="form-group">
                                                                                <button class="btn btn-icon btn-3 btn-primary" type="button" wire:click="clickQlOperation('stop','seat_cleaning','{{$services}}')">
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
                                                                        @if($services->interior_cleaning==null)
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <button class="btn btn-icon btn-3 btn-info" type="button" wire:click="clickQlOperation('start','interior_cleaning','{{$services}}')">
                                                                                    <span class="btn-inner--icon"><i class="ni ni-button-play"></i></span>
                                                                                    <span class="btn-inner--text">Start</span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        @elseif($services->interior_cleaning == 1)
                                                                        <div class="col-md-12">
                                                                            <label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->interior_cleaning_time_in)->format('dS M Y H:i A') }}</label>
                                                                            <div class="form-group">
                                                                                <button class="btn btn-icon btn-3 btn-primary" type="button" wire:click="clickQlOperation('stop','interior_cleaning','{{$services}}')">
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
                                                                                <button class="btn btn-icon btn-3 btn-info" type="button" wire:click="clickQlOperation('start','oil_change','{{$services}}')">
                                                                                    <span class="btn-inner--icon"><i class="ni ni-button-play"></i></span>
                                                                                    <span class="btn-inner--text">Start</span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        @elseif($services->oil_change == 1)
                                                                        <div class="col-md-12">
                                                                            <label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->oil_change_time_in)->format('dS M Y H:i A') }}</label>
                                                                            <div class="form-group">
                                                                                <button class="btn btn-icon btn-3 btn-primary" type="button" wire:click="clickQlOperation('stop','oil_change','{{$services}}')">
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
                                                                                <button class="btn btn-icon btn-3 btn-info" type="button" wire:click="clickQlOperation('start','wash_service','{{$services}}')">
                                                                                    <span class="btn-inner--icon"><i class="ni ni-button-play"></i></span>
                                                                                    <span class="btn-inner--text">Start</span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        @elseif($services->wash_service == 1)
                                                                        <div class="col-md-12">
                                                                            <label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->wash_service_time_in)->format('dS M Y H:i A') }}</label>
                                                                            <div class="form-group">
                                                                                <button class="btn btn-icon btn-3 btn-primary" type="button" wire:click="clickQlOperation('stop','wash_service','{{$services}}')">
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
                                                                                <button class="btn btn-icon btn-3 btn-info" type="button" wire:click="clickQlOperation('start','oil_change','{{$services}}')">
                                                                                    <span class="btn-inner--icon"><i class="ni ni-button-play"></i></span>
                                                                                    <span class="btn-inner--text">Start</span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        @elseif($services->oil_change == 1)
                                                                        <div class="col-md-12">
                                                                            <label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->oil_change_time_in)->format('dS M Y H:i A') }}</label>
                                                                            <div class="form-group">
                                                                                <button class="btn btn-icon btn-3 btn-primary" type="button" wire:click="clickQlOperation('stop','oil_change','{{$services}}')">
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
                                                                                <button class="btn btn-icon btn-3 btn-info" type="button" wire:click="clickQlOperation('start','wash_service','{{$services}}')">
                                                                                    <span class="btn-inner--icon"><i class="ni ni-button-play"></i></span>
                                                                                    <span class="btn-inner--text">Start</span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        @elseif($services->wash_service == 1)
                                                                        <div class="col-md-12">
                                                                            <label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->wash_service_time_in)->format('dS M Y H:i A') }}</label>
                                                                            <div class="form-group">
                                                                                <button class="btn btn-icon btn-3 btn-primary" type="button" wire:click="clickQlOperation('stop','wash_service','{{$services}}')">
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
                                                        @if($services->service_group_code=='GS')

                                                        <a class="btn btn-link text-dark p-0 mb-0 float-end" wire:click="updateGSService('{{$services}}')">
                                                            <button class="mt-4 btn btn-sm {{config('global.jobs.status_btn_class')[$services->job_status+1]}}">{{config('global.jobs.status')[$services->job_status+1]}}</button>
                                                        </a>
                                                        @elseif($services->service_group_code=='QL')
                                                        <a class="btn btn-link text-dark p-0 mb-0 float-end" wire:click="updateQLService('{{$services}}')">
                                                            <button class="mt-4 btn btn-sm {{config('global.jobs.status_btn_class')[$services->job_status+1]}}">{{config('global.jobs.status')[$services->job_status+1]}}</button>
                                                        </a>
                                                        @endif
                                                    @endif

                                                    
                                                

                                                @endif
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
                            </div>
                            <div class="col-md-12" style="display:none;">
                                <div class="card h-100 my-2">
                                    <div class="card-header pb-0">
                                        <h6>Service History overview</h6>
                                        <p class="text-sm">
                                            <span class="font-weight-bold">#{{$job_number}}</span>
                                        </p>
                                        <hr class="m-0">
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="timeline timeline-one-side">
                                            @forelse( $customerjoblogs as $logs)
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
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <!-- <button type="submit" class="btn bg-gradient-primary">Submit</button> -->
            </div>
       </div>
    </div>
</div>
