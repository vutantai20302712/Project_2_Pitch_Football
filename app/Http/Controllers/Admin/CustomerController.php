<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Scalar\String_;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DB::table('customers')->paginate(5); // Paginate 5 items per page
        return view('Manager.Customer.list')->with('data', $data);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Manager.Customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        //
        DB::table('customers')->insert([
            'name' => $request ->name,
            'email' => $request ->email,
            'password' => Hash::make($request ->password),
            'phone_number'=> $request ->phone_number
        ]);
        return Redirect::route('customer.index') ->with('msg','Add Successfull');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        //
        $data = DB::table('customers') ->where('id',$id) ->get();
        return view('Manager.Customer.edit') ->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, String $id)
    {
        //
        DB::table('customers')->where('id',$id)
            ->update([
                'name' => $request ->name,
                'email' => $request ->email,
                'password' => Hash::make($request ->password),
                'phone_number'=> $request ->phone_number
            ]);
        return Redirect::route('customer.index') ->with('msg','Edit Successfull');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        //
        DB::table('customers') ->delete($id);
        return Redirect::route('customer.index') ->with('msg','Delete Successfull');
    }
}
