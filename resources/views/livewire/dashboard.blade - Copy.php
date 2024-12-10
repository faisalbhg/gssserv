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
    .right{
      direction: rtl;
    }
    .right li{
        list-style: arabic-indic;
    }
    .left li{
        list-style: binary;
    }
    
    

    .imagediv {
    float:left;
    margin-top:50px;
}
.imagediv .showonhover {
    background:red;
    padding:20px;
    opacity:0.9;
    color:white;
    width: 100%;
    display:block;  
    text-align:center;
    cursor:pointer;
}
</style>

<!-- Signature Pad Style -->
<style type="text/css">
    .wrapper {
      position: relative;
      width: 450px;
      height: 200px;
      -moz-user-select: none;
      -webkit-user-select: none;
      -ms-user-select: none;
      user-select: none;
      /*boreder:1px solid #000;
      border-radius: 13px;*/
    }

    .signature-pad {
      position: absolute;
      left: 0;
      top: 0;
      width:400px;
      height:200px;
    }

    .wrapper1 {
      position: relative;
      height:500px;
      -moz-user-select: none;
      -webkit-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    .signature-pad1 {
      position: absolute;
      left: 0;
      top: 0;
      
    }


</style>
<!-- End Signature Pad Style -->

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

        
        <div class="row mt-2">
            <div class="col-lg-6 col-7">
                <h6>{{count($pendingCustomersCart)}} - Ongoing Customers</h6>
            </div>
            <div class="col-lg-6 col-5 my-auto text-end">
                @if($newVehicleSearch)
                <button class="btn btn-icon btn-sm btn-3 bg-gradient-primary" type="button" wire:click="newVehicleOpen">
                    
                    <span class="btn-inner--icon"><i style="font-size: 1.5em;" class="fa-solid fa-car fa-xl"></i></span>
                    <span class="btn-inner--text">New Vehicle</span>
                </button>
                @endif
            </div>
        </div>
        <hr class="horizontal dark mt-0 mb-1">
        @if($selectedCustomerVehicle)
        <div class="row">
            <div class="col-md-12">
                <div class="card card-profile card-plain">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="javascript:;">
                                <div class="position-relative">
                                    <div class="blur-shadow-image">
                                        <img class="w-100 rounded-3 shadow-lg" src="{{url('storage/'.$selectedVehicleInfo['vehicle_image'])}}">
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-8 ps-0 my-auto">
                            <div class="card-body text-left">
                                <div class="p-md-0 pt-3">
                                    <h5 class="font-weight-bolder mb-0">{{$selectedVehicleInfo['name']}}</h5>
                                    <p class="text-sm font-weight-bold mb-2 text-capitalize"> - {{strtolower(str_replace("_"," ",$selectedVehicleInfo['customerType']))}}</p>
                                </div>
                                <p class="mb-4"><b>Vehicle:</b> {{$selectedVehicleInfo['vehicleName']}}, {{$selectedVehicleInfo['model']}}
                                    <br>
                                    <b>Plate Number:</b> {{$selectedVehicleInfo['plate_number_final']}}</p>
                                <p class="mb-4"><b>Chaisis:</b> {{$selectedVehicleInfo['chassis_number']}}
                                    <br>
                                    <b>KM Reading:</b> {{$selectedVehicleInfo['vehicle_km']}}</p>
                                <button type="button" class="btn btn-primary btn-simple btn-lg mb-0 px-2" wire:click="editCustomer()">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button type="button" class="btn btn-warning btn-simple btn-lg mb-0 px-2" wire:click="addNewVehicle({{$customer_id}})">
                                    <i class="fa-solid fa-square-plus"></i>
                                </button>
                                <button type="button" class="d-none btn btn-danger btn-simple btn-lg mb-0 px-2">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>

                                <div wire:loading wire:target="editCustomer">
                                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                        <div class="la-ball-beat">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                </div>

                                <div wire:loading wire:target="addNewVehicle">
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
        </div>
        @endif
        <div class="row">
            
            @if($newcustomeoperation)
            @include('components.newcustomeoperation')
            @endif
            <?php $arrayCustomersPendingJobs = []; ?>
            @if($showDashboard)
                @forelse($pendingCustomersCart as $pendingvehicle)
                    @if(!in_array($pendingvehicle->vehicle_id, $arrayCustomersPendingJobs))
                        <div class="col-xl-3 col-md-4 mb-xl-0 my-4">
                            <a href="javascript:;" wire:click="selectPendingVehicle({{$pendingvehicle}})" class="">
                                <div class="card card-background move-on-hover">
                                    <div class="full-background" style="background-image: url('{{url("storage/".$pendingvehicle->vehicleInfo["vehicle_image"])}}')"></div>
                                    <div class="card-body pt-5">
                                        <h4 class="text-white mb-0 pb-0">
                                            @if($pendingvehicle->customerInfo['name'])
                                                {{$pendingvehicle->customerInfo['name']}}
                                            @else
                                            Guest
                                            @endif
                                        </h4>
                                        <p class="mt-0 pt-0"><small>{{$pendingvehicle->customerInfo['email']}}, {{$pendingvehicle->customerInfo['mobile']}}</small></p>
                                        <p class="mb-0">{{$pendingvehicle->vehicleInfo['make']}}, {{$pendingvehicle->vehicleInfo['model']}}</p>
                                        <p>{{$pendingvehicle->vehicleInfo['plate_number_final']}}</p>
                                        <span class="text-xs">{{ \Carbon\Carbon::parse($pendingvehicle->created_at)->diffForHumans() }} </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php array_push($arrayCustomersPendingJobs, $pendingvehicle->vehicle_id);?>
                    @endif
                @empty
                @endforelse
            @endif



            
        </div>

        

        @if($showDashboard)
        <div class="row mt-4">
            <div class="col-lg-6 col-7">
                <h6>{{ count($pendingjobs)}} - Pending Payment Customers</h6>
            </div>
            <div class="col-lg-6 col-5 my-auto text-end">
                
            </div>
        </div>
        <hr class="horizontal dark mt-0 mb-1">
        <div class="row">
            @forelse($pendingjobs as $pendingjob)
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12">

                <a href="javascript:;"  wire:click="pendingPaymentClick('{{$pendingjob}}')">
                    <div class="card card-background ">
                        <div class="full-background" style="background-image: url('{{url("storage/".$pendingjob->customerVehicle["vehicle_image"])}}')"></div>
                        <div class="card-body pt-10">
                            <h4 class="text-white mb-0">{{$pendingjob->customerInfo['name']}}</h4>
                            <small>{{$pendingjob->customerInfo['mobile']}}</small>
                            <p>Vehicle: {{$pendingjob->customerVehicle['make']}}-{{$pendingjob->customerVehicle['model']}}</p>
                            <p>Plate Number: {{$pendingjob->customerVehicle['plate_number_final']}}</p>
                            <p><span class="badge "></span></p>
                            
                            <h6 class="text-white font-weight-bolder mt-2 mb-0">
                            {{$pendingjob->job_number}}
                            </h6>
                            
                            <button class="btn btn-icon btn-sm btn-3 bg-gradient-primary" type="button">
                                <span class="btn-inner--icon"><i class="ni ni-button-play"></i></span>
                                <span class="btn-inner--text">{{config('global.CURRENCY')}}{{number_format($pendingjob->grand_total,2)}}</span>
                            </button>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            @endforelse
        </div>
       
        <div class="row mt-2">
            <p class="h5 mt-2 px-4">Jobs Over View</p>
            <hr class="horizontal dark mt-0 mb-2">
            <div class="col-xl-3 col-md-4 col-sm-4 mb-xl-2 mb-2">
                <div class="card">
                    <div class="card-body p-3 cursor-pointer" wire:click="jobListPage('total')">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total jobs</p>
                                    <hr class="m-0">
                                    <h5 class="font-weight-bolder mb-0">{{$getCountSalesJob->total}}<span class="text-success text-sm font-weight-bolder"></span></h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow text-center border-radius-md">
                                    <i class="ni ni-archive-2 text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-4 col-sm-4 mb-xl-2 mb-2">
                <div class="card">
                    <div class="card-body p-3 cursor-pointer" wire:click="jobListPage('working_progress')">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Working Progress</p>
                                    <hr class="m-0">
                                    <h5 class="font-weight-bolder mb-0">{{$getCountSalesJob->working_progress}}<span class="text-success text-sm font-weight-bolder"></span></h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="fa-solid fa-hourglass-start text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-4 col-sm-4 mb-xl-2 mb-2">
                <div class="card">
                    <div class="card-body p-3 cursor-pointer" wire:click="jobListPage('work_finished')">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Work Completed</p>
                                    <hr class="m-0">
                                    <h5 class="font-weight-bolder mb-0">{{$getCountSalesJob->work_finished}}<span class="text-success text-sm font-weight-bolder"></span></h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                    <i class="fa-solid fa-hourglass-end text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-4 col-sm-4 mb-xl-2 mb-2">
                <div class="card">
                    <div class="card-body p-3 cursor-pointer" wire:click="jobListPage('ready_to_deliver')">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Ready to Deliver</p>
                                    <hr class="m-0">
                                    <h5 class="font-weight-bolder mb-0">{{$getCountSalesJob->ready_to_deliver}}<span class="text-success text-sm font-weight-bolder"></span></h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                    <i class="fa-solid fa-car opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-4 col-sm-4 mb-xl-2 mb-2">
                <div class="card">
                    <div class="card-body p-3 cursor-pointer" wire:click="jobListPage('delivered')">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Delivered</p>
                                    <hr class="m-0">
                                    <h5 class="font-weight-bolder mb-0">{{$getCountSalesJob->delivered}}<span class="text-success text-sm font-weight-bolder"></span></h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                    <i class="fa-solid fa-flag-checkered opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <div class="card mb-2">
                    <div class="card-header pb-0">
                        <h5>Service Jobs
                          <input type="text"  class="form-control float-end" style="width:20%;" placeholder="Search Job Number" wire:model="search_job_bumber" />
                        </h5>
                        <hr>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                          <table class="table align-items-center justify-content-center mb-0">
                            <thead>
                              <tr>
                                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Customer</th>
                                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Job Number</th>
                                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Time</th>
                                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Price</th>
                                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Payment Status</th>
                                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Payment Type</th>
                                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2 align-middle text-center">Status</th>
                                <!-- <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Department</th> -->
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                              @forelse( $customerjobs as $jobs)
                              <tr wire:click="dashCustomerJobUpdate('{{$jobs->job_number}}')">
                                <td>
                                  <div class="d-flex px-2">
                                    <div>
                                      <img src="{{url('storage/'.$jobs->vehicle_image)}}" class="avatar avatar-md me-2">
                                    </div>
                                    <div class="my-auto">
                                      <h6 class="mb-0 text-sm">{{$jobs->make}} - <small>{{$jobs->model}} ({{$jobs->plate_number_final}})</small></h6>
                                      <hr class="m-0">
                                      <p class="text-sm text-dark mb-0">{{$jobs->customerInfo['name']}}({{$jobs->customerInfo->customerType['customer_type']}})<br>{{$jobs->customerInfo['email']}}<br>{{$jobs->customerInfo['mobile']}}</p>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <p class="text-sm font-weight-bold mb-0">{{$jobs->job_number}}</p>
                                </td>
                                <td>
                                  <p class="text-sm font-weight-bold mb-0">{{ \Carbon\Carbon::parse($jobs->job_date_time)->format('dS M Y H:i A') }}</p>
                                </td>
                                
                                <td>
                                  <p class="text-sm font-weight-bold mb-0">AED {{round($jobs->grand_total,2)}}</p>
                                </td>
                                <td>
                                    <span class="badge badge-sm {{config('global.payment.status_class')[$jobs->payment_status]}}">{{config('global.payment.status')[$jobs->payment_status]}}</span>
                                </td>
                                <td>
                                    <p class="text-sm text-gradient {!!config('global.payment.text_class')[$jobs->payment_type]!!}  font-weight-bold mb-0">{{config('global.payment.type')[$jobs->payment_type]}}</p>
                                </td>
                                <td class="align-middle text-center">

                                  <span class="badge badge-sm {!!config('global.jobs.status_btn_class')[$jobs->job_status]!!}">{{config('global.jobs.status')[$jobs->job_status]}}</span>
                                  <div class="d-flex align-items-center justify-content-center">
                                    <span class="me-2 text-xs font-weight-bold">{{config('global.jobs.status_perc')[$jobs->job_status]}}</span>
                                    <div>
                                      <div class="progress">
                                        <div class="progress-bar {{config('global.jobs.status_perc_class')[$jobs->job_status]}}" role="progressbar" aria-valuenow="{{config('global.jobs.status_perc')[$jobs->job_status]}}" aria-valuemin="0" aria-valuemax="100" style="width: {{config('global.status_perc')[$jobs->job_status]}};"></div>
                                      </div>
                                    </div>
                                  </div>
                                </td>
                                
                                <td class="align-middle">
                                  <button type="button" wire:click="dashCustomerJobUpdate('{{$jobs->job_number}}')" class="btn btn-link text-secondary mb-0">
                                    <i class="fa fa-edit fa-xl text-md"></i>
                                  </button>
                                  <!-- data-bs-toggle="modal" data-bs-target="#serviceUpdateModal" -->
                                </td>
                              </tr>
                              @empty
                                <tr>
                                  <td colspan="8">No Record Found</td>
                                </tr>
                              @endforelse
                          </tbody>
                        </table>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="d-none row mt-2">
            <div class="col-lg-12 mb-lg-0 mb-2">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="bg-gradient-dark border-radius-lg py-3 pe-1 mb-3">
                            <div class="chart">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                            <canvas id="chart-bars" class="chart-canvas chartjs-render-monitor" height="170" style="display: block; width: 700px; height: 170px;" width="700"></canvas>
                            </div>
                        </div>
                        <h6 class="ms-2 mt-4 mb-0"> Active Customers </h6>
                        <!-- <p class="text-sm ms-2"> (<span class="font-weight-bolder">+23%</span>) than last week </p> -->
                        <div class="container border-radius-lg">
                            <div class="row">
                                <div class="col-3 py-3 ps-0">
                                    <div class="d-flex mb-2">
                                        <div class="icon icon-shape icon-xxs shadow border-radius-sm bg-gradient-primary text-center me-2 d-flex align-items-center justify-content-center">
                                            <svg width="10px" height="10px" viewBox="0 0 40 44" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <title>document</title>
                                                <g id="Basic-Elements" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <g id="Rounded-Icons" transform="translate(-1870.000000, -591.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                                <g id="Icons-with-opacity" transform="translate(1716.000000, 291.000000)">
                                                <g id="document" transform="translate(154.000000, 300.000000)">
                                                <path class="color-background" d="M40,40 L36.3636364,40 L36.3636364,3.63636364 L5.45454545,3.63636364 L5.45454545,0 L38.1818182,0 C39.1854545,0 40,0.814545455 40,1.81818182 L40,40 Z" id="Path" opacity="0.603585379"></path>
                                                <path class="color-background" d="M30.9090909,7.27272727 L1.81818182,7.27272727 C0.814545455,7.27272727 0,8.08727273 0,9.09090909 L0,41.8181818 C0,42.8218182 0.814545455,43.6363636 1.81818182,43.6363636 L30.9090909,43.6363636 C31.9127273,43.6363636 32.7272727,42.8218182 32.7272727,41.8181818 L32.7272727,9.09090909 C32.7272727,8.08727273 31.9127273,7.27272727 30.9090909,7.27272727 Z M18.1818182,34.5454545 L7.27272727,34.5454545 L7.27272727,30.9090909 L18.1818182,30.9090909 L18.1818182,34.5454545 Z M25.4545455,27.2727273 L7.27272727,27.2727273 L7.27272727,23.6363636 L25.4545455,23.6363636 L25.4545455,27.2727273 Z M25.4545455,20 L7.27272727,20 L7.27272727,16.3636364 L25.4545455,16.3636364 L25.4545455,20 Z" id="Shape"></path>
                                                </g>
                                                </g>
                                                </g>
                                                </g>
                                            </svg>
                                        </div>
                                        <p class="text-xs mt-1 mb-0 font-weight-bold">Customers</p>
                                    </div>
                                    <h4 class="font-weight-bolder">{{$getCountSalesJob->customers}}</h4>
                                    <div class="progress w-75">
                                        <div class="progress-bar bg-dark w-60" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-3 py-3 ps-0">
                                    <div class="d-flex mb-2">
                                        <div class="icon icon-shape icon-xxs shadow border-radius-sm bg-gradient-info text-center me-2 d-flex align-items-center justify-content-center">
                                            <svg width="10px" height="10px" viewBox="0 0 40 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <title>spaceship</title>
                                                <g id="Basic-Elements" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <g id="Rounded-Icons" transform="translate(-1720.000000, -592.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                                <g id="Icons-with-opacity" transform="translate(1716.000000, 291.000000)">
                                                <g id="spaceship" transform="translate(4.000000, 301.000000)">
                                                <path class="color-background" d="M39.3,0.706666667 C38.9660984,0.370464027 38.5048767,0.192278529 38.0316667,0.216666667 C14.6516667,1.43666667 6.015,22.2633333 5.93166667,22.4733333 C5.68236407,23.0926189 5.82664679,23.8009159 6.29833333,24.2733333 L15.7266667,33.7016667 C16.2013871,34.1756798 16.9140329,34.3188658 17.535,34.065 C17.7433333,33.98 38.4583333,25.2466667 39.7816667,1.97666667 C39.8087196,1.50414529 39.6335979,1.04240574 39.3,0.706666667 Z M25.69,19.0233333 C24.7367525,19.9768687 23.3029475,20.2622391 22.0572426,19.7463614 C20.8115377,19.2304837 19.9992882,18.0149658 19.9992882,16.6666667 C19.9992882,15.3183676 20.8115377,14.1028496 22.0572426,13.5869719 C23.3029475,13.0710943 24.7367525,13.3564646 25.69,14.31 C26.9912731,15.6116662 26.9912731,17.7216672 25.69,19.0233333 L25.69,19.0233333 Z" id="Shape"></path>
                                                <path class="color-background" d="M1.855,31.4066667 C3.05106558,30.2024182 4.79973884,29.7296005 6.43969145,30.1670277 C8.07964407,30.6044549 9.36054508,31.8853559 9.7979723,33.5253085 C10.2353995,35.1652612 9.76258177,36.9139344 8.55833333,38.11 C6.70666667,39.9616667 0,40 0,40 C0,40 0,33.2566667 1.855,31.4066667 Z" id="Path"></path>
                                                <path class="color-background" d="M17.2616667,3.90166667 C12.4943643,3.07192755 7.62174065,4.61673894 4.20333333,8.04166667 C3.31200265,8.94126033 2.53706177,9.94913142 1.89666667,11.0416667 C1.5109569,11.6966059 1.61721591,12.5295394 2.155,13.0666667 L5.47,16.3833333 C8.55036617,11.4946947 12.5559074,7.25476565 17.2616667,3.90166667 L17.2616667,3.90166667 Z" id="color-2" opacity="0.598539807"></path>
                                                <path class="color-background" d="M36.0983333,22.7383333 C36.9280725,27.5056357 35.3832611,32.3782594 31.9583333,35.7966667 C31.0587397,36.6879974 30.0508686,37.4629382 28.9583333,38.1033333 C28.3033941,38.4890431 27.4704606,38.3827841 26.9333333,37.845 L23.6166667,34.53 C28.5053053,31.4496338 32.7452344,27.4440926 36.0983333,22.7383333 L36.0983333,22.7383333 Z" id="color-3" opacity="0.598539807"></path>
                                                </g>
                                                </g>
                                                </g>
                                                </g>
                                            </svg>
                                        </div>
                                        <p class="text-xs mt-1 mb-0 font-weight-bold">Jobs</p>
                                    </div>
                                    <h4 class="font-weight-bolder">{{$getCountSalesJob->jobs}}</h4>
                                    <div class="progress w-75">
                                        <div class="progress-bar bg-dark w-90" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-3 py-3 ps-0">
                                    <div class="d-flex mb-2">
                                        <div class="icon icon-shape icon-xxs shadow border-radius-sm bg-gradient-warning text-center me-2 d-flex align-items-center justify-content-center">
                                            <svg width="10px" height="10px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <title>credit-card</title>
                                                <g id="Basic-Elements" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <g id="Rounded-Icons" transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                                <g id="Icons-with-opacity" transform="translate(1716.000000, 291.000000)">
                                                <g id="credit-card" transform="translate(453.000000, 454.000000)">
                                                <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" id="Path" opacity="0.593633743"></path>
                                                <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z" id="Shape"></path>
                                                </g>
                                                </g>
                                                </g>
                                                </g>
                                            </svg>
                                        </div>
                                        <p class="text-xs mt-1 mb-0 font-weight-bold">Sales</p>
                                    </div>
                                    <h4 class="font-weight-bolder">AED {{round($getCountSalesJob->saletotal, 2)}}</h4>
                                    <div class="progress w-75">
                                        <div class="progress-bar bg-dark w-30" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-3 py-3 ps-0">
                                    <div class="d-flex mb-2">
                                        <div class="icon icon-shape icon-xxs shadow border-radius-sm bg-gradient-danger text-center me-2 d-flex align-items-center justify-content-center">
                                            <svg width="10px" height="10px" viewBox="0 0 40 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <title>settings</title>
                                                <g id="Basic-Elements" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <g id="Rounded-Icons" transform="translate(-2020.000000, -442.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                                <g id="Icons-with-opacity" transform="translate(1716.000000, 291.000000)">
                                                <g id="settings" transform="translate(304.000000, 151.000000)">
                                                <polygon class="color-background" id="Path" opacity="0.596981957" points="18.0883333 15.7316667 11.1783333 8.82166667 13.3333333 6.66666667 6.66666667 0 0 6.66666667 6.66666667 13.3333333 8.82166667 11.1783333 15.315 17.6716667"></polygon>
                                                <path class="color-background" d="M31.5666667,23.2333333 C31.0516667,23.2933333 30.53,23.3333333 30,23.3333333 C29.4916667,23.3333333 28.9866667,23.3033333 28.48,23.245 L22.4116667,30.7433333 L29.9416667,38.2733333 C32.2433333,40.575 35.9733333,40.575 38.275,38.2733333 L38.275,38.2733333 C40.5766667,35.9716667 40.5766667,32.2416667 38.275,29.94 L31.5666667,23.2333333 Z" id="Path" opacity="0.596981957"></path>
                                                <path class="color-background" d="M33.785,11.285 L28.715,6.215 L34.0616667,0.868333333 C32.82,0.315 31.4483333,0 30,0 C24.4766667,0 20,4.47666667 20,10 C20,10.99 20.1483333,11.9433333 20.4166667,12.8466667 L2.435,27.3966667 C0.95,28.7083333 0.0633333333,30.595 0.00333333333,32.5733333 C-0.0583333333,34.5533333 0.71,36.4916667 2.11,37.89 C3.47,39.2516667 5.27833333,40 7.20166667,40 C9.26666667,40 11.2366667,39.1133333 12.6033333,37.565 L27.1533333,19.5833333 C28.0566667,19.8516667 29.01,20 30,20 C35.5233333,20 40,15.5233333 40,10 C40,8.55166667 39.685,7.18 39.1316667,5.93666667 L33.785,11.285 Z" id="Path"></path>
                                                </g>
                                                </g>
                                                </g>
                                                </g>
                                                </svg>
                                        </div>
                                        <p class="text-xs mt-1 mb-0 font-weight-bold">Services</p>
                                    </div>
                                    <h4 class="font-weight-bolder">{{$getAllSalesJob['totalJobServices']}}</h4>
                                    <div class="progress w-75">
                                        <div class="progress-bar bg-dark w-50" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-none row mt-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Sales overview</h6>
                        <p class="text-sm">
                            <i class="fa fa-arrow-up text-success" aria-hidden="true"></i>
                            <span class="font-weight-bold">4% more</span> in 2021
                        </p>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <canvas id="chart-line" class="chart-canvas chartjs-render-monitor" height="300" width="704" style="display: block; width: 704px; height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- components.modals.servicemodel -->
        <!--include('components.plugins.fixed-plugin')-->
        @include('components.modals.customerSignatureModel')
        @if($markCarScratch)
        @include('components.modals.serviceCarImageEdit')
        @endif
        <!-- <div class="fixed-plugin">
            <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
                <i class="fa-solid fa-cart-shopping py-2"> </i>
            </a>
            <div class="card shadow-lg ">
                <div class="card-header pb-0 pt-3 ">
                    <div class="float-start">
                        <h5 class="mt-3 mb-0">Service Buket</h5>
                        <p>{{ count($cartItems) }} Services selected</p>
                    </div>
                    <div class="float-end mt-4">
                        <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                            <i class="fa fa-close"></i>
                        </button>
                    </div>
                </div>
                <hr class="horizontal dark my-1">
                <div class="card-body pt-sm-3 pt-0">
                    <?php $total=0; ?>
                    @foreach ($cartItems as $item)
                    <a href="javascript:;" class="card-title h6 d-block text-darker text-capitalize">
                        @if($item->service_item)
                        {{ $item->item_name }} (Item)  
                        @else
                        {{ $item->service_type_name }} (Service)
                        @endif
                    </a>
                    <div class="author align-items-center">
                        <div class="name ps-3">
                            <div class="stats text-gradient text-primary">
                                <p class="font-weight-bold">{{ $item->quantity}} X AED {{ round($item->price,2) }}
                                    <a href="#" class="px-4 py-2 text-danger bg-red-600" wire:click.prevent="removeCart('{{$item['id']}}')"><i class="fa fa-trash"></i></a>   
                                </p>
                            </div>
                        </div>
                    </div>
                    <hr class="horizontal dark mb-1">
                    <?php $total = $total+$item->price*$item->quantity; ?>
                    
                    @endforeach

                    <?php
                    $tax = $total * (config('global.TAX_PERCENT') / 100);
                    $grand_total = $total+$tax;
                    ?>
                    
                    <p class="text-start  text-bold text-md mb-0">Total: AED {{ $total }}</p>
                    <p class="text-start  text-bold text-md">Tax: AED {{ $tax }}</p>
                    <p class="text-start  text-bold text-lg">Grand total: AED {{ $grand_total }}</p>
                    
                    
                    <hr class="horizontal dark my-sm-4">
                    @if(count($cartItems)>0)
                    <div class="w-100 text-center">
                        <a href="" class="btn bg-gradient-danger mb-0 me-2" wire:click="clearAllCart">
                            <i class="fas fa-trash me-1" aria-hidden="true"></i>Empty Cart
                        </a>
                        <a href="#" class="btn bg-gradient-success mb-0 me-2" wire:click="submitService()">
                            <i class="fa-solid fa-cart-shopping me-1" aria-hidden="true"></i> Continue
                        </a>
                    </div>
                    @endif
                </div>


                <hr class="horizontal dark my-sm-4">
                
                <div>
                    <h6 class="mb-0">Sidebar Colors</h6>
                </div>
                <a href="javascript:void(0)" class="switch-trigger background-color">
                    <div class="badge-colors my-2 text-start">
                        <span class="badge filter bg-gradient-primary active" data-color="primary"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-dark" data-color="dark" onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-success" data-color="success"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-warning" data-color="warning"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-danger" data-color="danger"
                            onclick="sidebarColor(this)"></span>
                    </div>
                </a>
                <div class="mt-3">
                    <h6 class="mb-0">Navbar Fixed</h6>
                </div>
                <div class="form-check form-switch ps-0">
                    <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed"
                        onclick="navbarFixed(this)">
                </div>
            </div>
        </div> -->

        @if($showSearchModelView)
        @include('components.modals.newCarSearchOperation')
        @endif
        
    </div>
  </main>

  <!--   Core JS Files   -->
  <script src="{{asset('js/plugins/chartjs.min.js')}}"></script>
  <script src="{{asset('js/plugins/Chart.extension.js')}}"></script>



  <script>
    

    var ctx = document.getElementById("chart-bars").getContext("2d");

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: {!!$getAllSalesJob['labels']!!},
            datasets: [
            {
                label: "Sales",
                tension: 0.4,
                borderWidth: 0,
                pointRadius: 0,
                backgroundColor: "#fff",
                data: {!!$getAllSalesJob['sales_values']!!},
                maxBarThickness: 6
            },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false,
            },
            tooltips: {
                enabled: true,
                mode: "index",
                intersect: false,
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: false,
                    },
                    ticks: {
                        suggestedMin: 0,
                        suggestedMax: 500,
                        beginAtZero: true,
                        padding: 0,
                        fontSize: 14,
                        lineHeight: 3,
                        fontColor: "#fff",
                        fontStyle: 'normal',
                        fontFamily: "Open Sans",
                    },
                },],
                xAxes: [{
                    gridLines: {
                        display: false,
                    },
                    ticks: {
                        display: true,
                        padding: 10,
                    },
                },],
            },
        },
    });

    var ctx2 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(253,235,173,0.4)');
    gradientStroke1.addColorStop(0.2, 'rgba(245,57,57,0.0)');
    gradientStroke1.addColorStop(0, 'rgba(255,214,61,0)'); //purple colors

    var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

    gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.4)');
    gradientStroke2.addColorStop(0.2, 'rgba(245,57,57,0.0)');
    gradientStroke2.addColorStop(0, 'rgba(255,214,61,0)'); //purple colors


    new Chart(ctx2, {
      type: "line",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
            label: "Mobile apps",
            tension: 0.4,
            borderWidth: 0,
            pointRadius: 0,
            borderColor: "#fbcf33",
            borderWidth: 3,
            backgroundColor: gradientStroke1,
            data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
            maxBarThickness: 6

          },
          {
            label: "Websites",
            tension: 0.4,
            borderWidth: 0,
            pointRadius: 0,
            borderColor: "#f53939",
            borderWidth: 3,
            backgroundColor: gradientStroke2,
            data: [30, 90, 40, 140, 290, 290, 340, 230, 400],
            maxBarThickness: 6

          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          display: false,
        },
        tooltips: {
          enabled: true,
          mode: "index",
          intersect: false,
        },
        scales: {
          yAxes: [{
            gridLines: {
              borderDash: [2],
              borderDashOffset: [2],
              color: '#dee2e6',
              zeroLineColor: '#dee2e6',
              zeroLineWidth: 1,
              zeroLineBorderDash: [2],
              drawBorder: false,
            },
            ticks: {
              suggestedMin: 0,
              suggestedMax: 500,
              beginAtZero: true,
              padding: 10,
              fontSize: 11,
              fontColor: '#adb5bd',
              lineHeight: 3,
              fontStyle: 'normal',
              fontFamily: "Open Sans",
            },
          }, ],
          xAxes: [{
            gridLines: {
              zeroLineColor: 'rgba(0,0,0,0)',
              display: false,
            },
            ticks: {
              padding: 10,
              fontSize: 11,
              fontColor: '#adb5bd',
              lineHeight: 3,
              fontStyle: 'normal',
              fontFamily: "Open Sans",
            },
          }, ],
        },
      },
    });
  </script>
  
