<?php

namespace App\Http\Controllers;

use App\Models\CustomerJobCards;
use App\Http\Requests\StoreCustomerJobCardsRequest;
use App\Http\Requests\UpdateCustomerJobCardsRequest;

class CustomerJobCardsController extends Controller
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
     * @param  \App\Http\Requests\StoreCustomerJobCardsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerJobCardsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomerJobCards  $customerJobCards
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerJobCards $customerJobCards)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerJobCards  $customerJobCards
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerJobCards $customerJobCards)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerJobCardsRequest  $request
     * @param  \App\Models\CustomerJobCards  $customerJobCards
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerJobCardsRequest $request, CustomerJobCards $customerJobCards)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerJobCards  $customerJobCards
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerJobCards $customerJobCards)
    {
        //
    }
}
