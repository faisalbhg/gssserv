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
                                        @if($job_number)
                                        <span class="badge badge-dark text-dark text-lg text-gradient ps-0">#{{$job_number}}</span>
                                        @endif
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
                                    @if($show_staff_details)
                                    <div class="row p-4">
                                        <div class="col-md-6 col-sm-6">
                                            <label for="staffIdInput">Staff ID</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" wire:model="staff_id"  name="staff_id" id="staffIdInput" style="padding-left:10px !important;" placeholder="Staff ID" />
                                            </div>
                                            @error('staff_id') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        @if($selectedVehicleInfo['customerInfoMaster']['TenantId'] == '6630')
                                        <div class="col-md-6 col-sm-6">
                                            <label for="staffNumberInput">AT Number</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" wire:model="staff_number"  name="staff_number" id="staffNumberInput" style="padding-left:10px !important;" placeholder="AT Number" />
                                            </div>
                                            @error('staff_number') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        @endif
                                    </div>
                                    @endif
                                    <div class="row p-4">
                                        <div class="col-md-6 col-sm-6">
                                            <label for="inputJobDateTime">Job Date</label>
                                            <div class="form-group">
                                                <input type="datetime-local" class="form-control" wire:model="job_date_time"  name="job_date_time" id="inputJobDateTime" style="padding-left:10px !important;" placeholder="Job Date Time" />
                                            </div>
                                            @error('staff_id') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <button type="button" class="d-none btn btn-primary btn-lg" wire:click="clickShowSignature()">Customer Signature</button>
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
                            <h6 class="text-uppercase text-body text-dark text-lg font-weight-bolder mt-2">Service/Items Summary <span class="float-end text-sm text-danger text-capitalize">{{ count($cartItems) }} Services selected</span></h6>
                            <div class="row">
                                <div class="col-lg-12 col-sm-12">
                                    <div class="card h-100">
                                        
                                        <div class="card-body p-3 pb-0">
                                            <ul class="list-group">
                                                <?php $total = 0;$totalDiscount=0; $package_job=false; ?>
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

                                                if($package_job)
                                                {
                                                    $tax = 0;
                                                }
                                                //$tax = $totalAfterDisc * (config('global.TAX_PERCENT') / 100);
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
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        @if($showCheckList)
            <div class="row mt-3">

                @if($showFuelScratchCheckList)
                    <div class="col-xxs-12 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-4">
                        <div class="card">
                            <div class="card-header text-left pt-4 pb-3">
                                <h5 class="font-weight-bold mt-2">Check List</h5>
                            </div>
                            <div class="card-body text-left pt-0">
                                @foreach($checklistLabels as $clKey => $checklist)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" wire:model="checklistLabel.{{$checklist->id}}" id="checkList{{ str_replace(" ","",$checklist->checklist_label) }}" >
                                    <label class="custom-control-label" for="checkList{{ str_replace(" ","",$checklist->checklist_label) }}">{{$checklist->checklist_label}}</label>
                                </div>
                                @endforeach
                            </div>
                            <div class="card-footer text-left pt-0">
                                <label class="custom-control-label" for="fcustomCheckRadioTapeCD">Note: <small>Minor surface scratches defects, stone chipping, scratches on glasses etc. are included</small></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxs-12 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-4">
                        <div class="card mb-3">
                            <div class="card-header text-left pt-4 pb-3">
                                <h5 class="font-weight-bold mt-2">Fuel</h5>
                            </div>
                            <div class="card-body text-left pt-0">
                                <div class="row"> 
                                    @foreach(config('global.fuel') as $keyF => $fuel)
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="fuel" value="{{$keyF}}" id="flexRadio{{$fuel}}">
                                            <label class="custom-control-label" for="flexRadio{{$fuel}}">{{$fuel}}</label>
                                        </div>
                                    </div>
                                    @endforeach
                                    @error('fuel') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header text-left pt-4 pb-3">
                                <h5 class="font-weight-bold mt-2 d-none">Scratches</h5>
                            </div>
                            <div class="card-body text-left pt-0">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="textareaScratchesFound">Found</label>
                                            <textarea class="form-control" id="scratchesFound" wire:model="scratchesFound" rows="3"></textarea>
                                            @error('scratchesFound') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="textareaScratchesNotFound">Not Found</label>
                                            <textarea class="form-control" id="scratchesNotFound" wire:model="scratchesNotFound" rows="3"></textarea>
                                            @error('scratchesNotFound') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($showQLCheckList)
                    <div class="col-xxs-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 mb-4 d-none">
                        <div class="card mb-3">
                            <div class="card-header text-left pt-4 pb-3">
                                <h5 class="font-weight-bold mt-2">Interior Cabin Inspection</h5>
                            </div>
                            <div class="card-body text-left pt-0">
                                <div class="row"> 
                                    <label>Turn key on - check for fault codes</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="turn_key_on_check_for_fault_codes" value="1" id="turn_key_on_check_for_fault_codes1">
                                            <label class="custom-control-label" for="turn_key_on_check_for_fault_codes1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="turn_key_on_check_for_fault_codes" value="2" id="turn_key_on_check_for_fault_codes2">
                                            <label class="custom-control-label" for="turn_key_on_check_for_fault_codes2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="turn_key_on_check_for_fault_codes" value="3" id="turn_key_on_check_for_fault_codes3">
                                            <label class="custom-control-label" for="turn_key_on_check_for_fault_codes3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('turn_key_on_check_for_fault_codes') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Start Engine - observe operation</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="start_engine_observe_operation" value="1" id="start_engine_observe_operation1">
                                            <label class="custom-control-label" for="start_engine_observe_operation1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="start_engine_observe_operation" value="2" id="start_engine_observe_operation2">
                                            <label class="custom-control-label" for="start_engine_observe_operation2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="start_engine_observe_operation" value="3" id="start_engine_observe_operation3">
                                            <label class="custom-control-label" for="start_engine_observe_operation3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('start_engine_observe_operation') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Reset the Service Reminder Alert</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="reset_the_service_reminder_alert" value="1" id="reset_the_service_reminder_alert1">
                                            <label class="custom-control-label" for="reset_the_service_reminder_alert1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="reset_the_service_reminder_alert" value="2" id="reset_the_service_reminder_alert2">
                                            <label class="custom-control-label" for="reset_the_service_reminder_alert2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="reset_the_service_reminder_alert" value="3" id="reset_the_service_reminder_alert3">
                                            <label class="custom-control-label" for="reset_the_service_reminder_alert3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('reset_the_service_reminder_alert') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Stick & Update Service Reminder Sticker on B-Piller</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="stick_update_service_reminder_sticker_on_b_piller" value="1" id="stick_update_service_reminder_sticker_on_b_piller1">
                                            <label class="custom-control-label" for="stick_update_service_reminder_sticker_on_b_piller1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="stick_update_service_reminder_sticker_on_b_piller" value="2" id="stick_update_service_reminder_sticker_on_b_piller2">
                                            <label class="custom-control-label" for="stick_update_service_reminder_sticker_on_b_piller2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="stick_update_service_reminder_sticker_on_b_piller" value="3" id="stick_update_service_reminder_sticker_on_b_piller3">
                                            <label class="custom-control-label" for="stick_update_service_reminder_sticker_on_b_piller3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('stick_update_service_reminder_sticker_on_b_piller') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Comments</label>
                                    <div class="col-md-12">
                                        <div class="form-check mb-3 ps-0">
                                            <textarea class="form-control" id="interior_cabin_inspection_comments" wire:model="interior_cabin_inspection_comments" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxs-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 mb-4 d-none">
                        <div class="card mb-3">
                            <div class="card-header text-left pt-4 pb-3">
                                <h5 class="font-weight-bold mt-2">Under Hood Inspection</h5>
                            </div>
                            <div class="card-body text-left pt-0">
                                <div class="row"> 
                                    <label>Check Power Steering Fluid Level</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_power_steering_fluid_level" value="1" id="check_power_steering_fluid_level1">
                                            <label class="custom-control-label" for="check_power_steering_fluid_level1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_power_steering_fluid_level" value="2" id="check_power_steering_fluid_level2">
                                            <label class="custom-control-label" for="check_power_steering_fluid_level2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_power_steering_fluid_level" value="3" id="check_power_steering_fluid_level3">
                                            <label class="custom-control-label" for="check_power_steering_fluid_level3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('check_power_steering_fluid_level') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Check Power Steering tank Cap properly fixed</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_power_steering_tank_cap_properly_fixed" value="1" id="check_power_steering_tank_cap_properly_fixed1">
                                            <label class="custom-control-label" for="check_power_steering_tank_cap_properly_fixed1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_power_steering_tank_cap_properly_fixed" value="2" id="check_power_steering_tank_cap_properly_fixed2">
                                            <label class="custom-control-label" for="check_power_steering_tank_cap_properly_fixed2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_power_steering_tank_cap_properly_fixed" value="3" id="check_power_steering_tank_cap_properly_fixed3">
                                            <label class="custom-control-label" for="check_power_steering_tank_cap_properly_fixed3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('check_power_steering_tank_cap_properly_fixed') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Check Brake fluid level</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_brake_fluid_level" value="1" id="check_brake_fluid_level1">
                                            <label class="custom-control-label" for="check_brake_fluid_level1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_brake_fluid_level" value="2" id="check_brake_fluid_level2">
                                            <label class="custom-control-label" for="check_brake_fluid_level2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_brake_fluid_level" value="3" id="check_brake_fluid_level3">
                                            <label class="custom-control-label" for="check_brake_fluid_level3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('check_brake_fluid_level') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Check Brake fluid tank Cap properly fixed</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="brake_fluid_tank_cap_properly_fixed" value="1" id="brake_fluid_tank_cap_properly_fixed1">
                                            <label class="custom-control-label" for="brake_fluid_tank_cap_properly_fixed1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="brake_fluid_tank_cap_properly_fixed" value="2" id="brake_fluid_tank_cap_properly_fixed2">
                                            <label class="custom-control-label" for="brake_fluid_tank_cap_properly_fixed2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="brake_fluid_tank_cap_properly_fixed" value="3" id="brake_fluid_tank_cap_properly_fixed3">
                                            <label class="custom-control-label" for="brake_fluid_tank_cap_properly_fixed3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('brake_fluid_tank_cap_properly_fixed') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Check Engine Oil Level</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_engine_oil_level" value="1" id="check_engine_oil_level1">
                                            <label class="custom-control-label" for="check_engine_oil_level1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_engine_oil_level" value="2" id="check_engine_oil_level2">
                                            <label class="custom-control-label" for="check_engine_oil_level2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_engine_oil_level" value="3" id="check_engine_oil_level3">
                                            <label class="custom-control-label" for="check_engine_oil_level3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('check_engine_oil_level') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Check Radiator Coolant Level</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_radiator_coolant_level" value="1" id="check_radiator_coolant_level1">
                                            <label class="custom-control-label" for="check_radiator_coolant_level1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_radiator_coolant_level" value="2" id="check_radiator_coolant_level2">
                                            <label class="custom-control-label" for="check_radiator_coolant_level2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_radiator_coolant_level" value="3" id="check_radiator_coolant_level3">
                                            <label class="custom-control-label" for="check_radiator_coolant_level3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('check_radiator_coolant_level') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Check Radiator Cap properly fixed</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_radiator_cap_properly_fixed" value="1" id="check_radiator_cap_properly_fixed1">
                                            <label class="custom-control-label" for="check_radiator_cap_properly_fixed1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_radiator_cap_properly_fixed" value="2" id="check_radiator_cap_properly_fixed2">
                                            <label class="custom-control-label" for="check_radiator_cap_properly_fixed2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_radiator_cap_properly_fixed" value="3" id="check_radiator_cap_properly_fixed3">
                                            <label class="custom-control-label" for="check_radiator_cap_properly_fixed3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('check_radiator_cap_properly_fixed') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Top off windshield washer fluid</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="top_off_windshield_washer_fluid" value="1" id="top_off_windshield_washer_fluid1">
                                            <label class="custom-control-label" for="top_off_windshield_washer_fluid1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="top_off_windshield_washer_fluid" value="2" id="top_off_windshield_washer_fluid2">
                                            <label class="custom-control-label" for="top_off_windshield_washer_fluid2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="top_off_windshield_washer_fluid" value="3" id="top_off_windshield_washer_fluid3">
                                            <label class="custom-control-label" for="top_off_windshield_washer_fluid3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('top_off_windshield_washer_fluid') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Check windshield Cap properly fixed</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_windshield_cap_properly_fixed" value="1" id="check_windshield_cap_properly_fixed1">
                                            <label class="custom-control-label" for="check_windshield_cap_properly_fixed1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_windshield_cap_properly_fixed" value="2" id="check_windshield_cap_properly_fixed2">
                                            <label class="custom-control-label" for="check_windshield_cap_properly_fixed2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_windshield_cap_properly_fixed" value="3" id="check_windshield_cap_properly_fixed3">
                                            <label class="custom-control-label" for="check_windshield_cap_properly_fixed3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('check_windshield_cap_properly_fixed') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Comments</label>
                                    <div class="col-md-12">
                                        <div class="form-check mb-3 ps-0">
                                            <textarea class="form-control" id="underHoodInspectionComments" wire:model="underHoodInspectionComments" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxs-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 mb-4 d-none">
                        <div class="card mb-3">
                            <div class="card-header text-left pt-4 pb-3">
                                <h5 class="font-weight-bold mt-2">Under Body Inspection</h5>
                            </div>
                            <div class="card-body text-left pt-0">
                                <div class="row"> 
                                    <label>Check for Oil leaks - Engine, Steering</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_for_oil_leaks_engine_steering" value="1" id="check_for_oil_leaks_engine_steering1">
                                            <label class="custom-control-label" for="check_for_oil_leaks_engine_steering1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_for_oil_leaks_engine_steering" value="2" id="check_for_oil_leaks_engine_steering2">
                                            <label class="custom-control-label" for="check_for_oil_leaks_engine_steering2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_for_oil_leaks_engine_steering" value="3" id="check_for_oil_leaks_engine_steering3">
                                            <label class="custom-control-label" for="check_for_oil_leaks_engine_steering3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('check_for_oil_leaks_engine_steering') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Check for Oil Leak - Oil Filtering</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_for_oil_leak_oil_filtering" value="1" id="check_for_oil_leak_oil_filtering1">
                                            <label class="custom-control-label" for="check_for_oil_leak_oil_filtering1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_for_oil_leak_oil_filtering" value="2" id="check_for_oil_leak_oil_filtering2">
                                            <label class="custom-control-label" for="check_for_oil_leak_oil_filtering2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_for_oil_leak_oil_filtering" value="3" id="check_for_oil_leak_oil_filtering3">
                                            <label class="custom-control-label" for="check_for_oil_leak_oil_filtering3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('check_for_oil_leak_oil_filtering') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Check Drain Plug fixed properly</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_drain_lug_fixed_properly" value="1" id="check_drain_lug_fixed_properly1">
                                            <label class="custom-control-label" for="check_drain_lug_fixed_properly1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_drain_lug_fixed_properly" value="2" id="check_drain_lug_fixed_properly2">
                                            <label class="custom-control-label" for="check_drain_lug_fixed_properly2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_drain_lug_fixed_properly" value="3" id="check_drain_lug_fixed_properly3">
                                            <label class="custom-control-label" for="check_drain_lug_fixed_properly3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('check_drain_lug_fixed_properly') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Check Oil Filter fixed properly</label>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_oil_filter_fixed_properly" value="1" id="check_oil_filter_fixed_properly1">
                                            <label class="custom-control-label" for="check_oil_filter_fixed_properly1">Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_oil_filter_fixed_properly" value="2" id="check_oil_filter_fixed_properly2">
                                            <label class="custom-control-label" for="check_oil_filter_fixed_properly2">Not Good</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" wire:model="check_oil_filter_fixed_properly" value="3" id="check_oil_filter_fixed_properly3">
                                            <label class="custom-control-label" for="check_oil_filter_fixed_properly3">Not Applicable</label>
                                        </div>
                                    </div>
                                    @error('check_oil_filter_fixed_properly') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="row"> 
                                    <label>Comments</label>
                                    <div class="col-md-12">
                                        <div class="form-check mb-3 ps-0">
                                            <textarea class="form-control" id="ubi_comments" wire:model="ubi_comments" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif
        
        @if($showvehicleImage)
            <div class="row mt-3">
                <h6 class="text-uppercase text-body text-dark text-lg font-weight-bolder mt-2">Exterior Vehicle Images</h6>
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-body text-left pt-0">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div 
                                    x-data="{ isUploading: false, progress: 0 }" 
                                    x-on:livewire-upload-start="isUploading = true" 
                                    x-on:livewire-upload-finish="isUploading = false" 
                                    x-on:livewire-upload-error="isUploading = false" 
                                    x-on:livewire-upload-progress="progress = $event.detail.progress" 
                                    >
                                        <!-- <div class="row">
                                            <div class="col-md-12">
                                                
                                                <button class="btn btn-icon btn-2 btn-primary float-start" id="plateImage" type="button">
                                                    <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                                </button>
                                            </div>
                                        </div> -->
                                        <!-- File Input -->
                                        <input type="file" id="file1" wire:model="vImageR1" accept="image/*" capture style="display: none;" />
                                        <!-- Progress Bar -->
                                        <div x-show="isUploading">
                                            <progress max="100" x-bind:value="progress"></progress>
                                        </div>
                                    </div>
                                    <img class="w-75 float-end" id="upfile1" src="@if($vImageR1) {{$vImageR1->temporaryUrl()}} @elseif($existingImageR1) {{ url('public/storage/'.$existingImageR1)}} @else {{asset('img/checklist/car1.png')}} @endif" style="cursor:pointer"  />
                                    @error('vImageR1') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div 
                                    x-data="{ isUploading: false, progress: 0 }" 
                                    x-on:livewire-upload-start="isUploading = true" 
                                    x-on:livewire-upload-finish="isUploading = false" 
                                    x-on:livewire-upload-error="isUploading = false" 
                                    x-on:livewire-upload-progress="progress = $event.detail.progress" 
                                    >
                                        <!-- <div class="row">
                                            <div class="col-md-12">
                                                
                                                <button class="btn btn-icon btn-2 btn-primary float-start" id="plateImage" type="button">
                                                    <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                                </button>
                                            </div>
                                        </div> -->
                                        <!-- File Input -->
                                        <input type="file" id="file2" wire:model="vImageR2" accept="image/*" capture style="display:none"/>
                                        <!-- Progress Bar -->
                                        <div x-show="isUploading">
                                            <progress max="100" x-bind:value="progress"></progress>
                                        </div>
                                    </div>
                                    
                                    <img class="w-75 float-start" id="upfile2" src="@if($vImageR2) {{$vImageR2->temporaryUrl()}} @elseif ($existingImageR2) {{ url('public/storage/'.$existingImageR2)}} @else {{asset('img/checklist/car2.png')}} @endif" style="cursor:pointer"  />
                                    @error('vImageR2') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                                <hr>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div 
                                    x-data="{ isUploading: false, progress: 0 }" 
                                    x-on:livewire-upload-start="isUploading = true" 
                                    x-on:livewire-upload-finish="isUploading = false" 
                                    x-on:livewire-upload-error="isUploading = false" 
                                    x-on:livewire-upload-progress="progress = $event.detail.progress" 
                                    >
                                        <!-- <div class="row">
                                            <div class="col-md-12">
                                                
                                                <button class="btn btn-icon btn-2 btn-primary float-start" id="plateImage" type="button">
                                                    <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                                </button>
                                            </div>
                                        </div> -->
                                        <!-- File Input -->
                                        <input type="file" id="file3" wire:model="vImageF" accept="image/*" capture style="display:none"/>
                                        <!-- Progress Bar -->
                                        <div x-show="isUploading">
                                            <progress max="100" x-bind:value="progress"></progress>
                                        </div>
                                    </div>
                                    <img class="w-75 float-end" id="upfile3" src="@if($vImageF) {{$vImageF->temporaryUrl()}} @elseif($existingImageF) {{ url('public/storage/'.$existingImageF)}} @else {{asset('img/checklist/car3.jpg')}} @endif" style="cursor:pointer"  />
                                    @error('vImageF') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div 
                                    x-data="{ isUploading: false, progress: 0 }" 
                                    x-on:livewire-upload-start="isUploading = true" 
                                    x-on:livewire-upload-finish="isUploading = false" 
                                    x-on:livewire-upload-error="isUploading = false" 
                                    x-on:livewire-upload-progress="progress = $event.detail.progress" 
                                    >
                                        <!-- <div class="row">
                                            <div class="col-md-12">
                                                
                                                <button class="btn btn-icon btn-2 btn-primary float-start" id="plateImage" type="button">
                                                    <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                                </button>
                                            </div>
                                        </div> -->
                                        <!-- File Input -->
                                        <input type="file" id="file4" wire:model="vImageB" accept="image/*" capture style="display:none"/>
                                        <!-- Progress Bar -->
                                        <div x-show="isUploading">
                                            <progress max="100" x-bind:value="progress"></progress>
                                        </div>
                                    </div>
                                    <img class="w-75 float-start" id="upfile4" src="@if($vImageB) {{$vImageB->temporaryUrl()}} @elseif($existingImageB) {{ url('public/storage/'.$existingImageB)}} @else {{asset('img/checklist/car4.jpg')}} @endif" style="cursor:pointer"  />
                                    @error('vImageB') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                                <hr>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div 
                                    x-data="{ isUploading: false, progress: 0 }" 
                                    x-on:livewire-upload-start="isUploading = true" 
                                    x-on:livewire-upload-finish="isUploading = false" 
                                    x-on:livewire-upload-error="isUploading = false" 
                                    x-on:livewire-upload-progress="progress = $event.detail.progress" 
                                    >
                                        <!-- <div class="row">
                                            <div class="col-md-12">
                                                
                                                <button class="btn btn-icon btn-2 btn-primary float-start" id="plateImage" type="button">
                                                    <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                                </button>
                                            </div>
                                        </div> -->
                                        <!-- File Input -->
                                        <input type="file" id="file5" wire:model="vImageL1" accept="image/*" capture style="display:none"/>
                                        <!-- Progress Bar -->
                                        <div x-show="isUploading">
                                            <progress max="100" x-bind:value="progress"></progress>
                                        </div>
                                    </div>
                                    <img class="w-75 float-end" id="upfile5" src="@if ($vImageL1) {{$vImageL1->temporaryUrl()}} @elseif($existingImageL1) {{ url('public/storage/'.$existingImageL1)}} @else {{asset('img/checklist/car5.png')}} @endif" style="cursor:pointer"  />
                                    @error('vImageL1') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div 
                                    x-data="{ isUploading: false, progress: 0 }" 
                                    x-on:livewire-upload-start="isUploading = true" 
                                    x-on:livewire-upload-finish="isUploading = false" 
                                    x-on:livewire-upload-error="isUploading = false" 
                                    x-on:livewire-upload-progress="progress = $event.detail.progress" 
                                    >
                                        <!-- <div class="row">
                                            <div class="col-md-12">
                                                
                                                <button class="btn btn-icon btn-2 btn-primary float-start" id="plateImage" type="button">
                                                    <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                                </button>
                                            </div>
                                        </div> -->
                                        <!-- File Input -->
                                        <input type="file" id="file6" wire:model="vImageL2" accept="image/*" capture style="display:none"/>
                                        <!-- Progress Bar -->
                                        <div x-show="isUploading">
                                            <progress max="100" x-bind:value="progress"></progress>
                                        </div>
                                    </div>
                                    <img class="w-75 float-start" id="upfile6" src="@if ($vImageL2) {{$vImageL2->temporaryUrl()}} @elseif($existingImageL2) {{ url('public/storage/'.$existingImageL2)}} @else {{asset('img/checklist/car6.png')}} @endif" style="cursor:pointer"   />
                                    @error('vImageL2') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h6 class="text-uppercase text-body text-dark text-lg font-weight-bolder mt-2">Interior Vehicle Images</h6>
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-body text-left pt-0">
                            <div class="row m-4">
                                <div class="col-md-6 col-sm-6">
                                    <div 
                                    x-data="{ isUploading: false, progress: 0 }" 
                                    x-on:livewire-upload-start="isUploading = true" 
                                    x-on:livewire-upload-finish="isUploading = false" 
                                    x-on:livewire-upload-error="isUploading = false" 
                                    x-on:livewire-upload-progress="progress = $event.detail.progress" 
                                    >
                                        <!-- <div class="row">
                                            <div class="col-md-12">
                                                
                                                <button class="btn btn-icon btn-2 btn-primary float-start" id="plateImage" type="button">
                                                    <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                                </button>
                                            </div>
                                        </div> -->
                                        <!-- File Input -->
                                        <input type="file" id="dashImage1File" wire:model="dash_image1" accept="image/*" capture style="display:none"/>
                                        <!-- Progress Bar -->
                                        <div x-show="isUploading">
                                            <progress max="100" x-bind:value="progress"></progress>
                                        </div>
                                    </div>

                                    
                                    <img class="img-fluid img-thumbnail shadow" id="dashImage1" src="@if($dash_image1) {{$dash_image1->temporaryUrl()}} @elseif($existingdash_image1) {{ url('public/storage/'.$existingdash_image1)}} @else {{asset('img/dashImage1.jpg')}} @endif" style="cursor:pointer"  />
                                    @error('dash_image1') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div 
                                    x-data="{ isUploading: false, progress: 0 }" 
                                    x-on:livewire-upload-start="isUploading = true" 
                                    x-on:livewire-upload-finish="isUploading = false" 
                                    x-on:livewire-upload-error="isUploading = false" 
                                    x-on:livewire-upload-progress="progress = $event.detail.progress" 
                                    >
                                        <!-- <div class="row">
                                            <div class="col-md-12">
                                                
                                                <button class="btn btn-icon btn-2 btn-primary float-start" id="plateImage" type="button">
                                                    <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                                </button>
                                            </div>
                                        </div> -->
                                        <!-- File Input -->
                                        <input type="file" id="dashImage2File" wire:model="dash_image2" accept="image/*" capture style="display:none"/>
                                        <!-- Progress Bar -->
                                        <div x-show="isUploading">
                                            <progress max="100" x-bind:value="progress"></progress>
                                        </div>
                                    </div>

                                    <img class="img-fluid img-thumbnail shadow" id="dashImage2" src="@if ($dash_image2) {{$dash_image2->temporaryUrl()}} @elseif($existingdash_image2) {{ url('public/storage/'.$existingdash_image2)}} @else {{asset('img/dashImage2.jpg')}} @endif" style="cursor:pointer"  />
                                    @error('dash_image2') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                            </div>
                            <div class="row m-4">
                                <div class="col-md-6 col-sm-6">
                                    <div 
                                    x-data="{ isUploading: false, progress: 0 }" 
                                    x-on:livewire-upload-start="isUploading = true" 
                                    x-on:livewire-upload-finish="isUploading = false" 
                                    x-on:livewire-upload-error="isUploading = false" 
                                    x-on:livewire-upload-progress="progress = $event.detail.progress" 
                                    >
                                        <!-- <div class="row">
                                            <div class="col-md-12">
                                                
                                                <button class="btn btn-icon btn-2 btn-primary float-start" id="plateImage" type="button">
                                                    <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                                </button>
                                            </div>
                                        </div> -->
                                        <!-- File Input -->
                                        <input type="file" id="passengerSeatImageFile" wire:model="passenger_seat_image" accept="image/*" capture style="display:none"/>
                                        <!-- Progress Bar -->
                                        <div x-show="isUploading">
                                            <progress max="100" x-bind:value="progress"></progress>
                                        </div>
                                    </div>
                                    
                                    <img class="img-fluid img-thumbnail shadow" id="passengerSeatImage" src="@if($passenger_seat_image) {{$passenger_seat_image->temporaryUrl()}} @elseif($existingpassenger_seat_image) {{ url('public/storage/'.$existingpassenger_seat_image)}} @else {{asset('img/passangerSeat1.jpg')}} @endif" style="cursor:pointer"  />
                                    @error('passenger_seat_image') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div 
                                    x-data="{ isUploading: false, progress: 0 }" 
                                    x-on:livewire-upload-start="isUploading = true" 
                                    x-on:livewire-upload-finish="isUploading = false" 
                                    x-on:livewire-upload-error="isUploading = false" 
                                    x-on:livewire-upload-progress="progress = $event.detail.progress" 
                                    >
                                        <!-- <div class="row">
                                            <div class="col-md-12">
                                                
                                                <button class="btn btn-icon btn-2 btn-primary float-start" id="plateImage" type="button">
                                                    <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                                </button>
                                            </div>
                                        </div> -->
                                        <!-- File Input -->
                                        <input type="file" id="driverSeatImageFile" wire:model="driver_seat_image" accept="image/*" capture style="display:none;"/>
                                        <!-- Progress Bar -->
                                        <div x-show="isUploading">
                                            <progress max="100" x-bind:value="progress"></progress>
                                        </div>
                                    </div>
                                    
                                    <img class="img-fluid img-thumbnail shadow" id="driverSeatImage" src="@if($driver_seat_image) {{$driver_seat_image->temporaryUrl()}} @elseif($existingdriver_seat_image) {{ url('public/storage/'.$driver_seat_image)}} @else {{asset('img/driverSeat1.jpg')}} @endif" style="cursor:pointer"  />
                                    @error('driver_seat_image') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div 
                                    x-data="{ isUploading: false, progress: 0 }" 
                                    x-on:livewire-upload-start="isUploading = true" 
                                    x-on:livewire-upload-finish="isUploading = false" 
                                    x-on:livewire-upload-error="isUploading = false" 
                                    x-on:livewire-upload-progress="progress = $event.detail.progress" 
                                    >
                                        <!-- <div class="row">
                                            <div class="col-md-12">
                                                
                                                <button class="btn btn-icon btn-2 btn-primary float-start" id="plateImage" type="button">
                                                    <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                                </button>
                                            </div>
                                        </div> -->
                                        <!-- File Input -->
                                        <input type="file" id="backSeat1ImageFile" wire:model="back_seat1" accept="image/*" capture style="display:none;"/>
                                        <!-- Progress Bar -->
                                        <div x-show="isUploading">
                                            <progress max="100" x-bind:value="progress"></progress>
                                        </div>
                                    </div>

                                    <img class="img-fluid img-thumbnail shadow" id="backSeat1Image" src="@if($back_seat1) {{$back_seat1->temporaryUrl()}} @elseif($existingback_seat1) {{ url('public/storage/'.$existingback_seat1)}} @else {{asset('img/backSeat1.jpg')}} @endif" style="cursor:pointer"  />
                                    @error('back_seat1') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div 
                                    x-data="{ isUploading: false, progress: 0 }" 
                                    x-on:livewire-upload-start="isUploading = true" 
                                    x-on:livewire-upload-finish="isUploading = false" 
                                    x-on:livewire-upload-error="isUploading = false" 
                                    x-on:livewire-upload-progress="progress = $event.detail.progress" 
                                    >
                                        <!-- <div class="row">
                                            <div class="col-md-12">
                                                
                                                <button class="btn btn-icon btn-2 btn-primary float-start" id="plateImage" type="button">
                                                    <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                                </button>
                                            </div>
                                        </div> -->
                                        <!-- File Input -->
                                        <input type="file" id="backSeat2ImageFile" wire:model="back_seat2" accept="image/*" capture style="display:none;"/>
                                        <!-- Progress Bar -->
                                        <div x-show="isUploading">
                                            <progress max="100" x-bind:value="progress"></progress>
                                        </div>
                                    </div>

                                    <img class="img-fluid img-thumbnail shadow" id="backSeat2Image" src="@if($back_seat2) {{$back_seat2->temporaryUrl()}} @elseif($existingback_seat2) {{ url('public/storage/'.$existingback_seat2)}} @else {{asset('img/backSeat2.jpg')}} @endif" style="cursor:pointer"   />
                                    @error('back_seat2') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div 
                                    x-data="{ isUploading: false, progress: 0 }" 
                                    x-on:livewire-upload-start="isUploading = true" 
                                    x-on:livewire-upload-finish="isUploading = false" 
                                    x-on:livewire-upload-error="isUploading = false" 
                                    x-on:livewire-upload-progress="progress = $event.detail.progress" 
                                    >
                                        <!-- <div class="row">
                                            <div class="col-md-12">
                                                
                                                <button class="btn btn-icon btn-2 btn-primary float-start" id="plateImage" type="button">
                                                    <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                                </button>
                                            </div>
                                        </div> -->
                                        <!-- File Input -->
                                        <input type="file" id="backSeat3ImageFile" wire:model="back_seat3" accept="image/*" capture style="display:none;"/>
                                        <!-- Progress Bar -->
                                        <div x-show="isUploading">
                                            <progress max="100" x-bind:value="progress"></progress>
                                        </div>
                                    </div>

                                    <img class="img-fluid img-thumbnail shadow" id="backSeat3Image" src="@if($back_seat3) {{$back_seat3->temporaryUrl()}} @elseif($existingback_seat3) {{ url('public/storage/'.$existingback_seat3)}} @else {{asset('img/backSeat1.jpg')}} @endif" style="cursor:pointer"  />
                                    @error('back_seat3') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div 
                                    x-data="{ isUploading: false, progress: 0 }" 
                                    x-on:livewire-upload-start="isUploading = true" 
                                    x-on:livewire-upload-finish="isUploading = false" 
                                    x-on:livewire-upload-error="isUploading = false" 
                                    x-on:livewire-upload-progress="progress = $event.detail.progress" 
                                    >
                                        <!-- <div class="row">
                                            <div class="col-md-12">
                                                
                                                <button class="btn btn-icon btn-2 btn-primary float-start" id="plateImage" type="button">
                                                    <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                                </button>
                                            </div>
                                        </div> -->
                                        <!-- File Input -->
                                        <input type="file" id="backSeat4ImageFile1" wire:model="back_seat4" accept="image/*" capture style="display:none;"/>
                                        <!-- Progress Bar -->
                                        <div x-show="isUploading">
                                            <progress max="100" x-bind:value="progress"></progress>
                                        </div>
                                    </div>
                                    
                                    <img class="img-fluid img-thumbnail shadow" id="backSeat4Image1" src="@if($back_seat4) {{$back_seat4->temporaryUrl()}} @elseif($existingback_seat4) {{ url('public/storage/'.$existingback_seat4)}} @else {{asset('img/backSeat2.jpg')}} @endif" style="cursor:pointer"   />
                                    @error('back_seat4') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div 
                                    x-data="{ isUploading: false, progress: 0 }" 
                                    x-on:livewire-upload-start="isUploading = true" 
                                    x-on:livewire-upload-finish="isUploading = false" 
                                    x-on:livewire-upload-error="isUploading = false" 
                                    x-on:livewire-upload-progress="progress = $event.detail.progress" 
                                    >
                                        <!-- <div class="row">
                                            <div class="col-md-12">
                                                
                                                <button class="btn btn-icon btn-2 btn-primary float-start" id="plateImage" type="button">
                                                    <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                                </button>
                                            </div>
                                        </div> -->
                                        <!-- File Input -->
                                        <input type="file" id="backSeat3ImageFile1" wire:model="roof_images" accept="image/*" capture style="display:none;"/>
                                        <!-- Progress Bar -->
                                        <div x-show="isUploading">
                                            <progress max="100" x-bind:value="progress"></progress>
                                        </div>
                                    </div>

                                    <img class="img-fluid img-thumbnail shadow" id="backSeat3Image1" src="@if($roof_images) {{$roof_images->temporaryUrl()}} @elseif($existingroof_images) {{ url('public/storage/'.$existingroof_images)}} @else {{asset('img/roofimage1.jpg')}} @endif" style="cursor:pointer"  />
                                    @error('roof_images') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($showTermsandCondition)
            <div class="row mt-3">
                <h6 class="text-uppercase text-body text-dark text-lg font-weight-bolder mt-2">Terms & Conditions</h6>
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-body text-left pt-4">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <img class="w-100" src="{{asset('img/checklist/gs-checkl-tc.png')}}" id="upfile6" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        
        @if($showSignaturePad)
            <!--Signature pad -->
            <div class="row mt-3">
                <h6 class="text-uppercase text-body text-dark text-lg font-weight-bolder mt-2">Customer Signature</h6>
                <div class="col-xxs-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 float-end">
                    <button type="button" class="btn btn-primary btn-lg mb-0 float-end" wire:click="clickShowSignature()">Customer Signature</button>
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
                <div class="col-xxs-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-4  float-end">
                    @if($customerSignature)
                    <div class="position-relative float-end">
                        <a class="d-block blur-shadow-image">
                            <img src="{{$customerSignature}}" alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        @endif
        @if($customerSignature || $showCheckout)
            <div class="row mt-3" id="checkoutSignature">
                <h6 class="text-uppercase text-body text-dark text-lg font-weight-bolder mt-2">Paymnet Confirmation</h6>
                <div class="col-md-12 mb-4" >
                    <div class="card p-2 mb-4">
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card p-2 mb-0">
                                        <div class="card-body text-center pt-0">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p><span class="badge rounded-pill bg-light text-dark text-md">Total: <small>AED</small> {{ custom_round($total) }}</span></p>
                                                    @if($totalAfterDisc>0 )
                                                    <p><span class="badge rounded-pill bg-light text-dark text-md">Discount: <small>AED</small> {{ custom_round($totalAfterDisc) }}</span></p>
                                                    @endif
                                                    <p><span class="badge rounded-pill bg-light text-dark text-md">VAT: <small>AED</small> {{ custom_round($tax) }}</span></p>
                                                    <p><span class="badge rounded-pill bg-dark text-light text-lg text-bold">Grand total: <small>AED</small> {{ custom_round($grand_total) }}</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($showSendSmsPannel && $mobile)
                                <div class="col-md-6">
                                    <div class="card p-2 mb-0">
                                        <div class="card-header text-left pt-4 pb-3">
                                            <h6 class="mt-2">SMS Confirmation in Job Update</h6>
                                            <hr>
                                        </div>
                                        <div class="card-body text-lg-left text-left pt-0">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" wire:model="jobUpdateSendSMS" name="flexRadioDefault" id="jobUpdateSendSMS1" value="yes">
                                                        <label class="custom-control-label" for="customRadio1">Send SMS</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input " type="radio"  wire:model="jobUpdateSendSMS" name="flexRadioDefault" id="jobUpdateSendSMS2" value="no">
                                                        <label class="custom-control-label text-danger" for="customRadio2">Do Not Send SMS</label>
                                                    </div>
                                                    @error('jobUpdateSendSMS') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="card-footer text-lg-left text-center pt-0">
                            <div class="d-flex justify-content-center p-2">
                                @if($package_job)
                                    <div class="form-check">
                                        <a wire:click="completePaymnet('empty')"  wire:loading.attr="disabled" class="btn btn-icon bg-gradient-success d-lg-block mt-3 mb-0">Complete<i class="fa-regular fa-money-bill-1 ms-1"></i></a>
                                    </div>
                                @elseif($grand_total>0)
                                    @if($mobile)
                                    <div class="form-check">
                                        <a wire:click="completePaymnet('link')" wire:loading.attr="disabled" class="btn btn-icon bg-gradient-info d-lg-block mt-3 mb-0">Pay By Link<i class="fa-solid fa-comments-dollar ms-1" ></i></a>
                                    </div>
                                    @endif
                                
                                    <div class="form-check">
                                        <a wire:click="completePaymnet('card')" wire:loading.attr="disabled" class="btn btn-icon bg-gradient-success d-lg-block mt-3 mb-0">Pay By Card<i class="fa-solid fa-credit-card ms-1" ></i></a>
                                    </div>
                                
                                    <div class="form-check">
                                        <a wire:click="completePaymnet('cash')" wire:loading.attr="disabled" class="btn btn-icon bg-gradient-danger d-lg-block mt-3 mb-0">Cash Payment<i class="fa-solid fa-money-bill-1-wave ms-1" ></i></a>
                                    </div>
                                    <div class="form-check">
                                        <a wire:click="payLater('paylater')" wire:loading.attr="disabled" class="btn btn-icon bg-gradient-secondary d-lg-block mt-3 mb-0">Pay Later<i class="fa-regular fa-money-bill-1 ms-1"></i></a>
                                    </div>
                                @else
                                    <div class="form-check">
                                        <a wire:click="completePaymnet('fulldiscount')" wire:loading.attr="disabled" class="btn btn-icon bg-gradient-danger d-lg-block mt-3 mb-0">Complete<i class="fa-solid fa-money-bill-1-wave ms-1" ></i></a>
                                    </div>
                                    
                                @endif

                                
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
        @if($showCustomerSignature)
        @include('components.modals.customerSignatureModel')
        @endif
    </div>
