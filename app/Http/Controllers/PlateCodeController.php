<?php

namespace App\Http\Controllers;

use App\Models\PlateCode;
use App\Http\Requests\StorePlateCodeRequest;
use App\Http\Requests\UpdatePlateCodeRequest;

class PlateCodeController extends Controller
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
     * @param  \App\Http\Requests\StorePlateCodeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePlateCodeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PlateCode  $plateCode
     * @return \Illuminate\Http\Response
     */
    public function show(PlateCode $plateCode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PlateCode  $plateCode
     * @return \Illuminate\Http\Response
     */
    public function edit(PlateCode $plateCode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePlateCodeRequest  $request
     * @param  \App\Models\PlateCode  $plateCode
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePlateCodeRequest $request, PlateCode $plateCode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PlateCode  $plateCode
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlateCode $plateCode)
    {
        //
    }
}
