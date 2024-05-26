@extends('layouts.layoutclient')
@section('content')
<section id="contant" class="contant">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="full">
                    <div class="main-heading sytle-2">
                        <h2>Xử lý đơn đặt lịch hiện tại</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@if (session('selected_pitch'))
<div class="container">
    <div id="session-table" class="table-container">
        <table class="table text-center mx-auto">
            <thead class="table-light">
                <tr class="text-center">
                    <th scope="col" class="text-center">Sân muốn đặt</th>
                    <th scope="col" class="text-center">Hình ảnh sân</th>
                    <th scope="col" class="text-center">Giá thuê sân</th>
                    <th scope="col" class="text-center">Thời gian đặt</th>
                    <th scope="col" class="text-center">Xóa</th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                    <td>{{ session('selected_pitch.pitch_name') }}</td>
                    <td style="max-width: 70px;"><img src="{{ asset('img/' . session('selected_pitch.pitch_image')) }}" alt="#" class="img-responsive" /></td>
                    <td>{{ number_format(session('selected_pitch.pitch_price'), 0, ',', '.') }} ₫</td>
                    <td>
                        @if (session('selected_time_frames'))
                        <div class="time-frames" style="background-color: rgb(22, 82, 201); color:white;padding:10px;border-radius:5px;font-weight:bold">
                            @foreach (session('selected_time_frames') as $timeFrame)
                            {{ $timeFrame['start_time'] }} - {{ $timeFrame['end_time'] }}<br>
                            @endforeach
                        </div>
                        @else
                        <span>Chưa chọn khung giờ</span>
                        @endif
                    </td>
                    <td class="d-flex justify-content-center">
                        <form action="{{ route('pitch.delete') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-danger" style="padding:20px; border-radius:10px; border-color:white">Hủy đơn tạo hiện tại</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endif
    <div class="col-md-12" style="margin-bottom:40px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @csrf
                    @if (session()->has('id'))
                    <div class="form-group">
                        <h3>Các thông tin cá nhân cần thiết để đặt sân của bạn:</h3>
                        <p style="text-align:left">😜 Tên người đặt: 🐳<strong style="color:#EC870E">@if (session()->has('name')) {{ session('name') }} @endif</strong>🐋</p>
                        <p style="text-align:left">📧 Email người đặt:🐧<strong style="color: #F09C42">@if (session()->has('email')) {{ session('email') }} @endif</strong>🐧</p>
                        <p style="text-align:left">📞 Số điện thoại người đặt:📲<strong style="color: #F5B16D">@if (session()->has('phone_number')) {{ session('phone_number') }} @endif</strong>📱</p>
                    </div>
                    <div class="form-group">
                        <h3>Chọn phương thức thanh toán:</h3>
                        <form action="{{ route('payment.process') }}" method="POST">
                            @csrf
                            <input type="hidden" name="total" value="{{ session('selected_pitch.pitch_price') }}">
                            <div class="form-group">
                                <label for="scheduling_form_date">Chọn ngày lên lịch:</label>
                                <input type="date" class="form-control" id="scheduling_form_date" name="scheduling_form_date" required>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="offline" value="offline" checked>
                                <label class="form-check-label" for="offline">Thanh toán offline</label>
                            </div>
                            <div id="offline-button">
                                <button type="submit" formaction="{{ route('booking.offline') }}" class="btn btn-primary" style="margin-top:10px">Đặt Sân</button><br><br><br>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="online" value="online">
                                <label class="form-check-label" for="online">Thanh toán online</label>
                            </div>
                            <div id="vnpay-button" style="display:none;">
                                @if (session('payment_status') !== 'success')
                                <button type="submit" name="redirect" class="primary-btn checkout-btn">Payment VNPAY</button>
                                @else
                                <button type="button" class="btn btn-secondary" disabled style="margin-right:20px;">Đã thanh toán</button><br><br>
                                <button type="submit" formaction="{{ route('booking.online') }}" class="btn btn-primary" style="margin-top:0px">Đặt Sân</button>
                                @endif
                            </div>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
        const vnpayButton = document.getElementById('vnpay-button');
        const offlineButton = document.getElementById('offline-button');

        paymentMethods.forEach(method => {
            method.addEventListener('change', function() {
                if (this.value === 'online') {
                    vnpayButton.style.display = 'block';
                    offlineButton.style.display = 'none';
                } else {
                    vnpayButton.style.display = 'none';
                    offlineButton.style.display = 'block';
                }
            });
        });
    });
</script>
