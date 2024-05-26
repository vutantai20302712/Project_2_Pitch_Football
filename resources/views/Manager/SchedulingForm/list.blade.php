@extends('layouts.layoutmaster')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (Session::has('msg'))
                    <div class="alert alert-success">{{ Session::get('msg') }}</div>
                @endif
                <a href="{{ route('scheduling_form.create') }}" class="btn btn-primary"><strong>ADD NEW +</strong></a>
                <table class="table text-center">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>CUSTOMER NAME</th>
                            <th>ADMIN MANAGER</th>
                            <th>STATUS</th>
                            <th>DATE</th>
                            <th>PAYMENT STATUS</th>
                            <th scope="col" colspan="2">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $value)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $value->customer_name }}</td>
                                <td>{{ $value->admin_name }}</td>
                                <td>
                                    @if ($value->scheduling_form_status == 'Unconfirmed')
                                    <span class="badge badge-sm bg-gradient-secondary">Unconfirmed</span>
                                @elseif ($value->scheduling_form_status == 'Confirmed')
                                    <span class="badge badge-sm bg-gradient-primary">Comfirmed</span>
                                @elseif ($value->scheduling_form_status == 'Paid')
                                <span class="badge badge-sm bg-gradient-warning">Paid</span>
                                @else
                                <span class="badge badge-sm bg-gradient-danger">Cancelled</span>
                                @endif
                                </td>
                                <td>{{ $value->scheduling_form_date }}</td>
                                <td>
                                    @if ($value->payment_method == 'Online')
                                        <span class="badge badge-sm bg-gradient-success">Đã thanh toán</span>
                                    @else
                                        <span class="badge badge-sm bg-gradient-danger">Chưa thanh toán</span>
                                    @endif
                                </td>
                                <td><a href="{{ route('scheduling_form.edit', $value->id) }}" class="btn btn-info">Edit</a></td>
                                <td>
                                    <form action="{{ route('scheduling_form.destroy', $value->id) }}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Xác nhận Xóa')">Delete</button>
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
