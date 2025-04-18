@if($priceDetails->ItemCode=='S403')
                                            <div class="row" >
                                                
                                                    <div class="form-group">
                                                        <a href="javascript:;" class="btn bg-gradient-dark mb-0 ms-auto btn-sm mb-2"  wire:click="manualDiscount('{{$priceDetails}}')">APply Manual Discount</a>
                                                        @if(isset($showManulDiscount[$priceDetails->ItemCode]))
                                                        <input type="number" style="padding-left: 5px !important;" class="form-control w-20" placeholder="%" wire:model="manualDiscountInput.{{$priceDetails->ItemId}}">
                                                        <a href="javascript:;" class="btn bg-gradient-info mb-0 ms-auto btn-sm my-2"  wire:click="addApplyManualDiscount()">Send Otp</a> 
                                                        @endif
                                                    </div>
                                            </div>
                                            @endif