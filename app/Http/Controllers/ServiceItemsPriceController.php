<?php

namespace App\Http\Controllers;

use App\Models\ServiceItemsPrice;
use App\Http\Requests\StoreServiceItemsPriceRequest;
use App\Http\Requests\UpdateServiceItemsPriceRequest;

class ServiceItemsPriceController extends Controller
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
     * @param  \App\Http\Requests\StoreServiceItemsPriceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceItemsPriceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceItemsPrice  $serviceItemsPrice
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceItemsPrice $serviceItemsPrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceItemsPrice  $serviceItemsPrice
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceItemsPrice $serviceItemsPrice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServiceItemsPriceRequest  $request
     * @param  \App\Models\ServiceItemsPrice  $serviceItemsPrice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceItemsPriceRequest $request, ServiceItemsPrice $serviceItemsPrice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceItemsPrice  $serviceItemsPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceItemsPrice $serviceItemsPrice)
    {
        //
    }
}
