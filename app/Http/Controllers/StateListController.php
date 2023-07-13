<?php

namespace App\Http\Controllers;

use App\Models\StateList;
use App\Http\Requests\StoreStateListRequest;
use App\Http\Requests\UpdateStateListRequest;

class StateListController extends Controller
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
     * @param  \App\Http\Requests\StoreStateListRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStateListRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StateList  $stateList
     * @return \Illuminate\Http\Response
     */
    public function show(StateList $stateList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StateList  $stateList
     * @return \Illuminate\Http\Response
     */
    public function edit(StateList $stateList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStateListRequest  $request
     * @param  \App\Models\StateList  $stateList
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStateListRequest $request, StateList $stateList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StateList  $stateList
     * @return \Illuminate\Http\Response
     */
    public function destroy(StateList $stateList)
    {
        //
    }
}
