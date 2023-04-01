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
        <h3>Vui lòng nhập đầy đủ thông tin</h3>
        <div class="col-sm-6">
            <form method="post" action="{{ route('thanhtoan.postThanhToan') }}">
                @csrf
                <div class="form-group">
                    <label>Email</label>
                    <input
                        type="email"
                        class="form-control"
                        name="email"
                        value="{{Auth::user()->email}}"
                        disabled
                    />
                </div>
                <div class="form-group">
                    <label>Họ tên</label>
                    <input
                        type="text"
                        class="form-control"
                        name="ho_ten"
                        value="{{ Auth::user()->ho_ten }}"
                        required
                    />
                </div>
                <div class="form-group">
                    <label>Số điện thoại</label>
                    <input
                        type="text"
                        class="form-control"
                        name="sdt"
                        maxlength="10"
                        value="{{ Auth::user()->sdt }}"
                        required
                    />
                </div>
                <div class="form-group">
                    <label>Địa chỉ giao hàng</label>
                    <textarea class="form-control" name="dia_chi" required>
                    {{ Auth::user()->dia_chi }}
                </textarea
                    >
                </div>
                <div class="form-group">
                    <label>Ghi chú</label>
                    <textarea class="form-control" name="ghi_chu"></textarea>
                </div>
                <div class="form-group">
                    <input
                        type="submit"
                        value="Hoàn tất đơn hàng"
                        class="btn btn-primary"
                    />
                </div>
            </form>
        </div>
        <div class="col-sm-6">
            <h4><b> Các sản phẩm đã chọn</b></h4>
            <table class="table table-bordered" style="vertical-align: middle">
                <tr class="info">
                    <th>Sản phẩm</th>
                    <th>Giá bán</th>
                    <th>Số lượng</th>
                    <th>Tổng tiền</th>
                </tr>
                @foreach(Cart::content() as $nd)

                <tr>
                    <td>
                        {{$nd->name}}
                    </td>

                    <td>
                        {{number_format($nd->price,0,',','.')}}
                        đ
                    </td>

                    <td>
                        {{$nd->qty}}
                    </td>
                    <td>
                        {{number_format(($nd->price*$nd->qty),0,',','.')
                        }}
                        đ
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3" align="right"><b>Thành tiền</b></td>
                    <td style="font-size: 1.5rem">
                        <strong>{{Cart::total(0,',','.') }} đ</strong>
                    </td>
                </tr>
            </table>
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
    src="{{ asset('frontend/assets_theme/plugins/jquery-ui.js') }}"
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

@endsection
