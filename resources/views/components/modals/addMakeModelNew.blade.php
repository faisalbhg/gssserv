<style>
    .modal-dialog {
        max-width: 90% !important;
    }
    .modal{
        z-index: 99999;
    }
</style>
<!-- Modal -->
<div wire:ignore.self  class="modal fade bd-example-modal-lg" id="addMakeModelModel" tabindex="-1" role="dialog" aria-labelledby="addMakeModelModelLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        
        <div class="modal-header">
            <h5 class="modal-title" id="addMakeModelModel">Add New Make Model</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="newVehicleMakeInput">Vehicle Make</label>
                                    <input type="text" class="form-control" id="newVehicleMakeInput" wire:model="new_make" />
                                    <div wire:loading wire:target="new_make">
                                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                            <div class="la-ball-beat">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                    @error('new_make') <span class="text-danger">{{ $message }}</span> @enderror
                                    <div class="row">
                                        
                                        @forelse($makeSearchResult as $makeResult)
                                        <div class="col-md-4 col-sm-4 m-2">
                                            <div class="card h-100 cursor-pointer" wire:click="selectMakeInfoSave('{{$makeResult}}')">
                                                <div class="card-body py-3">
                                                    <h6 class="font-weight-bold text-capitalize text-center text-sm">{{$makeResult->vehicle_name}}</h6>
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                        <div>
                                            <button wire:click="saveMakeInfo" type="submit" class="btn bg-gradient-primary mt-1">Save Make</button>
                                        </div>
                                        <div wire:loading wire:target="saveMakeInfo">
                                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                <div class="la-ball-beat">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforelse
                                    </div>
                                    <div wire:loading wire:target="selectMakeInfoSave">
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
                            @if($showAddNewModel)
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="newVehicleModelInput">Vehicle Model</label>
                                    <input type="text" class="form-control" id="newVehicleModelInput" wire:model="new_model" />
                                    <div wire:loading wire:target="new_model">
                                        <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                            <div class="la-ball-beat">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                     @error('new_make') <span class="text-danger">{{ $message }}</span> @enderror
                                     <div class="row">
                                        
                                        @forelse($modelSearchResult as $modelResult)
                                        <div class="col-md-4 col-sm-4">
                                            <div class="card h-100 cursor-pointer" wire:click="selectModelInfoSave({{$modelResult}})">
                                                <div class="card-body py-3">
                                                    <h6 class="font-weight-bold text-capitalize text-center text-sm">{{$modelResult->vehicle_model_name}}</h6>
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                        <button wire:click="saveModelInfo" type="submit" class="btn bg-gradient-primary">Save Model</button>
                                        <div wire:loading wire:target="saveModelInfo">
                                            <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                                                <div class="la-ball-beat">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                            @endif
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

