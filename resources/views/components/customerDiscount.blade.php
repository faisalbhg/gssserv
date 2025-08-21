<div class="card  h-100 cursor-pointer">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 my-2">
                                            <button type="button" class="btn btn-outline-primary" >Discount: {{str_replace("_"," ",strtolower($selectedDiscount['title']))}}</button>
                                        </div>
                                        <div class="col-lg-10 col-sm-8 text-center" >
                                            @if($searchStaffId)
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="employeeId">Employee Id</label>
                                                        <input type="text" class="form-control" wire:model="employeeId" id="employeeId" placeholder="Staff/Employee Id">
                                                        @error('employeeId') <span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <button type="button" class="btn bg-gradient-primary" wire:click="checkLineStaffDiscountGroup()">Check Employee</button>
                                                    <div wire:loading wire:target="checkLineStaffDiscountGroup">
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
                                            @if($discountCardApplyForm)
                                                <div class="row mb-0">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="discountCardImgae">Discount Card Imgae</label>
                                                            <input type="file" class="form-control" wire:model.defer="discount_card_imgae">
                                                            @error('discount_card_imgae') <span class="text-danger">{{ $message }}</span> @enderror
                                                            @if ($discount_card_imgae)
                                                            <img class="img-fluid border-radius-lg w-30" src="{{ $discount_card_imgae->temporaryUrl() }}">
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="discountCardNumber">Discount Card Number</label>
                                                            <input type="text" class="form-control" wire:model="discount_card_number" placeholder="Discount Card Number">
                                                            @error('discount_card_number') <span class="text-danger">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="discountCardValidity">Discount Card Validity</label>
                                                            <input type="date" class="form-control" id="discountCardValidity" wire:model="discount_card_validity" name="discountCardValidity" placeholder="Discount Card Validity" min="<?php echo date("Y-m-d"); ?>">
                                                            @error('discount_card_validity') <span class="text-danger">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                
                                                    <div class="col-md-12">
                    
                                                        <button type="button" class="btn bg-gradient-dark cursor-pointer " wire:click="clickLineDiscountGroup()" formmethod="">Back</button>
                                                        <button type="button" class="btn bg-gradient-primary " wire:click="saveSelectedLineDiscountGroup()">Save changes</button>
                                                        <div wire:loading wire:target="clickLineDiscountGroup">
                                                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                                <div class="la-ball-beat">
                                                                    <div></div>
                                                                    <div></div>
                                                                    <div></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div wire:loading wire:target="saveSelectedLineDiscountGroup">
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
                                            @if($engineOilDiscountForm)
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 my-2">
                                                        <div wire:click="selectEngineOilLineDiscount(10)" class="card bg-cover text-center cursor-pointer" style="background-image: url('https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/curved-images/curved1.jpg')">
                                                            <div class="card-body z-index-2 py-2">
                                                                <h2 class="text-white">10%</h2>
                                                                <p class="text-white">
                                                                10% Discount on Special Selected Engine Oil & Selected Wash Service</p>
                                                                <btn class="btn bg-gradient-dark text-light">Select & Apply</btn>
                                                            </div>
                                                            <div class="mask bg-gradient-primary border-radius-lg"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 my-2">
                                                        <div wire:click="selectEngineOilLineDiscount(15)" class="card bg-cover text-center cursor-pointer" style="background-image: url('https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/curved-images/curved1.jpg')">
                                                            <div class="card-body z-index-2 py-2">
                                                                <h2 class="text-white">15%</h2>
                                                                <p class="text-white">
                                                                15% Discount on Special Selected Engine Oil & Selected Wash Service</p>
                                                                <btn class="btn bg-gradient-dark text-light">Select & Apply</btn>
                                                            </div>
                                                            <div class="mask bg-gradient-primary border-radius-lg"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 my-2">
                                                        <div wire:click="selectEngineOilLineDiscount(20)" class="card bg-cover text-center cursor-pointer" style="background-image: url('https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/curved-images/curved1.jpg')">
                                                            <div class="card-body z-index-2 py-2">
                                                                <h2 class="text-white">20%</h2>
                                                                <p class="text-white">
                                                                20% Discount on Special Selected Engine Oil & Selected Wash Service</p>
                                                                <btn class="btn bg-gradient-dark text-light">Select & Apply</btn>
                                                            </div>
                                                            <div class="mask bg-gradient-primary border-radius-lg"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 my-2">
                                                        <div wire:click="selectEngineOilLineDiscount(25)" class="card bg-cover text-center cursor-pointer" style="background-image: url('https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/curved-images/curved1.jpg')">
                                                            <div class="card-body z-index-2 py-2">
                                                                <h2 class="text-white">25%</h2>
                                                                <p class="text-white">
                                                                25% Discount on Special Selected Engine Oil & Selected Wash Service</p>
                                                                <btn class="btn bg-gradient-dark text-light">Select & Apply</btn>
                                                            </div>
                                                            <div class="mask bg-gradient-primary border-radius-lg"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div wire:loading wire:target="selectEngineOilLineDiscount">
                                                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                        <div class="la-ball-beat">
                                                            <div></div>
                                                            <div></div>
                                                            <div></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($manulDiscountForm)
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h4 class="text-start" >Manual Discount Amount</h4>
                                                        <div class="row text-start">
                                                            <div class="col-md-4 col-sm-4">
                                                                <div class="form-check mb-3">
                                                                    <input class="form-check-input" type="radio" name="manualDiscountType" id="manualDiscountType1" wire:model="manualDiscountValueType" value="amount">
                                                                    <label class="custom-control-label" for="manualDiscountType1">Amount</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-sm-4">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="manualDiscountType" id="manualDiscountType2" wire:model="manualDiscountValueType" value="percentage">
                                                                    <label class="custom-control-label" for="manualDiscountType2">Percentage</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row text-start">
                                                            <div class="col-md-6 col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Manual Discount</label>
                                                                    <input type="number" class="form-control" wire:model="manualDiscountValue" id="manualDiscountValue" placeholder="Manual Discount">
                                                                    @error('manualDiscountValue') <span class="text-danger">{{ $message }}</span> @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Manual Discount Remarks</label>
                                                                    <textarea class="form-control" wire:model="manualDiscountRemarks" id="manualDiscountRemarks" placeholder="Manual Discount Remarks"></textarea>
                                                                    @error('manualDiscountRemarks') <span class="text-danger">{{ $message }}</span> @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            
                                                            <div class="col-12 mt-4">
                                                                <button type="button" class="btn btn-sm bg-gradient-primary float-end" wire:click="saveManulDiscountAproval()">Apply Discount</button>
                                                                <div wire:loading wire:target="saveManulDiscountAproval">
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
                                        </div>
                                    </div>
                                 </div>
                            </div>