</main>
@push('custom_script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    window.addEventListener('refreshPage',event=>{
        location.reload();
    });
    window.addEventListener('imageUpload',event=>{
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
        $("#dashImage1").click(function () {
            $("#dashImage1File").trigger('click');
        });
        $("#dashImage2").click(function () {
            $("#dashImage2File").trigger('click');
        });
        $("#passengerSeatImage").click(function () {
            $("#passengerSeatImageFile").trigger('click');
        });
        $("#driverSeatImage").click(function () {
            $("#driverSeatImageFile").trigger('click');
        });
        $("#backSeat1Image").click(function () {
            $("#backSeat1ImageFile").trigger('click');
        });
        $("#backSeat2Image").click(function () {
            $("#backSeat2ImageFile").trigger('click');
        });
        $("#backSeat3Image").click(function () {
            $("#backSeat3ImageFile").trigger('click');
        });
        $("#backSeat4Image1").click(function () {
            $("#backSeat4ImageFile1").trigger('click');
        });
        $("#backSeat3Image1").click(function () {
            $("#backSeat3ImageFile1").trigger('click');
        });
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
    $("#dashImage1").click(function () {
        $("#dashImage1File").trigger('click');
    });
    $("#dashImage2").click(function () {
        $("#dashImage2File").trigger('click');
    });
    $("#passengerSeatImage").click(function () {
        $("#passengerSeatImageFile").trigger('click');
    });
    $("#driverSeatImage").click(function () {
        $("#driverSeatImageFile").trigger('click');
    });
    $("#backSeat1Image").click(function () {
        $("#backSeat1ImageFile").trigger('click');
    });
    $("#backSeat2Image").click(function () {
        $("#backSeat2ImageFile").trigger('click');
    });
    $("#backSeat3Image").click(function () {
        $("#backSeat3ImageFile").trigger('click');
    });
    $("#backSeat4Image1").click(function () {
        $("#backSeat4ImageFile1").trigger('click');
    });
    $("#backSeat3Image1").click(function () {
        $("#backSeat3ImageFile1").trigger('click');
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
@endpush
