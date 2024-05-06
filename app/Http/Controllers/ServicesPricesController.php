<?php

namespace App\Http\Controllers;

use App\Models\ServicesPrices;
use App\Http\Requests\StoreServicesPricesRequest;
use App\Http\Requests\UpdateServicesPricesRequest;

class ServicesPricesController extends Controller
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
     * @param  \App\Http\Requests\StoreServicesPricesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServicesPricesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServicesPrices  $servicesPrices
     * @return \Illuminate\Http\Response
     */
    public function show(ServicesPrices $servicesPrices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServicesPrices  $servicesPrices
     * @return \Illuminate\Http\Response
     */
    public function edit(ServicesPrices $servicesPrices)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServicesPricesRequest  $request
     * @param  \App\Models\ServicesPrices  $servicesPrices
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServicesPricesRequest $request, ServicesPrices $servicesPrices)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServicesPrices  $servicesPrices
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServicesPrices $servicesPrices)
    {
        //
    }
}
