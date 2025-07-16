@push('custom_css')
<style type="text/css">
 
:root {
    --m1-tabs-bg: #e1e1e1;
    --m1-tab-text: #888;
    --m1-tab-bg: #f7f7f7;
    --m1-tab-hover-text: #ffc107;
    --m1-tab-hover-bg: #fff;
    --m1-tab-active-text: #fff;
    --m1-tab-active-bg: #ffc107;
}

.tab-content .tab-pane {
    margin: 0;
    padding: 0.2em 0;
    color: rgba(40,44,42,0.05);
    font-weight: 900;
    font-size: 4em;
    line-height: 1;
    text-align: center;
}

#model_1 .tabs-container {
    /*background: var(--m1-tabs-bg);*/
}
#model_1 .nav-tabs {
    text-align: center;
    border-bottom: 3px solid #ccc;
    display: -ms-flexbox;
    display: -webkit-flex;
    display: -moz-flex;
    display: -ms-flex;
    display: flex;
}
#model_1 .nav .nav-item {
    text-align: center;
    -webkit-flex: 1;
    -moz-flex: 1;
    -ms-flex: 1;
    flex: 1;
}
#model_1 .nav .nav-link {
    background-color: var(--m1-tab-bg);
    color: var(--m1-tab-text);
    transition: background-color 0.2s, color 0.2s;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    line-height: 2.5;
    border: 0;
    border-radius: 0;
    outline: none;
} 
#model_1 .nav .nav-link:hover {
    background-color: var(--m1-tab-hover-bg);
    color: var(--m1-tab-hover-text);
}
#model_1 .nav .nav-link.active,
#model_1 .nav .nav-link.active:hover {
    background: var(--m1-tab-active-bg);
    color: var(--m1-tab-active-text);
}
#model_1 .nav i {
    display: inline-block;
    margin: 0 0.4em 0 0;
    vertical-align: middle;
    text-transform: none;
    font-size: 1.3em;
    line-height: 1;
    speak: none;
    -webkit-backface-visibility: hidden;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}


