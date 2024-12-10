@if($showForms)
    @if($showSearchByMobileNumber)
        <div class="row">
            <div class="col-md-12">
                <div class="card px-3 my-2" >
                    <div class="card-body p-0">
                        <div class="row">
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mobilenumberInput">Mobile Number </label>
                                    <div class="input-group mb-0">
                                        <span class="input-group-text px-0">+971</span>
                                        <input class="form-control" placeholder="Mobile Number" type="number" wire:model="mobile" @if(!$editCustomerAndVehicle) wire:keyup="searchResult" @endif name="mobile" id="mobilenumberInput">
                                    </div>
                                    @error('mobile') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            @if ($showCustomerForm)
                                <div class="col-md-4">
                                    <div class="form-group openDiv">
                                        <label for="nameInput">Name</label>
                                        <input type="text" class="form-control" wire:model.defer="name" name="name" placeholder="Name" id="nameInput">
                                        @error('name') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group openName">
                                        <label for="emailInput">Email</label>
                                        <input type="email" wire:model.defer="email" name="email" class="form-control" id="emailInput" placeholder="Email">
                                        @error('email') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                
                                
                                @if($updateCustomerFormDiv)
                                <div class="col-md-4">
                                    <button type="button" wire:click="updateCustomer()" class="btn btn-primary btn-sm">Update Customer</button>
                                </div>
                                @endif
                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($showDiscountGroup)
        <div class="row">
            <div class="col-md-12">
                <div class="card px-3 my-2" >
                    <div class="card-body p-0">
                        <div class="row">
                            
                            @if($showDiscountGroupForm)
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="customerTypeSelect">Customer Type</label>
                                        <select id="customerTypeSelect" wire:model.defer="customer_type" class="form-control selectSearch">
                                            <option value="">-Select-</option>
                                            @foreach($customerTypeList as $customerType)
                                            <option value="{{$customerType->id}}">{{$customerType->customer_type}}</option>
                                            @endforeach
                                        </select>
                                        @error('customer_type') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect2">Customer ID image</label>
                                        <input type="file" class="form-control" wire:model="customer_id_image">
                                        @if($customer_id_image)
                                            Photo Preview:
                                            <img class="img-fluid border-radius-lg" src="{{ $customer_id_image->temporaryUrl() }}">
                                        @endif
                                    </div>
                                </div>
                                
                                @if($updateDiscountGroupFormDiv)
                                <div class="col-md-4">
                                    <button type="button" wire:click="updateCustomer()" class="btn btn-primary btn-sm">Update Customer</button>
                                </div>
                                @endif
                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($showSearchByPlateNumber)
        <div class="row">
            <div class="col-md-12">
                <div class="card p-3 m-0" >
                    <div class="card-body p-0">
                        
                            @if($numberPlateAddForm)
                            <div class="row">
                                <div class="col-md-12">
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="plateImage">Plate Imgae</label>
                                                <input type="file" class="form-control" wire:model="plate_number_image" id="plateImage">
                                                @if ($plate_number_image)
                                                    <button type="button" class="btn bg-gradient-secondary btn-sm" wire:click="getPlateNumber('{{$plate_number_image->temporaryUrl()}}')">Get Plate Number</button>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="plateEmirates">Plate Emirates</label>
                                                <select class="form-control  " wire:model="plate_state" name="plate_state" id="plateEmirates" style="padding:0.5rem 0.3rem !important;" @if(!$editCustomerAndVehicle) wire:change="searchResult" @endif>
                                                    <option value="">-Emirates-</option>
                                                    @foreach($stateList as $state)
                                                    <option value="{{$state->state_name}}">{{$state->state_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="plateCode">Plate Code</label>
                                                <input style="padding:0.5rem 0.3rem !important;" type="text" id="plateCode" class="form-control @error('plate_code') btn-outline-danger @enderror" wire:model="plate_code" @if(!$editCustomerAndVehicle) wire:keyup="searchResult" @endif name="plate_code" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" minlength="1" maxlength="2" placeholder="Code">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="plateNumber">Plate Number</label>
                                                <input style="padding:0.5rem 0.3rem !important;" type="number" id="plateNumber" class="form-control @error('plate_number') btn-outline-danger @enderror" wire:model="plate_number" @if(!$editCustomerAndVehicle) wire:keyup="searchResult" @endif name="plate_number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" minlength="1" maxlength="6" placeholder="Number">
                                            </div>
                                        </div>
                                    </div>
                                    @error('plate_state') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            @endif
                            @if($otherVehicleDetailsForm)
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect2">Vehicle Picture</label>
                                        <input type="file" class="form-control" wire:model="vehicle_image">
                                        @error('vehicle_image') <span class="text-danger">{{ $message }}</span> @enderror
                                        
                                        @if ($vehicle_image)
                                            
                                            <img class="img-fluid border-radius-lg w-30" src="{{ $vehicle_image->temporaryUrl() }}">
                                        @endif
                                    </div>
                                    
                                </div>
                                <div class="col-md-3">
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="vehicleMakeInput">Vehicle Make</label>
                                        <select class="form-control selectSearch" id="vehicleMakeInput" wire:model="make" >
                                            <option value="">-Select-</option>
                                            @foreach($listVehiclesMake as $vehicleName)
                                            <option value="{{$vehicleName->vehicle_make}}">{{$vehicleName->vehicle_make}}</option>
                                            @endforeach
                                        </select>
                                        @error('make') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="vehicleModelInput">Vehicle Model</label>

                                        <select class="form-control" id="vehicleModelInput" wire:model="model">
                                            <option value="">-Select-</option>
                                            @foreach($vehiclesModel as $model)
                                            <option value="{{$model->model}}">{{$model->model}}</option>
                                            @endforeach
                                        </select>
                                         @error('model') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect2">Chaisis Imgae</label>
                                        <input type="file" class="form-control" wire:model="chaisis_image">
                                        @if ($chaisis_image)
                                            <button type="button" class="btn bg-gradient-secondary btn-sm" wire:click="getChaisisNumber('{{$chaisis_image->temporaryUrl()}}')">Get Chaisis Number</button>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="chaisisNumberInput">Chaisis Number</label>
                                        <input type="text" class="form-control" id="chaisisNumberInput" wire:model.defer="chassis_number" name="chassis_number" placeholder="Chassis Number">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="vehicleKmInput">K.M Reading</label>
                                        <input type="number" class="form-control" id="vehicleKmInput" wire:model.defer="vehicle_km" name="vehicle_km" placeholder="Chaisis Number">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    @if($updateVehicleFormBtn)
                                    <button type="button" wire:click="updateVehicleCustomer()" class="btn btn-primary btn-sm">Update Vehicle</button>
                                    @else
                                    <button type="button" wire:click="saveVehicleCustomer()" class="btn btn-primary btn-sm">Save Vehicle</button>
                                    @endif
                                </div>


                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endif
                <div class="container">
                    <div class="">
                    @if($showCustomerSearch)
                        @if($showFormBoxClose)
                        <div class="card-header m-0 p-0">
                            <div class="float-end cursor-pointer" wire:click="">
                                <a wire:click="closeSearchNewCustomer()">
                                    <i class="text-danger fa-solid fa-circle-xmark fa-xxl" style="font-size:2rem;"></i>
                                </a>
                            </div>
                        </div>
                        @endif
                        <div class="row mt-2">
                            
                            
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
                                            <div class="col-xl-3 col-md-6 mb-xl-0 my-4">
                                                <a href="javascript:;" wire:click="selectVehicle({{$customer}})" class="">
                                                    <div class="card card-background move-on-hover">
                                                        <div class="full-background" style="background-image: url('{{url("storage/".$customer->vehicle_image)}}')"></div>
                                                        <div class="card-body pt-5">
                                                            <h4 class="text-white mb-0 pb-0">
                                                                @if($customer->name)
                                                                    {{$customer->name}}
                                                                @else
                                                                Guest
                                                                @endif
                                                            </h4>
                                                            <p class="mt-0 pt-0"><small>{{$customer->email}}, {{$customer->mobile}}</small></p>
                                                            <p class="mb-0">{{$customer->vehicleName}}, {{$customer->model}}</p>
                                                            <p>{{$customer->plate_number_final}}</p>
                                                        </div>
                                                    </div>
                                                </a>
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
                            
                        </div>
                    @endif

                    @if ($showServiceGroup)
                        <div class="row">
                            @if ($selectedCustomerVehicle)
                                <!-- <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <p class="h5 text-left">Services Details</p><hr class="m-0" >
                                </div> -->

                                @if(!$servicesGroupList->isEmpty())
                                    @foreach($servicesGroupList as $servicesGroup)
                                        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3 my-2">
                                            <div class="card h-100">
                                                
                                                <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('{{asset("img/".str_replace("/","",$servicesGroup->department_code).".jpg")}}');">
                                                    
                                                    @if($service_group_id == $servicesGroup->id)
                                                    <span class="mask bg-gradient-dark opacity-2"></span>
                                                    @else
                                                    <span class="mask bg-gradient-dark opacity-9"></span>
                                                    @endif
                                                    
                                                    <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
                                                        <!--  -->
                                                        <h5 class="text-white font-weight-bolder mb-4 pt-2">{{$servicesGroup->department_name}}</h5>
                                                        <!-- <p class="text-white">Wealth creation is an evolutionarily recent positive-sum game. It is all about who take the opportunity first.</p> -->
                                                        <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:;">
                                                            
                                                            <button wire:click="serviceGroupForm({{$servicesGroup}})" class="btn @if($service_group_id == $servicesGroup->department_code) bg-gradient-primary @else btn-outline-light @endif" type="button" >
                                                                Select
                                                            </button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                @endif
                            @endif
                        </div>
                        @if($showSectionsList)
                            <div class="row mt-2 mb-2">
                                @foreach($sectionsLists as $sectionsList)
                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3 my-2 cursor-pointer" wire:click="getSectionServices({{$sectionsList}})">
                                    <!--  aria-hidden="true" data-bs-toggle="modal" data-bs-target="#exampleModal"-->
                                    <div class="card bg-gradient-dark">
                                        <div class="card-body ">
                                            <div class="row">
                                                <div class="col-8 p-0">
                                                    <div class="numbers">
                                                    <p class="text-white text-sm mb-0 opacity-7">{{$service_group_name}}</p>
                                                    <h5 class="text-white font-weight-bolder mb-0">
                                                    {{$sectionsList->PropertyName}}
                                                    </h5>
                                                    </div>
                                                </div>
                                                <div class="col-4 text-end">
                                                    <div class="icon icon-shape bg-white shadow text-center border-radius-md">
                                                        <i class="cursor-pointer fa-solid fa-angles-down text-dark text-lg opacity-10"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="servicePriceModal" tabindex="-1" role="dialog" aria-labelledby="servicePriceModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="servicePriceModalLabel">{{$service_group_name}} - {{$selectedSectionName}}</h5>
                                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="card p-0">
                                                    <div class="card-body py-2 px-0">
                                                        <div class="timeline timeline-one-side" data-timeline-axis-style="dotted">
                                                            @foreach($sectionServiceLists as $sectionServiceList)
                                                            <div class="timeline-block mb-3">
                                                                <span class="timeline-step">
                                                                    <i class="fa-solid fa-taxi text-warning text-gradient"></i>
                                                                </span>
                                                                <div class="timeline-content">
                                                                    <h6 class="text-dark text-sm font-weight-bold mb-0">{{$sectionServiceList->ItemCode}} - {{$sectionServiceList->ItemName}}</h6>
                                                                    <h6 class="text-gradient text-primary text-sm font-weight-bold mb-0">AED {{$sectionServiceList->UnitPrice}}</h6>
                                                                    <textarea style="padding-left: 5px !important; width:90%" class="form-control" placeholder="Notes..!"></textarea>
                                                                    <span class="cursor-pointer badge badge-sm bg-gradient-warning" wire:click="addtoCart({{$sectionServiceList->ItemId}})">Add</span>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                            <!-- <div class="timeline-block mb-3">
                                                                <span class="timeline-step">
                                                                    <i class="fa-solid fa-taxi text-warning text-gradient"></i>
                                                                </span>
                                                                <div class="timeline-content">
                                                                    <h6 class="text-dark text-sm font-weight-bold mb-0">New card added for order #4395133</h6>
                                                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">20 DEC 2:20 AM</p>
                                                                    <textarea style="padding-left: 5px !important;" class="form-control" placeholder="Notes..!"></textarea>
                                                                    <span class="cursor-pointer badge badge-sm bg-gradient-warning">Add</span>
                                                                </div>
                                                            </div>

                                                            <div class="timeline-block mb-3">
                                                                <span class="timeline-step">
                                                                    <i class="fa-solid fa-taxi text-warning text-gradient"></i>
                                                                </span>
                                                                <div class="timeline-content">
                                                                    <h6 class="text-dark text-sm font-weight-bold mb-0">New card added for order #4395133</h6>
                                                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">20 DEC 2:20 AM</p>
                                                                    <textarea style="padding-left: 5px !important;" class="form-control" placeholder="Notes..!"></textarea>
                                                                    <span class="cursor-pointer badge badge-sm bg-gradient-warning">Add</span>
                                                                </div>
                                                            </div>

                                                            <div class="timeline-block mb-3">
                                                                <span class="timeline-step">
                                                                    <i class="fa-solid fa-taxi text-warning text-gradient"></i>
                                                                </span>
                                                                <div class="timeline-content">
                                                                    <h6 class="text-dark text-sm font-weight-bold mb-0">New card added for order #4395133</h6>
                                                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">20 DEC 2:20 AM</p>
                                                                    <textarea style="padding-left: 5px !important;" class="form-control" placeholder="Notes..!"></textarea>
                                                                    <span class="cursor-pointer badge badge-sm bg-gradient-warning">Add</span>
                                                                </div>
                                                            </div> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn bg-gradient-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    @endif

                    @if($showServiceType)
                        @foreach($servicesTypesList as $servicesType)
                            <div class="col-md-4 mb-4">
                                <div class="card ">
                                    <div class="card-header text-center pt-4 pb-3">
                                        <span class=" text-dark">{{$servicesType->serviceInfo['service_name']}}</span>
                                        <h2 class="font-weight-bold mt-2">
                                          <small>AED</small>{{round($servicesType->final_price_after_dicount,2)}}
                                        </h2>
                                    </div>
                                  <div class="card-body text-lg-left text-center pt-0">

                                    @if(in_array($servicesType['service_id'], $cartItemsInService))
                                    <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                        <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                    </div>
                                    <a href="javascript:;" wire:click="removeCartN({{$servicesType->service_id}})" class="btn btn-sm bg-gradient-danger border-radius-md mt-4 mb-2">Remove</a>
                                    @else
                                    <a href="javascript:;" wire:click="addtoCart({{$servicesType}})" class="btn btn-sm bg-gradient-dark w-100 border-radius-md mt-4 mb-2">Buy now</a>
                                    @endif
                                    
                                  </div>
                                </div>
                            </div>
                        @endforeach
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
                                            Payment Confirmation
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
                                                <a wire:click="completePaymnet('link')" class="btn btn-icon bg-gradient-info d-lg-block mt-3 mb-0">Pay By Link<i class="fa-solid fa-comments-dollar ms-1" ></i></a>
                                            </div>
                                        
                                            <div class="form-check">
                                                <a wire:click="completePaymnet('card')" class="btn btn-icon bg-gradient-success d-lg-block mt-3 mb-0">Pay By Card<i class="fa-solid fa-credit-card ms-1" ></i></a>
                                            </div>
                                        
                                            <div class="form-check">
                                                <a wire:click="completePaymnet('cash')" class="btn btn-icon bg-gradient-danger d-lg-block mt-3 mb-0">Cash Payment<i class="fa-solid fa-money-bill-1-wave ms-1" ></i></a>
                                            </div>
                                            <div class="form-check">
                                                <a wire:click="payLater('paylater')" class="btn btn-icon bg-gradient-secondary d-lg-block mt-3 mb-0">Pay Later<i class="fa-regular fa-money-bill-1 ms-1"></i></a>
                                            </div>

                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($showPayLaterCheckout)
                        <div class="row mt-3">
                            <div class="col-md-12 mb-4" >
                                <div class="card p-2 mb-4">
                                    <div class="card-header text-center pt-4 pb-3">
                                        
                                        <h1 class="font-weight-bold mt-2">
                                            Payment Confirmation {{$job_number}}
                                        </h1>
                                        <hr>
                                        
                                    </div>
                                    <div class="card-body text-lg-left text-center pt-0">
                                        <p><span class="badge rounded-pill bg-light text-dark text-md">Total: <small>AED</small> {{ $totalPL }}</span></p>
                                        <p><span class="badge rounded-pill bg-light text-dark text-md">VAT: <small>AED</small> {{ $taxPL }}</span></p>
                                        <p><span class="badge rounded-pill bg-dark text-light text-lg text-bold">Grand total: <small>AED</small> {{ $grand_totalPL }}</span></p>
                                        
                                        
                                    </div>
                                    <div class="card-footer text-lg-left text-center pt-0">
                                        <div class="d-flex justify-content-center p-2">
                                            <div class="form-check">
                                                <a wire:click="completePaymnet('link')" class="btn btn-icon bg-gradient-info d-lg-block mt-3 mb-0">Pay By Link<i class="fa-solid fa-comments-dollar ms-1" ></i></a>
                                            </div>
                                        
                                            <div class="form-check">
                                                <a wire:click="completePaymnet('card')" class="btn btn-icon bg-gradient-warning d-lg-block mt-3 mb-0">Pay By Card<i class="fa-solid fa-credit-card ms-1" ></i></a>
                                            </div>
                                        
                                            <div class="form-check">
                                                <a wire:click="completePaymnet('cash')" class="btn btn-icon bg-gradient-danger d-lg-block mt-3 mb-0">Cash Payment<i class="fa-solid fa-money-bill-1-wave ms-1" ></i></a>
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
                                    <div class="card-body z-index-2 py-2">
                                        <h2 class="text-white">Successful..!</h2>
                                        <p class="text-white">The service in under processing</p>
                                        <button type="button" class=" text-white btn bg-gradient-default selectVehicle py-2 " wire:click="dashCustomerJobUpdate('{{$job_number}}')"   >Job Number: {{$job_number}}</button>
                                    </div>
                                    <div class="mask bg-gradient-success border-radius-lg"></div>
                                </div>
                            </div>
                        </div>
                    @endif
                    </div>
                </div>