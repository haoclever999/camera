<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />
        <meta name="description" content="" />
        <meta name="author" content="" />

        <meta property="og:site_name" content="-CUSTOMER VALUE-" />
        <meta property="og:title" content="-CUSTOMER VALUE-" />
        <meta property="og:description" content="-CUSTOMER VALUE-" />
        <meta property="og:type" content="website" />
        <meta property="og:image" content="-CUSTOMER VALUE-" />
        <!-- link to image for socio -->
        <meta property="og:url" content="-CUSTOMER VALUE-" />
        @yield('title')
        <!-- Fonts START -->
        <link
            href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|PT+Sans+Narrow|Source+Sans+Pro:200,300,400,600,700,900&amp;subset=all"
            rel="stylesheet"
            type="text/css"
        />
        <link
            href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900&amp;subset=all"
            rel="stylesheet"
            type="text/css"
        />
        <!-- Fonts END -->

        <!-- Global styles START -->
        <link
            href="{{
                asset(
                    'frontend/vendor/fontawesome-free/css/font-awesome.min.css'
                )
            }}"
            rel="stylesheet"
        />

        <link
            href="{{
                asset('frontend/vendor/bootstrap/css/bootstrap.min.css')
            }}"
            rel="stylesheet"
        />

        <link href="{{ asset('frontend/css/animate.css') }}" rel="stylesheet" />
        <link
            href="{{ asset('frontend/vendor/jquery/jquery.fancybox.css') }}"
            rel="stylesheet"
        />
        <link
            href="{{ asset('frontend/vendor/owl.carousel/owl.carousel.css') }}"
            rel="stylesheet"
        />
        <link
            href="{{ asset('frontend/css/components.css') }}"
            rel="stylesheet"
        />
        <link href="{{ asset('frontend/css/slider.css') }}" rel="stylesheet" />
        <link
            href="{{ asset('frontend/css/style-shop.css') }}"
            rel="stylesheet"
        />
        <link
            href="{{ asset('frontend/css/style-responsive.css') }}"
            rel="stylesheet"
        />
        <link href="{{ asset('frontend/css/red.css') }}" rel="stylesheet" />

        <!-- Theme styles END -->

        @yield('css')
    </head>

    <body id="page-top">
        <!-- Top bar-->
        @include('view-page.user.topbar')
        <!-- Header-->
        @include('view-page.user.header')
        <!-- Slider -->
        @include('view-page.user.slider')
        <div class="main">
            <div class="container">@yield('content')</div>
        </div>

        @include('view-page.user.footer')

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        @yield('js')
    </body>
    <script
        src="{{ asset('frontend/vendor/jquery/jquery.min.js') }}"
        type="text/javascript"
    ></script>
    <script
        src="{{ asset('frontend/vendor/jquery/jquery-migrate.min.js') }}"
        type="text/javascript"
    ></script>
    <script
        src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.min.js') }}"
        type="text/javascript"
    ></script>
    <!-- chưa  -->
    <script
        src="{{ asset('frontend/corporate/scripts/back-to-top.js') }}"
        type="text/javascript"
    ></script>
    <!--  -->
    <script
        src="{{ asset('frontend/vendor/jquery/jquery.slimscroll.min.js') }}"
        type="text/javascript"
    ></script>
    <!-- END CORE vendor -->

    <!-- BEGIN PAGE LEVEL JAVASCRIPTS (REQUIRED ONLY FOR CURRENT PAGE) -->
    <script
        src="{{ asset('frontend/vendor/jquery/jquery.fancybox.pack.js') }}"
        type="text/javascript"
    ></script>
    <!-- pop up -->
    <script
        src="{{ asset('frontend/vendor/owl.carousel/owl.carousel.min.js') }}"
        type="text/javascript"
    ></script>
    <!-- slider for products -->
    <script
        src="{{ asset('frontend/vendor/zoom/jquery.zoom.min.js') }}"
        type="text/javascript"
    ></script>
    <!-- product zoom -->
    <script
        src="{{
            asset('frontend/vendor/bootstrap-touchspin/bootstrap.touchspin.js')
        }}"
        type="text/javascript"
    ></script>
    <!-- Quantity -->

    <script
        src="{{ asset('frontend/js/layout.js') }}"
        type="text/javascript"
    ></script>
    <script
        src="{{ asset('frontend/vendor/owl.carousel/bs-carousel.js') }}"
        type="text/javascript"
    ></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            Layout.init();
            Layout.initOWL();
            Layout.initImageZoom();
            Layout.initTouchspin();
            Layout.initTwitter();

            Layout.initFixHeaderWithPreHeader();
            Layout.initNavScrolling();
        });
    </script>
</html>
