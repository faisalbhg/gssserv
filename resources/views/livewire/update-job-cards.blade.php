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
        @if($editCUstomerInformation)
            <div class="card px-3 my-2" >
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group">
                                <label for="mobilenumberInput">Mobile Number </label>
                                <div class="input-group mb-0">
                                    <span class="input-group-text px-0">+971</span>
                                    <input class="form-control" placeholder="Mobile Number" type="number" wire:model="mobile" name="mobile" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" minlength="1" maxlength="9" id="mobilenumberInput">
                                </div>
                                @error('mobile') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group openDiv">
                                <label for="nameInput">Name</label>
                                <input type="text" class="form-control" wire:model.defer="name" name="name" placeholder="Name" id="nameInput">
                                @error('name') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group openName">
                                <label for="emailInput">Email</label>
                                <input type="email" wire:model.defer="email" name="email" class="form-control" id="emailInput" placeholder="Email">
                                @error('email') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
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
                        <div class="col-md-3 col-sm-4">
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
                        
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="button" wire:click="updateVehicleCustomer()" class="btn btn-primary btn-sm">Update Vehicle</button>
                        
                        <button type="button" wire:click="closeUpdateVehicleCustomer()" class="btn btn-default btn-sm">cancel</button>
                        
                        <div wire:loading wire:target="updateVehicleCustomer,closeUpdateVehicleCustomer">
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

        @if($vehicleServvicesItems)
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
                                        <h5 class="font-weight-bolder mb-0">{{$selectedVehicleInfo['plate_number_final']}}</h5>
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
                                        <div wire:loading wire:target="editCustomer">
                                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                <div class="la-ball-beat">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn bg-gradient-info btn-tooltip btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Apply Discount Group" data-container="body" data-animation="true" wire:click="clickDiscountGroup()">Discount Group</button>
                                        <div wire:loading wire:target="clickDiscountGroup">
                                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                <div class="la-ball-beat">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn bg-gradient-info btn-sm" wire:click="openServiceGroup">Add New</button>
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

                                        @if(@$customerSelectedDiscountGroup['groupType']==3)
                                        <button class="btn bg-gradient-success btn-sm mb-0" wire:click.prevent="applyEngineOilDiscount()">Apply {{$engineOilDiscountPercentage}}% Discount</button>
                                        <div wire:loading wire:target="applyEngineOilDiscount">
                                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                <div class="la-ball-beat">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        <br>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 my-2">
                    @if(count($jobDetails->customerJobServices)>0)
                        <div class="card card-profile card-plain">
                            <h6 class="text-uppercase text-body text-lg font-weight-bolder mt-2">Order Summary </h6>
                            <div class="row">
                                <div class="col-lg-8 col-md-8">
                                    <div class="card h-100">
                                        
                                        <div class="card-body p-3 pb-0">
                                            <ul class="list-group">
                                                <?php $total = 0;$totalDiscount=0; $discountName=''; ?>
                                                @foreach ($tempServiceCart as $item)
                                                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                        
                                                        <div class="d-flex flex-column">
                                                            <h6 class="mb-1 text-dark font-weight-bold text-sm">
                                                                {{ $item->item_name }} (<span class="text-xs">#{{ $item->item_code }}</span>)
                                                            </h6>
                                                            
                                                            @if($item->extra_note)
                                                                <span class="text-xs text-dark">Note: {{ $item->extra_note }}</span>
                                                            @endif
                                                            @if($item->customer_group_code)
                                                            <?php $discountName = $item->customer_group_code;?>
                                                            <p class="mb-0"><span class="text-sm text-dark">Discount:  <label class="badge bg-gradient-info">{{ $item->customer_group_code }} - {{ $item->discount_perc }}% Off</label></span></p>
                                                            @endif
                                                            <!-- <a href="#" class="p-0 text-danger bg-red-600" wire:click.prevent="removeFromOrder('{{$item->id}}')"><i class="fa fa-trash"></i> Remove</a> -->

                                                            @if($confirming===$item->id)
                                                            <p>
                                                                <label class="p-0 text-success bg-red-600 cursor-pointer float-start" wire:click.prevent="kill({{ $item->id }})"><i class="fa fa-trash"></i> Yes</label>
                                                                <label class="p-0 text-info bg-red-600 cursor-pointer float-end" wire:click.prevent="safe({{ $item->id }})"><i class="fa fa-trash"></i> No</label>
                                                            </p>

                                                            @else
                                                                <label class="p-0 text-danger bg-red-600 cursor-pointer" wire:click.prevent="confirmDelete({{ $item->id }})"><i class="fa fa-trash"></i> Remove</label>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex align-items-center text-sm">
                                                            <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4" > {{round($item->unit_price,2)}}</button>
                                                        </div>
                                                        <div class="d-flex align-items-center text-sm">
                                                            @if($item->quantity>1)<span class="px-2 cursor-pointer" wire:click="orderSetDownQty({{ $item->id }})">
                                                                <i class="fa-solid fa-square-minus fa-xl"></i>
                                                            </span>
                                                            @endif
                                                            {{$item->quantity}}
                                                            <span class="px-2 cursor-pointer" wire:click="orderSetUpQty({{ $item->id }})">
                                                                <i class="fa-solid fa-square-plus fa-xl"></i>
                                                            </span>

                                                            
                                                            <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4" @if($item->customer_group_code) style="text-decoration: line-through;" @endif > {{round($item->unit_price,2)*$item->quantity}}</button>

                                                            @if($item->customer_group_code)
                                                            
                                                            <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4"> {{ round($item->unit_price-(($item->discount_perc/100)*($item->discount_perc)),2)*$item->quantity }}</button>
                                                            @endif


                                                        </div>

                                                    </li>
                                                    <hr class="horizontal dark mt-0 mb-2">
                                                    <?php
                                                    $total = $total+$item->unit_price*$item->quantity;
                                                    $totalDiscount = $totalDiscount+round((($item->discount_perc/100)*($item->unit_price*$item->quantity)),2);
                                                    ?>
                                                @endforeach
                                                <div wire:loading wire:target="confirmDelete, kill, safe">
                                                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                        <div class="la-ball-beat">
                                                            <div></div>
                                                            <div></div>
                                                            <div></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                $totalAfterDisc = $total - $totalDiscount;
                                                $tax = $totalAfterDisc * (config('global.TAX_PERCENT') / 100);
                                                $grand_total = $totalAfterDisc+$tax;
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 ms-auto">
                                    <h6 class="mb-3">Order Summary</h6>
                                    <div class="d-flex justify-content-between">
                                        <span class="mb-2 text-sm">
                                        Total:
                                        </span>
                                        <span class="text-dark font-weight-bold ms-2"> {{round($total,2)}}</span>
                                    </div>
                                    @if($totalDiscount>0)
                                    <div class="d-flex justify-content-between">
                                        <span class="mb-2 text-sm">
                                        Discount:
                                        </span>
                                        <span class="text-dark ms-2 font-weight-bold"> {{round($totalDiscount,2)}}</span>
                                    </div>
                                    
                                    @endif
                                    <hr class="horizontal dark my-2">
                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="mb-2 text-md text-dark text-bold">
                                        Total:
                                        </span>
                                        <span class="text-dark text-lg ms-2 font-weight-bold"> {{round($totalAfterDisc,2)}}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-sm">
                                        Taxes:
                                        </span>
                                        <span class="text-dark ms-2 font-weight-bold"> {{round($tax,2)}}</span>
                                    </div>
                                    <hr class="horizontal dark my-2">
                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="mb-2 text-lg text-dark text-bold">
                                        Grand Total:
                                        </span>
                                        <span class="text-dark text-lg ms-2 font-weight-bold"> {{round($grand_total,2)}}</span>
                                    </div>
                                    
                                    <button type="button" class="btn bg-gradient-success btn-sm float-end" wire:click="updateServiceConfirm()">Confirm & Continue</button>
                                    <div wire:loading wire:target="updateServiceConfirm">
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
            <div class="row" id="servceGroup">
                @if(!$servicesGroupList->isEmpty())
                    @foreach($servicesGroupList as $servicesGroup)
                        <div class="col-sm-3 col-md-3 col-lg-2 col-xl-2 my-2">
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
                    
                    <div class="col-sm-3 col-md-3 col-lg-2 col-xl-2 my-2">
                        <div class="card h-100" >
                            <a wire:click="openServiceItems()" href="javascript:;">
                                <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('{{asset("img/PP00039item.jpg")}}');">
                                    @if($showServiceItems)
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

                    <div class="col-sm-4 col-md-3 col-lg-2 col-xl-2 my-2 d-none">
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
                                            <small>AED</small>{{round($qlItemPriceDetails->UnitPrice,2)}}
                                        </h5>
                                        @if($qlItemDiscountDetails != null)
                                        <h5 class="font-weight-bold mt-2">
                                            <span class="text-secondary text-sm me-1">{{config('global.CURRENCY')}}</span>{{ round($qlItemPriceDetails->UnitPrice-(($qlItemDiscountDetails->DiscountPerc/100)*$qlItemPriceDetails->UnitPrice),2) }}
                                        </h5>
                                        @endif
                                        <div class="ms-auto">
                                            @if(!empty($qlItemDiscountDetails))
                                                <span class="badge bg-gradient-info">{{round($qlItemDiscountDetails->DiscountPerc,2)}}%off</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-body text-lg-left text-center p-2">
                                        <input type="number" class="form-control w-30 float-start" placeholder="Qty" wire:model.defer="ql_item_qty.{{$qlItemPriceDetails->ItemId}}" style="padding-left:5px !important;" />
                                        <a href="javascript:;" class="btn btn-icon bg-gradient-primary d-lg-block m-0 float-end p-2" wire:click="addtoCartItem('{{$qlItemPriceDetails}}','{{$qlItemDiscountDetails}}')">Buy Now<i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
                                        </a>
                                        <div wire:loading wire:target="addtoCartItem">
                                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                <div class="la-ball-beat">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </div>
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
                                        <p class="text-sm text-center font-weight-bold text-dark">{{$priceDetails->ItemCode}} - {{$priceDetails->ItemName}}</p>
                                        <!-- <textarea style="padding-left: 5px !important;" class="form-control" placeholder="Notes..!" wire:model="extra_note.{{$priceDetails->ItemId}}"></textarea > -->
                                        <div class="d-flex border-radius-lg p-0 mt-2">
                                            
                                            <p class="text-md font-weight-bold text-dark my-auto me-2" @if($discountDetails != null) style="text-decoration: line-through;" @endif>{{config('global.CURRENCY')}} {{round($priceDetails->UnitPrice,2)}}
                                            </p>
                                            @if($discountDetails != null)
                                            <p class="text-sm font-weight-bold my-auto">
                                            <span class="text-secondary text-sm me-1">{{config('global.CURRENCY')}}</span>{{ round($priceDetails->UnitPrice-(($discountDetails->DiscountPerc/100)*$priceDetails->UnitPrice),2) }}
                                            </p>
                                            <span class="badge bg-gradient-info">{{round($discountDetails->DiscountPerc,2)}}%off</span>
                                            
                                            @endif

                                            <a href="javascript:;" class="btn bg-gradient-primary mb-0 ms-auto btn-sm"  wire:click="addtoCart('{{$priceDetails}}','{{$discountDetails}}')">Add Now</a>
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

        
    </div>
    @if($showDiscountDroup)
    @include('components.modals.discountGroups')
    @endif
</main>
@push('custom_script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    window.addEventListener('openDiscountGroupModal',event=>{
        $('#discountGroupModal').modal('show');
    });
    window.addEventListener('closeDiscountGroupModal',event=>{
        $('#discountGroupModal').modal('hide');
    });

    window.addEventListener('openServicesListModal',event=>{
        $('#servicePriceModal').modal('show');
    });
    window.addEventListener('closeServicesListModal',event=>{
        $('#servicePriceModal').modal('hide');
    });


    window.addEventListener('selectSearchEvent',event=>{
        $(document).ready(function () {

            $('#seachByCategory').select2();
            $('#seachByCategory').on('change', function (e) {
                var catVal = $('#seachByCategory').select2("val");
                @this.set('ql_search_category', catVal);
            });

            $('#seachBySubCategory').select2();
            $('#seachBySubCategory').on('change', function (e) {
                var subCatVal = $('#seachBySubCategory').select2("val");
                @this.set('ql_search_subcategory', subCatVal);
            });

            $('#seachByBrand').select2();
            $('#seachByBrand').on('change', function (e) {
                var BrandVal = $('#seachByBrand').select2("val");
                @this.set('ql_search_brand', BrandVal);
            });

            $('#qlSeachByBrand').select2();
            $('#qlSeachByBrand').on('change', function (e) {
                var BrandVal = $('#qlSeachByBrand').select2("val");
                @this.set('ql_search_brand', BrandVal);
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