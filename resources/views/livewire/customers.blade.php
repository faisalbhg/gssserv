<main class="main-content position-relative h-100 border-radius-lg">
    <div class="container-fluid py-2">
        <div class="row">
            
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">All Customers</h5>
                            </div>
                            <button wire:click="addNewCustomer()" class="btn bg-gradient-primary btn-sm" type="button">+ New Customer</button>
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
                        <div class="row px-4">
                            <div class="col-xl-3 col-md-3 col-sm-3 mb-xl-2 mb-2">
                                <label>Customer Name</label>
                                <div class="form-group">
                                    <input style="padding:0.5rem 0.3rem !important;"  type="text"  class="form-control" placeholder="Customer Name" wire:model="search_customer" />
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-3 col-sm-3 mb-xl-2 mb-2">
                                <label>Customer Mobile</label>
                                <div class="form-group">
                                    <input style="padding:0.5rem 0.3rem !important;"  type="text"  class="form-control" placeholder="Customer Mobile" wire:model="customer_mobile" />
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            ID
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Name
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Mobile
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Email
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Created At
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
                                    @forelse( $customersList as $customer)
                                    <tr>
                                        <td class="ps-4">
                                            <span class="exploder badge badge-sm bg-gradient-primary">
                                                <i class="fas fa-eye text-secondary text-white"></i> Show Vehicles
                                            </span>
                                        </td>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{$customer->TenantId}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$customer->TenantName}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$customer->Mobile}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$customer->Email}}</p>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ \Carbon\Carbon::parse($customer->Creationdate)->format('dS M Y H:i A') }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-sm {!!config('global.is_active')[$customer->Active]['class']!!}">{{config('global.is_active')[$customer->Active]['label']}}</span>
                                        </td>
                                        <td class="text-center">
                                            <a wire:click="editCustomer({{$customer->TenantId}})" class="mx-1" data-bs-toggle="tooltip"
                                                data-bs-original-title="Edit Department {{$customer->TenantName}}">
                                                <i class="fas fa-user-edit text-secondary"></i>
                                            </a>
                                            <span  onclick="deletePost({{$customer->TenantId}})">
                                                <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="explode hide">
                                      <td colspan="8" style="background: rgb(239 238 238); display: none;">
                                          <table class="table align-items-center mb-0">
                                            <thead>
                                              <tr>
                                                <th>Image</th>
                                                <th>Vehicle</th>
                                                <th>Type</th>
                                                <th>Make/Model</th>
                                                <th>Plate No</th>
                                                <th>Chaisis</th>
                                                <th>K.M Reading</th>
                                                <th>Created</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($customer->customerVehicleDetails as $customervehicle)
                                                <tr>
                                                    <td>
                                                        @if($customervehicle['vehicle_image'])
                                                        <img class="w-100 rounded-3 shadow-lg" src="{{url('storage/'.$customervehicle['vehicle_image'])}}">
                                                        @endif
                                                    </td>
                                                    <td>{{$customervehicle['vehicle_id']}}</td>
                                                    <td>{{$customervehicle['vehicle_type']}}</td>
                                                    <td>{{$customervehicle['make_model']}}</td>
                                                    <td>{{$customervehicle['plate_number']}}</td>
                                                    <td>{{$customervehicle['chassis_number']}}</td>
                                                    <td>{{$customervehicle['vehicle_km']}}</td>
                                                    <td>{{ \Carbon\Carbon::parse($customervehicle['created_at'])->format('dS M Y H:i A') }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="8">No Record Found</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                       </td>
                                    </tr>
                                    @empty
                                        <tr>
                                          <td colspan="8">No Record Found</td>
                                        </tr>
                                    @endforelse
                                    
                                </tbody>
                            </table>
                            <div class="float-end">{{$customersList->links()}}</div>
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
    $(document).ready(function(){
        $(".exploder").click(function(){
        $(this).toggleClass("btn-success btn-danger");
        $(this).children("span").toggleClass("glyphicon-search glyphicon-zoom-out");  
        $(this).closest("tr").next("tr").toggleClass("hide");
        if($(this).closest("tr").next("tr").hasClass("hide")){
            $(this).closest("tr").next("tr").children("td").slideUp();
        }
        else{
            $(this).closest("tr").next("tr").children("td").slideDown(350);
        }
        });
    });
</script>
@endpush
