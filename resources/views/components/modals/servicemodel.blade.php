<style>
    .modal-dialog {
        max-width: 85%;
    }
    .modal{
        z-index: 99999;
    }
</style

<!-- Modal -->
<div wire:ignore.self  class="modal fade bd-example-modal-lg" id="serviceModel" tabindex="-1" role="dialog" aria-labelledby="serviceModelLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$service_group_name}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        
            <div class="modal-body">
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
                <div class="row">
                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12  col-sm-12 col-xs-12 col-xxs-12">
                        <div class="card p-0 m-0" >
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-md-6">
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
                                                        <label for="exampleFormControlSelect2">Customer Type</label>
                                                        <select class="form-control" id="exampleFormControlSelect2" wire:model="customer_type">
                                                            <option value="">-Select-</option>
                                                            @foreach($customerTypes as $customerType)
                                                            <option value="{{$customerType->id}}">{{$customerType->customer_type}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('customer_type') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
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
                                    @if ($showVehicleFormDiv || $newVehicleAdd)
                                        <div class="col-md-6">
                                            <div class="row">
                                                <p class="h5 text-left">Vehicle Details</p><hr class="mt-0">
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
                                                        <select class="form-control" id="vehicleTypeInput" wire:model="vehicle_type">
                                                            <option value="">-Select-</option>
                                                            @foreach($vehicleTypes as $vehicleType)
                                                            <option value="{{$vehicleType->id}}">{{$vehicleType->type_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="vehicleNameInput">Vehicle Name</label>
                                                        <select class="form-control" id="vehicleNameInput" wire:model="vehicle_id">
                                                            <option value="">-Select-</option>
                                                            @foreach($vehicleNames as $vehicleName)
                                                            <option value="{{$vehicleName->id}}">{{$vehicleName->vehicle_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="makeModelInput">Make/Model</label>
                                                        <input type="text" class="form-control" id="makeModelInput" wire:model="make_model" name="make_model" placeholder="Make/Model">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect2">PlateNumber Imgae</label>
                                                        <input type="file" class="form-control" wire:model="plateNumberImage">
                                                        @error('plateNumberImage') <span class="text-danger">{{ $message }}</span> @enderror
                                                        @if ($plateNumberImage)
                                                            <button type="button" class="btn bg-gradient-secondary btn-sm" wire:click="getPlateNumber('{{$plateNumberImage->temporaryUrl()}}')">Get Plate Number</button>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="plateNumberInput">Plate Number</label>
                                                        <input type="text" class="form-control" id="plateNumberInput" wire:model="plate_number" name="plate_number" placeholder="Plate Number">
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
                                            </div>
                                        </div>
                                    @endif
                                    @if ($selectedCustomerVehicle)
                                    <div class="col-md-6">
                                        <div class="card px-2 mb-0" >
                                            <div class="card card-profile card-plain p-0">
                                                <div class="card-header p-0">
                                                    <h5 class="font-weight-bolder mb-0">{{$sCtmrVhlvehicleName}}</h5>
                                                    <p class="text-uppercase text-sm font-weight-bold mb-0">{{$sCtmrVhlmake_model}} ({{$sCtmrVhlplate_number}})</p>
                                                    <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">Chassis: {{$sCtmrVhlchassis_number}}</span><br>
                                                    <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">KM reading : {{$sCtmrVhlvehicle_km}}</span>
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
                            </div>
                        </div>
                        
                        <div class="row">

                            @if($cartItems)
                            <div class="col-md-12 mb-4" id="cartDetails">
                                <div class="card p-2 mb-4">
                                    <div class="card-header px-2 py-0">
                                        @if ($message = Session::get('cartsuccess'))
                                            <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
                                                <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                                                <span class="alert-text"><strong>Success!</strong> {{ $message }}</span>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                        @endif
                                        <h3 class="px-2 text-lg text-bold">{{ Cart::getTotalQuantity()}} Services selected </h3>
                                    </div>
                                    <div class="card-body p-2 mb-4">
                                        <div class="table-responsive">
                                            <table class="table align-items-center mb-0">
                                              <thead>
                                                <tr>
                                                    <th class="text-uppercase text-dark text-sm font-weight-bolder opacity-7">Service</th>
                                                    <th class="text-uppercase text-dark text-sm font-weight-bolder opacity-7 ps-2 ">
                                                        <span class="">Quantity</span>
                                                    </th>
                                                    <th class="text-uppercase text-dark text-sm font-weight-bolder opacity-7 ps-2">price</th>
                                                    <th class="text-uppercase text-dark text-sm font-weight-bolder opacity-7 ps-2">Remove</th>
                                                    <th></th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                                @foreach ($cartItems as $item)
                                                    <tr>
                                                        <td>
                                                            <h6 class="mb-0 text-xs">{{ $item['name'] }}</h6>
                                                        </td>
                                                        <td class="justify-center mt-6 md:justify-end md:flex">
                                                            <div class="h-10 w-28">
                                                                <div class="relative flex flex-row w-full h-8">
                                                                    <div>
                                                                        {{ $item['quantity']}}
                                                                        <!-- <input wire:model="quantity"
                                                                       type="number" min="1" max="5"
                                                                       wire:change="updateCart" class="text-center bg-gray-100" value="{{ $item['quantity']}}"> -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="hidden text-right md:table-cell">
                                                            <p class="text-xs font-weight-bold mb-0">AED {{ $item['price'] }}</p>
                                                        </td>
                                                        <td class="hidden text-right md:table-cell">
                                                            <a href="#" class="px-4 py-2 text-danger bg-red-600" wire:click.prevent="removeCart('{{$item['id']}}')"><i class="fa fa-trash"></i></a>    
                                                        </td>
                                                    </tr>
                                                @endforeach
                                              </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer p-2 mb-4">
                                        <div class="row d-flex flex-row justify-content-between">
                                            <div class="col-md-12">
                                                <p class="text-end  text-bold text-md mb-0">Total: AED {{ \Cart::getTotal() }}</p>
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

                        <div class="row">
                            @if($showVehicleDiv)
                                <div class="col-md-12">
                                    <p class="h5 text-left">Vehicle Details</p><hr class="mt-0">
                                </div>
                                @foreach($customers as $customer)
                                    <div class="col-md-6">
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
                                                        <p class="text-uppercase text-sm font-weight-bold mb-0">{{$customer->make_model}} ({{$customer->plate_number}})</p>
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

                            

                        @if($showServiceType)
                            @if(count($servicesTypesList))
                            <div class="col-md-12">

                                <div class="row p-0">
                                    <p class="h4 text-left">Services Available</p>
                                    <hr>
                                </div>
                                <div class="row p-0">
                                    @foreach($servicesTypesList as $servicesType)
                                    <div class="col-md-4 mb-4">
                                        <div class="card card-pricing">
                                            <div class="card-header bg-gradient-dark text-center pt-2 pb-5 position-relative">
                                                <div class="z-index-1 position-relative">
                                                    <h6 class="text-gradient text-primary text-white">{{$servicesType->service_type_name}}</h6>
                                                    <h5 class="text-white mt-2 mb-0">
                                                    <small>AED</small>{{$servicesType->unit_price}}</h5>
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
                                            <div class="card-body text-center p-0">
                                                
                                            </div>
                                            <div class="card-footer text-center p-2">
                                                
                                                <a wire:click="addtoCart('{{$servicesType}}')" class="btn bg-gradient-primary w-50 mt-4 mb-0">Select </a>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-gradient-primary">Submit</button> -->
            </div>
        
    </div>
  </div>
</div>

