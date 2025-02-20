<style>
    .modal-dialog {
        max-width: 90% !important;
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
                    @if($jobcardDetails->payment_status==0)
                      <button wire:click="addNewServiceItemsJob('{{$jobcardDetails->job_number}}')" type="button" class="btn bg-gradient-primary btn-sm mb-0 float-end cursor-pointer">Add New Service/Items</button>
                    @endif
                        <i class="far fa-calendar-alt me-2" aria-hidden="true"></i>
                        <small>{{ \Carbon\Carbon::parse($jobcardDetails->job_date_time)->format('dS M Y h:i A') }}</small>
                      <a  class="cursor-pointer" data-bs-dismiss="modal"><i class="text-danger fa-solid fa-circle-xmark fa-xxl" style="font-size:2rem;"></i></a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <a href="javascript:;" class="">
                            <div class="card card-background mb-4" style="align-items: inherit;">
                                <!-- move-on-hover-->
                                <div class="full-background" style="background-image: url('{{url("public/storage/".$jobcardDetails->vehicle_image)}}')"></div>
                                <div class="card-body pt-2">
                                    @if($jobcardDetails->customerInfo['TenantName'])
                                    <h4 class="text-white mb-0 pb-0 text-white">{{$jobcardDetails->customerInfo['TenantName']}}</h4>
                                    @else
                                    Guest
                                    @endif
                                    @if($jobcardDetails->customerInfo['Mobile'])
                                        <p class="mt-0 pt-0 mb-0 pb-0 text-white"><small>{{$jobcardDetails->customerInfo['Mobile']}}</small></p>
                                    @endif
                                    @if($jobcardDetails->customerInfo['Email'])
                                        <p class="mt-0 pt-0 mb-0 pb-0 text-white"><small>{{$jobcardDetails->customerInfo['Email']}}</small></p>
                                    @endif
                                    <!--ID image-->
                                    <hr class="horizontal dark mt-3">
                                    <p class="mb-0 text-white">{{isset($jobcardDetails->makeInfo)?$jobcardDetails->makeInfo['vehicle_name']:''}}, {{isset($jobcardDetails->modelInfo['vehicle_model_name'])?$jobcardDetails->modelInfo['vehicle_model_name']:''}}</p>
                                    <p class="text-white">{{$jobcardDetails->plate_number}}</p>
                                    <p class="mb-0 text-white">Chassis Number: {{$jobcardDetails->chassis_number}}</p>
                                    <p class="text-white">K.M Reading: {{$jobcardDetails->vehicle_km}}</p>
                                    <ul class="list-group">
                                        <!-- Job Status -->
                                        <li class="list-group-item border-0 p-0 pb-0 mb-0 bg-transparent border-radius-lg">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="float-start icon icon-shape icon-xs rounded-circle {{config('global.jobs.status_btn_class')[$jobcardDetails->job_status]}} shadow text-center m-2">
                                                        <i class="fa-solid fa-car-on  opacity-10" aria-hidden="true"></i>
                                                    </div>
                                                    @if($jobcardDetails->job_status)
                                                    <h6 class="my-2 text-sm text-white"><span class="text-sm badge badge-sm {{config('global.jobs.status_btn_class')[$jobcardDetails->job_status]}} pb-2">{{config('global.jobs.status')[$jobcardDetails->job_status]}}</span> 
                                                    </h6>
                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                        <!-- Payment Status -->
                                        <li class="list-group-item border-0 p-0 mb-0 bg-transparent border-radius-lg">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    
                                                    <div class="float-start icon icon-shape icon-xs rounded-circle {{config('global.payment.status_class')[$jobcardDetails->payment_status]}} shadow text-center m-2">
                                                        @if($jobcardDetails->payment_type)
                                                        <i class="{{config('global.payment.icons')[$jobcardDetails->payment_type]}} opacity-10" aria-hidden="true"></i>
                                                        @endif
                                                    </div>
                                                    <h6 class="my-2 text-sm text-white">
                                                        @if($jobcardDetails->payment_type) <span class="badge badge-sm {{config('global.payment.status_class')[$jobcardDetails->payment_status]}} text-sm btn-sm"> {{config('global.payment.type')[$jobcardDetails->payment_type]}} {{config('global.payment.status')[$jobcardDetails->payment_status]}}</span>
                                                        @endif
                                                    </h6>
                                                    
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">

                                                    @if($jobcardDetails->payment_status==0 && $jobcardDetails->payment_type==1)
                                                    
                                                    <div class=" float-start">
                                                        @if($jobcardDetails->payment_type==1 && $jobcardDetails->payment_status==0)
                                                        <button type="button" wire:click="resendPaymentLink('{{$jobcardDetails->job_number}}')" class="mt-2 btn btn-sm bg-gradient-success px-2">Re send Payment link</button>
                                                        <button type="button" wire:click="checkPaymentStatus('{{$jobcardDetails->job_number}}','{{$jobOrderReference}}','{{$jobcardDetails->stationInfo['StationID']}}')" class="mt-2 btn btn-sm bg-gradient-info px-2">Check Payment Status</button>
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
                                        <!-- CheckList Status -->
                                        @if($jobcardDetails->checklistInfo!=null)
                                        <li class="list-group-item border-0  p-2 mb-2 bg-transparent border-radius-lg">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="d-flex">
                                                        @if($showVehicleImageDetails)
                                                        <button type="button" class="btn btn-sm bg-gradient-danger mb-0 me-2" wire:click="closeVehicleImageDetails">
                                                        Close Vehicle images and checklists
                                                        </button>
                                                        @else
                                                        <button type="button" class="btn btn-sm bg-gradient-primary mb-0 me-2" wire:click="openVehicleImageDetails">
                                                        Show Vehicle images and checklists
                                                        </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @if($jobcardDetails->checklistInfo['fuel'])
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="float-start icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center m-2">
                                                        <i class="fa-solid fa-gas-pump opacity-10" aria-hidden="true"></i>
                                                    </div>
                                                    <h6 class="my-2 text-sm text-white">
                                                        Fuel: <span class="text-sm  pb-2">{{config('global.fuel')[$jobcardDetails->checklistInfo['fuel']]}}</span>
                                                    </h6>
                                                </div>
                                            </div>
                                            @endif
                                        </li>
                                        @endif
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
                                                                    <!-- <div class="card-header pb-0 p-2">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <h6 class="mb-0">Billing Summary</h6>
                                                                            </div>
                                                                            <div class="col-md-6 d-flex justify-content-end align-items-center">
                                                                                <i class="far fa-calendar-alt me-2" aria-hidden="true"></i>
                                                                                <small>{{ \Carbon\Carbon::parse($jobcardDetails->job_date_time)->format('dS M Y h:i A') }}</small>
                                                                            </div>
                                                                        </div>
                                                                    </div> -->
                                                                    <div class="card-body pt-4 p-2">
                                                                        <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-0">Items/Services</h6>
                                                                        <ul class="list-group">
                                                                            <?php $discountPS=0;?>
                                                                            @foreach($jobcardDetails->customerJobServices as $serviceItems)
                                                                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                                                <div class="d-flex align-items-left">
                                                                                    <button class="btn btn-icon-only btn-rounded  mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-right" aria-hidden="true"></i></button>
                                                                                    <div class="d-flex">
                                                                                        <h6 class="mb-1 text-dark text-sm">{{$serviceItems->item_name}}<br>
                                                                                        <small>
                                                                                            {{$serviceItems->item_code}} 
                                                                                            @if($serviceItems->department_name) - {{$serviceItems->department_name}} @endif
                                                                                        </small>
                                                                                        @if($serviceItems->discount_code)
                                                                                        <label class="badge bg-gradient-info cursor-pointer badge-sm">{{strtolower($serviceItems->discount_title)}} {{ $serviceItems->discount_percentage }}% Off </label>
                                                                                        @endif
                                                                                        </h6>
                                                                                        
                                                                                    </div>
                                                                                </div>
                                                                                <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                                                                                    <div class="d-flex mx-2">
                                                                                        {{$serviceItems->quantity}} x {{round($serviceItems->total_price,2)}}
                                                                                    </div>
                                                                                    <div class="d-none d-flex">
                                                                                        <span>
                                                                                        
                                                                                        {{config('global.CURRENCY')}} {{round($serviceItems->grand_total,2)}}
                                                                                        
                                                                                    </span>
                                                                                    </div>
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
                                                                                {{config('global.CURRENCY')}} {{round($jobcardDetails->total_price,2)}}
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
                                                                                {{config('global.CURRENCY')}} {{round($jobcardDetails->vat,2)}}
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
                                                                                {{config('global.CURRENCY')}} {{round(($jobcardDetails->grand_total),2)}}
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
                @if($showVehicleImageDetails)
                <div class="row">
                    <div class="col-12 col-md-6 col-xl-4 my-4">
                        <div class="card h-100">
                            <div class="card-header pb-0 p-3">
                                
                            </div>
                            <div class="card-body p-3">
                                <h6 class="mb-0">Check List</h6>
                                <ul class="list-group">
                                    @foreach($checklistLabels as $clKey => $checklist)
                                    <li class="list-group-item border-0 px-0">
                                        <div class="form-check form-switch ps-0">
                                            <input class="form-check-input ms-auto" type="checkbox" id="checkList{{ str_replace(" ","",$checklist->checklist_label) }}" disabled @if(isset($vehicleCheckedChecklist[$checklist->id])) checked="" @endif>
                                            <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="checkList{{ str_replace(" ","",$checklist->checklist_label) }}">{{$checklist->checklist_label}}</label>
                                        </div>
                                    </li>
                                    @endforeach
                                    <p>Note: Minor surface scratches defects, stone chipping, scratches on glasses etc. are included</p>
                                </ul>
                                <hr class="horizontal gray-light my-4 mb-4">
                                <h6 class="mb-0">Found</h6>
                                <p class="text-sm">{{$checkListDetails->scratches_found}}</p>

                                <h6 class="mt-3">Not Found</h6>
                                <p class="text-sm">{{$checkListDetails->scratches_notfound}}</p>
                                <hr class="horizontal gray-light my-4 mb-4">
                            </div>
                        </div>
                    </div>
                    @if($checkListDetails['turn_key_on_check_for_fault_codes'] || $checkListDetails['start_engine_observe_operation'] || $checkListDetails['reset_the_service_reminder_alert'] || $checkListDetails['stick_update_service_reminder_sticker_on_b_piller'] || $checkListDetails['interior_cabin_inspection_comments'])
                    <div class="col-12 col-md-6 col-xl-4 my-4">
                        <div class="card h-100">
                            <div class="card-header pb-0 p-3">
                                
                            </div>
                            <div class="card-body p-3">
                                <h6 class="mt-4 mb-0">Interior Cabin Inspection</h6>
                                <div class="row"> 
                                    <label>Turn key on - check for fault codes</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="turn_key_on_check_for_fault_codes" value="1" id="turn_key_on_check_for_fault_codes1" disabled>
                                            <label class="custom-control-label" for="turn_key_on_check_for_fault_codes1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="turn_key_on_check_for_fault_codes" value="2" id="turn_key_on_check_for_fault_codes2" disabled>
                                            <label class="custom-control-label" for="turn_key_on_check_for_fault_codes2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="turn_key_on_check_for_fault_codes" value="3" id="turn_key_on_check_for_fault_codes3" disabled>
                                            <label class="custom-control-label" for="turn_key_on_check_for_fault_codes3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('turn_key_on_check_for_fault_codes') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Start Engine - observe operation</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="start_engine_observe_operation" value="1" id="start_engine_observe_operation1" disabled>
                                            <label class="custom-control-label" for="start_engine_observe_operation1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="start_engine_observe_operation" value="2" id="start_engine_observe_operation2" disabled>
                                            <label class="custom-control-label" for="start_engine_observe_operation2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="start_engine_observe_operation" value="3" id="start_engine_observe_operation3" disabled>
                                            <label class="custom-control-label" for="start_engine_observe_operation3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('start_engine_observe_operation') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Reset the Service Reminder Alert</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="reset_the_service_reminder_alert" value="1" id="reset_the_service_reminder_alert1" disabled>
                                            <label class="custom-control-label" for="reset_the_service_reminder_alert1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="reset_the_service_reminder_alert" value="2" id="reset_the_service_reminder_alert2" disabled>
                                            <label class="custom-control-label" for="reset_the_service_reminder_alert2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="reset_the_service_reminder_alert" value="3" id="reset_the_service_reminder_alert3" disabled>
                                            <label class="custom-control-label" for="reset_the_service_reminder_alert3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('reset_the_service_reminder_alert') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Stick & Update Service Reminder Sticker on B-Piller</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="stick_update_service_reminder_sticker_on_b_piller" value="1" id="stick_update_service_reminder_sticker_on_b_piller1" disabled>
                                            <label class="custom-control-label" for="stick_update_service_reminder_sticker_on_b_piller1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="stick_update_service_reminder_sticker_on_b_piller" value="2" id="stick_update_service_reminder_sticker_on_b_piller2" disabled>
                                            <label class="custom-control-label" for="stick_update_service_reminder_sticker_on_b_piller2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="stick_update_service_reminder_sticker_on_b_piller" value="3" id="stick_update_service_reminder_sticker_on_b_piller3" disabled>
                                            <label class="custom-control-label" for="stick_update_service_reminder_sticker_on_b_piller3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('stick_update_service_reminder_sticker_on_b_piller') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Comments</label>
                                    <div class="col-md-12">
                                        <div class="form-check mb-3 ps-0">
                                            <textarea class="form-control" id="interior_cabin_inspection_comments" wire:model="interior_cabin_inspection_comments" disabled rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($checkListDetails['check_power_steering_fluid_level'] || $checkListDetails['check_power_steering_tank_cap_properly_fixed'] || $checkListDetails['check_brake_fluid_level'] || $checkListDetails['brake_fluid_tank_cap_properly_fixed'] || $checkListDetails['check_engine_oil_level'] || $checkListDetails['check_radiator_cap_properly_fixed'] || $checkListDetails['top_off_windshield_washer_fluid']
                     || $checkListDetails['check_windshield_cap_properly_fixed']
                     || $checkListDetails['underHoodInspectionComments'])
                    <div class="col-12 col-md-6 col-xl-4 my-4">
                        <div class="card h-100">
                            <div class="card-header text-left pt-4 pb-3">
                                <h5 class="font-weight-bold mt-2">Under Hood Inspection</h5>
                            </div>
                            <div class="card-body text-left pt-0">
                                <div class="row"> 
                                    <label>Check Power Steering Fluid Level</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_power_steering_fluid_level" value="1" id="check_power_steering_fluid_level1" disabled>
                                            <label class="custom-control-label" for="check_power_steering_fluid_level1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_power_steering_fluid_level" value="2" id="check_power_steering_fluid_level2" disabled>
                                            <label class="custom-control-label" for="check_power_steering_fluid_level2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_power_steering_fluid_level" value="3" id="check_power_steering_fluid_level3" disabled>
                                            <label class="custom-control-label" for="check_power_steering_fluid_level3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('check_power_steering_fluid_level') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Check Power Steering tank Cap properly fixed</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_power_steering_tank_cap_properly_fixed" value="1" id="check_power_steering_tank_cap_properly_fixed1" disabled>
                                            <label class="custom-control-label" for="check_power_steering_tank_cap_properly_fixed1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_power_steering_tank_cap_properly_fixed" value="2" id="check_power_steering_tank_cap_properly_fixed2" disabled>
                                            <label class="custom-control-label" for="check_power_steering_tank_cap_properly_fixed2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_power_steering_tank_cap_properly_fixed" value="3" id="check_power_steering_tank_cap_properly_fixed3" disabled>
                                            <label class="custom-control-label" for="check_power_steering_tank_cap_properly_fixed3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('check_power_steering_tank_cap_properly_fixed') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Check Brake fluid level</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_brake_fluid_level" value="1" id="check_brake_fluid_level1" disabled>
                                            <label class="custom-control-label" for="check_brake_fluid_level1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_brake_fluid_level" value="2" id="check_brake_fluid_level2" disabled>
                                            <label class="custom-control-label" for="check_brake_fluid_level2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_brake_fluid_level" value="3" id="check_brake_fluid_level3" disabled>
                                            <label class="custom-control-label" for="check_brake_fluid_level3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('check_brake_fluid_level') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Check Brake fluid tank Cap properly fixed</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="brake_fluid_tank_cap_properly_fixed" value="1" id="brake_fluid_tank_cap_properly_fixed1" disabled>
                                            <label class="custom-control-label" for="brake_fluid_tank_cap_properly_fixed1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="brake_fluid_tank_cap_properly_fixed" value="2" id="brake_fluid_tank_cap_properly_fixed2" disabled>
                                            <label class="custom-control-label" for="brake_fluid_tank_cap_properly_fixed2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="brake_fluid_tank_cap_properly_fixed" value="3" id="brake_fluid_tank_cap_properly_fixed3" disabled>
                                            <label class="custom-control-label" for="brake_fluid_tank_cap_properly_fixed3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('brake_fluid_tank_cap_properly_fixed') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Check Engine Oil Level</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_engine_oil_level" value="1" id="check_engine_oil_level1" disabled>
                                            <label class="custom-control-label" for="check_engine_oil_level1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_engine_oil_level" value="2" id="check_engine_oil_level2" disabled>
                                            <label class="custom-control-label" for="check_engine_oil_level2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_engine_oil_level" value="3" id="check_engine_oil_level3" disabled>
                                            <label class="custom-control-label" for="check_engine_oil_level3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('check_engine_oil_level') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Check Radiator Coolant Level</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_radiator_coolant_level" value="1" id="check_radiator_coolant_level1" disabled>
                                            <label class="custom-control-label" for="check_radiator_coolant_level1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_radiator_coolant_level" value="2" id="check_radiator_coolant_level2" disabled>
                                            <label class="custom-control-label" for="check_radiator_coolant_level2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_radiator_coolant_level" value="3" id="check_radiator_coolant_level3" disabled>
                                            <label class="custom-control-label" for="check_radiator_coolant_level3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('check_radiator_coolant_level') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Check Radiator Cap properly fixed</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_radiator_cap_properly_fixed" value="1" id="check_radiator_cap_properly_fixed1" disabled>
                                            <label class="custom-control-label" for="check_radiator_cap_properly_fixed1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_radiator_cap_properly_fixed" value="2" id="check_radiator_cap_properly_fixed2" disabled>
                                            <label class="custom-control-label" for="check_radiator_cap_properly_fixed2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_radiator_cap_properly_fixed" value="3" id="check_radiator_cap_properly_fixed3" disabled>
                                            <label class="custom-control-label" for="check_radiator_cap_properly_fixed3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('check_radiator_cap_properly_fixed') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Top off windshield washer fluid</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="top_off_windshield_washer_fluid" value="1" id="top_off_windshield_washer_fluid1" disabled>
                                            <label class="custom-control-label" for="top_off_windshield_washer_fluid1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="top_off_windshield_washer_fluid" value="2" id="top_off_windshield_washer_fluid2" disabled>
                                            <label class="custom-control-label" for="top_off_windshield_washer_fluid2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="top_off_windshield_washer_fluid" value="3" id="top_off_windshield_washer_fluid3" disabled>
                                            <label class="custom-control-label" for="top_off_windshield_washer_fluid3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('top_off_windshield_washer_fluid') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Check windshield Cap properly fixed</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_windshield_cap_properly_fixed" value="1" id="check_windshield_cap_properly_fixed1" disabled>
                                            <label class="custom-control-label" for="check_windshield_cap_properly_fixed1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_windshield_cap_properly_fixed" value="2" id="check_windshield_cap_properly_fixed2" disabled>
                                            <label class="custom-control-label" for="check_windshield_cap_properly_fixed2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_windshield_cap_properly_fixed" value="3" id="check_windshield_cap_properly_fixed3" disabled>
                                            <label class="custom-control-label" for="check_windshield_cap_properly_fixed3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('check_windshield_cap_properly_fixed') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Comments</label>
                                    <div class="col-md-12">
                                        <div class="form-check mb-3 ps-0">
                                            <textarea class="form-control" id="underHoodInspectionComments" wire:model="underHoodInspectionComments" disabled rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($checkListDetails['check_for_oil_leaks_engine_steering'] || $checkListDetails['check_for_oil_leak_oil_filtering'] || $checkListDetails['check_drain_lug_fixed_properly'] || $checkListDetails['check_oil_filter_fixed_properly'] || $checkListDetails['ubi_comments'])
                    <div class="col-12 col-md-6 col-xl-4 my-4">
                        <div class="card h-100">
                            <div class="card-header text-left pt-4 pb-3">
                                <h5 class="font-weight-bold mt-2">Under Body Inspection</h5>
                            </div>
                            <div class="card-body text-left pt-0">
                                <div class="row"> 
                                    <label>Check for Oil leaks - Engine, Steering</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_for_oil_leaks_engine_steering" value="1" id="check_for_oil_leaks_engine_steering1" disabled>
                                            <label class="custom-control-label" for="check_for_oil_leaks_engine_steering1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_for_oil_leaks_engine_steering" value="2" id="check_for_oil_leaks_engine_steering2" disabled>
                                            <label class="custom-control-label" for="check_for_oil_leaks_engine_steering2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_for_oil_leaks_engine_steering" value="3" id="check_for_oil_leaks_engine_steering3" disabled>
                                            <label class="custom-control-label" for="check_for_oil_leaks_engine_steering3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('check_for_oil_leaks_engine_steering') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Check for Oil Leak - Oil Filtering</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_for_oil_leak_oil_filtering" value="1" id="check_for_oil_leak_oil_filtering1" disabled>
                                            <label class="custom-control-label" for="check_for_oil_leak_oil_filtering1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_for_oil_leak_oil_filtering" value="2" id="check_for_oil_leak_oil_filtering2" disabled>
                                            <label class="custom-control-label" for="check_for_oil_leak_oil_filtering2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_for_oil_leak_oil_filtering" value="3" id="check_for_oil_leak_oil_filtering3" disabled>
                                            <label class="custom-control-label" for="check_for_oil_leak_oil_filtering3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('check_for_oil_leak_oil_filtering') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Check Drain Plug fixed properly</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_drain_lug_fixed_properly" value="1" id="check_drain_lug_fixed_properly1" disabled>
                                            <label class="custom-control-label" for="check_drain_lug_fixed_properly1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_drain_lug_fixed_properly" value="2" id="check_drain_lug_fixed_properly2" disabled>
                                            <label class="custom-control-label" for="check_drain_lug_fixed_properly2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_drain_lug_fixed_properly" value="3" id="check_drain_lug_fixed_properly3" disabled>
                                            <label class="custom-control-label" for="check_drain_lug_fixed_properly3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('check_drain_lug_fixed_properly') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Check Oil Filter fixed properly</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_oil_filter_fixed_properly" value="1" id="check_oil_filter_fixed_properly1" disabled>
                                            <label class="custom-control-label" for="check_oil_filter_fixed_properly1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_oil_filter_fixed_properly" value="2" id="check_oil_filter_fixed_properly2" disabled>
                                            <label class="custom-control-label" for="check_oil_filter_fixed_properly2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_oil_filter_fixed_properly" value="3" id="check_oil_filter_fixed_properly3" disabled>
                                            <label class="custom-control-label" for="check_oil_filter_fixed_properly3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('check_oil_filter_fixed_properly') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Comments</label>
                                    <div class="col-md-12">
                                        <div class="form-check mb-3 ps-0">
                                            <textarea class="form-control" id="ubi_comments" wire:model="ubi_comments" rows="3" disabled></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    
                
                    <div class="col-12 col-md-12 col-xl-6 my-4">
                        <div class="card">
                            <div class="card-header text-center pt-4 pb-3">
                                <h5 class="font-weight-bold mt-2">Vehicle Sides Images</h5>
                            </div>
                            
                            
                            <div class="card-body text-left pt-0">
                                <div class="row">
                                    {{$vehicleSidesImages}}
                                    <div class="col-md-6 col-sm-6">
                                        <input type="file" id="img1File" wire:model="vImageR1" accept="image/*" capture style="display:block"/>
                                        <img class="w-75 float-end" id="img1" src="@if($vehicleSidesImages['vImageR1']) {{ url('public/storage/'.$vehicleSidesImages['vImageR1'])}} @else {{asset('img/checklist/car1.png')}} @endif" style="cursor:pointer" wire:click="markScrach('img1')" />
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="file" id="img2File" wire:model="vImageR2" accept="image/*" capture style="display:block"/>
                                        <img class="w-75 float-start" id="img2" src="@if ($vehicleSidesImages['vImageR2']) {{ url('public/storage/'.$vehicleSidesImages['vImageR2']) }} @else {{asset('img/checklist/car2.png')}} @endif" style="cursor:pointer" wire:click="markScrach('img2')" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <input type="file" id="vImageFFile" wire:model="vImageF" accept="image/*" capture style="display:block"/>
                                        <img class="w-75 float-end" id="img3" src="@if ($vehicleSidesImages['vImageF']) {{ url('public/storage/'.$vehicleSidesImages['vImageF']) }} @else {{asset('img/checklist/car3.jpg')}} @endif" style="cursor:pointer" wire:click="markScrach('img3')" />
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="file" id="vImageBFile" wire:model="vImageB" accept="image/*" capture style="display:block"/>
                                        <img class="w-75 float-start" id="img4" src="@if ($vehicleSidesImages['vImageB']) {{ url('public/storage/'.$vehicleSidesImages['vImageB']) }} @else {{asset('img/checklist/car4.jpg')}} @endif" style="cursor:pointer" wire:click="markScrach('img4')" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <input type="file" id="vImageL1File" wire:model="vImageL1" accept="image/*" capture style="display:block"/>
                                        <img class="w-75 float-end" id="img5" src="@if ($vehicleSidesImages['vImageL1']) {{ url('public/storage/'.$vehicleSidesImages['vImageL1']) }} @else {{asset('img/checklist/car5.png')}} @endif" style="cursor:pointer" wire:click="markScrach('img5')" />
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="file" id="vImageL2File" wire:model="vImageL2" accept="image/*" capture style="display:block"/>
                                        <img class="w-75 float-start" id="img6" src="@if ($vehicleSidesImages['vImageL2']) {{ url('public/storage/'.$vehicleSidesImages['vImageL2']) }} @else {{asset('img/checklist/car6.png')}} @endif" style="cursor:pointer" wire:click="markScrach('img6')" />
                                    </div>
                                </div>

                                @if($jobcardDetails->is_contract==1)
                                <h5 class="font-weight-bold mt-2">Interior Vehicle Images</h5>
                                <div class="row m-4">
                                    <div class="col-md-6 col-sm-6">
                                        <input type="file" id="dashImage1File" wire:model="dash_image1" accept="image/*" capture style="display:block"/>
                                        <img class="img-fluid img-thumbnail shadow" id="dashImage1" src="@if ($vehicleSidesImages['dash_image1']) {{ url('public/storage/'.$vehicleSidesImages['dash_image1']) }} @else {{asset('img/dashImage1.jpg')}} @endif" style="cursor:pointer"  />
                                        @error('dash_image1') <span class="text-danger">Missing Image..!</span> @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="file" id="dashImage2File" wire:model="dash_image2" accept="image/*" capture style="display:block"/>
                                        <img class="img-fluid img-thumbnail shadow" id="dashImage2" src="@if ($vehicleSidesImages['dash_image2']) {{ url('public/storage/'.$vehicleSidesImages['dash_image2']) }} @else {{asset('img/dashImage2.jpg')}} @endif" style="cursor:pointer"  />
                                        @error('dash_image2') <span class="text-danger">Missing Image..!</span> @enderror
                                    </div>
                                    <hr>
                                </div>
                                <div class="row m-4">
                                    <div class="col-md-6 col-sm-6">
                                        <input type="file" id="passengerSeatImageFile" wire:model="passenger_seat_image" accept="image/*" capture style="display:block"/>
                                        <img class="img-fluid img-thumbnail shadow" id="passengerSeatImage" src="@if ($vehicleSidesImages['passenger_seat_image']) {{ url('public/storage/'.$vehicleSidesImages['passenger_seat_image']) }} @else {{asset('img/passangerSeat1.jpg')}} @endif" style="cursor:pointer"  />
                                        @error('passenger_seat_image') <span class="text-danger">Missing Image..!</span> @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="file" id="driverSeatImageFile" wire:model="driver_seat_image" accept="image/*" capture style="display:block"/>
                                        <img class="img-fluid img-thumbnail shadow" id="driverSeatImage" src="@if ($vehicleSidesImages['driver_seat_image']) {{ url('public/storage/'.$vehicleSidesImages['driver_seat_image']) }} @else {{asset('img/driverSeat1.jpg')}} @endif" style="cursor:pointer"  />
                                        @error('driver_seat_image') <span class="text-danger">Missing Image..!</span> @enderror
                                    </div>
                                    <hr>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <input type="file" id="backSeat1ImageFile" wire:model="back_seat1" accept="image/*" capture style="display:block"/>
                                        <img class="img-fluid img-thumbnail shadow" id="backSeat1Image" src="@if ($vehicleSidesImages['back_seat1']) {{ url('public/storage/'.$vehicleSidesImages['back_seat1']) }} @else {{asset('img/backSeat1.jpg')}} @endif" style="cursor:pointer"  />
                                        @error('back_seat1') <span class="text-danger">Missing Image..!</span> @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="file" id="backSeat2ImageFile" wire:model="back_seat2" accept="image/*" capture style="display:block"/>
                                        <img class="img-fluid img-thumbnail shadow" id="backSeat2Image" src="@if ($vehicleSidesImages['back_seat2']) {{ url('public/storage/'.$vehicleSidesImages['back_seat2']) }} @else {{asset('img/backSeat2.jpg')}} @endif" style="cursor:pointer"   />
                                        @error('back_seat2') <span class="text-danger">Missing Image..!</span> @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <input type="file" id="backSeat3ImageFile" wire:model="back_seat3" accept="image/*" capture style="display:block"/>
                                        <img class="img-fluid img-thumbnail shadow" id="backSeat3Image" src="@if ($vehicleSidesImages['back_seat3']) {{ url('public/storage/'.$vehicleSidesImages['back_seat3']) }} @else {{asset('img/backSeat1.jpg')}} @endif" style="cursor:pointer"  />
                                        @error('back_seat3') <span class="text-danger">Missing Image..!</span> @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="file" id="backSeat4ImageFile1" wire:model="back_seat4" accept="image/*" capture style="display:block"/>
                                        <img class="img-fluid img-thumbnail shadow" id="backSeat4Image1" src="@if ($vehicleSidesImages['back_seat4']) {{ url('public/storage/'.$vehicleSidesImages['back_seat4']) }} @else {{asset('img/backSeat2.jpg')}} @endif" style="cursor:pointer"   />
                                        @error('back_seat4') <span class="text-danger">Missing Image..!</span> @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <input type="file" id="backSeat3ImageFile1" wire:model="roof_images" accept="image/*" capture style="display:block"/>
                                        <img class="img-fluid img-thumbnail shadow" id="backSeat3Image1" src="@if ($vehicleSidesImages['roof_images']) {{ url('public/storage/'.$vehicleSidesImages['roof_images']) }} @else {{asset('img/roofimage1.jpg')}} @endif" style="cursor:pointer"  />
                                        @error('roof_images') <span class="text-danger">Missing Image..!</span> @enderror
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <!-- <h6 class="mb-0">Services Information</h6>
                         <hr class="mt-0">
                         --><ul class="list-group">
                            @forelse( $jobcardDetails->customerJobServices as $services)
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
                                                <div class="float-start icon icon-shape icon-xs rounded-circle {{config('global.jobs.status_btn_class')[$services->job_status]}} shadow text-center m-2">
                                                    <i class="fa-solid fa-car-on  opacity-10" aria-hidden="true"></i>
                                                </div>
                                                @if($services->job_status)
                                                <h6 class="my-2 text-sm">
                                                    Job Status: <span class="text-sm {{config('global.jobs.status_text_class')[$services->job_status]}} pb-2">{{config('global.jobs.status')[$services->job_status]}}</span> 
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
                                                @if($services->job_status!=3 && $services->job_status<3)
                                                <a class="btn btn-link text-dark p-0 m-0" wire:click="updateQwService({{$services}})">
                                                    <button class="mt-4 btn btn-sm {{config('global.jobs.status_btn_class')[$services->job_status+1]}}">{{config('global.jobs.status')[$services->job_status+1]}}</button>
                                                </a>
                                                @endif
                                                @if($services->is_removed==1)
                                                <span class="mt-4 badge badge-md bg-gradient-danger"> <i class="fas fa-trash text-white me-2" aria-hidden="true"></i> Removeed</span>
                                                @else
                                                
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
                                        @if($services->service_item_type==1)
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
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <button class="btn btn-icon btn-3 btn-info" type="button" wire:click="clickQlOperation('start','pre_finishing','{{$services->id}}')">
                                                                                <span class="btn-inner--icon"><i class="ni ni-button-play"></i></span>
                                                                                <span class="btn-inner--text">Start</span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    @elseif($services->pre_finishing == 1)
                                                                    <div class="col-md-12">
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
                                        @endif
                                        
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
    <div wire:loading wire:target="checkPaymentStatus">
      <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
        <div class="la-ball-beat">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <div wire:loading wire:target="updateQwService">
      <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
        <div class="la-ball-beat">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <div wire:loading wire:target="addNewServiceItemsJob">
      <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
        <div class="la-ball-beat">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <div wire:loading wire:target="clickQlOperation">
      <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
          <div class="la-ball-beat">
              <div></div>
              <div></div>
              <div></div>
          </div>
      </div>

</div>
