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

        @if($showCustomerSearch)
            <div class="row mt-2">
                @if($showSearchMobile)
                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-5  col-sm-6 col-xs-6 col-xxs-6">
                        <div class="card p-3 m-0" >
                            <div class="card-header p-0">
                                <p class="h5 text-left">Customer Details
                                    @if($customer_id)
                                    <a class="float-end text-danger text-xs cursor-pointer" wire:click="editCustomer()"><small>Edit Customer</small></a>
                                    @endif
                                </p>
                                <hr class="mt-0">
                            </div>
                            <div class="card-body p-0">
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
                                    @if ($showCustomerForm)
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
                        </div>
                    </div>
                @endif
                @if($showVehicleForm)
                    <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-7  col-sm-6 col-xs-6 col-xxs-6">
                        <div class="card p-3 m-0" >
                            <div class="card-header p-0">
                                <p class="h5 text-left">Vehicle Details</p>
                                <hr class="mt-0">
                            </div>
                            <div class="card-body p-0">
                                <div class="row">
                                    
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
                                    @if($otherVehicleDetailsForm)
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect2">Vehicle Picture</label>
                                                <input type="file" class="form-control" wire:model.lazy="vehicle_image">
                                                @error('vehicle_image') <span class="text-danger">{{ $message }}</span> @enderror
                                                @if ($vehicle_image)
                                                    <img class="img-fluid border-radius-lg w-30" src="{{ $vehicle_image->temporaryUrl() }}">
                                                @endif
                                            </div>
                                            <div wire:loading wire:target="vehicle_image">
                                                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                    <div class="la-ball-beat">
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                    </div>
                                                </div>
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
                        </div>
                    </div>
                @endif
            </div>
        @endif

        @if($showVehicleAvailable)
            <div class="row mb-2">
                <div class="col-12 mt-4">
                    <div class="card mb-4">
                        <div class="card-header pb-0 p-3">
                            <h6 class="mb-1">Available Vehicles</h6>
                            <hr class="m-0">
                        </div>
                        <div class="card-body p-3">
                            <div class="row">
                                @foreach($customers as $customer)
                                <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                                    <div class="card card-blog card-plain">
                                        <div class="position-relative">
                                            <a class="d-block shadow-xl border-radius-xl"  wire:click="selectVehicle('{{$customer}}')">
                                                <img src="{{url('storage/'.$customer->vehicle_image)}}" alt="img-blur-shadow" class="img-fluid shadow border-radius-xl">
                                            </a>
                                        </div>
                                        <div class="card-body px-1 pb-0">
                                            <p class="text-gradient text-dark mb-2 text-sm">{{$customer->vehicleName}}</p>
                                            <a href="javascript:;">
                                                <h5>
                                                    {{$customer->make_model}} ({{$customer->plate_number_final}})
                                                </h5>
                                            </a>
                                            <p class="mb-4 text-sm">
                                                {{$customer->name}}<small>({{$customer->customerType}})</small>
                                                <br>
                                                <small>{{$customer->email}}<br>{{$customer->mobile}}</small>
                                            </p>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <button type="button" class="btn btn-outline-success btn-sm mb-0"  wire:click="selectVehicle('{{$customer}}')">Select</button>
                                                <button type="button" class="btn btn-outline-primary btn-sm mb-0"  wire:click="addNewVehicle('{{$customer}}')">New</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                
                                <!-- <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                                    <div class="card h-100 card-plain border">
                                        <div class="card-body d-flex flex-column justify-content-center text-center" wire:click="addNewVehicle()">
                                            <a href="javascript:;">
                                                <i class="fa fa-plus text-secondary mb-3" aria-hidden="true"></i>
                                                <h5 class=" text-secondary"> New Vehicle </h5>
                                            </a>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($selectedCustomerVehicle)
            <div class="row mb-2">
                <div class="col-xxs-4 col-xs-4 col-sm-4 col-md-6 col-lg-3 col-xl-3 col-xxl-3 mt-1">
                    <a href="javascript:;">
                        <div class="position-relative">
                            <div class="blur-shadow-image p-0 pt-2">
                                <img class="w-100 rounded-3 shadow-lg" src="{{url('storage/'.$sCtmrVhlvehicle_image)}}">
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xxs-8 col-xs-8 col-sm-8 col-md-6 col-lg-9 col-xl-9 col-xxl-9 mt-1">
                    <div class="p-md-0 pt-3">
                        <div class="row mt-2">
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12  col-sm-12 col-xs-12 col-xxs-12">
                                <div class="card px-2 mb-0" >
                                    <div class="card card-profile card-plain p-0">
                                        <div class="card-body text-left p-0">
                                            
                                            <h5 class="font-weight-bolder mb-0">{{$sCtmrVhlvehicleName}}</h5>
                                            <p class="text-uppercase text-sm font-weight-bold mb-0">{{$sCtmrVhlmake_model}} ({{$sCtmrVhlplate_number}})</p>
                                            @if($sCtmrVhlchassis_number)
                                            <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">Chassis: {{$sCtmrVhlchassis_number}}</span><br>
                                            @endif
                                            @if($sCtmrVhlvehicle_km)
                                            <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">KM reading : {{$sCtmrVhlvehicle_km}}</span>
                                            @endif
                                            <div class="form-check ">
                                                <input type="checkbox" class="form-check-input" wire:model="vehicleNewKM" @if ($vehicleNewKM) checked @endif id="newVehicleKMClick" wire:click="showNewKM()" >
                                                <label class="mb-1 custom-control-label" for="customCheckDisabled">New Vehicle KM</label>
                                                @if ($showVehicleNewKM)
                                                    <input type="number" class="form-control w-60 mb-1" wire:model.lazy="new_vehicle_km" placeholder="New K.M Reading">
                                                    <button type="button" wire:click="saveVehicleKmReading('{{$sCtmrVhlcustomer_vehicle_id}}')" class="btn btn-primary btn-sm">Save New K.M Reading</button>
                                                @endif
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="author align-items-center">
                            <img src="{{asset('img/kit/pro/team-2.jpg')}}" alt="..." class="avatar shadow">
                            <div class="name ps-3">
                                <span>{{$sCtmrVhlname}}<small>({{$sCtmrVhlcustomerType}})</small> </span> 
                                <p>@if($customer_id)
                                    <a class="float-end text-danger text-xs cursor-pointer" wire:click="editCustomer()"><small>Edit Customer</small></a>
                                    @endif</p>
                                <div class="stats">
                                    <small>{{$sCtmrVhlemail}}<br>{{$sCtmrVhlmobile}}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

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

                            <div wire:loading wire:target="completePaymnet">
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
        @endif

        @if ($showServiceGroup)
            <div class="row mt-2 mb-2">
                @if ($selectedCustomerVehicle)
                    <!-- <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <p class="h5 text-left">Services Details</p><hr class="m-0" >
                    </div> -->
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
                                <div class="card ">
                                    <div class="card-header text-center pt-4 pb-3">
                                        <span class=" text-dark">{{$servicesType->service_type_name}}</span>
                                        <h2 class="font-weight-bold mt-2">
                                          <small>AED</small>{{round($servicesType->unit_price,2)}}
                                        </h2>
                                    </div>
                                  <div class="card-body text-lg-left text-center pt-0">
                                    <a href="javascript:;" wire:click="addtoCart('{{$servicesType}}')" class="btn btn-sm bg-gradient-dark w-100 border-radius-md mt-4 mb-2">Buy now</a>
                                  </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            @endif
        @endif

        
        @if($showCheckList)
            <div class="row mt-3">
                @if($showGSCheckList)
                <div class="col-xxs-12 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-4">
                    <div class="card">
                        <div class="card-header text-center pt-4 pb-3">
                            <h5 class="font-weight-bold mt-2">Check List</h5>
                        </div>
                        <div class="card-body text-left pt-0">
                            @foreach($checklistLabels as $checklist)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="checklistLabel" value="{{$checklist->id}}" id="checkList{{ str_replace(" ","",$checklist->checklist_label) }}" >
                                <label class="custom-control-label" for="checkList{{ str_replace(" ","",$checklist->checklist_label) }}">{{$checklist->checklist_label}}</label>
                            </div>
                            @endforeach
                        </div>
                        <div class="card-footer text-left pt-0">
                            <label class="custom-control-label" for="fcustomCheckRadioTapeCD">Note: <small>Minor surface scratches defects, stone chipping, scratches on glasses etc. are included</small></label>
                        </div>
                    </div>
                </div>
                <div class="col-xxs-12 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-4">
                    <div class="card mb-3">
                        <div class="card-header text-left pt-4 pb-3">
                            <h5 class="font-weight-bold mt-2">Fuel</h5>
                        </div>
                        <div class="card-body text-left pt-0">
                            <div class="row"> 
                                @foreach(config('global.fuel') as $keyF => $fuel)
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="fuel" value="{{$keyF}}" id="flexRadio{{$fuel}}">
                                        <label class="custom-control-label" for="flexRadio{{$fuel}}">{{$fuel}}</label>
                                    </div>
                                </div>
                                @endforeach
                                @error('fuel') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header text-left pt-4 pb-3">
                            <h5 class="font-weight-bold mt-2">Scratches</h5>
                        </div>
                        <div class="card-body text-left pt-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="textareaScratchesFound">Scratches Found</label>
                                        <textarea class="form-control" id="scratchesFound" wire:model="scratchesFound" rows="3"></textarea>
                                        @error('scratchesFound') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="textareaScratchesNotFound">Scratches Not Found</label>
                                        <textarea class="form-control" id="scratchesNotFound" wire:model="scratchesNotFound" rows="3"></textarea>
                                        @error('scratchesNotFound') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @elseif($showQLCheckList)
                <div class="col-xxs-12 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-4">
                    <div class="card mb-3">
                        <div class="card-header text-left pt-4 pb-3">
                            <h5 class="font-weight-bold mt-2">Fuel</h5>
                        </div>
                        <div class="card-body text-left pt-0">
                            <div class="row"> 
                                @foreach(config('global.fuel') as $keyF => $fuel)
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="fuel" value="{{$keyF}}" id="flexRadio{{$fuel}}">
                                        <label class="custom-control-label" for="flexRadio{{$fuel}}">{{$fuel}}</label>
                                    </div>
                                </div>
                                @endforeach
                                @error('fuel') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxs-12 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-4">
                    <div class="card mb-3">
                        <div class="card-header text-left pt-4 pb-3">
                            <h5 class="font-weight-bold mt-2">Scratches</h5>
                        </div>
                        <div class="card-body text-left pt-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="textareaScratchesFound">Scratches Found</label>
                                        <textarea class="form-control" id="scratchesFound" wire:model="scratchesFound" rows="3"></textarea>
                                        @error('scratchesFound') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="textareaScratchesNotFound">Scratches Not Found</label>
                                        <textarea class="form-control" id="scratchesNotFound" wire:model="scratchesNotFound" rows="3"></textarea>
                                        @error('scratchesNotFound') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxs-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 mb-4">
                    <div class="card mb-3">
                        <div class="card-header text-left pt-4 pb-3">
                            <h5 class="font-weight-bold mt-2">Interior Cabin Inspection</h5>
                        </div>
                        <div class="card-body text-left pt-0">
                            <div class="row"> 
                                <label>Turn key on - check for fault codes</label>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="turn_key_on_check_for_fault_codes" value="1" id="turn_key_on_check_for_fault_codes1">
                                        <label class="custom-control-label" for="turn_key_on_check_for_fault_codes1">Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="turn_key_on_check_for_fault_codes" value="2" id="turn_key_on_check_for_fault_codes2">
                                        <label class="custom-control-label" for="turn_key_on_check_for_fault_codes2">Not Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="turn_key_on_check_for_fault_codes" value="3" id="turn_key_on_check_for_fault_codes3">
                                        <label class="custom-control-label" for="turn_key_on_check_for_fault_codes3">Not Applicable</label>
                                    </div>
                                </div>
                                @error('turn_key_on_check_for_fault_codes') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="row"> 
                                <label>Start Engine - observe operation</label>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="start_engine_observe_operation" value="1" id="start_engine_observe_operation1">
                                        <label class="custom-control-label" for="start_engine_observe_operation1">Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="start_engine_observe_operation" value="2" id="start_engine_observe_operation2">
                                        <label class="custom-control-label" for="start_engine_observe_operation2">Not Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="start_engine_observe_operation" value="3" id="start_engine_observe_operation3">
                                        <label class="custom-control-label" for="start_engine_observe_operation3">Not Applicable</label>
                                    </div>
                                </div>
                                @error('start_engine_observe_operation') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="row"> 
                                <label>Reset the Service Reminder Alert</label>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="reset_the_service_reminder_alert" value="1" id="reset_the_service_reminder_alert1">
                                        <label class="custom-control-label" for="reset_the_service_reminder_alert1">Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="reset_the_service_reminder_alert" value="2" id="reset_the_service_reminder_alert2">
                                        <label class="custom-control-label" for="reset_the_service_reminder_alert2">Not Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="reset_the_service_reminder_alert" value="3" id="reset_the_service_reminder_alert3">
                                        <label class="custom-control-label" for="reset_the_service_reminder_alert3">Not Applicable</label>
                                    </div>
                                </div>
                                @error('reset_the_service_reminder_alert') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="row"> 
                                <label>Stick & Update Service Reminder Sticker on B-Piller</label>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="stick_update_service_reminder_sticker_on_b_piller" value="1" id="stick_update_service_reminder_sticker_on_b_piller1">
                                        <label class="custom-control-label" for="stick_update_service_reminder_sticker_on_b_piller1">Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="stick_update_service_reminder_sticker_on_b_piller" value="2" id="stick_update_service_reminder_sticker_on_b_piller2">
                                        <label class="custom-control-label" for="stick_update_service_reminder_sticker_on_b_piller2">Not Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="stick_update_service_reminder_sticker_on_b_piller" value="3" id="stick_update_service_reminder_sticker_on_b_piller3">
                                        <label class="custom-control-label" for="stick_update_service_reminder_sticker_on_b_piller3">Not Applicable</label>
                                    </div>
                                </div>
                                @error('stick_update_service_reminder_sticker_on_b_piller') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="row"> 
                                <label>Comments</label>
                                <div class="col-md-12">
                                    <div class="form-check mb-3 ps-0">
                                        <textarea class="form-control" id="interior_cabin_inspection_comments" wire:model="interior_cabin_inspection_comments" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxs-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 mb-4">
                    <div class="card mb-3">
                        <div class="card-header text-left pt-4 pb-3">
                            <h5 class="font-weight-bold mt-2">Under Hood Inspection</h5>
                        </div>
                        <div class="card-body text-left pt-0">
                            <div class="row"> 
                                <label>Check Power Steering Fluid Level</label>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_power_steering_fluid_level" value="1" id="check_power_steering_fluid_level1">
                                        <label class="custom-control-label" for="check_power_steering_fluid_level1">Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_power_steering_fluid_level" value="2" id="check_power_steering_fluid_level2">
                                        <label class="custom-control-label" for="check_power_steering_fluid_level2">Not Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_power_steering_fluid_level" value="3" id="check_power_steering_fluid_level3">
                                        <label class="custom-control-label" for="check_power_steering_fluid_level3">Not Applicable</label>
                                    </div>
                                </div>
                                @error('check_power_steering_fluid_level') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="row"> 
                                <label>Check Power Steering tank Cap properly fixed</label>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_power_steering_tank_cap_properly_fixed" value="1" id="check_power_steering_tank_cap_properly_fixed1">
                                        <label class="custom-control-label" for="check_power_steering_tank_cap_properly_fixed1">Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_power_steering_tank_cap_properly_fixed" value="2" id="check_power_steering_tank_cap_properly_fixed2">
                                        <label class="custom-control-label" for="check_power_steering_tank_cap_properly_fixed2">Not Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_power_steering_tank_cap_properly_fixed" value="3" id="check_power_steering_tank_cap_properly_fixed3">
                                        <label class="custom-control-label" for="check_power_steering_tank_cap_properly_fixed3">Not Applicable</label>
                                    </div>
                                </div>
                                @error('check_power_steering_tank_cap_properly_fixed') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="row"> 
                                <label>Check Brake fluid level</label>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_brake_fluid_level" value="1" id="check_brake_fluid_level1">
                                        <label class="custom-control-label" for="check_brake_fluid_level1">Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_brake_fluid_level" value="2" id="check_brake_fluid_level2">
                                        <label class="custom-control-label" for="check_brake_fluid_level2">Not Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_brake_fluid_level" value="3" id="check_brake_fluid_level3">
                                        <label class="custom-control-label" for="check_brake_fluid_level3">Not Applicable</label>
                                    </div>
                                </div>
                                @error('check_brake_fluid_level') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="row"> 
                                <label>Check Brake fluid tank Cap properly fixed</label>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="brake_fluid_tank_cap_properly_fixed" value="1" id="brake_fluid_tank_cap_properly_fixed1">
                                        <label class="custom-control-label" for="brake_fluid_tank_cap_properly_fixed1">Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="brake_fluid_tank_cap_properly_fixed" value="2" id="brake_fluid_tank_cap_properly_fixed2">
                                        <label class="custom-control-label" for="brake_fluid_tank_cap_properly_fixed2">Not Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="brake_fluid_tank_cap_properly_fixed" value="3" id="brake_fluid_tank_cap_properly_fixed3">
                                        <label class="custom-control-label" for="brake_fluid_tank_cap_properly_fixed3">Not Applicable</label>
                                    </div>
                                </div>
                                @error('brake_fluid_tank_cap_properly_fixed') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="row"> 
                                <label>Check Engine Oil Level</label>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_engine_oil_level" value="1" id="check_engine_oil_level1">
                                        <label class="custom-control-label" for="check_engine_oil_level1">Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_engine_oil_level" value="2" id="check_engine_oil_level2">
                                        <label class="custom-control-label" for="check_engine_oil_level2">Not Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_engine_oil_level" value="3" id="check_engine_oil_level3">
                                        <label class="custom-control-label" for="check_engine_oil_level3">Not Applicable</label>
                                    </div>
                                </div>
                                @error('check_engine_oil_level') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="row"> 
                                <label>Check Radiator Coolant Level</label>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_radiator_coolant_level" value="1" id="check_radiator_coolant_level1">
                                        <label class="custom-control-label" for="check_radiator_coolant_level1">Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_radiator_coolant_level" value="2" id="check_radiator_coolant_level2">
                                        <label class="custom-control-label" for="check_radiator_coolant_level2">Not Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_radiator_coolant_level" value="3" id="check_radiator_coolant_level3">
                                        <label class="custom-control-label" for="check_radiator_coolant_level3">Not Applicable</label>
                                    </div>
                                </div>
                                @error('check_radiator_coolant_level') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="row"> 
                                <label>Check Radiator Cap properly fixed</label>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_radiator_cap_properly_fixed" value="1" id="check_radiator_cap_properly_fixed1">
                                        <label class="custom-control-label" for="check_radiator_cap_properly_fixed1">Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_radiator_cap_properly_fixed" value="2" id="check_radiator_cap_properly_fixed2">
                                        <label class="custom-control-label" for="check_radiator_cap_properly_fixed2">Not Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_radiator_cap_properly_fixed" value="3" id="check_radiator_cap_properly_fixed3">
                                        <label class="custom-control-label" for="check_radiator_cap_properly_fixed3">Not Applicable</label>
                                    </div>
                                </div>
                                @error('check_radiator_cap_properly_fixed') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="row"> 
                                <label>Top off windshield washer fluid</label>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="top_off_windshield_washer_fluid" value="1" id="top_off_windshield_washer_fluid1">
                                        <label class="custom-control-label" for="top_off_windshield_washer_fluid1">Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="top_off_windshield_washer_fluid" value="2" id="top_off_windshield_washer_fluid2">
                                        <label class="custom-control-label" for="top_off_windshield_washer_fluid2">Not Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="top_off_windshield_washer_fluid" value="3" id="top_off_windshield_washer_fluid3">
                                        <label class="custom-control-label" for="top_off_windshield_washer_fluid3">Not Applicable</label>
                                    </div>
                                </div>
                                @error('top_off_windshield_washer_fluid') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="row"> 
                                <label>Check windshield Cap properly fixed</label>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_windshield_cap_properly_fixed" value="1" id="check_windshield_cap_properly_fixed1">
                                        <label class="custom-control-label" for="check_windshield_cap_properly_fixed1">Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_windshield_cap_properly_fixed" value="2" id="check_windshield_cap_properly_fixed2">
                                        <label class="custom-control-label" for="check_windshield_cap_properly_fixed2">Not Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_windshield_cap_properly_fixed" value="3" id="check_windshield_cap_properly_fixed3">
                                        <label class="custom-control-label" for="check_windshield_cap_properly_fixed3">Not Applicable</label>
                                    </div>
                                </div>
                                @error('check_windshield_cap_properly_fixed') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="row"> 
                                <label>Comments</label>
                                <div class="col-md-12">
                                    <div class="form-check mb-3 ps-0">
                                        <textarea class="form-control" id="underHoodInspectionComments" wire:model="underHoodInspectionComments" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxs-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 mb-4">
                    <div class="card mb-3">
                        <div class="card-header text-left pt-4 pb-3">
                            <h5 class="font-weight-bold mt-2">Under Body Inspection</h5>
                        </div>
                        <div class="card-body text-left pt-0">
                            <div class="row"> 
                                <label>Check for Oil leaks - Engine, Steering</label>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_for_oil_leaks_engine_steering" value="1" id="check_for_oil_leaks_engine_steering1">
                                        <label class="custom-control-label" for="check_for_oil_leaks_engine_steering1">Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_for_oil_leaks_engine_steering" value="2" id="check_for_oil_leaks_engine_steering2">
                                        <label class="custom-control-label" for="check_for_oil_leaks_engine_steering2">Not Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_for_oil_leaks_engine_steering" value="3" id="check_for_oil_leaks_engine_steering3">
                                        <label class="custom-control-label" for="check_for_oil_leaks_engine_steering3">Not Applicable</label>
                                    </div>
                                </div>
                                @error('check_for_oil_leaks_engine_steering') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="row"> 
                                <label>Check for Oil Leak - Oil Filtering</label>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_for_oil_leak_oil_filtering" value="1" id="check_for_oil_leak_oil_filtering1">
                                        <label class="custom-control-label" for="check_for_oil_leak_oil_filtering1">Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_for_oil_leak_oil_filtering" value="2" id="check_for_oil_leak_oil_filtering2">
                                        <label class="custom-control-label" for="check_for_oil_leak_oil_filtering2">Not Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_for_oil_leak_oil_filtering" value="3" id="check_for_oil_leak_oil_filtering3">
                                        <label class="custom-control-label" for="check_for_oil_leak_oil_filtering3">Not Applicable</label>
                                    </div>
                                </div>
                                @error('check_for_oil_leak_oil_filtering') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="row"> 
                                <label>Check Drain Plug fixed properly</label>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_drain_lug_fixed_properly" value="1" id="check_drain_lug_fixed_properly1">
                                        <label class="custom-control-label" for="check_drain_lug_fixed_properly1">Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_drain_lug_fixed_properly" value="2" id="check_drain_lug_fixed_properly2">
                                        <label class="custom-control-label" for="check_drain_lug_fixed_properly2">Not Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_drain_lug_fixed_properly" value="3" id="check_drain_lug_fixed_properly3">
                                        <label class="custom-control-label" for="check_drain_lug_fixed_properly3">Not Applicable</label>
                                    </div>
                                </div>
                                @error('check_drain_lug_fixed_properly') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="row"> 
                                <label>Check Oil Filter fixed properly</label>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_oil_filter_fixed_properly" value="1" id="check_oil_filter_fixed_properly1">
                                        <label class="custom-control-label" for="check_oil_filter_fixed_properly1">Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_oil_filter_fixed_properly" value="2" id="check_oil_filter_fixed_properly2">
                                        <label class="custom-control-label" for="check_oil_filter_fixed_properly2">Not Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model="check_oil_filter_fixed_properly" value="3" id="check_oil_filter_fixed_properly3">
                                        <label class="custom-control-label" for="check_oil_filter_fixed_properly3">Not Applicable</label>
                                    </div>
                                </div>
                                @error('check_oil_filter_fixed_properly') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="row"> 
                                <label>Comments</label>
                                <div class="col-md-12">
                                    <div class="form-check mb-3 ps-0">
                                        <textarea class="form-control" id="ubi_comments" wire:model="ubi_comments" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                
                
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header text-center pt-4 pb-3">
                            <h5 class="font-weight-bold mt-2">Vehicle Images</h5>
                        </div>
                        <div wire:loading wire:target="vImageR1">
                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                <div class="la-ball-beat">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                        </div>
                        <div wire:loading wire:target="vImageR2">
                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                <div class="la-ball-beat">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                        </div>
                        <div wire:loading wire:target="vImageF">
                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                <div class="la-ball-beat">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                        </div>
                        <div wire:loading wire:target="vImageB">
                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                <div class="la-ball-beat">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                        </div>
                        <div wire:loading wire:target="vImageL1">
                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                <div class="la-ball-beat">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                        </div>
                        <div wire:loading wire:target="vImageL2">
                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                <div class="la-ball-beat">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-left pt-0">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-icon btn-2 btn-primary float-end" id="upfile1" type="button">
                                                <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                            </button>
                                        </div>
                                    </div>
                                    <input type="file" id="file1" wire:model="vImageR1" accept="image/*" capture style="display:none"/>
                                    <img class="w-75 float-end" id="img1" src="@if($vImageR1) {{$vImageR1->temporaryUrl()}} @else {{asset('img/checklist/car1.png')}} @endif" style="cursor:pointer" wire:click="markScrach('img1')" />
                                    @error('vImageR1') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-icon btn-2 btn-primary float-end" id="upfile2" type="button">
                                                <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                            </button>
                                        </div>
                                    </div>
                                    <input type="file" id="file2" wire:model="vImageR2" accept="image/*" capture style="display:none"/>
                                    <img class="w-75 float-start" id="img2" src="@if ($vImageR2) {{ $vImageR2->temporaryUrl() }} @else {{asset('img/checklist/car2.png')}} @endif" style="cursor:pointer" wire:click="markScrach('img2')" />
                                    @error('vImageR2') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                                <hr>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-icon btn-2 btn-primary float-end" id="upfile3" type="button">
                                                <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                            </button>
                                        </div>
                                    </div>
                                    <input type="file" id="file3" wire:model="vImageF" accept="image/*" capture style="display:none"/>
                                    <img class="w-75 float-end" id="img3" src="@if ($vImageF) {{ $vImageF->temporaryUrl() }} @else {{asset('img/checklist/car3.jpg')}} @endif" style="cursor:pointer" wire:click="markScrach('img3')" />
                                    @error('vImageF') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-icon btn-2 btn-primary float-end" id="upfile4" type="button">
                                                <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                            </button>
                                        </div>
                                    </div>
                                    <input type="file" id="file4" wire:model="vImageB" accept="image/*" capture style="display:none"/>
                                    <img class="w-75 float-start" id="img4" src="@if ($vImageB) {{ $vImageB->temporaryUrl() }} @else {{asset('img/checklist/car4.jpg')}} @endif" style="cursor:pointer" wire:click="markScrach('img4')" />
                                    @error('vImageB') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                                <hr>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-icon btn-2 btn-primary float-end" id="upfile5" type="button">
                                                <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                            </button>
                                        </div>
                                    </div>
                                    <input type="file" id="file5" wire:model="vImageL1" accept="image/*" capture style="display:none"/>
                                    <img class="w-75 float-end" id="img5" src="@if ($vImageL1) {{ $vImageL1->temporaryUrl() }} @else {{asset('img/checklist/car5.png')}} @endif" style="cursor:pointer" wire:click="markScrach('img5')" />
                                    @error('vImageL1') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-icon btn-2 btn-primary float-end" id="upfile6" type="button">
                                                <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                            </button>
                                        </div>
                                    </div>
                                    <input type="file" id="file6" wire:model="vImageL2" accept="image/*" capture style="display:none"/>
                                    <img class="w-75 float-start" id="img6" src="@if ($vImageL2) {{ $vImageL2->temporaryUrl() }} @else {{asset('img/checklist/car6.png')}} @endif" style="cursor:pointer" wire:click="markScrach('img6')" />
                                    @error('vImageL2') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-body text-left pt-4">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <img class="w-100" src="{{asset('img/checklist/gs-checkl-tc.png')}}" id="upfile6" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header mx-4 p-3 pb-0 mb-0 text-center">
                            <h5 class="font-weight-bold mt-2">Service Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header mx-4 p-3 text-center">
                                            <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                                <i class="fa fa-money opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <div class="card-body pt-0 p-3 text-center">
                                            <h6 class="text-center mb-0">Total</h6>
                                            <!-- <span class="text-xs">Belong Interactive</span> -->
                                            <hr class="horizontal dark my-3">
                                            <h5 class="mb-0">AED {{ $total }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header mx-4 p-3 text-center">
                                            <div class="icon icon-shape icon-lg bg-gradient-info shadow text-center border-radius-lg">
                                                <i class="fa fa-money opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <div class="card-body pt-0 p-3 text-center">
                                            <h6 class="text-center mb-0 text-info">Vat</h6>
                                            <!-- <span class="text-xs">Belong Interactive</span> -->
                                            <hr class="horizontal dark my-3">
                                            <h5 class="mb-0 text-info">AED {{ $tax }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header mx-4 p-3 text-center">
                                            <div class="icon icon-shape icon-lg bg-gradient-danger shadow text-center border-radius-lg">
                                                <i class="fa fa-money opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <div class="card-body pt-0 p-3 text-center">
                                            <h6 class="text-center mb-0 text-danger">Grand Total</h6>
                                            <!-- <span class="text-xs">Belong Interactive</span> -->
                                            <hr class="horizontal dark my-3">
                                            <h4 class="mb-0 text-danger">AED {{ $grand_total }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                    
            </div>
            <div class="row mt-3">
                <div class="col-xxs-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-4">
                    <div class="card">
                        <div class="card-header text-left pt-4 pb-3">
                            <h5 class="font-weight-bold mt-2">Signature</h5>
                        </div>
                        <div class="card-body text-left pt-0">
                            <button type="button" class="btn btn-primary btn-lg" wire:click="clickShowSignature()">Customer Signature</button>
                            @if($customerSignature)
                            <div class="row">
                                <div class="col-md-6">
                                    <img class="w-100" src="{{$customerSignature}}" />
                                </div>
                            </div>
                            
                            @endif
                        </div>
                        
                    </div>
                </div>
            </div>
            @if($customerSignature)
                <div class="row mt-3">
                    <div class="col-xxs-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-4">
                        <div class="card">
                            <div class="card-footer text-left pt-4">
                                <div class="m-signature-pad--footer">
                                    <button type="button" id='btnSubmit' class="btn bg-gradient-primary btn-lg mui-btn float-end" wire:click="createJob();">Create Job</button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            @endif
        @endif

        

           

        @if($showCheckout)
            <div class="row mt-3">
                <div class="col-md-12 mb-4" >
                    <div class="card p-2 mb-4">
                        <div class="card-header text-center pt-4 pb-3">
                            
                            <h1 class="font-weight-bold mt-2">
                                Payment #{{$job_number}}
                            </h1>
                            <hr>
                            
                        </div>
                        <div class="card-body text-lg-left text-center pt-0">
                            <p><span class="badge rounded-pill bg-light text-dark text-md">Total: <small>AED</small> {{ $total }}</span></p>
                            <p><span class="badge rounded-pill bg-light text-dark text-md">VAT: <small>AED</small> {{ $tax }}</span></p>
                            <p><span class="badge rounded-pill bg-dark text-light text-lg text-bold">Grand total: <small>AED</small> {{ $grand_total }}</span></p>
                            
                            
                        </div>
                        <div class="card-footer text-lg-left text-center pt-0">
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
                                <div class="form-check">
                                    <a wire:click="payLater('paylater','{{$job_number}}')" class="btn btn-icon bg-gradient-secondary d-lg-block mt-3 mb-0">Pay Later<i class="fa-regular fa-money-bill-1 ms-1"></i></a>
                                </div>

                                <div wire:loading wire:target="payLater">
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
        @endif

        @if($successPage)
        <div class="row mt-3">
            <div class="col-md-12 mb-4" >
                <div class="card p-2 mb-4 bg-cover text-center" style="background-image: url('https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/curved-images/curved1.jpg')">
                    <div class="card-body z-index-2 py-9">
                        <h2 class="text-white">Successful..!</h2>
                        <p class="text-white">The service in under processing</p>
                        <button type="button" class=" text-white btn bg-gradient-default selectVehicle py-2 " wire:click="dashCustomerJobUpdate('{{$job_number}}')"   >Job Number: {{$job_number}}</button>
                    </div>
                    <div class="mask bg-gradient-primary border-radius-lg"></div>
                </div>
            </div>
        </div>
        @endif

        @if($showDashboard)
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
        @endif
        <!-- components.modals.servicemodel -->
        <!--include('components.plugins.fixed-plugin')-->
        @include('components.modals.customerSignatureModel')
        @if($markCarScratch)
        @include('components.modals.serviceCarImageEdit')
        @endif
        <div class="fixed-plugin">
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
                    <!-- End Toggle Button -->
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
                <!-- Sidebar Backgrounds -->
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
                <!-- Navbar Fixed -->
                <div class="mt-3">
                    <h6 class="mb-0">Navbar Fixed</h6>
                </div>
                <div class="form-check form-switch ps-0">
                    <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed"
                        onclick="navbarFixed(this)">
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
</script>


@endpush