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
                                <h5 class="mb-0">All Item Product Group</h5>
                            </div>
                            
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
                                            Product Group Name
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Product Sub GrouCategory
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
                                    @forelse($itemProductGroup as $itemGroups)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{$itemGroups->id}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$itemGroups->product_group_name}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">@if(!empty($itemGroups->sub_group))
                                                {{$itemGroups->sub_group->product_group_name}}
                                                @endif
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-sm {!!config('global.is_active')[$itemGroups->is_active]['class']!!}">{{config('global.is_active')[$itemGroups->is_active]['label']}}</span>
                                        </td>
                                        <td class="text-center">
                                            <a wire:click="editDepartment({{$itemGroups->id}})" class="mx-3" data-bs-toggle="tooltip"
                                                data-bs-original-title="Edit {{$itemGroups->category_name}}">
                                                <i class="fas fa-user-edit text-secondary"></i>
                                            </a>
                                            <span  onclick="deletePost({{$itemGroups->id}})">
                                                <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" align="center">
                                            No Posts Found.
                                        </td>
                                    </tr>
                                    @endforelse
                                    
                                </tbody>
                            </table>
                            <div class="float-end">{{ $itemProductGroup->onEachSide(1)->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@push('custom_script')
@endpush
