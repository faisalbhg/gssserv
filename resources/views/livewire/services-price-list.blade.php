<main class="main-content position-relative border-radius-lg">
    <div class="container-fluid py-2">
        

        <div class="row">
            <div class="col-md-8 mb-2">
                
                
            </div>
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">All Services Price Lists</h5>
                                <button wire:click="addNewmanual()" class=" btn bg-gradient-info btn-sm" type="button">+ Add New</button>
                            </div>
                            
                            
                            <button wire:click="addNewImport()" class=" btn bg-gradient-primary btn-sm" type="button">+ New Import</button>
                        </div>
                        @if($isAddedNew)
                        <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
                            <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                            <span class="alert-text"><strong>Success!</strong> New Services Added Successfully..! </span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        @endif
                        @if($showManualForm)
                        <div class="card mb-4">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label" for="newServiceCode">Service Code</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Service Code" name="new_service_name" wire:model="new_service_code" id="newServiceCode" >
                                        </div>
                                    </div>
                                
                                    <div class="col-md-4">
                                        <label for="newCustomerType">Customer Type</label>
                                        <select class="form-control" id="newCustomerType" wire:model="new_customer_type">
                                            @foreach($customertypesList as $customertype)
                                            <option value="{{$customertype->id}}">{{$customertype->customer_type}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label" for="newDiscountType">Discount Type</label>
                                        <select class="form-control" id="newDiscountType" wire:model="new_discount_type">
                                            <option value="0">None</option>
                                            <option value="1">Fixed</option>
                                            <option value="2">Percentage</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="newDiscountValue">Discount Value</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Discount Value" name="new_discount_value" wire:model="new_discount_value" id="newDiscountValue" >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="newDiscountAmount">Discount Amount</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Discount Value" name="new_discount_amount" wire:model="new_discount_amount" id="newDiscountAmount" >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="newFinalPrice">Final Price</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Final Price" name="new_discount_value" wire:model="new_final_price" id="newFinalPrice" >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="newDateFrom">Date From</label>
                                        <input type="date" placeholder="Date range" class="form-control" wire:model="new_date_from" id="newDateFrom"  />
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="newDateTo">Date To</label>
                                        <input type="date" placeholder="Date range" class="form-control" wire:model="new_date_to" id="newDateTo"  />
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-lg-8 col-12 actions ms-auto">
                                        <button class="btn bg-gradient-primary btn-sm mb-0" wire:click="saveManualForm">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif


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
                                            Station
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Discount
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Discounted Price
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            from - to
                                        </th>
                                        <!-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status
                                        </th> -->
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
                                            <p class="text-xs font-weight-bold mb-0">{{$servicePrice->service_code}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$servicePrice->serviceInfo['service_name']}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">AED {{custom_round($servicePrice->unit_price)}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                @if($servicePrice->customerType)
                                                {{$servicePrice->customerType['customer_type']}}
                                                @endif
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$servicePrice->stationInfo['station_code']}}</p>
                                        </td>
                                        
                                        <td class="text-center">
                                            @if($servicePrice->discount_amount)
                                                @if($servicePrice->discount_type==1)
                                                <p class="text-xs font-weight-bold mb-0">AED {{$servicePrice->discount_value}}</p>
                                                @else
                                                <p class="text-xs font-weight-bold mb-0">{{$servicePrice->discount_value}}%</p>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($servicePrice->discount_amount)
                                            <p class="text-xs font-weight-bold mb-0">AED {{custom_round($servicePrice->final_price_after_dicount)}}</p>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0"> {{\Carbon\Carbon::parse($servicePrice->start_date)->format('dS M Y').' - '.\Carbon\Carbon::parse($servicePrice->end_date)->format('dS M Y')}}</p>
                                        </td>
                                        
                                        <td class="text-center">
                                            <a wire:click="editDepartment({{$servicePrice->id}})" class="mx-3" data-bs-toggle="tooltip"
                                                data-bs-original-title="Edit Department {{$servicePrice->service_type_name}}">
                                                <i class="fas fa-user-edit text-secondary"></i>
                                            </a>
                                            <span  wire:click="deletePriceMasterCT({{$servicePrice->id}})">
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
                                            <input type="text"  class="form-control" placeholder="Code" wire:model="search_service_code" />
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            <input type="text"  class="form-control" placeholder="Type Name" wire:model="service_name_search" />
                                        </th>
                                        <th></th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            <input type="text"  class="form-control" placeholder="Customer Type" wire:model="customerType" />
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                           <input type="text"  class="form-control" placeholder="Station Type" wire:model="station_id" />
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            <input type="text"  class="form-control" placeholder="Discount" wire:model="discount_perc" />
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            <input type="text"  class="form-control" placeholder="Status" wire:model="is_active" />
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                           
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
        @if($showImportPannel)
        @include('components.modals.importServicesPriceModel')
        @endif
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

    window.addEventListener('showServicePriceImportModel',event=>{
        $('#importServicesPriceModel').modal('show');
    });
    window.addEventListener('hideServicePriceImportModel',event=>{
        $('#importServicesPriceModel').modal('hide');
    });
    
</script>
@endpush
