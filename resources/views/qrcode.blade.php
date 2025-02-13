<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Metas -->
    @if(env('IS_DEMO'))
        <x-demo-metas></x-demo-metas>
    @endif
    
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('favicon/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('favicon/site.webmanifest')}}">

    <title>
        GRAND SERVICE STATION UAE
    </title>
    <!-- Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{asset('css/nucleo-icons.css')}}" rel="stylesheet" />
    <link href="{{asset('css/nucleo-svg.css')}}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/f5641a49d9.js" crossorigin="anonymous"></script>

    <link href="{{asset('css/nucleo-svg.css')}}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{asset('css/soft-ui-dashboard.css?v=0.1')}}" rel="stylesheet" />
    <!-- Alpine -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    
    <style type="text/css">
        .block {
    position: relative;
    margin: 0px auto 0;
    padding:10px;
    background: linear-gradient(0deg, #FFF, #FFF);
}

.block:before, .block:after {
    content: '';
    position: absolute;
    left: -5px;
    top: -5px;
    background: {!!config('global.qr_status_color')[$qrdata->job_status]!!};
    background-size: 400%;
    width: calc(100% + 10px);
    height: calc(100% + 10px);
    z-index: -1;
    animation: steam 20s linear infinite;
}

@keyframes steam {
    0% {
        background-position: 0 0;
    }
    50% {
        background-position: 400% 0;
    }
    100% {
        background-position: 0 0;
    }
}

.block:after {
    filter: blur(10px);
}
    </style>

</head>

<body class="g-sidenav-show bg-gray-100">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-plain pt-4 mb-4 text-center">
                <a href="javascript:;" class="block">
                    {!! QrCode::size(180)->generate(url('vehiclestatus/'.$qrdata->job_number)) !!}
                    <h6 class="card-title text-center">#{{$qrdata->job_number}}</h6>
                </a>
                
            </div>
        </div>
    </div>
    
    <section>
        <div class="container">
            <div class="background-img">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="card card-profile card-plain">
                                            <div class="position-relative">
                                                <div class="blur-shadow-image">
                                                    <img class="w-100 rounded-3 shadow-lg" src="{{url("public/storage/".$qrdata->customerVehicle["vehicle_image"])}}">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="card card-profile card-plain">
                                            <div class="card-body text-left p-0">
                                                <div class="p-md-0 pt-3 text-left">
                                                    <h5 class="font-weight-bolder mb-0">
                                                        {{$qrdata->customerVehicle['plate_number_final']}}
                                                    </h5>
                                                    <p class="text-uppercase text-sm font-weight-bold mb-2">{{isset($qrdata->makeInfo)?$qrdata->makeInfo['vehicle_name']:''}}, {{isset($qrdata->modelInfo['vehicle_model_name'])?$qrdata->modelInfo['vehicle_model_name']:''}}</p>
                                                </div>
                                                @if($qrdata->customerInfo['TenantName'])
                                                    @if($qrdata->customerInfo['TenantName'])
                                                    <p class="mb-0">{{$qrdata->customerInfo['TenantName']}}</p>
                                                    @endif
                                                    @if($qrdata->customerInfo['Mobile'])
                                                    <p class="mb-0">{{$qrdata->customerInfo['Mobile']}}</p>
                                                    @endif
                                                    @if($qrdata->customerInfo['Email'])
                                                    <p class="mb-1">{{$qrdata->customerInfo['Email']}}</p>
                                                    @endif
                                                @else
                                                <p class="mb-0">Customer Guest</p>
                                                @endif
                                                @if($qrdata->customerVehicle['chassis_number'])
                                                <p class="mb-1"><b>Chaisis:</b> {{$qrdata->customerVehicle['chassis_number']}}</p>
                                                @endif
                                                <button class="btn {!!config('global.payment.status_class')[$qrdata->payment_status]!!}" type="button">
                                                    <span class="btn-inner--icon"><i class="fa-solid fa-money-bill-1-wave ms-1 fs-xl" style="font-size: 1.5em;" ></i></span>
                                                    {!!config('global.payment.status')[$qrdata->payment_status]!!}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-md-12">
                                        <div class="timeline timeline-one-side" data-timeline-axis-style="dotted">
                                            @foreach(config('global.jobs.actions') as $actionKey => $jobActions)
                                            <div class="timeline-block mb-3">
                                              <span class="timeline-step">
                                                <i class="ni ni-bell-55 @if($qrdata->job_status < $actionKey) text-secondary @else {!!config('global.jobs.status_text_class')[$actionKey]!!}  text-gradient @endif"></i>
                                              </span>
                                              <div class="timeline-content">
                                                <span class="badge badge-sm @if($qrdata->job_status < $actionKey) bg-gradient-secondary @else {!!config('global.jobs.status_btn_class')[$actionKey]!!} @endif">{{$jobActions}}</span>
                                              </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            
                                        
                            
                            <hr class="horizontal dark mt-3">

                            <div class="row">
                                <div class="col-md-12">
                                    
                                </div>
                            </div>
                            <!-- <button type="button" class="btn btn-dark">
                                <h5 class="font-weight-bolder mb-0">{{$qrdata->make}}</h5>
                                <p class="text-sm font-weight-bold mb-0">{{$qrdata->model}} ({{$qrdata->plate_number}})</p>
                                <p class="text-sm mb-0">Chassis Number: {{$qrdata->chassis_number}}</p>
                                <p class="text-sm mb-3">K.M Reading: {{$qrdata->vehicle_km}}</p>
                            </button>
                            <hr class="horizontal dark mt-3">
                            <button type="button" class="btn btn-outline-dark">
                                <p class="text-sm mb-0">Name: {{$qrdata->customerInfo['Name']}}</p>
                                <p class="text-sm mb-0">Mobile: <a href="tel:{{$qrdata->mobile}}">{{$qrdata->customerInfo['Mobile']}}</a></p>
                                <p class="text-sm mb-0">Email: {{$qrdata->customerInfo['Email']}}</p>
                            </button> -->

                          </div>
                        </div>
                    </div>
                       
                </div>
                
            </div>
        </div>
    </section>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card card-plain text-center">
                <a href="javascript:;">
                    <img src="{{asset('img/logos/gss-logo.svg')}}" class="navbar-brand-img h-100" style="width:100px;" alt="...">
                </a>
            </div>
        </div>
    </div>
    
    <!--   Core JS Files   -->

    <script src="{{asset('js/core/popper.min.js')}}"></script>
    <script src="{{asset('js/core/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/plugins/smooth-scrollbar.min.js')}}"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }

    </script>

    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{asset('js/soft-ui-dashboard.js')}}"></script>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    

</body>

</html>