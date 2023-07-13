<?php

namespace App\Http\Controllers;

use Livewire\Component;

use App\Models\CustomerVehicle;
use App\Http\Requests\StoreCustomerVehicleRequest;
use App\Http\Requests\UpdateCustomerVehicleRequest;

use App\Models\Customerjobs;
use App\Models\Customerjobservices;
use App\Models\Customerjoblogs;

use Carbon\Carbon;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;

class CustomerVehicleController extends Component
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
     * @param  \App\Http\Requests\StoreCustomerVehicleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerVehicleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomerVehicle  $customerVehicle
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerVehicle $customerVehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerVehicle  $customerVehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerVehicle $customerVehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerVehicleRequest  $request
     * @param  \App\Models\CustomerVehicle  $customerVehicle
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerVehicleRequest $request, CustomerVehicle $customerVehicle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerVehicle  $customerVehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerVehicle $customerVehicle)
    {
        //
    }
}
