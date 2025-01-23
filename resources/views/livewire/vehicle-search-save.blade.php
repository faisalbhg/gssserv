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

        <div class="d-flex mt-0 mb-3 mx-0">
            <div class=" d-flex">
                <h5 class="mb-1 text-gradient text-dark">
                    <a href="javascript:;">Search By: </a>
                </h5>
                <div class="px-2 position-relative ">
                    <button wire:click="clickSearchBy('1')" class="btn @if($searchByMobileNumberBtn) bg-gradient-primary @else bg-gradient-default @endif  mb-0" data-toggle="modal" data-target="#new-board-modal">
                        Mobile Number
                    </button>
                    <hr class="vertical dark mt-2">
                </div>
                <div class="px-2 position-relative ">
                    <button wire:click="clickSearchBy('2')" class="btn @if($searchByPlateBtn) bg-gradient-primary @else bg-gradient-default @endif mb-0" data-toggle="modal" data-target="#new-board-modal">
                        Plate Number
                    </button>
                    <hr class="vertical dark mt-2">
                </div>
                <div class="px-2">
                    <button wire:click="clickSearchBy('3')" class="btn @if($searchByChaisisBtn) bg-gradient-primary @else bg-gradient-default @endif mb-0" data-toggle="modal" data-target="#new-board-modal">
                        Chaisis Number
                    </button>
                </div>

                <div wire:loading wire:target="clickSearchBy">
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
        

        <!--Customer Search Save Pannel-->
        @if($showForms)
            <div class="card px-3 my-2" >
                <div class="card-body p-0">
                    @if($searchByMobileNumber)
                        <div class="row">
                            @if($showByMobileNumber)
                                <div class="col-md-4 col-sm-6">
                                    <label for="mobilenumberInput">Mobile Number </label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" placeholder="Mobile Number" aria-label="Mobile Number" aria-describedby="button-MobileSearch" wire:model="mobile"  name="mobile" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" minlength="1" maxlength="10" id="mobilenumberInput" style="padding-left:10px !important;">
                                        <button wire:click="searchResult" class="btn btn-outline-primary mb-0" type="button" id="button-MobileSearch">Search</button>
                                        <div wire:loading wire:target="searchResult">
                                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                <div class="la-ball-beat">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @error('mobile') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
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
                    @endif
                    @if($showPlateNumber)
                        <div class="row">
                            <div class="col-2">
                                <label for="plateImageFile" >Plate Image</label>
                                <div  x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"  x-on:livewire-upload-finish="isUploading = false"  x-on:livewire-upload-error="isUploading = false"  x-on:livewire-upload-progress="progress = $event.detail.progress" >
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <button class="btn btn-icon btn-2 btn-primary float-start" id="plateImage" type="button">
                                                <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- File Input -->
                                    <input type="file" id="plateImageFile" wire:model="plate_number_image" accept="image/*" capture style="display: none;" />
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
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <button class="btn btn-icon btn-2 btn-primary float-start" id="vehicleImage" type="button">
                                                <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- File Input -->
                                    <input type="file" id="vehicleImageFile" wire:model="vehicle_image" accept="image/*" capture style="display: none;" />
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
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <button class="btn btn-icon btn-2 btn-primary float-start" id="chaisisImage" type="button">
                                                <span class="btn-inner--icon"><i class="fa-solid fa-camera fa-xl text-white"></i></span>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- File Input -->
                                    <input type="file" id="chaisisImageFile" wire:model="chaisis_image" accept="image/*" capture style="display: none;" />
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
                                <!--wire:click="selectVehicle({{$customer->TenantId}}, {{$customer->id}})"-->
                                <div class="col-xl-3 col-md-4 col-sm-6 mb-xl-0 my-4">
                                    <a href="{{url('customer-service-job/'.$customer->customer_id.'/'.$customer->id)}}"  class="">
                                        <div class="card card-background move-on-hover">
                                            <div class="full-background" style="background-image: url('{{url("public/storage/".$customer->vehicle_image)}}')"></div>
                                            <div class="card-body pt-5">
                                                <h4 class="text-white mb-0 pb-0">
                                                    @if($customer->customerInfoMaster['TenantName'])
                                                        {{$customer->customerInfoMaster['TenantName']}}
                                                    @else
                                                    Guest
                                                    @endif
                                                </h4>
                                                <p class="mt-0 pt-0"><small>{{$customer->customerInfoMaster['Email']}}, {{$customer->customerInfoMaster['Mobile']}}</small></p>
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
    </div>
</main>

@push('custom_script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    window.addEventListener('mobile0Remove',event=>{
        $("#mobilenumberInput").on("input", function() {
            if (/^0/.test(this.value)) {
                this.value = this.value.replace(/^0/, "")
            }
        });
    });
    window.addEventListener('selectSearchEvent',event=>{
        $(document).ready(function () {
            $('#plateState').select2();
            $('#vehicleTypeInput').select2();
            $('#vehicleMakeInput').select2();
            $('#vehicleModelInput').select2();
            $('#plateCode').select2();

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
            $('#plateCode').on('change', function (e) {
                var stateCodeVal = $('#plateCode').select2("val");
                @this.set('plate_code', stateCodeVal);
            });
        });
    });

    
</script>

<script type="text/javascript">
    
    window.addEventListener('imageUpload',event=>{
        $('#vehicleImage').click(function(){
            $("#vehicleImageFile").trigger('click');
        });
        $('#plateImage').click(function(){
            $("#plateImageFile").trigger('click');
        });
        $('#chaisisImage').click(function(){
            $("#chaisisImageFile").trigger('click');
        });

        
    });
    let file = document.querySelector('input[type="file"]').files[0];
    // Upload a file:
    @this.upload('plate_number_image', file, (uploadedFilename) => {
        // Success callback.
    }, () => {
        // Error callback.
    }, (event) => {
        // Progress callback.
        // event.detail.progress contains a number between 1 and 100 as the upload progresses.
    });

    let file1 = document.querySelector('input[type="file"]').files[0];
    // Upload a file:
    @this.upload('vehicle_image', file1, (uploadedFilename) => {
        // Success callback.
    }, () => {
        // Error callback.
    }, (event) => {
        // Progress callback.
        // event.detail.progress contains a number between 1 and 100 as the upload progresses.
    });

    // Upload a file:
    @this.upload('chaisis_image', file, (uploadedFilename) => {
        // Success callback.
    }, () => {
        // Error callback.
    }, (event) => {
        // Progress callback.
        // event.detail.progress contains a number between 1 and 100 as the upload progresses.
    });

    window.addEventListener('mobile0Remove',event=>{
        $("#mobilenumberInput").on("input", function() {
            if (/^0/.test(this.value)) {
                this.value = this.value.replace(/^0/, "")
            }
        });
    });
</script>

@endpush
