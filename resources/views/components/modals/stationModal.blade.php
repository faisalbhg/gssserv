
<!-- Modal -->
<div wire:ignore.self  class="modal fade bd-example-modal-lg" id="stationModel" tabindex="-1" role="dialog" aria-labelledby="stationModelLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        
        <div class="modal-header">
            <h5 class="modal-title" id="stationModelLabel">{{$stationTitle}}</h5>
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
                                        <div class="row">
                                            <form  autocomplete="off" wire:submit.prevent="saveCustomer" method="POST"  enctype="multipart/form-data">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="stationCodeInput">Station Code</label>
                                                    <div class="input-group mb-0">
                                                        <input class="form-control" placeholder="Station Code" type="text" wire:model="station_code" name="station_code" id="stationCodeInput">
                                                    </div>
                                                    @error('station_code') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                            
                                                <div class="col-md-12">
                                                    <div class="form-group openDiv">
                                                        <label for="stationNameInput">station_name</label>
                                                        <input type="text" class="form-control" wire:model="station_name" name="station_name" placeholder="Station Name" id="stationNameInput">
                                                        @error('name') <span class="mb-4 text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                <input type="hidden" wire:model="station_id">
                                                <button wire:click="manageStation()" type="button" class="btn bg-gradient-warning">Save</button>
                                            
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

