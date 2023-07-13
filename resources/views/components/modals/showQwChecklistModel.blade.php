<style>
    .modal-dialog {
        max-width: 100%;
    }
    .modal{
        z-index: 99999;
    }
</style>

<!-- Modal -->
<div wire:ignore.self class="modal fade" id="showQwChecklistModel" tabindex="-1" role="dialog" aria-labelledby="showQwChecklistModelLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="showQwChecklistModelLabel">#{{$job_number}} GSS Vehicle Cleaning Internal Quality Control Checlist</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mt-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-profile card-plain py-2">
                                    <div class="row">
                                        <div class="col-xxs-4 col-xs-4 col-sm-3 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                                            <a href="javascript:;">
                                                <div class="position-relative">
                                                <div class="blur-shadow-image">
                                                    <img class="w-100 rounded-3 shadow-lg" src="{{url('storage/'.$vehicle_image)}}">
                                                </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-xxs-8 col-xs-8 col-sm-9 col-md-9 col-lg-9 col-xl-9 col-xxl-9">
                                            <div class="card-body p-0 text-left">
                                                <div class="p-md-0 pt-0">
                                                    <h5 class="font-weight-bolder mb-0">{{$make}}</h5>
                                                    <p class="text-sm font-weight-bold mb-0">{{$model}} ({{$plate_number}})</p>
                                                    <p class="text-sm mb-0">Chassis Number: {{$chassis_number}}</p>
                                                    <p class="text-sm mb-3">K.M Reading: {{$vehicle_km}}</p>
                                                    <hr class="horizontal dark mt-3">
                                                </div>
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ul class="list-group">
                                    <li class="list-group-item border-0  p-2 mb-2 bg-gray-100 border-radius-lg">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="float-start icon icon-shape icon-xs rounded-circle {{config('global.jobs.status_btn_class')[$job_status]}} shadow text-center m-2">
                                                    <i class="fa-solid fa-car-on  opacity-10" aria-hidden="true"></i>
                                                </div>
                                                <h6 class="my-2 text-sm">
                                                    Job Status: <span class="text-sm {{config('global.jobs.status_text_class')[$job_status]}} pb-2">{{config('global.jobs.status')[$job_status]}}</span> 
                                                </h6>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <h4 class="mb-2 text-center">Front Side</h4>
                            <hr class="horizontal dark mt-0 mb-3">
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="frontSideBumperCheck" >
                                    <label class="form-check-label" for="frontSideBumperCheck">Bumper</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="frontSideGrillCheck" >
                                    <label class="form-check-label" for="frontSideGrillCheck">Grill</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="frontSideNumberPlateCheck" >
                                    <label class="form-check-label" for="frontSideNumberPlateCheck">Number Plate</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="frontSideHeadLampsCheck" >
                                    <label class="form-check-label" for="frontSideHeadLampsCheck">Head Lamps</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="frontSideFogLampsCheck" >
                                    <label class="form-check-label" for="frontSideFogLampsCheck">Fog Lamps</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="frontSideHoodCheck" >
                                    <label class="form-check-label" for="frontSideHoodCheck">Hood</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <h4 class="mb-2 text-center">Rear Side</h4>
                            <hr class="horizontal dark mt-0 mb-3">
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="rearSideBumperCheck" >
                                    <label class="form-check-label" for="rearSideBumperCheck">Bumper</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="rearSideMufflerCheck" >
                                    <label class="form-check-label" for="rearSideMufflerCheck">Muffler</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="rearSideNumberPlateCheck" >
                                    <label class="form-check-label" for="rearSideNumberPlateCheck">Number Plate</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="rearSideTrunkCheck" >
                                    <label class="form-check-label" for="rearSideTrunkCheck">Trunk</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="rearSideLightsCheck" >
                                    <label class="form-check-label" for="rearSideLightsCheck">Lights</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="rearSideRoofTopCheck" >
                                    <label class="form-check-label" for="rearSideRoofTopCheck">Roof Top</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <h4 class="mb-2 text-center">Left Side</h4>
                            <hr class="horizontal dark mt-0 mb-3">
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="leftSideWheelCheck" >
                                    <label class="form-check-label" for="leftSideWheelCheck">Wheel</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="leftSideFenderCheck" >
                                    <label class="form-check-label" for="leftSideFenderCheck">Fender</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="leftSideSideMirrorCheck" >
                                    <label class="form-check-label" for="leftSideSideMirrorCheck">Side Mirror</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="leftSideDoorGlassInOutCheck" >
                                    <label class="form-check-label" for="leftSideDoorGlassInOutCheck">Door Glass In & Out</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="leftSideDoorHandleCheck" >
                                    <label class="form-check-label" for="leftSideDoorHandleCheck">Door Handle</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="leftSideSideStepperCheck" >
                                    <label class="form-check-label" for="leftSideSideStepperCheck">Side Stepper</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <h4 class="mb-2 text-center">Right Side</h4>
                            <hr class="horizontal dark mt-0 mb-3">
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="rightSideWheelCheck" >
                                    <label class="form-check-label" for="rightSideWheelCheck">Wheel</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="rightSideFenderCheck" >
                                    <label class="form-check-label" for="rightSideFenderCheck">Fender</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="rightSideSideMirrorCheck" >
                                    <label class="form-check-label" for="rightSideSideMirrorCheck">Side Mirror</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="rightSideDoorGlassInOutCheck" >
                                    <label class="form-check-label" for="rightSideDoorGlassInOutCheck">Door Glass In & Out</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="rightSideDoorHandleCheck" >
                                    <label class="form-check-label" for="rightSideDoorHandleCheck">Door Handle</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="rightSideSideStepperCheck" >
                                    <label class="form-check-label" for="rightSideSideStepperCheck">Side Stepper</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <h4 class="mb-2 text-center">Inner Cabin</h4>
                            <hr class="horizontal dark mt-0 mb-3">
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="innerCabinSmellCheck" >
                                    <label class="form-check-label" for="innerCabinSmellCheck">Smell</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="innerCabinWindshieldFRRRCheck" >
                                    <label class="form-check-label" for="innerCabinWindshieldFRRRCheck">Windshield FR & RR</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="innerCabinSteeringWheelCheck" >
                                    <label class="form-check-label" for="innerCabinSteeringWheelCheck">Steering Wheel</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="innerCabinGearKnobCheck" >
                                    <label class="form-check-label" for="innerCabinGearKnobCheck">Gear Knob</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="innerCabinCentreConsoleCheck" >
                                    <label class="form-check-label" for="innerCabinCentreConsoleCheck">Centre Console</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="innerCabinAshTryCheck" >
                                    <label class="form-check-label" for="innerCabinAshTryCheck">Ash Try</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="innerCabinDashboardCheck" >
                                    <label class="form-check-label" for="innerCabinDashboardCheck">Dashboard</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="innerCabinACVentsFRRRCheck" >
                                    <label class="form-check-label" for="innerCabinACVentsFRRRCheck">AC Vents FR & RR</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="innerCabinInteriorTrimCheck" >
                                    <label class="form-check-label" for="innerCabinInteriorTrimCheck">Interior Trim</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="innerCabinFloorMatCheck" >
                                    <label class="form-check-label" for="innerCabinFloorMatCheck">Floor Mat</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="innerCabinRearViewMirrorCheck" >
                                    <label class="form-check-label" for="innerCabinRearViewMirrorCheck">Rear View Mirror</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="innerCabinLuggageCompCheck" >
                                    <label class="form-check-label" for="innerCabinLuggageCompCheck">Luggage Comp</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="innerCabinRoofTopCheck" >
                                    <label class="form-check-label" for="innerCabinRoofTopCheck">Roof Top</label>
                                </div>
                            </div>
                        </div>

                    </div>
                    

                    
                
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" wire:click="customerJobUpdate('{{$job_number}}')" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn bg-gradient-primary">Submit</button>
            </div>
       </div>
    </div>
</div>
