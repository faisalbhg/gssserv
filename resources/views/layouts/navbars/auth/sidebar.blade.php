<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="align-items-center d-flex m-0 navbar-brand text-wrap" href="{{ url('/') }}">
            <img src="{{asset('img/logos/gss-logo.svg')}}" class="navbar-brand-img h-100" alt="...">
            
        </a>

    </div>

    <hr class="horizontal dark mt-3">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item pb-2">
                <a class="nav-link {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <svg width="12px" height="12px" viewBox="0 0 45 40" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>shop </title>
                            <g id="Basic-Elements" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Rounded-Icons" transform="translate(-1716.000000, -439.000000)" fill="#FFFFFF"
                                    fill-rule="nonzero">
                                    <g id="Icons-with-opacity" transform="translate(1716.000000, 291.000000)">
                                        <g id="shop-" transform="translate(0.000000, 148.000000)">
                                            <path class="color-background"
                                                d="M46.7199583,10.7414583 L40.8449583,0.949791667 C40.4909749,0.360605034 39.8540131,0 39.1666667,0 L7.83333333,0 C7.1459869,0 6.50902508,0.360605034 6.15504167,0.949791667 L0.280041667,10.7414583 C0.0969176761,11.0460037 -1.23209662e-05,11.3946378 -1.23209662e-05,11.75 C-0.00758042603,16.0663731 3.48367543,19.5725301 7.80004167,19.5833333 L7.81570833,19.5833333 C9.75003686,19.5882688 11.6168794,18.8726691 13.0522917,17.5760417 C16.0171492,20.2556967 20.5292675,20.2556967 23.494125,17.5760417 C26.4604562,20.2616016 30.9794188,20.2616016 33.94575,17.5760417 C36.2421905,19.6477597 39.5441143,20.1708521 42.3684437,18.9103691 C45.1927731,17.649886 47.0084685,14.8428276 47.0000295,11.75 C47.0000295,11.3946378 46.9030823,11.0460037 46.7199583,10.7414583 Z"
                                                id="Path" opacity="0.598981585"></path>
                                            <path class="color-background"
                                                d="M39.198,22.4912623 C37.3776246,22.4928106 35.5817531,22.0149171 33.951625,21.0951667 L33.92225,21.1107282 C31.1430221,22.6838032 27.9255001,22.9318916 24.9844167,21.7998837 C24.4750389,21.605469 23.9777983,21.3722567 23.4960833,21.1018359 L23.4745417,21.1129513 C20.6961809,22.6871153 17.4786145,22.9344611 14.5386667,21.7998837 C14.029926,21.6054643 13.533337,21.3722507 13.0522917,21.1018359 C11.4250962,22.0190609 9.63246555,22.4947009 7.81570833,22.4912623 C7.16510551,22.4842162 6.51607673,22.4173045 5.875,22.2911849 L5.875,44.7220845 C5.875,45.9498589 6.7517757,46.9451667 7.83333333,46.9451667 L19.5833333,46.9451667 L19.5833333,33.6066734 L27.4166667,33.6066734 L27.4166667,46.9451667 L39.1666667,46.9451667 C40.2482243,46.9451667 41.125,45.9498589 41.125,44.7220845 L41.125,22.2822926 C40.4887822,22.4116582 39.8442868,22.4815492 39.198,22.4912623 Z"
                                                id="Path"></path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item mt-2 {{!in_array((auth()->user('user')->user_type),config('global.user_type_access')['operation']) ? 'd-none': ''}}">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Operation</h6>
            </li>
            <li class="nav-item pb-2 {{!in_array((auth()->user('user')->user_type),config('global.user_type_access')['operation']) ? 'd-none': ''}}">
                <a class="nav-link {{ in_array(request()->route()->getName(),['customer-jobs','customer-jobs-filter']) ? 'active' : ' ' }}"
                    href="{{ route('customer-jobs') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fa-solid fa-car-on fa-lg ps-2 pe-2 text-center
                        {{ in_array(request()->route()->getName(),['customer-jobs','customer-jobs-filter']) ? 'text-white' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Jobs</span>
                </a>
            </li>
            <li class="nav-item pb-2 {{!in_array((auth()->user('user')->user_type),config('global.user_type_access')['operation']) ? 'd-none': ''}}">
                <a class="nav-link {{ in_array(request()->route()->getName(),['packages']) ? 'active' : ' ' }}"
                    href="{{ route('packages') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fa-solid fa-layer-group fa-lg ps-2 pe-2 text-center
                        {{ in_array(request()->route()->getName(),['packages']) ? 'text-white' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Packages</span>
                </a>
            </li>

            <li class="nav-item pb-2 {{!in_array((auth()->user('user')->user_type),config('global.user_type_access')['security']) ? 'd-none': ''}}">
                <a class="nav-link {{ in_array(request()->route()->getName(),['gatepass']) ? 'active' : ' ' }}"
                    href="{{ route('gatepasses') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fa-solid fa-dungeon fa-lg ps-2 pe-2 text-center
                        {{ in_array(request()->route()->getName(),['gatepass']) ? 'text-white' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Gate Passes</span>
                </a>
            </li>

            <li class="nav-item pb-2 {{!in_array((auth()->user('user')->user_type),config('global.user_type_access')['section-forman']) ? 'd-none': ''}}">
                <a class="nav-link {{ in_array(request()->route()->getName(),['material-requisition']) ? 'active' : ' ' }}"
                    href="{{ route('material-requisition') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fa-solid fa-recycle fa-lg ps-2 pe-2 text-center
                        {{ in_array(request()->route()->getName(),['material-requisition']) ? 'text-white' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Material Requisition</span>
                </a>
            </li>

            <!-- <li class="nav-item mt-2 {{!in_array((auth()->user('user')->user_type),config('global.user_type_access')['finance']) ? 'd-none': ''}}">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Finance</h6>
            </li>
            <li class="nav-item pb-2 {{!in_array((auth()->user('user')->user_type),config('global.user_type_access')['finance']) ? 'd-none': ''}}">
                <a class="nav-link {{ Route::currentRouteName() == 'customer-jobs-reports' ? 'active' : '' }}"
                    href="{{ route('customer-jobs-reports') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fa-solid fa-file-invoice fa-lg ps-2 pe-2 text-center
                        {{ in_array(request()->route()->getName(),['customer-jobs-reports']) ? 'text-white' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Accounts</span>
                </a>
            </li> -->


            <li class="nav-item mt-2 {{!in_array((auth()->user('user')->user_type),config('global.user_type_access')['administrator']) ? 'd-none': ''}}">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Administration</h6>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'user-profile' ? 'active' : '' }}"
                    href="{{ route('user-profile') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <svg width="12px" height="12px" viewBox="0 0 46 42" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>customer-support</title>
                            <g id="Basic-Elements" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Rounded-Icons" transform="translate(-1717.000000, -291.000000)" fill="#FFFFFF"
                                    fill-rule="nonzero">
                                    <g id="Icons-with-opacity" transform="translate(1716.000000, 291.000000)">
                                        <g id="customer-support" transform="translate(1.000000, 0.000000)">
                                            <path class="color-background"
                                                d="M45,0 L26,0 C25.447,0 25,0.447 25,1 L25,20 C25,20.379 25.214,20.725 25.553,20.895 C25.694,20.965 25.848,21 26,21 C26.212,21 26.424,20.933 26.6,20.8 L34.333,15 L45,15 C45.553,15 46,14.553 46,14 L46,1 C46,0.447 45.553,0 45,0 Z"
                                                id="Path" opacity="0.59858631"></path>
                                            <path class="color-foreground"
                                                d="M22.883,32.86 C20.761,32.012 17.324,31 13,31 C8.676,31 5.239,32.012 3.116,32.86 C1.224,33.619 0,35.438 0,37.494 L0,41 C0,41.553 0.447,42 1,42 L25,42 C25.553,42 26,41.553 26,41 L26,37.494 C26,35.438 24.776,33.619 22.883,32.86 Z"
                                                id="Path"></path>
                                            <path class="color-foreground"
                                                d="M13,28 C17.432,28 21,22.529 21,18 C21,13.589 17.411,10 13,10 C8.589,10 5,13.589 5,18 C5,22.529 8.568,28 13,28 Z"
                                                id="Path"></path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <span class="nav-link-text ms-1">User Profile</span>
                </a>
            </li> -->

            <li class="nav-item {{!in_array((auth()->user('user')->user_type),config('global.user_type_access')['administrator']) ? 'd-none': ''}}">
                <a data-bs-toggle="collapse" href="#serviceMenu" class="nav-link {{ in_array(request()->route()->getName(),['services-prices-list','services-master-list','services-section-group','services-groups','stations-list','departments-list','sections-list','checklist','customer-types']) ? 'active' : ' ' }}" aria-controls="laravelExamples" role="button" aria-expanded="false">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fa-solid fa-lg fa-gear ps-2 pe-2 text-center
                        {{ in_array(request()->route()->getName(),['services-prices-list','services-master-list','services-section-group','services-groups','stations-list','departments-list','sections-list','checklist','customer-types']) ? 'text-white' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1"> Services </span>
                </a>
                <div class="collapse {{ in_array(request()->route()->getName(),['services-prices-list','services-master-list','services-section-group','services-groups','stations-list','departments-list','sections-list','checklist','customer-types']) ? 'show' : '' }}" id="serviceMenu" style="">
                    <ul class="nav ms-4 ps-3">
                        
                        <li class="nav-item ">
                            <a class="nav-link {{ Route::currentRouteName() == 'services-prices-list' ? 'active' : '' }}" href="{{ route('services-prices-list') }}">
                                <span class="sidenav-mini-icon"> D </span>
                                <span class="sidenav-normal"> Services Pricing List</span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link {{ Route::currentRouteName() == 'services-master-list' ? 'active' : '' }}" href="{{ route('services-master-list') }}">
                                <span class="sidenav-mini-icon"> D </span>
                                <span class="sidenav-normal"> Services Master List</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'services-section-group' ? 'active' : '' }}">
                            <a class="nav-link " href="{{ route('services-section-group') }}">
                                <span class="sidenav-mini-icon"> D </span>
                                <span class="sidenav-normal"> Services Section Group </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'services-groups' ? 'active' : '' }}">
                            <a class="nav-link " href="{{ route('services-groups') }}">
                                <span class="sidenav-mini-icon"> D </span>
                                <span class="sidenav-normal"> Services Group </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'stations-list' ? 'active' : '' }}">
                            <a class="nav-link " href="{{ route('stations-list') }}">
                                <span class="sidenav-mini-icon"> D </span>
                                <span class="sidenav-normal"> Stations </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'departments-list' ? 'active' : '' }}">
                            <a class="nav-link " href="{{ route('departments-list') }}">
                                <span class="sidenav-mini-icon"> D </span>
                                <span class="sidenav-normal"> Department </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'sections-list' ? 'active' : '' }}">
                            <a class="nav-link " href="{{ route('sections-list') }}">
                                <span class="sidenav-mini-icon"> D </span>
                                <span class="sidenav-normal"> Sections </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'checklist' ? 'active' : '' }}">
                            <a class="nav-link " href="{{ route('checklist') }}">
                                <span class="sidenav-mini-icon"> D </span>
                                <span class="sidenav-normal"> Checklist </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'customer-types' ? 'active' : '' }}">
                            <a class="nav-link " href="{{ route('customer-types') }}">
                                <span class="sidenav-mini-icon"> C </span>
                                <span class="sidenav-normal"> Customer Types </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item {{!in_array((auth()->user('user')->user_type),config('global.user_type_access')['administrator']) ? 'd-none': ''}}">
                <a data-bs-toggle="collapse" href="#serviceItemsMenu" class="nav-link {{ in_array(request()->route()->getName(),['sales-items-list','item-product-groups','services-item-categories','services-brands']) ? 'active' : ' ' }}" aria-controls="laravelExamples" role="button" aria-expanded="false">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fa-solid fa-shopping-cart fa-gear ps-2 pe-2 text-center
                        {{ in_array(request()->route()->getName(),['sales-items-list','item-product-groups','services-item-categories','services-brands']) ? 'text-white' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1"> Items </span>
                </a>
                <div class="collapse {{ in_array(request()->route()->getName(),['sales-items-list','item-product-groups','services-item-categories','services-brands']) ? 'show' : '' }}" id="serviceItemsMenu" style="">
                    <ul class="nav ms-4 ps-3">
                        <li class="nav-item ">
                            <a class="nav-link {{ Route::currentRouteName() == 'sales-items-list' ? 'active' : '' }}" href="{{ route('sales-items-list') }}">
                                <span class="sidenav-mini-icon"> D </span>
                                <span class="sidenav-normal"> Service Items</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'item-product-groups' ? 'active' : '' }}">
                            <a class="nav-link " href="{{ route('item-product-groups') }}">
                                <span class="sidenav-mini-icon"> D </span>
                                <span class="sidenav-normal"> Product Item Groups </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'services-item-categories' ? 'active' : '' }}">
                            <a class="nav-link " href="{{ route('services-item-categories') }}">
                                <span class="sidenav-mini-icon"> D </span>
                                <span class="sidenav-normal"> Categories </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'services-brands' ? 'active' : '' }}">
                            <a class="nav-link " href="{{ route('services-brands') }}">
                                <span class="sidenav-mini-icon"> D </span>
                                <span class="sidenav-normal"> Brands </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            

            <li class="nav-item {{!in_array((auth()->user('user')->user_type),config('global.user_type_access')['administrator']) ? 'd-none': ''}}">
                <a data-bs-toggle="collapse" href="#usersMenu" class="nav-link {{ in_array(request()->route()->getName(),['customers-list','user-management']) ? 'active' : ' ' }}" aria-controls="laravelExamples" role="button" aria-expanded="false">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-lg fa-user ps-2 pe-2 text-center
                        {{ in_array(request()->route()->getName(),['customers-list','user-management']) ? 'text-white' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1"> Users </span>
                </a>
                <div class="collapse {{ in_array(request()->route()->getName(),['customers-list','user-management']) ? 'show' : '' }}" id="usersMenu" style="">
                    <ul class="nav ms-4 ps-3">
                        <li class="nav-item {{ Route::currentRouteName() == 'customers-list' ? 'active' : '' }}">
                            <a class="nav-link " href="{{ route('customers-list') }}">
                                <span class="sidenav-mini-icon"> D </span>
                                <span class="sidenav-normal"> Customers </span>
                            </a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() == 'user-management' ? 'active' : '' }}">
                            <a class="nav-link " href="{{ route('user-management') }}">
                                <span class="sidenav-mini-icon"> D </span>
                                <span class="sidenav-normal"> Admin User </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            
            

            

            <!-- <li class="nav-item mt-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Example pages</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'tables' ? 'active' : '' }}"
                    href="{{ route('tables') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <svg width="12px" height="12px" viewBox="0 0 42 42" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>office</title>
                            <g id="Basic-Elements" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Rounded-Icons" transform="translate(-1869.000000, -293.000000)" fill="#FFFFFF"
                                    fill-rule="nonzero">
                                    <g id="Icons-with-opacity" transform="translate(1716.000000, 291.000000)">
                                        <g id="office" transform="translate(153.000000, 2.000000)">
                                            <path class="color-background"
                                                d="M12.25,17.5 L8.75,17.5 L8.75,1.75 C8.75,0.78225 9.53225,0 10.5,0 L31.5,0 C32.46775,0 33.25,0.78225 33.25,1.75 L33.25,12.25 L29.75,12.25 L29.75,3.5 L12.25,3.5 L12.25,17.5 Z"
                                                id="Path" opacity="0.6"></path>
                                            <path class="color-background"
                                                d="M40.25,14 L24.5,14 C23.53225,14 22.75,14.78225 22.75,15.75 L22.75,38.5 L19.25,38.5 L19.25,22.75 C19.25,21.78225 18.46775,21 17.5,21 L1.75,21 C0.78225,21 0,21.78225 0,22.75 L0,40.25 C0,41.21775 0.78225,42 1.75,42 L40.25,42 C41.21775,42 42,41.21775 42,40.25 L42,15.75 C42,14.78225 41.21775,14 40.25,14 Z M12.25,36.75 L7,36.75 L7,33.25 L12.25,33.25 L12.25,36.75 Z M12.25,29.75 L7,29.75 L7,26.25 L12.25,26.25 L12.25,29.75 Z M35,36.75 L29.75,36.75 L29.75,33.25 L35,33.25 L35,36.75 Z M35,29.75 L29.75,29.75 L29.75,26.25 L35,26.25 L35,29.75 Z M35,22.75 L29.75,22.75 L29.75,19.25 L35,19.25 L35,22.75 Z"
                                                id="Shape"></path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <span class="nav-link-text ms-1">Tables</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'billing' ? 'active' : '' }}"
                    href="{{ route('billing') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>credit-card</title>
                            <g id="Basic-Elements" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Rounded-Icons" transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF"
                                    fill-rule="nonzero">
                                    <g id="Icons-with-opacity" transform="translate(1716.000000, 291.000000)">
                                        <g id="credit-card" transform="translate(453.000000, 454.000000)">
                                            <path class="color-background"
                                                d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z"
                                                id="Path" opacity="0.593633743"></path>
                                            <path class="color-background"
                                                d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"
                                                id="Shape"></path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <span class="nav-link-text ms-1">Billing</span>
                </a>
            </li> -->
            <hr class="horizontal dark mt-3">
            <li class="nav-item">
                <a class="nav-link pb-0"
                    href="">
                    <i class="fa fa-user me-sm-1"></i>
                    Welcome {{ ucfirst(auth()->user('user')->name)}}
                </a>

            </li>
            <livewire:auth.logout />
        </ul>
    </div>
    
</aside>
