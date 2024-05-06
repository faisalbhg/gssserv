
<!-- Modal -->
<div wire:ignore.self  class="modal fade bd-example-modal-lg" id="userModel" tabindex="-1" role="dialog" aria-labelledby="userModelLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        
        <div class="modal-header">
            <h5 class="modal-title" id="userModelLabel">{{$title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        
            <div class="modal-body">

                <div class="row">
                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12  col-sm-12 col-xs-12 col-xxs-12">
                        <div class="card p-0 m-0" >
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="h5 text-left">Customer Details</p><hr class="mt-0">
                                        <div class="row">
                                            <form  autocomplete="off" wire:submit.prevent="storeUserData" method="POST"  enctype="multipart/form-data">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="nameInput">Name</label>
                                                    <div class="input-group mb-0">
                                                        <input class="form-control" placeholder="Name" type="text" wire:model="name" name="name" id="nameInput">
                                                    </div>
                                                    @error('name') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                            
                                                <div class="col-md-12">
                                                    <div class="form-group openDiv">
                                                        <label for="emailInput">Email</label>
                                                        <input type="email" class="form-control" wire:model="email" name="email" placeholder="Email" id="emailInput">
                                                        @error('email') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                @if($showpasswordinput)
                                                <div class="col-md-12">
                                                    <div class="form-group openDiv">
                                                        <label for="emailInput">Password</label>
                                                        <input type="password" class="form-control" wire:model="password" name="password" placeholder="Password" id="passwordInput">
                                                        @error('password') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                @endif
                                                
                                                <div class="col-md-12">
                                                    <div class="form-group openName">
                                                        <label for="phoneInput">Phone</label>
                                                        <input type="number" wire:model="phone" name="phone" class="form-control" id="phoneInput" placeholder="Phone">
                                                        @error('phone') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="userTypeSelect">User Type</label>
                                                        <select class="form-control" id="userTypeSelect" wire:model="user_type">
                                                            <option value="">-Select-</option>
                                                            @foreach(config('global.user_type') as $userTypeKey => $userTypeVal)
                                                            <option value="{{$userTypeKey}}">{{$userTypeVal}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('user_type') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="stationSelect">Station</label>
                                                        <select class="form-control" id="stationSelect" wire:model="station_id">
                                                            <option value="">-Select-</option>
                                                            @foreach($stationsList as $station)
                                                            <option value="{{$station->id}}">{{$station->station_name.' - '.$station->station_code}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('station_id') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="isActiveSelect">is Active</label>
                                                        <select class="form-control" id="isActiveSelect" wire:model="is_active">
                                                            <option @if($is_active==1) selected @endif value="1">Active</option>
                                                            <option @if($is_active==0) selected @endif value="0">Dissable</option>
                                                        </select>
                                                        @error('is_active') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                <input type="hidden" wire:model="user_id" name="user_id">
                                                <button type="button" class="btn bg-gradient-warning" wire:click="storeUserData()">{{$buttonName}}</button>
                                            
                                            </form>
                                            
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-gradient-primary">Submit</button> -->
            </div>
        
    </div>
  </div>
</div>

