@extends('layouts.layoutclient')

@section('content')
@if(Session::has('success'))
<div class="alert alert-success">{{ Session::get('success') }}</div>
@endif
@if(Session::has('errors'))
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
    @endforeach
</div>
@endif
<div class="col-md-6">
    <div class="contact-info">
        <div class="kode-section-title">
            <h3>Đăng ký tài khoản</h3>
            <div class="kode-forminfo">
                <p style="text-align:left">Đăng kí tài khoản khách hàng để có thể đặt lịch thuê sân bóng của trang web chúng tôi.</p>
                <ul class="kode-form-list">
                    <li>
                        <p style="text-align:left"><strong>Address:</strong> 303 Vũ Tấn Tài - Sao Hỏa</p>
                    </li>
                    <li>
                        <p style="text-align:left"><strong>Phone:</strong> 0326196160</p>
                    </li>
                    <li>
                        <p style="text-align:left"><strong>Email:</strong> vutai4420@gmail.com</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6" style="margin-bottom: 30px">
    <div class="contact-us">
        <form method="post" action="{{ route('page_register') }}">
            @csrf
            <ul>
                <li><input type="text" id="name" name="name" class="required" placeholder="Họ và tên" required></li>
                <li><input type="text" id="email" name="email" class="required email" placeholder="Email" required></li>
                <li><input type="password" name="password" id="password" placeholder="Mật khẩu" required></li>
                <li><input type="number" id="phone_number" name="phone_number" placeholder="Số điện thoại" required></li>
                <li><input type="submit" class="btn btn-primary" value="Đăng Ký"></li>
            </ul>
            <div class="hidden-me" id="contact_form_responce">
                <p></p>
            </div>
        </form>
    </div>
</div>
@endsection
