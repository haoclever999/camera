<div class="header">
    <div class="container">
        <a class="site-logo" href="{{ route('home.index') }}">
            <img
                src="{{ asset('frontend/img/Logo_trong.png') }}"
                alt="HaoNganTelecom"
                width="100"
            />
        </a>

        <a href="#" class="mobi-toggler">
            <i class="fa fa-bars"></i>
        </a>

        <!-- BEGIN CART -->
        <div class="top-cart-block">
            <div class="top-cart-info">
                <!-- tổng sản phẩm điều chỉnh -->
                <a href="#" class="top-cart-info-count"> 3 items </a>
                <!-- tổng tiền điều chỉnh -->
                <a href="#" class="top-cart-info-value"> $1260 </a>
            </div>
            <i class="fa fa-shopping-cart"></i>

            <div class="top-cart-content-wrapper">
                <div class="top-cart-content">
                    <ul class="scroller" style="height: 250px">
                        <!-- foreach hình ảnh, số lượng, tên sp, xóa  -->
                        <li>
                            <a href="#"
                                ><img
                                    src="assets/pages/img/cart-img.jpg"
                                    alt="Rolex Classic Watch"
                                    width="37"
                                    height="34"
                            /></a>
                            <span class="cart-content-count">x 1</span>
                            <strong
                                ><a href="#"> Rolex Classic Watch </a></strong
                            >
                            <em>$1230</em>
                            <a href="javascript:void(0);" class="del-goods"
                                >&nbsp;</a
                            >
                        </li>
                    </ul>
                    <div class="text-right">
                        <a href="#" class="btn btn-default"> Xem giỏ hàng </a>
                        <a href="#" class="btn btn-primary"> Thanh toán </a>
                    </div>
                </div>
            </div>
        </div>
        <!--END CART -->

        <!-- BEGIN NAVIGATION -->
        <div class="header-navigation">
            <ul>
                <li>
                    <a href="#"> Trang chủ </a>
                </li>
                <li class="dropdown dropdown-megamenu">
                    <a href="javascript:;"> Danh mục </a>
                </li>
                <li class="dropdown dropdown-megamenu">
                    <a href="#"> Sản phẩm </a>
                </li>
                <li>
                    <a href="#"> 7 ngày đổi trả </a>
                </li>

                <!-- BEGIN TOP SEARCH -->
                <li class="menu-search">
                    <span class="sep"></span>
                    <i class="fa fa-search search-btn"></i>
                    <div class="search-box">
                        <form action="#">
                            <div class="input-group">
                                <input
                                    type="text"
                                    placeholder="Search"
                                    class="form-control"
                                />
                                <span class="input-group-btn">
                                    <button
                                        class="btn btn-primary"
                                        type="submit"
                                    >
                                        Search
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                </li>
                <!-- END TOP SEARCH -->
            </ul>
        </div>
        <!-- END NAVIGATION -->
    </div>
</div>
<!-- Header END -->
