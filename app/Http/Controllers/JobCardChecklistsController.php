<?php

namespace App\Http\Controllers;

use App\Models\JobCardChecklists;
use App\Http\Requests\StoreJobCardChecklistsRequest;
use App\Http\Requests\UpdateJobCardChecklistsRequest;

class JobCardChecklistsController extends Controller
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
     * @param  \App\Http\Requests\StoreJobCardChecklistsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJobCardChecklistsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobCardChecklists  $jobCardChecklists
     * @return \Illuminate\Http\Response
     */
    public function show(JobCardChecklists $jobCardChecklists)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobCardChecklists  $jobCardChecklists
     * @return \Illuminate\Http\Response
     */
    public function edit(JobCardChecklists $jobCardChecklists)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateJobCardChecklistsRequest  $request
     * @param  \App\Models\JobCardChecklists  $jobCardChecklists
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJobCardChecklistsRequest $request, JobCardChecklists $jobCardChecklists)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobCardChecklists  $jobCardChecklists
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobCardChecklists $jobCardChecklists)
    {
        //
    }
}
