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
    </div>
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
                        <label for="ctNumberInput">Meter ID </label>
                        <div class="input-group mb-0">
                            <input class="form-control" placeholder="Meter ID" type="text" wire:model="meter_id" name="ct_number" minlength="1" maxlength="7" id="ctNumberInput">
                        </div>
                        @error('meter_id') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-2 col-sm-2">
                    <label for="plateImageFile" >Plate Image</label>
                    <div 
                    x-data="{ isUploading: false, progress: 0 }" 
                    x-on:livewire-upload-start="isUploading = true" 
                    x-on:livewire-upload-finish="isUploading = false" 
                    x-on:livewire-upload-error="isUploading = false" 
                    x-on:livewire-upload-progress="progress = $event.detail.progress" 
                    >
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
                <div class="col-md-2 col-sm-2">
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
                        <div class="card-header text-center pt-4 pb-3">
                            <h5 class="font-weight-bold mt-2">Exterior Vehicle Images</h5>
                        </div>
                        <div class="card-body text-left pt-0">
                            <div class="row">

                                <div class="col-md-6 col-sm-6">
                                    <input type="file" id="file1" wire:model="vImageR1" accept="image/*" capture style="display:none"/>
                                    <img class="w-75 float-end" id="upfile1" src="@if($vImageR1) {{$vImageR1->temporaryUrl()}} @else {{asset('img/checklist/car1.png')}} @endif" style="cursor:pointer"  />
                                    @error('vImageR1') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <input type="file" id="file2" wire:model="vImageR2" accept="image/*" capture style="display:none"/>
                                    <img class="w-75 float-start" id="upfile2" src="@if ($vImageR2) {{ $vImageR2->temporaryUrl() }} @else {{asset('img/checklist/car2.png')}} @endif" style="cursor:pointer"  />
                                    @error('vImageR2') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                                <hr>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <input type="file" id="file3" wire:model="vImageF" accept="image/*" capture style="display:none"/>
                                    <img class="w-75 float-end" id="upfile3" src="@if ($vImageF) {{ $vImageF->temporaryUrl() }} @else {{asset('img/checklist/car3.jpg')}} @endif" style="cursor:pointer"  />
                                    @error('vImageF') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <input type="file" id="file4" wire:model="vImageB" accept="image/*" capture style="display:none"/>
                                    <img class="w-75 float-start" id="upfile4" src="@if ($vImageB) {{ $vImageB->temporaryUrl() }} @else {{asset('img/checklist/car4.jpg')}} @endif" style="cursor:pointer"  />
                                    @error('vImageB') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                                <hr>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <input type="file" id="file5" wire:model="vImageL1" accept="image/*" capture style="display:none"/>
                                    <img class="w-75 float-end" id="upfile5" src="@if ($vImageL1) {{ $vImageL1->temporaryUrl() }} @else {{asset('img/checklist/car5.png')}} @endif" style="cursor:pointer"  />
                                    @error('vImageL1') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <input type="file" id="file6" wire:model="vImageL2" accept="image/*" capture style="display:none"/>
                                    <img class="w-75 float-start" id="upfile6" src="@if ($vImageL2) {{ $vImageL2->temporaryUrl() }} @else {{asset('img/checklist/car6.png')}} @endif" style="cursor:pointer"   />
                                    @error('vImageL2') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header text-center pt-4 pb-3">
                            <h5 class="font-weight-bold mt-2">Interior Vehicle Images</h5>
                        </div>
                        <div class="card-body text-left pt-0">
                            <div class="row m-4">

                                <div class="col-md-12 col-sm-12">
                                    <input type="file" id="roofImgFile" multiple wire:model="roof_images" accept="image/*" capture style="display:none"/>
                                    <img class="w-100" id="roofimg" src="@if($roof_images) {{$roof_images->temporaryUrl()}} @else {{asset('img/roofimage1.jpg')}} @endif" style="cursor:pointer"  />
                                    @error('roof_images') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                            </div>
                            <div class="row m-4">
                                <div class="col-md-6 col-sm-6">
                                    <input type="file" id="dashImage1File" wire:model="dash_image1" accept="image/*" capture style="display:none"/>
                                    <img class="w-100" id="dashImage1" src="@if ($dash_image1) {{ $dash_image1->temporaryUrl() }} @else {{asset('img/dashImage1.jpg')}} @endif" style="cursor:pointer"  />
                                    @error('dash_image1') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <input type="file" id="dashImage2File" wire:model="dash_image2" accept="image/*" capture style="display:none"/>
                                    <img class="w-100" id="dashImage2" src="@if ($dash_image2) {{ $dash_image2->temporaryUrl() }} @else {{asset('img/dashImage2.jpg')}} @endif" style="cursor:pointer"  />
                                    @error('dash_image2') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                                <hr>
                            </div>
                            <div class="row m-4">
                                <div class="col-md-6 col-sm-6">
                                    <input type="file" id="passengerSeatImageFile" wire:model="passenger_seat_image" accept="image/*" capture style="display:none"/>
                                    <img class="w-100" id="passengerSeatImage" src="@if ($passenger_seat_image) {{ $passenger_seat_image->temporaryUrl() }} @else {{asset('img/passangerSeat1.jpg')}} @endif" style="cursor:pointer"  />
                                    @error('passenger_seat_image') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <input type="file" id="driverSeatImageFile" wire:model="driver_seat_image" accept="image/*" capture style="display:none"/>
                                    <img class="w-100" id="driverSeatImage" src="@if ($driver_seat_image) {{ $driver_seat_image->temporaryUrl() }} @else {{asset('img/driverSeat1.jpg')}} @endif" style="cursor:pointer"  />
                                    @error('driver_seat_image') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                                <hr>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <input type="file" id="backSeat1ImageFile" wire:model="back_seat1" accept="image/*" capture style="display:none"/>
                                    <img class="w-100" id="backSeat1Image" src="@if ($back_seat1) {{ $back_seat1->temporaryUrl() }} @else {{asset('img/backSeat1.jpg')}} @endif" style="cursor:pointer"  />
                                    @error('back_seat1') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <input type="file" id="backSeat1ImageFile" wire:model="back_seat1" accept="image/*" capture style="display:none"/>
                                    <img class="w-100" id="backSeat1Image" src="@if ($back_seat2) {{ $back_seat2->temporaryUrl() }} @else {{asset('img/backSeat2.jpg')}} @endif" style="cursor:pointer"   />
                                    @error('back_seat2') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <input type="file" id="backSeat3ImageFile" wire:model="back_seat3" accept="image/*" capture style="display:none"/>
                                    <img class="w-100" id="backSeat3Image" src="@if ($back_seat3) {{ $back_seat3->temporaryUrl() }} @else {{asset('img/backSeat1.jpg')}} @endif" style="cursor:pointer"  />
                                    @error('back_seat3') <span class="text-danger">Missing Image..!</span> @enderror
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <input type="file" id="backSeat4ImageFile" wire:model="back_seat4" accept="image/*" capture style="display:none"/>
                                    <img class="w-100" id="backSeat4Image" src="@if ($back_seat4) {{ $back_seat4->temporaryUrl() }} @else {{asset('img/backSeat2.jpg')}} @endif" style="cursor:pointer"   />
                                    @error('back_seat4') <span class="text-danger">Missing Image..!</span> @enderror
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
                                    <button type="button" id='btnSubmit' class="btn bg-gradient-primary btn-lg mui-btn float-end" wire:click="createJob();">Create Job</button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            @endif
            @include('components.modals.customerSignatureModel')
        </div>
    </div>

    

</main>
@push('custom_script')
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
 
    // Upload multiple files:
    @this.uploadMultiple('plate_number_image', [file], successCallback, errorCallback, progressCallback)
 
    // Remove single file from multiple uploaded files
    @this.removeUpload('plate_number_image', uploadedFilename, successCallback)
</script>
<script type="text/javascript">
    window.addEventListener('imageUpload',event=>{ 
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

        $("#roofimg").click(function () {
            $("#roofimgFile").trigger('click');
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
    });
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
            $('#plateCode').select2();

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

@endpush