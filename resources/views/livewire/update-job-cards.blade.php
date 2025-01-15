@push('custom_css')
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
    </div>
    <div class="card px-3 my-2" >
        <div class="card-body p-0">
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
                                    <button type="button" class="btn bg-gradient-primary btn-tooltip btn-sm" title="Add Customer/Discount/Vehicle"  wire:click="addNewVehicle()">New Vehicle</button>
                                    <button type="button" class="btn bg-gradient-info btn-tooltip btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Apply Discount Group" data-container="body" data-animation="true" wire:click="clickDiscountGroup()">Discount Group</button>
                                    <button class="btn bg-gradient-info btn-sm" wire:click="openServiceGroup">Services</button>
                                    @if(@$customerSelectedDiscountGroup['groupType']==2)
                                    <button class="btn bg-gradient-danger btn-sm mb-0" wire:click.prevent="removeDiscount()">Remove Discount - {{strtolower(str_replace("_"," ",$customerDiscontGroupCode))}}</button>
                                    @endif

                                    @if(@$customerSelectedDiscountGroup['groupType']==3)
                                    {{$engineOilDiscountPercentage}}
                                    <button class="btn bg-gradient-success btn-sm mb-0" wire:click.prevent="applyEngineOilDiscount()">Apply {{$engineOilDiscountPercentage}}% Discount</button>
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
                                    <!-- @if($customerDiscontGroupCode)
                                    <button class="btn bg-gradient-info text-white ms-0 py-1 px-3 m-0" wire:click.prevent="applyDiscountGroup()">Apply {{$customerDiscontGroupCode}} Discount Group</button> 
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
        </div>
    </div>
</main>
@push('custom_script')
@endpush