@if($showForms)
    <div class="row">
        <div class="col-md-12">
            <div class="card px-3 my-2" >
                <div class="card-body p-0">
                    <div class="row">
                        @if($showByMobileNumber)
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="mobilenumberInput">Mobile Number </label>
                                    <div class="input-group mb-0">
                                        <span class="input-group-text px-0">+971</span>
                                        <input class="form-control" placeholder="Mobile Number" type="number" wire:model="mobile" @if(!$editCustomerAndVehicle) wire:keyup="searchResult" @endif name="mobile" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" minlength="1" maxlength="9" id="mobilenumberInput">
                                    </div>
                                    @error('mobile') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @endif
                        @if ($showCustomerForm)
                            <div class="col-md-4  col-sm-6">
                                <div class="form-group openDiv">
                                    <label for="nameInput">Name</label>
                                    <input type="text" class="form-control" wire:model.defer="name" name="name" placeholder="Name" id="nameInput">
                                    @error('name') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group openName">
                                    <label for="emailInput">Email</label>
                                    <input type="email" wire:model.defer="email" name="email" class="form-control" id="emailInput" placeholder="Email">
                                    @error('email') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($showPlateNumber || $searchByChaisis)
        <div class="row">
            <div class="col-md-12">
                <div class="card px-3 my-2" >
                    <div class="card-body p-0">
                        @if($showPlateNumber)
                        <div class="row">
                            <div class="col-md-12">
                                
                                <div class="row mb-0">

                                    <div class="col-2">
                                        <label for="plateImageFile" >Plate Image</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button class="btn btn-icon btn-2 btn-primary float-start" id="plateImage" type="button">
                                                    <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                                </button>
                                            </div>
                                        </div>
                                        <input type="file" id="plateImageFile" wire:model="plate_number_image" accept="image/*" capture style="display: none;" />
                                        @if ($plate_number_image)
                                            <img class="img-fluid border-radius-lg w-30" src="{{ $plate_number_image->temporaryUrl() }}">
                                        @endif
                                        
                                    </div>
                                    <div class="col-md-3 col-sm-4">
                                        <div class="form-group">
                                            <label for="plateEmirates">Country</label>
                                            <select class="form-control  " wire:model="plate_country"  id="PlateCountry" name="PlateCountry" aria-invalid="false"><option value="">Select</option>
                                                @foreach(config('global.country') as $country)
                                                <option value="{{$country['CountryCode']}}">{{$country['CountryName']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="form-group">
                                            <label for="plateEmirates">Plate Emirates</label>
                                            <select class="form-control  " wire:model="plate_state" name="plate_state" id="plateEmirates" style="padding:0.5rem 0.3rem !important;" >
                                                <option value="">-Emirates-</option>
                                                @foreach($stateList as $state)
                                                <option value="{{$state->StateName}}">{{$state->StateName}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 d-none">
                                        <div class="form-group">
                                            <label for="plateCategory">Plate Category</label>
                                            <select class="form-control  " wire:model="plate_category" name="plate_category" id="plateCategory" style="padding:0.5rem 0.3rem !important;" >
                                                <option value="">-Category-</option>
                                                @foreach($plateEmiratesCategories as $plateCategory)
                                                <option value="{{$plateCategory->id}}">{{$plateCategory->plateCategoryTitle}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="form-group">
                                            <label for="plateCode">Plate Code</label>
                                            <select class="form-control  " wire:model="plate_code" name="plateCode" id="plateCode" style="padding:0.5rem 0.3rem !important;" >
                                                <option value="">-Code-</option>
                                                @foreach($plateEmiratesCodes as $plateCode)
                                                <option value="{{$plateCode->plateColorTitle}}">{{$plateCode->plateColorTitle}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('plate_code') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div class="col-md-3 col-sm-6">
                                        <div class="form-group">
                                            <label for="plateNumber">Plate Number</label>
                                            <input style="padding:0.5rem 0.3rem !important;" type="number" id="plateNumber" class="form-control @error('plate_number') btn-outline-danger @enderror" wire:model="plate_number" name="plate_number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" minlength="1" maxlength="6" placeholder="Number">
                                        </div>
                                    </div>
                                </div>
                                @error('plate_state') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        @endif
                        @if($showSearchByPlateNumberButton)
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" wire:click="clickSearchByPlateNumber()" class="btn btn-primary btn-sm">Search</button>
                            </div>
                        </div>
                        <div wire:loading wire:target="clickSearchByPlateNumber">
                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                <div class="la-ball-beat">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                        </div>
                        @endif


                        @if($otherVehicleDetailsForm)
                        <div class="row">
                            
                            <div wire:loading wire:target="vehicle_image">
                                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                    <div class="la-ball-beat">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <label for="vehicleImageFile">Vehicle Image</label>
                                <!-- <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-icon btn-2 btn-primary float-start" id="vehicleImage" type="button">
                                            <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                        </button>
                                    </div>
                                </div> -->
                                <input type="file" id="vehicleImageFile" wire:model="vehicle_image" accept="image/*" capture />
                                @if ($vehicle_image)
                                <img class="img-fluid border-radius-lg w-30" src="{{ $vehicle_image->temporaryUrl() }}">
                                @endif
                                @error('vehicle_image') <span class="text-danger">{{ $message }}</span> @enderror
                                
                            </div>
                            
                            <div class="col-md-3 col-sm-6">
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
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="vehicleMakeInput">Vehicle Make</label>
                                    <select class="form-control selectSearch" id="vehicleMakeInput" wire:model="make" >
                                        <option value="">-Select-</option>
                                        @foreach($listVehiclesMake as $vehicleName)
                                        <option value="{{$vehicleName->id}}">{{$vehicleName->vehicle_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('make') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="vehicleModelInput">Vehicle Model</label>

                                    <select class="form-control" id="vehicleModelInput" wire:model="model">
                                        <option value="">-Select-</option>
                                        @foreach($vehiclesModelList as $model)
                                        <option value="{{$model->id}}">{{$model->vehicle_model_name}}</option>
                                        @endforeach
                                    </select>
                                     @error('model') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            @if($searchByChaisisForm)
                                <div class="col-md-3 col-sm-6">
                                    <label for="chaisisImageFile">Chaisis Picture</label>
                                    <!-- <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-icon btn-2 btn-primary float-start" id="chaisisImage" type="button">
                                                <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                            </button>
                                        </div>
                                    </div> -->
                                    <input type="file" id="chaisisImageFile" wire:model="chaisis_image" accept="image/*" capture  />
                                    @if ($chaisis_image)
                                        <button type="button" class="btn bg-gradient-secondary btn-sm" wire:click="getChaisisNumber('{{$chaisis_image->temporaryUrl()}}')">Get Chaisis Number</button>
                                    @endif
                                    
                                </div>
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label for="chaisisNumberInput">Chaisis Number</label>
                                        <input type="text" class="form-control" id="chaisisNumberInput" wire:model.defer="chassis_number" name="chassis_number" placeholder="Chassis Number">
                                    </div>
                                </div>
                            @endif
                            @if($otherVehicleDetailsForm)
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="vehicleKmInput">K.M Reading</label>
                                    <input type="number" class="form-control" id="vehicleKmInput" wire:model.defer="vehicle_km" name="vehicle_km" placeholder="Chaisis Number">
                                </div>
                            </div>
                            @endif
                        </div>
                        @if($showSearchByChaisisButton)
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" wire:click="clickSearchByChaisisNumber()" class="btn btn-primary btn-sm">Search</button>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                @if($updateVehicleFormBtn)
                                <button type="button" wire:click="updateVehicleCustomer()" class="btn btn-primary btn-sm">Update Vehicle</button>
                                @endif
                                @if($addVehicleFormBtn)
                                <button type="button" wire:click="addNewCustomerVehicle()" class="btn btn-primary btn-sm">Save Vehicle</button>
                                @endif
                                @if($cancelEdidAddFormBtn)
                                <button type="button" wire:click="closeUpdateVehicleCustomer()" class="btn btn-default btn-sm">cancel</button>
                                @endif
                                @if($showSaveCustomerButton)
                                <button type="button" wire:click="saveVehicleCustomer()" class="btn btn-primary btn-sm">Save Vehicle</button>
                                @endif
                                <div wire:loading wire:target="updateVehicleCustomer,addNewCustomerVehicle,closeUpdateVehicleCustomer,saveVehicleCustomer">
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
        </div>
    @endif
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
                    <div class="row" id="searchVehicleDiv">
                        @foreach($customers as $customer)
                        <div class="col-xl-3 col-md-4 col-sm-6 mb-xl-0 my-4">
                            <a href="javascript:;" wire:click="selectVehicle({{$customer->TenantId}}, {{$customer->id}})" class="">
                                <div class="card card-background move-on-hover">
                                    <div class="full-background" style="background-image: url('{{url("public/storage/".$customer->vehicle_image)}}')"></div>
                                    <div class="card-body pt-5">
                                        <h4 class="text-white mb-0 pb-0">
                                            @if($customer->TenantName)
                                                {{$customer->TenantName}}
                                            @else
                                            Guest
                                            @endif
                                        </h4>
                                        <p class="mt-0 pt-0"><small>{{$customer->Email}}, {{$customer->Mobile}}</small></p>
                                        <p class="mb-0">{{isset($customer->makeInfo)?$customer->makeInfo['vehicle_name']:''}}, {{isset($customer->modelInfo['vehicle_model_name'])?$customer->modelInfo['vehicle_model_name']:''}}</p>
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

@if($showServiceGroup)

    <div class="row" id="servceGroup">
        @if($selectedCustomerVehicle)
            <!-- <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p class="h5 text-left">Services Details</p><hr class="m-0" >
            </div> -->

            @if(!$servicesGroupList->isEmpty())
                @foreach($servicesGroupList as $servicesGroup)
                    <div class="col-sm-4 col-md-3 col-lg-2 col-xl-2 my-2">
                        <div class="card h-100" >
                            <a wire:click="serviceGroupForm({{$servicesGroup}})" href="javascript:;">
                                <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('{{asset("img/".str_replace(" ","-",$servicesGroup->department_name).".jpg")}}');">
                                    @if($service_group_id == $servicesGroup->id)
                                    <span class="mask bg-gradient-dark opacity-4"></span>
                                    @else
                                    <span class="mask bg-gradient-dark opacity-9"></span>
                                    @endif
                                    <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
                                        <h5 class="@if($service_group_id == $servicesGroup->id) text-primary @else text-white @endif font-weight-bolder mb-4 pt-2">{{$servicesGroup->department_name}}</h5>
                                        <!-- <p class="text-white">Wealth creation is an evolutionarily recent positive-sum game. It is all about who take the opportunity first.</p> -->
                                        <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:;">
                                            <button wire:click="serviceGroupForm({{$servicesGroup}})" class="btn @if($service_group_id == $servicesGroup->id) bg-gradient-primary @else btn-outline-light @endif" type="button" >Select</button>
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
                <div wire:loading wire:target="serviceGroupForm">
                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                        <div class="la-ball-beat">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-3 col-lg-2 col-xl-2 my-2">
                    <div class="card h-100" >
                        <a wire:click="openServiceItems()" href="javascript:;">
                            <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('{{asset("img/PP00039item.jpg")}}');">
                                @if($selectServiceItems)
                                <span class="mask bg-gradient-dark opacity-4"></span>
                                @else
                                <span class="mask bg-gradient-dark opacity-9"></span>
                                @endif
                                <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
                                    <h5 class="@if($selectServiceItems) text-primary @else text-white @endif font-weight-bolder mb-4 pt-2">Items</h5>
                                    <!-- <p class="text-white">Wealth creation is an evolutionarily recent positive-sum game. It is all about who take the opportunity first.</p> -->
                                    <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:;">
                                        <button wire:click="openServiceItems()" class="btn @if($selectServiceItems) bg-gradient-primary @else btn-outline-light @endif" type="button" >Select</button>
                                    </a>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-sm-4 col-md-3 col-lg-2 col-xl-2 my-2">
                    <div class="card h-100" >
                        <a wire:click="openPackages()" href="javascript:;">
                            <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('{{asset("img/service-item-products.jpg")}}');">
                                @if($selectPackageMenu)
                                <span class="mask bg-gradient-dark opacity-4"></span>
                                @else
                                <span class="mask bg-gradient-dark opacity-9"></span>
                                @endif
                                <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
                                    <h5 class="@if($selectPackageMenu) text-primary @else text-white @endif font-weight-bolder mb-4 pt-2">Packages</h5>
                                    <!-- <p class="text-white">Wealth creation is an evolutionarily recent positive-sum game. It is all about who take the opportunity first.</p> -->
                                    <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:;">
                                        <button wire:click="openPackages()" class="btn @if($selectPackageMenu) bg-gradient-primary @else btn-outline-light @endif" type="button" >Select</button>
                                    </a>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endif
        @endif        
    </div>
    @if($showSectionsList)
        <div class="row mt-2 mb-2">
            
            
            @if($service_group_name=='Quick Lube')
                @if($qlFilterOpen)
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <label for="seachByBrand">Engine Oil Brand</label>
                            <div class="form-group">
                                <select class="form-control" id="seachByBrand" wire:model="ql_search_brand" style="padding-left:5px !important;">
                                    <option value="">-Select-</option>
                                    @foreach($qlBrandsLists as $qlBrand)
                                    <option value="{{$qlBrand->BrandId}}">{{$qlBrand->Description}}</option>
                                    @endforeach
                                </select>
                                @error('ql_search_brand') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <label></label>
                            <div class="form-group pt-1">
                                <button class="btn bg-gradient-primary me-2" wire:click="qlItemkmRange(5000)">5K</button>
                                <button class="btn bg-gradient-primary" wire:click="qlItemkmRange(10000)">10K</button>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group">
                                <label for="seachByCategory">Category</label>
                                <select class="form-control" id="seachBy Category" wire:model="ql_search_category" wire:change="qlCategorySelect" style="padding-left:5px !important;">
                                    <option value="">-Select-</option>
                                    @foreach($itemQlCategories as $itemQlCategory)
                                    <option value="{{$itemQlCategory->CategoryId}}">{{$itemQlCategory->Description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div wire:loading wire:target="qlItemkmRange,qlCategorySelect">
                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                            <div class="la-ball-beat">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8 col-sm-8">
                            <div class="form-group">
                                <label for="seachByItemBrand">Items Name</label>
                                <input type="text" wire:model.defer="quickLubeItemSearch" name="" class="form-control">
                            </div>
                            @error('quickLubeItemSearch') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <label></label>
                            <div class="form-group pt-1">
                                <!-- <input type="text" wire:model.defer="quickLubeItemSearch" name="" class="form-control"> -->
                                <button class="btn bg-gradient-info" wire:click="searchQuickLubeItem">Search</button>
                            </div>
                        </div>
                    </div>
                    <div wire:loading wire:target="searchQuickLubeItem">
                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                            <div class="la-ball-beat">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                @endif

                @if($showQlItems)
                    <div class="row mt-4"  id="serviceQlItems">
                        @if (session()->has('cartsuccess'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <span class="alert-icon text-light"><i class="ni ni-like-2"></i></span>
                                <span class="alert-text text-light"><strong>Success!</strong> {{ Session::get('cartsuccess') }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @forelse($quickLubeItemsList as $quickLubeItem)
                            <?php $qlItemPriceDetails = $quickLubeItem['priceDetails']; ?>
                            <?php $qlItemDiscountDetails = $quickLubeItem['discountDetails']; ?>
                            <div class="col-md-4 col-sm-6 mb-4">
                                <div class="card">
                                    <div class="card-header text-center pt-4 pb-3">
                                        <h6 class="font-weight-normal mt-2" style="text-transform: capitalize;">
                                            {{ strtolower($qlItemPriceDetails->ItemName)}}

                                        </h6>
                                        <small>{{$qlItemPriceDetails->ItemCode}}</small>
                                        <!-- <textarea style="padding-left: 5px !important;" class="form-control" placeholder="Notes..!" wire:model="extra_note.{{$qlItemPriceDetails->ItemId}}"></textarea > -->
                                        <div class="ms-auto">
                                            @if(!empty($qlItemDiscountDetails))
                                                <span class="badge bg-gradient-info">{{round($qlItemDiscountDetails->DiscountPerc,2)}}%off</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-body text-lg-left text-center pt-0">
                                        <h4 class="my-auto me-2" @if($qlItemDiscountDetails != null) style="text-decoration: line-through;" @endif>{{config('global.CURRENCY')}} {{round($qlItemPriceDetails->UnitPrice,2)}}
                                        </h4>
                                        @if($qlItemDiscountDetails != null)
                                        <h4 class="my-auto">
                                        <span class="text-secondary text-sm me-1">{{config('global.CURRENCY')}}</span>{{ round($qlItemPriceDetails->UnitPrice-(($qlItemDiscountDetails->DiscountPerc/100)*$qlItemPriceDetails->UnitPrice),2) }}
                                        </h4>
                                        @endif
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="number" class="form-control w-30 m-auto" placeholder="Qty" wire:model.defer="ql_item_qty.{{$qlItemPriceDetails->ItemId}}" style="padding-left:5px !important;" />
                                                <a href="javascript:;" class="btn bg-gradient-primary mb-0 ms-auto btn-sm"  wire:click="addtoCartItem('{{$qlItemPriceDetails}}','{{$qlItemDiscountDetails}}')">Add Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-danger text-white" role="alert">
                                <strong>Empty!</strong> The Searched items are not in stock!</div>
                        @endforelse 
                    </div>
                @endif
                @forelse($sectionsLists as $sectionsList)
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3 my-2 cursor-pointer" wire:click="getSectionServices({{$sectionsList}})">
                    <!--  aria-hidden="true" data-bs-toggle="modal" data-bs-target="#exampleModal"-->
                    <div class="card bg-gradient-primary">
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
                @empty
                @endforelse
            @else
                @foreach($sectionsLists as $sectionsList)
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3 my-2 cursor-pointer" wire:click="getSectionServices({{$sectionsList}})">
                    <div class="card bg-gradient-primary">
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
            @endif
        </div>

        @if($showServiceSectionsList)
            <!-- Modal -->
            <style type="text/css">
                .modal-body{
                    max-height: calc(100vh - 300px);
                    overflow-y: auto;
                }
            </style>
            <div class="modal fade" id="servicePriceModal" tabindex="-1" role="dialog" aria-labelledby="servicePriceModalLabel" aria-hidden="true" wire:ignore.self style="z-index:99999;" >
                <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:90%;">
                    <div class="modal-content">
                        @if (session()->has('cartsuccess'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <span class="alert-icon text-light"><i class="ni ni-like-2"></i></span>
                                <span class="alert-text text-light"><strong>Success!</strong> {{ Session::get('cartsuccess') }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="modal-header">
                            <h5 class="modal-title" id="servicePriceModalLabel">{{$service_group_name}} - {{$selectedSectionName}}</h5>
                            <button type="button" class="btn-close text-dark " style="font-size: 2.125rem !important;" data-bs-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true" class="text-xl">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body py-0">
                            <div class="row">
                                @forelse($sectionServiceLists as $sectionServiceList)
                                <?php $priceDetails = $sectionServiceList['priceDetails']; ?>
                                <?php $discountDetails = $sectionServiceList['discountDetails']; ?>
                                @if($priceDetails->UnitPrice!=0)
                                <div class="col-md-6">
                                    
                                    <div class="bg-gray-100 my-3 p-2">
                                        <div class="d-flex">
                                            <h6>{{$priceDetails->ItemCode}} - {{$priceDetails->ItemName}}</h6>
                                            <div class="ms-auto">
                                                @if(!empty($discountDetails))
                                                    <span class="badge bg-gradient-info">{{round($discountDetails->DiscountPerc,2)}}%off</span>
                                                @endif
                                                
                                            </div>
                                        </div>
                                        
                                        
                                        <p class="d-none text-sm mb-0">The website was initially built in PHP, I need a professional ruby programmer to shift it.</p>
                                        <!-- <textarea style="padding-left: 5px !important;" class="form-control" placeholder="Notes..!" wire:model="extra_note.{{$priceDetails->ItemId}}"></textarea > -->
                                        <div class="d-flex border-radius-lg p-0 mt-2">
                                            
                                            <h4 class="my-auto me-2" @if($discountDetails != null) style="text-decoration: line-through;" @endif>{{config('global.CURRENCY')}} {{round($priceDetails->UnitPrice,2)}}
                                            </h4>
                                            @if($discountDetails != null)
                                            <h4 class="my-auto">
                                            <span class="text-secondary text-sm me-1">{{config('global.CURRENCY')}}</span>{{ round($priceDetails->UnitPrice-(($discountDetails->DiscountPerc/100)*$priceDetails->UnitPrice),2) }}
                                            </h4>
                                            
                                            @endif

                                            <a href="javascript:;" class="btn bg-gradient-primary mb-0 ms-auto btn-sm"  wire:click="addtoCart('{{$priceDetails}}','{{$discountDetails}}')">Add Now</a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @empty
                                @endforelse
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" class="btn bg-gradient-primary">Save changes</button> -->
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif

    @if($selectServiceItems)
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="seachByItemCategory">Category</label>
                <select class="form-control" id="seachByItemCategory" wire:model="item_search_category">
                    <option value="">-Select-</option>
                    @foreach($itemCategories as $itemCategory)
                    <option value="{{$itemCategory->CategoryId}}">{{$itemCategory->Description}}</option>
                    @endforeach
                </select>
                @error('item_search_category') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="seachByItemSubCategory">Sub Category</label>
                <select class="form-control" id="seachByItemSubCategory" wire:model="item_search_subcategory">
                    <option value="">-Select-</option>
                    @foreach($itemSubCategories as $itemSubCategory)
                    <option value="{{$itemSubCategory->SubCategoryId}}">{{$itemSubCategory->Description}}</option>
                    @endforeach
                </select>
                @error('item_search_subcategory') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="col-md-4 d-none">
            <div class="form-group">
                <label for="seachByItemBrand">Brand</label>
                <select class="form-control" id="seachByItemBrand" wire:model="item_search_brand">
                    <option value="">-Select-</option>
                    @foreach($itemBrandsLists as $itemBrand)
                    <option value="{{$itemBrand->BrandId}}">{{$itemBrand->Description}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="seachByItemBrand">Items Name</label>
                <input type="text" wire:model.defer="itemSearchName" name="" class="form-control">
                <button class=" mt-2 btn bg-gradient-info" wire:click="dearchServiceItems">Search</button>
            </div>
            
        </div>
    </div>
    <div wire:loading wire:target="dearchServiceItems,addtoCartItem">
            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                <div class="la-ball-beat">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
    <div class="row mt-4">
        @if($showItemsSearchResults)
            @forelse($serviceItemsList as $servicesItem)
                <?php $itemPriceDetails = $servicesItem['priceDetails']; ?>
                <?php $itemDiscountDetails = $servicesItem['discountDetails']; ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header text-center pt-4 pb-3">
                            <h4 class="font-weight-normal mt-2">
                                {{$itemPriceDetails->ItemName}}
                            </h4>
                            <h4 class="font-weight-bold mt-2">
                                <small>AED</small>{{round($itemPriceDetails->UnitPrice,2)}}
                            </h4>
                        </div>
                        <div class="card-body text-lg-left text-center pt-0">
                            <a href="javascript:;" class="btn btn-icon bg-gradient-primary d-lg-block mt-3 mb-0" wire:click="addtoCartItem('{{$itemPriceDetails}}','{{$itemDiscountDetails}}')">Buy Now<i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-danger text-white" role="alert">
                                <strong>Empty!</strong> The Searched items are not in stock!</div>
            @endforelse 
        @endif
    </div>
    @endif
    @if($showPackageList)
    <div class="row mt-4">
        <div class="container">
            <div class="tab-content tab-space">
                <div class="tab-pane active" id="monthly" role="tabpanel" aria-labelledby="tabs-iconpricing-tab-1">
                    <div class="row">
                        @foreach($servicePackage as $servicePkg)

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-lg-0 mb-4">
                                <div class="card">
                                    <div class="card-header text-center pt-4 pb-3">
                                        <span class="badge rounded-pill bg-light text-dark">{{$servicePkg->PackageName}}</span>
                                        <p class="text-sm font-weight-bold text-dark mt-2 mb-0">Duration: {{$servicePkg->Duration}} Months</p>
                                        <p class="text-sm font-weight-bold text-dark">{{$servicePkg->PackageKM}} K.M</p>
                                        
                                    </div>
                                    <div class="card-body text-lg-start text-left pt-0">
                                        <?php $totalPrice=0;?>
                                        <?php $unitPrice=0;?>
                                        <?php $discountedPrice=0;?>
                                        @foreach($servicePkg->packageDetails as $packageDetails)
                                            @if($packageDetails->isDefault==1)
                                            <div class="d-flex justify-content-lg-start p-2">
                                                
                                                <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                                    <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                                </div>
                                                <?php $totalPrice = $totalPrice+$packageDetails->TotalPrice; ?>
                                                <?php $unitPrice = $unitPrice+$packageDetails->UnitPrice; ?>
                                                <?php $discountedPrice = $discountedPrice+$packageDetails->DiscountedPrice; ?>
                                                
                                                <div>
                                                    @if($packageDetails->ItemType=='S')
                                                    <span class="ps-3">{{$packageDetails->labourItemDetails['ItemName']}}</span>
                                                    @else
                                                    <span class="ps-3">{{$packageDetails->inventoryItemDetails['ItemName']}}</span>
                                                    @endif
                                                    <p class="h6"><small><s>AED {{$packageDetails->UnitPrice}}</s> {{$packageDetails->DiscountedPrice}}</small></p>
                                                </div>
                                            </div>
                                            @endif  
                                        @endforeach
                                        <!-- <div class="d-flex justify-content-lg-start p-2">
                                            <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                                                <i class="fas fa-minus" aria-hidden="true"></i>
                                            </div>
                                            <div>
                                                <span class="ps-3">Integration help </span>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-lg-start p-2">
                                            <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                                                <i class="fas fa-minus" aria-hidden="true"></i>
                                            </div>
                                            <div>
                                                <span class="ps-3">Sketch Files </span>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-lg-start  p-2">
                                            <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                                                <i class="fas fa-minus" aria-hidden="true"></i>
                                            </div>
                                            <div>
                                                <span class="ps-3">API Access </span>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-lg-start p-2">
                                            <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                                                <i class="fas fa-minus" aria-hidden="true"></i>
                                            </div>
                                            <div>
                                                <span class="ps-3">Complete documentation </span>
                                            </div>
                                        </div> -->
                                        <h3 class="text-default font-weight-bold mt-2"></h3>
                                        <p class="text-center h4"><s><small>AED</small> {{$unitPrice}}</s> <small>AED</small> {{$discountedPrice}}</p>
                                        <div class="text-center align-center">
                                            <a href="javascript:;" class="btn btn-icon bg-gradient-dark d-lg-block mt-3 mb-0 " wire:click="packageAddOnContinue({{$servicePkg}})">Continue<i class="fas fa-arrow-right ms-1" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if($showPackageAddons)
                        @include('components.modals.pckageAddOns')
                        @endif
                <!-- <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4  col-xs-6 mb-lg-0 mb-4">
                  <div class="card">
                    <div class="card-header text-center pt-4 pb-3">
                      <span class="badge rounded-pill bg-light text-dark">Starter</span>
                      <h1 class="font-weight-bold mt-2">
                        <small>$</small>59
                      </h1>
                    </div>
                    <div class="card-body text-lg-start text-center pt-0">
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">2 team members</span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">20GB Cloud storage </span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                          <i class="fas fa-minus" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">Integration help </span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                          <i class="fas fa-minus" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">Sketch Files </span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                          <i class="fas fa-minus" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">API Access </span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                          <i class="fas fa-minus" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">Complete documentation </span>
                        </div>
                      </div>
                      <a href="javascript:;" class="btn btn-icon bg-gradient-dark d-lg-block mt-3 mb-0">
                        Join
                        <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4  col-xs-6 mb-lg-0 mb-4">
                  <div class="card">
                    <div class="card-header text-center pt-4 pb-3">
                      <span class="badge rounded-pill bg-light text-dark">Premium</span>
                      <h1 class="font-weight-bold mt-2">
                        <small>$</small>89
                      </h1>
                    </div>
                    <div class="card-body text-lg-start text-center pt-0">
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">10 team members</span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">40GB Cloud storage </span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">Integration help </span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">Sketch Files </span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                          <i class="fas fa-minus" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">API Access </span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                          <i class="fas fa-minus" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">Complete documentation </span>
                        </div>
                      </div>
                      <a href="javascript:;" class="btn btn-primary btn-icon d-lg-block mt-3 mb-0">
                        Try Premium
                        <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4  col-xs-6 mb-lg-0 mb-4">
                  <div class="card">
                    <div class="card-header text-center pt-4 pb-3">
                      <span class="badge rounded-pill bg-light text-dark">Enterprise</span>
                      <h1 class="font-weight-bold mt-2">
                        <small>$</small>99
                      </h1>
                    </div>
                    <div class="card-body text-lg-start text-center pt-0">
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">Unlimited team members</span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">100GB Cloud storage </span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">Integration help </span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">Sketch Files </span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">API Access </span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">Complete documentation </span>
                        </div>
                      </div>
                      <a href="javascript:;" class="btn btn-icon bg-gradient-dark d-lg-block mt-3 mb-0">
                        Join
                        <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
                      </a>
                    </div>
                  </div>
                </div> -->
              </div>
            </div>
            <div class="tab-pane" id="annual" role="tabpanel" aria-labelledby="tabs-iconpricing-tab-2">
              <div class="row">
                <div class="col-lg-4 mb-lg-0 mb-4">
                  <div class="card">
                    <div class="card-header text-center pt-4 pb-3">
                      <span class="badge rounded-pill bg-light text-dark">Starter</span>
                      <h1 class="font-weight-bold mt-2">
                        <small>$</small>119
                      </h1>
                    </div>
                    <div class="card-body text-lg-start text-center pt-0">
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">2 team members</span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">20GB Cloud storage </span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                          <i class="fas fa-minus" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">Integration help </span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                          <i class="fas fa-minus" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">Sketch Files </span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                          <i class="fas fa-minus" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">API Access </span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                          <i class="fas fa-minus" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">Complete documentation </span>
                        </div>
                      </div>
                      <a href="javascript:;" class="btn btn-icon bg-gradient-dark d-lg-block mt-3 mb-0">
                        Join
                        <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 mb-lg-0 mb-4">
                  <div class="card">
                    <div class="card-header text-center pt-4 pb-3">
                      <span class="badge rounded-pill bg-light text-dark">Premium</span>
                      <h1 class="font-weight-bold mt-2">
                        <small>$</small>159
                      </h1>
                    </div>
                    <div class="card-body text-lg-start text-center pt-0">
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">10 team members</span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">40GB Cloud storage </span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">Integration help </span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">Sketch Files </span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                          <i class="fas fa-minus" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">API Access </span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-secondary shadow text-center">
                          <i class="fas fa-minus" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">Complete documentation </span>
                        </div>
                      </div>
                      <a href="javascript:;" class="btn btn-primary btn-icon d-lg-block mt-3 mb-0">
                        Try Premium
                        <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 mb-lg-0 mb-4">
                  <div class="card">
                    <div class="card-header text-center pt-4 pb-3">
                      <span class="badge rounded-pill bg-light text-dark">Enterprise</span>
                      <h1 class="font-weight-bold mt-2">
                        <small>$</small>399
                      </h1>
                    </div>
                    <div class="card-body text-lg-start text-center pt-0">
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">Unlimited team members</span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">100GB Cloud storage </span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">Integration help </span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">Sketch Files </span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">API Access </span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-lg-start justify-content-center p-2">
                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                          <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                        </div>
                        <div>
                          <span class="ps-3">Complete documentation </span>
                        </div>
                      </div>
                      <a href="javascript:;" class="btn btn-icon bg-gradient-dark d-lg-block mt-3 mb-0">
                        Join
                        <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    @endif
@endif

@if($showCheckList)
    <div class="row mt-3">
        @if($showFuelScratchCheckList)
        <div class="col-xxs-12 col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-4">
            <div class="card">
                <div class="card-header text-center pt-4 pb-3">
                    <h5 class="font-weight-bold mt-2">Check List</h5>
                </div>
                <div class="card-body text-left pt-0">
                    @foreach($checklistLabels as $clKey => $checklist)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" wire:model="checklistLabel.{{$checklist->id}}" id="checkList{{ str_replace(" ","",$checklist->checklist_label) }}" >
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
                    <h5 class="font-weight-bold mt-2 d-none">Scratches</h5>
                </div>
                <div class="card-body text-left pt-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="textareaScratchesFound">Found</label>
                                <textarea class="form-control" id="scratchesFound" wire:model="scratchesFound" rows="3"></textarea>
                                @error('scratchesFound') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="textareaScratchesNotFound">Not Found</label>
                                <textarea class="form-control" id="scratchesNotFound" wire:model="scratchesNotFound" rows="3"></textarea>
                                @error('scratchesNotFound') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if($showQLCheckList)
        <div class="col-xxs-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 mb-4 d-none">
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
        <div class="col-xxs-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 mb-4 d-none">
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
        <div class="col-xxs-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 mb-4 d-none">
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

                        <div class="col-md-6 col-sm-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-icon btn-2 btn-primary float-end" id="upfile1" type="button">
                                        <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                    </button>
                                </div>
                            </div>
                            <input type="file" id="file1" wire:model="vImageR1" accept="image/*" capture style="display:none"/>
                            <img class="w-75 float-end" id="img1" src="@if($vImageR1) {{$vImageR1->temporaryUrl()}} @else {{asset('img/checklist/car1.png')}} @endif" style="cursor:pointer"  />
                            @error('vImageR1') <span class="text-danger">Missing Image..!</span> @enderror
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-icon btn-2 btn-primary float-end" id="upfile2" type="button">
                                        <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                    </button>
                                </div>
                            </div>
                            <input type="file" id="file2" wire:model="vImageR2" accept="image/*" capture style="display:none"/>
                            <img class="w-75 float-start" id="img2" src="@if ($vImageR2) {{ $vImageR2->temporaryUrl() }} @else {{asset('img/checklist/car2.png')}} @endif" style="cursor:pointer"  />
                            @error('vImageR2') <span class="text-danger">Missing Image..!</span> @enderror
                        </div>
                        <hr>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-icon btn-2 btn-primary float-end" id="upfile3" type="button">
                                        <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                    </button>
                                </div>
                            </div>
                            <input type="file" id="file3" wire:model="vImageF" accept="image/*" capture style="display:none"/>
                            <img class="w-75 float-end" id="img3" src="@if ($vImageF) {{ $vImageF->temporaryUrl() }} @else {{asset('img/checklist/car3.jpg')}} @endif" style="cursor:pointer"  />
                            @error('vImageF') <span class="text-danger">Missing Image..!</span> @enderror
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-icon btn-2 btn-primary float-end" id="upfile4" type="button">
                                        <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                    </button>
                                </div>
                            </div>
                            <input type="file" id="file4" wire:model="vImageB" accept="image/*" capture style="display:none"/>
                            <img class="w-75 float-start" id="img4" src="@if ($vImageB) {{ $vImageB->temporaryUrl() }} @else {{asset('img/checklist/car4.jpg')}} @endif" style="cursor:pointer"  />
                            @error('vImageB') <span class="text-danger">Missing Image..!</span> @enderror
                        </div>
                        <hr>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-icon btn-2 btn-primary float-end" id="upfile5" type="button">
                                        <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                    </button>
                                </div>
                            </div>
                            <input type="file" id="file5" wire:model="vImageL1" accept="image/*" capture style="display:none"/>
                            <img class="w-75 float-end" id="img5" src="@if ($vImageL1) {{ $vImageL1->temporaryUrl() }} @else {{asset('img/checklist/car5.png')}} @endif" style="cursor:pointer"  />
                            @error('vImageL1') <span class="text-danger">Missing Image..!</span> @enderror
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-icon btn-2 btn-primary float-end" id="upfile6" type="button">
                                        <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                    </button>
                                </div>
                            </div>
                            <input type="file" id="file6" wire:model="vImageL2" accept="image/*" capture style="display:none"/>
                            <img class="w-75 float-start" id="img6" src="@if ($vImageL2) {{ $vImageL2->temporaryUrl() }} @else {{asset('img/checklist/car6.png')}} @endif" style="cursor:pointer"   />
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
                        <div class="col-md-3">
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
                        @if($totalDiscount)
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header mx-4 p-3 text-center">
                                    <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                        <i class="fa fa-money opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="card-body pt-0 p-3 text-center">
                                    <h6 class="text-center mb-0">Discount</h6>
                                    <!-- <span class="text-xs">Belong Interactive</span> -->
                                    <hr class="horizontal dark my-3">
                                    <h5 class="mb-0">AED {{ $totalDiscount }}</h5>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-3">
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
                        <div class="col-md-3">
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
                    @if($totalDiscount)
                    <p><span class="badge rounded-pill bg-light text-dark text-md">Discount: <small>AED</small> {{ $totalDiscount }}</span></p>
                    @endif
                    <p><span class="badge rounded-pill bg-light text-dark text-md">VAT: <small>AED</small> {{ $tax }}</span></p>
                    <p><span class="badge rounded-pill bg-dark text-light text-lg text-bold">Grand total: <small>AED</small> {{ $grand_total }}</span></p>
                    
                    
                </div>
                <div class="card-footer text-lg-left text-center pt-0">
                    <div class="d-flex justify-content-center p-2">
                        @if($mobile)
                        <div class="form-check">
                            <a wire:click="completePaymnet('link')" class="btn btn-icon bg-gradient-info d-lg-block mt-3 mb-0">Pay By Link<i class="fa-solid fa-comments-dollar ms-1" ></i></a>
                        </div>
                        @endif
                    
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
                        @if($mobile)
                        <div class="form-check">
                            <a wire:click="completePaymnet('link')" class="btn btn-icon bg-gradient-info d-lg-block mt-3 mb-0">Pay By Link<i class="fa-solid fa-comments-dollar ms-1" ></i></a>
                        </div>
                        @endif
                    
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
<div wire:loading wire:target="completePaymnet">
    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
        <div class="la-ball-beat">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
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