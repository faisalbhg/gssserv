<?php

namespace App\Http\Controllers;

use App\Models\VehicleChecklistEntry;
use App\Http\Requests\StoreVehicleChecklistEntryRequest;
use App\Http\Requests\UpdateVehicleChecklistEntryRequest;

class VehicleChecklistEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreVehicleChecklistEntryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVehicleChecklistEntryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VehicleChecklistEntry  $vehicleChecklistEntry
     * @return \Illuminate\Http\Response
     */
    public function show(VehicleChecklistEntry $vehicleChecklistEntry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VehicleChecklistEntry  $vehicleChecklistEntry
     * @return \Illuminate\Http\Response
     */
    public function edit(VehicleChecklistEntry $vehicleChecklistEntry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVehicleChecklistEntryRequest  $request
     * @param  \App\Models\VehicleChecklistEntry  $vehicleChecklistEntry
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVehicleChecklistEntryRequest $request, VehicleChecklistEntry $vehicleChecklistEntry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VehicleChecklistEntry  $vehicleChecklistEntry
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehicleChecklistEntry $vehicleChecklistEntry)
    {
        //
    }
}
