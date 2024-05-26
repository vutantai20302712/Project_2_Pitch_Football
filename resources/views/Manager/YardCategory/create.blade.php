@extends('layouts.layoutmaster')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form method="post" action="{{ route('yard_category.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputName1"><strong>Enter Name</strong></label>
                        <input type="text" class="form-control" id="exampleInputName1" aria-describedby="emailHelp" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1"><strong>Enter Description</strong></label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="description">
                    </div>

                    <button type="submit" class="btn btn-primary"><strong>ADD</strong></button>
                </form>
            </div>
        </div>
    </div>
@endsection
