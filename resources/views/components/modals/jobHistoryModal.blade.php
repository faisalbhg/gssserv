<style>
    .modal-dialog {
        max-width: 90% !important;
    }
    .modal{
        z-index: 99999;
    }
</style>
<!-- Modal -->
<div wire:ignore.self  class="modal fade bd-example-modal-lg" id="jobHIstoryModal" tabindex="-1" role="dialog" aria-labelledby="jobHIstoryModalLabel" aria-hidden="true" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title" id="jobHIstoryModalLabel">Jobs History</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span class="text-dark" aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <div class="row">
                    @foreach($jobsHistory as $jobHistory)
                    <div class="col-md-4 mb-4">
                        <div class="card card-pricing">
                            <div class="card-header text-center pt-4 pb-3">
                                <div class="card card-background move-on-hover">
                                    <div class="full-background" style="background-image: url('{{url("public/storage/".$selectedVehicleInfo["vehicle_image"])}}')"></div>
                                    <div class="card-body pt-5">
                                        <h4 class="text-white mb-0 pb-0">
                                            @if($selectedVehicleInfo['customerInfoMaster']['TenantName'])
                                                {{$selectedVehicleInfo['customerInfoMaster']['TenantName']}}
                                            @else
                                            Guest
                                            @endif
                                        </h4>
                                        <p class="mt-0 pt-0"><small>{{$selectedVehicleInfo['customerInfoMaster']['Email']}}, {{$selectedVehicleInfo['customerInfoMaster']['Mobile']}}</small></p>
                                        <p class="mb-0">{{isset($selectedVehicleInfo['makeInfo'])?$selectedVehicleInfo['makeInfo']['vehicle_name']:''}}, {{isset($selectedVehicleInfo['modelInfo']['vehicle_model_name'])?$selectedVehicleInfo['modelInfo']['vehicle_model_name']:''}}</p>
                                        <h4 class="text-white mb-0 pb-0">
                                            {{$selectedVehicleInfo['plate_number_final']}}
                                        </h4>
                                    </div>
                                </div>
                                <h4 class="font-weight-bold mt-2 {{config('global.jobs.status_text_class')[$jobHistory->job_status]}}">{{$jobHistory->job_number}}</h4>
                                <i class="far fa-calendar-alt me-2" aria-hidden="true"></i>
                                <small>{{ \Carbon\Carbon::parse($jobHistory->job_date_time)->format('dS M Y h:i A') }}</small>
                            </div>
                            
                            <div class="card-body text-center">
                                <ul class="list-unstyled max-width-200 mx-auto">
                                    @foreach($jobHistory->customerJobServices as $custJobService)
                                    <li>
                                        <b><div class="icon icon-shape icon-xs rounded-circle {{config('global.jobs.status_btn_class')[$custJobService->job_status]}} shadow text-center">
                                            <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                        </div></b> {{$custJobService->item_name}}<small>({{$custJobService->item_code}})</small>
                                        <hr class="horizontal dark">
                                    </li>
                                    @endforeach
                                </ul>
                                <button class="btn bg-gradient-dark w-100 mt-4 mb-0 cusrsor-pointer" wire:click="makeNewSameJob('{{$jobHistory->job_number}}')">
                                    Make Same Job
                                </button>
                                <div wire:loading wire:target="makeNewSameJob">
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
                    @endforeach
                    
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-gradient-primary">Submit</button> -->
            </div>
            
        </div>
    </div>
</div>

