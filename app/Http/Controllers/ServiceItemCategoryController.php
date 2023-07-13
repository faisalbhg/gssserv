<?php

namespace App\Http\Controllers;

use App\Models\ServiceItemCategory;
use App\Http\Requests\StoreServiceItemCategoryRequest;
use App\Http\Requests\UpdateServiceItemCategoryRequest;

class ServiceItemCategoryController extends Controller
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
     * @param  \App\Http\Requests\StoreServiceItemCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceItemCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceItemCategory  $serviceItemCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceItemCategory $serviceItemCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceItemCategory  $serviceItemCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceItemCategory $serviceItemCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServiceItemCategoryRequest  $request
     * @param  \App\Models\ServiceItemCategory  $serviceItemCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceItemCategoryRequest $request, ServiceItemCategory $serviceItemCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceItemCategory  $serviceItemCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceItemCategory $serviceItemCategory)
    {
        //
    }
}
