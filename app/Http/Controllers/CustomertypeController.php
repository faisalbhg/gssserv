<?php

namespace App\Http\Controllers;

use App\Models\Customertype;
use App\Http\Requests\StoreCustomertypeRequest;
use App\Http\Requests\UpdateCustomertypeRequest;

class CustomertypeController extends Controller
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
     * @param  \App\Http\Requests\StoreCustomertypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomertypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customertype  $customertype
     * @return \Illuminate\Http\Response
     */
    public function show(Customertype $customertype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customertype  $customertype
     * @return \Illuminate\Http\Response
     */
    public function edit(Customertype $customertype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomertypeRequest  $request
     * @param  \App\Models\Customertype  $customertype
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomertypeRequest $request, Customertype $customertype)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customertype  $customertype
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customertype $customertype)
    {
        //
    }
}
