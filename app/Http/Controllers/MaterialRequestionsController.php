<?php

namespace App\Http\Controllers;

use App\Models\MaterialRequestions;
use App\Http\Requests\StoreMaterialRequestionsRequest;
use App\Http\Requests\UpdateMaterialRequestionsRequest;

class MaterialRequestionsController extends Controller
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
     * @param  \App\Http\Requests\StoreMaterialRequestionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMaterialRequestionsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MaterialRequestions  $materialRequestions
     * @return \Illuminate\Http\Response
     */
    public function show(MaterialRequestions $materialRequestions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MaterialRequestions  $materialRequestions
     * @return \Illuminate\Http\Response
     */
    public function edit(MaterialRequestions $materialRequestions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMaterialRequestionsRequest  $request
     * @param  \App\Models\MaterialRequestions  $materialRequestions
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMaterialRequestionsRequest $request, MaterialRequestions $materialRequestions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MaterialRequestions  $materialRequestions
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaterialRequestions $materialRequestions)
    {
        //
    }
}
