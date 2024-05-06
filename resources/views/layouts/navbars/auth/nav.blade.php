<main class="main-content mt-1 border-radius-lg">
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 border-radius-xl shadow-none position-sticky blur shadow-blur mt-4 left-auto top-1 z-index-sticky" id="navbarBlur"
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
            <nav aria-label="breadcrumb">
                <!-- <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5  px-4">
                    <li class="breadcrumb-item text-sm text-dark active text-capitalize" aria-current="page">
                        {{ str_replace('-', ' ', Route::currentRouteName()) }}</li>
                </ol> -->
                <h6 class="font-weight-bolder mb-0 text-capitalize  px-4">
                    {{ str_replace('-', ' ', Route::currentRouteName()) }}</h6>
            </nav>
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 d-flex justify-content-end" id="navbar">

                <!-- <div class="nav-item d-flex align-itel-left">
                    <a href="{{ route('dashboard') }}"
                        class="btn btn-primary active mb-0 text-white" role="button" aria-pressed="true">
                        New Car
                    </a>
                </div> -->
                
                <ul class="navbar-nav justify-content-end">
                    <li class="nav-item px-2  d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                            {{Session::get('user')->name}}
                            <livewire:auth.logout />
                        </a>
                    </li>
                    <!-- <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                            </div>
                        </a>
                    </li> -->
                    

                    <li class="nav-item px-1 dropdown pe-2 d-flex align-items-center">
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
                    
                    <li class="nav-item px-3 d-flex align-items-center {{ Route::currentRouteName() == 'dashboard' ? '' : 'd-none' }}"  >
                        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="fa-solid fa-cart-shopping fixed-plugin-button-nav cursor-pointer cartitemcount"></i>
                        </div>
                    </li>

                    
                </ul>
            </div>
        </div>
    </nav>

