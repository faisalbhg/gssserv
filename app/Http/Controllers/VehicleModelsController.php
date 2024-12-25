<?php

namespace App\Http\Controllers;

use App\Models\VehicleModels;
use App\Http\Requests\StoreVehicleModelsRequest;
use App\Http\Requests\UpdateVehicleModelsRequest;

class VehicleModelsController extends Controller
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
     * @param  \App\Http\Requests\StoreVehicleModelsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVehicleModelsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VehicleModels  $vehicleModels
     * @return \Illuminate\Http\Response
     */
    public function show(VehicleModels $vehicleModels)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VehicleModels  $vehicleModels
     * @return \Illuminate\Http\Response
     */
    public function edit(VehicleModels $vehicleModels)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVehicleModelsRequest  $request
     * @param  \App\Models\VehicleModels  $vehicleModels
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVehicleModelsRequest $request, VehicleModels $vehicleModels)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VehicleModels  $vehicleModels
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehicleModels $vehicleModels)
    {
        //
    }
}
