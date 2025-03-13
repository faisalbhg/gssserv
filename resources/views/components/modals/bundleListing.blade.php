            <!-- Modal -->
            <style type="text/css">
                .modal-body{
                    max-height: calc(100vh - 50px);
                    overflow-y: auto;
                }
            </style>
            <div class="modal fade" id="bundlePriceModelList" tabindex="-1" role="dialog" aria-labelledby="bundlePriceModelListLabel" aria-hidden="true" wire:ignore.self style="z-index:99999;" >
                <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:95%;">
                    <div class="modal-content">
                        
                        <div class="modal-header">
                            <h5 class="modal-title" id="bundlePriceModelListLabel">{{$selectedBundles['Description']}}</h5>
                            
                            <button type="button" class="btn-close text-dark " style="font-size: 2.125rem !important;" data-bs-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true" class="text-xl">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body py-0">
                            <div class="row">
                                @foreach($bundleServiceLists as $bdlerviceList)
                                    <div class="col-lg-4 col-md-4 col-sm-4 mb-4">
                                        <div class="card">
                                            <div class="card-header text-center p-2">
                                                <span class="badge rounded-pill {{config('global.bundles.type_class')[$bdlerviceList['BundleDiscountType']]}} text-light text-bold text-capitalize" style="white-space: inherit;">{{config('global.bundles.type')[$bdlerviceList['BundleDiscountType']]}}</span>
                                            </div>
                                            <div class="card-body text-lg-start text-left p-2">
                                                <ul class="list-group">
                                                    <?php
                                                    $totPriceBfDis =0;
                                                    $totPriceAfDis =0;
                                                    ?>
                                                    @foreach($bdlerviceList['lists'] as $bdllists)
                                                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                        <div class="d-flex flex-column">
                                                            <h6 class="mb-1 text-dark font-weight-bold text-sm">{{$bdllists['ItemName']}}</h6>
                                                            <span class="text-xs">#{{$bdllists['ServiceItemCode']}}</span>
                                                                <span class="badge bg-gradient-danger">{{$bdllists['DiscountPerc']}}% OFF</span>
                                                            <?php $unitPrice=0; ?>
                                                            @if($bdllists['Type']=='S')
                                                                <span class="text-sm">No.Services: {{round($bdllists['Qty'])}}</span>
                                                                <?php
                                                                $unitPriceBfDiscount = $bdllists['services']['UnitPrice'];
                                                                $totPriceBfDis = $totPriceBfDis+$unitPriceBfDiscount;
                                                                $unitPriceAfDiscount = $bdllists['services']['UnitPrice']-(($bdllists['DiscountPerc']/100)*$bdllists['services']['UnitPrice']);
                                                                $totPriceAfDis = $totPriceAfDis+$unitPriceAfDiscount;


                                                                ?>
                                                            @elseif($bdllists['Type']=='I')
                                                            <span class="text-sm">No.Items: {{round($bdllists['Qty'])}}</span>
                                                                <?php
                                                                $unitPriceBfDiscount = $bdllists['items']['UnitPrice'];
                                                                $totPriceBfDis = $totPriceBfDis+$unitPriceBfDiscount;
                                                                $unitPriceAfDiscount = $bdllists['items']['UnitPrice']-(($bdllists['DiscountPerc']/100)*$bdllists['items']['UnitPrice']);
                                                                $totPriceAfDis = $totPriceAfDis+$unitPriceAfDiscount;
                                                                ?>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex align-items-center text-sm">
                                                            <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4">
                                                            <span style="text-decoration:line-through;" class="text-muted">{{config('global.CURRENCY')}}{{custom_round($unitPriceBfDiscount)}}</span>
                                                            <span>{{config('global.CURRENCY')}}{{custom_round($unitPriceAfDiscount)}}</span>
                                                            </button>
                                                        </div>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                                <!-- @foreach($bdlerviceList['lists'] as $bdllists)
                                                <div class="d-flex justify-content-lg-start p-2">
                                                    <div class="icon icon-shape icon-xs rounded-circle bg-gradient-dark shadow text-center">
                                                        <i class="fas fa-minus opacity-10"></i>
                                                    </div>
                                                    
                                                    <div>
                                                        <span>{{$bdllists['ItemName']}}</span>
                                                        <br>Qty: {{round($bdllists['Qty'])}}
                                                    </div>
                                                </div>
                                                @endforeach -->
                                                
                                                <h5 class="font-weight-bold mt-2 text-center">
                                                    <span class="text-muted" style="text-decoration:line-through;"><small>{{config('global.CURRENCY')}}</small>{{custom_round($totPriceBfDis)}} </span>
                                                    <small>{{config('global.CURRENCY')}}</small>{{custom_round($totPriceAfDis)}}
                                                </h5>
                                                <div class="text-center">
                                                    <?php
                                                    $button_allowed=false;
                                                    if($bdlerviceList['BundleDiscountType']==1){
                                                        $button_allowed=true;
                                                    }
                                                    else if($bdlerviceList['BundleDiscountType']==2)
                                                    {
                                                        if(!empty($appliedDiscount))
                                                        {
                                                            if($appliedDiscount['groupType'] !=2 && $appliedDiscount['groupType'] !=6)
                                                            {
                                                                if($appliedDiscount['id']!=9 && $appliedDiscount['id']!=41)
                                                                {
                                                                    $button_allowed=true;
                                                                }
                                                                else
                                                                {
                                                                    $button_allowed=false;
                                                                }
                                                            }
                                                        }
                                                        else
                                                        {
                                                            $button_allowed=false;
                                                        }
                                                    }
                                                    else if($bdlerviceList['BundleDiscountType']==3)
                                                    {
                                                        if(!empty($appliedDiscount))
                                                        {
                                                            if(@$appliedDiscount['groupType']!=2 && @$appliedDiscount['groupType']!=6)
                                                            {
                                                                if($appliedDiscount['id']==9 && $appliedDiscount['id']!=41 )
                                                                {
                                                                    $button_allowed=true;
                                                                }
                                                                else
                                                                {
                                                                    $button_allowed=false;
                                                                }
                                                            }
                                                        }
                                                        else
                                                        {
                                                            $button_allowed=false;
                                                        }
                                                    }
                                                    ?>
                                                    @if($button_allowed)
                                                    <a class="btn btn-icon {{config('global.bundles.type_class')[$bdlerviceList['BundleDiscountType']]}} d-lg-block mt-3 mb-0"  wire:click="bundleAddtoCart('{{json_encode($bdlerviceList)}}')">Buy Now <i class="fas fa-arrow-right ms-1"></i></a>
                                                    @endif

                                                    @if(!$button_allowed)
                                                    <a class="btn btn-icon {{config('global.bundles.type_class')[$bdlerviceList['BundleDiscountType']]}} d-lg-block mt-3 mb-0 opacity-4">Buy Now <i class="fas fa-arrow-right ms-1"></i></a>
                                                    @endif
                                                    
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div wire:loading wire:target="bundleAddtoCart">
                                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                    <div class="la-ball-beat">
                                        <div></div>
                                        <div></div>
                                        <div></div>
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