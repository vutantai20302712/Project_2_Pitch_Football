@extends('layouts.layoutmaster')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form method="post" action="{{ route('payment.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputName1"><strong>Payment Method</strong></label>
                        <input type="text" class="form-control" id="exampleInputName1" aria-describedby="emailHelp" name="payment_method">
                    </div>
                    <button type="submit" class="btn btn-primary"><strong>ADD</strong></button>
                </form>
            </div>
        </div>
    </div>
@endsection
