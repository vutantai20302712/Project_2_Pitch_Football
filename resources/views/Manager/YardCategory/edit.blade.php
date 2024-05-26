@extends('layouts.layoutmaster')

@section('content')
    @foreach($data as $key => $value )
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <form method="post" action="{{route('yard_category.update',$value->id)}}">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputName1"><strong>Name</strong></label>
                            <input type="text" class="form-control" id="exampleInputPassword1" aria-describedby="emailHelp" name="name" value="{{$value ->name}}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1"><strong>Description</strong></label>
                            <input type="text" class="form-control" id="exampleInputPassword1" aria-describedby="emailHelp" name="description" value="{{$value ->description}}">
                        </div>
                        <button type="submit" class="btn btn-primary" style="background: #CE165D ;--bs-btn-border-color: none;">UPDATE</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
