@push('custom_css')

@endpush
<main class="main-content position-relative  border-radius-lg h-100">
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
        @if($showServiceGroup)
            <div class="row" id="servceGroups">
                @if(!$servicesGroupList->isEmpty())
                    @foreach($servicesGroupList as $servicesGroup)
                        <div class="col-sm-3 col-md-3 col-lg-2 col-xl-2 my-2">
                            <div class="card h-100" >
                                <a wire:click="serviceGroupForm({{$servicesGroup}})" href="javascript:;">
                                    <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('{{asset("img/".str_replace(" ","-",$servicesGroup->department_name).".jpg")}}');">
                                        @if($service_group_id == $servicesGroup->id)
                                        <span class="mask bg-gradient-dark opacity-4"></span>
                                        @else
                                        <span class="mask bg-gradient-dark opacity-7"></span>
                                        @endif
                                        <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
                                            <h5 class="@if($service_group_id == $servicesGroup->id) text-primary @else text-white @endif font-weight-bolder mb-4 pt-2">{{$servicesGroup->department_name}}</h5>
                                            <!-- <p class="text-white">Wealth creation is an evolutionarily recent positive-sum game. It is all about who take the opportunity first.</p> -->
                                            <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:;">
                                                <button wire:click="serviceGroupForm({{$servicesGroup}})" class="btn @if($service_group_id == $servicesGroup->id) bg-gradient-primary @else btn-outline-light @endif" type="button" >Select</button>
                                            </a>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                    
                    

                @endif
            </div>
            <div wire:loading wire:target="serviceGroupForm">
                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                    <div class="la-ball-beat">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
        @endif
        @if($showQWServiceMRItems)
            <div class="row" id="serviceItemsListDiv">
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <input type="text" wire:model="mt_serive_item_search" name="" id="seachByItemName" class="form-control">
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="seachByItemSubmit"></label>
                        <button class=" mt-2 btn bg-gradient-info" wire:click="searchServiceItems">Search</button>
                    </div>
                </div>
                <div wire:loading wire:target="searchServiceItems">
                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                        <div class="la-ball-beat">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
            @if($showQWServiceMRItemsResults)
                <div class="row">
                    @forelse($serviceItemsList as $servicesItem)
                        <?php $itemPriceDetails = $servicesItem['priceDetails']; ?>
                        <?php $itemDiscountDetails = $servicesItem['discountDetails']; ?>
                        @if($itemPriceDetails->UnitPrice!=0)
                        <div class="col-md-4 col-sm-6">
                            <div class="card mt-2">
                                <div class="card-header text-center p-2">
                                    <p class="font-weight-normal mt-2 text-capitalize text-sm- font-weight-bold mb-0">
                                        {{strtolower($itemPriceDetails->ItemName)}}<small>({{$itemPriceDetails->ItemCode}})</small>
                                    </p>
                                    <h5 class="font-weight-bold mt-2"  @if($itemDiscountDetails != null) style="text-decoration: line-through;" @endif>
                                        <small>AED</small>{{round($itemPriceDetails->UnitPrice,2)}}
                                    </h5>
                                    @if($itemDiscountDetails != null)
                                    <h5 class="font-weight-bold mt-2">
                                        <span class="text-secondary text-sm me-1">{{config('global.CURRENCY')}}</span>{{ round($itemPriceDetails->UnitPrice-(($itemDiscountDetails->DiscountPerc/100)*$itemPriceDetails->UnitPrice),2) }}
                                    </h5>
                                    @endif
                                    <div class="ms-auto">
                                        @if(!empty($qlItemDiscountDetails))
                                            <span class="badge bg-gradient-info">{{round($qlItemDiscountDetails->DiscountPerc,2)}}%off</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body text-lg-left text-center p-2">
                                    <input type="number" class="form-control w-30 float-start" placeholder="Qty" wire:model.defer="ql_item_qty.{{$itemPriceDetails->ItemId}}" style="padding-left:5px !important;" />
                                    <a href="javascript:;" class="btn btn-icon bg-gradient-primary d-lg-block m-0 float-end p-2" wire:click="addtoCartItem('{{$itemPriceDetails}}','{{$itemDiscountDetails}}')">Buy Now<i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
                                    </a>
                                </div>
                                @if(@$serviceAddedMessgae[$itemPriceDetails->ItemCode])
                                    <div class="text-center">
                                        <span class="alert-icon"><i class="ni ni-like-2 text-success"></i></span>
                                        <span class="alert-text text-success"><strong>Success!</strong> Added serves!</span>
                                        <button type="button" class="btn-close text-success" data-bs-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    @empty
                        <div class="alert alert-danger text-white" role="alert"><strong>Empty!</strong> The Searched items are not in stock!</div>
                    @endforelse
                </div>
            @endif
        @endif
    </div>
</main>
@push('custom_script')
@endpush