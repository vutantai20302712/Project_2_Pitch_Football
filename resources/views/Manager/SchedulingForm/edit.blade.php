@extends('layouts.layoutmaster')

@section('content')
    @foreach ($data as $key => $value)
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <form method="post" action="{{ route('scheduling_form.update', $value->id) }}">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <label for="customer_id"><strong> CUSTOMER NAME</strong></label>
                            <select class="form-control" id="customer_id" name="customer_id">
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        {{ $value->customer_id == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="admin_id"><strong> ADMIN MANAGER</strong></label>
                            <select class="form-control" id="admin_id" name="admin_id">
                                @foreach ($admins as $admin)
                                    <option value="{{ $admin->id }}"
                                        {{ $value->admin_id == $admin->id ? 'selected' : '' }}>
                                        {{ $admin->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="payment_method"><strong> PAYMENT METHOD</strong></label>
                            <select class="form-control" id="payment_method" name="payment_method">
                                @foreach ($payments as $payment)
                                    <option value="{{ $payment->id }}"
                                        {{ $value->payment_method == $payment->id ? 'selected' : '' }}>
                                        {{ $payment->payment_method }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1"><strong>DATE BOOKING</strong></label>
                            <input type="date" class="form-control" id="exampleInputPassword1"
                                name="scheduling_form_date" value="{{ $value->scheduling_form_date }}">
                        </div>
                        <div class="mb-3">
                            <label for="status"><strong>STATUS</strong></label>
                            <select class="form-control" id="status" name="scheduling_form_status">
                                <option value="Confirmed"
                                    {{ $value->scheduling_form_status == 'Unconfirmed' ? 'selected' : '' }}>Unconfirmed
                                </option>
                                <option value="Confirmed"
                                    {{ $value->scheduling_form_status == 'Confirmed' ? 'selected' : '' }}>Confirmed
                                </option>
                                <option value="Paid" {{ $value->scheduling_form_status == 'Paid' ? 'selected' : '' }}>
                                    Paid</option>
                                <option value="Cancelled"
                                    {{ $value->scheduling_form_status == 'Cancelled' ? 'selected' : '' }}>Cancelled
                                </option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary"
                            style="background: #CE165D ;--bs-btn-border-color: none;">UPDATE</button>
                        <table class="table text-center ">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Order Id</th>
                                    <th scope="col">Pitch</th>
                                    <th scope="col">Image Pitch</th>
                                    <th scope="col">Price Booking</th>
                                    <th scope="col">Time Booking</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($scheduling_form_details as $scheduling_form_detail)
                                    <tr>
                                        @if ($scheduling_form_detail->scheduling_form_id == $value->id)
                                            <td>{{ $scheduling_form_detail->scheduling_form_id }}</td>
                                            @foreach ($pitches as $pitch)
                                                @if ($scheduling_form_detail->pitch_id == $pitch->id)
                                                    <td>{{ $pitch->name }} </td>
                                                    <td><img src="{{ asset('img/' . $pitch->image) }}" alt=""
                                                            width="150" height="150"></td>
                                                    <td>{{ number_format($pitch->price, 0, ',', '.') }} ₫</td>
                                                @endif
                                            @endforeach
                                            @foreach ($time_frames as $time_frame)
                                                @if ($scheduling_form_detail->time_id == $time_frame->id)
                                                    <td class="btn btn-danger">{{ $time_frame->start_time }} -
                                                        {{ $time_frame->end_time }}</td>
                                                @endif
                                            @endforeach
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
