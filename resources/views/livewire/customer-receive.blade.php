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


.dropdown-list {
  background: #eee;
  position: absolute;
  max-height: 200px;
  overflow-y: auto;
  border: 1px solid #ccc;
  border-top: none;
  border-radius: 0 0 4px 4px;
}


.dropdown-list li {
  padding: 8px;
  cursor: pointer;
}

.dropdown-list li:hover {
  background-color: #f0f0f0;
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
            <span class="alert-text"><strong>Alert!</strong> {{ $message }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        @endif
        <section id="model_1" class="d-none mb-4">      
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
                @if($showWalkingCustomerPanel)
                <div class="px-2 position-relative ">
                    <button wire:click="clickSearchBy('1')" class="btn @if($searchByCustomer) bg-gradient-primary @else bg-gradient-default @endif  mb-0" data-toggle="modal" data-target="#new-board-modal">
                        Search Customer
                    </button>
                    
                </div>
                <div class="px-2 position-relative ">
                    <button wire:click="clickSearchBy('2')" class="btn @if($searchByVehicle) bg-gradient-primary @else bg-gradient-default @endif mb-0" data-toggle="modal" data-target="#new-board-modal">
                        Search Vehicle
                    </button>
                </div>
                <div class="px-2 position-relative ">
                    <button wire:click="clickSearchBy('3')" class="btn @if($searchByContractCustomer) bg-gradient-primary @else bg-gradient-default @endif mb-0" data-toggle="modal" data-target="#new-board-modal">
                        Search Contract Customer
                    </button>
                </div>                
                @endif

            </div>
        </div>
        @if($customerForm)
            <div class="card px-3 my-2" >
                <div class="card-body p-0">
                    @if($showSelectedCustomer)
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <label for="mobilenumberInput">Mobile Number </label>: {{$mobile}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <label for="mobilenumberInput">Name </label>: {{$name}}
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <label for="mobilenumberInput">Email </label>: {{$email}}
                            </div>
                            <div class="col-md-12 col-sm-12 mt-4">
                                <button type="button" wire:click="editCustomerDetails()" class="btn bg-gradient-primary btn-sm mx-3 float-start" id="editCustomerDetailsBtn">Edit Customer</button>

                                <button type="button" wire:click="addCustomerVehicle()" class="btn bg-gradient-danger btn-sm mx-3 float-end" id="addNewVehicleBtn">Add New Vehicle</button>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <label for="mobilenumberInput">Mobile Number </label>
                                <div class="form-group mb-3"  >
                                    <input  type="number" class="form-control @error('mobile') btn-outline-danger @enderror" placeholder="Mobile Number" aria-label="Mobile Number" aria-describedby="button-MobileSearch" wire:model="mobile"  name="mobile" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" minlength="1" maxlength="10" id="mobilenumberInput" style="padding-left:10px !important;">
                                    <button wire:click="searchResult" class="d-none btn btn-outline-primary mb-0" type="button" id="button-MobileSearch">Search</button>
                                </div>
                            </div>
                            <div class="col-md-6  col-sm-6">
                                <div class="form-group openDiv">
                                    <label for="nameInput">Name</label>
                                    <input type="text" class="form-control @error('name') btn-outline-danger @enderror" wire:model.defer="name" name="name" placeholder="Name" id="nameInput" style="padding-left:10px !important;">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group openName">
                                    <label for="emailInput">Email</label>
                                    <input type="email" wire:model.defer="email" name="email" class="form-control @error('email') btn-outline-danger @enderror" id="emailInput" placeholder="Email" style="padding-left:10px !important;">
                                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="gusestCustomer">Gusest Customer</label>
                                    <div class="form-check form-switch mt-1">
                                        <input class="form-check-input" type="checkbox" id="gusestCustomer" wire:model="markGusestCustomer">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 mt-4">
                                @if($updateCustomerDetails)
                                <button type="button" wire:click="updateCustomer()" class="btn bg-gradient-warning btn-sm" id="updateCustomerButton">Update Customer</button>
                                @else
                                    @if($customerSearchBtn)
                                    <button type="button" wire:click="searchCustomer()" class="btn bg-gradient-warning btn-sm" id="searchCustomerButton">Search Customer</button>
                                    @endif
                                    @if($customerSaveBtn)
                                        @if($confirmGuestCustSave)
                                        <p class="float-end">Continue Save as Guest
                                            <span><label wire:click.prevent="confirmSaveAsGuest()" class="badge bg-gradient-success cursor-pointer"> Yes</label></span>
                                            <span><label wire:click.prevent="notConfirmSaveAsGuest()" class="badge bg-gradient-danger cursor-pointer"> No</label></span>

                                        </p>
                                        @else
                                        <button type="button" wire:click="saveCustomer()" class="btn bg-gradient-info btn-sm mx-3 float-end" id="saveCustomerButton">Save Customer & Continue</button>
                                        @endif
                                    @endif
                                @endif
                                
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        @if($contractCustomerForm)
            <div class="card px-3 my-2" >
                <div class="card-body p-0">
                    @if($contract_customer_id && $showSelectedContractCustomer)
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <label for="mobilenumberInput">Mobile Number </label>: {{$mobile}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <label for="mobilenumberInput">Name </label>: {{$name}}
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="mobilenumberInput">Email </label>: {{$email}}
                        </div>
                        <div class="col-md-12 col-sm-12 mt-4">
                            
                            <button type="button" wire:click="addNewContractCustomerVehicle()" class="btn bg-gradient-danger btn-sm mx-3 float-end" id="addNewVehicleBtn">Add New Vehicle</button>
                        </div>

                    </div>

                    @else
                    <div class="row">
                        <div class="col-md-6 col-sm-6">

                            <label for="saveContractCustomerNameButton">Contract Customer</label>
                            <div class="form-group">
                                <input type="text" wire:model.live="search_contract_contract" placeholder="Search..." class="form-control @error('search_contract_contract') btn-outline-danger @enderror">
                                @if (!empty($search_contract_contract) && $filteredItems->count() > 0)

                                <ul class="list-group dropdown-list">
                                    @foreach ($filteredItems as $item)
                                    <li class="list-item" wire:click="selectItem('{{ $item->TenantId }}')">{{ $item->TenantName }}</li>
                                    @endforeach
                                </ul>
                                @elseif (!empty($search_contract_contract) && $filteredItems->count() === 0)
                                <div class="no-results">No results found.</div>
                                @endif
                                @if ($selectedContract)
                                <p>Selected: {{ $selectedContract }}</p>
                                @endif
                                @error('contract_customer_id') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                

                                <!-- <select class="form-control chosen-select d-none" wire:model="contract_customer_id"  name="contract_customer_id" id="contractCustomerNameInput" style="padding-left:10px !important;">
                                    <option value="">-Select Contract Customers--</option>
                                    @foreach($contractCustomersList as $contractCustomer)
                                    <option value="{{$contractCustomer->TenantId}}">{{$contractCustomer->TenantName}}</option>
                                    @endforeach
                                </select>
                                @error('contract_customer_id') <span class="mb-4 text-danger">{{ $message }}</span> @enderror -->
                            </div>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="plateCodeOthCountry">Plate Code</label>
                                <input type="text" class="form-control @error('contract_plate_code') btn-outline-danger @enderror" wire:model="contract_plate_code" name="plateCode" id="plateCodeOthCountry" placeholder="Plate Code" style="padding:0.5rem 0.3rem !important;" />
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="contractPlateNumber">Plate Number</label>
                                <input style="padding:0.5rem 0.3rem !important;" type="number" id="contractPlateNumber" class="form-control @error('contract_plate_number') btn-outline-danger @enderror" wire:model="contract_plate_number" name="contract_plate_number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" minlength="1" maxlength="6" placeholder="Plate Number">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="contractChaisisNumberInput">Chaisis Number</label>
                                <input type="text" style="padding:0.5rem 0.3rem !important;" class="form-control @error('contract_chassis_number') btn-outline-danger @enderror" id="contractChaisisNumberInput" wire:model="contract_chassis_number" name="contract_chassis_number" placeholder="Chassis Number">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-4">
                            <button type="button" wire:click="searchContractVehicle()" class="btn btn-primary btn-sm me-3">Search Vehicle</button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        @endif

        @if($vehicleForm)
            <div class="card px-3 my-2" >
                <div class="card-body p-0">
                    @if($vehicleSearchForm)
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
                            @if(!$otherCountryPlateCode)
                            <div class="col-md-5 col-sm-4">
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
                            <div class="col-md-2 col-sm-3">
                                <div class="form-group">
                                    <label for="plateNumber">Plate Number</label>
                                    <div class="form-check form-switch mt-1">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" wire:model="numberPlateRequired">
                                        <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-3">
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
                            <div class="col-md-5 col-sm-3">
                                <div class="form-group">
                                    <label for="plateCodeOthCountry">Plate Code</label>
                                    <input type="text" class="form-control @error('plate_code') btn-outline-danger @enderror" wire:model="plate_code" name="plateCode" id="plateCodeOthCountry" placeholder="Plate Code" style="padding:0.5rem 0.3rem !important;" />
                                </div>
                            </div>
                            @endif
                            <div class="col-md-5 col-sm-5">
                                <div class="form-group">
                                    <label for="plateNumber">Plate Number</label>
                                    <input style="padding:0.5rem 0.3rem !important;" type="number" id="plateNumber" class="form-control @error('plate_number') btn-outline-danger @enderror" wire:model="plate_number" name="plate_number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" minlength="1" maxlength="6" placeholder="Number">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 col-sm-3">
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
                            <div class="col-md-10 col-sm-9">
                                <div class="form-group">
                                    <label for="chaisisNumberInput">Chaisis Number</label>
                                    <input type="text" class="form-control @error('chassis_number') btn-outline-danger @enderror" id="chaisisNumberInput" wire:model="chassis_number" name="chassis_number" placeholder="Chassis Number">
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($vehicleDetailsForm)
                    <div class="row">
                        <div class="col-md-2 col-sm-3">
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
                        <div class="col-md-5 col-sm-5">
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
                        <div class="col-md-5 col-sm-5">
                            <div class="form-group">
                                <label for="vehicleKmInput">K.M Reading</label>
                                <input type="number" class="form-control" id="vehicleKmInput" wire:model="vehicle_km" name="vehicle_km" placeholder="K.M Reading">
                            </div>
                        </div>

                        <div class="col-md-2 col-sm-4">
                            <label for="AddVehicleMakeInput mb-2"></label>
                            <div class="form-group">
                                <button type="button" wire:click="addMakeModel()" class="btn btn-info btn-sm mt-2 p-1" id="AddVehicleMakeInput">Add Make/Model</button>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-5">
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
                        <div class="col-md-5 col-sm-5">
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
                    
                    <div class="row">
                        <div class="col-md-12 mt-4">
                            @if($vehicleSearchBtn)
                            <button type="button" wire:click="searchVehicle()" class="btn btn-primary btn-sm me-3">Search Vehicle</button>
                            @endif
                            @if($vehicleSaveBtn)
                            <button type="button" wire:click="saveVehicle()" class="btn bg-gradient-info btn-sm mx-3 float-end" id="saveVehicleButton">Save Vehicle & Continue</button>
                            @endif
                        </div>
                    </div>
                    
                </div>
            </div>
        @endif

        

        @if(!empty($customerVehicles))
            <div class="row mb-2" id="customerSearchVehicleList">
                <div class="col-12 mt-4">
                    <div class="card mb-4">
                        <div class="card-header pb-0 p-3">
                            <h6 class="mb-1">Vehicles Search Results</h6>
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
                                @foreach($customerVehicles as $vehicle)
                                <div class="col-xl-3 col-md-4 col-sm-6 mb-xl-0 my-4">
                                    <a class="cursor-pointer"  wire:click="selectVehicleProceed('{{$vehicle->customer_id}}','{{$vehicle->id}}')" wire:navigate>
                                        <div class="card card-background move-on-hover" style="align-items: start">
                                            <div class="full-background" style="background-image: url('{{url("public/storage/".$vehicle->vehicle_image)}}')"></div>
                                            <div class="card-body pt-5">
                                                <h4 class="text-white mb-0 pb-0">
                                                    @if($vehicle->customerInfoMaster['TenantName'])
                                                        {{$vehicle->customerInfoMaster['TenantName']}}
                                                    @else
                                                    Guest
                                                    @endif
                                                </h4>
                                                <p class="mt-0 pt-0"><small>{{$vehicle->customerInfoMaster['Email']}}, {{$vehicle->customerInfoMaster['Mobile']}}</small></p>
                                                <p class="mb-0">{{isset($vehicle->makeInfo)?$vehicle->makeInfo['vehicle_name']:''}}, {{isset($vehicle->modelInfo['vehicle_model_name'])?$vehicle->modelInfo['vehicle_model_name']:''}}</p>
                                                <p>
                                                    {{$vehicle->plate_number_final}}
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
        
        @if($showAddMakeModelNew)
            @include('components.modals.addMakeModelNew')
        @endif

        @if($showPendingJobList)
            @include('components.modals.pendingJobListModal')
        @endif
        
        <div wire:loading wire:target="confirmSaveAsGuest">
            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                <div class="la-ball-beat">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        <div wire:loading wire:target="notConfirmSaveAsGuest">
            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                <div class="la-ball-beat">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        <div wire:loading wire:target="addNewContractCustomerVehicle">
            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                <div class="la-ball-beat">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        <div wire:loading wire:target="searchContractVehicle">
            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                <div class="la-ball-beat">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        <div wire:loading wire:target="searchVehicle">
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
        <div wire:loading wire:target="saveVehicle">
            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                <div class="la-ball-beat">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        <div wire:loading wire:target="updateCustomer">
            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                <div class="la-ball-beat">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        <div wire:loading wire:target="editCustomerDetails">
            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                <div class="la-ball-beat">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        <div wire:loading wire:target="addCustomerVehicle">
            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                <div class="la-ball-beat">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
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
        <div wire:loading wire:target="searchResult">
            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                <div class="la-ball-beat">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        <div wire:loading wire:target="saveCustomerOnly">
            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                <div class="la-ball-beat">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        <div wire:loading wire:target="searchCustomer">
            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                <div class="la-ball-beat">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        <div wire:loading wire:target="saveCustomer">
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

    window.addEventListener('openPendingJobListModal',event=>{
        $('#pendingJobListModal').modal('show');
    });
    
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
           /* $('#contractCustomerNameInput').on('change', function (e) {
                var contractCustomerVal = $('#contractCustomerNameInput').val();
                alert(contractCustomerVal);
                @this.set('contract_customer_id', contractCustomerVal);
            });*/
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
    

</script>
@endpush