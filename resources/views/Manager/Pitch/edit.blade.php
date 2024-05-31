@extends('layouts.layoutmaster')

@section('content')
    @foreach($data as $key => $value)
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if(Session::has('msg'))
                    <div class="alert alert-success">{{Session::get('msg')}}</div>
                @endif
                <form method="post" action="{{ route('pitch.update', $value->id) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleInputName1"><strong>Pitch Name</strong></label>
                                <input type="text" class="form-control" id="exampleInputName1" aria-describedby="emailHelp" name="name" value="{{ $value->name }}">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputName1"><strong>Price</strong></label>
                                <input type="text" class="form-control" id="exampleInputName1" aria-describedby="emailHelp" name="price" value="{{ $value->price }}">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputName1"><strong>Description</strong></label>
                                <input type="text" class="form-control" id="exampleInputName1" aria-describedby="emailHelp" name="description" value="{{ $value->description }}">
                            </div>
                            <div class="mb-3">
                                <label for="yard_category"><strong>Yard Category</strong></label>
                                <select class="form-control" id="yard_category" name="yard_category">
                                    @foreach($yard_categories as $yard_category)
                                        <option value="{{ $yard_category->id }}" {{ $value->yard_category == $yard_category->id ? 'selected' : '' }}>
                                            {{ $yard_category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleInputImage1"><strong>Pitch Image</strong></label>
                                <input type="file" class="form-control-file" id="exampleInputImage1" name="image" onchange="previewImage(this);">
                                <br>
                                <img src="{{ asset('img/' . $value->image) }}" alt="Pitch Image" id="preview" width="120px" height="150px" style="margin-top: 10px;">
                                <input type="hidden" name="current_image" value="{{ $value->image }}">
                                <script>
                                    function previewImage(input) {
                                        var preview = document.getElementById('preview');
                                        if (input.files && input.files[0]) {
                                            var reader = new FileReader();
                                            reader.onload = function (e) {
                                                preview.src = e.target.result;
                                            }
                                            reader.readAsDataURL(input.files[0]);
                                        }
                                    }
                                </script>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputName1"><strong>Address</strong></label>
                                <input type="text" class="form-control" id="exampleInputName1" aria-describedby="emailHelp" name="address" value="{{ $value->address }}">
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-6 text-center">
                            <button type="submit" class="btn btn-primary"><strong>UPDATE</strong></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
@endsection
