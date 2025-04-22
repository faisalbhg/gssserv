<main class="main-content mt-1 border-radius-lg">
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-1 border-radius-xl shadow-none position-sticky blur shadow-blur mt-1 left-auto z-index-sticky" id="navbarBlur"
        navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <ul class="navbar-nav justify-content-end">
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a class="align-items-center d-flex m-0 navbar-brand text-wrap" href="{{ route('dashboard') }}">
                        <img src="{{asset('img/logos/gss-logo.svg')}}" class="navbar-brand-img h-100" style="width:150px;" alt="...">
                    </a>
                </li>
            </ul>
            <nav aria-label="breadcrumb" class="d-xl-block d-md-none d-sm-none d-xs-none">
                <h6 class="font-weight-bolder mb-0 text-capitalize  px-4">{{ str_replace('-', ' ', Route::currentRouteName()) }}</h6>
            </nav>
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-0 d-flex justify-content-end" id="navbar">

                <!-- <div class="nav-item d-flex align-itel-left">
                    <a href="{{ route('dashboard') }}"
                        class="btn btn-primary active mb-0 text-white" role="button" aria-pressed="true">
                        New Car
                    </a>
                </div> -->
                
                <ul class="navbar-nav justify-content-end">
                    <li class="d-none nav-item px-1 dropdown pe-2 d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-primary p-0 " id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-bell cursor-pointer"></i>
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                            <li class="mb-2">
                                <a class="dropdown-item border-radius-md" href="javascript:;">
                                    <div class="d-flex py-1">
                                        
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="text-sm font-weight-normal mb-1">
                                                <span class="text-danger font-weight-bold">Empty..!</span>
                                            </h6>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            
                        </ul>
                    </li>
                    
                    

                    <!-- <li class="d-none nav-item px-3 d-flex align-items-center"  >
                        <a class="nav-link" href="{{ route('mechanical') }}">
                            <button class="btn btn-icon btn-sm btn-3 bg-gradient-danger" type="button" wire:click="newMechanicalJob">
                                <span class="btn-inner--icon"><i style="font-size: 1.5em;" class="fa-solid fa-tools fa-xl"></i></span>
                                <span class="btn-inner--text">Mechanical</span>
                            </button>
                        </a>
                    </li> -->
                    

                    <li class="nav-item px-0 d-flex align-items-center"  >
                        <div class="dropdown">
                            <button class="btn btn-sm bg-gradient-danger dropdown-toggle " type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="btn-inner--icon"><i style="font-size: 1.5em;" class="fa-solid fa-car fa-xl"></i></span>
                                Contract
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="{{ route('kabil-llc') }}"  wire:click="cartaxiClick('unique_id1')" wire:navigate>KABI L.L.C
                                    <span wire:target="cartaxiClick('unique_id1')" wire:loading> {{-- new wire:navigating directive --}}
                                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                            <div class="la-ball-beat">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </span>
                                </a></li><!-- 
                                <li><a class="dropdown-item" href="{{ route('kabil-llc') }}">Emirates Catering</a></li> -->
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item px-0 d-flex align-items-center"  >
                        <a class="nav-link" href="{{ route('job-start') }}"  wire:click="nothing('unique_id')" wire:navigate>
                            <button class="btn btn-icon btn-sm btn-3 bg-gradient-primary" type="button" wire:click="newVehicleOpen">
                                <span class="btn-inner--icon"><i style="font-size: 1.5em;" class="fa-solid fa-car fa-xl"></i></span>
                                <span class="btn-inner--text">New Job</span>
                            </button>
                            <span wire:target="nothing('unique_id')" wire:loading> {{-- new wire:navigating directive --}}
                                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                    <div class="la-ball-beat">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </div>
                            </span>
                        </a>
                    </li>
                    <li class="nav-item dropdown pe-2 d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-dark p-0" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <button class="btn btn-icon btn-sm btn-3 bg-gradient-default px-2" type="button" wire:click="newVehicleOpen">
                                <span class="btn-inner--icon"><i style="font-size: 1.5em;" class="fas fa-lg fa-user fa-xl cursor-pointer"></i></span>
                            </button>
                            
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end px-2 py-3 ms-n4"
                            aria-labelledby="dropdownMenuButton">
                            <li class="mb-2">
                                
                                    <div class="d-flex p-2">
                                        <div class="my-auto">
                                            
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="text-sm font-weight-normal mb-1">
                                                <span class="font-weight-bold">{{ auth()->user('user')['name']}}</span>
                                            </h6>
                                            <p class="text-xs text-dark mb-0">
                                                <i class="fa fa-clock me-1"></i>
                                                {{ auth()->user('user')['stationName']['CorporateName']}}
                                            </p>
                                        </div>
                                    </div>
                                
                            </li>
                            <hr class="horizontal dark mt-3">
                            <livewire:auth.logout />
                        </ul>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>
    <nav aria-label="breadcrumb" class="d-xl-none mt-2">
        <h6 class="font-weight-bolder mb-0 text-capitalize  px-4">{{ str_replace('-', ' ', Route::currentRouteName()) }}</h6>
        <hr class="horizontal dark mt-0">
    </nav>

