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
        <!--- fonts for slider on the index page -->
        <!-- Fonts END -->

        <!-- Global styles START -->
        <link
            href="{{
                asset('frontend/plugins/font-awesome/css/font-awesome.min.css')
            }}"
            rel="stylesheet"
        />
        <link
            href="{{
                asset('frontend/plugins/bootstrap/css/bootstrap.min.css')
            }}"
            rel="stylesheet"
        />
        <!-- Global styles END -->

        <!-- Page level plugin styles START -->
        <link
            href="{{ asset('frontend/pages/css/animate.css') }}"
            rel="stylesheet"
        />
        <link
            href="{{
                asset('frontend/plugins/fancybox/source/jquery.fancybox.css')
            }}"
            rel="stylesheet"
        />
        <link
            href="{{
                asset('frontend/plugins/owl.carousel/assets/owl.carousel.css')
            }}"
            rel="stylesheet"
        />
        <!-- Page level plugin styles END -->

        <!-- Theme styles START -->
        <link
            href="{{ asset('frontend/pages/css/components.css') }}"
            rel="stylesheet"
        />
        <link
            href="{{ asset('frontend/pages/css/slider.css') }}"
            rel="stylesheet"
        />
        <link
            href="{{ asset('frontend/pages/css/style-shop.css') }}"
            rel="stylesheet"
            type="text/css"
        />
        <link
            href="{{ asset('frontend/corporate/css/style.css') }}"
            rel="stylesheet"
        />
        <link
            href="{{ asset('frontend/corporate/css/style-responsive.css') }}"
            rel="stylesheet"
        />
        <link
            href="{{ asset('frontend/corporate/css/themes/red.css') }}"
            rel="stylesheet"
            id="style-color"
        />
        <link
            href="{{ asset('frontend/corporate/css/custom.css') }}"
            rel="stylesheet"
        />
        <!-- Theme styles END -->
        <title>
            Cửa Hàng Bán Camera Quan Sát, Camera An Ninh, Camera Giám Sát
        </title>
        @yield('css')
    </head>

    <body id="page-top">
        <div id="wrapper">
            <!-- Sidebar -->
            @include('view-page.user.header') @include('view-page.user.sidebar')
            <div class="main">
                <div class="container">@yield('content')</div>
            </div>

            @include('view-page.user.footer')
        </div>

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        @yield('js')
    </body>
    <script
        src="{{ asset('frontend/plugins/jquery.min.js') }}"
        type="text/javascript"
    ></script>
    <script
        src="{{ asset('frontend/plugins/jquery-migrate.min.js') }}"
        type="text/javascript"
    ></script>
    <script
        src="{{ asset('frontend/plugins/bootstrap/js/bootstrap.min.js') }}"
        type="text/javascript"
    ></script>
    <script
        src="{{ asset('frontend/corporate/scripts/back-to-top.js') }}"
        type="text/javascript"
    ></script>
    <script
        src="{{
            asset('frontend/plugins/jquery-slimscroll/jquery.slimscroll.min.js')
        }}"
        type="text/javascript"
    ></script>
    <!-- END CORE PLUGINS -->

    <!-- BEGIN PAGE LEVEL JAVASCRIPTS (REQUIRED ONLY FOR CURRENT PAGE) -->
    <script
        src="{{
            asset('frontend/plugins/fancybox/source/jquery.fancybox.pack.js')
        }}"
        type="text/javascript"
    ></script>
    <!-- pop up -->
    <script
        src="{{ asset('frontend/plugins/owl.carousel/owl.carousel.min.js') }}"
        type="text/javascript"
    ></script>
    <!-- slider for products -->
    <script
        src="{{ asset('frontend/plugins/zoom/jquery.zoom.min.js') }}"
        type="text/javascript"
    ></script>
    <!-- product zoom -->
    <script
        src="{{
            asset('frontend/plugins/bootstrap-touchspin/bootstrap.touchspin.js')
        }}"
        type="text/javascript"
    ></script>
    <!-- Quantity -->

    <script
        src="{{ asset('frontend/corporate/scripts/layout.js') }}"
        type="text/javascript"
    ></script>
    <script
        src="{{ asset('frontend/pages/scripts/bs-carousel.js') }}"
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
