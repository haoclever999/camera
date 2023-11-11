@extends('layouts.user') @section('title')
    <title>Sản phẩm</title>
    @endsection @section('content')

    <div class="row margin-bottom-40" style="margin-top: 40px">
        @include('view-page.user.sidebar_menu')
        <div class="col-md-9 col-sm-7">
            <div class="row list-view-sorting clearfix">
                <div class="col-md-7 col-sm-7">
                    <h3>Sản phẩm cho tag {{ $tags->ten_tag }}</h3>
                </div>
            </div>
            <!-- BEGIN PRODUCT LIST -->
            <div class="row product-list" style="min-height: 300px">
                <!-- PRODUCT ITEM START -->

                @if ($tags->count() > 0)
                    @foreach ($tags->SanPhamTag as $s)
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="product-item">
                                <div class="pi-img-wrapper">
                                    <img src="{{ $s->hinh_anh_chinh }}" class="img-responsive" />
                                    <div>
                                        <a href="{{ $s->hinh_anh_chinh }}" class="btn btn-default fancybox-button">
                                            Phóng to
                                        </a>
                                        <a href="{{ route('sanpham.chitiet_sp', [$s->id]) }}"
                                            class="btn btn-default fancybox-fast-view">
                                            Chi tiết
                                        </a>
                                    </div>
                                </div>
                                <h3>
                                    <a href="{{ route('sanpham.chitiet_sp', [$s->id]) }}">
                                        <b> {{ $s->ten_sp }} </b>
                                    </a>
                                </h3>
                                @if ($s->giam_gia != 0)
                                    <div style="display: inline">
                                        <div class="pi-price">
                                            {{ number_format($s->gia_ban - ($s->gia_ban * $s->giam_gia) / 100, 0, ',', '.') }}đ
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
                                                    {{ number_format($s->gia_ban, 0, ',', '.') }}đ
                                                </i>
                                            </del>
                                        </div>
                                    </div>
                                @else
                                    <div style="display: inline-block">
                                        <div class="pi-price">
                                            {{ number_format($s->gia_ban - ($s->gia_ban * $s->giam_gia) / 100, 0, ',', '.') }}đ
                                        </div>
                                    </div>
                                @endif
                                <div>
                                    <p class="btn btn-so-sanh" onclick="ThemSoSanh('{{ $s->id }}')">
                                        So sánh
                                    </p>
                                    <form>
                                        @csrf
                                        <input type="hidden" id="id_sp" value="{{ $s->id }}" />
                                        <input type="hidden" id="tensp_{{ $s->id }}"
                                            value="{{ $s->ten_sp }}" />
                                        <input type="hidden" id="hinhanh_{{ $s->id }}"
                                            value="{{ $s->hinh_anh_chinh }}" />
                                        <input type="hidden" id="giaban_{{ $s->id }}"
                                            value="{{ number_format($s->gia_ban - ($s->gia_ban * $s->giam_gia) / 100, 0, ',', '.') }}" />
                                        <input type="hidden" id="tinhnang_{{ $s->id }}"
                                            value="{{ $s->tinh_nang }}" />
                                        <a id="url_{{ $s->id }}"
                                            href="{{ route('sanpham.chitiet_sp', [$s->id]) }}"></a>
                                    </form>
                                    <form action="{{ route('giohang.them_giohang') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="id_sp" value="{{ $s->id }}" />
                                        <input type="hidden" name="num_so_luong" value="1" />
                                        <button class="btn btn-them-gio-hang" type="submit">
                                            Thêm vào giỏ
                                        </button>
                                    </form>
                                </div>
                                @if ($s->giam_gia != 0)
                                    <div class="giamgia">
                                        <span class="chu">GIẢM</span>
                                        <span class="phantram">{{ $s->giam_gia }}%</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    <!-- PRODUCT ITEM END -->
                @else
                    <div>
                        <h3>Không có sản phẩm</h3>
                    </div>
                @endif
            </div>

            <!-- END PRODUCT LIST -->
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
                        <button type="button" class="btn btn-default" data-dismiss="modal">
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
