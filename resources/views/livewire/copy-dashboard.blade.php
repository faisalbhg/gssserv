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
</style>
@endpush

 <main class="main-content position-relative h-100 border-radius-lg">
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
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12  col-sm-12 col-xs-12 col-xxs-12">
                <div class="card p-3 m-0" >
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-5  col-sm-6 col-xs-6 col-xxs-6">
                                <p class="h5 text-left">Customer Details
                                    @if($customer_id)
                                    <a class="float-end text-danger text-xs cursor-pointer" wire:click="editCustomer()"><small>Edit Customer</small></a>
                                    @endif
                                </p>
                                <hr class="mt-0">
                                <div class="row">
                                    <form  autocomplete="off" wire:submit.prevent="saveCustomer" method="POST"  enctype="multipart/form-data">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="mobilenumberInput">Mobile Number </label>
                                            <div class="input-group mb-0">
                                                <span class="input-group-text px-0">+971</span>
                                                <input class="form-control" placeholder="Mobile Number" type="number" wire:model="mobile" wire:keyup="searchResult" name="mobile" id="mobilenumberInput">
                                            </div>
                                            @error('mobile') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    @if ($showCustomerFormDiv)
                                        <div class="col-md-12">
                                            <div class="form-group openDiv">
                                                <label for="nameInput">Name</label>
                                                <input type="text" class="form-control" wire:model="name" name="name" placeholder="Name" id="nameInput">
                                                @error('name') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group openName">
                                                <label for="emailInput">Email</label>
                                                <input type="email" wire:model="email" name="email" class="form-control" id="emailInput" placeholder="Email">
                                                @error('email') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="customerTypeSelect">Customer Type</label>
                                                <select id="customerTypeSelect" wire:model="customer_type" class="form-control selectSearch">
                                                    <option value="">-Select-</option>
                                                    @foreach($customerTypeList as $customerType)
                                                    <option value="{{$customerType->id}}">{{$customerType->customer_type}}</option>
                                                    @endforeach
                                                </select>
                                                @error('customer_type') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect2">Customer ID image</label>
                                                <input type="file" class="form-control" wire:model="customer_id_image">
                                                @if($customer_id_image)
                                                    Photo Preview:
                                                    <img class="img-fluid border-radius-lg" src="{{ $customer_id_image->temporaryUrl() }}">
                                                @endif
                                            </div>
                                        </div>
                                        
                                        @if($updateCustomerFormDiv)
                                        <div class="col-md-12">
                                            <button type="button" wire:click="updateCustomer()" class="btn btn-primary btn-sm">Update Customer</button>
                                        </div>
                                        @endif
                                    @else
                                    @endif
                                    </form>
                                </div>
                            </div>
                            @if ($showVehicleFormDiv || $numberPlateAddForm)
                            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-7  col-sm-6 col-xs-6 col-xxs-6">
                                <div class="row">
                                    <p class="h5 text-left">Vehicle Details</p><hr class="mt-0">
                                    @if($numberPlateAddForm)
                                    <div class="col-md-12">
                                        <label for="vehicleNameInput">Plate Number</label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <select class="form-control selectSearch " wire:model="plate_state" name="plate_state" id="plateState" style="padding:0.5rem 0.3rem !important;" wire:change="searchResult">
                                                    <option value="">-Emirates-</option>
                                                    @foreach($stateList as $state)
                                                        <option value="{{$state->state_name}}">{{$state->state_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <input style="padding:0.5rem 0.3rem !important;" type="text" class="form-control @error('plate_code') btn-outline-danger @enderror" wire:model="plate_code" wire:keyup="searchResult" name="plate_code" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" minlength="1" maxlength="2" placeholder="Code">
                                            </div>
                                            <div class="col-md-5">
                                                <input style="padding:0.5rem 0.3rem !important;" type="number" class="form-control @error('plate_number') btn-outline-danger @enderror" wire:model="plate_number" wire:keyup="searchResult" name="plate_number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" minlength="1" maxlength="6" placeholder="Number">
                                            </div>
                                        </div>
                                        @error('plate_state') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    @endif
                                    @if($otherVehicleForm)
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect2">Vehicle Picture</label>
                                            <input type="file" class="form-control" wire:model.lazy="vehicle_image">
                                            @error('vehicle_image') <span class="text-danger">{{ $message }}</span> @enderror
                                            @if ($vehicle_image)
                                                Photo Preview:
                                                <img class="img-fluid border-radius-lg" src="{{ $vehicle_image->temporaryUrl() }}">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="vehicleTypeInput">Vehicle Type</label>
                                            <select class="form-control selectSearch" id="vehicleTypeInput" wire:model="vehicle_type">
                                                <option value="">-Select-</option>
                                                @foreach($vehicleTypesList as $vehicleType)
                                                <option value="{{$vehicleType->id}}">{{$vehicleType->type_name}}</option>
                                                @endforeach
                                            </select>
                                            @error('vehicle_type') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="vehicleMakeInput">Vehicle Make</label>
                                            <select class="form-control selectSearch" id="vehicleMakeInput" wire:model="make" >
                                                <option value="">-Select-</option>
                                                @foreach($vehiclesMakeList as $vehicleName)
                                                <option value="{{$vehicleName->vehicle_make}}">{{$vehicleName->vehicle_make}}</option>
                                                @endforeach
                                            </select>
                                            @error('make') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="vehicleModelInput">Vehicle Model</label>
                                            <select class="form-control" id="vehicleModelInput" wire:model="model">
                                                <option value="">-Select-</option>
                                                @foreach($vehiclesModel as $model)
                                                <option value="{{$model->vehicle_model}}">{{$model->vehicle_model}}</option>
                                                @endforeach
                                            </select>
                                             @error('model') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect2">PlateNumber Imgae</label>
                                            <input type="file" class="form-control" wire:model="plate_number_image">
                                            @if ($plate_number_image)
                                                <button type="button" class="btn bg-gradient-secondary btn-sm" wire:click="getPlateNumber('{{$plate_number_image->temporaryUrl()}}')">Get Plate Number</button>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect2">Chaisis Imgae</label>
                                            <input type="file" class="form-control" wire:model="chaisis_image">
                                            @if ($chaisis_image)
                                                <button type="button" class="btn bg-gradient-secondary btn-sm" wire:click="getChaisisNumber('{{$chaisis_image->temporaryUrl()}}')">Get Chaisis Number</button>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="chaisisNumberInput">Chaisis Number</label>
                                            <input type="text" class="form-control" id="chaisisNumberInput" wire:model="chassis_number" name="chassis_number" placeholder="Chassis Number">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="vehicleKmInput">K.M Reading</label>
                                            <input type="number" class="form-control" id="vehicleKmInput" wire:model="vehicle_km" name="vehicle_km" placeholder="Chaisis Number">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="button" wire:click="saveVehicleCustomer()" class="btn btn-primary btn-sm">Save Customer</button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                             @endif
                            @if ($selectedCustomerVehicle)
                            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-7  col-sm-6 col-xs-6 col-xxs-6">
                                <div class="card px-2 mb-0" >
                                    <div class="card card-profile card-plain p-0">
                                        <div class="card-header p-0">
                                            <h5 class="font-weight-bolder mb-0">{{$sCtmrVhlvehicleName}}</h5>
                                            <p class="text-uppercase text-sm font-weight-bold mb-0">{{$sCtmrVhlmake_model}} ({{$sCtmrVhlplate_number}})</p>
                                            @if($sCtmrVhlchassis_number)
                                            <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">Chassis: {{$sCtmrVhlchassis_number}}</span><br>
                                            @endif
                                            @if($sCtmrVhlvehicle_km)
                                            <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">KM reading : {{$sCtmrVhlvehicle_km}}</span>
                                            @endif
                                            <div class="form-check ">
                                                <input type="checkbox" class="form-check-input" wire:model="vehicleNewKM" @if ($vehicleNewKM) checked @endif >
                                                <label class="mb-1 custom-control-label" for="customCheckDisabled">New Vehicle KM</label>
                                                @if ($vehicleNewKM)
                                                    <input type="number" class="form-control w-60 mb-1" wire:model.lazy="new_vehicle_km" placeholder="New K.M Reading">
                                                    <button type="button" wire:click="saveVehicleKmReading('{{$sCtmrVhlcustomer_vehicle_id}}')" class="btn btn-primary btn-sm">Save New K.M Reading</button>
                                                @endif
                                            </div>
                                            <hr class="p-0 m-0 mb-1">
                                        </div>
                                        <div class="card-body text-left p-0">
                                            <div class="row">
                                                <div class="col-xxs-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6">
                                                    <a href="javascript:;">
                                                        <div class="position-relative">
                                                            <div class="blur-shadow-image p-0">
                                                                <img class="w-70 rounded-3 shadow-lg" src="{{url('storage/'.$sCtmrVhlvehicle_image)}}">
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="col-xxs-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 mt-1">
                                                    <div class="p-md-0 pt-3">
                                                        <div class="author align-items-center">
                                                            <img src="{{asset('img/kit/pro/team-2.jpg')}}" alt="..." class="avatar shadow">
                                                            <div class="name ps-3">
                                                                <span>{{$sCtmrVhlname}}<small>({{$sCtmrVhlcustomerType}})</small></span>
                                                                <div class="stats">
                                                                    <small>{{$sCtmrVhlemail}}<br>{{$sCtmrVhlmobile}}</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="card-footer  p-0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        
                        <div class="row mt-2">
                            @if($showVehicleDiv)
                                <div class="col-md-12">
                                    <p class="h5 text-left">Vehicle Details</p><hr class="mt-0">
                                </div>
                                @foreach($customers as $customer)
                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6  col-sm-6 col-xs-6 col-xxs-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card p-2" >
                                                    @if ($customer->vehicle_image)
                                                    <div class="card-header p-0 m-0 position-relative z-index-1">
                                                        <a href="javascript:;" class="d-block">
                                                            <img src="{{url('storage/'.$customer->vehicle_image)}}" class="img-fluid border-radius-lg">
                                                        </a>
                                                    </div>
                                                    @endif
                                                    <div class="card-body p-0">
                                                        <h5 class="font-weight-bolder mb-0">{{$customer->vehicleName}}</h5>
                                                        <p class="text-uppercase text-sm font-weight-bold mb-0">{{$customer->make_model}} ({{$customer->plate_number_final}})</p>
                                                        <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">Chassis: {{$customer->chassis_number}}</span><br>
                                                        <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">KM reading : {{$customer->vehicle_km}}</span>
                                                        <div class="author align-items-center">
                                                            <img src="{{asset('img/kit/pro/team-2.jpg')}}" alt="..." class="avatar shadow">
                                                            <div class="name ps-3">
                                                                <span>{{$customer->name}}<small>({{$customer->customerType}})</small></span>
                                                                <div class="stats">
                                                                    <small>{{$customer->email}}<br>{{$customer->mobile}}</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr class="horizontal dark my-1">
                                                        <div>
                                                            <button type="button" class="btn bg-gradient-info selectVehicle btn-xs py-2 float-start" wire:click="addNewVehicle('{{$customer}}')">Add New</button>
                                                            <button type="button" class=" float-end btn bg-gradient-success selectVehicle btn-xs py-2 " wire:click="selectVehicle('{{$customer}}')">Select</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        @if($cardShow)
                            <div class="row mt-3">
                                @if($cartItems)
                                <div class="col-md-12 mb-4" id="cartDetails">
                                    <div class="card p-2 mb-4">
                                        <div class="card-header px-2 py-0">
                                            
                                            <h3 class="px-2 text-lg text-bold">{{ count($cartItems) }} Services selected </h3>
                                        </div>
                                        <div class="card-body p-2 mb-4">
                                            <div class="table-responsive">
                                                <table class="table align-items-center mb-0">
                                                  <thead>
                                                    <tr>
                                                        <th class="text-uppercase text-dark text-sm font-weight-bolder opacity-7">Service</th>
                                                        <th class="text-uppercase text-dark text-sm font-weight-bolder opacity-7 ps-2">price</th>
                                                        <th class="text-uppercase text-dark text-sm font-weight-bolder opacity-7 ps-2 ">
                                                            <span class="">Quantity</span>
                                                        </th>
                                                        <th class="text-uppercase text-dark text-sm font-weight-bolder opacity-7 ps-2">Total</th>
                                                        <th class="text-uppercase text-dark text-sm font-weight-bolder opacity-7 ps-2">Remove</th>
                                                        <th></th>
                                                    </tr>
                                                  </thead>
                                                  <tbody>
                                                    <?php $total=0; ?>
                                                    @foreach ($cartItems as $item)
                                                        <tr>
                                                            <td>
                                                                <h6 class="mb-0 text-xs">
                                                                    @if($item->service_item)
                                                                    {{ $item->item_name }} (Item)  
                                                                    @else
                                                                    {{ $item->service_type_name }} (Service)
                                                                    @endif
                                                                </h6>
                                                            </td>
                                                            
                                                            <td class="hidden text-right md:table-cell">
                                                                <p class="text-xs font-weight-bold mb-0">AED {{ round($item->price,2) }}</p>
                                                            </td>
                                                            <td class="justify-center mt-6 md:justify-end md:flex">
                                                                <div class="h-10 w-28">
                                                                    <div class="relative flex flex-row w-full h-8">
                                                                        <div>
                                                                            {{ $item->quantity}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="justify-center mt-6 md:justify-end md:flex">
                                                                <div class="h-10 w-28">
                                                                    <div class="relative flex flex-row w-full h-8">
                                                                        <div>
                                                                            {{ $item->quantity*$item->price}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="hidden text-right md:table-cell">
                                                                <a href="#" class="px-4 py-2 text-danger bg-red-600" wire:click.prevent="removeCart('{{$item->id}}')"><i class="fa fa-trash"></i></a>    
                                                            </td>
                                                        </tr>
                                                        <?php $total = $total+$item->price*$item->quantity; ?>
                                                    @endforeach
                                                    <?php $tax = $total * (config('global.TAX_PERCENT') / 100);
                                                    $grand_total = $total+$tax;
                                                    ?>
                                                  </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="card-footer p-2 mb-4">
                                            <div class="row d-flex flex-row justify-content-between">
                                                <div class="col-md-12">
                                                    <p class="text-end  text-bold text-md mb-0">Total: AED {{ $total }}</p>
                                                    <p class="text-end  text-bold text-md">Tax: AED {{ $tax }}</p>
                                                    <p class="text-end  text-bold text-lg">Grand total: AED {{ $grand_total }}</p>
                                                </div>
                                                <hr>
                                                <div class="col-md-6">
                                                    <button class="btn bg-gradient-danger btn-sm" wire:click.prevent="clearAllCart">Remove All Cart</button>
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="button" class="btn bg-gradient-success btn-sm float-end" wire:click="submitService()">Confirm & Continue</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="col-md-12 mb-4" id="paymentDetails" style="display:none;">
                                    <div class="card p-2 mb-4">
                                        <div class="card-header text-center pt-4 pb-3">
                                            
                                            <h1 class="font-weight-bold mt-2">
                                                Payment #{{$job_number}}
                                            </h1>
                                            <span class="badge rounded-pill bg-light text-dark text-lg"><small>AED</small> {{ $grand_total }}</span>
                                        </div>
                                        <div class="card-body text-lg-left text-center pt-0">

                                            <div class="d-flex justify-content-center p-2">
                                                <div class="form-check">
                                                    <a wire:click="completePaymnet('link','{{$job_number}}')" class="btn btn-icon bg-gradient-info d-lg-block mt-3 mb-0">Pay By Link<i class="fa-solid fa-comments-dollar ms-1" ></i></a>
                                                </div>
                                            
                                                <div class="form-check">
                                                    <a wire:click="completePaymnet('card','{{$job_number}}')" class="btn btn-icon bg-gradient-warning d-lg-block mt-3 mb-0">Pay By Card<i class="fa-solid fa-credit-card ms-1" ></i></a>
                                                </div>
                                            
                                                <div class="form-check">
                                                    <a wire:click="completePaymnet('cash','{{$job_number}}')" class="btn btn-icon bg-gradient-danger d-lg-block mt-3 mb-0">Cash Payment<i class="fa-solid fa-money-bill-1-wave ms-1" ></i></a>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-4" id="paymentRespnse" style="display:none;">
                                    <div class="card p-2 mb-4 bg-cover text-center" style="background-image: url('https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/curved-images/curved1.jpg')">
                                        <div class="card-body z-index-2 py-9">
                                            <h2 class="text-white">Successful..!</h2>
                                            <p class="text-white">The service in under processing</p>
                                            <button type="button" class=" text-white btn bg-gradient-default selectVehicle py-2 " >Job Number: {{$job_number}}</button>
                                        </div>
                                        <div class="mask bg-gradient-primary border-radius-lg"></div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($showCheckout)
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="card card-plain text-center">
                                        <a href="javascript:;">
                                            <img class="avatar w-100 avatar-xl shadow" src="{{asset('img/kit/pro/team-1.jpg')}}">
                                        </a>

                                        <div class="card-body">
                                            <h4 class="card-title">Andrew John</h4>
                                            <h6 class="category text-info text-gradient">Loan Counselor</h6>
                                            <p class="card-description">
                                                "Don't walk behind me; I may not lead. Don't walk in front of me; I may not follow. Just walk beside me and be my friend."
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{$cartItems}}
                        @endif
                        @if ($showServiceGroup)
                            <div class="row mt-2 mb-2">
                                @if ($selectedCustomerVehicle)
                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <p class="h5 text-left">Services Details</p><hr class="m-0" >
                                    </div>
                                    @if(!$servicesGroups->isEmpty())
                                        @foreach($servicesGroups as $servicesGroup)
                                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="card h-100 p-3">
                                                    
                                                    <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('{{asset("img/".$servicesGroup->service_group_code.".jpg")}}');">
                                                        
                                                        @if($service_group_id == $servicesGroup->id)
                                                        <span class="mask bg-gradient-dark opacity-4"></span>
                                                        @else
                                                        <span class="mask bg-gradient-dark opacity-8"></span>
                                                        @endif
                                                        
                                                        <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
                                                            <!--  -->
                                                            <h5 class="text-white font-weight-bolder mb-4 pt-2">{{$servicesGroup->service_group_name}}</h5>
                                                            <!-- <p class="text-white">Wealth creation is an evolutionarily recent positive-sum game. It is all about who take the opportunity first.</p> -->
                                                            <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:;">
                                                                @if($service_group_id == $servicesGroup->id)
                                                                <button wire:click="serviceGroupForm('{{$servicesGroup}}')" class="btn bg-gradient-primary" type="button" >
                                                                    Select
                                                                </button>
                                                                @else
                                                                <button type="button" wire:click="serviceGroupForm('{{$servicesGroup}}')" class="btn btn-outline-light">Select</button>
                                                                @endif
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                @endif
                            </div>
                            @if($showServicesitems || $showServiceType)
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <h5>
                                            <a wire:click="showServices();" href="javascript:;" class="services btn btn-sm bg-gradient-dark border-radius-md mt-0 mb-2">
                                                <i class="fa-solid fa-car"></i> Services
                                            </a>
                                            @if($showServicesitems)
                                            <a href="javascript:;" class="serviceitems btn btn-sm bg-gradient-primary border-radius-md mt-0 mb-2" wire:click="showServiceItem();">
                                            <i class="fa-solid fa-shopping-cart"></i>
                                             Service items</a>
                                             @endif
                                            <input type="text"  class="form-control float-end" style="width:20%;" placeholder="Search Services" wire:model="service_search" />
                                        </h5>
                                        <hr>
                                    </div>
                                    @if($selectServicesitems)
                                        @forelse($serviceItemsList as $items)
                                        <?php
                                        $servicesItem = $items->serviceItems;
                                        ?>
                                            <div class="col-md-4 mb-4">
                                                <div class="card">
                                                  <div class="card-header text-center pt-4 pb-3">
                                                    <span class="badge rounded-pill bg-light text-dark">{{$servicesItem['item_name']}}</span>
                                                    <h1 class="font-weight-bold mt-2">
                                                      <small>AED</small>{{round($items->sale_price,2)}}
                                                    </h1>
                                                  </div>
                                                  <div class="card-body text-lg-left text-center pt-0">
                                                    

                                                    <a href="javascript:;" class="btn btn-icon bg-gradient-primary d-lg-block mt-3 mb-0" wire:click="addtoCartItem('{{$items}}')">
                                                      Buy Now
                                                      <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
                                                    </a>
                                                  </div>
                                                </div>
                                              </div>
                                        @empty
                                            
                                        @endforelse
                                    @endif
                                    
                                    @if($showServiceType)
                                        @foreach($servicesTypesList as $servicesType)
                                            <div class="col-md-4 mb-4">
                                                <div class="card shadow-none border h-100">
                                                  <div class="card-header text-sm-left text-center pt-4 pb-3 px-4">
                                                    <!-- <h5 class="mb-1">Pro</h5> -->
                                                    <p class="mb-3 text-sm">{{$servicesType->service_type_name}}</p>
                                                    <h3 class="font-weight-bolder mt-3">
                                                      AED {{round($servicesType->unit_price,2)}} 
                                                    </h3>
                                                    <a href="javascript:;" wire:click="addtoCart('{{$servicesType}}')" class="btn btn-sm bg-gradient-dark w-100 border-radius-md mt-4 mb-2">Buy now</a>
                                                  </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
                
                        
            </div>
        </div>
      
        <div class="row mt-2">
            <p class="h5 mt-2 px-4">Jobs Over View</p>
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
                                      <p class="text-sm text-dark mb-0">{{$jobs->name}}({{$jobs->customerType}})<br>{{$jobs->email}}<br>{{$jobs->mobile}}</p>
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
                                <!-- <td>
                                  <span class="text-xs {{config('global.job_department_text_class')[$jobs->job_status]}} font-weight-bold">{{config('global.job_department')[$jobs->job_departent]}}</span>
                                </td> -->
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
                        @include('components.modals.updateservice')
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
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
        <div class="row mt-3">
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
        <!-- components.modals.servicemodel -->
        @include('components.plugins.fixed-plugin')
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
window.addEventListener('selectSearchEvent',event=>{
    $(document).ready(function () {
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
</script>
@endpush