<main class="main-content">
    <div class="container-fluid py-4">
        <div class="row">

            <div class="col-md-12">
                <div class="card mb-4 p-4">
                    <div class="card-body px-0 pt-0 pb-2 ">
                        <button class="w-100 btn {{config('global.payment.status_class')[$jobDetails->payment_status]}} text-uppercase text-lg">Payment: {{config('global.payment.status')[$jobDetails->payment_status]}}</button>
                        @if($jobDetails->job_status==3)
                            @if($jobDetails->payment_type!=4)
                                @if($jobDetails->payment_status==1)
                                <button type="button"  wire:click="updateQwService({{$jobDetails}})" class="w-100 btn {!!config('global.jobs.status_btn_class')[$jobDetails->job_status+1]!!}"  >Mark as {{config('global.jobs.status')[$jobDetails->job_status+1]}}</button>
                                @endif    
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-md-12">
                <div class="card bg-cover text-center" style="background-image: url('{{url('public/storage/'.$jobDetails->vehicle_image)}}')">
                <div class="card-body z-index-2 py-9">
                <h2 class="text-white">{{$selectedVehicleInfo['plate_number_final']}}</h2>
                <p class="text-uppercase text-sm font-weight-bold mb-2 text-white">{{isset($selectedVehicleInfo->makeInfo)?$selectedVehicleInfo->makeInfo['vehicle_name']:''}}, {{isset($selectedVehicleInfo->modelInfo['vehicle_model_name'])?$selectedVehicleInfo->modelInfo['vehicle_model_name']:''}}</p>
                @if($selectedVehicleInfo['customerInfoMaster']['TenantName'])
                    @if($selectedVehicleInfo['customerInfoMaster']['TenantName'])
                    <p class="text-white mb-0">{{$selectedVehicleInfo['customerInfoMaster']['TenantName']}}</p>
                    @endif
                    @if($selectedVehicleInfo['customerInfoMaster']['Mobile'])
                    <p class="text-white mb-0">{{$selectedVehicleInfo['customerInfoMaster']['Mobile']}}</p>
                    @endif
                    @if($selectedVehicleInfo['customerInfoMaster']['Email'])
                    <p class="text-white mb-1">{{$selectedVehicleInfo['customerInfoMaster']['Email']}}</p>
                    @endif
                @else
                <p class="text-white mb-0">Customer Guest</p>
                @endif
                @if($selectedVehicleInfo['chassis_number'])
                <p class="text-white mb-1"><b>Chaisis:</b> {{$selectedVehicleInfo['chassis_number']}}</p>
                @endif
                @if($selectedVehicleInfo['vehicle_km'])
                <p class="text-white mb-1"><b>KM Reading:</b> {{$selectedVehicleInfo['vehicle_km']}}</p>
                @endif
                
                </div>
                <div class="mask {!!config('global.payment.status_class')[$jobDetails->payment_status]!!} border-radius-lg"></div>
                </div>
            </div>
            
        </div>
        <div class="row ">
            <div class="col-md-12">
                <div class="card mb-4 p-4">
                    <div class="card-body px-0 pt-0 pb-2 ">
                        <span class="w-100 badge badge-lg {{config('global.payment.status_class')[$jobDetails->payment_status]}}"> #{{$job_number}}</span>
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
            
        </div>
    </div>
</main>

