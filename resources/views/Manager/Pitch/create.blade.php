@extends('layouts.layoutmaster')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (Session::has('msg'))
                    <div class="alert alert-success">{{ Session::get('msg') }}</div>
                @endif
                <form method="POST" action="{{ route('pitch.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleInputName1"><strong>Pitch Name</strong></label>
                                <input type="text" class="form-control" id="exampleInputName1"
                                    aria-describedby="emailHelp" name="name">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPrice1"><strong>Price</strong></label>
                                <input type="number" class="form-control" id="exampleInputPrice1"
                                    aria-describedby="emailHelp" name="price">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputQuantity1"><strong>Description</strong></label>
                                <input type="text" class="form-control" id="exampleInputQuantity1"
                                    aria-describedby="emailHelp" name="description">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputQuantity1"><strong>Address</strong></label>
                                <input type="text" class="form-control" id="exampleInputQuantity1"
                                    aria-describedby="emailHelp" name="address">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleInputImage1"><strong>Pitch Image</strong></label>
                                <input type="file" class="form-control-file" id="exampleInputImage1" name="image"
                                    onchange="previewImage(this);">
                                <br>
                                <img src="{{ asset('img/logoadmin.png') }}" alt="" id="preview" width="120px"
                                    height="150px" style="margin-top: 10px;">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputCategory1"><strong>Category</strong></label>
                                <select name="yard_category" class="form-control">
                                    @foreach ($yard_categories as $yard_category)
                                        <option value="{{ $yard_category->id }}"> {{ $yard_category->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center"> <!-- Thêm dòng này để giữ nút button ở giữa -->
                        <div class="col-md-6 text-center"> <!-- Thêm lớp 'text-center' để căn giữa nội dung -->
                            <button type="submit" class="btn btn-primary"><strong>ADD</strong></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script>
            function previewImage(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        document.getElementById('preview').src = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            }
        </script>
    </div>
@endsection
