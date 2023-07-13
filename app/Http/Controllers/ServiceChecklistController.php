<?php

namespace App\Http\Controllers;

use App\Models\ServiceChecklist;
use App\Http\Requests\StoreServiceChecklistRequest;
use App\Http\Requests\UpdateServiceChecklistRequest;

class ServiceChecklistController extends Controller
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
     * @param  \App\Http\Requests\StoreServiceChecklistRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceChecklistRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceChecklist  $serviceChecklist
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceChecklist $serviceChecklist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceChecklist  $serviceChecklist
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceChecklist $serviceChecklist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServiceChecklistRequest  $request
     * @param  \App\Models\ServiceChecklist  $serviceChecklist
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceChecklistRequest $request, ServiceChecklist $serviceChecklist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceChecklist  $serviceChecklist
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceChecklist $serviceChecklist)
    {
        //
    }
}
