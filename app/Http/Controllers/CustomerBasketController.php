<?php

namespace App\Http\Controllers;

use App\Models\CustomerBasket;
use App\Http\Requests\StoreCustomerBasketRequest;
use App\Http\Requests\UpdateCustomerBasketRequest;

class CustomerBasketController extends Controller
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
     * @param  \App\Http\Requests\StoreCustomerBasketRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerBasketRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomerBasket  $customerBasket
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerBasket $customerBasket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerBasket  $customerBasket
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerBasket $customerBasket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerBasketRequest  $request
     * @param  \App\Models\CustomerBasket  $customerBasket
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerBasketRequest $request, CustomerBasket $customerBasket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerBasket  $customerBasket
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerBasket $customerBasket)
    {
        //
    }
}
