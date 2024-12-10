<?php

namespace App\Http\Controllers;

use App\Models\Development;
use App\Http\Requests\StoreDevelopmentRequest;
use App\Http\Requests\UpdateDevelopmentRequest;

class DevelopmentController extends Controller
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
     * @param  \App\Http\Requests\StoreDevelopmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDevelopmentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Development  $development
     * @return \Illuminate\Http\Response
     */
    public function show(Development $development)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Development  $development
     * @return \Illuminate\Http\Response
     */
    public function edit(Development $development)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDevelopmentRequest  $request
     * @param  \App\Models\Development  $development
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDevelopmentRequest $request, Development $development)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Development  $development
     * @return \Illuminate\Http\Response
     */
    public function destroy(Development $development)
    {
        //
    }
}
