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
    background: linear-gradient(0deg, #000, #272727);
}

.block:before, .block:after {
    content: '';
    position: absolute;
    left: -2px;
    top: -2px;
    background: {!!config('global.qr_status_color')[$qrdata->job_status]!!};
    background-size: 400%;
    width: calc(100% + 4px);
    height: calc(100% + 4px);
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
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card card-plain text-center">
                <a href="javascript:;">
                    <img src="{{asset('img/logos/gss-logo.svg')}}" class="navbar-brand-img h-100" style="width:150px;" alt="...">
                </a>
            </div>
        </div>
    </div>
    
    <section>
        <div class="container">
            <div class="background-img">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-plain text-center">
                          <a href="javascript:;" class="block">
                            {!! QrCode::size(250)->generate(url('vehiclestatus/'.$qrdata->job_number)) !!}
                          </a>

                          <div class="card-body">
                            <h4 class="card-title">#{{$qrdata->job_number}}</h4>
                            <h6 class="category text-gradient h2 {{config('global.jobs.status_text_class')[$qrdata->job_status]}}">Status: {{config('global.jobs.status')[$qrdata->job_status]}}</h6>
                            <h6 class="category text-gradient h2 {{config('global.payment.status_class')[$qrdata->payment_status]}}">Payment: {{config('global.payment.status')[$qrdata->payment_status]}}</h6>
                            <hr class="horizontal dark mt-3">
                            <button type="button" class="btn btn-dark">
                                <h5 class="font-weight-bolder mb-0">{{$qrdata->make}}</h5>
                                <p class="text-sm font-weight-bold mb-0">{{$qrdata->model}} ({{$qrdata->plate_number}})</p>
                                <p class="text-sm mb-0">Chassis Number: {{$qrdata->chassis_number}}</p>
                                <p class="text-sm mb-3">K.M Reading: {{$qrdata->vehicle_km}}</p>
                            </button>
                            <hr class="horizontal dark mt-3">
                            <button type="button" class="btn btn-outline-dark">
                                <p class="text-sm mb-0">Name: {{$qrdata->name}}</p>
                                <p class="text-sm mb-0">Mobile: <a href="tel:{{$qrdata->mobile}}">{{$qrdata->mobile}}</a></p>
                                <p class="text-sm mb-0">Email: {{$qrdata->email}}</p>
                            </button>

                          </div>
                        </div>
                    </div>
                       
                </div>
                
            </div>
        </div>
    </section>
    
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