@extends('layouts.layoutmaster')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form method="post" action="{{ route('customer.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputName1"><strong>Enter Name</strong></label>
                        <input type="text" class="form-control" id="exampleInputName1" aria-describedby="emailHelp" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1"><strong>Enter Email</strong></label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1"><strong>Enter Password</strong></label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPhoneNumber1"><strong>Enter Phone Number</strong></label>
                        <input type="tel" class="form-control" id="exampleInputPhoneNumber1" aria-describedby="emailHelp" name="phone_number">
                    </div>
                    <button type="submit" class="btn btn-primary"><strong>ADD</strong></button>
                </form>
            </div>
        </div>
    </div>
@endsection
