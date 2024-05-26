@extends('layouts.layoutclient')

@section('content')

    <section id="contant" class="contant">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="full">
                            <div class="main-heading sytle-2">
                                <h2>Các Sân Bóng hiện có</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="container">
            @foreach ($pitches as $pitch)
                <?php
                $maxLength = 202; // Số ký tự tối đa bạn muốn hiển thị
                $description = $pitch->description;
                if (strlen($description) > $maxLength) {
                    $description = substr($description, 0, $maxLength) . '...';
                }
                ?>
                <div class="feature-post small-blog">
                    <div class="col-md-5">
                        <div class="feature-img">
                            <img src="{{ asset('img/' . $pitch->image) }}" alt="" width=500 height="550"
                                class="img-responsive">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="feature-cont">
                            <div class="post-info">
                                <span>
                                    <h4 style="font-weight:bold">{{ $pitch->name }}</h4>
                                    <h5 style="color:black">- Danh mục sân: {{ $pitch->yardCategory->name }} </h5>
                                    <h5 style="color:black">- Địa chỉ sân: {{ $pitch->address }}</h5>
                                </span>
                            </div>
                            <div class="post-heading">
                                <h3 class="btn btn-primary" style="padding:10px;">
                                    {{ number_format($pitch->price, 0, ',', '.') }} ₫ / lần thuê
                                </h3>
                                <p style="font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; font-weight:500">
                                    Mô tả: {{ $description }}
                                </p>
                                <div class="full">
                                    <a class="btn" href="{{route('pitch.details', $pitch->id)}}">Xem Chi Tiết</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        </div>
        </div>
    </section>
@endsection
