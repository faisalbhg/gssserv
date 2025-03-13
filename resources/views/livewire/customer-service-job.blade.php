@push('custom_css')

@endpush
<main class="main-content position-relative  border-radius-lg h-100">
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

        @if($showForms)
            <div class="card px-3 my-2" >
                <div class="card-body p-0">
                    @if($searchByMobileNumber)
                        <div class="row">
                            @if($showByMobileNumber)
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label for="mobilenumberInput">Mobile Number </label>
                                        <div class="input-group mb-0">
                                            <span class="input-group-text px-0">+971</span>
                                            <input  type="number" class="form-control @error('mobile') btn-outline-danger @enderror" placeholder="Mobile Number" aria-label="Mobile Number" aria-describedby="button-MobileSearch" wire:model="mobile"  name="mobile" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" minlength="1" maxlength="10" id="mobilenumberInput" style="padding-left:10px !important;">
                                        </div>
                                        @error('mobile') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            @endif
                            @if ($showCustomerForm)
                                <div class="col-md-4  col-sm-6">
                                    <div class="form-group openDiv">
                                        <label for="nameInput">Name</label>
                                        <input type="text" class="form-control @error('name') btn-outline-danger @enderror" wire:model.defer="name" name="name" placeholder="Name" id="nameInput">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group openName">
                                        <label for="emailInput">Email</label>
                                        <input type="email" wire:model.defer="email" name="email" class="form-control @error('email') btn-outline-danger @enderror" id="emailInput" placeholder="Email">
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                    @if($showPlateNumber)
                        <div class="row">
                            <div class="col-2">
                                <label for="plateImageFile" >Plate Image</label>
                                <div  x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"  x-on:livewire-upload-finish="isUploading = false"  x-on:livewire-upload-error="isUploading = false"  x-on:livewire-upload-progress="progress = $event.detail.progress" >
                                    <!-- <div class="row">
                                        <div class="col-md-12">
                                            
                                            <button class="btn btn-icon btn-2 btn-primary float-start" id="plateImage" type="button">
                                                <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                            </button>
                                        </div>
                                    </div> -->
                                    <!-- File Input -->
                                    <input type="file" id="plateImageFile" wire:model="plate_number_image" accept="image/*" capture style="display: block;" />
                                    <!-- Progress Bar -->
                                    <div x-show="isUploading">
                                        <progress max="100" x-bind:value="progress"></progress>
                                    </div>
                                </div>
                                @if ($plate_number_image)
                                    <img class="img-fluid border-radius-lg w-30" src="{{ $plate_number_image->temporaryUrl() }}">
                                @endif
                            </div>
                            <div class="col-md-3 col-sm-4">
                                <div class="form-group">
                                    <label for="plateCountry">Country</label>
                                    <select class="form-control chosen-select" wire:model="plate_country"  id="plateCountry" name="plate_country" aria-invalid="false"><option value="">Select</option>
                                        @foreach(config('global.country') as $country)
                                        <option value="{{$country['CountryCode']}}">{{$country['CountryName']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="plateEmirates">Plate Emirates</label>
                                    <select class="form-control chosen-select" wire:model="plate_state" name="plate_state" id="plateEmirates" style="padding:0.5rem 0.3rem !important;" >
                                        <option value="">-Emirates-</option>
                                        @foreach($stateList as $state)
                                        <option value="{{$state->StateName}}">{{$state->StateName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="plateCode">Plate Code</label>
                                    <select class="form-control chosen-select" wire:model="plate_code" name="plateCode" id="plateCode" style="padding:0.5rem 0.3rem !important;" >
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
                        @if($showSearchByPlateNumberButton)
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" wire:click="clickSearchByPlateNumber()" class="btn btn-primary btn-sm">Search By Plate Number</button>
                                    <button type="button" wire:click="saveByPlateNumber()" class="btn btn-info btn-sm">Save Plate Number</button>
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
                    @endif
                    @if($otherVehicleDetailsForm)
                        <div class="row">
                            <div class="col-md-2 col-sm-2">
                                <label for="vehicleImageFile">Vehicle Image</label>
                                <div  x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"  x-on:livewire-upload-finish="isUploading = false"  x-on:livewire-upload-error="isUploading = false"  x-on:livewire-upload-progress="progress = $event.detail.progress" >
                                    <!-- <div class="row">
                                        <div class="col-md-12">
                                            
                                            <button class="btn btn-icon btn-2 btn-primary float-start" id="vehicleImage" type="button">
                                                <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                            </button>
                                        </div>
                                    </div> -->
                                    <!-- File Input -->
                                    <input type="file" id="vehicleImageFile" wire:model="vehicle_image" accept="image/*" capture style="display: block;" />
                                    <!-- Progress Bar -->
                                    <div x-show="isUploading">
                                        <progress max="100" x-bind:value="progress"></progress>
                                    </div>
                                </div>
                                @if ($vehicle_image)
                                <img class="img-fluid border-radius-lg w-30" src="{{ $vehicle_image->temporaryUrl() }}">
                                @endif
                                @error('vehicle_image') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-3 col-sm-5">
                                <div class="form-group">
                                    <label for="vehicleTypeInput">Vehicle Type</label>
                                    <select class="form-control chosen-select  @error('vehicle_type') btn-outline-danger @enderror" id="vehicleTypeInput" wire:model="vehicle_type">
                                        <option value="">-Select-</option>
                                        @foreach($vehicleTypesList as $vehicleType)
                                        <option value="{{$vehicleType->id}}">{{$vehicleType->type_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('vehicle_type') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-4">
                                <label for="AddVehicleMakeInput mb-2"></label>
                                <div class="form-group">
                                    <button type="button" wire:click="addMakeModel()" class="btn btn-info btn-sm mt-2" id="AddVehicleMakeInput">Add Make Model</button>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="vehicleMakeInput">Vehicle Make</label>
                                    <select class="form-control chosen-select" id="vehicleMakeInput" wire:model="make" >
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

                                    <select class="form-control chosen-select" id="vehicleModelInput" wire:model="model">
                                        <option value="">-Select-</option>
                                        @foreach($vehiclesModelList as $model)
                                        <option value="{{$model->id}}">{{$model->vehicle_model_name}}</option>
                                        @endforeach
                                    </select>
                                     @error('model') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="vehicleKmInput">K.M Reading</label>
                                    <input type="number" class="form-control" id="vehicleKmInput" wire:model="vehicle_km" name="vehicle_km" placeholder="Chaisis Number">
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($searchByChaisisForm)
                        <div class="row">
                            <div class="col-md-3 col-sm-2">
                                <label for="chaisisImageFile">Chaisis Picture</label>
                                <div  x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"  x-on:livewire-upload-finish="isUploading = false"  x-on:livewire-upload-error="isUploading = false"  x-on:livewire-upload-progress="progress = $event.detail.progress" >
                                    <!-- <div class="row">
                                        <div class="col-md-12">
                                            
                                            <button class="btn btn-icon btn-2 btn-primary float-start" id="chaisisImage" type="button">
                                                <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                            </button>
                                        </div>
                                    </div> -->
                                    <!-- File Input -->
                                    <input type="file" id="chaisisImageFile" wire:model="chaisis_image" accept="image/*" capture style="display: block;" />
                                    <!-- Progress Bar -->
                                    <div x-show="isUploading">
                                        <progress max="100" x-bind:value="progress"></progress>
                                    </div>
                                </div>
                                @if ($chaisis_image)
                                    <img class="img-fluid border-radius-lg w-30" src="{{ $chaisis_image->temporaryUrl() }}">
                                    <!-- <button type="button" class="btn bg-gradient-secondary btn-sm" wire:click="getChaisisNumber('{{$chaisis_image->temporaryUrl()}}')">Get Chaisis Number</button> -->
                                @endif
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="chaisisNumberInput">Chaisis Number</label>
                                    <input type="text" class="form-control" id="chaisisNumberInput" wire:model="chassis_number" name="chassis_number" placeholder="Chassis Number">
                                </div>
                            </div>
                        </div>
                        @if($showSearchByChaisisButton)
                            <div class="row">
                                <div class="col-md-3 col-sm-2">
                                    <button type="button" wire:click="clickSearchByChaisisNumber()" class="btn btn-primary btn-sm">Search By Chaisis Number</button>
                                    <div wire:loading wire:target="clickSearchByChaisisNumber">
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
                        @endif
                        
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
        @endif

        @if($selectedCustomerVehicle)
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-4">
                            <div class="card card-profile card-plain">
                                <div class="position-relative">
                                    <div class="blur-shadow-image">
                                        <img class="w-100 rounded-3 shadow-lg" src="{{url("public/storage/".$selectedVehicleInfo["vehicle_image"])}}">
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="card card-profile card-plain">
                                <div class="card-body text-left p-0">
                                    <div class="p-md-0 pt-3">
                                        <h5 class="font-weight-bolder mb-0">
                                            {{$selectedVehicleInfo['plate_number_final']}}
                                        </h5>
                                        <p class="text-uppercase text-sm font-weight-bold mb-2">{{isset($selectedVehicleInfo->makeInfo)?$selectedVehicleInfo->makeInfo['vehicle_name']:''}}, {{isset($selectedVehicleInfo->modelInfo['vehicle_model_name'])?$selectedVehicleInfo->modelInfo['vehicle_model_name']:''}}</p>
                                    </div>
                                    @if($selectedVehicleInfo['customerInfoMaster']['TenantName'])
                                        @if($selectedVehicleInfo['customerInfoMaster']['TenantName'])
                                        <p class="mb-0">{{$selectedVehicleInfo['customerInfoMaster']['TenantName']}}</p>
                                        @endif
                                        @if($selectedVehicleInfo['customerInfoMaster']['Mobile'])
                                        <p class="mb-0">{{$selectedVehicleInfo['customerInfoMaster']['Mobile']}}</p>
                                        @endif
                                        @if($selectedVehicleInfo['customerInfoMaster']['Email'])
                                        <p class="mb-1">{{$selectedVehicleInfo['customerInfoMaster']['Email']}}</p>
                                        @endif
                                    @else
                                    <p class="mb-0">Customer Guest</p>
                                    @endif
                                    @if($selectedVehicleInfo['chassis_number'])
                                    <p class="mb-1"><b>Chaisis:</b> {{$selectedVehicleInfo['chassis_number']}}</p>
                                    @endif
                                    @if($selectedVehicleInfo['vehicle_km'])
                                    <b>KM Reading:</b> {{$selectedVehicleInfo['vehicle_km']}}</p>
                                    @endif
                                    <div>
                                        <button type="button" class="btn bg-gradient-primary btn-tooltip btn-sm" title="Edit Customer/Discount/Vehicle" wire:click="editCustomer()">Edit</button>
                                        <button type="button" class="btn bg-gradient-primary btn-tooltip btn-sm" title="Add Customer/Discount/Vehicle"  wire:click="addNewVehicle()">New Vehicle</button>
                                        <button type="button" class="btn bg-gradient-info btn-tooltip btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Apply Discount Group" data-container="body" data-animation="true" wire:click="clickDiscountGroup()">Discount Group</button>
                                        <button class="btn bg-gradient-info btn-sm" wire:click="openServiceGroup">Services</button>
                                        <div wire:loading wire:target="openServiceGroup">
                                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                <div class="la-ball-beat">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </div>
                                        @if(!empty($appliedDiscount))
                                        <button class="btn bg-gradient-danger btn-sm" wire:click.prevent="removeDiscount()">Remove Discount - {{strtolower(str_replace("_"," ",$appliedDiscount['code']))}}</button>
                                        <div wire:loading wire:target="removeDiscount">
                                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                <div class="la-ball-beat">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <!-- @if(@$appliedDiscount['groupType']==2)
                                        <button class="btn bg-gradient-danger btn-sm" wire:click.prevent="removeDiscount()">Remove Discount - {{strtolower(str_replace("_"," ",$appliedDiscount['title']))}}</button>
                                        @endif -->

                                        @if(@$appliedDiscount['groupType']==3)
                                        <button class="btn bg-gradient-success btn-sm " wire:click.prevent="applyEngineOilDiscount()">Apply {{$engineOilDiscountPercentage}}% Discount</button>
                                        @endif

                                        <br>
                                        <div wire:loading wire:target="applyEngineOilDiscount">
                                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                <div class="la-ball-beat">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:loading wire:target="editCustomer">
                                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                <div class="la-ball-beat">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:loading wire:target="addNewVehicle">
                                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                <div class="la-ball-beat">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:loading wire:target="clickDiscountGroup">
                                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                <div class="la-ball-beat">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:loading wire:target="saveSelectedDiscountGroup">
                                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                <div class="la-ball-beat">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- @if(!empty($appliedDiscount))
                                        <button class="btn bg-gradient-info text-white ms-0 py-1 px-3 m-0" wire:click.prevent="applyDiscountGroup()">Apply {{$appliedDiscount['code']}} Discount Group</button> 
                                        <button type="button" wire:click="removeDiscount()" class="btn btn-danger btn-simple btn-lg mb-0 p-1">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                        @endif -->
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 my-2" id="cartDisplayId">
                    @if($cardShow)
                        <div class="card card-profile card-plain">
                            <h6 class="text-uppercase text-body text-lg font-weight-bolder mt-2">Pricing Summary <span class="float-end text-sm text-danger text-capitalize">{{ count($cartItems) }} Services selected</span></h6>
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="card h-100">
                                        
                                        <div class="card-body p-3 pb-0">
                                            <ul class="list-group">
                                                <?php $total = 0;$totalDiscount=0; ?>
                                                @foreach ($cartItems as $item)
                                                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                        
                                                        <div class="d-flex flex-column">
                                                            <h6 class="mb-1 text-dark font-weight-bold text-sm">
                                                                {{ $item->item_name }}
                                                            </h6>
                                                            <span class="text-xs">#{{ $item->item_code }}</span>
                                                            @if($item->extra_note)
                                                                <span class="text-xs text-dark">Note: {{ $item->extra_note }}</span>
                                                            @endif
                                                            @if($item->customer_group_code)
                                                            <label wire:click.prevent="removeLineDiscount({{$item->id}})" class="badge bg-gradient-info cursor-pointer">{{strtolower($item->customer_group_code)}} {{ $item->discount_perc }}% Off <i class="fa fa-trash text-danger"></i> </label>
                                                            @endif

                                                            @if($confirming===$item->id)
                                                            <p>
                                                                <label class="p-0 text-success bg-red-600 cursor-pointer float-start" wire:click.prevent="kill({{ $item->id }},{{ $item->item_id }})"><i class="fa fa-trash"></i> Yes</label>
                                                                <label class="p-0 text-info bg-red-600 cursor-pointer float-end" wire:click.prevent="safe({{ $item->id }})"><i class="fa fa-trash"></i> No</label>
                                                                <div wire:loading wire:target="kill">
                                                                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                                        <div class="la-ball-beat">
                                                                            <div></div>
                                                                            <div></div>
                                                                            <div></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </p>

                                                            @else
                                                                <label class="p-0 text-danger bg-red-600 cursor-pointer" wire:click.prevent="confirmDelete({{ $item->id }})"><i class="fa fa-trash"></i> Remove</label>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex align-items-center text-sm">
                                                            <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4" @if($item->customer_group_code) style="text-decoration: line-through;" @endif >{{config('global.CURRENCY')}} {{custom_round($item->unit_price)}}</button>

                                                            @if($item->customer_group_code)
                                                            <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4">{{config('global.CURRENCY')}} {{ custom_round($item->unit_price-(($item->discount_perc/100)*($item->unit_price))) }}</button>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex align-items-center text-sm">
                                                            @if($item->quantity>1)<span class="px-2 cursor-pointer" wire:click="cartSetDownQty({{ $item->id }})">
                                                                <i class="fa-solid fa-square-minus fa-xl"></i>
                                                            </span>
                                                            @endif
                                                            {{$item->quantity}}
                                                            <span class="px-2 cursor-pointer" wire:click="cartSetUpQty({{ $item->id }})">
                                                                <i class="fa-solid fa-square-plus fa-xl"></i>
                                                            </span>
                                                        </div>
                                                        <div class="d-flex align-items-center text-sm">
                                                            <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4">{{config('global.CURRENCY')}}
                                                            @if($item->customer_group_code)
                                                            {{ custom_round($item->unit_price-(($item->discount_perc/100)*($item->unit_price)))*$item->quantity }}
                                                            @else
                                                            {{custom_round($item->unit_price*$item->quantity)}}
                                                            @endif</button>

                                                        </div>

                                                    </li>
                                                    <hr class="horizontal dark mt-0 mb-2">
                                                    <?php
                                                    $total = $total+$item->unit_price*$item->quantity;
                                                    if($item->discount_perc){
                                                        $totalDiscount = $totalDiscount+custom_round((($item->discount_perc/100)*$item->unit_price)*$item->quantity);
                                                        //echo $totalDiscount;
                                                    }
                                                    ?>
                                                @endforeach
                                                <?php
                                                $totalAfterDisc = $total - $totalDiscount;
                                                $tax = $totalAfterDisc * (config('global.TAX_PERCENT') / 100);
                                                $grand_total = $totalAfterDisc+$tax;
                                                ?>
                                            </ul>
                                            
                                            <button class="btn bg-gradient-danger btn-sm float-end" wire:click.prevent="clearAllCart">Remove All Cart</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-12 ms-auto">
                                    <h6 class="mb-3">Order Summary</h6>
                                    <div class="d-flex justify-content-between">
                                        <span class="mb-2 text-sm">
                                        Product Price:
                                        </span>
                                        <span class="text-dark font-weight-bold ms-2">{{config('global.CURRENCY')}} {{custom_round($total)}}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="mb-2 text-sm">
                                        Discount:
                                        </span>
                                        <span class="text-dark ms-2 font-weight-bold">{{config('global.CURRENCY')}} {{custom_round($totalDiscount)}}</span>
                                    </div>
                                    <hr class="horizontal dark my-2">
                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="mb-2 text-md text-dark text-bold">
                                        Total:
                                        </span>
                                        <span class="text-dark text-lg ms-2 font-weight-bold">{{config('global.CURRENCY')}} {{custom_round($totalAfterDisc)}}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-sm">
                                        Taxes:
                                        </span>
                                        <span class="text-dark ms-2 font-weight-bold">{{config('global.CURRENCY')}} {{custom_round($tax)}}</span>
                                    </div>
                                    <hr class="horizontal dark my-2">
                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="mb-2 text-lg text-dark text-bold">
                                        Grand Total:
                                        </span>
                                        <span class="text-dark text-lg ms-2 font-weight-bold">{{config('global.CURRENCY')}} {{custom_round($grand_total)}}</span>
                                    </div>
                                    @if($cardShow)
                                    <button type="button" class="btn bg-gradient-success btn-sm float-end" wire:click="submitService()">Confirm & Continue</button>
                                    <div wire:loading wire:target="submitService">
                                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                            <div class="la-ball-beat">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div wire:loading wire:target="removeLineDiscount">
                                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                            <div class="la-ball-beat">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div wire:loading wire:target="removeCart">
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
            </div>
        @endif

        @if($showServiceGroup)
            <div class="row" id="servceGroups">
                @if(!$servicesGroupList->isEmpty())
                    @foreach($servicesGroupList as $servicesGroup)
                        <div class="col-sm-3 col-md-3 col-lg-2 col-xl-2 my-2">
                            <div class="card h-100" >
                                <a wire:click="serviceGroupForm({{$servicesGroup}})" href="javascript:;">
                                    <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('{{asset("img/".str_replace(" ","-",$servicesGroup->department_name).".jpg")}}');">
                                        @if($service_group_id == $servicesGroup->id)
                                        <span class="mask bg-gradient-dark opacity-4"></span>
                                        @else
                                        <span class="mask bg-gradient-dark opacity-7"></span>
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
                    
                    <div class="col-sm-3 col-md-3 col-lg-2 col-xl-2 my-2">
                        <div class="card h-100" >
                            <a wire:click="openServiceItems()" href="javascript:;">
                                <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('{{asset("img/PP00039item.jpg")}}');">
                                    @if($showServiceItems)
                                    <span class="mask bg-gradient-dark opacity-4"></span>
                                    @else
                                    <span class="mask bg-gradient-dark opacity-7"></span>
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

                    <div class="col-sm-3 col-md-3 col-lg-2 col-xl-2 my-2">
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

                    <div class="col-sm-3 col-md-3 col-lg-2 col-xl-2 my-2">
                        <div class="card h-100" >
                            <a wire:click="openBundles()" href="javascript:;">
                                <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('{{asset("img/bundle-package.jpg")}}');">
                                    @if($selectBundleMenu)
                                    <span class="mask bg-gradient-dark opacity-4"></span>
                                    @else
                                    <span class="mask bg-gradient-dark opacity-9"></span>
                                    @endif
                                    <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
                                        <h5 class="@if($selectPackageMenu) text-primary @else text-white @endif font-weight-bolder mb-4 pt-2">Bundles</h5>
                                        <!-- <p class="text-white">Wealth creation is an evolutionarily recent positive-sum game. It is all about who take the opportunity first.</p> -->
                                        <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:;">
                                            <button wire:click="openBundles()" class="btn @if($selectPackageMenu) bg-gradient-primary @else btn-outline-light @endif" type="button" >Select</button>
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                @endif
            </div>
            <div wire:loading wire:target="serviceGroupForm">
                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                    <div class="la-ball-beat">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <div wire:loading wire:target="openServiceItems">
                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                    <div class="la-ball-beat">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <div wire:loading wire:target="openPackages">
                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                    <div class="la-ball-beat">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <div wire:loading wire:target="openBundles">
                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                    <div class="la-ball-beat">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            @if($showQlItemSearch)
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <label for="qlSeachByBrand">Engine Oil Brand</label>
                        <div class="form-group">
                            <select class="form-control" id="qlSeachByBrand" wire:model="ql_search_brand" style="padding-left:5px !important;">
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
                            <label for="qlSeachByCategory">Category</label>
                            <select class="form-control" id="qlSeachByCategory" wire:model="ql_search_category" wire:change="qlCategorySelect" style="padding-left:5px !important;">
                                <option value="">-Select-</option>
                                @foreach($itemQlCategories as $itemQlCategory)
                                <option value="{{$itemQlCategory->CategoryId}}">{{$itemQlCategory->Description}}</option>
                                @endforeach
                            </select>
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
                            <button class="btn bg-gradient-info" wire:click="searchQuickLubeItem">Search</button>
                        </div>
                    </div>
                </div>
                <div wire:loading wire:target="qlItemkmRange">
                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                        <div class="la-ball-beat">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>
                <div wire:loading wire:target="qlCategorySelect">
                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                        <div class="la-ball-beat">
                            <div></div>
                            <div></div>
                            <div></div>
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
                <!-- serviceQlItems -->
                @if($showQlItemsList)
                    <div class="row"  id="serviceQlItems">
                        @forelse($quickLubeItemsList as $quickLubeItem)
                            <?php $qlItemPriceDetails = $quickLubeItem['priceDetails']; ?>
                            <?php $qlItemDiscountDetails = $quickLubeItem['discountDetails']; ?>
                            @if($qlItemPriceDetails->UnitPrice!=0)
                            <div class="col-md-4 col-sm-6">
                                <div class="card mt-2">
                                    <div class="card-header text-center p-2">
                                        <p class="font-weight-normal mt-2 text-capitalize text-sm- font-weight-bold mb-0">
                                            {{strtolower($qlItemPriceDetails->ItemName)}}<small>({{$qlItemPriceDetails->ItemCode}})</small>
                                        </p>
                                        <h5 class="font-weight-bold mt-2"  @if($qlItemDiscountDetails != null) style="text-decoration: line-through;" @endif>
                                            <small>AED</small>{{custom_round($qlItemPriceDetails->UnitPrice)}}
                                        </h5>
                                        @if($qlItemDiscountDetails != null)
                                        <h5 class="font-weight-bold mt-2">
                                            <span class="text-secondary text-sm me-1">{{config('global.CURRENCY')}}</span>{{ custom_round($qlItemPriceDetails->UnitPrice-(($qlItemDiscountDetails->DiscountPerc/100)*$qlItemPriceDetails->UnitPrice)) }}
                                        </h5>
                                        @endif
                                        <div class="ms-auto">
                                            @if(!empty($qlItemDiscountDetails))
                                                <span class="badge bg-gradient-info">{{custom_round($qlItemDiscountDetails->DiscountPerc)}}%off</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-body text-lg-left text-center p-2">
                                        <input type="number" class="form-control w-30 float-start" placeholder="Qty" wire:model.defer="ql_item_qty.{{$qlItemPriceDetails->ItemId}}" style="padding-left:5px !important;" />
                                        <a href="javascript:;" class="btn btn-icon bg-gradient-primary d-lg-block m-0 float-end p-2" wire:click="addtoCartItem('{{$qlItemPriceDetails->ItemCode}}','{{$qlItemDiscountDetails}}')">Buy Now<i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                    @if(@$serviceAddedMessgae[$qlItemPriceDetails->ItemCode])
                                    <div class="text-center">
                                        <span class="alert-icon"><i class="ni ni-like-2 text-success"></i></span>
                                        <span class="alert-text text-success"><strong>Success!</strong> Added serves!</span>
                                        <button type="button" class="btn-close text-success" data-bs-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        @empty
                            <div class="alert alert-danger text-white" role="alert">
                                <strong>Empty!</strong> The Searched items are not in stock!</div>
                        @endforelse 
                    </div>
                @endif
            @endif
            @if($showSectionsList)
                <div class="row mt-2 mb-2" id="servceSectionsList">
                    @foreach($sectionsLists as $sectionsList)
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3 my-2 cursor-pointer" wire:click="getSectionServices({{$sectionsList}})">
                            <div class="card bg-gradient-primary">
                                <div class="card-body p-2">
                                    <div class="row">
                                        <div class="col-md-9 col-sm-9">
                                            <div class="numbers">
                                            <p class="text-white text-sm mb-0 opacity-7">{{$service_group_name}}</p>
                                            <h6 class="text-white font-weight-bolder mb-0 text-capitalize">
                                            {{strtolower(str_replace("-"," ",$sectionsList->PropertyName))}}
                                            </h6>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 text-end">
                                            <div class="icon icon-shape bg-white shadow text-center border-radius-md">
                                                <i class="cursor-pointer fa-solid fa-angles-down text-dark text-lg opacity-10"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div wire:loading wire:target="getSectionServices">
                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                            <div class="la-ball-beat">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
        @endif
        
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
                        
                        <div class="modal-header">
                            <h5 class="modal-title" id="servicePriceModalLabel">{{$selectedSectionName}}</h5>
                            <input type="text" class="form-control w-30" name="" wire:model="section_service_search">
                            <div wire:loading wire:target="section_service_search">
                                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                    <div class="la-ball-beat">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </div>
                            </div>
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
                                    <div class="col-md-6 col-sm-6">
                                        
                                        <div class="bg-gray-100 shadow my-3 p-2">
                                            <div class="row">
                                                <div class="col-12">
                                                    <p class="text-sm text-center font-weight-bold text-dark">{{$priceDetails->ItemCode}} - {{$priceDetails->ItemName}}</p>
                                                    <!-- <textarea style="padding-left: 5px !important;" class="form-control" placeholder="Notes..!" wire:model="extra_note.{{$priceDetails->ItemId}}"></textarea > -->
                                                </div>
                                            </div>
                                            <div class="row">
                                                @if($priceDetails->CustomizePrice==1)
                                                
                                                <div class="col-12">
                                                    <input type="number" class="form-control w-50 float-start" placeholder="Price {{$priceDetails->MinPrice}} - {{$priceDetails->MaxPrice}}" wire:model="customise_service_item_price.{{$priceDetails->ItemId}}" style="padding-left:5px !important;" >
                                                    
                                                </div>
                                                @else
                                                <div class="col-12">
                                                    <div class="d-flex border-radius-lg p-0 mt-2">
                                                        <p class="w-100 text-md font-weight-bold text-dark my-auto me-2 float-start">
                                                        <span class="float-start" @if($discountDetails != null) style="text-decoration: line-through;" @endif>
                                                            <span class=" text-sm me-1">{{config('global.CURRENCY')}}</span> {{custom_round($priceDetails->UnitPrice)}}
                                                        </span>
                                                        @if($discountDetails != null)
                                                        <span  class="float-end">
                                                        <span class=" text-sm me-1">{{config('global.CURRENCY')}}</span> {{ custom_round($priceDetails->UnitPrice-(($discountDetails['DiscountPerc']/100)*$priceDetails->UnitPrice)) }}
                                                        </span>
                                                        @endif
                                                        </p>
                                                        
                                                    </div>
                                                </div>
                                                @endif
                                                

                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="d-flex border-radius-lg p-0 mt-2">
                                                        @if($discountDetails != null)
                                                        <span class="badge bg-gradient-info">{{custom_round($discountDetails['DiscountPerc'])}}%off</span>
                                                        @endif
                                                        
                                                        <a href="javascript:;" class="btn bg-gradient-primary mb-0 ms-auto btn-sm"  wire:click="addtoCart('{{$priceDetails}}','{{$discountDetails}}')">Add Now</a>
                                                        
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                            
                                            
                                            
                                            @if(@$serviceAddedMessgae[$priceDetails->ItemCode])
                                            <div class="text-center">
                                                <span class="alert-icon"><i class="ni ni-like-2 text-success"></i></span>
                                                <span class="alert-text text-success"><strong>Success!</strong> Added serves!</span>
                                                <button type="button" class="btn-close text-success" data-bs-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            @endif
                                            @if(@$customizedErrorMessage[$priceDetails->ItemId])
                                            <div class="text-center">
                                                
                                                <span class="alert-text text-danger"><strong>Error!</strong> Enter valied price!</span>
                                                <button type="button" class="btn-close text-danger" data-bs-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            @endif

                                        </div>
                                    </div>
                                    @endif
                                @empty
                                @endforelse
                                <div wire:loading wire:target="addtoCart">
                                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                        <div class="la-ball-beat">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                </div>
                                <div wire:loading wire:target="addtoCartCP">
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
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" class="btn bg-gradient-primary">Save changes</button> -->
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($showServiceItems)
            <div class="row" id="serviceItemsListDiv">
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="seachByItemCategory">Category</label>
                        <select class="form-control" id="seachItemByCategory" wire:model="item_search_category">
                            <option value="">-Select-</option>
                            @foreach($itemCategories as $itemCategory)
                            <option value="{{$itemCategory->CategoryId}}">{{$itemCategory->Description}}</option>
                            @endforeach
                        </select>
                        @error('item_search_category') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div wire:loading wire:target="item_search_category">
                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                        <div class="la-ball-beat">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="seachByItemSubCategory">Sub Category</label>
                        <select class="form-control" id="seachItemBySubCategory" wire:model="item_search_subcategory">
                            <option value="">-Select-</option>
                            @foreach($itemSubCategories as $itemSubCategory)
                            <option value="{{$itemSubCategory->SubCategoryId}}">{{$itemSubCategory->Description}}</option>
                            @endforeach
                        </select>
                        @error('item_search_subcategory') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
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
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="seachByItemName">Items Name</label>
                        <input type="text" wire:model="item_search_name" name="" id="seachByItemName" class="form-control">
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="seachByItemSubmit"></label>
                        <button class=" mt-2 btn bg-gradient-info" wire:click="searchServiceItems">Search</button>
                    </div>
                </div>
                <div wire:loading wire:target="searchServiceItems">
                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                        <div class="la-ball-beat">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
            @if($showItemsSearchResults)
                <div class="row">
                    @forelse($serviceItemsList as $servicesItem)
                        <?php $itemPriceDetails = $servicesItem['priceDetails']; ?>
                        <?php $itemDiscountDetails = $servicesItem['discountDetails']; ?>
                        @if($itemPriceDetails->UnitPrice!=0)
                        <div class="col-md-4 col-sm-6">
                            <div class="card mt-2">
                                <div class="card-header text-center p-2">
                                    <p class="font-weight-normal mt-2 text-capitalize text-sm- font-weight-bold mb-0">
                                        {{strtolower($itemPriceDetails->ItemName)}}<small>({{$itemPriceDetails->ItemCode}})</small>
                                    </p>
                                    <h5 class="font-weight-bold mt-2"  @if($itemDiscountDetails != null) style="text-decoration: line-through;" @endif>
                                        <small>AED</small>{{custom_round($itemPriceDetails->UnitPrice)}}
                                    </h5>
                                    @if($itemDiscountDetails != null)
                                    <h5 class="font-weight-bold mt-2">
                                        <span class="text-secondary text-sm me-1">{{config('global.CURRENCY')}}</span>{{ custom_round($itemPriceDetails->UnitPrice-(($itemDiscountDetails->DiscountPerc/100)*$itemPriceDetails->UnitPrice)) }}
                                    </h5>
                                    @endif
                                    <div class="ms-auto">
                                        @if(!empty($qlItemDiscountDetails))
                                            <span class="badge bg-gradient-info">{{custom_round($qlItemDiscountDetails->DiscountPerc)}}%off</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body text-lg-left text-center p-2">
                                    <input type="number" class="form-control w-30 float-start" placeholder="Qty" wire:model.defer="ql_item_qty.{{$itemPriceDetails->ItemId}}" style="padding-left:5px !important;" />
                                    <a href="javascript:;" class="btn btn-icon bg-gradient-primary d-lg-block m-0 float-end p-2" wire:click="addtoCartItem('{{$itemPriceDetails->ItemCode}}','{{$itemDiscountDetails}}')">Buy Now<i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
                                    </a>
                                </div>
                                @if(@$serviceAddedMessgae[$itemPriceDetails->ItemCode])
                                    <div class="text-center">
                                        <span class="alert-icon"><i class="ni ni-like-2 text-success"></i></span>
                                        <span class="alert-text text-success"><strong>Success!</strong> Added serves!</span>
                                        <button type="button" class="btn-close text-success" data-bs-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    @empty
                        <div class="alert alert-danger text-white" role="alert"><strong>Empty!</strong> The Searched items are not in stock!</div>
                    @endforelse
                </div>
            @endif
        @endif

        @if($showPackageList)
            <div class="row mt-4">
                <div class="container">
                    <div class="tab-content tab-space">
                        <div class="tab-pane active" id="monthly" role="tabpanel" aria-labelledby="tabs-iconpricing-tab-1">
                            <div class="row" id="packageServiceListDiv">
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-lg-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-header text-center pt-4 pb-3">
                                            <span class="badge rounded-pill bg-light text-dark bg-light">Redeem Package</span>
                                            <h4>Booked Packags</h4>
                                        </div>
                                        <div class="card-body text-lg-start text-left pt-0">
                                            @if ($message = Session::get('package_success'))
                                            <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
                                                <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                                                <span class="alert-text"><strong>Success!</strong> {{ $message }}</span>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            @endif
                                            @if ($message = Session::get('package_error'))
                                            <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                                                <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                                                <span class="alert-text"><strong>Error!</strong> {{ $message }}</span>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            @endif
                                            @if($showPackageOtpVerify)
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 mb-4" >
                                                    <div class="card p-2 mb-4">
                                                        
                                                        <div class="card-body text-lg-left text-center pt-0">
                                                            <label for="packageOTPVerify">Package OTP Verify</label>
                                                            <div class="form-group">
                                                                <input type="numer" class="form-control" placeholder="Package OTP Verify..!" aria-label="Package OTP Verify..!" aria-describedby="button-addon4" id="packageOTPVerify" wire:model="package_otp">
                                                                <button class="btn btn-outline-success mb-0" type="button" wire:click="verifyPackageOtp">Verify</button>
                                                                <button class="btn btn-outline-info mb-0" type="button"  wire:click="resendPackageOtp">Resend</button>
                                                                <div wire:loading wire:target="verifyPackageOtp" >
                                                                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                                        <div class="la-ball-beat">
                                                                            <div></div>
                                                                            <div></div>
                                                                            <div></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div wire:loading wire:target="resendOtp" >
                                                                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                                        <div class="la-ball-beat">
                                                                            <div></div>
                                                                            <div></div>
                                                                            <div></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @error('package_otp') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                                            @if($package_otp_message)<span class="mb-4 text-danger">{{ $package_otp_message }}</span>@endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            @forelse($customerBookedPackages as $packBookd)
                                            <?php
                                            $packageBookedDateTime = new Carbon\Carbon($packBookd->package_date_time);
                                            $endPackageDateTime = $packageBookedDateTime->addMonth($packBookd->package_duration);
                                            ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card bg-cover text-center my-2" style="background-image: url('https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/curved-images/curved1.jpg')">
                                                        <div class="card-body z-index-2 py-2 text-center">
                                                            <span class="badge rounded-pill bg-light {{config('global.package.type')[$packBookd->package_type]['bg_class']}} {{config('global.package.type')[$packBookd->package_type]['text_class']}}">{{config('global.package.type')[$packBookd->package_type]['title']}}</span>
                                                            <h4 class="text-white">{{$packBookd->package_name}}</h4>
                                                            @if(\Carbon\Carbon::now()->diffInDays($endPackageDateTime, false)>=0)
                                                            <button  wire:click="openPackageDetails({{$packBookd}})" class="btn bg-gradient-primary mb-2 btn-sm">Open</button>
                                                            @else
                                                            <button class="btn bg-gradient-dark mb-2 btn-sm opacity-7">Expired</button>
                                                            @endif
                                                        </div>
                                                        @if(\Carbon\Carbon::now()->diffInDays($endPackageDateTime, false)>=0)
                                                        <div class="mask bg-gradient-info border-radius-lg"></div>
                                                        @else
                                                        <div class="mask bg-gradient-danger border-radius-lg"></div>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                                <span class="text-danger">empty..!</span>
                                            @endforelse
                                            <div wire:loading wire:target="openPackageDetails" >
                                                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                    <div class="la-ball-beat">
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group d-none">
                                                <input class="form-control" type="text" wire:model="package_number" id="redeemPackageNumber" placeholder="Redeem Package Number..!">
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                @foreach($servicePackages as $servicePackage)
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-lg-4 mb-4">
                                        <div class="card h-100" >
                                            <div class="card-header text-center pt-4 pb-3">
                                                <span class="badge rounded-pill bg-light gold_button text-white">{{$servicePackage->packageTypes['Description']}}</span>
                                                <h4>{{$servicePackage->PackageName}}</h4>
                                                @if($servicePackage->Duration)
                                                <p class="text-sm font-weight-bold text-dark mt-2 mb-0">Duration: {{$servicePackage->Duration}} Months</p>
                                                @endif
                                                @if($servicePackage->PackageKM)
                                                <p class="text-sm font-weight-bold text-dark">{{$servicePackage->PackageKM}} K.M</p>
                                                @endif
                                                
                                            </div>
                                            <div class="card-body text-lg-start text-left pt-0">
                                                <?php $totalPrice=0;?>
                                                <?php $unitPrice=0;?>
                                                <?php $discountedPrice=0;?>
                                                @foreach($servicePackage->packageDetails as $packageDetails)
                                                    @if($packageDetails->isDefault==1)
                                                    <div class="d-flex justify-content-lg-start p-2">
                                                        
                                                        <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                                            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                                                        </div>
                                                        <?php $totalPrice = $totalPrice+($packageDetails->TotalPrice*$packageDetails->Quantity); ?>
                                                        <?php $unitPrice = $unitPrice+($packageDetails->UnitPrice*$packageDetails->Quantity); ?>
                                                        <?php $discountedPrice = $discountedPrice+($packageDetails->DiscountedPrice*$packageDetails->Quantity); ?>
                                                        
                                                        <div>
                                                            @if($packageDetails->ItemType=='S')
                                                            <span class="ps-3">{{$packageDetails->Quantity}} x {{$packageDetails->labourItemDetails['ItemName']}}</span>
                                                            @else
                                                            <span class="ps-3">{{$packageDetails->inventoryItemDetails['ItemName']}}</span>
                                                            @endif
                                                            <p class="ps-3 h6"><small><s>AED {{$packageDetails->UnitPrice}}</s> {{$packageDetails->DiscountedPrice}}</small></p>
                                                        </div>
                                                    </div>
                                                    @endif  
                                                @endforeach
                                                <h3 class="text-default font-weight-bold mt-2"></h3>
                                                <p class="text-center h4"><s><small>AED</small> {{$unitPrice}}</s> <small>AED</small> {{$discountedPrice}}</p>
                                                <div class="text-center align-center">
                                                    <a href="javascript:;" class="btn btn-icon bg-gradient-dark d-lg-block mt-3 mb-0 " wire:click="packageContinue({{$servicePackage->Id}})"   wire:navigate>Continue<i class="fas fa-arrow-right ms-1" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                
                                <div wire:loading wire:target="packageContinue" >
                                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                        <div class="la-ball-beat">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                </div>
                                @if($showPackageAddons)
                                @include('components.modals.pckageAddOns')
                                @endif
                        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($showBundleList)
            <div class="row mt-4">
                <div class="container">
                    <div class="tab-content tab-space">
                        <div class="tab-pane active" id="monthly" role="tabpanel" aria-labelledby="tabs-iconpricing-tab-1">
                            <div class="row mb-4" id="bundleServiceListDiv">
                                @foreach($bundlleLists as $bundlle)
                                    @if(count($bundlle->bundlesDetails)>0)
                                    <div class="col-md-4 col-sm-4 mb-4">
                                        <div class="card card-profile card-plain cursor-pointer" wire:click="openBundleListDetails('{{$bundlle}}')">
                                            <div class="card-body text-center bg-white shadow border-radius-lg p-3">
                                                <a href="javascript:;" class="d-none">
                                                    <img class="w-100 border-radius-md" src="./assets/img/kit/pro/anastasia.jpg">
                                                </a>
                                                <h5 class="mt-3 mb-3 text-danger text-gradient text-uppercase">{{$bundlle->Description}}</h5>
                                                
                                                <button type="button" class="btn btn-warning btn-sm"   wire:click="openBundleListDetails('{{$bundlle}}')">Open</button>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                                
                                <div wire:loading wire:target="openBundleListDetails" >
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

        @if($showPackageServiceSectionsList)
            <!-- Modal -->
            <style type="text/css">
                .modal-body{
                    max-height: calc(100vh - 300px);
                    overflow-y: auto;
                }
            </style>
            <div class="modal fade" id="servicePackagePriceModal" tabindex="-1" role="dialog" aria-labelledby="servicePackagePriceModalLabel" aria-hidden="true" wire:ignore.self style="z-index:99999;" >
                <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:90%;">
                    <div class="modal-content">
                        
                        <div class="modal-header">
                            <h5 class="modal-title" id="servicePackagePriceModalLabel">{{$selectedSectionName}}</h5>
                            <input type="text" class="form-control w-30" name="" wire:model="section_service_search">
                            <div wire:loading wire:target="section_service_search">
                                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                    <div class="la-ball-beat">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn-close text-dark " style="font-size: 2.125rem !important;" data-bs-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true" class="text-xl">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body py-0">
                            <div class="row">
                                @forelse($sectionPackageServiceLists as $sectionServiceList)
                                <?php $priceDetails = $sectionServiceList['priceDetails']; ?>
                                <?php $package_quantity = $sectionServiceList['package_quantity']; ?>
                                <?php $package_quantity_used = $sectionServiceList['package_quantity_used']; ?>
                                <?php $discountDetails = $sectionServiceList['discountDetails']; ?>
                                @if($priceDetails->UnitPrice!=0)
                                <div class="col-md-6 col-sm-6">
                                    
                                    <div class="bg-gray-100 shadow my-3 p-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <p class="text-sm text-center font-weight-bold text-dark">{{$priceDetails->ItemCode}} - {{$priceDetails->ItemName}}</p>
                                                <!-- <textarea style="padding-left: 5px !important;" class="form-control" placeholder="Notes..!" wire:model="extra_note.{{$priceDetails->ItemId}}"></textarea > -->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="d-flex border-radius-lg p-0 mt-2">
                                                    <p class="w-100 text-md font-weight-bold text-dark my-auto me-2 float-start">
                                                        <span class="float-start" @if($discountDetails != null) style="text-decoration: line-through;" @endif>
                                                            <span class=" text-sm me-1">{{config('global.CURRENCY')}}</span> {{custom_round($priceDetails->UnitPrice)}}
                                                        </span>
                                                        @if($discountDetails != null)
                                                        <span  class="float-end">
                                                            <span class=" text-sm me-1">{{config('global.CURRENCY')}}</span> {{ custom_round($priceDetails->UnitPrice-(($discountDetails['DiscountPerc']/100)*$priceDetails->UnitPrice)) }}
                                                        </span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="d-flex border-radius-lg p-0 mt-2">
                                                    @if($package_quantity==$package_quantity_used)
                                                        <span class="badge bg-gradient-danger">Package Used</span>
                                                    @else
                                                        @if($discountDetails != null)
                                                        <span class="badge bg-gradient-info">{{custom_round($discountDetails['DiscountPerc'])}}%off</span>
                                                        @endif
                                                        <a href="javascript:;" class="btn bg-gradient-primary mb-0 ms-auto btn-sm"  wire:click="addtoCartPackage('{{$priceDetails}}','{{$discountDetails}}')">Add Now</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @if(@$serviceAddedMessgae[$priceDetails->ItemCode])
                                        <div class="text-center">
                                            <span class="alert-icon"><i class="ni ni-like-2 text-success"></i></span>
                                            <span class="alert-text text-success"><strong>Success!</strong> Added serves!</span>
                                            <button type="button" class="btn-close text-success" data-bs-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        @endif

                                    </div>
                                </div>
                                @endif
                                @empty
                                @endforelse
                                <div wire:loading wire:target="addtoCart">
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
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" class="btn bg-gradient-primary">Save changes</button> -->
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        @if($showBundleServiceSectionsList)
            @include('components.modals.bundleListing')
        @endif
        
        @if($showDiscountDroup)
            @include('components.modals.discountGroups')
        @endif

        @if($showAddMakeModelNew)
            @include('components.modals.addMakeModelNew')
        @endif

        <div wire:loading wire:target="addtoCartItem">
            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                <div class="la-ball-beat">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>

        <div wire:loading wire:target="addMakeModel">
            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                <div class="la-ball-beat">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
    </div>
</main>
@push('custom_script')

<script type="text/javascript">
    
    window.addEventListener('openServicesListModal',event=>{
        $('#servicePriceModal').modal('show');
    });
    window.addEventListener('closeServicesListModal',event=>{
        $('#servicePriceModal').modal('hide');
    });

    window.addEventListener('openBundleServicesListModal', event=>{
        $('#bundlePriceModelList').modal('show');
    });
    window.addEventListener('closeBundleServicesListModal', event=>{
        $('#bundlePriceModelList').modal('hide');
    });

    window.addEventListener('openServicesPackageListModal',event=>{
        $('#servicePackagePriceModal').modal('show');
    });
    window.addEventListener('closeServicesPackageListModal',event=>{
        $('#servicePackagePriceModal').modal('hide');
    });

    window.addEventListener('selectSearchEvent',event=>{
        $(document).ready(function () {

            $('#plateEmirates').on('change', function (e) {
                var plateStateVal = $('#plateEmirates').val();
                @this.set('plate_state', plateStateVal);
            });
            $('#vehicleTypeInput').on('change', function (e) {
                var vehicleTypeVal = $('#vehicleTypeInput').val();
                @this.set('vehicle_type', vehicleTypeVal);
            });
            $('#vehicleMakeInput').on('change', function (e) {
                var makeVal = $('#vehicleMakeInput').val();
                @this.set('make', makeVal);
            });
            $('#vehicleModelInput').on('change', function (e) {
                var modelVal = $('#vehicleModelInput').val();
                @this.set('model', modelVal);
            });
            $('#plateCode').on('change', function (e) {
                var stateCodeVal = $('#plateCode').val();
                @this.set('plate_code', stateCodeVal);
            });

            $('#seachItemByCategory').on('change', function (e) {
                var catVal = $('#seachItemByCategory').val();
                @this.set('item_search_category', catVal);
            });
            $('#seachItemBySubCategory').on('change', function (e) {
                var subCatVal = $('#seachItemBySubCategory').val();
                @this.set('item_search_subcategory', subCatVal);
            });
            $('#seachByItemBrand').on('change', function (e) {
                var BrandVal = $('#seachByItemBrand').val();
                @this.set('item_search_brand', BrandVal);
            });

            $('#qlSeachByBrand').on('change', function (e) {
                var BrandVal = $('#qlSeachByBrand').val();
                @this.set('ql_search_brand', BrandVal);
            });
        });
    });

    
    window.addEventListener('openDiscountGroupModal',event=>{
        $('#discountGroupModal').modal('show');
    });
    window.addEventListener('closeDiscountGroupModal',event=>{
        $('#discountGroupModal').modal('hide');
    });

    window.addEventListener('openAddMakeModel', event=>{
        $('#addMakeModelModel').modal('show');
    });
    window.addEventListener('closeAddMakeModel', event=>{
        $('#addMakeModelModel').modal('hide');
    });

    window.addEventListener('scrolltopQl',event=>{
        $(document).ready(function(){
            $('html, body').animate({
                scrollTop: $("#serviceQlItems").offset().top - 100
            }, 100);
        });
    });

</script>
@endpush