<?php

namespace App\Http\Controllers;

use App\Models\Vehicletypes;
use App\Http\Requests\StoreVehicletypesRequest;
use App\Http\Requests\UpdateVehicletypesRequest;

class VehicletypesController extends Controller
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
     * @param  \App\Http\Requests\StoreVehicletypesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVehicletypesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vehicletypes  $vehicletypes
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicletypes $vehicletypes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vehicletypes  $vehicletypes
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicletypes $vehicletypes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVehicletypesRequest  $request
     * @param  \App\Models\Vehicletypes  $vehicletypes
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVehicletypesRequest $request, Vehicletypes $vehicletypes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehicletypes  $vehicletypes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicletypes $vehicletypes)
    {
        //
    }
}
