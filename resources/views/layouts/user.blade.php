<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />
        <!-- Bắt đầu SEO  -->
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta name="robots" content="" />
        <link rel="canonical" href="{{ $url_canonical }}" />
        <meta name="author" content="" />

        <meta property="og:site_name" content="http://127.0.0.1:8000/" />
        <meta property="og:title" content="-CUSTOMER VALUE-" />
        <meta property="og:description" content="-CUSTOMER VALUE-" />
        <meta property="og:type" content="website" />
        <meta property="og:image" content="-CUSTOMER VALUE-" />
        <!-- link to image for socio -->
        <meta property="og:url" content="-CUSTOMER VALUE-" />
        <!-- Kết thúc SEO -->
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
        <!-- Global styles START -->
        <link
            href="{{
                asset(
                    'frontend/assets_theme/plugins/font-awesome/css/font-awesome.min.css'
                )
            }}"
            rel="stylesheet"
        />
        <link
            href="{{
                asset(
                    'frontend/assets_theme/plugins/bootstrap/css/bootstrap.min.css'
                )
            }}"
            rel="stylesheet"
        />
        <!-- Global styles END -->

        <!-- Page level plugin styles START -->
        <link
            href="{{ asset('frontend/assets_theme/pages/css/animate.css') }}"
            rel="stylesheet"
        />
        <link
            href="{{
                asset(
                    'frontend/assets_theme/plugins/fancybox/source/jquery.fancybox.css'
                )
            }}"
            rel="stylesheet"
        />
        <link
            href="{{
                asset(
                    'frontend/assets_theme/plugins/owl.carousel/assets/owl.carousel.css'
                )
            }}"
            rel="stylesheet"
        />
        <!-- Page level plugin styles END -->

        <!-- Theme styles START -->
        <link
            href="{{ asset('frontend/assets_theme/pages/css/components.css') }}"
            rel="stylesheet"
        />

        <link
            href="{{ asset('frontend/assets_theme/pages/css/style-shop.css') }}"
            rel="stylesheet"
            type="text/css"
        />
        <link
            href="{{ asset('frontend/assets_theme/corporate/css/style.css') }}"
            rel="stylesheet"
        />
        <link
            href="{{
                asset(
                    'frontend/assets_theme/corporate/css/style-responsive.css'
                )
            }}"
            rel="stylesheet"
        />
        <link
            href="{{
                asset('frontend/assets_theme/corporate/css/themes/blue.css')
            }}"
            rel="stylesheet"
            id="style-color"
        />
        <link
            href="{{ asset('frontend/assets_theme/corporate/css/custom.css') }}"
            rel="stylesheet"
        />
        <!-- Theme styles END -->

        @yield('css')
    </head>

    <body id="page-top">
        <!-- Top bar-->
        @include('view-page.user.topbar')
        <!-- Header-->
        @include('view-page.user.header')
        <!-- Slider -->
        @yield('slider')
        <div class="main">
            <div class="container">@yield('content')</div>
        </div>

        @include('view-page.user.footer')

        <!-- Scroll to Top Button-->

        @yield('js')
        <!-- Load javascripts at bottom, this will reduce page load time -->
        <!-- BEGIN CORE PLUGINS (REQUIRED FOR ALL PAGES) -->
        <!--[if lt IE 9]>
            <script src="assets/plugins/respond.min.js"></script>
        <![endif]-->
        <script
            src="{{ asset('frontend/assets_theme/plugins/jquery.min.js') }}"
            type="text/javascript"
        ></script>
        <script
            src="{{
                asset('frontend/assets_theme/plugins/jquery-migrate.min.js')
            }}"
            type="text/javascript"
        ></script>
        <script
            src="{{
                asset(
                    'frontend/assets_theme/plugins/bootstrap/js/bootstrap.min.js'
                )
            }}"
            type="text/javascript"
        ></script>
        <script
            src="{{
                asset('frontend/assets_theme/corporate/scripts/back-to-top.js')
            }}"
            type="text/javascript"
        ></script>
        <script
            src="{{
                asset(
                    'frontend/assets_theme/plugins/jquery-slimscroll/jquery.slimscroll.min.js'
                )
            }}"
            type="text/javascript"
        ></script>
        <!-- END CORE PLUGINS -->

        <!-- BEGIN PAGE LEVEL JAVASCRIPTS (REQUIRED ONLY FOR CURRENT PAGE) -->
        <script
            src="{{
                asset(
                    'frontend/assets_theme/plugins/fancybox/source/jquery.fancybox.pack.js'
                )
            }}"
            type="text/javascript"
        ></script>
        <!-- pop up -->
        <script
            src="{{
                asset(
                    'frontend/assets_theme/plugins/owl.carousel/owl.carousel.min.js'
                )
            }}"
            type="text/javascript"
        ></script>
        <!-- slider for products -->
        <script
            src="{{
                asset('frontend/assets_theme/plugins/zoom/jquery.zoom.min.js')
            }}"
            type="text/javascript"
        ></script>
        <!-- product zoom -->
        <script
            src="{{
                asset(
                    'frontend/assets_theme/plugins/bootstrap-touchspin/bootstrap.touchspin.js'
                )
            }}"
            type="text/javascript"
        ></script>
        <!-- Quantity -->

        <script
            src="{{
                asset('frontend/assets_theme/corporate/scripts/layout.js')
            }}"
            type="text/javascript"
        ></script>
        <script
            src="{{
                asset('frontend/assets_theme/pages/scripts/bs-carousel.js')
            }}"
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

        <div id="fb-root"></div>
        <div id="fb-root"></div>
        <div id="fb-root"></div>
        <script
            async
            defer
            crossorigin="anonymous"
            src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v16.0"
            nonce="WbtABH9B"
        ></script>
    </body>
</html>
