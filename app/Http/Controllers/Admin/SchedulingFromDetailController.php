<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScheduling_from_detailRequest;
use App\Http\Requests\UpdateScheduling_from_detailRequest;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Scheduling_from_detail;

class SchedulingFromDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScheduling_from_detailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Scheduling_from_detail $scheduling_from_detail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Scheduling_from_detail $scheduling_from_detail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScheduling_from_detailRequest $request, Scheduling_from_detail $scheduling_from_detail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Scheduling_from_detail $scheduling_from_detail)
    {
        //
    }
}
