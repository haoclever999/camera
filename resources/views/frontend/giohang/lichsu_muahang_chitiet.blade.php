@extends('layouts.user') @section('title')
<title>Giỏ hàng</title>
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
    <div class="col-md-12 col-sm-12">
        <h1>Lịch sử mua hàng</h1>

        <div class="goods-page">
            @if($lichsu->count()>0)
            <div class="goods-data clearfix">
                <div class="table-wrapper-responsive">
                    <h4>
                        Ngày mua hàng:
                        {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $lichsu->created_at)->format('H:i:s d/m/Y')}}
                    </h4>
                    <h4>Trạng thái: {{$lichsu->trang_thai}}</h4>
                    <br />
                    <table style="font-size: 1.2em">
                        <tr style="background-color: rgba(204, 204, 204, 0.8)">
                            <th style="text-align: center">STT</th>
                            <th style="text-align: center">Sản phẩm</th>
                            <th style="text-align: center">Hình ảnh</th>
                            <th style="text-align: center">Số lượng</th>
                            <th style="text-align: center">Giá bán</th>
                            <th style="text-align: center">Tổng</th>
                        </tr>
                        @php $count = 1; @endphp
                        @foreach($lichsu->DonHangChiTiet as $dhct)
                        <tr>
                            <td style="text-align: center">{{ $count++ }}</td>
                            <td>
                                {{ optional($dhct->SanPham)->ten_sp }}
                            </td>
                            <td style="text-align: center">
                                <img
                                    style="width: 70px"
                                    src="{{ optional($dhct->SanPham)->hinh_anh_chinh}}"
                                />
                            </td>
                            <td style="text-align: center">
                                {{$dhct->so_luong_ban}}
                            </td>
                            <td style="text-align: right">
                                <strong>
                                    {{number_format($dhct->gia,0,",",".")}}đ
                                </strong>
                            </td>
                            <td style="text-align: right">
                                <strong>
                                    {{number_format($dhct->thanh_tien,0,",",".")




                                    }}đ
                                </strong>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <br />
            </div>
            @else
            <div style="min-height: 300px">
                <br />
                <h3 style="padding-left: 50px">Bạn chưa mua sản phẩm nào</h3>
            </div>
            @endif
            <a
                href="{{ route('sanpham.all') }}"
                class="btn btn-default"
                type="button"
            >
                Tiếp tục mua sản phẩm <i class="fa fa-shopping-cart"></i>
            </a>
        </div>
    </div>
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
<script
    src="{{ asset('frontend/assets_theme/plugins/carousel/carousel.js') }}"
    type="text/javascript"
></script>
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
