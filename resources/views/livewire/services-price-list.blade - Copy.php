<main class="main-content position-relative border-radius-lg">
    <div class="container-fluid py-2">
        <div class="row mb-3 mx-3">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Pricing Category</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="form-label">Service/Item</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Search Service..." aria-label="Service Name" aria-describedby="searchServiceNameBtn" name="service_name_search" wire:model="service_name_search" id="service_name_search" wire:keyup="searchServiceName">
                                    <button class="btn bg-gradient-primary btn-sm mb-0" type="button" id="searchServiceNameBtn" wire:click="searchServiceName">Search</button><!-- 
                                    <div wire:loading="" wire:target="searchServiceName">
                                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;">
                                            <div class="la-ball-beat">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                                @if($showServiceSelected)
                                    <div class="card mb-3">
                                        <div class="card-header text-center pt-4 pb-3">
                                            <span class="badge rounded-pill bg-light text-dark">Selected Services</span>
                                        </div>
                                        <div class="card-body text-lg-left text-left pt-0">
                                            @foreach($selectedServicePriceId as $keySelPrSer => $selectedItem)
                                            <div class="justify-content-lg-start justify-content-left p-2" >
                                                <div class="icon icon-shape icon-xs bg-gradient-success shadow text-center">
                                                    <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                                </div>
                                                <span class="ps-3">{{$selectedServicePriceName[$keySelPrSer]}}({{$selectedServicePriceCode[$keySelPrSer]}}) - <b>AED{{$selectedServicePriceVal[$keySelPrSer]}}</b></span>
                                                <small wire:click="removeSelectedService('{{$keySelPrSer}}')" class="float-end cursor-pointer text-danger text-xxs">Remove</small><hr class="m-0">
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif 
                            </div>
                            @if($showSearchServiceInfo)
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-header text-center pt-4 pb-3">
                                            <span class="badge rounded-pill bg-light text-dark">Search Results</span>
                                            <div class="cursor-pointer icon icon-shape icon-xs shadow text-center" wire:click="closeSearchResult">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm79 143c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z"/></svg>
                                            </div>
                                        </div>
                                        <div class="card-body text-lg-left text-left pt-0">
                                            @foreach($servicesResults as $serviceVal)
                                            <div class="justify-content-lg-start justify-content-left p-2" wire:click="selectedService({{$serviceVal}})">
                                                <div class="icon icon-shape icon-xs bg-gradient-info shadow text-center" >
                                                    <i class="fas fa-plus" aria-hidden="true"></i>
                                                </div>
                                                <span class="ps-3"> {{$serviceVal->service_name}} - <b>AED{{$serviceVal->sale_price}}</b></span><hr class="m-0">
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>   
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            @if($showSelectedServiceCustomerType)
                                <div class="card-header pb-0 p-3">
                                    <h6 class="mb-3">Customer Type</h6>
                                </div>
                                @foreach($customertypesList as $customerKey => $customertype)
                                <div class="col-lg-6 col-sm-6 px-4">
                                    <div class="card p-2 mb-2">
                                        <div class="checklist-item checklist-item-primary ps-2 ms-3">
                                            <div class="d-flex align-items-center">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" wire:model="customerTypeValue" value="{{$customertype->id}}" id="flexCheckDefault">
                                                </div>
                                                <h6 class="mb-0 text-dark font-weight-bold text-sm">{{str_replace("_"," ",$customertype->customer_type)}}</h6>
                                                
                                            </div>
                                            @if($showServiceDiscountDetails[$customertype->id])
                                            <div class="d-flex align-items-center ms-4 mt-3 ps-1">
                                                <div>
                                                    <p class="text-xs mb-0 text-secondary font-weight-bold">Discount</p>
                                                    <input type="text" placeholder="Fixed/Percentage" class="form-control" style="padding-left:0 !important;" />
                                                </div>
                                                <div class="mx-auto">
                                                    <p class="text-xs mb-0 text-secondary font-weight-bold">Date From</p>
                                                    <input type="date" placeholder="Date range" class="form-control" />
                                                </div>
                                                <div class="mx-auto">
                                                    <p class="text-xs mb-0 text-secondary font-weight-bold">Date To</p>
                                                    <input type="date" placeholder="Date range" class="form-control" />
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                            
                        </div>
                        <div class="row mt-5">
                            <div class="col-lg-8 col-12 actions text-end ms-auto">
                                <button class="btn btn-outline-primary btn-sm mb-0" type="reset">Cancel</button>
                                <button class="btn bg-gradient-primary btn-sm mb-0" type="button">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 mb-2">
                
                
            </div>
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">All Services Price Lists</h5>
                            </div>
                            <input type="text"  class="form-control float-end" style="width:20%;" placeholder="Search Services" wire:model="service_price_search" />
                            
                            <button wire:click="addNewDepartment()" class="d-none btn bg-gradient-primary btn-sm" type="button">+ New Services</button>
                        </div>
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
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            ID
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Service Type Code
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Service Type Name
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Normal Price
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Customer Type
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Discount
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Discounted Price
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($servicePricesList as $servicePrice)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{$servicePrice->id}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$servicePrice->service_type_code}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$servicePrice->service_type_name}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$servicePrice->customerType}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">AED {{round($servicePrice->unit_price,2)}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$service->department_name}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$servicePrice->section_name}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$servicePrice->station_name}}</p>
                                        </td>
                                        <td class="text-center">
                                            <a wire:click="editDepartment({{$servicePrice->id}})" class="mx-3" data-bs-toggle="tooltip"
                                                data-bs-original-title="Edit Department {{$servicePrice->service_type_name}}">
                                                <i class="fas fa-user-edit text-secondary"></i>
                                            </a>
                                            <span  onclick="deletePost({{$servicePrice->id}})">
                                                <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" align="center">
                                            No Posts Found.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            <input type="text"  class="form-control" placeholder="Code" wire:model="service_code" />
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            <input type="text"  class="form-control" placeholder="Type Name" wire:model="service_type_name" />
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            <input type="text"  class="form-control" placeholder="Customer Type" wire:model="customerType" />
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                           
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            <input type="text"  class="form-control" placeholder="Department" wire:model="department_name" />
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            <input type="text"  class="form-control" placeholder="Station Name" wire:model="station_name" />
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="float-end">{{ $servicePricesList->onEachSide(1)->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@push('custom_script')
<script type="text/javascript">
    window.addEventListener('showDepartmentModel',event=>{
        $('#departmentModel').modal('show');
    });
    window.addEventListener('hideDepartmentModel',event=>{
        $('#departmentModel').modal('hide');
    });
</script>
@endpush
