<main class="main-content">
    <div class="container-fluid py-4">
        <div class="row ">
            <div class="col-md-12">
                <div class="card mb-4 p-4">
                    <div class="card-body px-0 pt-0 pb-2 ">
                        <span class="w-100 badge badge-sm {!!config('global.jobs.status_btn_class')[$jobDetails->job_status]!!}">{{config('global.jobs.status')[$jobDetails->job_status]}}</span>
                        <div class="progress-wrapper">
                            <div class="progress-info">
                                <div class="progress-percentage text-center">
                                    <span class="text-sm font-weight-bold">{{config('global.jobs.status_perc')[$jobDetails->job_status]}}</span>
                                </div>
                            </div>
                            <div class="progress">
                                <div class="progress-bar {{config('global.jobs.status_perc_class')[$jobDetails->job_status]}}" role="progressbar" aria-valuenow="{{config('global.jobs.status_perc')[$jobDetails->job_status]}}" aria-valuemin="0" aria-valuemax="100" style="width: {{config('global.status_perc')[$jobDetails->job_status]}};"></div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card mb-4 p-4">
                    <div class="card-body px-0 pt-0 pb-2 ">
                        <span class="w-100 badge badge-sm {{config('global.payment.status_class')[$jobDetails->payment_status]}}">Payment: {{config('global.payment.status')[$jobDetails->payment_status]}}</span>
                        <div class="text-center py-1">
                            <div class="d-flex flex-column justify-content-center">
                              <p class="text-sm font-weight-bold text-secondary mb-0"><span class="text-success">AED {{round($jobDetails->grand_total,2)}}</span></p>
                              <hr class="my-1">
                              @if($jobDetails->payment_type!=null)
                              <p class="text-sm text-gradient {{config('global.payment.text_class')[$jobDetails->payment_type]}}  font-weight-bold mb-0">{{config('global.payment.type')[$jobDetails->payment_type]}}</p>
                              @endif

                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card mb-4 p-4">
                    <div class="card-header p-0">
                        <h5 class="modal-title" id="serviceUpdateModalLabel">
                            <span class="float-start badge badge-lg {{config('global.payment.status_class')[$jobDetails->payment_status]}}"> #{{$job_number}}</span>
                            @if($jobDetails->job_status==3)
                            <a class="float-end btn btn-link text-dark p-0 m-0" wire:click="updateQwService({{$jobDetails}})">
                                <button class="btn btn-sm {{config('global.jobs.status_btn_class')[$jobDetails->job_status+1]}}">Mark as {{config('global.jobs.status')[$jobDetails->job_status+1]}}</button>
                            </a>
                            <div wire:loading wire:target="updateQwService">
                                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                    <div class="la-ball-beat">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </h5>
                    </div>
                    
                    <div class="card-body px-0 pt-0 pb-2 ">




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

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

