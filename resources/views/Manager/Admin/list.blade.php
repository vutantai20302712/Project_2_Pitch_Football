@extends('layouts.layoutmaster')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if(Session::has('msg'))
                    <div class="alert alert-success">{{Session::get('msg')}}</div>
                @endif
                <a href="{{route('admin.create')}}" class="btn btn-primary" ><strong>ADD NEW +</strong></a>
                <table class="table text-center ">
                    <thead class="table-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">NAME</th>
                        <th scope="col">EMAIL</th>
                        <th scope="col">ADDRESS</th>
                        <th scope="col">PHONE NUMBER</th>
                        <th scope="col" colspan="2">ACTION</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $key => $value)
                        <tr>
                            <td scope="row">{{$key + 1}}</td>
                            <td>{{$value->name}}</td>
                            <td>{{$value->email}}</td>
                            <td>{{$value->address}}</td>
                            <td>{{$value->phone_number}}</td>
                            <td><a href="{{ route('admin.edit', $value->id)}}" class="btn btn-info">Edit</a></td>
                            <td>
                                <form action="{{ route('admin.destroy', $value ->id) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Confirm Delete')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                  <!-- Pagination Links -->
                  <div class="d-flex justify-content-center">
                    {{ $data->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
@endsection
