@extends('layouts.user') @section('title')
<title>Sản phẩm chi tiết</title>
@endsection @section('css')

<link
    href="{{
        asset('frontend/assets_theme/plugins/uniform/css/uniform.default.css')
    }}"
    rel="stylesheet"
    type="text/css"
/>
<link
    href="{{ asset('frontend/assets_theme/plugins/smoothness/jquery-ui.css') }}"
    rel="stylesheet"
    type="text/css"
/>

<link
    rel="stylesheet"
    href="{{ asset('frontend/assets_theme/plugins/carousel/carousel.css') }}"
/>
<!-- for slider-range -->
<link
    href="{{ asset('frontend/assets_theme/plugins/rateit/src/rateit.css') }}"
    rel="stylesheet"
    type="text/css"
/>
@endsection @section('content')
<div class="row margin-bottom-40" style="margin-top: 40px">
    <div class="col-md-12 col-sm-7">
        <div class="product-page">
            <div class="row">
                @foreach($sp_chitiet as $spct)
                <div class="col-md-6 col-sm-6">
                    <div class="product-main-image">
                        <img
                            src="{{$spct->hinh_anh_chinh}}"
                            class="img-responsive"
                            data-BigImgsrc="{{$spct->hinh_anh_chinh}}"
                        />
                    </div>
                    <div class="product-other-images">
                        @foreach($spct->HinhAnh as $hinh)
                        <a
                            href="{{$hinh->hinh_anh}}"
                            class="fancybox-button"
                            rel="photos-lib"
                        >
                            <img src="{{$hinh->hinh_anh}}" />
                        </a>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <h1>{{$spct->ten_sp}}</h1>
                    <div class="price-availability-block clearfix">
                        <div class="price">
                            <strong>
                                {{number_format(($spct->gia_ban-($spct->gia_ban*$spct->giam_gia/100)),0,',','.')
                                }}
                                đ
                            </strong>
                            @if($spct->giam_gia!=0)
                            <span style="font-size: 18px">
                                <del>
                                    {{number_format(($spct->gia_ban),0,',','.')
                                    }}
                                    đ
                                </del>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div
                        class="description"
                        style="margin-bottom: 8px; font-size: 18px"
                    >
                        <b> Danh mục:</b>
                        <span> {{$spct->DanhMuc->ten_dm}} </span>
                    </div>
                    <div
                        class="description"
                        style="margin-bottom: 8px; font-size: 18px"
                    >
                        <b> Thương hiệu:</b>
                        <span>
                            {{$spct->ThuongHieu->ten_thuong_hieu}}
                        </span>
                    </div>

                    <div
                        class="description"
                        style="margin-bottom: 8px; font-size: 18px"
                    >
                        <b> Lượt xem:</b>
                        <span>
                            {{$spct->luot_xem}}
                        </span>
                    </div>

                    <div
                        class="description"
                        style="margin-bottom: 8px; font-size: 18px"
                    >
                        <b> Đã bán:</b>
                        <span> {{$spct->luot_mua}} sản phẩm </span>
                    </div>

                    <div class="product-page-cart" style="margin-top: 30px">
                        <form
                            action="{{ route('giohang.them_giohang') }}"
                            method="post"
                        >
                            @csrf
                            <input
                                type="hidden"
                                name="id_sp"
                                value="{{$spct->id}}"
                            />
                            <input
                                type="hidden"
                                name="gia"
                                value="{{number_format(($spct->gia_ban-($spct->gia_ban*$spct->giam_gia/100)),0,',','.')}}"
                            />
                            <div class="product-quantity">
                                <input
                                    id="product-quantity"
                                    name="num_so_luong"
                                    type="number"
                                    min="1"
                                    value="1"
                                    onchange="SoLuongMinMax(this)"
                                    readonly
                                    class="form-control input-sm"
                                />
                            </div>
                            <button class="btn btn-primary" type="submit">
                                Thêm vào giỏ
                            </button>
                        </form>
                    </div>

                    <div
                        class="fb-share-button"
                        data-href="{{ $url_canonical }}"
                        data-layout="button"
                        data-size="large"
                    >
                        <a
                            target="_blank"
                            href="https://www.facebook.com/sharer/sharer.php?u={{
                                $url_canonical
                            }}&src=sdkpreparse"
                            class="fb-xfbml-parse-ignore"
                        >
                            Chia sẻ
                        </a>
                    </div>
                </div>
                <!-- Mô tả tính  năng sp -->
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
                            <p>{!!$spct->mo_ta!!}</p>
                        </div>
                        <div class="tab-pane fade" id="Tinh_nang">
                            {!!$spct->tinh_nang!!}
                        </div>
                    </div>
                    <!-- Sản phẩm liên quan -->
                    <div class="row margin-bottom-40">
                        <div class="sale-product">
                            <h2><b>Sản phẩm liên quan</b></h2>
                            <div
                                id="carouselExampleControls"
                                class="carousel slide"
                                data-ride="carousel"
                            >
                                <div class="carousel-inner">
                                    @foreach($sp_lienquan as $key => $lienquan)
                                    <div
                                        class="item {{
                                            $key == 0 ? 'active' : ''
                                        }} "
                                    >
                                        <div
                                            class="col-sm-3"
                                            style="margin-top: 6px"
                                        >
                                            <div class="product-item">
                                                <div class="pi-img-wrapper">
                                                    <img
                                                        src="{{$lienquan->hinh_anh_chinh}}"
                                                        class="img-responsive"
                                                    />
                                                    <div>
                                                        <a
                                                            href="{{$lienquan->hinh_anh_chinh}}"
                                                            class="btn btn-default fancybox-button"
                                                        >
                                                            Phóng to
                                                        </a>
                                                        <a
                                                            href="{{route('sanpham.chitiet_sp',[$lienquan->id])}}"
                                                            class="btn btn-default fancybox-fast-view"
                                                        >
                                                            Chi tiết
                                                        </a>
                                                    </div>
                                                </div>
                                                <h3>
                                                    <a
                                                        href="{{route('sanpham.chitiet_sp',[$lienquan->id])}}"
                                                    >
                                                        <b>
                                                            {{$lienquan->ten_sp}}
                                                        </b>
                                                    </a>
                                                </h3>
                                                <div class="pi-price">
                                                    {{number_format(($lienquan->gia_ban-($lienquan->gia_ban*$lienquan->giam_gia/100)),0,',','.')
                                                    }}
                                                    đ
                                                </div>
                                                <form
                                                    action="{{
                                                        route(
                                                            'giohang.them_giohang'
                                                        )
                                                    }}"
                                                    method="post"
                                                >
                                                    @csrf
                                                    <input
                                                        type="hidden"
                                                        name="id_sp"
                                                        value="{{$lienquan->id}}"
                                                    />
                                                    <input
                                                        type="hidden"
                                                        name="gia"
                                                        value="{{number_format(($lienquan->gia_ban-($lienquan->gia_ban*$lienquan->giam_gia/100)),0,',','.')}}"
                                                    />
                                                    <div
                                                        class="product-quantity"
                                                    >
                                                        <input
                                                            name="num_so_luong"
                                                            type="hidden"
                                                            value="1"
                                                        />
                                                    </div>
                                                    <button
                                                        class="btn add2cart"
                                                        type="submit"
                                                        style="
                                                            background-color: rgba(
                                                                204,
                                                                204,
                                                                204,
                                                                0.5
                                                            );
                                                        "
                                                    >
                                                        Thêm vào giỏ
                                                    </button>
                                                </form>
                                                @if($lienquan->giam_gia !=0)
                                                <div class="giamgia">
                                                    <span
                                                        class="chu"
                                                        style="top: -2px"
                                                    >
                                                        GIẢM
                                                    </span>
                                                    <span
                                                        class="phantram"
                                                        style="top: -11px"
                                                    >
                                                        {{$lienquan->giam_gia}}%
                                                    </span>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bắt đầu bình luận-->
    <div class="col-md-12">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div
                class="fb-comments"
                data-href="{{ $url_canonical }}"
                data-width="100%"
                data-numposts="10"
                data-order-by="reverse-time"
            ></div>
        </div>
        <div class="col-md-1"></div>
    </div>
    <!--kết thúc bình luận-->
</div>

@endsection @section('js')
<script
    src="{{
        asset('frontend/assets_theme/plugins/uniform/jquery.uniform.min.js')
    }}"
    type="text/javascript"
></script>
<script
    src="{{
        asset('frontend/assets_theme/plugins/rateit/src/jquery.rateit.js')
    }}"
    type="text/javascript"
></script>
<script src="{{
        asset('frontend/assets_theme/plugins/carousel/carousel.js')
    }}"></script>
<script>
    function SoLuongMinMax(el) {
        if (el.value != "") {
            if (parseInt(el.value) < parseInt(el.min)) {
                el.value = el.min;
            }
            if (parseInt(el.value) > parseInt(el.max)) {
                el.value = el.max;
            }
        }
    }
</script>

@endsection
