<?php

namespace App\Http\Controllers;

use App\Models\JobcardChecklistEntries;
use App\Http\Requests\StoreJobcardChecklistEntriesRequest;
use App\Http\Requests\UpdateJobcardChecklistEntriesRequest;

class JobcardChecklistEntriesController extends Controller
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
     * @param  \App\Http\Requests\StoreJobcardChecklistEntriesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJobcardChecklistEntriesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobcardChecklistEntries  $jobcardChecklistEntries
     * @return \Illuminate\Http\Response
     */
    public function show(JobcardChecklistEntries $jobcardChecklistEntries)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobcardChecklistEntries  $jobcardChecklistEntries
     * @return \Illuminate\Http\Response
     */
    public function edit(JobcardChecklistEntries $jobcardChecklistEntries)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateJobcardChecklistEntriesRequest  $request
     * @param  \App\Models\JobcardChecklistEntries  $jobcardChecklistEntries
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJobcardChecklistEntriesRequest $request, JobcardChecklistEntries $jobcardChecklistEntries)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobcardChecklistEntries  $jobcardChecklistEntries
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobcardChecklistEntries $jobcardChecklistEntries)
    {
        //
    }
}
