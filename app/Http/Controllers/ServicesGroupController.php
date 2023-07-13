<?php

namespace App\Http\Controllers;

use App\Models\ServicesGroups;
use App\Http\Requests\StoreServicesGroupRequest;
use App\Http\Requests\UpdateServicesGroupRequest;

class ServicesGroupController extends Controller
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
     * @param  \App\Http\Requests\StoreServicesGroupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServicesGroupRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServicesGroups  $servicesGroup
     * @return \Illuminate\Http\Response
     */
    public function show(ServicesGroup $servicesGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServicesGroups  $servicesGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(ServicesGroup $servicesGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServicesGroupRequest  $request
     * @param  \App\Models\ServicesGroups  $servicesGroup
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServicesGroupRequest $request, ServicesGroup $servicesGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServicesGroups  $servicesGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServicesGroup $servicesGroup)
    {
        //
    }
}
