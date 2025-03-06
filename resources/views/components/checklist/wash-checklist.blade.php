<div class="row">
    <div class="col-md-4">
        <div class="card m-2">
            <div class="card-header p-2">
                <h4 class="mb-2 text-sm text-left">Front Side</h4>
            </div>
            <div class="card-body p-2">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="frontSideBumperCheck" wire:model="frontSideBumperCheck" >
                    <label class="form-check-label" for="frontSideBumperCheck">Bumper</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="frontSideGrillCheck" wire:model="frontSideGrillCheck" >
                    <label class="form-check-label" for="frontSideGrillCheck">Grill</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="frontSideNumberPlateCheck" wire:model="frontSideNumberPlateCheck" >
                    <label class="form-check-label" for="frontSideNumberPlateCheck">Number Plate</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="frontSideHeadLampsCheck" wire:model="frontSideHeadLampsCheck" >
                    <label class="form-check-label" for="frontSideHeadLampsCheck">Head Lamps</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="frontSideFogLampsCheck" wire:model="frontSideFogLampsCheck" >
                    <label class="form-check-label" for="frontSideFogLampsCheck">Fog Lamps</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="frontSideHoodCheck" wire:model="frontSideHoodCheck" >
                    <label class="form-check-label" for="frontSideHoodCheck">Hood</label>
                </div>
            </div>
        </div>
        <div class="card m-2">
            <div class="card-header p-2">
                <h4 class="mt-3 text-sm text-left">Rear Side</h4>
            </div>
            <div class="card-body p-2">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="rearSideBumperCheck" wire:model="rearSideBumperCheck" >
                    <label class="form-check-label" for="rearSideBumperCheck">Bumper</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="rearSideMufflerCheck" wire:model="rearSideMufflerCheck" >
                    <label class="form-check-label" for="rearSideMufflerCheck">Muffler</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="rearSideNumberPlateCheck" wire:model="rearSideNumberPlateCheck" >
                    <label class="form-check-label" for="rearSideNumberPlateCheck">Number Plate</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="rearSideTrunkCheck" wire:model="rearSideTrunkCheck" >
                    <label class="form-check-label" for="rearSideTrunkCheck">Trunk</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="rearSideLightsCheck" wire:model="rearSideLightsCheck" >
                    <label class="form-check-label" for="rearSideLightsCheck">Lights</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="rearSideRoofTopCheck" wire:model="rearSideRoofTopCheck" >
                    <label class="form-check-label" for="rearSideRoofTopCheck">Roof Top</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card m-2">
            <div class="card-header p-2">
                <h4 class="mb-2 text-sm text-left">Left Side</h4>
            </div>
            <div class="card-body p-2">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="leftSideWheelCheck" wire:model="leftSideWheelCheck" >
                    <label class="form-check-label" for="leftSideWheelCheck">Wheel</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="leftSideFenderCheck" wire:model="leftSideFenderCheck" >
                    <label class="form-check-label" for="leftSideFenderCheck">Fender</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="leftSideSideMirrorCheck" wire:model="leftSideSideMirrorCheck" >
                    <label class="form-check-label" for="leftSideSideMirrorCheck">Side Mirror</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="leftSideDoorGlassInOutCheck" wire:model="leftSideDoorGlassInOutCheck" >
                    <label class="form-check-label" for="leftSideDoorGlassInOutCheck">Door Glass In & Out</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="leftSideDoorHandleCheck" wire:model="leftSideDoorHandleCheck" >
                    <label class="form-check-label" for="leftSideDoorHandleCheck">Door Handle</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="leftSideSideStepperCheck" wire:model="leftSideSideStepperCheck" >
                    <label class="form-check-label" for="leftSideSideStepperCheck">Side Stepper</label>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header p-2">
                <h4 class="mt-3 text-sm text-lefft">Right Side</h4>
            </div>
            <div class="card-body p-2">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="rightSideWheelCheck" wire:model="rightSideWheelCheck" >
                    <label class="form-check-label" for="rightSideWheelCheck">Wheel</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="rightSideFenderCheck" wire:model="rightSideFenderCheck" >
                    <label class="form-check-label" for="rightSideFenderCheck">Fender</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="rightSideSideMirrorCheck" wire:model="rightSideSideMirrorCheck" >
                    <label class="form-check-label" for="rightSideSideMirrorCheck">Side Mirror</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="rightSideDoorGlassInOutCheck" wire:model="rightSideDoorGlassInOutCheck" >
                    <label class="form-check-label" for="rightSideDoorGlassInOutCheck">Door Glass In & Out</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="rightSideDoorHandleCheck" wire:model="rightSideDoorHandleCheck" >
                    <label class="form-check-label" for="rightSideDoorHandleCheck">Door Handle</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="rightSideSideStepperCheck" wire:model="rightSideSideStepperCheck" >
                    <label class="form-check-label" for="rightSideSideStepperCheck">Side Stepper</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card m-2">
            <div class="card-header p-2">
                <h4 class="mb-2 text-sm text-left">Inner Cabin</h4>
            </div>
            <div class="card-body p-2">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="innerCabinSmellCheck" wire:model="innerCabinSmellCheck" >
                    <label class="form-check-label" for="innerCabinSmellCheck">Smell</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="innerCabinWindshieldFRRRCheck" wire:model="innerCabinWindshieldFRRRCheck" >
                    <label class="form-check-label" for="innerCabinWindshieldFRRRCheck">Windshield FR & RR</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="innerCabinSteeringWheelCheck" wire:model="innerCabinSteeringWheelCheck" >
                    <label class="form-check-label" for="innerCabinSteeringWheelCheck">Steering Wheel</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="innerCabinGearKnobCheck" wire:model="innerCabinGearKnobCheck" >
                    <label class="form-check-label" for="innerCabinGearKnobCheck">Gear Knob</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="innerCabinCentreConsoleCheck" wire:model="innerCabinCentreConsoleCheck" >
                    <label class="form-check-label" for="innerCabinCentreConsoleCheck">Centre Console</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="innerCabinAshTryCheck" wire:model="innerCabinAshTryCheck" >
                    <label class="form-check-label" for="innerCabinAshTryCheck">Ash Try</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="innerCabinDashboardCheck" wire:model="innerCabinDashboardCheck" >
                    <label class="form-check-label" for="innerCabinDashboardCheck">Dashboard</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="innerCabinACVentsFRRRCheck" wire:model="innerCabinACVentsFRRRCheck" >
                    <label class="form-check-label" for="innerCabinACVentsFRRRCheck">AC Vents FR & RR</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="innerCabinInteriorTrimCheck" wire:model="innerCabinInteriorTrimCheck" >
                    <label class="form-check-label" for="innerCabinInteriorTrimCheck">Interior Trim</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="innerCabinFloorMatCheck" wire:model="innerCabinFloorMatCheck" >
                    <label class="form-check-label" for="innerCabinFloorMatCheck">Floor Mat</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="innerCabinRearViewMirrorCheck" wire:model="innerCabinRearViewMirrorCheck" >
                    <label class="form-check-label" for="innerCabinRearViewMirrorCheck">Rear View Mirror</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="innerCabinLuggageCompCheck" wire:model="innerCabinLuggageCompCheck" >
                    <label class="form-check-label" for="innerCabinLuggageCompCheck">Luggage Comp</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="innerCabinRoofTopCheck" wire:model="innerCabinRoofTopCheck" >
                    <label class="form-check-label" for="innerCabinRoofTopCheck">Roof Top</label>
                </div>
            </div>
        </div>
    </div>
</div>
