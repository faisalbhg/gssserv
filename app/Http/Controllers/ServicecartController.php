<?php

namespace App\Http\Controllers;

use App\Models\Servicecart;
use App\Http\Requests\StoreServicecartRequest;
use App\Http\Requests\UpdateServicecartRequest;

class ServicecartController extends Controller
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
     * @param  \App\Http\Requests\StoreServicecartRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServicecartRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Servicecart  $servicecart
     * @return \Illuminate\Http\Response
     */
    public function show(Servicecart $servicecart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Servicecart  $servicecart
     * @return \Illuminate\Http\Response
     */
    public function edit(Servicecart $servicecart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServicecartRequest  $request
     * @param  \App\Models\Servicecart  $servicecart
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServicecartRequest $request, Servicecart $servicecart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Servicecart  $servicecart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Servicecart $servicecart)
    {
        //
    }
}
