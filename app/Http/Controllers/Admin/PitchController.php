<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePitchRequest;
use App\Http\Requests\UpdatePitchRequest;
use App\Models\Pitch;
use App\Models\Yard_category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PitchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = DB::table('pitches')
            ->join('yard_categories', 'pitches.yard_category', '=', 'yard_categories.id')
            ->select('pitches.*', 'yard_categories.name as yard_category_name')
            ->paginate(5);

        $yard_categories = DB::table('yard_categories')->get();
        return view('Manager.Pitch.list', compact('data', 'yard_categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $yard_categories = Yard_category::all();
        return view('Manager.Pitch.create', compact('yard_categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePitchRequest $request)
    {
        //
        $filename = null;
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('img/', $filename);
        }

        // Chèn dữ liệu sản phẩm vào cơ sở dữ liệu
        DB::table('pitches')->insert([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $filename,
            'address' => $request -> address,
            'yard_category' => $request->yard_category,
        ]);
        return Redirect::route('pitch.index')->with('msg', 'Thêm sản phẩm thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pitch $pitch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        //
        $data = DB::table('pitches')
            ->join('yard_categories', 'pitches.yard_category', '=', 'yard_categories.id')
            ->select('pitches.*', 'yard_categories.name as yard_category_name') // Chọn cột 'category_name'
            ->where('pitches.id', $id) // Lọc theo ID của sản phẩm
            ->paginate(5);
        $yard_categories = DB::table('yard_categories')->get();
        return view('Manager.Pitch.edit', compact('data','yard_categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePitchRequest $request, String $id)
    {
        //
        if ($request->has('price')) {
            DB::table('pitches')->where('id', $id)->update([
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'image' => $request->image,
                'address' => $request->address,
                'yard_category' => $request->yard_category,
            ]);
        } else {
        }
        return Redirect::route('pitch.index')->with('msg', 'Update Successfull');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        //
        DB::table('pitches') ->delete($id);
        return Redirect::route('pitch.index') ->with('msg','Delete Successfull');
    }
}
