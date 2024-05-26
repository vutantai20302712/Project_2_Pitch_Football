<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @vite(['resources/css/app.css'])
</head>
<body>
    <div id="app">
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav class="navbar navbar-dark bg-dark">
                <a href="{{ route('home_admin')}}">
                    <img src="{{ asset('img/logo.png') }}" class="logo" width="150px" height="45px" style="margin-left:25px;">
                </a>
                <div>
                    <a href="{{ route('login_admin')}}" style="text-decoration:none;">
                        <p class="option_login_logout"><strong> LOGOUT</strong></p>
                    </a>
                </div>
            </nav>
            <div class="card" style="border-radius:0px">
                <div class="container">
                    <div class="row">
                        <div class="col-md-2 bg-dark">
                            <div id="list-example" class="list-group">
                                <a href="{{ route('admin.index') }}" class="cate_option" style="background-color: #00BCFF; border-radius:5px;border:1px solid white; margin-top:30px; text-decoration:none; text-align:center;padding:10px; margin-bottom:15px;"><strong>ADMIN</strong></a>
                                <a href="{{ route('customer.index') }}" class="cate_option" style="background-color: #00BCFF; border-radius:5px;border:1px solid white; text-decoration:none; text-align:center;padding:10px; margin-bottom:15px;"><strong>CUSTOMER</strong></a>
                                <a href="{{ route('yard_category.index') }}" class="cate_option" style="background-color: #00BCFF; border-radius:5px;border:1px solid white; text-decoration:none; text-align:center;padding:10px; margin-bottom:15px;"><strong>YARD CATEGORY</strong></a>
                                <a href="{{ route('payment.index') }}" class="cate_option" style="background-color: #00BCFF; border-radius:5px;border:1px solid white; text-decoration:none; text-align:center;padding:10px; margin-bottom:15px;"><strong>PAYMENT METHOD</strong></a>
                                <a href="{{ route('pitch.index') }}" class="cate_option" style="background-color: #00BCFF; border-radius:5px;border:1px solid white; text-decoration:none; text-align:center;padding:10px; margin-bottom:15px;"><strong>PITCH</strong></a>
                                <a href="{{ route('time_frame.index') }}" class="cate_option" style="background-color: #00BCFF; border-radius:5px;border:1px solid white; text-decoration:none; text-align:center;padding:10px; margin-bottom:15px;"><strong>TIME FRAME</strong></a>
                                <a href="{{ route('scheduling_form.index') }}" class="cate_option" style="background-color: #00BCFF; border-radius:5px;border:1px solid white; text-decoration:none; text-align:center;padding:10px; margin-bottom:15px;"><strong>SCHEDULING FORM</strong></a>
                            </div>
                        </div>
                        <div class="col-md-10"> <!-- Thay đổi class -->
                            <main class="py-4">
                                 @yield('content')
                            </main>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</body>
</html>
