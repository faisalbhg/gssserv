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
                @if($alreadyUpdationGOing)
                    <div class="d-sm-flex justify-content-right float-end">
                        <div class="alert alert-warning" role="alert">
                            <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                            <span class="alert-text"><strong>Warning!</strong> Job updation is pending,</span>
                            <a class="btn btn-outline-danger"  wire:click="addnewItemProceed('{{$jobcardDetails->job_number}}')">Confinue New Update</a>
                            <a href="{{url('customer-service-job/'.$jobcardDetails->customer_id.'/'.$jobcardDetails->vehicle_id.'/'.$jobcardDetails->job_number)}}" class="btn btn-outline-dark" >Open Existing Update</a>
                        </div>
                    </div>
                @endif
                <div class="d-sm-flex justify-content-between">
                    <div>
                      <h5 class=" modal-title" id="serviceUpdateModalLabel">#{{$jobcardDetails->job_number}}</h5>
                        <i class="far fa-calendar-alt me-2" aria-hidden="true"></i>
                        <small>{{ \Carbon\Carbon::parse($jobcardDetails->job_date_time)->format('dS M Y h:i A') }}</small>
                    </div>
                    <div class="d-flex">
                        @if($jobcardDetails->payment_status!=1 && $jobcardDetails->job_status!=4  && $jobcardDetails->job_status!=5 && $updateJob)
                            @if($canceljobReasonButton)
                                <textarea wire:model="cancelationReason" class="form-control" placeholder="Cancelation Reason..!"></textarea>
                                @error('cancelationReason') <span class="text-danger">{{ $message }}</span> @enderror
                                <button type="button" wire:click="confirmCancelJob('{{$jobcardDetails->job_number}}','{{$jobcardDetails->job_status}}')" class="mt-2 btn btn-sm bg-gradient-info px-2 mx-2">Confirm Cancel Job</button>
                            @else
                                @if($jobcardDetails->cancel_req_status==null || $jobcardDetails->cancel_req_status=="R" || $jobcardDetails->cancel_req_status == "A")
                                    <div>
                                        <button type="button" wire:click="cancelJob('{{$jobcardDetails->job_number}}')" class="mt-2 btn btn-sm bg-gradient-danger px-2 mx-2">Cancel Job</button>

                                        @if($jobcardDetails->cancel_req_status=="R")
                                            <label class="mt-2 text-danger px-2 mx-2">Rejected cancellation request</label>
                                        @endif
                                    </div>
                                @elseif($jobcardDetails->cancel_req_status=='W')
                                <button type="button" class="mt-2 btn btn-sm btn-outline-danger px-2 mx-2">Pending Cancelation Request</button>
                                @endif
                                @if($cancelError)<br><span class="text-danger">{{$cancelError}}</span>@endif
                            @endif


                            
                            @if($jobcardDetails->cancel_req_status!='W' && $jobcardDetails->cancel_req_status!='A' || ( $jobcardDetails->cancel_req_status==null ))
                                
                                <button type="button" wire:click="addNewServiceItemsJob('{{$jobcardDetails->job_number}}')" class="mt-2 btn btn-sm bg-gradient-primary px-2">Add New Service/Items</button>
                                
                            @endif
                            
                            
                        @endif
                            
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
                                    @if($jobcardDetails->customer_name)
                                    <h4 class="text-white mb-0 pb-0 text-white">{{$jobcardDetails->customer_name}}</h4>
                                    @else
                                    Guest
                                    @endif
                                    @if($jobcardDetails->customer_mobile)
                                        <p class="mt-0 pt-0 mb-0 pb-0 text-white"><small>{{$jobcardDetails->customer_mobile}}</small></p>
                                    @endif
                                    @if($jobcardDetails->customer_email)
                                        <p class="mt-0 pt-0 mb-0 pb-0 text-white"><small>{{$jobcardDetails->customer_email}}</small></p>
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
                                                        @if($jobcardDetails->cancel_req_status=='W')
                                                            <button type="button" class="mt-2 btn btn-sm btn-outline-danger px-2 mx-2">Pending Cancelation Request</button>
                                                        @endif
                                                        </h6>
                                                    @endif
                                                    <span class="text-sm badge badge-sm {{config('global.jobs.status_btn_class')[$jobcardDetails->job_status]}} pb-2 float-end" wire:click="jobCardStatusUpdate('{{$jobcardDetails->job_number}}')">Update job Status</span>
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
                                                        @if($jobcardDetails->payment_type)
                                                            <span class="badge badge-sm {{config('global.payment.status_class')[$jobcardDetails->payment_status]}} text-sm btn-sm"> {{config('global.payment.type')[$jobcardDetails->payment_type]}} {{config('global.payment.status')[$jobcardDetails->payment_status]}}</span>
                                                        @endif
                                                        @if($jobcardDetails->payment_status==0)
                                                            <button wire:click="checkOnlinePaymentStatus('{{$jobcardDetails->job_number}}','{{$jobcardDetails->stationInfo['StationID']}}')" type="button" class="mt-2 btn btn-sm bg-gradient-info px-2">Check Payment Status</button>
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
                                                                <span class="alert-text"> {{ $message }}</span>
                                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                        @endif
                                                    </h6>
                                                    
                                                </div>
                                            </div>
                                            <!-- <div class="row">
                                                <div class="col-md-12">
                                                    @if($jobcardDetails->payment_status==0)
                                                    <button type="button" wire:click="resendPaymentLink('{{$jobcardDetails->job_number}}')" class="mt-2 btn btn-sm bg-gradient-success px-2">Re send Payment link</button> 
                                                    <a href="https://gsstations.ae/qr/{{$jobcardDetails->job_number}}" ><button wire:click="checkOnlinePaymentStatus('{{$jobcardDetails->job_number}}')" type="button" class="mt-2 btn btn-sm bg-gradient-info px-2">Check Payment Status</button></a>
                                                    @endif
                                                    
                                                </div>
                                            </div> -->
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
                                                        <button type="button" class="btn btn-sm bg-gradient-primary mb-0 me-2" wire:click="openVehicleImageDetails('{{$jobcardDetails->job_number}}')">
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
                                    @if(auth()->user('user')->user_type==1)
                                        @if($showJobsLogseDetails)
                                            <button type="button" class="btn btn-sm bg-gradient-danger mb-0 me-2" wire:click="hideJobLogs('{{$jobcardDetails->job_number}}')">
                                            Close Job Card Logs
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-sm bg-gradient-primary mb-0 me-2" wire:click="showJobLogs('{{$jobcardDetails->job_number}}')">
                                            Show Job Card Logs
                                            </button>
                                        @endif
                                    @endif
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
                                                                                        {{$serviceItems->quantity}} x {{custom_round($serviceItems->total_price)}}
                                                                                    </div>
                                                                                    <div class="d-none d-flex">
                                                                                        <span>
                                                                                        
                                                                                        {{config('global.CURRENCY')}} {{custom_round($serviceItems->grand_total)}}
                                                                                        
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
                                                                                {{config('global.CURRENCY')}} {{custom_round($jobcardDetails->total_price)}}
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
                                                                                {{config('global.CURRENCY')}} {{custom_round($discountPS)}}
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
                                                                                {{config('global.CURRENCY')}} {{custom_round($jobcardDetails->vat)}}
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
                                                                                {{config('global.CURRENCY')}} {{custom_round(($jobcardDetails->grand_total))}}
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
                @if($showJobsLogseDetails)

                @endif

                @if($showVehicleImageDetails)
                    <div class="row">
                        <div class="col-12 col-md-12 col-xl-4 my-4">
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
                                    <h5 class="font-weight-bold mt-2">Vehicle Exterior Images</h5>
                                </div>
                                <div class="card-body text-left pt-0">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <img class="w-75 float-end" id="img1" src="@if(isset($vehicleSidesImages['vImageR1'])) {{ url('public/storage/'.$vehicleSidesImages['vImageR1'])}} @else {{asset('img/checklist/car1.png')}} @endif" style="cursor:pointer" wire:click="markScrach('img1')" />
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <img class="w-75 float-start" id="img2" src="@if (isset($vehicleSidesImages['vImageR2'])) {{ url('public/storage/'.$vehicleSidesImages['vImageR2']) }} @else {{asset('img/checklist/car2.png')}} @endif" style="cursor:pointer" wire:click="markScrach('img2')" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <img class="w-75 float-end" id="img3" src="@if (isset($vehicleSidesImages['vImageF'])) {{ url('public/storage/'.$vehicleSidesImages['vImageF']) }} @else {{asset('img/checklist/car3.jpg')}} @endif" style="cursor:pointer" wire:click="markScrach('img3')" />
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <img class="w-75 float-start" id="img4" src="@if (isset($vehicleSidesImages['vImageB'])) {{ url('public/storage/'.$vehicleSidesImages['vImageB']) }} @else {{asset('img/checklist/car4.jpg')}} @endif" style="cursor:pointer" wire:click="markScrach('img4')" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <img class="w-75 float-end" id="img5" src="@if (isset($vehicleSidesImages['vImageL1'])) {{ url('public/storage/'.$vehicleSidesImages['vImageL1']) }} @else {{asset('img/checklist/car5.png')}} @endif" style="cursor:pointer" wire:click="markScrach('img5')" />
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <img class="w-75 float-start" id="img6" src="@if (isset($vehicleSidesImages['vImageL2'])) {{ url('public/storage/'.$vehicleSidesImages['vImageL2']) }} @else {{asset('img/checklist/car6.png')}} @endif" style="cursor:pointer" wire:click="markScrach('img6')" />
                                        </div>
                                    </div>

                                    <h5 class="font-weight-bold mt-2">Interior Vehicle Images</h5>
                                    <div class="row m-4">
                                        <div class="col-md-6 col-sm-6">
                                            <img class="img-fluid img-thumbnail shadow" id="dashImage1" src="@if (isset($vehicleSidesImages['dash_image1'])) {{ url('public/storage/'.$vehicleSidesImages['dash_image1']) }} @else {{asset('img/dashImage1.jpg')}} @endif" style="cursor:pointer"  />
                                            @error('dash_image1') <span class="text-danger">Missing Image..!</span> @enderror
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <img class="img-fluid img-thumbnail shadow" id="dashImage2" src="@if (isset($vehicleSidesImages['dash_image2'])) {{ url('public/storage/'.$vehicleSidesImages['dash_image2']) }} @else {{asset('img/dashImage2.jpg')}} @endif" style="cursor:pointer"  />
                                            @error('dash_image2') <span class="text-danger">Missing Image..!</span> @enderror
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="row m-4">
                                        <div class="col-md-6 col-sm-6">
                                            <img class="img-fluid img-thumbnail shadow" id="passengerSeatImage" src="@if (isset($vehicleSidesImages['passenger_seat_image'])) {{ url('public/storage/'.$vehicleSidesImages['passenger_seat_image']) }} @else {{asset('img/passangerSeat1.jpg')}} @endif" style="cursor:pointer"  />
                                            @error('passenger_seat_image') <span class="text-danger">Missing Image..!</span> @enderror
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <img class="img-fluid img-thumbnail shadow" id="driverSeatImage" src="@if (isset($vehicleSidesImages['driver_seat_image'])) {{ url('public/storage/'.$vehicleSidesImages['driver_seat_image']) }} @else {{asset('img/driverSeat1.jpg')}} @endif" style="cursor:pointer"  />
                                            @error('driver_seat_image') <span class="text-danger">Missing Image..!</span> @enderror
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <img class="img-fluid img-thumbnail shadow" id="backSeat1Image" src="@if (isset($vehicleSidesImages['back_seat1'])) {{ url('public/storage/'.$vehicleSidesImages['back_seat1']) }} @else {{asset('img/backSeat1.jpg')}} @endif" style="cursor:pointer"  />
                                            @error('back_seat1') <span class="text-danger">Missing Image..!</span> @enderror
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <img class="img-fluid img-thumbnail shadow" id="backSeat2Image" src="@if (isset($vehicleSidesImages['back_seat2'])) {{ url('public/storage/'.$vehicleSidesImages['back_seat2']) }} @else {{asset('img/backSeat2.jpg')}} @endif" style="cursor:pointer"   />
                                            @error('back_seat2') <span class="text-danger">Missing Image..!</span> @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <img class="img-fluid img-thumbnail shadow" id="backSeat3Image" src="@if (isset($vehicleSidesImages['back_seat3'])) {{ url('public/storage/'.$vehicleSidesImages['back_seat3']) }} @else {{asset('img/backSeat1.jpg')}} @endif" style="cursor:pointer"  />
                                            @error('back_seat3') <span class="text-danger">Missing Image..!</span> @enderror
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <img class="img-fluid img-thumbnail shadow" id="backSeat4Image1" src="@if (isset($vehicleSidesImages['back_seat4'])) {{ url('public/storage/'.$vehicleSidesImages['back_seat4']) }} @else {{asset('img/backSeat2.jpg')}} @endif" style="cursor:pointer"   />
                                            @error('back_seat4') <span class="text-danger">Missing Image..!</span> @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <img class="img-fluid img-thumbnail shadow" id="backSeat3Image1" src="@if (isset($vehicleSidesImages['roof_images'])) {{ url('public/storage/'.$vehicleSidesImages['roof_images']) }} @else {{asset('img/roofimage1.jpg')}} @endif" style="cursor:pointer"  />
                                            @error('roof_images') <span class="text-danger">Missing Image..!</span> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($customerSignatureShow)
                        <div class="row">
                            <div class="col-md-6 mt-0">
                                <div class="card card-blog card-plain">
                                    <div class="card-header text-left pt-4 pb-3">
                                        <h5 class="font-weight-bold mt-2">Signature</h5>
                                    </div>
                                    <div class="card-body px-1 pt-3">
                                        <div class="position-relative">
                                            <a class="d-block blur-shadow-image">
                                                <img src="{{$customerSignatureShow}}" alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <?php 
                            $qlServiceUpdate=false;
                            $mechServiceUpdate=false;
                            ?>
                            @if($jobcardDetails->cancel_req_status == "A" || $jobcardDetails->job_status==5)
                                <div class="row">
                                    @forelse( $jobcardDetails->customerJobServices as $services)
                                    
                                        <div class="col-md-4 mb-4">
                                            <div class="card">
                                                <div class="card-header text-center pt-4 pb-3">
                                                    <span class="badge rounded-pill bg-light text-dark">{{$services->department_name}} - {{$services->section_name}}</span>
                                                    <h5 class="text-dark">
                                                        @if($services->quantity>1)
                                                            {{$services->quantity.' x '}}
                                                        @endif
                                                        {{$services->item_name}}
                                                    </h5>
                                                </div>
                                                <div class="card-body text-lg-left text-center pt-0">
                                                    <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                                        <div class="icon icon-shape icon-xs rounded-circle {{config('global.jobs.status_btn_class')[$services->job_status]}} shadow text-center">
                                                            <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                                        </div>
                                                        <div>
                                                            <span class="ps-3 {{config('global.jobs.status_text_class')[$services->job_status]}}">Status: {{config('global.jobs.status')[$services->job_status]}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    
                                    @empty
                                        <div class="col-md-4 mb-4">
                                            <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                                <div class="d-flex flex-column">
                                                    <h6 class="mb-3 text-sm text-danger">Empty..!</h6>
                                                </div>
                                            </li>
                                        </div>
                                    @endforelse 
                                </div>
                            @elseif($jobcardDetails->cancel_req_status == "W")
                                <div class="row">
                                    @forelse( $jobcardDetails->customerJobServices as $services)
                                    
                                        <div class="col-md-4 mb-4">
                                            <div class="card">
                                                <div class="card-header text-center pt-4 pb-3">
                                                    <span class="badge rounded-pill bg-light text-dark">{{$services->department_name}} - {{$services->section_name}}</span>
                                                    <h5 class="text-dark">
                                                        @if($services->quantity>1)
                                                            {{$services->quantity.' x '}}
                                                        @endif
                                                        {{$services->item_name}}
                                                    </h5>
                                                </div>
                                                <div class="card-body text-lg-left text-center pt-0">
                                                    <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                                        <div class="icon icon-shape icon-xs rounded-circle {{config('global.jobs.status_btn_class')[$services->job_status]}} shadow text-center">
                                                            <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                                        </div>
                                                        <div>
                                                            <span class="ps-3 {{config('global.jobs.status_text_class')[$services->job_status]}}">Status: {{config('global.jobs.status')[$services->job_status]}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    
                                    @empty
                                        <div class="col-md-4 mb-4">
                                            <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                                <div class="d-flex flex-column">
                                                    <h6 class="mb-3 text-sm text-danger">Empty..!</h6>
                                                </div>
                                            </li>
                                        </div>
                                    @endforelse 
                                </div>
                            @else
                                @if(!empty($quickLubeServices))
                                    <!--Quick lube Head-->
                                    <div class="row" >
                                        <div class="d-sm-flex justify-content-between">
                                            <div>
                                                <h5 class=" modal-title">Quick Lube</h5>
                                            </div>
                                            <div class="d-flex">
                                                @if($qLInspectionPending)
                                                    <button class="mt-0 me-2 btn btn-sm {{config('global.jobs.status_outline_class')[6]}}" >Current Status: {{config('global.jobs.status')[6]}}</button>
                                                    <button class="mt-0 me-2 btn btn-sm {{config('global.jobs.status_btn_class')[6]}}" wire:click="updateQlMechJobService('{{$jobcardDetails->job_number}}','Quick Lube','6')">Click to Complete {{config('global.jobs.status')[6]}}</button>
                                                @elseif($qLCustomerAprovePending)
                                                    <button class="mt-0 me-2 btn btn-sm {{config('global.jobs.status_outline_class')[7]}}" >Current Status: {{config('global.jobs.status')[7]}}</button>
                                                    <button class="mt-0 me-2 btn btn-sm {{config('global.jobs.status_btn_class')[7]}}" wire:click="updateQlMechJobService('{{$jobcardDetails->job_number}}','Quick Lube','7')">Complete {{config('global.jobs.status')[7]}}</button>
                                                @elseif($qLServiceIssuePending)
                                                    <button class="mt-0 me-2 btn btn-sm {{config('global.jobs.status_outline_class')[8]}}" >Current Status: {{config('global.jobs.status')[8]}}</button>
                                                    <button class="mt-0 me-2 btn btn-sm {{config('global.jobs.status_btn_class')[8]}}" wire:click="updateQlMechJobService('{{$jobcardDetails->job_number}}','Quick Lube','8')">Complete {{config('global.jobs.status')[8]}}</button>
                                                @elseif($qLServicePending)
                                                    <button class="mt-0 me-2 btn btn-sm {{config('global.jobs.status_outline_class')[0]}}" >Current Status: {{config('global.jobs.status')[0]}}</button>
                                                    <a class="btn btn-link text-dark p-0 m-0" wire:click="updateQlMechJobService('{{$jobcardDetails->job_number}}','Quick Lube','0')">
                                                        <button class="mt-0 me-2 btn btn-sm {{config('global.jobs.status_btn_class')[1]}}">Complete {{config('global.jobs.status')[1]}}</button>
                                                    </a>
                                                @elseif($qLServiceWorkingProgressPending)
                                                    <button class="mt-0 me-2 btn btn-sm {{config('global.jobs.status_outline_class')[1]}}" >Current Status: {{config('global.jobs.status')[1]}}</button>
                                                    <a class="btn btn-link text-dark p-0 m-0" wire:click="qLQualityCheck('{{$jobcardDetails->job_number}}')" >
                                                        <button class="mt-0 me-2 btn btn-sm {{config('global.jobs.status_btn_class')[2]}}">Complete {{config('global.jobs.status')[2]}}</button>
                                                    </a>
                                                @elseif($qLServiceQualityCheckPending)
                                                    <button class="mt-0 me-2 btn btn-sm {{config('global.jobs.status_outline_class')[2]}}" >Current Status: {{config('global.jobs.status')[2]}}</button>
                                                    <?php /*@include('components.checklist.qlServiceTimer') */ ?>
                                                    <a class="btn btn-link text-dark p-0 m-0" wire:click="updateQlMechJobService('{{$jobcardDetails->job_number}}','Quick Lube','2')">
                                                        <button class="mt-0 me-2 btn btn-sm {{config('global.jobs.status_btn_class')[3]}}">Complete {{config('global.jobs.status')[3]}}</button>
                                                    </a>
                                                @elseif($qLServiceReadyToDeliverPending)
                                                    <label class="mt-0 me-2 btn btn-sm {{config('global.jobs.status_outline_class')[3]}}" >Current Status: {{config('global.jobs.status')[3]}}</label>
                                                    <?php /*@include('components.checklist.qlServiceTimer') */ ?>
                                                    <a class="btn btn-link text-dark p-0 m-0 d-none" wire:click="updateQlMechJobService('{{$jobcardDetails->job_number}}','Quick Lube','3')">
                                                        <button class="mt-0 me-2 btn btn-sm {{config('global.jobs.status_btn_class')[3]}}">Complete {{config('global.jobs.status')[3]}}</button>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                    @if($showQlQualityCheck)
                                        <div>
                                            <button type="button" class="btn btn-icon btn-3 btn-outline-primary" wire:click="qlChecklistToggleSelectAll()">
                                                <span class="btn-inner--icon"><i class="ni ni-button-play"></i></span>Mark as all good
                                            </button>
                                        </div>
                                        @include('components.checklist.oilChange-checklist')
                                        <a class="btn btn-link text-dark p-0 m-0" wire:click="updateQlMechJobService('{{$jobcardDetails->job_number}}','Quick Lube','1')">
                                            <button class="mt-4 btn btn-sm {{config('global.jobs.status_btn_class')[2]}}"> Quick Lube {{config('global.jobs.status')[2]}} Complete</button>
                                        </a>
                                    @endif
                                    @foreach( $quickLubeServices as $quickLubeService)
                                        <div class="col-md-4 mb-4">
                                            <div class="card">
                                                <div class="card-header text-center pt-4 pb-3">
                                                    <span class="badge rounded-pill bg-light text-dark">{{$quickLubeService['department_name']}} - {{$quickLubeService['section_name']}}</span>
                                                    <h5 class="text-dark">
                                                        @if($quickLubeService['quantity']>1)
                                                            {{$quickLubeService['quantity'].' x '}}
                                                        @endif
                                                        {{$quickLubeService['item_name']}}
                                                    </h5>
                                                </div>
                                                <div class="card-body text-lg-left text-center py-0">
                                                    <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                                        <div class="icon icon-shape icon-xs rounded-circle {{config('global.jobs.status_btn_class')[$quickLubeService['job_status']]}} shadow text-center">
                                                            <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                                        </div>
                                                        <div>
                                                            <span class="ps-3 {{config('global.jobs.status_text_class')[$quickLubeService['job_status']]}}">Status: {{config('global.jobs.status')[$quickLubeService['job_status']]}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                @if(!empty($mechanicalServices))
                                    <div class="row" >
                                        <div class="d-sm-flex justify-content-between">
                                            <div>
                                                <h5 class=" modal-title">Mechanical</h5>
                                            </div>
                                            <div class="d-flex">
                                                
                                                @if($mechInspectionPending)
                                                    <label class="mt-0 me-2 btn btn-sm {{config('global.jobs.status_outline_class')[6]}}" >Current Status: {{config('global.jobs.status')[6]}}</label>
                                                    <button class="mt-0 me-2 btn btn-sm {{config('global.jobs.status_btn_class')[6]}}" wire:click="updateQlMechJobService('{{$jobcardDetails->job_number}}','Mechanical','6')">Click to Complete {{config('global.jobs.status')[6]}}</button>
                                                @elseif($mechCustomerAprovePending)
                                                    <label class="mt-0 me-2 btn btn-sm {{config('global.jobs.status_outline_class')[7]}}" >Current Status: {{config('global.jobs.status')[7]}}</label>
                                                    <button class="mt-0 me-2 btn btn-sm {{config('global.jobs.status_btn_class')[7]}}" wire:click="updateQlMechJobService('{{$jobcardDetails->job_number}}','Mechanical','7')">Complete {{config('global.jobs.status')[7]}}</button>
                                                @elseif($mechServiceIssuePending)
                                                    <label class="mt-0 me-2 btn btn-sm {{config('global.jobs.status_outline_class')[8]}}" >Current Status: {{config('global.jobs.status')[8]}}</label>
                                                    <button class="mt-0 me-2 btn btn-sm {{config('global.jobs.status_btn_class')[8]}}" wire:click="updateQlMechJobService('{{$jobcardDetails->job_number}}','Mechanical','8')">Complete {{config('global.jobs.status')[8]}}</button>
                                                @elseif($mechServicePending)
                                                    <label class="mt-0 me-2 btn btn-sm {{config('global.jobs.status_outline_class')[0]}}" >Current Status: {{config('global.jobs.status')[0]}}</label>
                                                    <a class="btn btn-link text-dark p-0 m-0" wire:click="updateQlMechJobService('{{$jobcardDetails->job_number}}','Mechanical','0')">
                                                        <button class="mt-0 me-2 btn btn-sm {{config('global.jobs.status_btn_class')[1]}}">Complete {{config('global.jobs.status')[1]}}</button>
                                                    </a>
                                                @elseif($mechServiceWorkingProgressPending)
                                                    <label class="mt-0 me-2 btn btn-sm {{config('global.jobs.status_outline_class')[1]}}" >Current Status: {{config('global.jobs.status')[1]}}</label>
                                                    <a class="btn btn-link text-dark p-0 m-0" wire:click="mechQualityCheck('{{$jobcardDetails->job_number}}')" >
                                                        <button class="mt-0 me-2 btn btn-sm {{config('global.jobs.status_btn_class')[2]}}">Complete {{config('global.jobs.status')[2]}}</button>
                                                    </a>
                                                @elseif($mechServiceQualityCheckPending)
                                                    <label class="mt-0 me-2 btn btn-sm {{config('global.jobs.status_outline_class')[2]}}" >Current Status: {{config('global.jobs.status')[2]}}</label>
                                                    <?php /*@include('components.checklist.qlServiceTimer') */ ?>
                                                    <a class="btn btn-link text-dark p-0 m-0" wire:click="updateQlMechJobService('{{$jobcardDetails->job_number}}','Mechanical','2')">
                                                        <button class="mt-0 me-2 btn btn-sm {{config('global.jobs.status_btn_class')[3]}}">Complete {{config('global.jobs.status')[3]}}</button>
                                                    </a>
                                                @elseif($mechServiceReadyToDeliverPending)
                                                    <label class="mt-0 me-2 btn btn-sm {{config('global.jobs.status_outline_class')[3]}}" >Current Status: {{config('global.jobs.status')[3]}}</label>
                                                    <?php /*@include('components.checklist.qlServiceTimer') */ ?>
                                                    <a class="btn btn-link text-dark p-0 m-0 d-none" wire:click="updateQlMechJobService('{{$jobcardDetails->job_number}}','Mechanical','3')">
                                                        <button class="mt-0 me-2 btn btn-sm {{config('global.jobs.status_btn_class')[3]}}">Complete {{config('global.jobs.status')[3]}}</button>
                                                    </a>
                                                @endif
                                            
                                            </div>
                                        </div>
                                        <hr>
                                    </div>

                                    @if($showMechQualityCheck)
                                        <?php /*@include('components.checklist.mechanical-checklist') */ ?>
                                        <a class="btn btn-link text-dark p-0 m-0" wire:click="updateQlMechJobService('{{$jobcardDetails->job_number}}','Mechanical','1')">
                                            <button class="mt-4 btn btn-sm {{config('global.jobs.status_btn_class')[2]}}"> Mechanical {{config('global.jobs.status')[2]}} Complete</button>
                                        </a>
                                    @endif

                                    @foreach($mechanicalServices as $mechanicalService)
                                        <div class="col-md-4 mb-4">
                                            <div class="card">
                                                <div class="card-header text-center pt-4 pb-3">
                                                    <span class="badge rounded-pill bg-light text-dark">{{$mechanicalService['department_name']}} - {{$mechanicalService['section_name']}}</span>
                                                    <h5 class="text-dark">
                                                        @if($mechanicalService['quantity']>1)
                                                            {{$mechanicalService['quantity'].' x '}}
                                                        @endif
                                                        {{$mechanicalService['item_name']}}
                                                    </h5>
                                                </div>
                                                <div class="card-body text-lg-left text-center pt-0">
                                                    <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                                        <div class="icon icon-shape icon-xs rounded-circle {{config('global.jobs.status_btn_class')[$mechanicalService['job_status']]}} shadow text-center">
                                                            <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                                        </div>
                                                        <div>
                                                            <span class="ps-3 {{config('global.jobs.status_text_class')[$mechanicalService['job_status']]}}">Status: {{config('global.jobs.status')[$mechanicalService['job_status']]}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                @forelse($jobcardDetails->customerJobServices as $services)
                                    <li class="list-group-item border-0  p-2 mb-2 border-radius-lg">


                                        @if($services->section_name != 'Quick Lube' && $services->section_name != 'Mechanical' )
                                            <div class="card">
                                                <div class="card-body p-2">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            
                                                            <h6 class="mb-0 text-md">
                                                                @if($services->quantity>1)
                                                                {{$services->quantity.' x '}}
                                                                @endif
                                                                {{$services->item_name}}
                                                                <span class=" bg-gradient-dark text-gradient text-sm font-weight-bold">({{$services->department_code}})</span>
                                                            </h6>
                                                            
                                                            @if($services->job_status)
                                                            <div class="float-start icon icon-shape icon-xs rounded-circle {{config('global.jobs.status_btn_class')[$services->job_status]}} shadow text-center m-2">
                                                                <i class="fa-solid fa-car-on  opacity-10" aria-hidden="true"></i>
                                                            </div>
                                                            <h6 class="my-2 text-sm">
                                                                Status: <span class="text-sm {{config('global.jobs.status_text_class')[$services->job_status]}} pb-2">{{config('global.jobs.status')[$services->job_status]}}</span> 
                                                            </h6>
                                                            @else
                                                            <div class="float-start icon icon-shape icon-xs rounded-circle {{config('global.jobs.status_btn_class')[0]}} shadow text-center m-2">
                                                                <i class="fa-solid fa-car-on  opacity-10" aria-hidden="true"></i>
                                                            </div>
                                                            <h6 class="my-2 text-sm">
                                                                Status: <span class="text-sm {{config('global.jobs.status_text_class')[0]}} pb-2">{{config('global.jobs.status')[0]}}</span> 
                                                            </h6>
                                                            @endif
                                                            
                                                            <!-- <p class="text-sm font-weight-bold mb-0">
                                                                <span class="mb-2 text-xs">Price: <span class="text-dark ms-2 font-weight-bold">AED {{custom_round($services->total_price)}}</span></span>
                                                            </p>
                                                            <p class="text-sm font-weight-bold mb-0">
                                                                <span class="text-xs">VAT: <span class="text-dark ms-2 font-weight-bold">AED {{custom_round($services->vat)}}</span></span>
                                                            </p>
                                                            <p class="text-sm font-weight-bold mb-2">
                                                                <span class="text-md text-dark">Grand Total: <span class="text-dark ms-2 font-weight-bold">AED {{custom_round($services->grand_total)}}</span></span>
                                                            </p> -->
                                                        </div>
                                                        <div class="col-md-4">
                                                            @if($services->job_status==0 || $services->job_status==null)
                                                                <a class="btn btn-link text-dark p-0 m-0" wire:click="updateJobService({{$services}})">
                                                                    <button class="mt-4 btn btn-sm {{config('global.jobs.status_btn_class')[$services->job_status+1]}}">{{config('global.jobs.status')[$services->job_status+1]}}</button>
                                                                </a>
                                                            @elseif($services->job_status==1)
                                                                @include('components.checklist.serviceTimer')
                                                                <a class="btn btn-link text-dark p-0 m-0" wire:click="qualityCheck({{$services->id}})">
                                                                    <button class="mt-4 btn btn-sm {{config('global.jobs.status_btn_class')[$services->job_status+1]}}">{{config('global.jobs.status')[$services->job_status+1]}}</button>
                                                                </a>
                                                            @elseif($services->job_status==2)
                                                                <a class="btn btn-link text-dark p-0 m-0" wire:click="updateJobService({{$services}})">
                                                                    <button class="mt-4 btn btn-sm {{config('global.jobs.status_btn_class')[$services->job_status+1]}}">{{config('global.jobs.status')[$services->job_status+1]}}</button>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <hr class="horizontal dark mt-0 mb-1">
                                                    @if($showchecklist[$services->id])
                                                        @if($services->job_status==1)
                                                            <button type="button" class="btn btn-icon btn-3 btn-outline-primary" wire:click="checklistToggleSelectAll('{{$services}}')">
                                                                <span class="btn-inner--icon"><i class="ni ni-button-play"></i></span>
                                                                Mark as all good
                                                            </button>
                                                            @if($services->item_code=="S255")
                                                                @include('components.checklist.interiorCleaning-checklist')
                                                                <a class="btn btn-link text-dark p-0 m-0" wire:click="updateJobService({{$services}})">
                                                                    <button class="mt-4 btn btn-sm {{config('global.jobs.status_btn_class')[$services->job_status+1]}}"> {{config('global.jobs.status')[$services->job_status+1]}} Complete</button>
                                                                </a>

                                                            @elseif(in_array($services->section_name, config('global.check_list.wash.services')))
                                                                @include('components.checklist.wash-checklist')
                                                                <a class="btn btn-link text-dark p-0 m-0" wire:click="updateJobService({{$services}})">
                                                                    <button class="mt-4 btn btn-sm {{config('global.jobs.status_btn_class')[$services->job_status+1]}}"> {{config('global.jobs.status')[$services->job_status+1]}} Complete</button>
                                                                </a>    
                                                            @elseif(in_array($services->section_name, config('global.check_list.glazing.services')))
                                                                @include('components.checklist.glazing-checklist')
                                                                <a class="btn btn-link text-dark p-0 m-0" wire:click="updateJobService({{$services}})">
                                                                    <button class="mt-4 btn btn-sm {{config('global.jobs.status_btn_class')[$services->job_status+1]}}"> {{config('global.jobs.status')[$services->job_status+1]}} Complete</button>
                                                                </a>
                                                            @elseif(in_array($services->section_name, config('global.check_list.interiorCleaning.services')))
                                                                @include('components.checklist.interiorCleaning-checklist')
                                                                <a class="btn btn-link text-dark p-0 m-0" wire:click="updateJobService({{$services}})">
                                                                    <button class="mt-4 btn btn-sm {{config('global.jobs.status_btn_class')[$services->job_status+1]}}"> {{config('global.jobs.status')[$services->job_status+1]}} Complete</button>
                                                                </a>
                                                            @elseif(in_array($services->section_name, config('global.check_list.oilChange.services')))
                                                                @include('components.checklist.oilChange-checklist')
                                                                <a class="btn btn-link text-dark p-0 m-0" wire:click="updateJobService({{$services}})">
                                                                    <button class="mt-4 btn btn-sm {{config('global.jobs.status_btn_class')[$services->job_status+1]}}"> {{config('global.jobs.status')[$services->job_status+1]}} Complete</button>
                                                                </a>
                                                            @elseif(in_array($services->section_name, config('global.check_list.tinting.services')))
                                                                @include('components.checklist.tinting-checklist')
                                                                <a class="btn btn-link text-dark p-0 m-0" wire:click="updateJobService({{$services}})">
                                                                    <button class="mt-4 btn btn-sm {{config('global.jobs.status_btn_class')[$services->job_status+1]}}"> {{config('global.jobs.status')[$services->job_status+1]}} Complete</button>
                                                                </a>
                                                            @elseif(in_array($services->section_name, config('global.check_list.mechanical.services')))
                                                                <a class="btn btn-link text-dark p-0 m-0" wire:click="updateJobService({{$services}})">
                                                                    <button class="mt-4 btn btn-sm {{config('global.jobs.status_btn_class')[$services->job_status+1]}}"> {{config('global.jobs.status')[$services->job_status+1]}} Complete</button>
                                                                </a>
                                                            @else
                                                                <a class="btn btn-link text-dark p-0 m-0" wire:click="updateJobService({{$services}})">
                                                                    <button class="mt-4 btn btn-sm {{config('global.jobs.status_btn_class')[$services->job_status+1]}}"> {{config('global.jobs.status')[$services->job_status+1]}} Complete</button>
                                                                </a>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        @else

                                            <div class="card d-none">
                                                <div class="card-body p-2">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <div class="d-none float-start icon icon-shape icon-xs rounded-circle {{config('global.jobs.status_btn_class')[$services->job_status]}} shadow text-center mx-2">
                                                                <i class="{{config('global.jobs.status_icon')[$services->job_status]}} opacity-10" aria-hidden="true"></i>
                                                            </div>
                                                            <h6 class="mb-0 text-md">
                                                                @if($services->quantity>1)
                                                                {{$services->quantity.' x '}}
                                                                @endif
                                                                {{$services->item_name}}
                                                                <span class=" bg-gradient-dark text-gradient text-sm font-weight-bold">({{$services->department_code}})</span>
                                                            </h6>
                                                            <div class="float-start icon icon-shape icon-xs rounded-circle {{config('global.jobs.status_btn_class')[$services->job_status]}} shadow text-center m-2">
                                                                <i class="fa-solid fa-car-on  opacity-10" aria-hidden="true"></i>
                                                            </div>
                                                            @if($services->job_status)
                                                            <h6 class="my-2 text-sm">
                                                                Status: <span class="text-sm {{config('global.jobs.status_text_class')[$services->job_status]}} pb-2">{{config('global.jobs.status')[$services->job_status]}}</span> 
                                                            </h6>
                                                            @endif
                                                            
                                                        </div>
                                                        <div class="col-md-4">
                                                            @if($services->job_status==1)
                                                                <a class="btn btn-link text-dark p-0 m-0" wire:click="qualityCheck({{$services->id}})">
                                                                    <button class="mt-4 btn btn-sm {{config('global.jobs.status_btn_class')[$services->job_status+1]}}">{{config('global.jobs.status')[$services->job_status+1]}}</button>
                                                                </a>
                                                            @elseif($services->job_status>=2 && $services->job_status<3)
                                                                <a class="btn btn-link text-dark p-0 m-0" wire:click="updateJobService({{$services}})">
                                                                    <button class="mt-4 btn btn-sm {{config('global.jobs.status_btn_class')[$services->job_status+1]}}">{{config('global.jobs.status')[$services->job_status+1]}}</button>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <hr class="horizontal dark mt-0 mb-1">
                                                    @if($services->job_status==1)
                                                        @if($showchecklist[$services->id])
                                                        
                                                            <a class="btn btn-link text-dark p-0 m-0" wire:click="updateJobService({{$services}})">
                                                                    <button class="mt-4 btn btn-sm {{config('global.jobs.status_btn_class')[$services->job_status+1]}}"> {{config('global.jobs.status')[$services->job_status+1]}} Complete</button>
                                                                </a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </li>
                                @empty
                                    <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-3 text-sm text-danger">Empty..!</h6>
                                        </div>
                                    </li>
                                @endforelse
                            @endif
                        </ul>
                    </div>
                </div>


            </div>
       </div>
    </div>
    <div wire:loading wire:target="qlChecklistToggleSelectAll">
        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
            <div class="la-ball-beat">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <div wire:loading wire:target="updateQlMechJobService">
        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
            <div class="la-ball-beat">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <div wire:loading wire:target="qLQualityCheck">
        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
            <div class="la-ball-beat">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <div wire:loading wire:target="mechQualityCheck">
        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
            <div class="la-ball-beat">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <div wire:loading wire:target="confirmCancelJob">
        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
            <div class="la-ball-beat">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <div wire:loading wire:target="openVehicleImageDetails">
        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
            <div class="la-ball-beat">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>

    <div wire:loading wire:target="closeVehicleImageDetails">
        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
            <div class="la-ball-beat">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <div wire:loading wire:target="checklistToggleSelectAll">
        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
            <div class="la-ball-beat">
                <div></div>
                <div></div>
                <div></div>
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
    </div>
    <div wire:loading wire:target="updateJobService">
        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
            <div class="la-ball-beat">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <div wire:loading wire:target="qualityCheck">
        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
            <div class="la-ball-beat">
                <div></div>
                <div></div>
                <div></div>
            </div>
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
    </div>
    <div wire:loading wire:target="cancelJob">
        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
            <div class="la-ball-beat">
                <div></div>
                <div></div>
                <div></div>
            </div>
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
    <div wire:loading wire:target="checkOnlinePaymentStatus">
        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
            <div class="la-ball-beat">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>

</div>
