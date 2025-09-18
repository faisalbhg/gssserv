@push('custom_css')
<link rel="stylesheet" type="text/css" href="https://unpkg.com/lightpick@latest/css/lightpick.css">
<style type="text/css">
    .lightpick{
        z-index: 999 !important;
    }
    .lightpick__month{
        width:100%;
    }
    .lightpick__day.is-today {
        background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Ccircle fill='rgba(0, 0, 0)' cx='16' cy='16' r='16'/%3E%3C/svg%3E");
        background-size: auto;
        color: #FFFF;
        /*background-position: center center;
        color: #FFF;
        font-weight: bold*/;
    }
    .availabledate a {
        background-color: #07ea69 !important;
        background-image :none !important;
        color: #ffffff !important;
    }
    .shadowMarg ul li{
        border: 0px solid #e0e1e6;
        padding: 10px 15px 10px 15px;
        margin-bottom: 15px;
        box-shadow: 1px 3px 6px rgba(0, 0, 0, 0.25);
        opacity: 0.5;
    }
</style>


@endpush
<main class="main-content position-relative  border-radius-lg">
    <div class="container-fluid py-2">
        
        <div class="row">
            <div class="col-xl-6 col-md-6 col-sm-6 mb-2">
                <p class="h5 mt-2">Jobs Over View @if($selected_date) On {{ \Carbon\Carbon::parse($selected_date)->format('dS M Y') }} @endif</p>
                @if(auth()->user('user')->user_type==1)
                    <div class="row">
                        <div class="col-12 mb-2">
                            <div class="form-group">
                                <select class="form-control" id="stationSelect" wire:model="search_station">
                                    <option value="">-Select Station-</option>
                                    @foreach($stationsList as $station)
                                    <option value="{{$station->LandlordCode}}">{{$station->CorporateName}}</option>
                                    @endforeach
                                </select>
                                <div wire:loading wire:target="search_station">
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
                @endif
            </div>
            <div class="col-xl-6 col-md-6 col-sm-6 mb-2">
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('customer-receive') }}">
                        <div class="card bg-cover text-center my-4" style="background-image: url('https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/curved-images/curved1.jpg')">
                            <div class="card-body z-index-2 py-4">
                                <h2 class="text-white"><i class="fa fa-plus text-white mb-3" aria-hidden="true"></i> New Job</h2>
                                
                            </div>
                            <div class="mask bg-gradient-primary border-radius-lg"></div>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row  mb-4">
            <div class="col-md-6">
                <div class="card mb-0">
                    <input wire:ignore type="text" wire:model="selected_date" id="demo-13" class="form-control form-control-sm" style="display: none;"  />
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-4 mb-4 cursor-pointer" wire:click="jobListPage('total')">
                        <div class="d-flex mb-2">
                            <div class="icon icon-shape icon-xxs shadow border-radius-sm bg-gradient-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <svg width="10px" height="10px" viewBox="0 0 40 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><title>spaceship</title><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <title>basket</title> <g id="Basic-Elements" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Rounded-Icons" transform="translate(-1869.000000, -741.000000)" fill="#FFFFFF" fill-rule="nonzero"> <g id="Icons-with-opacity" transform="translate(1716.000000, 291.000000)"> <g id="basket" transform="translate(153.000000, 450.000000)"> <path class="color-background" d="M34.080375,13.125 L27.3748125,1.9490625 C27.1377583,1.53795093 26.6972449,1.28682264 26.222716,1.29218729 C25.748187,1.29772591 25.3135593,1.55890827 25.0860125,1.97535742 C24.8584658,2.39180657 24.8734447,2.89865282 25.1251875,3.3009375 L31.019625,13.125 L10.980375,13.125 L16.8748125,3.3009375 C17.1265553,2.89865282 17.1415342,2.39180657 16.9139875,1.97535742 C16.6864407,1.55890827 16.251813,1.29772591 15.777284,1.29218729 C15.3027551,1.28682264 14.8622417,1.53795093 14.6251875,1.9490625 L7.919625,13.125 L0,13.125 L0,18.375 L42,18.375 L42,13.125 L34.080375,13.125 Z" opacity="0.595377604"></path> <path class="color-background" d="M3.9375,21 L3.9375,38.0625 C3.9375,40.9619949 6.28800506,43.3125 9.1875,43.3125 L32.8125,43.3125 C35.7119949,43.3125 38.0625,40.9619949 38.0625,38.0625 L38.0625,21 L3.9375,21 Z M14.4375,36.75 L11.8125,36.75 L11.8125,26.25 L14.4375,26.25 L14.4375,36.75 Z M22.3125,36.75 L19.6875,36.75 L19.6875,26.25 L22.3125,26.25 L22.3125,36.75 Z M30.1875,36.75 L27.5625,36.75 L27.5625,26.25 L30.1875,26.25 L30.1875,36.75 Z"></path> </g> </g> </g> </g> </svg>
              
                            </div>
                            <p class="text-xs mt-1 mb-0 font-weight-bold">Total jobs</p>
                        </div>
                        <h4 class="font-weight-bolder">{{$getCountSalesJob->total}}</h4>
                        <div class="progress w-100">
                            <div class="progress-bar bg-dark w-100" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <div class="col-4 mb-4 cursor-pointer"  wire:click="jobListPage('working_progress')">
                        <div class="d-flex mb-2">
                            <div class="icon icon-shape icon-xxs shadow border-radius-sm bg-gradient-danger text-center me-2 d-flex align-items-center justify-content-center">
                                <svg width="10px" height="10px" viewBox="0 0 40 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><title>spaceship</title><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-1720.000000, -592.000000)" fill="#FFFFFF" fill-rule="nonzero"><g transform="translate(1716.000000, 291.000000)"><g transform="translate(4.000000, 301.000000)"><path class="color-background" d="M39.3,0.706666667 C38.9660984,0.370464027 38.5048767,0.192278529 38.0316667,0.216666667 C14.6516667,1.43666667 6.015,22.2633333 5.93166667,22.4733333 C5.68236407,23.0926189 5.82664679,23.8009159 6.29833333,24.2733333 L15.7266667,33.7016667 C16.2013871,34.1756798 16.9140329,34.3188658 17.535,34.065 C17.7433333,33.98 38.4583333,25.2466667 39.7816667,1.97666667 C39.8087196,1.50414529 39.6335979,1.04240574 39.3,0.706666667 Z M25.69,19.0233333 C24.7367525,19.9768687 23.3029475,20.2622391 22.0572426,19.7463614 C20.8115377,19.2304837 19.9992882,18.0149658 19.9992882,16.6666667 C19.9992882,15.3183676 20.8115377,14.1028496 22.0572426,13.5869719 C23.3029475,13.0710943 24.7367525,13.3564646 25.69,14.31 C26.9912731,15.6116662 26.9912731,17.7216672 25.69,19.0233333 L25.69,19.0233333 Z"></path><path class="color-background" d="M1.855,31.4066667 C3.05106558,30.2024182 4.79973884,29.7296005 6.43969145,30.1670277 C8.07964407,30.6044549 9.36054508,31.8853559 9.7979723,33.5253085 C10.2353995,35.1652612 9.76258177,36.9139344 8.55833333,38.11 C6.70666667,39.9616667 0,40 0,40 C0,40 0,33.2566667 1.855,31.4066667 Z"></path><path class="color-background" d="M17.2616667,3.90166667 C12.4943643,3.07192755 7.62174065,4.61673894 4.20333333,8.04166667 C3.31200265,8.94126033 2.53706177,9.94913142 1.89666667,11.0416667 C1.5109569,11.6966059 1.61721591,12.5295394 2.155,13.0666667 L5.47,16.3833333 C8.55036617,11.4946947 12.5559074,7.25476565 17.2616667,3.90166667 L17.2616667,3.90166667 Z" opacity="0.598539807"></path><path class="color-background" d="M36.0983333,22.7383333 C36.9280725,27.5056357 35.3832611,32.3782594 31.9583333,35.7966667 C31.0587397,36.6879974 30.0508686,37.4629382 28.9583333,38.1033333 C28.3033941,38.4890431 27.4704606,38.3827841 26.9333333,37.845 L23.6166667,34.53 C28.5053053,31.4496338 32.7452344,27.4440926 36.0983333,22.7383333 L36.0983333,22.7383333 Z" opacity="0.598539807"></path></g></g></g></g></svg>
                            </div>
                            <p class="text-xs mt-1 mb-0 font-weight-bold">Working Progress</p>
                        </div>
                        <h4 class="font-weight-bolder">{{$getCountSalesJob->working_progress}}</h4>
                        <div class="progress w-100">
                            <div class="progress-bar bg-dark w-100" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <div class="col-4 mb-4 cursor-pointer" wire:click="jobListPage('work_finished')">
                        <div class="d-flex mb-2">
                            <div class="icon icon-shape icon-xxs shadow border-radius-sm bg-gradient-warning text-center me-2 d-flex align-items-center justify-content-center">
                                <svg width="10px" height="10px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><title>credit-card</title><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero"><g transform="translate(1716.000000, 291.000000)"><g transform="translate(453.000000, 454.000000)"><path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path><path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path></g></g></g></g></svg>
                            </div>
                            <p class="text-xs mt-1 mb-0 font-weight-bold">Work Completed</p>
                        </div>
                        <h4 class="font-weight-bolder">{{$getCountSalesJob->work_finished}}</h4>
                        <div class="progress w-100">
                            <div class="progress-bar bg-dark w-100" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <div class="col-4 mb-4 cursor-pointer" wire:click="jobListPage('ready_to_deliver')">
                        <div class="d-flex mb-2">
                            <div class="icon icon-shape icon-xxs shadow border-radius-sm bg-gradient-info text-center me-2 d-flex align-items-center justify-content-center">
                                <svg width="10px" height="10px" viewBox="0 0 40 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><title>settings</title><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-2020.000000, -442.000000)" fill="#FFFFFF" fill-rule="nonzero"><g transform="translate(1716.000000, 291.000000)"><g transform="translate(304.000000, 151.000000)"><polygon class="color-background" opacity="0.596981957" points="18.0883333 15.7316667 11.1783333 8.82166667 13.3333333 6.66666667 6.66666667 0 0 6.66666667 6.66666667 13.3333333 8.82166667 11.1783333 15.315 17.6716667"></polygon><path class="color-background" d="M31.5666667,23.2333333 C31.0516667,23.2933333 30.53,23.3333333 30,23.3333333 C29.4916667,23.3333333 28.9866667,23.3033333 28.48,23.245 L22.4116667,30.7433333 L29.9416667,38.2733333 C32.2433333,40.575 35.9733333,40.575 38.275,38.2733333 L38.275,38.2733333 C40.5766667,35.9716667 40.5766667,32.2416667 38.275,29.94 L31.5666667,23.2333333 Z" opacity="0.596981957"></path><path class="color-background" d="M33.785,11.285 L28.715,6.215 L34.0616667,0.868333333 C32.82,0.315 31.4483333,0 30,0 C24.4766667,0 20,4.47666667 20,10 C20,10.99 20.1483333,11.9433333 20.4166667,12.8466667 L2.435,27.3966667 C0.95,28.7083333 0.0633333333,30.595 0.00333333333,32.5733333 C-0.0583333333,34.5533333 0.71,36.4916667 2.11,37.89 C3.47,39.2516667 5.27833333,40 7.20166667,40 C9.26666667,40 11.2366667,39.1133333 12.6033333,37.565 L27.1533333,19.5833333 C28.0566667,19.8516667 29.01,20 30,20 C35.5233333,20 40,15.5233333 40,10 C40,8.55166667 39.685,7.18 39.1316667,5.93666667 L33.785,11.285 Z"></path></g></g></g></g></svg>
                            </div>
                            <p class="text-xs mt-1 mb-0 font-weight-bold">Ready</p>
                        </div>
                        <h4 class="font-weight-bolder">{{$getCountSalesJob->ready_to_deliver}}</h4>
                        <div class="progress w-100">
                            <div class="progress-bar bg-dark w-100" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <div class="col-4 mb-4 cursor-pointer" wire:click="jobListPage('delivered')">
                        <div class="d-flex mb-2">
                            <div class="icon icon-shape icon-xxs shadow border-radius-sm bg-gradient-success text-center me-2 d-flex align-items-center justify-content-center">
                                <svg width="10px" height="10px" viewBox="0 0 40 44" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                  <title>document</title>
                                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-1870.000000, -591.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                      <g transform="translate(1716.000000, 291.000000)">
                                        <g transform="translate(154.000000, 300.000000)">
                                          <path class="color-background" d="M40,40 L36.3636364,40 L36.3636364,3.63636364 L5.45454545,3.63636364 L5.45454545,0 L38.1818182,0 C39.1854545,0 40,0.814545455 40,1.81818182 L40,40 Z" opacity="0.603585379"></path>
                                          <path class="color-background" d="M30.9090909,7.27272727 L1.81818182,7.27272727 C0.814545455,7.27272727 0,8.08727273 0,9.09090909 L0,41.8181818 C0,42.8218182 0.814545455,43.6363636 1.81818182,43.6363636 L30.9090909,43.6363636 C31.9127273,43.6363636 32.7272727,42.8218182 32.7272727,41.8181818 L32.7272727,9.09090909 C32.7272727,8.08727273 31.9127273,7.27272727 30.9090909,7.27272727 Z M18.1818182,34.5454545 L7.27272727,34.5454545 L7.27272727,30.9090909 L18.1818182,30.9090909 L18.1818182,34.5454545 Z M25.4545455,27.2727273 L7.27272727,27.2727273 L7.27272727,23.6363636 L25.4545455,23.6363636 L25.4545455,27.2727273 Z M25.4545455,20 L7.27272727,20 L7.27272727,16.3636364 L25.4545455,16.3636364 L25.4545455,20 Z"></path>
                                        </g>
                                      </g>
                                    </g>
                                  </g>
                                </svg>
                            </div>
                            <p class="text-xs mt-1 mb-0 font-weight-bold">Delivered</p>
                        </div>
                        <h4 class="font-weight-bolder">{{$getCountSalesJob->delivered}}</h4>
                        <div class="progress w-100">
                            <div class="progress-bar bg-dark w-100" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div wire:loading wire:target="jobListPage">
            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                <div class="la-ball-beat">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        
        <div class="row">
            @foreach($departmentSummary as $departmentCount)
                <div class="col-md-4 mb-4">
                    <div class="card card-pricing">
                        <div class="card-header bg-gradient-dark text-center pt-4 pb-5 position-relative">
                            <div class="z-index-1 position-relative">
                                <h5 class="text-white">{{$departmentCount['departments']['DevelopmentName']}}</h5>
                                <h1 class="text-white mt-2 mb-0">
                                <small></small>{{$departmentCount['order_count']}}</h1>
                                @if(auth()->user('user')->user_type==1)
                                <h6 class="text-white">{{explode("-",$departmentCount['departments']['DevelopmentNo'])[0]}}</h6>
                                @endif
                            </div>
                        </div>
                        <div class="position-relative mt-n5" style="height: 50px;">
                            <div class="position-absolute w-100">
                                <svg class="waves waves-sm" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 40" preserveAspectRatio="none" shape-rendering="auto">
                                    <defs>
                                        <path id="card-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path>
                                    </defs>
                                    <g class="moving-waves">
                                        <use xlink:href="#card-wave" x="48" y="-1" fill="rgba(255,255,255,0.30"></use>
                                        <use xlink:href="#card-wave" x="48" y="3" fill="rgba(255,255,255,0.35)"></use>
                                        <use xlink:href="#card-wave" x="48" y="5" fill="rgba(255,255,255,0.25)"></use>
                                        <use xlink:href="#card-wave" x="48" y="8" fill="rgba(255,255,255,0.20)"></use>
                                        <use xlink:href="#card-wave" x="48" y="13" fill="rgba(255,255,255,0.15)"></use>
                                        <use xlink:href="#card-wave" x="48" y="16" fill="rgba(255,255,255,0.99)"></use>
                                    </g>
                                </svg>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <ul class="list-unstyled max-width-200 mx-auto">
                                @foreach($departmentCount['sections'] as $sectionsDtls )
                                <li class="cursor-pointer" wire:click="sectionsDtlsJobs('{{$sectionsDtls}}')">
                                    <b>{{$sectionsDtls['order_count']}}</b> -  {{$sectionsDtls['sections']['PropertyName']}}
                                    <hr class="horizontal dark">
                                </li>
                                @endforeach
                            </ul>
                            
                        </div>
                    </div>
                </div>
            @endforeach
            <div wire:loading wire:target="sectionsDtlsJobs">
                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                    <div class="la-ball-beat">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
        @if($showServiceItemSummary)
            @include('components.modals.serviceItemSummary')
        @endif
        
        <div class="row">
            
            <div class="col-md-12">
                
                <div class="row mt-lg-0 mt-0">
                    <p class="h5 mt-2">{{$jobList}}</p>
                    
                    @foreach($customerjobsLists as $custJob)
                    <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                        <div class="card h-100" wire:click="dashCustomerJobUpdate('{{$custJob->job_number}}')">
                            <div class="card-body d-flex flex-column justify-content-center text-center">
                                <div class="d-flex">
                                    <div class="avatar avatar-xxl {{config('global.jobs.job_status_bg')[$custJob->job_status]}} border-radius-md p-2" style="width:inherit; height: inherit;">
                                        <img src="{{url('public/storage/'.$custJob->vehicle_image)}}" alt="slack_logo">
                                    </div>
                                    <div class="ms-3 my-auto">
                                        <h6>{{$custJob->job_number}}</h6>
                                    </div>
                                </div>
                                <h6 class="text-sm mb-0">{{ \Carbon\Carbon::parse($custJob->job_date_time)->format('dS M Y H:i A') }}</h6>
                                <p class="text-secondary text-sm font-weight-bold mb-0">Created On</p>
                          </div>
                        </div>
                    </div>
                    @endforeach
                    
                </div>
            </div>
        </div>
                    
    </div>
