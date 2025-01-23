<!-- Modal -->
            <style type="text/css">
                .modal-body{
                    max-height: calc(100vh - 300px);
                    overflow-y: auto;
                }
            </style>
            <div class="modal fade" id="discountGroupModal" tabindex="-1" role="dialog" aria-labelledby="discountGroupModalLabel" aria-hidden="true" wire:ignore.self style="z-index:99999;" >
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width:90%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="discountGroupModalLabel">Discount Groups</h5>
                            <button type="button" class="btn-close text-dark " data-bs-dismiss="modal" aria-label="Close" style="font-size: 2.125rem !important;" >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body py-0">
                            @if(count($selectedVehicleInfo->customerDiscountLists)>0)
                                <div class="row">

                                    <h6><u>Saved Customer Discounts</u></h6>
                                    @forelse($selectedVehicleInfo->customerDiscountLists as $customerDiscountLists)
                                        <div class="col-lg-2 col-sm-3 my-2">
                                            @if($customerDiscountLists->discount_id==8 || $customerDiscountLists->discount_id==9)
                                            <?php $expired=false; $bgbackground= "bg-gradient-info";?>
                                            @else
                                                <?php $end = \Carbon\Carbon::parse($customerDiscountLists->discount_card_validity);$expired=false;?>
                                                @if(\Carbon\Carbon::now()->diffInDays($end, false)>=0)
                                                <?php $bgbackground= "bg-gradient-info";?>
                                                @else
                                                <?php $bgbackground= "bg-gradient-danger";$expired=true;?>
                                                @endif

                                            @endif
                                            <div @if(!$expired) wire:click="savedCustomerDiscountGroup({{$customerDiscountLists}})" @endif class="card cursor-pointer {{$bgbackground}}">
                                                <div class="card-body  py-2">
                                                    <h6 class="font-weight-bold text-capitalize text-center text-sm text-light mb-0">{{strtolower($customerDiscountLists->discount_title)}}</h6>
                                                </div>

                                            </div>
                                            @if($customerDiscountLists->discount_id==8 || $customerDiscountLists->discount_id==9)
                                                    
                                                    @else
                                                    <small>Expired in: {{ $diff = Carbon\Carbon::parse($customerDiscountLists->discount_card_validity)->diffForHumans(Carbon\Carbon::now()) }}   </small>
                                                    @endif
                                        </div>
                                    @empty
                                    @endforelse
                                    <div wire:loading wire:target="savedCustomerDiscountGroup">
                                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                            <div class="la-ball-beat">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            @endif
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    @error('$selectedDiscountId') <span class="text-danger">{{ $message }}</span> @enderror
                                    @if($discountSearch)
                                        <div class="row">
                                            @forelse($customerGroupLists as $listCustDiscGrp)
                                            <div class="col-lg-2 col-sm-4 my-2">
                                                <div wire:click="selectDiscountGroup({{$listCustDiscGrp}})" class="card h-100 cursor-pointer">
                                                    <div class="card-body py-3">
                                                        <h6 class="font-weight-bold text-capitalize text-center text-sm">{{strtolower(str_replace("_"," ",$listCustDiscGrp->Title))}}</h6>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                            @endforelse
                                        </div>
                                    @else
                                        <div class="row">
                                            @if($selectedDiscount)
                                            <div class="col-lg-2 col-sm-4 my-2">
                                                <div class="card  h-100 cursor-pointer">
                                                    <div class="card-body">
                                                        <button type="button" class="btn bg-gradient-primary" >{{str_replace("_"," ",strtolower($selectedDiscount['title']))}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="col-lg-10 col-sm-8 text-center">
                                                <div class="row">
                                                    <p class="badge bg-gradient-danger text-light text-bold text-lg mb-0">{{$staffavailable}}</p>
                                                    @if($discountForm)
                                                        @if($searchStaffId)
                                                            <div class="row mb-0">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="employeeId">Employee Id</label>
                                                                        <input type="text" class="form-control" wire:model="employeeId" id="employeeId" placeholder="Staff/Employee Id">
                                                                        @error('employeeId') <span class="text-danger">{{ $message }}</span> @enderror
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-12">
                                                                    <button type="button" class="btn bg-gradient-primary" wire:click="checkStaffDiscountGroup()">Check Employee</button>
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
                                
                                                                    <button type="button" class="btn bg-gradient-dark cursor-pointer " wire:click="clickDiscountGroup()" formmethod="">Back</button>
                                                                    <button type="button" class="btn bg-gradient-primary " wire:click="saveSelectedDiscountGroup()">Save changes</button>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if($engineOilDiscountForm)
                                                            <div class="row">
                                                                <div class="col-md-6 col-sm-6 my-2">
                                                                    <div wire:click="selectEngineOilDiscount(10)" class="card bg-cover text-center cursor-pointer" style="background-image: url('https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/curved-images/curved1.jpg')">
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
                                                                    <div wire:click="selectEngineOilDiscount(15)" class="card bg-cover text-center cursor-pointer" style="background-image: url('https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/curved-images/curved1.jpg')">
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
                                                                    <div wire:click="selectEngineOilDiscount(20)" class="card bg-cover text-center cursor-pointer" style="background-image: url('https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/curved-images/curved1.jpg')">
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
                                                                    <div wire:click="selectEngineOilDiscount(25)" class="card bg-cover text-center cursor-pointer" style="background-image: url('https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/curved-images/curved1.jpg')">
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
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                        </div>
                        <div wire:loading wire:target="selectEngineOilDiscount">
                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                <div class="la-ball-beat">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                        </div>
                        
                        <div wire:loading wire:target="selectDiscountGroup">
                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                <div class="la-ball-beat">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                        </div>
                        <div wire:loading wire:target="checkStaffDiscountGroup">
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
                        
                        
                        
                        <div class="modal-footer">
                            
                        </div>
                    </div>
                </div>
            </div>