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
            <p class="h5 mt-2 px-4">{{count($pendingCustomersCart)}} - Ongoing Customers</p>
        </div>
        
        <div class="row">            
            <?php $arrayCustomersPendingJobs = []; ?>
            @if($showDashboard)
                @forelse($pendingCustomersCart as $pendingvehicle)
                    @if(!in_array($pendingvehicle->vehicle_id, $arrayCustomersPendingJobs))
                        <div class="col-xl-3 col-md-4 mb-xl-0 my-4">
                            <a href="javascript:;" wire:click="selectPendingVehicle({{$pendingvehicle->customer_id}},{{$pendingvehicle->vehicle_id}})" class="">
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

        <div class="row mt-4">
            <p class="h5 mt-2 px-4">{{ count($pendingjobs)}} - Pending Payment Customers</p>
        </div>
        <div class="row">
            @forelse($pendingjobs as $pendingjob)
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12">

                <a href="javascript:;"  wire:click="pendingPaymentClick('{{$pendingjob->job_number}}')">
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
                                      <h6 class="mb-0 text-sm">{{$jobs->make}} - <small>{{$jobs->model}} ({{$jobs->plate_number}})</small></h6>
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
                                  <p class="text-sm font-weight-bold mb-0">AED {{custom_round($jobs->grand_total)}}</p>
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




@endpush