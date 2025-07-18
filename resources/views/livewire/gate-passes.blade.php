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
    @media (max-width: 991.98px) {
    :not(.navbar) .dropdown .dropdown-menu {
        opacity: 0;
        top: 30px !important;
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
        <section class="py-3">

            <div class="row">
                <div class="col-md-8 me-auto text-left">
                    <h5>Gate Pass {{ auth()->user('user')['stationName']['CorporateName']}}</h5>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-3 col-md-4 col-sm-4 mb-xl-2 mb-2">
                    <label>Job Number</label>
                    <div class="form-group">
                      <input style="padding:0.5rem 0.3rem !important;"  type="text"  class="form-control" placeholder="Search Job Number" wire:model="search_job_number" />
                      <div wire:loading wire:target="search_job_number">
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
                <div class="col-xl-3 col-md-4 col-sm-4 mb-xl-2 mb-2">
                    <label>Job Date</label>
                    <div class="form-group">
                      <input type="date"  class="form-control" placeholder="Search Job Date" wire:model="search_job_date" />
                      <div wire:loading wire:target="search_job_date">
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
                <div class="col-xl-3 col-md-4 col-sm-4 mb-xl-2 mb-2">
                    <label>Plate Search</label>
                    <div class="form-group">
                        <input style="padding:0.5rem 0.3rem !important;" type="text" id="plateNumber" class="form-control @error('plate_number') btn-outline-danger @enderror" wire:model="search_plate_number" name="plate_number" placeholder="Number Plate">
                        <div wire:loading wire:target="search_plate_number">
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

                <div class="col-xl-3 col-md-4 col-sm-4 mb-xl-2 mb-2">
                    <label>CT Number</label>
                    <div class="form-group">
                        <input style="padding:0.5rem 0.3rem !important;"  type="text"  class="form-control" placeholder="Search CT Number" wire:model="search_ct_number" />
                        <div wire:loading wire:target="search_ct_number">
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
                <div class="col-xl-3 col-md-4 col-sm-4 mb-xl-2 mb-2">
                    <label>Meeter Number</label>
                    <div class="form-group">
                        <input style="padding:0.5rem 0.3rem !important;"  type="text"  class="form-control" placeholder="Search Meeter Number" wire:model="search_meeter_number" />
                        <div wire:loading wire:target="search_meeter_number">
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
            <div class="row mt-lg-4 mt-2">
                
                @forelse($jobsResults as $job)
                    <div class="col-lg-4 col-md-4 col-sm-6 mb-4">
                        <div class="card">
                            <div class="card-body p-3">
                                <div class="d-flex">
                                    <div class="avatar avatar-xl bg-gradient-dark border-radius-md p-0 shadow">
                                        <img src="{{url('public/storage/'.$job->vehicle_image)}}" alt="slack_logo">
                                    </div>
                                    <div class="ms-3 my-auto">
                                        <h6 class="text-primary mb-0 mt-0 ">{{$job->plate_number}}</h6>
                                        <h6 class="mb-0 mt-0">#{{$job->job_number}}</h6>
                                        <h6 class="mb-0 text-sm mt-0">{{$job->makeInfo['vehicle_name']}} - <small>{{$job->modelInfo['vehicle_model_name']}} </small></h6>
                                        @if($job->payment_type==4 && $job->payment_status==0)
                                            <button class="btn bg-gradient-success" type="button">
                                                <span class="btn-inner--icon"><i class="fa-solid fa-money-bill-1-wave ms-1 fs-xl" style="font-size: 1.5em;" ></i></span>
                                                CREDIT
                                                    
                                            </button>
                                        @else
                                        <button class="btn {!!config('global.payment.status_class')[$job->payment_status]!!}" type="button">
                                            <span class="btn-inner--icon"><i class="fa-solid fa-money-bill-1-wave ms-1 fs-xl" style="font-size: 1.5em;" ></i></span>
                                            {!!config('global.payment.status')[$job->payment_status]!!}
                                                
                                        </button>
                                        @endif
                                    </div>
                                    
                                </div>
                                <hr class="m-0">
                                <p class="text-sm text-dark mb-0"><i class="fa-solid fa-user text-default mt-3"></i> {{$job->customerInfo['TenantName']}}
                                    @if(isset($job->customerInfo['Mobile']))
                                    <br><i class="fa-solid fa-phone text-dark mb-0"></i> {{$job->customerInfo['Mobile']}}
                                    @endif
                                    @if(isset($job->customerInfo['Email']))
                                    <br><i class="fa-solid fa-envelope text-dark mb-0"></i> {{$job->customerInfo['Email']}}
                                    @endif
                                </p>
                                <hr class="horizontal dark">
                                <div class="row">
                                    <div class="col-12">

                                        @if($job->job_status==3)
                                            @if($job->payment_type!=4)
                                                @if($job->payment_status==1)
                                                    <button type="button"  wire:click="updateQwService('{{$job->job_number}}','4','{{$job->customerInfo['TenantId']}}')" class="w-100 btn {!!config('global.jobs.status_btn_class')[$job->job_status+1]!!}"  >Mark as {{config('global.jobs.status')[$job->job_status+1]}}</button>
                                                @endif

                                            @elseif($job->payment_type==4 && $job->payment_status==0)
                                            <button type="button"  wire:click="updateQwService('{{$job->job_number}}','4','{{$job->customerInfo['TenantId']}}')" class="w-100 btn {!!config('global.jobs.status_btn_class')[$job->job_status+1]!!}"  >Mark as {{config('global.jobs.status')[$job->job_status+1]}}</button>
                                            @endif
                                        @else
                                        <button type="button"  wire:click="updateQwService('{{$job->job_number}}','4','{{$job->customerInfo['TenantId']}}')" class="w-100 btn {!!config('global.jobs.status_btn_class')[$job->job_status+1]!!}"  >Mark as {{config('global.jobs.status')[$job->job_status+1]}}</button>
                                        @endif
                                        <!-- <small class="text-secondary mb-0">{{ \Carbon\Carbon::parse($job->created_at)->format('d-m-y h:i A') }}</small> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
            <div wire:loading wire:target="updateQwService">
                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                    <div class="la-ball-beat">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <div class="float-end">{{$jobsResults->onEachSide(0)->links()}}</div>
            
        </section>
    </div>
</main>
@push('custom_script')

@endpush