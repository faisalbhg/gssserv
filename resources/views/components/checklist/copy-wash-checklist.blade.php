<div class="row">
    @foreach(config('global.check_list.wash.checklist.type') as $cLTkey => $checklistType)
        <div class="col-md-6 px-1">
            <div class="card mb-2">
                <div class="card-header p-2 pb-0">
                    <h3 class="mb-0 text-sm text-center">{{$checklistType}}</h3>
                    <hr class="horizontal dark mt-0 mb-1">
                </div>
                <div class="card-body p-2">
                    @foreach(config('global.check_list.wash.checklist.type_section') as $cLTSeckey => $checklistTypeSection)
                        <div class="form-check ps-0">
                            <label class="custom-control-label" for="frontSideBumperCheck">{{$checklistTypeSection}}</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="radio" wire:model="frontSideBumperCheck" value="G" id="washBumberCheckG">
                                        <label class="custom-control-label" for="washBumberCheckG">Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="radio" wire:model="frontSideBumperCheck" value="NG" id="washBumberCheckNG">
                                        <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="radio" wire:model="frontSideBumperCheck" value="NA" id="washBumberCheckNA">
                                        <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                </div>
            </div>
        </div>
    @endforeach
    <div class="col-md-6 px-1">
        <div class="card mb-2">
            <div class="card-header p-2 pb-0">
                <h3 class="mb-0 text-sm text-center">Front Side</h3>
                <hr class="horizontal dark mt-0 mb-1">
            </div>
            <div class="card-body p-2">
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="frontSideBumperCheck">Bumper</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="frontSideBumperCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="frontSideBumperCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="frontSideBumperCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="frontSideGrillCheck">Grill</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="frontSideGrillCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="frontSideGrillCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="frontSideGrillCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="frontSideNumberPlateCheck">Number Plate</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="frontSideNumberPlateCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="frontSideNumberPlateCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="frontSideNumberPlateCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="frontSideHeadLampsCheck">Head Lamps</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="frontSideHeadLampsCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="frontSideHeadLampsCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="frontSideHeadLampsCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="frontSideFogLampsCheck">Fog Lamps</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="frontSideFogLampsCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="frontSideFogLampsCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="frontSideFogLampsCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="frontSideHoodCheck">Hood</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="frontSideHoodCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="frontSideHoodCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="frontSideHoodCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 px-1">
        <div class="card mb-2">
            <div class="card-header p-2 pb-0">
                <h3 class="mb-0 text-sm text-center">Rear Side</h3>
                <hr class="horizontal dark mt-0 mb-1">
            </div>
            <div class="card-body p-2">
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="rearSideBumperCheck">Bumper</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rearSideBumperCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rearSideBumperCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rearSideBumperCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="rearSideMufflerCheck">Muffler</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rearSideMufflerCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rearSideMufflerCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rearSideMufflerCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="rearSideNumberPlateCheck">Number Plate</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rearSideNumberPlateCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rearSideNumberPlateCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rearSideNumberPlateCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="rearSideTrunkCheck">Trunk</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rearSideTrunkCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rearSideTrunkCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rearSideTrunkCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="rearSideLightsCheck">Lights</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rearSideLightsCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rearSideLightsCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rearSideLightsCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="rearSideRoofTopCheck">Roof Top</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rearSideRoofTopCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rearSideRoofTopCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rearSideRoofTopCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 px-1">
        <div class="card mb-2">
            <div class="card-header p-2">
                <h4 class="mb-0 text-sm text-center">Left Side</h4>
                <hr class="horizontal dark mt-0 mb-1">
            </div>
            <div class="card-body p-2">
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="leftSideWheelCheck">Wheel</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="leftSideWheelCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="leftSideWheelCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="leftSideWheelCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="leftSideFenderCheck">Fender</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="leftSideFenderCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="leftSideFenderCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="leftSideFenderCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="leftSideSideMirrorCheck">Side Mirror</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="leftSideSideMirrorCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="leftSideSideMirrorCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="leftSideSideMirrorCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="leftSideDoorGlassInOutCheck">Door Glass In & Out</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="leftSideDoorGlassInOutCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="leftSideDoorGlassInOutCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="leftSideDoorGlassInOutCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="leftSideDoorHandleCheck">Door Handle</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="leftSideDoorHandleCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="leftSideDoorHandleCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="leftSideDoorHandleCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="leftSideSideStepperCheck">Side Stepper</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="leftSideSideStepperCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="leftSideSideStepperCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="leftSideSideStepperCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 px-1">
        <div class="card mb-2">
            <div class="card-header p-2">
                <h3 class="mb-0 text-sm text-center">Right Side</h3>
                <hr class="horizontal dark mt-0 mb-1">
            </div>
            <div class="card-body p-2">
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="rightSideWheelCheck">Wheel</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rightSideWheelCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rightSideWheelCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rightSideWheelCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="rightSideFenderCheck">Fender</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rightSideFenderCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rightSideFenderCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rightSideFenderCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="rightSideSideMirrorCheck">Side Mirror</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rightSideSideMirrorCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rightSideSideMirrorCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rightSideSideMirrorCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="rightSideDoorGlassInOutCheck">Door Glass In & Out</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rightSideDoorGlassInOutCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rightSideDoorGlassInOutCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rightSideDoorGlassInOutCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="rightSideDoorHandleCheck">Door Handle</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rightSideDoorHandleCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rightSideDoorHandleCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rightSideDoorHandleCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="rightSideSideStepperCheck">Side Stepper</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rightSideSideStepperCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rightSideSideStepperCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="rightSideSideStepperCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 px-1">
        <div class="card mb-2">
            <div class="card-header p-2">
                <h4 class="mb-0 text-sm text-center">Inner Cabin</h4>
                <hr class="horizontal dark mt-0 mb-1">
            </div>
            <div class="card-body p-2">
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="innerCabinSmellCheck">Smell</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinSmellCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinSmellCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinSmellCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="innerCabinWindshieldFRRRCheck">Windshield FR & RR</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinWindshieldFRRRCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinWindshieldFRRRCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinWindshieldFRRRCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="innerCabinSteeringWheelCheck">Steering Wheel</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinSteeringWheelCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinSteeringWheelCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinSteeringWheelCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="innerCabinGearKnobCheck">Gear Knob</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" wire:model="innerCabinGearKnobCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" wire:model="innerCabinGearKnobCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" wire:model="innerCabinGearKnobCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="innerCabinCentreConsoleCheck">Centre Console</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinCentreConsoleCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinCentreConsoleCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinCentreConsoleCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="innerCabinAshTryCheck">Ash Try</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinAshTryCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinAshTryCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinAshTryCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="innerCabinDashboardCheck">Dashboard</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" wire:model="innerCabinDashboardCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" wire:model="innerCabinDashboardCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" wire:model="innerCabinDashboardCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="innerCabinACVentsFRRRCheck">AC Vents FR & RR</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinACVentsFRRRCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinACVentsFRRRCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinACVentsFRRRCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="innerCabinInteriorTrimCheck">Interior Trim</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinInteriorTrimCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinInteriorTrimCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinInteriorTrimCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="innerCabinFloorMatCheck">Floor Mat</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinFloorMatCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinFloorMatCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinFloorMatCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="innerCabinRearViewMirrorCheck">Rear View Mirror</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinRearViewMirrorCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinRearViewMirrorCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinRearViewMirrorCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <div class="row">
                        <label class="custom-control-label" for="innerCabinLuggageCompCheck">Luggage Comp</label>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinLuggageCompCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinLuggageCompCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinLuggageCompCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check ps-0">
                    <label class="custom-control-label" for="innerCabinRoofTopCheck">Roof Top</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinRoofTopCheck" value="G" id="washBumberCheckG">
                                <label class="custom-control-label" for="washBumberCheckG">Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinRoofTopCheck" value="NG" id="washBumberCheckNG">
                                <label class="custom-control-label" for="washBumberCheckNG">Not Good</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" wire:model="innerCabinRoofTopCheck" value="NA" id="washBumberCheckNA">
                                <label class="custom-control-label" for="washBumberCheckNA">Not Applicable</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
