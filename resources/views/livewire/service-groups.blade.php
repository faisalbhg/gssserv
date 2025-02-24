                    <div class="row" id="servceGroup">
                        @foreach($servicesGroupList as $servicesGroup)
                            <div class="col-sm-4 col-md-3 col-lg-2 col-xl-2 my-2">
                                <div class="card h-100" >
                                    <a wire:click="serviceGroupForm({{$servicesGroup}})" href="javascript:;">
                                        <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('{{asset("img/".str_replace(" ","-",$servicesGroup->department_name).".jpg")}}');">
                                            @if($service_group_id == $servicesGroup->id)
                                            <span class="mask bg-gradient-dark opacity-4"></span>
                                            @else
                                            <span class="mask bg-gradient-dark opacity-9"></span>
                                            @endif
                                            <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
                                                <h5 class="@if($service_group_id == $servicesGroup->id) text-primary @else text-white @endif font-weight-bolder mb-4 pt-2">{{$servicesGroup->department_name}}</h5>
                                                <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:;">
                                                    <button wire:click="serviceGroupForm({{$servicesGroup}})" class="btn @if($service_group_id == $servicesGroup->id) bg-gradient-primary @else btn-outline-light @endif" type="button" >Select</button>
                                                </a>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                        <div wire:loading wire:target="serviceGroupForm">
                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                <div class="la-ball-beat">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 col-lg-2 col-xl-2 my-2">
                            <div class="card h-100" >
                                <a wire:click="openServiceItems()" href="javascript:;">
                                    <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('{{asset("img/PP00039item.jpg")}}');">
                                        @if($selectServiceItems)
                                        <span class="mask bg-gradient-dark opacity-4"></span>
                                        @else
                                        <span class="mask bg-gradient-dark opacity-9"></span>
                                        @endif
                                        <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
                                            <h5 class="@if($selectServiceItems) text-primary @else text-white @endif font-weight-bolder mb-4 pt-2">Items</h5>
                                            <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:;">
                                                <button wire:click="openServiceItems()" class="btn @if($selectServiceItems) bg-gradient-primary @else btn-outline-light @endif" type="button" >Select</button>
                                            </a>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 col-lg-2 col-xl-2 my-2">
                            <div class="card h-100" >
                                <a wire:click="openPackages()" href="javascript:;">
                                    <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('{{asset("img/service-item-products.jpg")}}');">
                                        @if($selectPackageMenu)
                                        <span class="mask bg-gradient-dark opacity-4"></span>
                                        @else
                                        <span class="mask bg-gradient-dark opacity-9"></span>
                                        @endif
                                        <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
                                            <h5 class="@if($selectPackageMenu) text-primary @else text-white @endif font-weight-bolder mb-4 pt-2">Packages</h5>
                                            <!-- <p class="text-white">Wealth creation is an evolutionarily recent positive-sum game. It is all about who take the opportunity first.</p> -->
                                            <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:;">
                                                <button wire:click="openPackages()" class="btn @if($selectPackageMenu) bg-gradient-primary @else btn-outline-light @endif" type="button" >Select</button>
                                            </a>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>       
                    </div>

                    @if($showSectionsList)
                        <div class="row mt-2 mb-2">
                            
                            
                            @if($service_group_name=='Quick Lube')
                                @if($qlFilterOpen)
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4">
                                            <label for="seachByBrand">Engine Oil Brand</label>
                                            <div class="form-group">
                                                <select class="form-control" id="seachByBrand" wire:model="ql_search_brand" style="padding-left:5px !important;">
                                                    <option value="">-Select-</option>
                                                    @foreach($qlBrandsLists as $qlBrand)
                                                    <option value="{{$qlBrand->BrandId}}">{{$qlBrand->Description}}</option>
                                                    @endforeach
                                                </select>
                                                @error('ql_search_brand') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label></label>
                                            <div class="form-group pt-1">
                                                <button class="btn bg-gradient-primary me-2" wire:click="qlItemkmRange(5000)">5K</button>
                                                <button class="btn bg-gradient-primary" wire:click="qlItemkmRange(10000)">10K</button>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label for="seachByCategory">Category</label>
                                                <select class="form-control" id="seachBy Category" wire:model="ql_search_category" wire:change="qlCategorySelect" style="padding-left:5px !important;">
                                                    <option value="">-Select-</option>
                                                    @foreach($itemQlCategories as $itemQlCategory)
                                                    <option value="{{$itemQlCategory->CategoryId}}">{{$itemQlCategory->Description}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:loading wire:target="qlItemkmRange,qlCategorySelect">
                                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                            <div class="la-ball-beat">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-8 col-sm-8">
                                            <div class="form-group">
                                                <label for="seachByItemBrand">Items Name</label>
                                                <input type="text" wire:model.defer="quickLubeItemSearch" name="" class="form-control">
                                            </div>
                                            @error('quickLubeItemSearch') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label></label>
                                            <div class="form-group pt-1">
                                                <!-- <input type="text" wire:model.defer="quickLubeItemSearch" name="" class="form-control"> -->
                                                <button class="btn bg-gradient-info" wire:click="searchQuickLubeItem">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:loading wire:target="searchQuickLubeItem">
                                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                            <div class="la-ball-beat">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if($showQlItems)
                                    <div class="row mt-4"  id="serviceQlItems">
                                        @if (session()->has('cartsuccess'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <span class="alert-icon text-light"><i class="ni ni-like-2"></i></span>
                                                <span class="alert-text text-light"><strong>Success!</strong> {{ Session::get('cartsuccess') }}</span>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif
                                        @forelse($quickLubeItemsList as $quickLubeItem)
                                            <?php $qlItemPriceDetails = $quickLubeItem['priceDetails']; ?>
                                            <?php $qlItemDiscountDetails = $quickLubeItem['discountDetails']; ?>
                                            @if($qlItemPriceDetails->UnitPrice!=0)
                                            <div class="col-md-4 col-sm-6 mb-4">
                                                <div class="card">
                                                    <div class="card-header text-center pt-4 pb-3">
                                                        <h6 class="font-weight-normal mt-2" style="text-transform: capitalize;">
                                                            {{ strtolower($qlItemPriceDetails->ItemName)}}

                                                        </h6>
                                                        <small>{{$qlItemPriceDetails->ItemCode}}</small>
                                                        <!-- <textarea style="padding-left: 5px !important;" class="form-control" placeholder="Notes..!" wire:model="extra_note.{{$qlItemPriceDetails->ItemId}}"></textarea > -->
                                                        <div class="ms-auto">
                                                            @if(!empty($qlItemDiscountDetails))
                                                                <span class="badge bg-gradient-info">{{custom_round($qlItemDiscountDetails->DiscountPerc)}}%off</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="card-body text-lg-left text-center pt-0">
                                                        <h4 class="my-auto me-2" @if($qlItemDiscountDetails != null) style="text-decoration: line-through;" @endif>{{config('global.CURRENCY')}} {{custom_round($qlItemPriceDetails->UnitPrice)}}
                                                        </h4>
                                                        @if($qlItemDiscountDetails != null)
                                                        <h4 class="my-auto">
                                                        <span class="text-secondary text-sm me-1">{{config('global.CURRENCY')}}</span>{{ custom_round($qlItemPriceDetails->UnitPrice-(($qlItemDiscountDetails->DiscountPerc/100)*$qlItemPriceDetails->UnitPrice)) }}
                                                        </h4>
                                                        @endif
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <input type="number" class="form-control w-30 m-auto" placeholder="Qty" wire:model.defer="ql_item_qty.{{$qlItemPriceDetails->ItemId}}" style="padding-left:5px !important;" />
                                                                <a href="javascript:;" class="btn bg-gradient-primary mb-0 ms-auto btn-sm"  wire:click="addtoCartItem('{{$qlItemPriceDetails}}','{{$qlItemDiscountDetails}}')">Add Now</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        @empty
                                            <div class="alert alert-danger text-white" role="alert">
                                                <strong>Empty!</strong> The Searched items are not in stock!</div>
                                        @endforelse 
                                    </div>
                                @endif
                                
                            @endif

                            @foreach($sectionsLists as $sectionsList)
                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3 my-2 cursor-pointer" wire:click="getSectionServices({{$sectionsList}})">
                                <div class="card bg-gradient-primary">
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-8 p-0">
                                                <div class="numbers">
                                                <p class="text-white text-sm mb-0 opacity-7">{{$service_group_name}}</p>
                                                <h5 class="text-white font-weight-bolder mb-0">
                                                {{$sectionsList->PropertyName}}
                                                </h5>
                                                </div>
                                            </div>
                                            <div class="col-4 text-end">
                                                <div class="icon icon-shape bg-white shadow text-center border-radius-md">
                                                    <i class="cursor-pointer fa-solid fa-angles-down text-dark text-lg opacity-10"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div wire:loading wire:target="getSectionServices">
                                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                    <div class="la-ball-beat">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($showServiceSectionsList)
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
                                        @if (session()->has('cartsuccess'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <span class="alert-icon text-light"><i class="ni ni-like-2"></i></span>
                                                <span class="alert-text text-light"><strong>Success!</strong> {{ Session::get('cartsuccess') }}</span>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="servicePriceModalLabel">{{$service_group_name}} - {{$selectedSectionName}}</h5>
                                            <button type="button" class="btn-close text-dark " style="font-size: 2.125rem !important;" data-bs-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true" class="text-xl">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body py-0">
                                            <div class="row">
                                                @forelse($sectionServiceLists as $sectionServiceList)
                                                <?php $priceDetails = $sectionServiceList['priceDetails']; ?>
                                                <?php $discountDetails = $sectionServiceList['discountDetails']; ?>
                                                @if($priceDetails->UnitPrice!=0)
                                                <div class="col-md-6">
                                                    
                                                    <div class="bg-gray-100 my-3 p-2">
                                                        <div class="d-flex">
                                                            <h6>{{$priceDetails->ItemCode}} - {{$priceDetails->ItemName}}</h6>
                                                            <div class="ms-auto">
                                                                @if(!empty($discountDetails))
                                                                    <span class="badge bg-gradient-info">{{custom_round($discountDetails->DiscountPerc)}}%off</span>
                                                                @endif
                                                                
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                        <p class="d-none text-sm mb-0">The website was initially built in PHP, I need a professional ruby programmer to shift it.</p>
                                                        <!-- <textarea style="padding-left: 5px !important;" class="form-control" placeholder="Notes..!" wire:model="extra_note.{{$priceDetails->ItemId}}"></textarea > -->
                                                        <div class="d-flex border-radius-lg p-0 mt-2">
                                                            
                                                            <h4 class="my-auto me-2" @if($discountDetails != null) style="text-decoration: line-through;" @endif>{{config('global.CURRENCY')}} {{custom_round($priceDetails->UnitPrice)}}
                                                            </h4>
                                                            @if($discountDetails != null)
                                                            <h4 class="my-auto">
                                                            <span class="text-secondary text-sm me-1">{{config('global.CURRENCY')}}</span>{{ custom_round($priceDetails->UnitPrice-(($discountDetails->DiscountPerc/100)*$priceDetails->UnitPrice)) }}
                                                            </h4>
                                                            
                                                            @endif

                                                            <a href="javascript:;" class="btn bg-gradient-primary mb-0 ms-auto btn-sm"  wire:click="addtoCart('{{$priceDetails}}','{{$discountDetails}}')">Add Now</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                @empty
                                                @endforelse
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                            <!-- <button type="button" class="btn bg-gradient-primary">Save changes</button> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif