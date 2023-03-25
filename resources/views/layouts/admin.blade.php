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

        @yield('title')

        <!-- Custom fonts for this template-->
        <link
            href="{{
                asset('frontend/vendor/fontawesome-free/css/all.min.css')
            }} "
            rel="stylesheet"
            type="text/css"
        />
        <link
            rel="stylesheet"
            href="{{
                asset('frontend/vendor/bootstrap/css/bootstrap-icons.css')
            }}"
            type="text/css"
        />
        <link
            rel="stylesheet"
            href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.css') }}"
            type="text/css"
        />

        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet"
            type="text/css"
        />

        <link
            href="{{ asset('frontend/css/sb-admin-2.min.css') }} "
            rel="stylesheet"
            type="text/css"
        />

        <link
            rel="stylesheet"
            href="{{ asset('frontend/css/camera.css') }}"
            type="text/css"
        />

        @yield('css')
    </head>

    <body id="page-top">
        @include('sweetalert::alert')
        <div id="wrapper">
            <!-- Sidebar -->
            @include('view-page.admin.sidebar')

            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    <!-- Topbar -->
                    @include('view-page.admin.header')

                    <!-- Content -->
                    <div class="container-fluid">@yield('content')</div>
                </div>
            </div>
        </div>

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Bootstrap core JavaScript-->
        <script src="{{
                asset('frontend/vendor/jquery/jquery.min.js')
            }} "></script>
        <script src="{{ asset('frontend/vendor/jquery/jquery.js') }} "></script>
        <script src="{{
                asset('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js')
            }} "></script>

        <!-- Core plugin JavaScript-->
        <script src="{{
                asset('frontend/vendor/jquery-easing/jquery.easing.min.js')
            }} "></script>

        <!-- Custom scripts for all pages-->
        <script src="{{ asset('frontend/js/sb-admin-2.min.js') }} "></script>

        <!-- Page level plugins -->
        <script src="{{
                asset('frontend/vendor/chart.js/Chart.min.js')
            }} "></script>

        <!-- Page level custom scripts -->
        <script src="{{
                asset('frontend/js/demo/chart-area-demo.js')
            }} "></script>
        <script src="{{
                asset('frontend/js/demo/chart-pie-demo.js')
            }} "></script>
        <!-- hiển thị alert thông báo  -->
        <script src="{{ asset('frontend/js/sweetalert2@11.js') }}"></script>
        <script src="{{ asset('frontend/js/sweetalert2.all.js') }}"></script>
        <script src="{{ asset('frontend/js/camera.js') }}"></script>
        <script src="{{ asset('frontend/ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('frontend/js/select2.min.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                setTimeout(function () {
                    $("div.alert").remove();
                }, 3000);
            });
        </script>
        @yield('js')
    </body>
</html>