@push('custom_script')

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
        $('#customerSignatureModal').modal('hide');
        // Send data to server instead...
        //window.open(data);
    });
    cancelButton.addEventListener('click', function (event) {
        signaturePad.clear();
    });

    

});


window.addEventListener('loadCarImage',event=>{
    $('#serviceCarImageModal').modal('show');
    var imageUrl = $('#'+event.detail.imgId).attr('src');
    $("#carImagePad").attr("src",imageUrl);

$(document).ready(function() {
  initialize(imageUrl);
});



// works out the X, Y position of the click inside the canvas from the X, Y position on the page

function getPosition(mouseEvent, sigCanvas) {
    var rect = sigCanvas.getBoundingClientRect();
    return {
      X: mouseEvent.clientX - rect.left,
      Y: mouseEvent.clientY - rect.top
    };
}

/*function getPosition(mouseEvent, sigCanvas) {
  var x, y;
  if (mouseEvent.pageX != undefined && mouseEvent.pageY != undefined) {
    x = mouseEvent.pageX;
    y = mouseEvent.pageY;

  } else {
    x = mouseEvent.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
    y = mouseEvent.clientY + document.body.scrollTop + document.documentElement.scrollTop;
  }

  return {
    X: x - sigCanvas.offsetLeft,
    Y: y - sigCanvas.offsetTop
  };
}*/

function initialize(imageUrl) {
  // get references to the canvas element as well as the 2D drawing context
  var sigCanvas = document.getElementById("canvas");
  var context = sigCanvas.getContext("2d");
  context.strokeStyle = "#f53939";
  context.lineJoin = "round";
  context.lineWidth = 10;

  


    //apply width and height for canvas
        const  getMeta = (url, cb) => {
            const  img = new Image();
            img.onload = () => cb(null, img);
            img.onerror = (err) => cb(err);
            img.src = url;
        };

        // Use like:
        getMeta(imageUrl, (err, img) => {
            sigCanvas.width = img.naturalWidth     // 350px
            sigCanvas.height = img.naturalHeight    // 200px
            
        });



  // Add background image to canvas - remove for blank white canvas
  var background = new Image();
  background.src = imageUrl;
  // Make sure the image is loaded first otherwise nothing will draw.
  background.onload = function() {
    context.drawImage(background, 0, 0);
  }

  


  // This will be defined on a TOUCH device such as iPad or Android, etc.
  var is_touch_device = 'ontouchstart' in document.documentElement;

  if (is_touch_device) {
    // create a drawer which tracks touch movements
    var drawer = {
      isDrawing: false,
      touchstart: function(coors) {
        context.beginPath();
        context.moveTo(coors.x, coors.y);
        this.isDrawing = true;
      },
      touchmove: function(coors) {
        if (this.isDrawing) {
          context.lineTo(coors.x, coors.y);
          context.stroke();
        }
      },
      touchend: function(coors) {
        if (this.isDrawing) {
          this.touchmove(coors);
          this.isDrawing = false;
        }
      }
    };

    // create a function to pass touch events and coordinates to drawer
    function draw(event) {

      // get the touch coordinates.  Using the first touch in case of multi-touch
      var coors = {
        x: event.targetTouches[0].pageX,
        y: event.targetTouches[0].pageY
      };

      // Now we need to get the offset of the canvas location
      var obj = sigCanvas;

      if (obj.offsetParent) {
        // Every time we find a new object, we add its offsetLeft and offsetTop to curleft and curtop.
        do {
          coors.x -= obj.offsetLeft;
          coors.y -= obj.offsetTop;
        }
        // The while loop can be "while (obj = obj.offsetParent)" only, which does return null
        // when null is passed back, but that creates a warning in some editors (i.e. VS2010).
        while ((obj = obj.offsetParent) != null);
      }

      // pass the coordinates to the appropriate handler
      drawer[event.type](coors);

    }

    // attach the touchstart, touchmove, touchend event listeners.
    sigCanvas.addEventListener('touchstart', draw, false);
    sigCanvas.addEventListener('touchmove', draw, false);
    sigCanvas.addEventListener('touchend', draw, false);

    // prevent elastic scrolling
    sigCanvas.addEventListener('touchmove', function(event) {
      event.preventDefault();
    }, false);
  } else {

    // start drawing when the mousedown event fires, and attach handlers to
    // draw a line to wherever the mouse moves to
    $("#canvas").mousedown(function(mouseEvent) {
      var position = getPosition(mouseEvent, sigCanvas);
      context.moveTo(position.X, position.Y);
      context.beginPath();

      // attach event handlers
      $(this).mousemove(function(mouseEvent) {
        drawLine(mouseEvent, sigCanvas, context);
      }).mouseup(function(mouseEvent) {
        finishDrawing(mouseEvent, sigCanvas, context);
      }).mouseout(function(mouseEvent) {
        finishDrawing(mouseEvent, sigCanvas, context);
      });
    });

  }
}

// draws a line to the x and y coordinates of the mouse event inside
// the specified element using the specified context
function drawLine(mouseEvent, sigCanvas, context) {

  var position = getPosition(mouseEvent, sigCanvas);

  context.lineTo(position.X, position.Y);
  context.stroke();
}

// draws a line from the last coordiantes in the path to the finishing
// coordinates and unbind any event handlers which need to be preceded
// by the mouse down event
function finishDrawing(mouseEvent, sigCanvas, context) {
    var base64Canvas = '';
  // draw the line to the finishing coordinates
  drawLine(mouseEvent, sigCanvas, context);

  context.closePath();

  // unbind any events which could draw
  $(sigCanvas).unbind("mousemove")
    .unbind("mouseup")
    .unbind("mouseout");

    var sigCanvas = document.getElementById("canvas");
    var base64Canvas = sigCanvas.toDataURL("image/jpeg");
    console.log(event.detail.imgId);
    $('#'+event.detail.imgId).attr('src',base64Canvas);
    //$('#serviceCarImageModal').modal('hide');
}

// Clear the canvas context using the canvas width and height
function clearCanvas(canvas, ctx) {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
}
    
    
});

