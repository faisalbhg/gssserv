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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

    <link href="{{asset('css/nucleo-svg.css')}}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{asset('css/soft-ui-dashboard.css?v=0.4')}}" rel="stylesheet" />
    <!-- Alpine -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

    <!--Choosen Css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">

    <style type="text/css">
        html,body{
            height: 100%;
        }
        /*!
         * Load Awesome v1.1.0 (http://github.danielcardoso.net/load-awesome/)
         * Copyright 2015 Daniel Cardoso <@DanielCardoso>
         * Licensed under MIT
         */
        .la-ball-beat,
        .la-ball-beat > div {
            position: relative;
            -webkit-box-sizing: border-box;
               -moz-box-sizing: border-box;
                    box-sizing: border-box;
        }
        .la-ball-beat {
            display: block;
            font-size: 0;
            color: #fff;
        }
        .la-ball-beat.la-dark {
            color: #333;
        }
        .la-ball-beat > div {
            display: inline-block;
            float: none;
            background-color: currentColor;
            border: 0 solid currentColor;
        }
        .la-ball-beat {
            /*width: 54px;
            height: 18px;*/
        }
        .la-ball-beat > div {
            width: 10px;
            height: 10px;
            margin: 4px;
            border-radius: 100%;
            -webkit-animation: ball-beat .7s -.15s infinite linear;
               -moz-animation: ball-beat .7s -.15s infinite linear;
                 -o-animation: ball-beat .7s -.15s infinite linear;
                    animation: ball-beat .7s -.15s infinite linear;
        }
        .la-ball-beat > div:nth-child(2n-1) {
            -webkit-animation-delay: -.5s;
               -moz-animation-delay: -.5s;
                 -o-animation-delay: -.5s;
                    animation-delay: -.5s;
        }
        .la-ball-beat.la-sm {
            width: 26px;
            height: 8px;
        }
        .la-ball-beat.la-sm > div {
            width: 4px;
            height: 4px;
            margin: 2px;
        }
        .la-ball-beat.la-2x {
            width: 108px;
            height: 36px;
        }
        .la-ball-beat.la-2x > div {
            width: 20px;
            height: 20px;
            margin: 8px;
        }
        .la-ball-beat.la-3x {
            width: 162px;
            height: 54px;
        }
        .la-ball-beat.la-3x > div {
            width: 30px;
            height: 30px;
            margin: 12px;
        }
        /*
         * Animation
         */
        @-webkit-keyframes ball-beat {
            50% {
                opacity: .2;
                -webkit-transform: scale(.75);
                        transform: scale(.75);
            }
            100% {
                opacity: 1;
                -webkit-transform: scale(1);
                        transform: scale(1);
            }
        }
        @-moz-keyframes ball-beat {
            50% {
                opacity: .2;
                -moz-transform: scale(.75);
                     transform: scale(.75);
            }
            100% {
                opacity: 1;
                -moz-transform: scale(1);
                     transform: scale(1);
            }
        }
        @-o-keyframes ball-beat {
            50% {
                opacity: .2;
                -o-transform: scale(.75);
                   transform: scale(.75);
            }
            100% {
                opacity: 1;
                -o-transform: scale(1);
                   transform: scale(1);
            }
        }
        @keyframes ball-beat {
            50% {
                opacity: .2;
                -webkit-transform: scale(.75);
                   -moz-transform: scale(.75);
                     -o-transform: scale(.75);
                        transform: scale(.75);
            }
            100% {
                opacity: 1;
                -webkit-transform: scale(1);
                   -moz-transform: scale(1);
                     -o-transform: scale(1);
                        transform: scale(1);
            }
        }
        .silver_button
        {
            background: radial-gradient(ellipse farthest-corner at right bottom, #E5E4E2 0%, #D6D5D3 8%, #C7C6C4 30%, #F4F3F1 40%, transparent 80%),
                radial-gradient(ellipse farthest-corner at left top, #F4F3F1 0%, #C7C6C4 8%, #D6D5D3 25%, #E5E4E2 62.5%, #E5E4E2 100%) !important;
        }
        .gold_button
        {
            background: radial-gradient(ellipse farthest-corner at right bottom, #c39738 0%, #deb761 8%, #c39738 30%, #c39738 40%, transparent 80%),
                radial-gradient(ellipse farthest-corner at left top, #FFFFFF 0%, #FFFFAC 8%, #D1B464 25%, #5d4a1f 62.5%, #5d4a1f 100%) !important;
        }
        .platinum_button
        {
            background-image: linear-gradient(0deg, rgba(242, 142, 28, 1) 10%, rgba(210, 116, 0, 1) 20%, rgba(179, 91, 0, 1) 35%, rgba(149, 66, 0, 1) 45%, rgba(118, 43, 0, 1) 55%, rgba(89, 19, 0, 1) 65%, rgba(61, 0, 0, 1) 80%, rgba(37, 0, 1, 1) 90%, rgba(0, 0, 0, 1) 100%) !important;
        }
        .chosen-container-single .chosen-single
        {
            border: 1px solid #d2d6da !important;
            border-radius: 0.5rem !important;
            background: linear-gradient(#fff 20%, #FFF 50%, #FFF 52%, #f6f6f6 100%);
            height: 40px;
            line-height: 40px;
        }
        .chosen-container-single .chosen-single div
        {
            top:25%;
        }
        .chosen-container .chosen-results, .chosen-container .chosen-results li
        {
            padding: 15px 6px;
        }

    </style>
    @livewireStyles

    @stack('custom_css') 
    
    
</head>

<body class="g-sidenav-show bg-gray-100">

    

    <script>
        window.onload = function() {
            /*Livewire.hook('message.sent', () => {
                window.dispatchEvent(
                    new CustomEvent('loading', { detail: { loading: true }})
                );
            })
            Livewire.hook('message.processed', (message, component) => {
                window.dispatchEvent(
                    new CustomEvent('loading', { detail: { loading: false }})
                );
            })*/
        }
    </script>

    <div x-data="{ loading: false }" x-show="loading" @loading.window="loading = $event.detail.loading">
        <div style="display: flex; justify-content: center; align-items: center; background-color: #170b2a; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
            <div class="la-ball-beat">
                <img src="{{ asset('img/animated_car.gif') }}" width="200">
            </div>
        </div>
    </div>
    

    

    {{ $slot }}

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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        
        
        window.addEventListener('close-form',event=>{
            $('#'+event.detail.modelName).modal('hide');
        });
        window.addEventListener('focus-form',event=>{
            $('#'+event.detail.modelName).show();
        });
        
        window.addEventListener('showPaymentPannel',event=>{
            $('#cartDetails').hide();
            $('#paymentDetails').show();
        });
        window.addEventListener('paymentRespnse',event=>{
            $('#paymentRespnse').show();
            $('#paymentDetails').hide();
        });

        
        //New Vehicle Km
        window.addEventListener('openNewVehicleKm',event=>{
            $('#newKmReadingForm').show();
        });
        window.addEventListener('closeNewVehicleKm',event=>{
            $('#newKmReadingForm').hide();
        });

        window.addEventListener('swal:modal', event => { 
            Swal.fire({
                icon: event.detail.type,
                html: event.detail.message,
                position: 'top-end',
                timer: 2000
            });
            $('.cartitemcount').text('('+event.detail.cartitemcount+')');
        });

        window.addEventListener('scrollto',event=>{
            $(document).ready(function(){
                $('html, body').animate({
                    scrollTop: $("#"+event.detail.scrollToId).offset().top - 10
                }, 100);
            });
        });
        window.addEventListener('refreshPage',event=>{
            location.reload();
        });

        
    </script>

    <!--Choosen Js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
    @livewireScripts


    @stack('custom_script') 

</body>

</html>
