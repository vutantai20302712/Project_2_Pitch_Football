@extends('layouts.layoutclient')
@section('content')
    <section id="contant" class="contant main-heading"
        style="padding-bottom:0;margin-bottom:-1px;position:relative;z-index:1;">
        <div class="aboutus"
            style="border:1px solid black; margin-left: 30px; margin-right:20px;border-radius:20px; margin-bottom:40px">
            <div class="container">
                <div class="col-md-12 col-sm-12">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="full">
                            <h3 style="color:red"><strong>{{ $pitches->name }}</strong></h3>
                            <ul class="icon-list row">
                                <li>- Danh mục: <strong>{{ $pitches->yard_category_name }} </strong></li>
                                <li>- Địa chỉ sân: <strong>{{ $pitches->address }}</strong></li>
                                <li class="btn btn-primary" style="margin-bottom:20px;">
                                    {{ number_format($pitches->price, 0, ',', '.') }} ₫ / lần thuê</li>
                                <li> <img class="img-responsive" src="{{ asset('img/' . $pitches->image) }}"
                                        alt="#" /></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="margin-bottom:30px;">
                    <div class="row">
                        <p style="text-align: center;"><strong
                                style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif ">- Mô Tả Sân
                                -</strong></p>
                        <p
                            style="text-align: center; font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif ">
                            {{ $pitches->description }}</p>
                        <form id="pitch-form" action="{{ route('pitch.select') }}" method="post">
                            @csrf
                            <input type="hidden" name="pitch_id" value="{{ $pitches->id }}">
                            <input type="hidden" name="pitch_name" value="{{ $pitches->name }}">
                            <input type="hidden" name="pitch_price" value="{{ $pitches->price }}">
                            <input type="hidden" name="pitch_image" value="{{ $pitches->image }}">
                            @if (session()->has('id'))
                                <button type="submit" class="btn-danger"
                                    style="padding:20px; border-radius:10px; border-color:white"> Chọn Đặt Sân Này</button>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="heading-main">
                    <h2 style="margin-bottom:10px;">Các Khung Giờ Có Thể Đặt Sân</h2>
                </div>
                <div class="col-md-12 d-flex justify-content-center" style="margin-bottom:40px;">
                    <div class="d-flex flex-wrap justify-content-center">
                        <form id="time-frame-form" action="{{ route('choosetime.add') }}" method="post">
                            @csrf
                            @foreach ($time_frames as $timeFrame)
                                <button type="button" class="btn btn-primary time-frame-btn"
                                    onclick="selectTimeFrame('{{ $timeFrame->id }}')"
                                    style="margin:10px; padding:20px; font-size:15px; background-color:{{ in_array($timeFrame->id, $bookedTimeFrames) ? 'grey' : 'rgb(18, 141, 242)' }}; font-weight:bold; border:none; border-radius:20px"
                                    {{ in_array($timeFrame->id, $bookedTimeFrames) ? 'disabled' : '' }}>
                                    {{ $timeFrame->start_time }} - {{ $timeFrame->end_time }}
                                </button>
                            @endforeach
                            <input type="hidden" name="selected_time_frame" id="selected_time_frame">
                        </form>
                    </div>
                </div>
              
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
                            @if(!empty($choosepitch))
                                <tr class="text-center">
                                    <td>{{ $choosepitch['pitch_name'] ?? '' }}</td>
                                    <td style="max-width: 70px;"><img src="{{ asset('img/' . ($choosepitch['pitch_image'] ?? '')) }}"
                                            alt="#" class="img-responsive" /></td>
                                    <td>{{ isset($choosepitch['pitch_price']) ? number_format($choosepitch['pitch_price'], 0, ',', '.') . ' ₫' : '' }}</td>
                                    <td>
                                        @if(!empty($choosetime))
                                            @foreach ($choosetime as $carttimeframe)
                                                <div class="time-frames"
                                                    style="background-color: rgb(22, 82, 201); color:white;padding:10px;border-radius:5px;font-weight:bold">
                                                    {{ $carttimeframe['start_time'] ?? '' }} - {{ $carttimeframe['end_time'] ?? '' }}
                                                </div>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="d-flex justify-content-center">
                                        <form action="{{ route('pitch.delete') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-danger"
                                                style="padding:20px; border-radius:10px; border-color:white">Hủy đơn tạo
                                                hiện tại</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        <a href="{{ route('schedulingform.process') }}"
                            style="font-size:40px;text-decoration:none">➡️</i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function selectTimeFrame(timeFrameId) {
            @if (session()->has('id'))
                $('#selected_time_frame').val(timeFrameId);
                $('#time-frame-form').submit();
            @else
                alert('Bạn phải đăng nhập để chọn khung giờ.');
            @endif
        }

        // Hide the session table initially
        $(document).ready(function() {
            @if (!session('selected_pitch'))
                $('#session-table').hide();
            @endif
        });

        // Show the session table after selecting a pitch
        $('#pitch-form').on('submit', function() {
            $('#session-table').show();
        });
    </script>
@endsection