window.addEventListener('hideCarScratchImageh',event=>{
    $('#serviceCarImageModal').modal('hide');
});
</script>
<!-- End Signature Script-->


<script type="text/javascript">
    window.addEventListener('imageUpload',event=>{
        $(document).ready(function(e) {
            $(".showonhover").click(function(){
                $("#selectfile").trigger('click');
            });
        });


        var input = document.querySelector('input[type=file]'); // see Example 4

        input.onchange = function () {
            var file = input.files[0];

            drawOnCanvas(file);   // see Example 6
            displayAsImage(file); // see Example 7
        };

        function drawOnCanvas(file) {
            var reader = new FileReader();

            reader.onload = function (e) {
            var dataURL = e.target.result,
            c = document.querySelector('canvas'), // see Example 4
            ctx = c.getContext('2d'),
            img = new Image();

            img.onload = function() {
            c.width = img.width;
            c.height = img.height;
            ctx.drawImage(img, 0, 0);
            };

            img.src = dataURL;
            };

            reader.readAsDataURL(file);
        }

        function displayAsImage(file) {
            var imgURL = URL.createObjectURL(file),
            img = document.createElement('img');

            img.onload = function() {
            URL.revokeObjectURL(imgURL);
            };

            img.src = imgURL;
            
            //document.body.appendChild(img);
        }

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

    });
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">

    
window.addEventListener('selectSearchEvent',event=>{
    $(document).ready(function () {

        $('#newVehicleKMClick').click(function(){
            //alert('5');
            $('.signaturePadDiv').hide();
        });

        $('#customerTypeSelect').select2();
        $('#plateState').select2();
        $('#vehicleTypeInput').select2();
        $('#vehicleMakeInput').select2();
        $('#vehicleModelInput').select2();
        
        $('#customerTypeSelect').on('change', function (e) {
            var customerTypeVal = $('#customerTypeSelect').select2("val");
            @this.set('customer_type', customerTypeVal);
        });

        $('#plateState').on('change', function (e) {
            var plateStateVal = $('#plateState').select2("val");
            @this.set('plate_state', plateStateVal);
        });

        $('#vehicleTypeInput').on('change', function (e) {
            var vehicleTypeVal = $('#vehicleTypeInput').select2("val");
            @this.set('vehicle_type', vehicleTypeVal);
        });

        $('#vehicleMakeInput').on('change', function (e) {
            var makeVal = $('#vehicleMakeInput').select2("val");
            @this.set('make', makeVal);
        });

        $('#vehicleModelInput').on('change', function (e) {
            var modelVal = $('#vehicleModelInput').select2("val");
            @this.set('model', modelVal);
        });
    });
});
window.addEventListener('show-serviceModel',event=>{
    $('#serviceModel').modal('show');
});
window.addEventListener('hide-serviceModel',event=>{
    $('#serviceModel').modal('hide');
});

window.addEventListener('show-searchNewVehicle',event=>{
    $('#searchNewVehicleModal').modal('show');
});
window.addEventListener('hide-searchNewVehicle',event=>{
    $('#searchNewVehicleModal').modal('hide');
});


</script>


@endpush