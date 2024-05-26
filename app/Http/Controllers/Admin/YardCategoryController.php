<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreYard_categoryRequest;
use App\Http\Requests\UpdateYard_categoryRequest;
use App\Models\Yard_category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class YardCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = DB::table('yard_categories') -> paginate(5);
        return view('Manager.YardCategory.list') -> with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Manager.YardCategory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreYard_categoryRequest $request)
    {
        $description = substr($request->description, 0, 255); // Truncate description to fit within 255 characters
        DB::table('yard_categories')->insert([
            'name' => $request->name,
            'description' => $description, // Use truncated description
        ]);
        return Redirect::route('yard_category.index')->with('msg', 'Add Successful');
    }


    /**
     * Display the specified resource.
     */
    public function show(Yard_category $yard_category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        //
        $data = DB::table('yard_categories') ->where('id',$id) ->get();
        return view('Manager.YardCategory.edit') ->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateYard_categoryRequest $request, String $id)
    {
        //
        DB::table('yard_categories')->where('id',$id)
            ->update([
                'name' => $request ->name,
                'description' => $request ->description,
            ]);
        return Redirect::route('yard_category.index') ->with('msg','Edit Successfull');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        //
        DB::table('yard_categories') ->delete($id);
        return Redirect::route('yard_category.index') ->with('msg','Delete Successfull');
    }
}
