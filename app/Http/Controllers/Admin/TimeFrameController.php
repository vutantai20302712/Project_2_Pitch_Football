<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTime_frameRequest;
use App\Http\Requests\UpdateTime_frameRequest;
use App\Models\Time_frame;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class TimeFrameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = DB::table('time_frames') -> get();
        $data = Time_frame::paginate(5);
        return view('Manager.TimeFrame.list',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Manager.TimeFrame.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTime_frameRequest $request)
    {
        //// Truncate description to fit within 255 characters
        DB::table('time_frames')->insert([
            'start_time' => $request->start_time,
            'end_time' => $request ->end_time, // Use truncated description
        ]);
        return Redirect::route('time_frame.index')->with('msg', 'Add Successful');
    }

    /**
     * Display the specified resource.
     */
    public function show(Time_frame $time_frame)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        //
        $data = DB::table('time_frames') ->where('id',$id) ->get();
        return view('Manager.TimeFrame.edit') ->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTime_frameRequest $request, String $id)
    {
        //
        DB::table('time_frames')->where('id',$id)
            ->update([
                'start_time' => $request ->start_time,
                'end_time' => $request ->end_time,
            ]);
        return Redirect::route('time_frame.index') ->with('msg','Edit Successfull');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        //
        DB::table('time_frames') ->delete($id);
        return Redirect::route('time_frame.index') ->with('msg','Delete Successfull');
    }
}
