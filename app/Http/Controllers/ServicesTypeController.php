<?php

namespace App\Http\Controllers;

use App\Models\ServicesType;
use App\Http\Requests\StoreServicesTypeRequest;
use App\Http\Requests\UpdateServicesTypeRequest;

class ServicesTypeController extends Controller
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
     * @param  \App\Http\Requests\StoreServicesTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServicesTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServicesType  $servicesType
     * @return \Illuminate\Http\Response
     */
    public function show(ServicesType $servicesType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServicesType  $servicesType
     * @return \Illuminate\Http\Response
     */
    public function edit(ServicesType $servicesType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServicesTypeRequest  $request
     * @param  \App\Models\ServicesType  $servicesType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServicesTypeRequest $request, ServicesType $servicesType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServicesType  $servicesType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServicesType $servicesType)
    {
        //
    }
}
