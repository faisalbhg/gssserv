<main class="main-content position-relative h-100 border-radius-lg">
    <div class="container-fluid py-2">

    <div class="row">
        <div class="col-md-8 mb-2">
            @if($addStation)
                @include('components.modals.stationModal')
            @endif
            @if($updateStation)
                @include('livewire.stationModal')
            @endif
        </div>
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Stations</h5>
                        </div>
                        <button wire:click="addNewStation()" class="btn bg-gradient-primary btn-sm" type="button">+ New Station</button>
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
                                        Station Code
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Station Name
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Creation Date
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($stations) > 0)
                                @foreach ($stations as $station)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{$station->id}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$station->station_code}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$station->station_name}}</p>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ \Carbon\Carbon::parse($station->created_at)->format('dS M Y H:i A') }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a wire:click="editStation({{$station->id}})" class="mx-3" data-bs-toggle="tooltip"
                                            data-bs-original-title="Edit Station {{$station->station_name}}">
                                            <i class="fas fa-user-edit text-secondary"></i>
                                        </a>
                                        <span  onclick="deletePost({{$station->id}})">
                                            <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" align="center">
                                        No Posts Found.
                                    </td>
                                </tr>
                            @endif
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
</main>
@push('custom_script')
<script type="text/javascript">
    window.addEventListener('showStationModel',event=>{
        $('#stationModel').modal('show');
    });
    window.addEventListener('hideStationModel',event=>{
        $('#stationModel').modal('hide');
    });
</script>
@endpush
