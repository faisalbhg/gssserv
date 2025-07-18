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
    @media (max-width: 991.98px) {
    :not(.navbar) .dropdown .dropdown-menu {
        opacity: 0;
        top: 30px !important;
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
        @if($showlistCarTaxiToday)
            <section class="py-3">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                        <div class="card h-100 cursor-pointer">
                            <div class="card-body d-flex flex-column justify-content-center">
                                <h5 class="text-danger text-left"><i class="fa-solid fa-car  text-danger mb-3"></i>  Add New <i class="fa fa-plus text-danger mb-3"></i></h5>
                                <div class="row">
                                    @foreach($all_car_taxi_Service as $carTaxiServ)
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                    <a href="javascript:;" wire:click="addNewCarTaxi({{$carTaxiServ}})">
                                        <button class="btn @if($carTaxiServ->ItemCode=='S255') bg-gradient-info @else bg-gradient-dark @endif">{{$carTaxiServ->ItemName}}</button>
                                    </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div wire:loading wire:target="addNewCarTaxi">
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
                <div class="row">
                    <div class="col-xl-2 col-md-3 col-sm-3 mb-xl-2 mb-2 jobscount total">
                        <div class="card bg-gradient-dark shadow text-white">
                            <div class="card-body p-3 cursor-pointer" wire:click="filterJobListPage('total')">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total jobs</p>
                                    <hr class="m-0">
                                    <h5 class="font-weight-bolder mb-0  text-white">{{$getCountCarTaxiJob->total}}<span class="text-success text-sm font-weight-bolder"></span></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-3 col-sm-3 mb-xl-2 mb-2 jobscount working_progress">
                        <div class="card bg-gradient-danger shadow text-white">
                            <div class="card-body p-3 cursor-pointer" wire:click="filterJobListPage('working_progress')">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Working</p>
                                    <hr class="m-0">
                                    <h5 class="font-weight-bolder mb-0 text-white">{{$getCountCarTaxiJob->working_progress}}<span class="text-success text-sm font-weight-bolder"></span></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-3 col-sm-3 mb-xl-2 mb-2 jobscount work_finished">
                        <div class="card bg-gradient-warning shadow text-white">
                            <div class="card-body p-3 cursor-pointer" wire:click="filterJobListPage('work_finished')">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="numbers">
                                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Completed</p>
                                            <hr class="m-0">
                                            <h5 class="font-weight-bolder mb-0 text-white">{{$getCountCarTaxiJob->work_finished+$getCountCarTaxiJob->ready_to_deliver}}<span class="text-success text-sm font-weight-bolder"></span></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-3 col-sm-3 mb-xl-2 mb-2 jobscount delivered">
                        <div class="card bg-gradient-success shadow text-white">
                            <div class="card-body p-3 cursor-pointer" wire:click="filterJobListPage('delivered')">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Delivered</p>
                                    <hr class="m-0">
                                    <h5 class="font-weight-bolder mb-0 text-white">{{$getCountCarTaxiJob->delivered}}<span class="text-success text-sm font-weight-bolder"></span></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 me-auto text-left">
                        <h5>KABI LLC Contract List On {{\Carbon\Carbon::parse($search_job_date)->format('dS M Y')}}</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-md-3 col-sm-3 mb-xl-2 mb-2">
                        <label>CT Number</label>
                        <div class="form-group">
                            <input style="padding:0.5rem 0.3rem !important;"  type="text"  class="form-control" placeholder="Search CT Number" wire:model="search_ct_number" />
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-3 col-sm-3 mb-xl-2 mb-2">
                        <label>Meeter Number</label>
                        <div class="form-group">
                            <input style="padding:0.5rem 0.3rem !important;"  type="text"  class="form-control" placeholder="Search Meeter Number" wire:model="search_meeter_number" />
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-3 col-sm-3 mb-xl-2 mb-2">
                        <label>Plate Search</label>
                        <div class="form-group">
                            <input style="padding:0.5rem 0.3rem !important;" type="text" id="plateNumber" class="form-control @error('plate_number') btn-outline-danger @enderror" wire:model="search_plate_number" name="plate_number" placeholder="Number Plate">
                        </div>
                    </div>
                </div>
                <div class="row mt-lg-4 mt-2">
                    @foreach($carTaxiJobs as $taxiJob)
                        <div class="col-lg-4 col-md-4 col-sm-6 mb-4">
                            <div class="card cursor-pointer" wire:click="customerJobUpdate('{{$taxiJob->job_number}}')">
                                <div class="card-body p-3">
                                    <div class="d-flex">
                                        <div class="avatar avatar-xl bg-gradient-dark border-radius-md p-0 shadow">
                                            <img src="{{'public/storage/'.$taxiJob->vehicle_image}}" alt="slack_logo">
                                        </div>
                                        <div class="ms-3 my-auto">
                                            <h6>CT No: {{$taxiJob->ct_number}}</h6>
                                            <h6>Meeter ID: {{$taxiJob->meter_id}}</h6>
                                        </div>
                                        <div class="ms-auto">
                                            <div class="dropdown">
                                                <button class="btn btn-link text-secondary ps-0 pe-2" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v text-lg"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end me-sm-n4 me-n3" aria-labelledby="navbarDropdownMenuLink">
                                                    @foreach(config('global.jobs.actions') as $actionKey => $jobActions)
                                                        @if($taxiJob->job_status>=$actionKey)
                                                        <a class="dropdown-item {!!config('global.jobs.status_text_class')[$actionKey]!!}">{{$jobActions}}</a>
                                                        @elseif($taxiJob->job_status+1==$actionKey)
                                                        <a class="dropdown-item {!!config('global.jobs.status_text_class')[$actionKey]!!}" @if($actionKey!=4) wire:click="updateCarTaxiHomeService('{{$taxiJob->job_number}}','{{$actionKey}}')" @else style="text-decoration: line-through;" @endif >{{$jobActions}}</a>
                                                        @else
                                                        <a class="dropdown-item" style="text-decoration: line-through;">{{$jobActions}}</a>
                                                        @endif


                                                        

                                                        
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="mb-0 text-sm mt-2">{{$taxiJob->makeInfo['vehicle_name']}} - <small>{{$taxiJob->modelInfo['vehicle_model_name']}} </small></h6>

                                      <p class="text-sm font-weight-bold text-primary mb-0">{{$taxiJob->plate_number}}</p>
                                      <hr class="m-0">
                                      <h5>{{$taxiJob->customerInfo['TenantName']}}</h5>
                                      <p class="text-sm text-dark mb-0"><i class="fa-solid fa-user text-default mt-3"></i> {{$taxiJob->customer_name}}
                                        @if(isset($taxiJob->customer_mobile))
                                        <br><i class="fa-solid fa-phone text-default mb-3"></i> {{$taxiJob->customer_mobile}}
                                        @endif
                                      </p>
                                    <hr class="horizontal dark">
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <span class="{!!config('global.jobs.status_text_class')[$taxiJob->job_status]!!} text-center w-100 d-none"> #{{$taxiJob->job_number}}</span>
                                            <button class="btn @if($taxiJob->customerJobServices[0]['item_code']=='S255') bg-gradient-info @else bg-gradient-dark @endif">
                                            {{$taxiJob->customerJobServices[0]['item_name']}}</button>
                                            <span class="w-100 badge badge-sm {!!config('global.jobs.status_btn_class')[$taxiJob->job_status]!!}">{{config('global.jobs.status')[$taxiJob->job_status]}}</span>
                                            <small class="text-secondary mb-0">{{ \Carbon\Carbon::parse($taxiJob->created_at)->format('d-m-y h:i A') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div wire:loading wire:target="updateQwService">
                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                        <div class="la-ball-beat">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>
                <div wire:loading wire:target="customerJobUpdate">
                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                        <div class="la-ball-beat">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>
            </section>
        @else
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
                    <div class="form-group">
                        <label for="ctNumberInput">CT Number </label>
                        <div class="input-group mb-0">
                            <input class="form-control" placeholder="CT Number" type="text" wire:model="ct_number" name="ct_number" minlength="1" maxlength="7" id="ctNumberInput">
                        </div>
                        @error('ct_number') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="form-group">
                        <label for="meterIdInput">Meter ID </label>
                        <div class="input-group mb-0">
                            <input class="form-control" placeholder="Meter ID" type="text" wire:model="meter_id" name="meter_id" minlength="1" maxlength="7" id="meterIdInput">
                        </div>
                        @error('meter_id') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <label for="plateImageFile" >Plate Image</label>
                    <div 
                    x-data="{ isUploading: false, progress: 0 }" 
                    x-on:livewire-upload-start="isUploading = true" 
                    x-on:livewire-upload-finish="isUploading = false" 
                    x-on:livewire-upload-error="isUploading = false" 
                    x-on:livewire-upload-progress="progress = $event.detail.progress" 
                    >
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
                    @error('plate_number_image') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                    @if ($plate_number_image)
                        <img class="img-fluid border-radius-lg w-30" src="{{ $plate_number_image->temporaryUrl() }}">
                    @endif
                </div>
                <div class="col-md-2 col-sm-2 d-none">
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
                <div class="col-md-4 col-sm-4">
                    <div class="form-group">
                        <label for="plateNumber">Plate Number</label>
                        <input style="padding:0.5rem 0.3rem !important;" type="number" id="plateNumber" class="form-control @error('plate_number') btn-outline-danger @enderror" wire:model="plate_number" name="plate_number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" minlength="1" maxlength="6" placeholder="Number">
                    </div>
                    @error('plate_state') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-4">
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
                <div class="col-md-4 col-sm-4">
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
                <div class="col-md-4 col-sm-4">
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
                <div class="col-md-4 col-sm-4">
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
                <div class="col-md-4 col-sm-4">
                    <div class="form-group">
                        <label for="chaisisNumberInput">Chaisis Number</label>
                        <input type="text" class="form-control" id="chaisisNumberInput" wire:model="chassis_number" name="chassis_number" placeholder="Chassis Number">
                    </div>
                    @error('chassis_number') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-4 col-sm-4">
                    <div class="form-group">
                        <label for="plateNumber"></label>
                        <div class="form-check form-switch mt-1">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" wire:model="onlyChaisisRequired">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Only Chaisis Number Required</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                
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
                <div class="col-md-12 mb-4">
                    <div class="card">
                        
                        <div class="card-body text-left pt-0">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <h5 class="font-weight-bold mt-2">Exterior Vehicle Images</h5>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <input type="file" id="file1" wire:model="vImageR1" accept="image/*" capture style="display:block"/>
                                            <img class="img-fluid img-thumbnail float-end" id="upfile1" src="{{asset('img/checklist/car1.png')}}" style="cursor:pointer"  />
                                            @error('vImageR1') <span class="text-danger">Missing Image..!</span> @enderror
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <input type="file" id="file2" wire:model="vImageR2" accept="image/*" capture style="display:block"/>
                                            <img class="img-fluid img-thumbnail float-start" id="upfile2" src="{{asset('img/checklist/car2.png')}}" style="cursor:pointer"  />
                                            @error('vImageR2') <span class="text-danger">Missing Image..!</span> @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <input type="file" id="file3" wire:model="vImageF" accept="image/*" capture style="display:block"/>
                                            <img class="img-fluid img-thumbnail float-end" id="upfile3" src="{{asset('img/checklist/car3.jpg')}}" style="cursor:pointer"  />
                                            @error('vImageF') <span class="text-danger">Missing Image..!</span> @enderror
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <input type="file" id="file4" wire:model="vImageB" accept="image/*" capture style="display:block"/>
                                            <img class="img-fluid img-thumbnail float-start" id="upfile4" src="{{asset('img/checklist/car4.jpg')}}" style="cursor:pointer"  />
                                            @error('vImageB') <span class="text-danger">Missing Image..!</span> @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <input type="file" id="file5" wire:model="vImageL1" accept="image/*" capture style="display:block"/>
                                            <img class="img-fluid img-thumbnail float-end" id="upfile5" src="{{asset('img/checklist/car5.png')}}" style="cursor:pointer"  />
                                            @error('vImageL1') <span class="text-danger">Missing Image..!</span> @enderror
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <input type="file" id="file6" wire:model="vImageL2" accept="image/*" capture style="display:block"/>
                                            <img class="img-fluid img-thumbnail float-start" id="upfile6" src="{{asset('img/checklist/car6.png')}}" style="cursor:pointer"   />
                                            @error('vImageL2') <span class="text-danger">Missing Image..!</span> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <h5 class="font-weight-bold mt-2">Interior Vehicle Images</h5>
                                    <div class="row m-4">
                                        <div class="col-md-6 col-sm-6">
                                            <input type="file" id="dashImage1File" wire:model="dash_image1" accept="image/*" capture style="display:block"/>
                                            <img class="img-fluid img-thumbnail shadow" id="dashImage1" src="{{asset('img/dashImage1.jpg')}}" style="cursor:pointer"  />
                                            @error('dash_image1') <span class="text-danger">Missing Image..!</span> @enderror
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <input type="file" id="dashImage2File" wire:model="dash_image2" accept="image/*" capture style="display:block"/>
                                            <img class="img-fluid img-thumbnail shadow" id="dashImage2" src="{{asset('img/dashImage2.jpg')}}" style="cursor:pointer"  />
                                            @error('dash_image2') <span class="text-danger">Missing Image..!</span> @enderror
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="row m-4">
                                        <div class="col-md-6 col-sm-6">
                                            <input type="file" id="passengerSeatImageFile" wire:model="passenger_seat_image" accept="image/*" capture style="display:block"/>
                                            <img class="img-fluid img-thumbnail shadow" id="passengerSeatImage" src="{{asset('img/passangerSeat1.jpg')}}" style="cursor:pointer"  />
                                            @error('passenger_seat_image') <span class="text-danger">Missing Image..!</span> @enderror
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <input type="file" id="driverSeatImageFile" wire:model="driver_seat_image" accept="image/*" capture style="display:block"/>
                                            <img class="img-fluid img-thumbnail shadow" id="driverSeatImage" src="{{asset('img/driverSeat1.jpg')}}" style="cursor:pointer"  />
                                            @error('driver_seat_image') <span class="text-danger">Missing Image..!</span> @enderror
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <input type="file" id="backSeat1ImageFile" wire:model="back_seat1" accept="image/*" capture style="display:block"/>
                                            <img class="img-fluid img-thumbnail shadow" id="backSeat1Image" src="{{asset('img/backSeat1.jpg')}}" style="cursor:pointer"  />
                                            @error('back_seat1') <span class="text-danger">Missing Image..!</span> @enderror
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <input type="file" id="backSeat2ImageFile" wire:model="back_seat2" accept="image/*" capture style="display:block"/>
                                            <img class="img-fluid img-thumbnail shadow" id="backSeat2Image" src="{{asset('img/backSeat2.jpg')}}" style="cursor:pointer"   />
                                            @error('back_seat2') <span class="text-danger">Missing Image..!</span> @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <input type="file" id="backSeat3ImageFile" wire:model="back_seat3" accept="image/*" capture style="display:block"/>
                                            <img class="img-fluid img-thumbnail shadow" id="backSeat3Image" src="{{asset('img/backSeat1.jpg')}}" style="cursor:pointer"  />
                                            @error('back_seat3') <span class="text-danger">Missing Image..!</span> @enderror
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <input type="file" id="backSeat4ImageFile1" wire:model="back_seat4" accept="image/*" capture style="display:block"/>
                                            <img class="img-fluid img-thumbnail shadow" id="backSeat4Image1" src="{{asset('img/backSeat2.jpg')}}" style="cursor:pointer"   />
                                            @error('back_seat4') <span class="text-danger">Missing Image..!</span> @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <input type="file" id="backSeat3ImageFile1" wire:model="roof_images" accept="image/*" capture style="display:block"/>
                                            <img class="img-fluid img-thumbnail shadow" id="backSeat3Image1" src="{{asset('img/roofimage1.jpg')}}" style="cursor:pointer"  />
                                            @error('roof_images') <span class="text-danger">Missing Image..!</span> @enderror
                                        </div>
                                    </div>
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
                                    <button type="button" id='btnSubmit' class="btn bg-gradient-primary btn-lg mui-btn float-end" wire:click="createTaxiJob();">Create</button>
                                    <div wire:loading wire:target="createTaxiJob">
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
            
            
        @endif
    </div>
    @include('components.modals.customerSignatureModel')
    @if($updateService)
            @include('components.modals.updateservice')
            @endif
</main>
@push('custom_script')
<script type="text/javascript">
    $(document).ready(function(){
      @if($showUpdateModel==true)
        $('#serviceUpdateModal').modal('show');
      @endif
      $('.jobscount').addClass('opacity-5');
      $('.{{$filterTab}}').removeClass('opacity-5');
    });
    window.addEventListener('filterTab',event=>{
        $('.jobscount').removeClass('opacity-5');
        $('.jobscount').addClass('opacity-5');
        $('.'+event.detail.tabName).removeClass('opacity-5');
    });
</script>


<script type="text/javascript">
    window.addEventListener('showServiceUpdate',event=>{
      $('#serviceUpdateModal').modal('show');
    });
    window.addEventListener('hideServiceUpdate',event=>{
      $('#serviceUpdateModal').modal('hide');
    });

    /*window.addEventListener('imageUpload',event=>{ 
        $('#plateImage').click(function(){
            $("#plateImageFile").trigger('click');
        });
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
        
        $("#dashImage1").click(function () {
            $("#dashImage1File").trigger('click');
        });
        $("#dashImage2").click(function () {
            $("#dashImage2File").trigger('click');
        });
        $("#passengerSeatImage").click(function () {
            $("#passengerSeatImageFile").trigger('click');
        });
        $("#driverSeatImage").click(function () {
            $("#driverSeatImageFile").trigger('click');
        });
        $("#backSeat1Image").click(function () {
            $("#backSeat1ImageFile").trigger('click');
        });
        $("#backSeat2Image").click(function () {
            $("#backSeat2ImageFile").trigger('click');
        });
        $("#backSeat3Image").click(function () {
            $("#backSeat3ImageFile").trigger('click');
        });
        $("#backSeat4Image").click(function () {
            $("#backSeat4ImageFile").trigger('click');
        });
        $("#backSeat4Image1").click(function () {
            $("#backSeat4ImageFile1").trigger('click');
        });
        $('#backSeat3Image1').click(function(){
            $("#backSeat3ImageFile1").trigger('click');
        });
    });

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
    
    $("#dashImage1").click(function () {
        $("#dashImage1File").trigger('click');
    });
    $("#dashImage2").click(function () {
        $("#dashImage2File").trigger('click');
    });
    $("#passengerSeatImage").click(function () {
        $("#passengerSeatImageFile").trigger('click');
    });
    $("#driverSeatImage").click(function () {
        $("#driverSeatImageFile").trigger('click');
    });
    $("#backSeat1Image").click(function () {
        $("#backSeat1ImageFile").trigger('click');
    });
    $("#backSeat2Image").click(function () {
        $("#backSeat2ImageFile").trigger('click');
    });
    $("#backSeat3Image").click(function () {
        $("#backSeat3ImageFile").trigger('click');
    });
    $("#backSeat4Image").click(function () {
        $("#backSeat4ImageFile").trigger('click');
    });
    $("#backSeat4Image1").click(function () {
        $("#backSeat4ImageFile1").trigger('click');
    });
    $('#backSeat3Image1').click(function(){
        $("#backSeat3ImageFile1").trigger('click');
    });*/
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    window.addEventListener('mobile0Remove',event=>{
        $("#mobilenumberInput").on("input", function() {
            if (/^0/.test(this.value)) {
                this.value = this.value.replace(/^0/, "")
            }
        });
    });
</script>
<script type="text/javascript">
    window.addEventListener('selectSearchEvent',event=>{
        $(document).ready(function () {
            $('#newVehicleKMClick').click(function(){
                //alert('5');
                $('.signaturePadDiv').hide();
            });
            $('#vehicleTypeInput').select2();
            $('#vehicleMakeInput').select2();
            $('#vehicleModelInput').select2();
            //$('#plateCode').select2();

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
            /*$('#plateCode').on('change', function (e) {
                var stateCodeVal = $('#plateCode').select2("val");
                @this.set('plate_code', stateCodeVal);
            });*/
        });
    });
</script>

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
</script>

<script type="text/javascript">
    let file = document.querySelector('input[type="file"]').files[0]
 
    // Upload a file:
    @this.upload('plate_number_image', file, (uploadedFilename) => {
        // Success callback.
    }, () => {
        // Error callback.
    }, (event) => {
        // Progress callback.
        // event.detail.progress contains a number between 1 and 100 as the upload progresses.
    })
 
   
    // Remove single file from multiple uploaded files
    @this.removeUpload('plate_number_image', uploadedFilename, successCallback)
</script>


@endpush