</main>
@push('custom_script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="https://unpkg.com/lightpick@latest/lightpick.js"></script>
<script type="text/javascript">
    window.addEventListener('openServiceItemSummaryModal',event=>{
        $('#serviceItemSummaryModal').modal('show');
    });
    window.addEventListener('closeServiceItemSummaryModal',event=>{
        $('#serviceItemSummaryModal').modal('hide');
    });

    var dateToday = new Date();
    window.addEventListener('datePicker',event=>{
        

        // demo-13
        //var some_date = '2024-11-20';
        //var dateToday = new Date('December 17, 2024 03:24:00');

        

        new Lightpick({
            field: document.getElementById('demo-13'),
            inline: true,
            minDate: false,
            onSelect: function(date){

                //$('.lightpick__day').removeClass('is_today');
                //$('div[data-time ="'+$('div[name ="box-2"]').attr('data-time')+'"]').addClass('is_today');

                var dateSelected = $(this).datepicker('getDate'); 
                dateSelected = moment(dateSelected).format('Y-m-d');
                Livewire.emit("selectDate", date.format('Y-M-D'));
                //Livewire.emit("selectTime", $('#timepicker').val());
                //document.getElementById('result-13').innerHTML = date.format('Do MMMM YYYY');
                //@this.set('meetingDate', taskduedate);
            }
        });

        
        

    });


    

    // demo-13
    new Lightpick({
        field: document.getElementById('demo-13'),
        inline: true,
        minDate: false,
        onSelect: function(date){
            $('.lightpick__day').removeClass('is_today');
            $('div[data-time ="'+$('div[name ="box-2"]').attr('data-time')+'"]').addClass('is_today');

            $('.lightpick__day').attr('data-time');
            var dateSelected = $(this).datepicker('getDate'); 
            dateSelected = moment(dateSelected).format('Y-m-d');
            Livewire.emit("selectDate", date.format('Y-M-D'));
            //Livewire.emit("selectTime", $('#timepicker').val());
            //document.getElementById('result-13').innerHTML = date.format('Do MMMM YYYY');
            //@this.set('meetingDate', taskduedate);
        }
    });

    
</script>
<script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>
@endpush