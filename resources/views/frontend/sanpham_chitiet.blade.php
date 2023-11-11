@extends('layouts.user') @section('title')
    <title>Sản phẩm chi tiết</title>
    @endsection @section('css')
    <link href="{{ asset('frontend/assets_theme/plugins/uniform/css/uniform.default.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('frontend/assets_theme/plugins/smoothness/jquery-ui.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{ asset('frontend/assets_theme/plugins/carousel/carousel.css') }}" />
    <!-- for slider-range -->
    <link href="{{ asset('frontend/assets_theme/plugins/rateit/src/rateit.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .Tag>a:hover {
            color: #26a5f0 !important;
        }
    </style>
    @endsection @section('content')
    <div class="row margin-bottom-40" style="margin-top: 40px">
        @foreach ($sp_chitiet as $spct)
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a style="text-decoration: none" href="{{ route('home.index') }}">
                            Trang chủ
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a style="text-decoration: none"
                            href="{{ route('danhmuc.sanpham', [
                                'slug' => $spct->DanhMuc->slug,
                                'id' => $spct->DanhMuc->id,
                            ]) }}">
                            {{ $spct->DanhMuc->ten_dm }}
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a style="text-decoration: none"
                            href="{{ route('thuonghieu.sanpham_all', [
                                'slug' => $spct->ThuongHieu->slug,
                                'id' => $spct->ThuongHieu->id,
                            ]) }}">
                            {{ $spct->ThuongHieu->ten_thuong_hieu }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $spct->ten_sp }}
                    </li>
                </ol>
            </nav>
            <div class="col-md-12 col-sm-7">
                <div class="product-page">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="product-main-image">
                                <img src="{{ $spct->hinh_anh_chinh }}" class="img-responsive"
                                    data-BigImgsrc="{{ $spct->hinh_anh_chinh }}" />
                            </div>
                            <div class="product-other-images">
                                @foreach ($spct->HinhAnh as $hinh)
                                    <a href="{{ $hinh->hinh_anh }}" class="fancybox-button" rel="photos-lib">
                                        <img src="{{ $hinh->hinh_anh }}" />
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <h1>{{ $spct->ten_sp }}</h1>
                            <div class="price-availability-block clearfix">
                                <div class="price">
                                    <strong>
                                        {{ number_format($spct->gia_ban - ($spct->gia_ban * $spct->giam_gia) / 100, 0, ',', '.') }}đ
                                    </strong>
                                    @if ($spct->giam_gia != 0)
                                        <span style="font-size: 18px">
                                            <del>
                                                <i>
                                                    {{ number_format($spct->gia_ban, 0, ',', '.') }}đ
                                                </i>
                                            </del>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="description" style="margin-bottom: 8px; font-size: 18px">
                                <b> Danh mục:</b>
                                <span> {{ $spct->DanhMuc->ten_dm }} </span>
                            </div>
                            <div class="description" style="margin-bottom: 8px; font-size: 18px">
                                <b> Thương hiệu:</b>
                                <span>
                                    {{ $spct->ThuongHieu->ten_thuong_hieu }}
                                </span>
                            </div>

                            <div class="description" style="margin-bottom: 8px; font-size: 18px">
                                <b> Lượt xem:</b>
                                <span>
                                    {{ $spct->luot_xem }}
                                </span>
                            </div>

                            <div class="description" style="margin-bottom: 8px; font-size: 18px">
                                <b> Đã bán:</b>
                                <span> {{ $spct->luot_mua }} sản phẩm </span>
                            </div>

                            <div class="Tag" style="margin-bottom: 8px; font-size: 18px">
                                <b> Tag:</b>
                                @foreach ($spct->SanPhamTag as $t)
                                    <a class="tagsp" href="{{ route('tagsp', [$t->ten_tag]) }}"
                                        style="
                                text-decoration: none;
                                color: black;
                                background-color: rgb(100 179 255 / 30%);
                                margin-right: 5px;
                                border-radius: 6px !important;
                            ">
                                        {{ $t->ten_tag }}
                                    </a>
                                @endforeach
                            </div>

                            <div class="product-page-cart" style="margin-top: 30px">
                                <form action="{{ route('giohang.them_giohang') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id_sp" value="{{ $spct->id }}" />

                                    <div class="product-quantity">
                                        <input id="product-quantity" name="num_so_luong" type="number" min="1"
                                            value="1" onchange="SoLuongMin(this)" readonly
                                            class="form-control input-sm" />
                                    </div>
                                    <button class="btn btn-primary" type="submit">
                                        Thêm vào giỏ
                                    </button>
                                </form>
                            </div>

                            <!-- Share facebook  -->
                            <div id="fb-root"></div>

                            <div class="fb-share-button" data-href="{{ $url_canonical }}" data-layout="button"
                                data-size="large" data-lazy="true">
                                <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ $url_canonical }}"
                                    class="fb-xfbml-parse-ignore">
                                    Chia sẻ
                                </a>
                            </div>
                        </div>
                        <!-- Mô tả, tính năng sp -->
                        <div class="product-page-content" style="font-size: 18px">
                            <ul id="myTab" class="nav nav-tabs">
                                <li class="active">
                                    <a href="#Mo_ta" data-toggle="tab">
                                        <span>Mô tả</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#Tinh_nang" data-toggle="tab">
                                        <span>Tính năng</span>
                                    </a>
                                </li>
                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <div class="tab-pane fade in active" id="Mo_ta">
                                    <p>{!! $spct->mo_ta !!}</p>
                                </div>
                                <div class="tab-pane fade" id="Tinh_nang">
                                    {!! $spct->tinh_nang !!}
                                </div>
                            </div>
                            <!-- Sản phẩm liên quan -->
                        </div>
                    </div>
                </div>
        @endforeach
    </div>
    @if ($sp_lienquan)
        <div class="row margin-bottom-40">
            <div class="sale-product">
                <h2><b>Sản phẩm liên quan</b></h2>
                <div class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($sp_lienquan as $key => $lienquan)
                            <div class="item {{ $key == 0 ? 'active' : '' }} ">
                                <div class="col-md-3">
                                    <div class="product-item">
                                        <div class="pi-img-wrapper">
                                            <img src="{{ $lienquan->hinh_anh_chinh }}" class="img-responsive" />
                                            <div>
                                                <a href="{{ $lienquan->hinh_anh_chinh }}"
                                                    class="btn btn-default fancybox-button">
                                                    Phóng to
                                                </a>
                                                <a href="{{ route('sanpham.chitiet_sp', [$lienquan->id]) }}"
                                                    class="btn btn-default fancybox-fast-view">
                                                    Chi tiết
                                                </a>
                                            </div>
                                        </div>
                                        <h3>
                                            <a href="{{ route('sanpham.chitiet_sp', [$lienquan->id]) }}">
                                                <b>
                                                    {{ $lienquan->ten_sp }}
                                                </b>
                                            </a>
                                        </h3>
                                        @if ($lienquan->giam_gia != 0)
                                            <div style="display: inline">
                                                <div class="pi-price">
                                                    {{ number_format($lienquan->gia_ban - ($lienquan->gia_ban * $lienquan->giam_gia) / 100, 0, ',', '.') }}đ
                                                </div>
                                                <div class="price">
                                                    <del>
                                                        <i
                                                            style="
                                                    margin-left: 1em;
                                                    height: 25px;
                                                    line-height: 2;
                                                    vertical-align: middle;
                                                ">
                                                            {{ number_format($lienquan->gia_ban, 0, ',', '.') }}đ
                                                        </i>
                                                    </del>
                                                </div>
                                            </div>
                                        @else
                                            <div style="display: inline-block">
                                                <div class="pi-price">
                                                    {{ number_format($lienquan->gia_ban - ($lienquan->gia_ban * $lienquan->giam_gia) / 100, 0, ',', '.') }}đ
                                                </div>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="btn btn-so-sanh" onclick="ThemSoSanh('{{ $lienquan->id }}')">
                                                So sánh
                                            </p>
                                            <form>
                                                @csrf
                                                <input type="hidden" id="id_sp" value="{{ $lienquan->id }}" />
                                                <input type="hidden" id="tensp_{{ $lienquan->id }}"
                                                    value="{{ $lienquan->ten_sp }}" />
                                                <input type="hidden" id="hinhanh_{{ $lienquan->id }}"
                                                    value="{{ $lienquan->hinh_anh_chinh }}" />
                                                <input type="hidden" id="giaban_{{ $lienquan->id }}"
                                                    value="{{ number_format($lienquan->gia_ban - ($lienquan->gia_ban * $lienquan->giam_gia) / 100, 0, ',', '.') }}" />
                                                <input type="hidden" id="tinhnang_{{ $lienquan->id }}"
                                                    value="{{ $lienquan->tinh_nang }}" />
                                                <a id="url_{{ $lienquan->id }}"
                                                    href="{{ route('sanpham.chitiet_sp', [$lienquan->id]) }}"></a>
                                            </form>
                                            <form action="{{ route('giohang.them_giohang') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id_sp" value="{{ $lienquan->id }}" />
                                                <input type="hidden" name="num_so_luong" value="1" />
                                                <button class="btn btn-them-gio-hang" type="submit">
                                                    Thêm vào giỏ
                                                </button>
                                            </form>
                                        </div>
                                        @if ($lienquan->giam_gia != 0)
                                            <div class="giamgia">
                                                <span class="chu" style="top: -2px">
                                                    GIẢM
                                                </span>
                                                <span class="phantram" style="top: -11px">
                                                    {{ $lienquan->giam_gia }}%
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Bắt đầu bình luận-->
    <div class="col-md-12">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="fb-comments" data-href="{{ $url_canonical }}" data-width="100%" data-numposts="10"
                data-order-by="reverse-time"></div>
        </div>
        <div class="col-md-1"></div>
    </div>
    <!--kết thúc bình luận-->
    </div>

    @endsection @section('js')
    <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
    <script>
        function SoLuongMin(el) {
            if (el.value != "") {
                if (parseInt(el.value) < parseInt(el.min)) {
                    el.value = el.min;
                }
            }
        }
        let items = document.querySelectorAll(".carousel .item");

        items.forEach((el) => {
            const minPerSlide = 4;
            let next = el.nextElementSibling;
            for (var i = 1; i < minPerSlide; i++) {
                if (!next) {
                    next = items[0];
                }
                let cloneChild = next.cloneNode(true);
                el.appendChild(cloneChild.children[0]);
                next = next.nextElementSibling;
            }
        });
    </script>
    <script src="{{ asset('frontend/js/sosanhsp.js') }}"></script>
    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v16.0&appId=553658326637566&autoLogAppEvents=1"
        nonce="QXUjLlwS"></script>
@endsection
