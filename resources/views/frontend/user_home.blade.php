@extends('layouts.user') @section('title')
<title>Cửa Hàng Camera Quan Sát, Camera An Ninh, Camera Giám Sát</title>
@endsection @section('slider') @include('view-page.user.slider') @endsection
@section('content')
<!-- Sản phẩm mới về -->
<div class="row margin-bottom-40">
    <div class="col-md-12 sale-product">
        <h2><b>Sản phẩm mới về</b></h2>
        @foreach($sp_moi as $sp_m)
        <div class="col-md-3" style="margin-top: 6px">
            <div class="product-item">
                <div class="pi-img-wrapper">
                    <img
                        src="{{$sp_m->hinh_anh_chinh}}"
                        class="img-responsive"
                    />
                    <div>
                        <a
                            href="{{$sp_m->hinh_anh_chinh}}"
                            class="btn btn-default fancybox-button"
                        >
                            Phóng to
                        </a>
                        <a
                            href="{{route('sanpham.chitiet_sp',[$sp_m->id])}}"
                            class="btn btn-default fancybox-fast-view"
                        >
                            Chi tiết
                        </a>
                    </div>
                </div>
                <h3>
                    <a
                        href="{{route('sanpham.chitiet_sp',[$sp_m->id])}}"
                        style="text-decoration: none"
                    >
                        <b> {{$sp_m->ten_sp}} </b>
                    </a>
                </h3>
                <div class="pi-price">
                    {{number_format(($sp_m->gia_ban-($sp_m->gia_ban*$sp_m->giam_gia/100)),0,',','.')



                    }}đ
                </div>
                <div class="price pull-right">
                    <del>
                        <i
                            style="
                                margin-left: 1em;
                                height: 25px;
                                line-height: 2;
                                vertical-align: middle;
                            "
                        >
                            {{number_format($sp_m->gia_ban,0,',','.')}}đ
                        </i>
                    </del>
                </div>
                @if($sp_m->giam_gia !=0)
                <div class="giamgia">
                    <span class="chu">GIẢM</span>
                    <span class="phantram">{{$sp_m->giam_gia}}%</span>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Banner quãng cáo -->
<div class="row margin-bottom-40">
    <div class="col-md-12 sale-product">
        <div class="banner_qc">
            <img src=" {{ asset('frontend/img/sliders/slider1.jpg') }}" />
        </div>
    </div>
</div>

<!-- Sản phẩm nổi bật -->
<div class="row margin-bottom-40">
    <div class="col-md-12 sale-product">
        <h2><b>Sản phẩm nổi bật</b></h2>
        @foreach($sp_noi_bat as $sp_nb)
        <div class="col-md-3" style="margin-top: 6px">
            <div class="product-item">
                <div class="pi-img-wrapper">
                    <img
                        src="{{$sp_nb->hinh_anh_chinh}}"
                        class="img-responsive"
                    />
                    <div>
                        <a
                            href="{{$sp_nb->hinh_anh_chinh}}"
                            class="btn btn-default fancybox-button"
                        >
                            Phóng to
                        </a>
                        <a
                            href="{{route('sanpham.chitiet_sp',[$sp_nb->id])}}"
                            class="btn btn-default fancybox-fast-view"
                        >
                            Chi tiết
                        </a>
                    </div>
                </div>
                <h3>
                    <a href="{{route('sanpham.chitiet_sp',[$sp_nb->id])}}">
                        <b> {{$sp_nb->ten_sp}} </b>
                    </a>
                </h3>
                <div class="pi-price">
                    {{number_format(($sp_nb->gia_ban-($sp_nb->gia_ban*$sp_nb->giam_gia/100)),0,',','.')

                    }}
                    đ
                </div>
                <div class="price">
                    <del>
                        <i
                            style="
                                margin-left: 1em;
                                height: 25px;
                                line-height: 2;
                                vertical-align: middle;
                            "
                        >
                            {{number_format($sp_nb->gia_ban,0,',','.')}}đ
                        </i>
                    </del>
                </div>
                @if($sp_nb->giam_gia !=0)
                <div class="giamgia">
                    <span class="chu">GIẢM</span>
                    <span class="phantram">{{$sp_nb->giam_gia}}%</span>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