</style>
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
        <section id="model_1" class="mb-4">      
            <div class="tabs-container">
                <ul class="nav nav-tabs container mx-0  pe-0" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link @if($showWalkingCustomerPanel) active shadow @endif text-uppercase font-weight-bolder" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true" wire:click="customerPanelTab('1')"><i class="fa fa-user"></i>Walking Customer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if($showContractCustomerPanel) active shadow @endif text-uppercase font-weight-bolder" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false" wire:click="customerPanelTab('2')"><i class="fa fa-home"></i>Contract / Credit Customer</a>
                    </li>
                    
                </ul>
            </div>
        </section>

        <div class="d-flex mt-0 mb-3 mx-0">
            <div class=" d-flex">
                <!-- <h5 class="mb-1 text-gradient text-dark">
                    <a href="javascript:;">Search By: </a>
                </h5> -->
                @if($showWalkingCustomerPanel)
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
                
                @endif
                <!-- <div class="px-2">
                    <button wire:click="clickSearchBy('4')" class="btn @if($searchByContractBtn) bg-gradient-primary @else bg-gradient-default @endif mb-0" data-toggle="modal" data-target="#new-board-modal">
                        Contract/Credit  Customer
                    </button>
                </div> -->

                <div wire:loading wire:target="clickSearchBy">
                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                        <div class="la-ball-beat">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>
                <div wire:loading wire:target="customerPanelTab">
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
                    
                    @if($showSearchContractCustomers)
                        <div class="row p-4">
                            <div class="col-md-6 col-sm-6">
                                <label for="saveContractCustomerNameButton">Contract Customer</label>
                                <div class="form-group">
                                    <select class="form-control chosen-select" wire:model="contract_customer_id"  name="contract_customer_id" id="contractCustomerNameInput" style="padding-left:10px !important;">
                                        <option value="">-Select Contract Customers--</option>
                                        @foreach($contractCustomersList as $contractCustomer)
                                        <option value="{{$contractCustomer->TenantId}}">{{$contractCustomer->TenantName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('contract_customer_id') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                            </div>
                        
                        @if($showSaveContractCustomerVehicle)
                            
                                <div class="col-md-6 col-sm-6">
                                    <label for="saveContractCustomerNameButton"></label>
                                    <div class="input-group mt-1">
                                        <button type="button" wire:click="searchContractCustomerVehicle()" class="btn btn-warning btn-sm" id="searchContractVehicleButton">Search Vehicle</button>
                                        <button type="button" wire:click="saveContractVehicle()" class="btn btn-info btn-sm" id="saveContractCustomerNameButton">Add New Vehicle</button>
                                        <div wire:loading wire:target="searchContractCustomerVehicle">
                                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                <div class="la-ball-beat">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:loading wire:target="saveContractVehicle">
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

                    @if($searchByMobileNumber)
                        <div class="row">
                            @if($showByMobileNumber)
                                <div class="col-md-6 col-sm-4">
                                    <label for="mobilenumberInput">Mobile Number </label>
                                    <div class="input-group mb-3"  >
                                        <input  type="number" class="form-control @error('mobile') btn-outline-danger @enderror" placeholder="Mobile Number" aria-label="Mobile Number" aria-describedby="button-MobileSearch" wire:model="mobile"  name="mobile" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" minlength="1" maxlength="10" id="mobilenumberInput" style="padding-left:10px !important;">
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
                                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 d-none">
                                    <div class="form-group openName mt-4 mb-0">
                                        <label class="mt-2"></label>
                                        <button type="button" wire:click="saveCustomerOnly()" class="btn btn-primary btn-sm mt-2">Save Customer Only</button>
                                        <div wire:loading wire:target="saveCustomerOnly">
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

                    @if($showPlateNumber)
                        <div class="row">
                            <div class="col-md-3 col-sm-3">
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
                                    <input type="file" id="plateImageFile" wire:model="plate_number_image" accept="image/*" capture style="display: block;" class="@error('plate_number_image') btn-outline-danger @enderror" />
                                    <!-- Progress Bar -->
                                    <div x-show="isUploading">
                                        <progress max="100" x-bind:value="progress"></progress>
                                    </div>
                                </div>
                                @if ($plate_number_image)
                                    <img class="img-fluid border-radius-lg w-30" src="{{ $plate_number_image->temporaryUrl() }}">
                                @endif
                            </div>
                            <div class="col-md-5 col-sm-5">
                                <div class="form-group">
                                    <label for="plateCountry">Country</label>
                                    <select class="form-control chosen-select" wire:model="plate_country"  id="plateCountry" name="PlateCountry" aria-invalid="false"><option value="">Select</option>
                                        @foreach($countryList as $country)
                                        <option value="{{$country->CountryCode}}">{{$country->CountryName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if(!$this->otherCountryPlateCode)
                            <div class="col-md-4 col-sm-4">
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
                            <div class="col-md-4 col-sm-4 d-none">
                                <div class="form-group">
                                    <label for="plateCategory">Plate Category</label>
                                    <select class="form-control" wire:model="plate_category" name="plate_category" id="plateCategory" style="padding:0.5rem 0.3rem !important;" >
                                        <option value="">-Category-</option>
                                        @foreach($plateEmiratesCategories as $category)
                                        <option value="{{$category->plateCategoryId}}">{{$category->plateCategoryTitle}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-3">
                                <div class="form-group">
                                    <label for="plateCode">Plate Code</label>
                                    <select class="form-control chosen-select @error('plate_code') btn-outline-danger @enderror" wire:model="plate_code" name="plateCode" id="plateCode" style="padding:0.5rem 0.3rem !important;" >
                                        <option value="">-Code-</option>
                                        @foreach($plateEmiratesCodes as $plateCode)
                                        <option value="{{$plateCode->plateColorTitle}}">{{$plateCode->plateColorTitle}}</option>
                                        @endforeach
                                    </select>
                                    @error('plate_code') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            @else
                            <div class="col-md-4 col-sm-3">
                                <div class="form-group">
                                    <label for="plateCodeOthCountry">Plate Code</label>
                                    <input type="text" class="form-control" wire:model="plate_code" name="plateCode" id="plateCodeOthCountry" placeholder="Plate Code" style="padding:0.5rem 0.3rem !important;" />
                                </div>
                                @error('plate_code') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                            </div>
                            @endif
                            <div class="col-md-5 col-sm-5">
                                <div class="form-group">
                                    <label for="plateNumber">Plate Number</label>
                                    <input style="padding:0.5rem 0.3rem !important;" type="number" id="plateNumber" class="form-control @error('plate_number') btn-outline-danger @enderror" wire:model="plate_number" name="plate_number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" minlength="1" maxlength="6" placeholder="Number">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="plateNumber"></label>
                                    <div class="form-check form-switch mt-1">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" wire:model="numberPlateRequired">
                                        <label class="form-check-label" for="flexSwitchCheckDefault">Plate Number Required</label>
                                    </div>
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
                            <div class="col-md-2 col-sm-3">
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
                                    <input type="file" id="vehicleImageFile" wire:model="vehicle_image" accept="image/*" capture style="display: block;" class="" />
                                    <!-- Progress Bar -->
                                    <div x-show="isUploading">
                                        <progress max="100" x-bind:value="progress"></progress>
                                    </div>
                                </div>
                                @if ($vehicle_image)
                                <img class="img-fluid border-radius-lg w-30" src="{{ $vehicle_image->temporaryUrl() }}">
                                @endif
                                @error('vehicle_image') <span class="text-danger">Vehicle Picture Required</span> @enderror
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
                            <div class="col-md-3 col-sm-4">
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
                            <div class="col-md-3 col-sm-4">
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
                            <div class="col-md-3 col-sm-4">
                                <div class="form-group">
                                    <label for="vehicleKmInput">K.M Reading</label>
                                    <input type="number" class="form-control" id="vehicleKmInput" wire:model="vehicle_km" name="vehicle_km" placeholder="Chaisis Number">
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($searchByChaisisForm)
                        <div class="row">
                            <div class="col-md-3 col-sm-3">
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
                            <div class="col-md-9 col-sm-9">
                                <div class="form-group">
                                    <label for="chaisisNumberInput">Chaisis Number</label>
                                    <input type="text" class="form-control" id="chaisisNumberInput" wire:model="chassis_number" name="chassis_number" placeholder="Chassis Number">
                                </div>
                                @error('chassis_number') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        @if($showSearchByChaisisButton)
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" wire:click="clickSearchByChaisisNumber()" class="btn btn-primary btn-sm">Search By Chaisis Number</button>
                                    <button type="button" wire:click="saveByPlateNumber()" class="btn btn-info btn-sm">Save Plate Number</button>
                                </div>
                            </div>
                            <div wire:loading wire:target="clickSearchByChaisisNumber">
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

                    <div class="row">
                        <div class="col-md-12">
                            @if($updateVehicleFormBtn)
                            <button type="button" wire:click="updateVehicleCustomer()" class="btn btn-primary btn-sm">Update Vehicle</button>
                            <div wire:loading wire:target="updateVehicleCustomer">
                                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                    <div class="la-ball-beat">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($addVehicleFormBtn)
                            <button type="button" wire:click="addNewCustomerVehicle()" class="btn btn-primary btn-sm">Save Vehicle</button>
                            <div wire:loading wire:target="addNewCustomerVehicle">
                                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                    <div class="la-ball-beat">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($cancelEdidAddFormBtn)
                            <button type="button" wire:click="closeUpdateVehicleCustomer()" class="btn btn-default btn-sm">cancel</button>
                            <div wire:loading wire:target="closeUpdateVehicleCustomer">
                                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                    <div class="la-ball-beat">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($showSaveCustomerButton)
                            <button type="button" wire:click="saveVehicleCustomer()" class="btn btn-primary btn-sm">Save Vehicle</button>
                            <div wire:loading wire:target="saveVehicleCustomer">
                                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                    <div class="la-ball-beat">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($showSaveCustomerVehicleOnly)
                            <button type="button" wire:click="saveContractCustomerVehicle()" class="btn btn-primary btn-sm">Save Contract Vehicle</button>
                            <div wire:loading wire:target="saveContractCustomerVehicle">
                                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                    <div class="la-ball-beat">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </div>
                            </div>
                            @endif
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
                                <span wire:target="nothing('unique_id')" wire:loading>
                                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                        <div class="la-ball-beat">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                </span>
                                @foreach($customers as $customer)
                                <div class="col-xl-3 col-md-4 col-sm-6 mb-xl-0 my-4">
                                    <a href="{{url('customer-service-job/'.$customer->customer_id.'/'.$customer->id)}}"  wire:click="nothing('unique_id')" wire:navigate>
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
                                                <p>
                                                    {{$customer->plate_number_final}}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        
    </div>
    <div wire:loading wire:target="saveByPlateNumber">
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
    @if($showAddMakeModelNew)
    @include('components.modals.addMakeModelNew')
    @endif
</main>

@push('custom_script')


<script type="text/javascript">
    window.addEventListener('mobile0Remove',event=>{
        $("#mobilenumberInput").on("input", function() {
            if (/^0/.test(this.value)) {
                this.value = this.value.replace(/^0/, "")
            }
        });
    });
    window.addEventListener('openAddMakeModel', event=>{
        $('#addMakeModelModel').modal('show');
    });
    window.addEventListener('closeAddMakeModel', event=>{
        $('#addMakeModelModel').modal('hide');
    });
    
    window.addEventListener('selectSearchEvent',event=>{
        $(document).ready(function () {
            //$('#plateCountry').select2();
            //$('#plateEmirates').select2();
            //$('#vehicleTypeInput').select2();
            //$('#vehicleMakeInput').select2();
            //$('#vehicleModelInput').select2();
            //$('#plateCode').select2();
            //$('#contractCustomerNameInput').select2();
            $('#contractCustomerNameInput').on('change', function (e) {
                var contractCustomerVal = $('#contractCustomerNameInput').val();
                @this.set('contract_customer_id', contractCustomerVal);
            });
            $('#plateCountry').on('change', function (e) {
                var plateCountryVal = $('#plateCountry').val();
                @this.set('plate_country', plateCountryVal);
            });
            $('#plateEmirates').on('change', function (e) {
                var plateStateVal = $('#plateEmirates').val();
                @this.set('plate_state', plateStateVal);
            });
            $('#plateCode').on('change', function (e) {
                var stateCodeVal = $('#plateCode').val();
                @this.set('plate_code', stateCodeVal);
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

    
</script>

@endpush
