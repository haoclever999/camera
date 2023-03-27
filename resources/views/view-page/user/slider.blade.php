<!-- <div id="myCarousel" class="carousel slide" data-ride="carousel">
    -- Indicators
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>
    </ol>

    -- Wrapper for slides
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <img src="images/carousel/c1.png" alt="ABC Shop" />
            <div class="carousel-caption">
                <h3>Sản phẩm chất lượng</h3>
            </div>
        </div>

        <div class="item">
            <img src="images/carousel/c2.png" alt="ABC Shop" />
            <div class="carousel-caption">
                <h3>Mẫu mã đa dạng</h3>
            </div>
        </div>

        <div class="item">
            <img src="images/carousel/c3.png" alt="ABC Shop" />
            <div class="carousel-caption">
                <h3>Giá cả hợp lý</h3>
            </div>
        </div>

        <div class="item">
            <img src="images/carousel/c4.png" alt="ABC Shop" />
            <div class="carousel-caption">
                <h3>Tận tâm phục vụ</h3>
            </div>
        </div>
    </div>

    -- Left and right controls
    <a
        class="left carousel-control"
        href="#myCarousel"
        role="button"
        data-slide="prev"
    >
        <span
            class="glyphicon glyphicon-chevron-left"
            aria-hidden="true"
        ></span>
        <span class="sr-only">Trước</span>
    </a>
    <a
        class="right carousel-control"
        href="#myCarousel"
        role="button"
        data-slide="next"
    >
        <span
            class="glyphicon glyphicon-chevron-right"
            aria-hidden="true"
        ></span>
        <span class="sr-only">Tiếp</span>
    </a>
</div> -->

<div class="page-slider margin-bottom-35">
    <div id="carousel-example-generic" class="carousel slide carousel-slider">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li
                data-target="#carousel-example-generic"
                data-slide-to="0"
                class="active"
            ></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            <li data-target="#carousel-example-generic" data-slide-to="3"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <!-- First slide -->
            <div class="item carousel-item-four active">
                <div class="container">
                    <div class="carousel-position-four text-center">
                        <h2
                            class="margin-bottom-20 animate-delay carousel-title-v3 border-bottom-title text-uppercase"
                            data-animation="animated fadeInDown"
                        >
                            Tones of <br /><span class="color-red-v2"
                                >Shop UI Features</span
                            ><br />
                            designed
                        </h2>
                        <p
                            class="carousel-subtitle-v2"
                            data-animation="animated fadeInUp"
                        >
                            Lorem ipsum dolor sit amet constectetuer diam <br />
                            adipiscing elit euismod ut laoreet dolore.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Second slide -->
            <div class="item carousel-item-five">
                <div class="container">
                    <div class="carousel-position-four text-center">
                        <h2
                            class="animate-delay carousel-title-v4"
                            data-animation="animated fadeInDown"
                        >
                            Unlimted
                        </h2>
                        <p
                            class="carousel-subtitle-v2"
                            data-animation="animated fadeInDown"
                        >
                            Layout Options
                        </p>
                        <p
                            class="carousel-subtitle-v3 margin-bottom-30"
                            data-animation="animated fadeInUp"
                        >
                            Fully Responsive
                        </p>
                        <a
                            class="carousel-btn"
                            href="#"
                            data-animation="animated fadeInUp"
                            >See More Details</a
                        >
                    </div>
                    <img
                        class="carousel-position-five animate-delay hidden-sm hidden-xs"
                        src="{{
                            asset(
                                'frontend/assets_theme/pages/img/shop-slider/slide2/price.png'
                            )
                        }}"
                        alt="Price"
                        data-animation="animated zoomIn"
                    />
                </div>
            </div>

            <!-- Third slide -->
            <div class="item carousel-item-six">
                <div class="container">
                    <div class="carousel-position-four text-center">
                        <span
                            class="carousel-subtitle-v3 margin-bottom-15"
                            data-animation="animated fadeInDown"
                        >
                            Full Admin &amp; Frontend
                        </span>
                        <p
                            class="carousel-subtitle-v4"
                            data-animation="animated fadeInDown"
                        >
                            eCommerce UI
                        </p>
                        <p
                            class="carousel-subtitle-v3"
                            data-animation="animated fadeInDown"
                        >
                            Is Ready For Your Project
                        </p>
                    </div>
                </div>
            </div>

            <!-- Fourth slide -->
            <div class="item carousel-item-seven">
                <div class="center-block">
                    <div class="center-block-wrap">
                        <div class="center-block-body">
                            <h2
                                class="carousel-title-v1 margin-bottom-20"
                                data-animation="animated fadeInDown"
                            >
                                The most <br />
                                wanted bijouterie
                            </h2>
                            <a
                                class="carousel-btn"
                                href="#"
                                data-animation="animated fadeInUp"
                                >But It Now!</a
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <a
            class="left carousel-control carousel-control-shop"
            href="#carousel-example-generic"
            role="button"
            data-slide="prev"
        >
            <i class="fa fa-angle-left" aria-hidden="true"></i>
        </a>
        <a
            class="right carousel-control carousel-control-shop"
            href="#carousel-example-generic"
            role="button"
            data-slide="next"
        >
            <i class="fa fa-angle-right" aria-hidden="true"></i>
        </a>
    </div>
</div>
<!-- END SLIDER -->
