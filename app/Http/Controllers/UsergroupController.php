<?php

namespace App\Http\Controllers;

use App\Models\Usergroup;
use App\Http\Requests\StoreUsergroupRequest;
use App\Http\Requests\UpdateUsergroupRequest;

class UsergroupController extends Controller
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
     * @param  \App\Http\Requests\StoreUsergroupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsergroupRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Usergroup  $usergroup
     * @return \Illuminate\Http\Response
     */
    public function show(Usergroup $usergroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Usergroup  $usergroup
     * @return \Illuminate\Http\Response
     */
    public function edit(Usergroup $usergroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUsergroupRequest  $request
     * @param  \App\Models\Usergroup  $usergroup
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUsergroupRequest $request, Usergroup $usergroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Usergroup  $usergroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usergroup $usergroup)
    {
        //
    }
}
