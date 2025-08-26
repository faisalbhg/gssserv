<div class="card px-3 my-2" >
                <div class="card-body p-0">
                    @if($selectedVehicleInfo->customerInfoMaster['Paymethod']!=2)
                    @if($searchByMobileNumber)
                        <div class="row">
                            @if($showByMobileNumber)
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="mobilenumberInput">Mobile Number </label>
                                        <div class="input-group mb-0">
                                            <span class="input-group-text px-0">+971</span>
                                            <input  type="number" class="form-control @error('mobile') btn-outline-danger @enderror" placeholder="Mobile Number" aria-label="Mobile Number" aria-describedby="button-MobileSearch" wire:model="mobile"  name="mobile" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" minlength="1" maxlength="10" id="mobilenumberInput" >
                                        </div>
                                        @error('mobile') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            @endif
                            @if ($showCustomerForm)
                                <div class="col-md-6  col-sm-6">
                                    <div class="form-group openDiv">
                                        <label for="nameInput">Name</label>
                                        <input type="text" class="form-control @error('name') btn-outline-danger @enderror" wire:model.defer="name" name="name" placeholder="Name" id="nameInput">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group openName">
                                        <label for="emailInput">Email</label>
                                        <input type="email" wire:model.defer="email" name="email" class="form-control @error('email') btn-outline-danger @enderror" id="emailInput" placeholder="Email">
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                    @endif
                    @if($showPlateNumber)
                        <div class="row">
                            <div class="col-md-2 col-sm-3">
                                <label for="plateImageFile" >Plate Image</label>
                                <div 
                                    x-data="{ isUploading: false, progress: 0 }"
                                    x-on:livewire-upload-start="isUploading = true"
                                    x-on:livewire-upload-finish="isUploading = false; progress = 0"
                                    x-on:livewire-upload-error="isUploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress"
                                    class=""
                                >
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-icon btn-2 btn-primary float-start mb-0" id="plateImage" type="button">
                                                <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- File Input -->
                                    <input type="file" id="plateImageFile" wire:model="plate_number_image" class="mb-2" accept="image/*" capture style="display: none;">

                                    <!-- Progress Bar -->
                                    <div x-show="isUploading" class="w-100">
                                        <div class="btn bg-gradient-info h-1 rounded-full pt-1 mt-1" :style="'width: ' + progress + '%'"></div>
                                    </div>

                                    <!-- Preview (if image) -->
                                    @if ($plate_number_image)
                                        <img src="{{ $plate_number_image->temporaryUrl() }}" class="img-fluid border-radius-lg w-50">
                                    @endif
                                    
                                    @error('plate_number_image') <div class="text-red-500 text-sm">Plate number image is required..!</div>  @enderror
                                </div>

                            </div>
                            <div class="col-md-5 col-sm-6">
                                <div class="form-group">
                                    <label for="plateCountry">Country</label>
                                    <select class="form-control chosen-select" wire:model="plate_country"  id="plateCountry" name="plate_country" aria-invalid="false"><option value="">Select</option>
                                        @foreach(config('global.country') as $country)
                                        <option value="{{$country['CountryCode']}}">{{$country['CountryName']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-6">
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
                            <div class="col-md-2 col-sm-4">
                                <div class="form-group">
                                    <label  for="platNumberRequired">Plate Number</label>
                                    <div class="form-check form-switch mt-1">
                                        <input class="form-check-input" type="checkbox" id="platNumberRequired" wire:model="numberPlateRequired">
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-6">
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
                            
                            <div class="col-md-5 col-sm-6">
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
                            <div class="col-md-2 col-sm-4">
                                <label for="vehicleImageFile">Vehicle Image</label>
                                <div 
                                    x-data="{ isUploading: false, progress: 0 }"
                                    x-on:livewire-upload-start="isUploading = true"
                                    x-on:livewire-upload-finish="isUploading = false; progress = 0"
                                    x-on:livewire-upload-error="isUploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress"
                                    class=""
                                >
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-icon btn-2 btn-primary float-start mb-0" id="vehicleImage" type="button">
                                                <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- File Input -->
                                    <input type="file" id="vehicleImageFile" wire:model="vehicle_image" class="mb-2" accept="image/*" capture style="display: none;">
                                    
                                    <!-- Progress Bar -->
                                    <div x-show="isUploading" class="w-100">
                                        <div class="btn bg-gradient-info h-1 rounded-full pt-1 mt-1" :style="'width: ' + progress + '%'"></div>
                                    </div>

                                    <!-- Preview (if image) -->
                                    @if ($vehicle_image)
                                        <img src="{{ $vehicle_image->temporaryUrl() }}" class="img-fluid border-radius-lg w-50">
                                    @endif
                                    @error('vehicle_image') <span class="text-danger">Vehicle picture required..!</span> @enderror
                                </div>

                            </div>
                            <div class="col-md-5 col-sm-6">
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
                            <div class="col-md-5 col-sm-6">
                                <div class="form-group">
                                    <label for="vehicleKmInput">K.M Reading</label>
                                    <input type="number" class="form-control" id="vehicleKmInput" wire:model="vehicle_km" name="vehicle_km" placeholder="Chaisis Number">
                                </div>
                            </div>

                            <div class="col-md-2 col-sm-4">
                                <label for="AddVehicleMakeInput mb-2"></label>
                                <div class="form-group">
                                    <button type="button" wire:click="addMakeModel()" class="btn btn-info btn-sm mt-2 p-1" id="AddVehicleMakeInput">Add Make/Model</button>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-6">
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
                            <div class="col-md-5 col-sm-6">
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
                            
                        </div>
                    @endif

                    @if($searchByChaisisForm)
                        <div class="row">
                            <div class="col-md-2 col-sm-4">
                                <label for="chaisisImageFile">Chaisis Picture</label>
                                <div 
                                    x-data="{ isUploading: false, progress: 0 }"
                                    x-on:livewire-upload-start="isUploading = true"
                                    x-on:livewire-upload-finish="isUploading = false; progress = 0"
                                    x-on:livewire-upload-error="isUploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress"
                                    class=""
                                >
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-icon btn-2 btn-primary float-start mb-0" id="chaisisImage" type="button">
                                                <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- File Input -->
                                    <input type="file" id="chaisisImageFile" wire:model="chaisis_image" class="mb-2" accept="image/*" capture style="display: none;">

                                    <!-- Progress Bar -->
                                    <div x-show="isUploading" class="w-100">
                                        <div class="btn bg-gradient-info h-1 rounded-full pt-1 mt-1" :style="'width: ' + progress + '%'"></div>
                                    </div>

                                    <!-- Preview (if image) -->
                                    @if ($chaisis_image)
                                        <img src="{{ $chaisis_image->temporaryUrl() }}" class="img-fluid border-radius-lg w-50">
                                    @endif
                                    @error('chaisis_image') <span class="text-danger">Chaisis picture is required..!</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-10 col-sm-8">
                                <div class="form-group">
                                    <label for="chaisisNumberInput">Chaisis Number</label>
                                    <input type="text" class="form-control" id="chaisisNumberInput" wire:model="chassis_number" name="chassis_number" placeholder="Chassis Number">
                                </div>
                            </div>
                        </div>
                        @endif

                    <div class="row mt-4">
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