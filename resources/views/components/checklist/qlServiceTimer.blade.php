
                <div class="row">
                    @if($services->service_time_in==null && $services->service_time_out==null)
                    <div class="col-md-12">
                        <div class="form-group">
                            <button class="btn btn-icon btn-3 btn-info" type="button" wire:click="clickQlJobOperation('start','service','{{$services->id}}','{{$services->section_name}}')">
                                <span class="btn-inner--icon"><i class="ni ni-button-play"></i></span>
                                <span class="btn-inner--text">{{$services->section_name}} Start</span>
                            </button>
                        </div>
                    </div>

                    @elseif($services->service_time_in != null && $services->service_time_out == null)
                    <div class="col-md-12">
                        <label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->service_time_in)->format('dS M Y H:i A') }}</label>
                        <div class="form-group">
                            <button class="btn btn-icon btn-3 btn-primary" type="button" wire:click="clickQlJobOperation('stop','service','{{$services->id}}','{{$services->section_name}}')">
                                <span class="btn-inner--icon"><i class="ni ni-button-pause"></i></span>
                                <span class="btn-inner--text"> {{$services->section_name}} Stop</span>
                            </button>
                            
                        </div>
                    </div>
                    @elseif($services->service_time_in != null && $services->service_time_out != null)
                    <div class="col-md-12">
                        <p class="mb-0"><label for="example-time-input" class="form-control-label">Starts at: {{ \Carbon\Carbon::parse($services->service_time_in)->format('dS M Y H:i A') }}</label></p>
                        <p class="mb-0"><label for="example-time-input" class="form-control-label">Ends at: {{ \Carbon\Carbon::parse($services->service_time_out)->format('dS M Y H:i A') }}</label></p>
                    </div>
                    @endif
                </div>
                <div wire:loading wire:target="clickQlJobOperation">
                    <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index:999999; width:100%; height:100%; opacity: .75;" >
                        <div class="la-ball-beat">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>
            