<main class="main-content position-relative h-100 border-radius-lg">
    <div class="container-fluid py-2">

        <div class="row">
            <div class="col-md-8 mb-2">
                
            </div>
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">All Services Master List</h5>
                                <span wire:click="addNewServiceMastter()" class="badge badge-sm bg-gradient-info" type="button">+ Add New</span>
                                <span class="badge badge-sm bg-gradient-success cursor-pointer" wire:click="exportServiceMaster">Export</span>
                            </div>

                            <input type="text"  class="form-control float-end" style="width:20%;" placeholder="Search Service Master" wire:model="service_master_search" />
                            
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
                        @if ($isAvailable)
                            <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                                <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                                <span class="alert-text"><strong>Error!</strong> Service is code is available</span>
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
                                        <label class="form-label" for="newServiceName">Service Name</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Service Name" name="new_service_name" wire:model="new_service_name" id="newServiceName" >
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-4">
                                        <label class="form-label" for="newServiceCode">Service Code</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Service Code" name="new_service_code" wire:model="new_service_code" id="newServiceCode" >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="newSalePrice">Sale Price</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Final Price" name="new_cost_price" wire:model="new_cost_price" id="newSalePrice" >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="newServiceSectionGroup">Service Section Group</label>
                                        <select class="form-control" id="newServiceSectionGroup" wire:model="new_service_section_group_code">
                                            @foreach($serviceSectionGroupList as $serviceSectionGroup)
                                            <option value="{{$serviceSectionGroup->service_section_group_code}}">{{$serviceSectionGroup->service_section_group_name}}({{$serviceSectionGroup->service_section_group_code}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="newServiceGroup">service_group</label>
                                        <select class="form-control" id="newServiceGroup" wire:model="new_service_group_code">
                                            @foreach($serviceGroupList as $serviceGroup)
                                            <option value="{{$serviceGroup->service_group_code}}">{{$serviceGroup->service_group_name}}({{$serviceGroup->service_group_code}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                </div>
                                <div class="row mt-5">
                                    <div class="col-lg-8 col-12 actions ms-auto">
                                        <button class="btn bg-gradient-primary btn-sm mb-0" wire:click="saveNewServiceMaster">Save Changes</button>
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
                                            Service Code
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Service Name
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Service Price
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Service Section
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Service Group
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
                                    @forelse($serviceMasterList as $service)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{$service->id}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$service->service_code}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$service->service_name}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{number_format($service->sale_price,2)}}</p>
                                        </td>
                                        
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                @if($service->serviceSectionGroup)
                                                {{$service->serviceSectionGroup['service_section_group_name']}}
                                                @endif
                                                
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                @if($service->serviceSectionGroup && $service->serviceSectionGroup->serviceGroup)
                                                {{$service->serviceSectionGroup->serviceGroup['service_group_name'].'('.$service->serviceSectionGroup->serviceGroup['service_group_code'].')'}}
                                                @endif
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-sm {!!config('global.is_active')[$service->is_active]['class']!!}">{{config('global.is_active')[$service->is_active]['label']}}</span>
                                        </td>
                                        <td class="text-center">
                                            <a wire:click="editDepartment({{$service->id}})" class="mx-3" data-bs-toggle="tooltip"
                                                data-bs-original-title="Edit Department ">
                                                <i class="fas fa-user-edit text-secondary"></i>
                                            </a>
                                            <span  onclick="deletePost({{$service->id}})">
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
                            </table>
                            <div class="float-end">{{ $serviceMasterList->onEachSide(1)->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@section('custom_script')
<script type="text/javascript">
    window.addEventListener('showDepartmentModel',event=>{
        $('#departmentModel').modal('show');
    });
    window.addEventListener('hideDepartmentModel',event=>{
        $('#departmentModel').modal('hide');
    });
</script>
@endsection
