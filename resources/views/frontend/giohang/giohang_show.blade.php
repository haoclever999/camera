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
        <h1>Giỏ hàng của bạn</h1>
        <div class="goods-page">
            <div class="goods-data clearfix">
                <div class="table-wrapper-responsive">
                    <table summary="Shopping cart">
                        <tr style="background-color: rgba(204, 204, 204, 0.8)">
                            <th class="goods-page-name">Sản phẩm</th>
                            <th class="goods-page-image">Hình ảnh</th>
                            <th class="goods-page-description">Description</th>
                            <th class="goods-page-quantity">Số lượng</th>
                            <th class="goods-page-price">Giá bán</th>
                            <th class="goods-page-total" colspan="2">Tổng</th>
                        </tr>
                        @foreach()
                        <tr>
                            <td class="goods-page-name">
                                <a href="javascript:;"
                                    ><img
                                        src="assets/pages/img/products/model3.jpg"
                                        alt="Berry Lace Dress"
                                /></a>
                            </td>
                            <td class="goods-page-image">
                                <a href="javascript:;"
                                    ><img
                                        src="assets/pages/img/products/model3.jpg"
                                        alt="Berry Lace Dress"
                                /></a>
                            </td>
                            <td class="goods-page-description">
                                <h3>
                                    <a href="javascript:;"
                                        >Cool green dress with red bell</a
                                    >
                                </h3>
                                <p>
                                    <strong>Item 1</strong> - Color: Green;
                                    Size: S
                                </p>
                                <em>More info is here</em>
                            </td>
                            <td class="goods-page-quantity">
                                <div class="product-quantity">
                                    <input
                                        id="product-quantity"
                                        type="text"
                                        value="1"
                                        readonly
                                        class="form-control input-sm"
                                    />
                                </div>
                            </td>
                            <td class="goods-page-price">
                                <strong><span>$</span>47.00</strong>
                            </td>
                            <td class="goods-page-total">
                                <strong><span>$</span>47.00</strong>
                            </td>
                            <td class="del-goods-col">
                                <a class="del-goods" href="javascript:;"
                                    >&nbsp;</a
                                >
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="shopping-total">
                    <ul>
                        <li>
                            <em>Sub total</em>
                            <strong class="price"><span>$</span>47.00</strong>
                        </li>
                        <li>
                            <em>Shipping cost</em>
                            <strong class="price"><span>$</span>3.00</strong>
                        </li>
                        <li class="shopping-total-price">
                            <em>Total</em>
                            <strong class="price"><span>$</span>50.00</strong>
                        </li>
                    </ul>
                </div>
            </div>
            <button class="btn btn-default" type="submit">
                Continue shopping <i class="fa fa-shopping-cart"></i>
            </button>
            <button class="btn btn-primary" type="submit">
                Checkout <i class="fa fa-check"></i>
            </button>
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
<script src="{{
        asset('frontend/assets_theme/plugins/carousel/carousel.js')
    }}"></script>

@endsection
