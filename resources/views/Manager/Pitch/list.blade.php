@extends('layouts.layoutmaster')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if(Session::has('msg'))
                    <div class="alert alert-success">{{Session::get('msg')}}</div>
                @endif
                <a href="{{route('pitch.create')}}" class="btn btn-primary" ><strong>ADD NEW +</strong></a>
                <table class="table text-center ">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>IMAGE</th>
                            <th>PRICE</th>
                            <th>YARD CATEGORY</th>
                            <th>DESCRIPTION</th>
                            <th scope="col" colspan="2">ACTION</th>
                        </tr>
                    </thead>
                        @foreach($data as $key => $value)
                        <?php
                        $maxLength = 27; // Số ký tự tối đa bạn muốn hiển thị
                        $description = $value->description;
                        if (strlen($description) > $maxLength) {
                            $description = substr($description, 0, $maxLength) . '...';
                        }
                        ?>
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$value->name}}</td>
                                <td>
                                    @if ($value->image)
                                        <img src="{{ asset('img/' . $value->image) }}" alt="" width="150" height="150">
                                    @else
                                        <span>No Image</span>
                                    @endif
                                </td>
                                <td>{{ number_format($value->price, 0, ',', '.') }} ₫</td>
                                <td>{{$value->yard_category_name}}</td>
                                <td>{{$description}}</td>
                                <td><a href="{{route('pitch.edit', $value->id)}}" class="btn btn-info">Edit</a></td>
                                <td>
                                    <form action="{{route('pitch.destroy',$value->id)}}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Xác nhận Xóa')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                      <!-- Pagination Links -->
                 <div class="d-flex justify-content-center">
                    {{ $data->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
@endsection
