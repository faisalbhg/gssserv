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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if($showCheckout)
            <div class="row mt-3">
                <div class="col-md-6 col-sm-6 mb-4" >
                    <div class="card h-100">
                        <div class="card-header text-center pt-4 pb-3">
                            <span class="badge rounded-pill bg-light {{config('global.package.type')[$packageInfo->PackageType]['bg_class']}} {{config('global.package.type')[$packageInfo->PackageType]['text_class']}}">{{config('global.package.type')[$packageInfo->PackageType]['title']}}</span>
                            <h4>{{$packageInfo->PackageName}}</h4>
                            @if($packageInfo->Duration)
                            <p class="text-sm font-weight-bold text-dark mt-2 mb-0">Duration: {{$packageInfo->Duration}} Months</p>
                            @endif
                            @if($packageInfo->PackageKM)
                            <p class="text-sm font-weight-bold text-dark">{{$packageInfo->PackageKM}} K.M</p>
                            @endif
                            
                        </div>
                        <div class="card-body text-lg-start text-left pt-0">
                            <?php $totalPrice=0;?>
                            <?php $unitPrice=0;?>
                            <?php $discountedPrice=0;?>
                            @foreach($packageInfo->packageDetails as $packageDetails)
                                @if($packageDetails->isDefault==1)
                                <div class="d-flex justify-content-lg-center p-2">
                                    
                                    <div class="icon icon-shape icon-xs rounded-circle bg-gradient-success shadow text-center">
                                        <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                    </div>
                                    <?php $totalPrice = $totalPrice+($packageDetails->UnitPrice*$packageDetails->Quantity); ?>
                                    <?php $unitPrice = $unitPrice+($packageDetails->UnitPrice*$packageDetails->Quantity); ?>
                                    <?php $discountedPrice = $discountedPrice+($packageDetails->DiscountedPrice*$packageDetails->Quantity); ?>
                                    
                                    
                                    <div>
                                        @if($packageDetails->ItemType=='S')
                                        <span class="ps-3">{{$packageDetails->Quantity}} x {{$packageDetails->labourItemDetails['ItemName']}}</span>
                                        @else
                                        <span class="ps-3">{{$packageDetails->inventoryItemDetails['ItemName']}}</span>
                                        @endif
                                        <p class="ps-3 h6"><small><s>AED {{custom_round($packageDetails->UnitPrice)}}</s> {{custom_round($packageDetails->DiscountedPrice)}}</small></p>
                                    </div>
                                </div>
                                @endif  
                            @endforeach
                            
                            <h3 class="text-default font-weight-bold mt-2"></h3>
                            <p class="text-center h4"><s><small>AED</small> {{custom_round($totalPrice)}}</s> <small>AED</small> {{custom_round($discountedPrice)}}</p>
                            <div class="text-center align-center">

                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="col-md-6 col-sm-6 mb-4" >
                    <div class="card p-2 mb-4 h-100">
                        <div class="card-header text-center pt-4 pb-3">
                            
                            <h4 class="font-weight-bold mt-2">Payment Confirmation</h4>
                            <hr>
                            
                        </div>
                        <div class="card-body text-lg-left text-center pt-0">
                            <p><span class="badge rounded-pill bg-light text-dark text-md">Total: <small>AED</small> {{ custom_round($total) }}</span></p>
                            @if($totalDiscount>0 )
                            <p><span class="badge rounded-pill bg-light text-dark text-md">Discount: <small>AED</small> {{ custom_round($totalDiscount) }}</span></p>
                            @endif
                            <p><span class="badge rounded-pill bg-light text-dark text-md">VAT: <small>AED</small> {{ custom_round($tax) }}</span></p>
                            <p><span class="badge rounded-pill bg-dark text-light text-lg text-bold">Grand total: <small>AED</small> {{ round(($grand_total)) }}</span></p>
                            
                            
                        </div>
                        <div class="card-footer text-lg-left text-center pt-0">
                            <div class="d-flex justify-content-center p-2">
                                <div class="form-check">
                                    <a wire:click="confirmPackage()" class="btn btn-icon bg-gradient-info d-lg-block mt-3 mb-0">Confirm & Submit Package</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if($showOtpVerify)
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
                <div class="col-md-12 col-sm-12 mb-4" id="packageOTPVerifyRow">
                    <div class="card p-2 mb-4">
                        
                        <div class="card-body text-lg-left text-center pt-0">
                            <label for="packageOTPVerify">Package OTP Verify</label>
                            <div class="input-group">
                                <input type="numer" class="form-control" placeholder="Package OTP Verify..!" aria-label="Package OTP Verify..!" aria-describedby="button-addon4" id="packageOTPVerify" wire:model.defer="package_otp">
                                <button class="btn btn-outline-success mb-0" type="button" wire:click="verifyPackageOtp">Verify</button>
                                <button class="btn btn-outline-info mb-0" type="button"  wire:click="resendPackageOtp">Resend</button>
                            </div>
                            @error('package_otp') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                            @if($otp_message)<span class="mb-4 text-danger">{{ $otp_message }}</span>@endif
                        </div>
                    </div>
                </div>
                @endif
                @if($otpVerified)
                    <div class="row mt-3">
                        <div class="col-xxs-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-4">
                            <div class="card">
                                <div class="card-header text-left pt-4 pb-3">
                                    <h5 class="font-weight-bold mt-2">Signature</h5>
                                </div>
                                <div class="card-body text-left pt-0">
                                    <button type="button" class="btn btn-primary btn-lg" wire:click="clickShowSignature()">Customer Signature</button>
                                    <div wire:loading wire:target="clickShowSignature">
                                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                            <div class="la-ball-beat">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
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
                        <div class="col-md-12 col-sm-12 mb-4" id="packagePaymentRow">
                            <div class="card p-2 mb-4">
                                
                                <div class="card-body text-lg-left text-center pt-0">
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
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>

            <div wire:loading wire:target="confirmPackage">
                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                    <div class="la-ball-beat">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <div wire:loading wire:target="verifyPackageOtp">
                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                    <div class="la-ball-beat">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <div wire:loading wire:target="resendPackageOtp">
                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                    <div class="la-ball-beat">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
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
        @endif
        @if($successPage)
            <div class="row mt-3">
                <div class="col-md-12 mb-4" >
                    <div class="card p-2 mb-4 bg-cover text-center" style="background-image: url('https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/curved-images/curved1.jpg')">
                        <div class="card-body z-index-2 py-2">
                            <h2 class="text-white">Successful..!</h2>
                            <p class="text-white">The package in created successfully</p>
                            <button type="button" class=" text-white btn bg-gradient-default selectVehicle py-2 "  >Package Number: {{$package_number}}</button>
                        </div>
                        <div class="mask bg-gradient-success border-radius-lg"></div>
                    </div>
                </div>
            </div>
            <div wire:loading wire:target="dashCustomerJobUpdate">
                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                    <div class="la-ball-beat">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
        @endif
        @if($showCustomerSignature)
        @include('components.modals.customerSignatureModel')
        @endif
    </div>
</main>
@push('custom_script')
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