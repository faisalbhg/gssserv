<?php

namespace App\Http\Controllers;

use App\Models\ServiceItems;
use App\Http\Requests\StoreServiceItemsRequest;
use App\Http\Requests\UpdateServiceItemsRequest;

class ServiceItemsController extends Controller
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
     * @param  \App\Http\Requests\StoreServiceItemsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceItemsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceItems  $serviceItems
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceItems $serviceItems)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceItems  $serviceItems
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceItems $serviceItems)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServiceItemsRequest  $request
     * @param  \App\Models\ServiceItems  $serviceItems
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceItemsRequest $request, ServiceItems $serviceItems)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceItems  $serviceItems
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceItems $serviceItems)
    {
        //
    }
}
