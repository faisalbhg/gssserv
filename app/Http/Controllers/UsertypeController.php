<?php

namespace App\Http\Controllers;

use App\Models\Usertype;
use App\Http\Requests\StoreUsertypeRequest;
use App\Http\Requests\UpdateUsertypeRequest;

class UsertypeController extends Controller
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
     * @param  \App\Http\Requests\StoreUsertypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsertypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Usertype  $usertype
     * @return \Illuminate\Http\Response
     */
    public function show(Usertype $usertype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Usertype  $usertype
     * @return \Illuminate\Http\Response
     */
    public function edit(Usertype $usertype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUsertypeRequest  $request
     * @param  \App\Models\Usertype  $usertype
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUsertypeRequest $request, Usertype $usertype)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Usertype  $usertype
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usertype $usertype)
    {
        //
    }
}
