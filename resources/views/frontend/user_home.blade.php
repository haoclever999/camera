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
                @if($sp_m->giam_gia !=0)
                <div style="display: inline">
                    <div class="pi-price">
                        {{number_format(($sp_m->gia_ban-($sp_m->gia_ban*$sp_m->giam_gia/100)),0,',','.')























                        }}đ
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
                                {{number_format($sp_m->gia_ban,0,',','.')
























                                }}đ
                            </i>
                        </del>
                    </div>
                </div>
                @else
                <div style="display: inline-block">
                    <div class="pi-price">
                        {{number_format(($sp_m->gia_ban-($sp_m->gia_ban*$sp_m->giam_gia/100)),0,',','.')























                        }}đ
                    </div>
                </div>
                @endif
                <div>
                    <p
                        class="btn btn-so-sanh"
                        onclick="ThemSoSanh('{{$sp_m->id}}')"
                    >
                        So sánh
                    </p>
                    <form>
                        @csrf
                        <input type="hidden" id="id_sp" value="{{$sp_m->id}}" />
                        <input
                            type="hidden"
                            id="tensp_{{$sp_m->id}}"
                            value="{{$sp_m->ten_sp}}"
                        />
                        <input
                            type="hidden"
                            id="hinhanh_{{$sp_m->id}}"
                            value="{{$sp_m->hinh_anh_chinh}}"
                        />
                        <input
                            type="hidden"
                            id="giaban_{{$sp_m->id}}"
                            value="{{number_format(($sp_m->gia_ban-($sp_m->gia_ban*$sp_m->giam_gia/100)),0,',','.')}}"
                        />
                        <input
                            type="hidden"
                            id="tinhnang_{{$sp_m->id}}"
                            value="{{$sp_m->tinh_nang}}"
                        />
                        <a
                            id="url_{{$sp_m->id}}"
                            href="{{route('sanpham.chitiet_sp', [$sp_m->id])}}"
                        ></a>
                    </form>
                    <form
                        action="{{ route('giohang.them_giohang') }}"
                        class="them_giohang"
                        method="post"
                    >
                        @csrf
                        <input
                            type="hidden"
                            name="id_sp"
                            value="{{$sp_m->id}}"
                        />
                        <input type="hidden" name="num_so_luong" value="1" />
                        <button class="btn btn-them-gio-hang" type="submit">
                            Thêm vào giỏ
                        </button>
                    </form>
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
                @if($sp_nb->giam_gia !=0)
                <div style="display: inline">
                    <div class="pi-price">
                        {{number_format(($sp_nb->gia_ban-($sp_nb->gia_ban*$sp_nb->giam_gia/100)),0,',','.')















                        }}đ
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
                </div>
                @else
                <div style="display: inline-block">
                    <div class="pi-price">
                        {{number_format(($sp_nb->gia_ban-($sp_nb->gia_ban*$sp_nb->giam_gia/100)),0,',','.')














                        }}đ
                    </div>
                </div>
                @endif
                <div>
                    <p
                        class="btn btn-so-sanh"
                        onclick="ThemSoSanh('{{$sp_nb->id}}')"
                    >
                        So sánh
                    </p>
                    <form>
                        @csrf
                        <input
                            type="hidden"
                            id="id_sp"
                            value="{{$sp_nb->id}}"
                        />
                        <input
                            type="hidden"
                            id="tensp_{{$sp_nb->id}}"
                            value="{{$sp_nb->ten_sp}}"
                        />
                        <input
                            type="hidden"
                            id="hinhanh_{{$sp_nb->id}}"
                            value="{{$sp_nb->hinh_anh_chinh}}"
                        />
                        <input
                            type="hidden"
                            id="giaban_{{$sp_nb->id}}"
                            value="{{number_format(($sp_nb->gia_ban-($sp_nb->gia_ban*$sp_nb->giam_gia/100)),0,',','.')}}"
                        />
                        <input
                            type="hidden"
                            id="tinhnang_{{$sp_nb->id}}"
                            value="{{$sp_nb->tinh_nang}}"
                        />
                        <a
                            id="url_{{$sp_nb->id}}"
                            href="{{route('sanpham.chitiet_sp', [$sp_nb->id])}}"
                        ></a>
                    </form>
                    <form
                        action="{{ route('giohang.them_giohang') }}"
                        class="them_giohang"
                        method="post"
                    >
                        @csrf
                        <input
                            type="hidden"
                            name="id_sp"
                            value="{{$sp_nb->id}}"
                        />
                        <input type="hidden" name="num_so_luong" value="1" />
                        <button class="btn btn-them-gio-hang" type="submit">
                            Thêm vào giỏ
                        </button>
                    </form>
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

<div class="row margin-bottom-40">
    <div class="col-md-12 sale-product">
        <h2><b>Các thương hiệu</b></h2>

        <ul id="thuonghieu" style="margin-top: 2em">
            @foreach ($th as $t)
            <li>
                <a
                    href="{{route('thuonghieu.sanpham_all',
                [
                'slug'=>$t->slug,'id'=>$t->id
                ]
                )}}"
                >
                    <img src="{{$t->logo}}" />
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
<!-- Modal so sánh sản phẩm -->
<div class="container">
    <div class="modal fade" id="modal-sosanh" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                    <h4 class="modal-title" id="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <table class="table" id="sosanh">
                        <thead>
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Hình ảnh</th>
                                <th>Tính năng</th>
                                <th>Chi tiết</th>
                                <th>Xoá</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-default"
                        data-dismiss="modal"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection @section('js')
<script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
<script src="{{ asset('frontend/js/sosanhsp.js') }}"></script>
@endsection
