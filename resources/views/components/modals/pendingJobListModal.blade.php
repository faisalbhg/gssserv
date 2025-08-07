<style>
    .modal-dialog {
        max-width: 90% !important;
    }
    .modal{
        z-index: 99999;
    }
</style>
<!-- Modal -->
<div wire:ignore.self  class="modal fade bd-example-modal-lg" id="pendingJobListModal" tabindex="-1" role="dialog" aria-labelledby="pendingJobListModalLabel" aria-hidden="true" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title" id="pendingJobListModalLabel">Pending Job List</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span class="text-dark" aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <div class="row">
                    @foreach($pendingExistingJobs as $pendingJob)
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header text-center pt-4 pb-3">

                                <div class="card card-background move-on-hover">
                                    <div class="full-background" style="background-image: url('{{url("public/storage/".$pendingJob->vehicle_image)}}')"></div>
                                    <div class="card-body pt-5">
                                        <h4 class="text-white mb-0 pb-0">
                                            @if($pendingJob->customer_name)
                                                {{$pendingJob->customer_name}}
                                            @else
                                            Guest
                                            @endif
                                        </h4>
                                        <p class="mt-0 pt-0"><small>{{$pendingJob->customer_name}}, {{$pendingJob->customer_mobile}}</small></p>
                                        <p class="mb-0">{{$pendingJob->makeInfo['vehicle_name'] }} - {{$pendingJob->modelInfo['vehicle_model_name'] }}</p>
                                        <h4 class="text-white mb-0 pb-0">
                                            {{$pendingJob->plate_number}}
                                        </h4>
                                    </div>
                                </div>
                                <h4 class="font-weight-bold mt-2">{{$pendingJob->job_number}}</h4>
                                <h6 class="font-weight-bold mt-2 {{config('global.jobs.status_text_class')[$pendingJob->job_status]}}">{{config('global.jobs.status')[$pendingJob->job_status]}}</h6>
                            </div>
                            <div class="card-body text-lg-left text-left pt-0">
                                @foreach($pendingJob->customerJobServices as $custJobService)
                                    <div class="d-flex justify-content-lg-start justify-content-left p-2">
                                        <div class="icon icon-shape icon-xs rounded-circle {{config('global.jobs.status_btn_class')[$custJobService->job_status]}} shadow text-center">
                                            <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                            <span class="ps-3">{{$custJobService->item_name}}<small>({{$custJobService->item_code}})</small></span>
                                        </div>
                                    </div>
                                @endforeach
                                

                                <a href="{{url('customer-service-job/'.$pendingJob->customer_id.'/'.$pendingJob->vehicle_id.'/'.$pendingJob->job_number)}}" class="btn btn-icon bg-gradient-danger d-lg-block mt-3 mb-0">Update Job<i class="fas fa-arrow-right ms-1" aria-hidden="true"></i></a><!-- 
                                <a href="{{url('customer-job-update/'.$pendingJob->job_number)}}" class="btn btn-icon bg-gradient-primary d-lg-block mt-3 mb-0">Status Update<i class="fas fa-arrow-right ms-1" aria-hidden="true"></i></a> -->
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

