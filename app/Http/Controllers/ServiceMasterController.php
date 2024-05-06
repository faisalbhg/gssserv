<?php

namespace App\Http\Controllers;

use App\Models\ServiceMaster;
use App\Http\Requests\StoreServiceMasterRequest;
use App\Http\Requests\UpdateServiceMasterRequest;

class ServiceMasterController extends Controller
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
     * @param  \App\Http\Requests\StoreServiceMasterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceMasterRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceMaster  $serviceMaster
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceMaster $serviceMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceMaster  $serviceMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceMaster $serviceMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServiceMasterRequest  $request
     * @param  \App\Models\ServiceMaster  $serviceMaster
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceMasterRequest $request, ServiceMaster $serviceMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceMaster  $serviceMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceMaster $serviceMaster)
    {
        //
    }
}
