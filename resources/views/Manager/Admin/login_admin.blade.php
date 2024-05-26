@extends('layouts.login_admin')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="background_login_admin">
                <div class="logo-title-container">
                    <img src="{{ asset('img/logo_loginadmin.png') }}" class="logo">
                    <h1 class="title_page">SPORT<strong style="color:red"> ONE</strong><br>START</h1>
                </div>
                <div class="col-md-12 custom-align-center">
                    <div class="background_form">
                        <form method="POST" action="{{ route('login.admin') }}">
                            @csrf
                            <div class="mb-3" style="margin-left: 50px; margin-right: 50px; margin-top: 80px;">
                                <label for="exampleInputEmail1" class="form-label">EMAIL</label>
                                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3" style="margin-left: 50px; margin-right: 50px;">
                                <label for="exampleInputPassword1" class="form-label">PASSWORD</label>
                                <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                            </div>
                            <div class="d-flex justify-content-center mb-3" style="margin-bottom:80px; margin-top:30px"> <!-- Thêm lớp d-flex và justify-content-center -->
                                <button type="submit" class="btn btn-primary buttonloginadmin" style="background-color:red; border:none; font-size: 20px;">LOG IN</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
