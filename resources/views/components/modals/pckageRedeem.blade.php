

<!-- Modal -->
<div wire:ignore.self class="modal fade" id="pckageRedeemModal" tabindex="-1" role="dialog" aria-labelledby="pckageRedeemModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-header" style="display:inline !important;">
                <div class="d-sm-flex justify-content-between">
                    <div>
                      <h5 class=" modal-title" id="pckageRedeemModalLabel">Package Redeem</h5>
                    </div>
                </div>
                
            </div>
            
            <div class="modal-body">
                <div class="card h-100">
                    <div class="card-header text-left p-2 pb-0">
                        <h5>Redeem Packages</h5>
                    </div>
                    <div class="card-body text-lg-start text-left pt-0 p-2">
                        @if($showPackageOtpVerify)
                        <div class="row">
                            <div class="col-md-12 col-sm-12 mb-0" >
                                <div class="card p-2 mb-4">
                                    
                                    <div class="card-body text-lg-left text-center pt-0">
                                        <label for="packageOTPVerify">Package OTP Verify</label>
                                        <div class="form-group">
                                            <input type="numer" class="form-control" placeholder="Package OTP Verify..!" aria-label="Package OTP Verify..!" aria-describedby="button-addon4" id="packageOTPVerify" wire:model.defer="package_otp">
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
                        
                        
                        
                    </div>
                </div>
            </div>
       </div>
    </div>
</div>
