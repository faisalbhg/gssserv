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
        @if($mRCardShow)
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 my-2">
                    <div class="card card-profile card-plain">
                        <h6 class="text-uppercase text-body text-lg font-weight-bolder mt-2">Material Request Summary <span class="float-end text-sm text-danger text-capitalize">{{ $mRCartItemCount }} Services selected</span></h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card h-100">
                                    
                                    <div class="card-body p-3 pb-0">
                                        <ul class="list-group">
                                            @foreach ($mRCartItems as $item)
                                                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                    
                                                    <div class="d-flex flex-column">
                                                        <h6 class="mb-1 text-dark font-weight-bold text-sm">
                                                            {{ $item->item_name }}
                                                        </h6>
                                                        <span class="text-xs">#{{ $item->item_code }}</span>
                                                        @if($item->extra_note)
                                                            <span class="text-xs text-dark">Note: {{ $item->extra_note }}</span>
                                                        @endif
                                                        
                                                        @if($confirming===$item->id)
                                                        <p>
                                                            <label class="p-0 text-success bg-red-600 cursor-pointer float-start" wire:click.prevent="kill({{ $item->id }},{{ $item->item_id }})"><i class="fa fa-trash"></i> Yes</label>
                                                            <label class="p-0 text-info bg-red-600 cursor-pointer float-end" wire:click.prevent="safe({{ $item->id }})"><i class="fa fa-trash"></i> No</label>
                                                            <div wire:loading wire:target="kill">
                                                                <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                                    <div class="la-ball-beat">
                                                                        <div></div>
                                                                        <div></div>
                                                                        <div></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </p>

                                                        @else
                                                            <label class="p-0 text-danger bg-red-600 cursor-pointer" wire:click.prevent="confirmDelete({{ $item->id }})"><i class="fa fa-trash"></i> Remove</label>
                                                        @endif
                                                    </div>
                                                    <div class="d-flex align-items-center text-sm">
                                                        
                                                    </div>
                                                    <div class="d-flex align-items-center text-sm">
                                                        @if($item->quantity>1)<span class="px-2 cursor-pointer" wire:click="cartSetDownQty({{ $item->id }})">
                                                            <i class="fa-solid fa-square-minus fa-xl"></i>
                                                        </span>
                                                        @endif
                                                        {{$item->quantity}}
                                                        <span class="px-2 cursor-pointer" wire:click="cartSetUpQty({{ $item->id }})">
                                                            <i class="fa-solid fa-square-plus fa-xl"></i>
                                                        </span>
                                                    </div>
                                                    
                                                </li>
                                                <hr class="horizontal dark mt-0 mb-2">
                                                
                                            @endforeach
                                            
                                        </ul>
                                        
                                        <button class="btn bg-gradient-danger btn-sm float-start" wire:click.prevent="clearAllCart">Remove All Cart</button>
                                        <button type="button" class="btn bg-gradient-success btn-sm float-end" wire:click="submitService()">Confirm & Continue</button>
                                        <div wire:loading wire:target="submitService">
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
                    </div>
                </div>
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
        @if($showQWServiceMRSections)
            <div class="row mt-2 mb-2" id="servceSectionsList">
                @foreach($sectionsLists as $sectionsList)
                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3 my-2 cursor-pointer" wire:click="getSectionServices({{$sectionsList}})">
                        <div class="card bg-gradient-primary">
                            <div class="card-body p-2">
                                <div class="row">
                                    <div class="col-md-9 col-sm-9">
                                        <div class="numbers">
                                        <p class="text-white text-sm mb-0 opacity-7">{{$service_group_name}}</p>
                                        <h6 class="text-white font-weight-bolder mb-0 text-capitalize">
                                        {{strtolower(str_replace("-"," ",$sectionsList->PropertyName))}}
                                        </h6>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 text-end">
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
        @endif
        @if($showQWServiceMRItems)
            <div class="row" id="serviceItemsListDiv">
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <input type="text" wire:model="mt_serive_item_search" name="" id="seachByItemName" class=" mt-2 form-control" placeholder="Search Item Name..!">
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
                        <div class="col-md-4 col-sm-6">
                            <div class="card mt-2">
                                <div class="card-header text-center p-2">
                                    <p class="font-weight-normal mt-2 text-capitalize text-sm- font-weight-bold mb-0">
                                        {{strtolower($servicesItem->ItemName)}}<small>({{$servicesItem->ItemCode}})</small>
                                    </p>
                                </div>
                                <div class="card-body text-lg-left text-center p-2">
                                    <input type="number" class="form-control w-30 float-start" placeholder="Qty" wire:model.defer="ql_item_qty.{{$servicesItem->ItemId}}" style="padding-left:5px !important;" />
                                    <a href="javascript:;" class="btn btn-icon bg-gradient-primary d-lg-block m-0 float-end p-2" wire:click="addtoCartItem({{$servicesItem}})">Add Now<i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
                                    </a>
                                </div>
                                @if(@$serviceMRAddedMessgae[$servicesItem->ItemCode])
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
                    @empty
                        <div class="alert alert-danger text-white" role="alert"><strong>Empty!</strong> The Searched items are not in stock!</div>
                    @endforelse
                    <div class="float-end">{{$serviceItemsList->onEachSide(0)->links()}}</div>
                    <div wire:loading wire:target="addtoCartItem">
                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                            <div class="la-ball-beat">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
</main>
@push('custom_script')
@endpush