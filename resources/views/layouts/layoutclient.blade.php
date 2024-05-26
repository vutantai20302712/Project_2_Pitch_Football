<!DOCTYPE html>
<html lang="en">
<!-- Basic -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- Mobile Metas -->
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<!-- Site Metas -->
<title>My Drames</title>
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="author" content="">
<!-- Site Icons -->
<link rel="shortcut icon" href="" type="image/x-icon" />
<link rel="apple-touch-icon" href="">
<!-- Bootstrap CSS -->

@vite(['assets/css/bootstrap.min.css'])
@vite(['style.css'])
@vite(['assets/css/colors.css'])
@vite(['assets/css/versions.css"'])
@vite(['assets/css/responsive.css'])
@vite(['assets/css/custom.css'])
@vite(['assets/css/bootstrap.min.css'])
@vite(['assets/css/3dslider.css'])
@vite(['assets/css/animate.css'])
@vite(['assets/js/3dslider.js'])

<!-- font family -->
<link
    href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
<!-- end font family -->

<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<script src="js/3dslider.js"></script>
<style>
    .active-time-frame {
        background-color: #ff0000;
        /* Thay đổi màu nền tùy theo nhu cầu */
        color: #ffffff;
        /* Thay đổi màu chữ nếu cần thiết */
    }
</style>
</head>

<body class="game_info" data-spy="scroll" data-target=".header">
    <!-- LOADER -->
    <div id="preloader">
        <img class="preloader" src="" alt="">
    </div>
    <!-- END LOADER -->
    <section id="top">
        <header>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="container">
                <div class="header-top">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="full">
                                <div class="logo">
                                    <a href="{{ route('welcome') }}"><img src="{{ asset('img/logo.png') }}"
                                            alt="#" /></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="right_top_section">
                                <!-- social icon -->
                                @if (session()->has('id'))
                                    <ul class="login">
                                        <li>
                                            <div class="cart-option">
                                                <a href="{{ route('customer_logout') }}">🥺</i>
                                                    @if (session()->has('name'))
                                                        {{ session('name') }}
                                                    @endif - Đăng xuất
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                @else
                                    <!-- end social icon -->
                                    <!-- button section -->
                                    <ul class="login">
                                        <li class="login-modal">
                                            <a href=" {{ route('pagelogin') }}" class="login"></i>🧓🏻 Đăng Nhập</a>
                                        </li>
                                        <li>
                                            <div class="cart-option">
                                                <a href="{{ route('pageregister') }}"></i>👦🏻 Đăng Kí</a>
                                            </div>
                                        </li>
                                    </ul>
                                @endif
                                <!-- end button section -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="full-slider">
            <div id="carousel-example-generic" class="carousel slide">
                <!-- Indicators -->

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <!-- First slide -->
                    <div class="item active deepskyblue" data-ride="carousel" data-interval="5000">
                        <div class="carousel-caption">
                            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                <div class="slider-contant" data-animation="animated fadeInRight">
                                    <h3>If you Don’t Practice<br>You <span class="color-yellow">Don’t
                                            Derserve</span><br>to win!</h3>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.item -->
                </div>
                <!-- /.carousel-inner -->
            </div>
            <!-- /.carousel -->
        </div>
    </section>
    <div class="matchs-info">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="full">
                    <div class="right-match-time">
                        <h2>THỜI GIAN MỞ CỬA TUẦN NÀY </h2>
                        <ul id="countdown-1" class="countdown">
                            <li> Từ Thứ 3 đến Chủ Nhật</li>
                        </ul>
                        <span>8:30 - 22:30 (theo thời gian mở cửa ở trên)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <main class="">
        @yield('content')
    </main>
    <footer id="footer" class="footer">
        <div class="footer-bottom">
            <div class="container">
                <p>Copyright by Developer <a href="https://themewagon.com/" target="_blank">Vu Tan Tai
                        @@</a></p>
            </div>
        </div>
    </footer>

</body>

</html>
