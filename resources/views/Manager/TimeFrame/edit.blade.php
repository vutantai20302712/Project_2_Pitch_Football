@extends('layouts.layoutmaster')

@section('content')
    @foreach($data as $key => $value )
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <form method="post" action="{{route('time_frame.update',$value->id)}}">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputName1"><strong>Start Time</strong></label>
                            <input type="text" class="form-control" id="exampleInputPassword1" aria-describedby="emailHelp" name="start_time" value="{{$value ->start_time}}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1"><strong>End Time</strong></label>
                            <input type="text" class="form-control" id="exampleInputPassword1" aria-describedby="emailHelp" name="end_time" value="{{$value ->end_time}}">
                        </div>
                        <button type="submit" class="btn btn-primary">UPDATE</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
