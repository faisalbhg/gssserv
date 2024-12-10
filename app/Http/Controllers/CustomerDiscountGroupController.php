<?php

namespace App\Http\Controllers;

use App\Models\CustomerDiscountGroup;
use App\Http\Requests\StoreCustomerDiscountGroupRequest;
use App\Http\Requests\UpdateCustomerDiscountGroupRequest;

class CustomerDiscountGroupController extends Controller
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
     * @param  \App\Http\Requests\StoreCustomerDiscountGroupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerDiscountGroupRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomerDiscountGroup  $customerDiscountGroup
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerDiscountGroup $customerDiscountGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerDiscountGroup  $customerDiscountGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerDiscountGroup $customerDiscountGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerDiscountGroupRequest  $request
     * @param  \App\Models\CustomerDiscountGroup  $customerDiscountGroup
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerDiscountGroupRequest $request, CustomerDiscountGroup $customerDiscountGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerDiscountGroup  $customerDiscountGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerDiscountGroup $customerDiscountGroup)
    {
        //
    }
}
