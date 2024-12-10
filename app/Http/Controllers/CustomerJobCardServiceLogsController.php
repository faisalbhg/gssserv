<?php

namespace App\Http\Controllers;

use App\Models\CustomerJobCardServiceLogs;
use App\Http\Requests\StoreCustomerJobCardServiceLogsRequest;
use App\Http\Requests\UpdateCustomerJobCardServiceLogsRequest;

class CustomerJobCardServiceLogsController extends Controller
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
     * @param  \App\Http\Requests\StoreCustomerJobCardServiceLogsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerJobCardServiceLogsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomerJobCardServiceLogs  $customerJobCardServiceLogs
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerJobCardServiceLogs $customerJobCardServiceLogs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerJobCardServiceLogs  $customerJobCardServiceLogs
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerJobCardServiceLogs $customerJobCardServiceLogs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerJobCardServiceLogsRequest  $request
     * @param  \App\Models\CustomerJobCardServiceLogs  $customerJobCardServiceLogs
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerJobCardServiceLogsRequest $request, CustomerJobCardServiceLogs $customerJobCardServiceLogs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerJobCardServiceLogs  $customerJobCardServiceLogs
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerJobCardServiceLogs $customerJobCardServiceLogs)
    {
        //
    }
}
