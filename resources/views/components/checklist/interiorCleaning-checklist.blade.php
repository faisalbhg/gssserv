<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header text-center pt-4 pb-3">
                <h5 class="font-weight-bold mt-2">Interior Cleaning</h5>
            </div>
            <div class="card-body text-center pt-0">
                <div class="row">
                    @if($services->interior==null)
                    <div class="col-md-12">
                        <div class="form-group">
                            <button class="btn btn-icon btn-3 btn-info" type="button" wire:click="clickQlOperation('start','interior','{{$services->id}}')">
                                <span class="btn-inner--icon"><i class="ni ni-button-play"></i></span>
                                <span class="btn-inner--text">Start</span>
                            </button>
                        </div>
                    </div>
                    @elseif($services->interior == 1)
                    <div class="col-md-12">
                        <label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->interior_cleaning_time_in)->format('dS M Y H:i A') }}</label>
                        <div class="form-group">
                            <button class="btn btn-icon btn-3 btn-primary" type="button" wire:click="clickQlOperation('stop','interior','{{$services->id}}')">
                                <span class="btn-inner--icon"><i class="ni ni-button-pause"></i></span>
                                <span class="btn-inner--text">Stop</span>
                            </button>
                            
                        </div>
                    </div>
                    @else
                    <div class="col-md-12">
                        <p class="mb-0"><label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->interior_cleaning_time_in)->format('dS M Y H:i A') }}</label></p>
                        <p class="mb-0"><label for="example-time-input" class="form-control-label">Ends at: {{ \Carbon\Carbon::parse($services->interior_cleaning_time_out)->format('dS M Y H:i A') }}</label></p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>