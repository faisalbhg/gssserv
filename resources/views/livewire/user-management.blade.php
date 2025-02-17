<main class="main-content position-relative h-100 border-radius-lg">
    <div class="container-fluid py-2">
       
        <div class="row">
            <div class="col-md-8 mb-2">
                @if($manageUser)
                    @include('components.modals.manageUser')
                @endif
                
            </div>
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">

                            <div>
                                <h5 class="mb-0">All Users</h5>
                            </div>
                            <div class="col-xl-3 col-md-3 col-sm-3 mb-xl-2 mb-2">
                                <div class="form-group">
                                    <select class="form-control" id="stationSelect" wire:model="search_station">
                                        <option value="">-Select-</option>
                                        @foreach($stationsList as $station)
                                            <option value="{{$station->LandlordCode}}">{{$station->CorporateName}}</option>
                                    @endforeach
                                    </select>
                                    <div wire:loading wire:target="search_station">
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
                            <button wire:click="addUser()" class="btn bg-gradient-primary btn-sm" type="button">+ New User</button>
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
                                            Name
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Email
                                        </th>
                                        <!-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Phone
                                        </th> -->
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Station
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Role
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Creation Date
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
                                    @forelse( $usersList as $user)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{$user->id}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$user->name}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$user->email}}</p>
                                        </td>
                                        <!-- <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$user->phone}}</p>
                                        </td> -->
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$user->stationName['CorporateName']}}</p>
                                        </td>
                                        <td class="text-center">
                                            {{<p class="text-xs font-weight-bold mb-0">{{config('global.user_type')[$user->user_type]}}</p>}}
                                        </td>
                                        <td class="text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{$user->created_at}}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-sm {!!config('global.is_active')[$user->is_active]['class']!!}">{{config('global.is_active')[$user->is_active]['label']}}</span>
                                        </td>
                                        <td class="text-center">
                                            <a wire:click="editUser({{$user->id}})" class="mx-3" data-bs-toggle="tooltip"
                                                data-bs-original-title="Edit user">
                                                <i class="fas fa-user-edit text-secondary"></i>
                                            </a>
                                            <span  onclick="deletePost({{$user->id}})">
                                                <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                          <td colspan="9">No Record Found</td>
                                        </tr>
                                      @endforelse
                                    
                                </tbody>
                            </table>
                            <div class="float-end">{{$usersList->links()}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@push('custom_script')
<script type="text/javascript">
    window.addEventListener('showUserModel',event=>{
        $('#userModel').modal('show');
    });
    window.addEventListener('hideUserModel',event=>{
        $('#userModel').modal('hide');
    });
</script>
@endpush
