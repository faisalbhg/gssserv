<?php

namespace App\Http\Controllers;

use App\Models\CustomerServiceCart;
use App\Http\Requests\StoreCustomerServiceCartRequest;
use App\Http\Requests\UpdateCustomerServiceCartRequest;

class CustomerServiceCartController extends Controller
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
     * @param  \App\Http\Requests\StoreCustomerServiceCartRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerServiceCartRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomerServiceCart  $customerServiceCart
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerServiceCart $customerServiceCart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerServiceCart  $customerServiceCart
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerServiceCart $customerServiceCart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerServiceCartRequest  $request
     * @param  \App\Models\CustomerServiceCart  $customerServiceCart
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerServiceCartRequest $request, CustomerServiceCart $customerServiceCart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerServiceCart  $customerServiceCart
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerServiceCart $customerServiceCart)
    {
        //
    }
}
