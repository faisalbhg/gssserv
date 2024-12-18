<?php

namespace App\Http\Controllers;

use App\Models\PlateCategories;
use App\Http\Requests\StorePlateCategoriesRequest;
use App\Http\Requests\UpdatePlateCategoriesRequest;

class PlateCategoriesController extends Controller
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
     * @param  \App\Http\Requests\StorePlateCategoriesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePlateCategoriesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PlateCategories  $plateCategories
     * @return \Illuminate\Http\Response
     */
    public function show(PlateCategories $plateCategories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PlateCategories  $plateCategories
     * @return \Illuminate\Http\Response
     */
    public function edit(PlateCategories $plateCategories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePlateCategoriesRequest  $request
     * @param  \App\Models\PlateCategories  $plateCategories
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePlateCategoriesRequest $request, PlateCategories $plateCategories)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PlateCategories  $plateCategories
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlateCategories $plateCategories)
    {
        //
    }
}
