<?php

namespace App\Http\Controllers;

use App\Models\PackageBookings;
use App\Http\Requests\StorePackageBookingsRequest;
use App\Http\Requests\UpdatePackageBookingsRequest;

class PackageBookingsController extends Controller
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
     * @param  \App\Http\Requests\StorePackageBookingsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePackageBookingsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PackageBookings  $packageBookings
     * @return \Illuminate\Http\Response
     */
    public function show(PackageBookings $packageBookings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PackageBookings  $packageBookings
     * @return \Illuminate\Http\Response
     */
    public function edit(PackageBookings $packageBookings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePackageBookingsRequest  $request
     * @param  \App\Models\PackageBookings  $packageBookings
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePackageBookingsRequest $request, PackageBookings $packageBookings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PackageBookings  $packageBookings
     * @return \Illuminate\Http\Response
     */
    public function destroy(PackageBookings $packageBookings)
    {
        //
    }
}
