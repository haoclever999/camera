@extends('layouts.user') @section('title')
<title>Cửa Hàng Bán Camera Quan Sát, Camera An Ninh, Camera Giám Sát</title>
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
                            href="{{route('sanpham.chitiet',[$sp_m->id])}}"
                            class="btn btn-default fancybox-fast-view"
                        >
                            Chi tiết
                        </a>
                    </div>
                </div>
                <h3>
                    <a href="{{route('sanpham.chitiet',[$sp_m->id])}}">
                        <b> {{$sp_m->ten_sp}} </b>
                    </a>
                </h3>
                <div class="pi-price">
                    {{number_format(($sp_m->gia_ban-($sp_m->gia_ban*$sp_m->giam_gia/100)),0,',','.')

                    }}
                </div>
                @if($sp_m->ton>0)
                <form
                    action="{{ route('giohang.them_giohang') }}"
                    method="post"
                >
                    @csrf
                    <input type="hidden" name="id_sp" value="{{$sp_m->id}}" />
                    <input
                        type="hidden"
                        name="gia"
                        value="{{number_format(($sp_m->gia_ban-($sp_m->gia_ban*$sp_m->giam_gia/100)),0,',','.')}}"
                    />
                    <div class="product-quantity">
                        <input name="num_so_luong" type="hidden" value="1" />
                    </div>
                    <button
                        class="btn add2cart"
                        type="submit"
                        style="background-color: rgba(204, 204, 204, 0.5)"
                    >
                        Thêm vào giỏ
                    </button>
                </form>
                @endif @if($sp_m->giam_gia !=0)
                <div class="sticker sticker-sale"></div>
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
                            href="{{route('sanpham.chitiet',[$sp_nb->id])}}"
                            class="btn btn-default fancybox-fast-view"
                        >
                            Chi tiết
                        </a>
                    </div>
                </div>
                <h3>
                    <a href="{{route('sanpham.chitiet',[$sp_nb->id])}}">
                        <b> {{$sp_nb->ten_sp}} </b>
                    </a>
                </h3>
                <div class="pi-price">
                    {{number_format(($sp_nb->gia_ban-($sp_nb->gia_ban*$sp_nb->giam_gia/100)),0,',','.')

                    }}
                    đ
                </div>
                @if($sp_nb->ton>0)
                <form
                    action="{{ route('giohang.them_giohang') }}"
                    method="post"
                >
                    @csrf
                    <input type="hidden" name="id_sp" value="{{$sp_nb->id}}" />
                    <input
                        type="hidden"
                        name="gia"
                        value="{{number_format(($sp_nb->gia_ban-($sp_nb->gia_ban*$sp_nb->giam_gia/100)),0,',','.')}}"
                    />
                    <div class="product-quantity">
                        <input name="num_so_luong" type="hidden" value="1" />
                    </div>
                    <button
                        class="btn add2cart"
                        type="submit"
                        style="background-color: rgba(204, 204, 204, 0.5)"
                    >
                        Thêm vào giỏ
                    </button>
                </form>
                @endif @if($sp_nb->giam_gia !=0)
                <div class="sticker sticker-sale"></div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
