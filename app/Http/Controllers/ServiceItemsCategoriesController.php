<?php

namespace App\Http\Controllers;

use App\Models\ServiceItemsCategories;
use App\Http\Requests\StoreServiceItemsCategoriesRequest;
use App\Http\Requests\UpdateServiceItemsCategoriesRequest;

class ServiceItemsCategoriesController extends Controller
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
     * @param  \App\Http\Requests\StoreServiceItemsCategoriesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceItemsCategoriesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceItemsCategories  $serviceItemsCategories
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceItemsCategories $serviceItemsCategories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceItemsCategories  $serviceItemsCategories
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceItemsCategories $serviceItemsCategories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServiceItemsCategoriesRequest  $request
     * @param  \App\Models\ServiceItemsCategories  $serviceItemsCategories
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceItemsCategoriesRequest $request, ServiceItemsCategories $serviceItemsCategories)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceItemsCategories  $serviceItemsCategories
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceItemsCategories $serviceItemsCategories)
    {
        //
    }
}
