<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = DB::table('payments') ->paginate(5);
        return view('Manager.Payment.list') -> with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Manager.Payment.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        //
        DB::table('payments')->insert([
            'payment_method' => $request ->payment_method,
        ]);
        return Redirect::route('payment.index') ->with('msg','Add Successfull');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        //
        $data = DB::table('payments') ->where('id',$id) ->get();
        return view('Manager.Payment.edit') ->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, String $id)
    {
        //
        DB::table('payments')->where('id',$id)
            ->update([
                'payment_method' => $request ->payment_method,
            ]);
        return Redirect::route('payment.index') ->with('msg','Edit Successfull');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        //
        DB::table('payments') ->delete($id);
        return Redirect::route('payment.index') ->with('msg','Delete Successfull');
    }
}
