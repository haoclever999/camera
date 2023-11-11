<style>
    .input-group>.goiy_timkiem>ul>li>a:hover {
        color: #26a5f0 !important;
    }
</style>
<div class="header">
    <div class="container">
        <a class="site-logo" href="{{ route('home.index') }}">
            <img src="{{ asset('frontend/img/logo.png') }}" width="70px" />
        </a>

        <a href="#" class="mobi-toggler">
            <i class="fa fa-bars"></i>
        </a>

        <!-- BEGIN CART -->
        <div class="top-cart-block">
            <div class="top-cart-info">
                <span class="top-cart-info-count">
                    {{ Cart::count() }} sản phẩm
                </span>
                <span class="top-cart-info-value">
                    {{ Cart::subtotal(0, ',', '.') }} đ
                </span>
            </div>
            <i class="fa fa-shopping-cart"></i>

            <div class="top-cart-content-wrapper">
                <div class="top-cart-content">
                    @if (Cart::count() > 0)

                        <ul style="overflow: hidden; width: auto" height="100px !important">
                            @foreach (Cart::content() as $nd)
                                <li>
                                    <a href="route('sanpham.chitiet_sp',[$nd->id])">
                                        <img src="{{ $nd->options->hinh_anh }}" width="43" height="40" />
                                    </a>
                                    <span class="cart-content-count">
                                        x {{ $nd->qty }}
                                    </span>
                                    <strong>
                                        <a href="route('sanpham.chitiet_sp',[$nd->id])">
                                            {{ $nd->name }}
                                        </a>
                                    </strong>
                                    <em>
                                        {{ number_format($nd->price * $nd->qty, 0, ',', '.') }}đ
                                    </em>

                                    <a class="del-goods" href="{{ route('giohang.xoa_sp', ['rowId' => $nd->rowId]) }}"
                                        style="background-color: #ff3737">
                                        &nbsp;
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="text-right">
                            <a href="{{ route('giohang.chitiet_giohang') }}" class="btn btn-default">
                                Xem giỏ hàng
                            </a>

                            <a href="{{ route('thanhtoan.getThanhToan') }}" class="btn btn-primary">
                                Thanh toán
                            </a>
                        </div>
                    @else
                        <h5 style="margin: 10px; padding-left: 30px">
                            Không có sản phẩm
                        </h5>
                    @endif
                </div>
            </div>
        </div>
        <!--END CART -->

        <!-- BEGIN NAVIGATION -->
        <div class="header-navigation" style="text-align: center">
            <ul>
                <li class="{{ Request::segment(1) == '' ? 'active' : '' }}">
                    <a href="{{ route('home.index') }}"> <b> Trang chủ </b> </a>
                </li>
                <li class="dropdown dropdown-megamenu {{ Request::segment(1) == 'danh-muc' ? 'active' : '' }}">
                    <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="javascript:;">
                        <b> Danh mục </b>
                    </a>
                    <ul class="dropdown-menu">
                        @foreach ($dm as $d)
                            <li class="{{ Request::segment(2) == $d->slug ? 'active' : '' }}">
                                <a
                                    href="{{ route('danhmuc.sanpham', [
                                        'slug' => $d->slug,
                                        'id' => $d->id,
                                    ]) }}">
                                    {{ $d->ten_dm }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li
                    class="{{ Request::segment(1) == 'san-pham' || Request::segment(1) == 'thuong-hieu' ? 'active' : '' }}">
                    <a href="{{ route('sanpham.all') }}"> <b> Sản phẩm </b> </a>
                </li>
                <li class="{{ Request::segment(1) == 'lien-he' ? 'active' : '' }}">
                    <a href="{{ route('getLienHe') }}"> <b> Liên hệ </b> </a>
                </li>

                <!-- BEGIN TOP SEARCH -->
                <li>
                    <span class="sep"></span>
                    <ul
                        style="
                            right: -7px;
                            top: 100%;
                            padding: 23px 12px 20px;
                            display: block;
                            background: transparent;
                            position: relative;
                            width: 274px;
                            margin-top: 0;
                            z-index: 22;
                        ">
                        <form action="{{ route('sanpham.timkiemsp') }}" method="get">
                            <div class="input-group">
                                <input type="search" placeholder="Tìm kiếm..." class="form-control timkiem_header"
                                    name="timkiem_header"
                                    style="
                                        border-radius: 0.4em 0 0 0.4em !important;
                                    "
                                    onblur="huyTimKiem(event)" onkeyup="timKiem(event)" />

                                <div style="
                                        display: none;
                                        padding: 8px 15px 10px;
                                        background: rgb(252, 250, 251);
                                        box-shadow: 5px 5px
                                            rgba(91, 91, 91, 0.2);
                                        width: max-content;
                                        margin-top: 34px;
                                        position: absolute;
                                        border-radius: 0.4em !important;
                                        text-transform: none;
                                    "
                                    class="goiy_timkiem"></div>

                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary btn_timkiem"
                                        style="
                                            border-radius: 0 0.4em 0.4em 0 !important;
                                        ">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>
                        <script>
                            function timKiem(event) {
                                event.preventDefault();
                                let timkiem_header =
                                    document.querySelector(
                                        ".timkiem_header"
                                    ).value;
                                $.ajax({
                                    url: "{{ route('timkiem_header') }}",
                                    method: "GET",
                                    data: {
                                        timkiem_header: timkiem_header
                                    },

                                    success: function(res) {
                                        var goi_y =
                                            document.querySelector(
                                                ".goiy_timkiem"
                                            );
                                        goi_y.style.display = "block";
                                        goi_y.innerHTML = res;
                                        if (res.status === "Không tìm thấy") {
                                            goi_y.style.display = "block";
                                            goi_y.innerHTML =
                                                "Không tìm thấy kết quả";
                                        }
                                    },
                                });
                            }

                            function huyTimKiem(event) {
                                event.preventDefault();
                                var goi_y = (document.querySelector(
                                    ".goiy_timkiem"
                                ).style.display = "none");
                            }
                        </script>
                    </ul>
                </li>
                <!-- END TOP SEARCH -->
            </ul>
        </div>
        <!-- END NAVIGATION -->
    </div>
</div>
<!-- Header END -->
