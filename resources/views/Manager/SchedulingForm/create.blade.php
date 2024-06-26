@extends('layouts.layoutmaster')
@section('content')
<div class="col-md-12">
    @if (Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @elseif(Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
    @endif
    <form method="post" action="{{ route('scheduling_form.store') }}">
        @csrf
        <div class="mb-3">
            <label for="exampleInputCategory1"><strong>Pitch Renter</strong></label>
            <select name="customer_id" class="form-control">
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}"> {{ $customer->name }} </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="exampleInputCategory1"><strong>Pitch Manager</strong></label>
            <select name="admin_id" class="form-control">
                @foreach ($admins as $admin)
                    <option value="{{ $admin->id }}"> {{ $admin->name }} </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="exampleInputCategory1"><strong>Payment Method</strong></label>
            <select name="payment_method" class="form-control">
                @foreach ($payments as $payment)
                    <option value="{{ $payment->id }}"> {{ $payment->payment_method }} </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1"><strong>Reservation Date</strong></label>
            <input type="date" class="form-control" id="exampleInputPassword1" name="scheduling_form_date" min="{{ date('Y-m-d') }}">
        </div>
        
        <div class="mb-3">
            <label for="exampleInputPassword1"><strong>Reservation Status</strong></label>
            <select class="form-control" name="scheduling_form_status">
                <option value="Unconfirmed">Unconfimred</option>
                <option value="Confirmed">Confirmed</option>
                <option value="Paid">Paid</option>   
                <option value="Cancelled">Cancelled</option>           
            </select>
        </div>
        <button type="submit" class="btn btn-primary" style="background: #CE165D; --bs-btn-border-color: none;"><strong>ADD</strong></button>
        <table class="table text-center ">
            <thead class="table-light">
                <tr>
                    <th scope="col">Tên sân</th>
                    <th scope="col">Hình ảnh</th>
                    <th scope="col">Giá </th>
                    <th scope="col">Thời gian đặt</th>
                    <th scope="col">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cartItems as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td><img src="{{ asset('img/' . $item['image']) }}" alt="{{ $item['name'] }}" style="max-width: 100px;"></td>
                        <td>{{ number_format($item['price'], 0, ',', '.') }} đ</td>
                        <td class="btn btn-dark"> 
                            @foreach ($carttimes as $carttimeframe)
                                {{ $carttimeframe['start_time'] }} - {{ $carttimeframe['end_time'] }}  
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('cart.clear') }}" class="btn btn-danger">Xóa Giỏ Hàng</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>

    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <a class="nav-link collapsed btn btn-primary rounded-0 pt-2" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCustomer" aria-expanded="false" aria-controls="collapseCustomer">
                        Thêm chi tiết lịch đặt sân
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <div class="collapse" id="collapseCustomer" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
        <div class="row">
            @foreach ($pitches as $index => $pitch)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img src="{{ asset('img/' . $pitch->image) }}" alt="" class="bd-placeholder-img card-img-top" width="100%" height="225">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <form action="{{ route('cart.add', ['id' => $pitch->id]) }}" method="get" class="add-to-cart-form" id="add-to-cart-form-{{ $index }}">
                                        @csrf
                                    </form>
                                    <p class="card-text">{{ $pitch->name }}</p>
                                </div>
                                <small class="text-muted">{{ number_format($pitch->price, 0, ',', '.') }} ₫</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            @foreach ($pitches as $pitch)
            <div class="col-md-12">
                <h5>{{ $pitch->name }}</h5>
                @foreach ($time_frames as $timeframe)
                @php
                $isBooked = in_array($timeframe->id, $bookedTimeFrames[$pitch->id]);
            @endphp
                <form action="{{ route('carttime.add', ['id' => $timeframe->id]) }}" method="get"
                    class="add-to-cart-form" id="add-to-cart-form-{{ $index }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                        {{ $timeframe->start_time }} - {{ $timeframe->end_time }}</button>
                </form>
            @endforeach

            </div>
        @endforeach
        </div>  
    </div>
</div>
<script>
    function selectedTimeFrame(timeFrame) {
        document.getElementById('selectedTimeFrame').value = timeFrame;
    }
</script>
@endsection
