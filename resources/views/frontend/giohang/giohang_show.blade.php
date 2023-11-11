@extends('layouts.user') @section('title')
    <title>Giỏ hàng</title>
    @endsection @section('css')
    <link href="{{ asset('frontend/assets_theme/plugins/uniform/css/uniform.default.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('frontend/assets_theme/plugins/smoothness/jquery-ui.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{ asset('frontend/assets_theme/plugins/carousel/carousel.css') }}" />
    <!-- for slider-range -->
    <link href="{{ asset('frontend/assets_theme/plugins/rateit/src/rateit.css') }}" rel="stylesheet" type="text/css" />
    @endsection @section('content')
    <div class="row margin-bottom-40" style="margin-top: 40px">
        <div class="col-md-12 col-sm-12">
            <div class="col-md-12 col-sm-12">
                <h1 style="float: left">Giỏ hàng của bạn</h1>
                @if (Auth::check())
                    <a href="{{ route('getLichSuMuaHang') }}" class="btn btn-primary" type="button"
                        style="float: right; width: max-content">
                        Lịch sử mua hàng
                    </a>
                @endif
            </div>
            <div class="goods-page" style="clear: both">
                @if (Session::has('success'))
                    <div style="min-height: 300px">
                        <br />
                        <h3 style="padding-left: 50px">{{ Session::get('success') }}</h3>
                    </div>
                @elseif(Cart::count() > 0)
                    <div class="goods-data clearfix">
                        <div class="table-wrapper-responsive">
                            @if (Session::has('error'))
                                <h3 style="color: red; font-size: 18px; font-weight: bold">
                                    {{ Session::get('error') }}
                                </h3>
                                @endif @if (Session::has('success_sl'))
                                    <h3 style="color: green; font-size: 18px; font-weight: bold">
                                        {{ Session::get('success_sl') }}
                                    </h3>
                                @endif
                                <table summary="Shopping cart">
                                    <tr style="background-color: rgba(204, 204, 204, 0.8)">
                                        <th class="goods-page-name">Sản phẩm</th>
                                        <th class="goods-page-image">Hình ảnh</th>
                                        <th class="goods-page-quantity">Số lượng</th>
                                        <th class="goods-page-price">Giá bán</th>
                                        <th class="goods-page-total" colspan="2">Tổng</th>
                                    </tr>
                                    @foreach (Cart::content() as $nd)
                                        <tr>
                                            <td class="goods-page-name" style="width: 400px">
                                                <a href="{{ route('sanpham.chitiet_sp', [$nd->id]) }}"
                                                    style="font-size: 20px">
                                                    {{ $nd->name }}
                                                </a>
                                            </td>
                                            <td class="goods-page-image" style="text-align: center">
                                                <a href="{{ route('sanpham.chitiet_sp', [$nd->id]) }}">
                                                    <img src="{{ $nd->options->hinh_anh }}" />
                                                </a>
                                            </td>
                                            <td class="goods-page-quantity">
                                                <form action="{{ route('giohang.capnhat_soluong') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="rowId" value="{{ $nd->rowId }}" />
                                                    <div class="product-quantity">
                                                        <input id="product-quantity" name="num_so_luong" type="text"
                                                            value="{{ $nd->qty }}"
                                                            onchange="SoLuongMinMax('{{ $nd->rowId }}')" min="1"
                                                            readonly class="form-control input-sm" />
                                                    </div>
                                                    <button class="btn btn-primary"
                                                        id="capnhat_soluong({{ $nd->rowId }})" type="submit"
                                                        style="
                                            display: none;
                                            float: none;
                                            margin-left: 80px;
                                            margin-right: -50px;
                                            vertical-align: center;
                                            padding-top: 9px;
                                            padding-bottom: 9px;
                                        ">
                                                        Cập nhật
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="goods-page-price">
                                                <strong>
                                                    {{ number_format($nd->price, 0, ',', '.') }}
                                                    đ
                                                </strong>
                                            </td>
                                            <td class="goods-page-total">
                                                <strong>
                                                    {{ number_format($nd->price * $nd->qty, 0, ',', '.') }}
                                                    đ
                                                </strong>
                                            </td>
                                            <td class="del-goods-col">
                                                <a class="del-goods"
                                                    href="{{ route('giohang.xoa_sp', ['rowId' => $nd->rowId]) }}"
                                                    style="background-color: #ff3737">
                                                    &nbsp;
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                                <br />
                                <a href="{{ route('giohang.xoatatca') }}" class="btn btn-default" type="button"
                                    style="background-color: #ff4646">
                                    Xoá tất cả sản phẩm
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                        </div>
                        <br />
                        <div class="shopping-total">
                            <ul>
                                <li>
                                    <em>Tổng tiền</em>
                                    <strong class="price">
                                        {{ Cart::subtotal(0, ',', '.') }}
                                        đ
                                    </strong>
                                </li>
                                <li>
                                    <em>Thuế</em>
                                    <strong class="price">
                                        {{ Cart::tax(0, ',', '.') }} đ</strong>
                                </li>
                                <li class="shopping-total-price">
                                    <em>Thành tiền</em>
                                    <strong class="price">
                                        {{ Cart::total(0, ',', '.') }}
                                        đ
                                    </strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                @else
                    <div style="min-height: 300px">
                        <br />
                        <h3 style="padding-left: 50px">Không có sản phẩm trong giỏ</h3>
                    </div>
                @endif
                <a href="{{ route('sanpham.all') }}" class="btn btn-default" type="button">
                    Tiếp tục mua sản phẩm <i class="fa fa-shopping-cart"></i>
                </a>
                @if (Cart::count() > 0)
                    <a href="{{ route('thanhtoan.getThanhToan') }}" class="btn btn-primary" type="button">
                        Thanh toán <i class="fa fa-check"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>

    @endsection @section('js')
    <script src="{{ asset('frontend/assets_theme/plugins/uniform/jquery.uniform.min.js') }}" type="text/javascript">
    </script>

    <script src="{{ asset('frontend/assets_theme/plugins/rateit/src/jquery.rateit.js') }}" type="text/javascript"></script>
    <script src="{{ asset('frontend/assets_theme/plugins/carousel/carousel.js') }}" type="text/javascript"></script>
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

            document.getElementById("capnhat_soluong(" + el + ")").style.display =
                "block";
        }
    </script>
@endsection
