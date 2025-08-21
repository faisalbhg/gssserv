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
                                    <?php $discountDetails = isset($sectionServiceList['discountDetails'])?$sectionServiceList['discountDetails']:null; ?>
                                    @if($sectionServiceList->UnitPrice!=0)
                                    <div class="col-md-6 col-sm-6">
                                        
                                        <div class="bg-gray-100 shadow my-3 p-2">
                                            <div class="row mb-1">
                                                <div class="col-12">
                                                    <p class="text-sm text-center font-weight-bold text-dark">{{$sectionServiceList->ItemCode}} - {{$sectionServiceList->ItemName}}</p>
                                                    
                                                    @if(in_array($sectionServiceList->ItemCode,config('global.extra_description_applied')))
                                                    <textarea style="padding-left: 5px !important;" class="form-control" placeholder="Descriptions..!" wire:model="extra_description.{{$sectionServiceList->ItemId}}"></textarea >
                                                    @error('extra_description.'.$sectionServiceList->ItemId) <span class="text-danger">Descriptions Required..!</span> @enderror

                                                    <input type="number" style="padding-left: 5px !important;display:none;" class="w-50 mt-2 form-control" placeholder="Discount Amount..!" wire:model="mechanical_discount.{{$sectionServiceList->ItemId}}" />

                                                    @endif

                                                    @if(in_array($sectionServiceList->ItemCode,config('global.extra_notes_applied')))
                                                    <textarea style="padding-left: 5px !important;" class="form-control" placeholder="Notes..!" wire:model="extra_note.{{$sectionServiceList->ItemId}}"></textarea >
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                @if($sectionServiceList->CustomizePrice==1)
                                                
                                                <div class="col-12">
                                                    <input type="number" class="form-control w-50 float-start" placeholder="Price {{$sectionServiceList->MinPrice}} - {{$sectionServiceList->MaxPrice}}" wire:model="customise_service_item_price.{{$sectionServiceList->ItemId}}" style="padding-left:5px !important;" >
                                                </div>
                                                @error('customise_service_item_price.'.$sectionServiceList->ItemId) <span class="text-danger">Price Required..!</span> @enderror
                                                @else
                                                <div class="col-12">
                                                    <div class="d-flex border-radius-lg p-0 mt-2">
                                                        <p class="w-100 text-md font-weight-bold text-dark my-auto me-2 float-start">
                                                        <span class="float-start" @if($discountDetails != null) style="text-decoration: line-through;" @endif >
                                                            <span class=" text-sm me-1">{{config('global.CURRENCY')}}</span> {{custom_round($sectionServiceList->UnitPrice)}}
                                                        </span>
                                                        @if($discountDetails != null)
                                                        <span  class="float-end">
                                                        <span class=" text-sm me-1">{{config('global.CURRENCY')}}</span> {{ custom_round($sectionServiceList->UnitPrice-(($discountDetails['DiscountPerc']/100)*$sectionServiceList->UnitPrice)) }}
                                                        </span>
                                                        @endif
                                                        </p>
                                                        
                                                    </div>
                                                </div>
                                                @endif
                                                

                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="d-flex border-radius-lg p-0 mt-2">
                                                        @if($discountDetails != null)
                                                        <span class="badge bg-gradient-info">{{custom_round($discountDetails['DiscountPerc'])}}%off</span>
                                                        @endif
                                                        @if($sectionServiceList->ItemCode==  config('global.ceramic.discount_in') && $selectedVehicleInfo->ceramic_wash_discount_count < 1)
                                                        <input type="number" style="padding-left: 5px !important;" class="form-control w-50" placeholder="{{$sectionServiceList->ItemName}} Discount Count..!" wire:model="ceramic_dicount.{{$sectionServiceList->ItemId}}">
                                                        @elseif($sectionServiceList->ItemCode==  config('global.ceramic.discount_in'))
                                                        Balance: {{$selectedVehicleInfo->ceramic_wash_discount_count}}
                                                        @endif
                                                        
                                                        <a href="javascript:;" class="btn bg-gradient-primary mb-0 ms-auto btn-sm"  wire:click="addtoCart('{{$sectionServiceList}}','{{$discountDetails}}')">Add Now</a>
                                                        
                                                        
                                                    </div>
                                                </div>
                                            </div>


                                            
                                            
                                            
                                            @if(@$serviceAddedMessgae[$sectionServiceList->ItemCode])
                                            <div class="text-center">
                                                <span class="alert-icon"><i class="ni ni-like-2 text-success"></i></span>
                                                <span class="alert-text text-success"><strong>Success!</strong> Added serves!</span>
                                                <button type="button" class="btn-close text-success" data-bs-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            @endif
                                            @if(@$customizedErrorMessage[$sectionServiceList->ItemId])
                                            <div class="text-center">
                                                
                                                <span class="alert-text text-danger"><strong>Error!</strong> Enter valied price!</span>
                                                <button type="button" class="btn-close text-danger" data-bs-dismiss="alert" aria-label="Close">
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
                                <div wire:loading wire:target="addtoCartCP">
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