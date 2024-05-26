@extends('layouts.layoutmaster')

@section('content')
    @foreach($data as $key => $value )
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <form method="post" action="{{route('customer.update',$value->id)}}">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputName1"><strong>Full Name</strong></label>
                            <input type="text" class="form-control" id="exampleInputPassword1" aria-describedby="emailHelp" name="name" value="{{$value ->name}}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1"><strong>Enter Email</strong></label>
                            <input type="email" class="form-control" id="exampleInputPassword1" aria-describedby="emailHelp" name="email" value="{{$value ->email}}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1"><strong>Enter Password</strong></label>
                            <input type="password" class="form-control" id="exampleInputPassword1" name="password" value="{{$value ->password}}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPhoneNumber1"><strong>Phone Number</strong></label>
                            <input type="tel" class="form-control" id="exampleInputPhoneNumber1" aria-describedby="emailHelp" name="phone_number" value="{{$value ->phone_number}}">
                        </div>
                        <button type="submit" class="btn btn-primary" style="background: #CE165D ;--bs-btn-border-color: none;">UPDATE</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
