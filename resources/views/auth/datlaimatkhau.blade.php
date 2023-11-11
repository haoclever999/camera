<!DOCTYPE html>
<html lang="en">

<head>
    <title>Đăng nhập - Đặt lại mật khẩu</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="{{ asset('frontend/img/Logo.png') }}" type="image/gif" sizes="32x32" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}" />

    <link rel="stylesheet" type="text/css"
        href="{{ asset('frontend/vendor/fontawesome-free/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('frontend/vendor/iconic/css/material-design-iconic-font.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/animate.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/css-hamburgers/hamburgers.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/animsition/css/animsition.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/select2.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/daterangepicker/daterangepicker.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/util.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/dangnhap.css') }}" />
</head>

<body>
    <div class="limiter">
        <div class="container-login100" style="background-image: url({{ url('frontend/img/background_login.jpg') }})">
            <div class="wrap-login100" style="padding-top: 55px; width: 420px">
                <form class="login100-form validate-form was-validated"
                    action="{{ route('postDatLaiMatKhauUser', ['id' => $user->id]) }}" method="post">
                    @csrf
                    <h1 style="text-align: center; font-size: 2.4rem">
                        <b>Đặt lại mật khẩu</b>
                    </h1>
                    <br />
                    @if (Session::has('err'))
                        <span class="help-block" style="color: #ff3f3f">
                            {{ Session::get('err') }}
                        </span>
                        <br />
                        <br />
                        @endif @if (Session::has('success'))
                            <span class="help-block" style="color: #3fff5f">
                                {{ Session::get('success') }}
                            </span>
                            <br />
                            <br />
                        @endif

                        <div class="wrap-input100 validate-input" data-validate="Email đúng dạng là: abc@gmail.com">
                            <input class="input100" type="text" name="email" style="cursor: no-drop"
                                value="{{ $user->email }}" disabled />
                        </div>

                        <div class="wrap-input100 validate-input" data-validate="Nhập mật khẩu">
                            <span class="btn-show-pass">
                                <i class="zmdi zmdi-eye"></i>
                            </span>
                            <input class="input100" type="password" name="password" minlength="6" required />
                            <span class="focus-input100" data-placeholder="Nhập mật khẩu mới">
                            </span>
                            @if ($errors->has('password'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ $errors->first('password') }}</b>
                                </span>
                            @endif
                        </div>

                        <div class="wrap-input100 validate-input" data-validate="Nhập lại mật khẩu">
                            <span class="btn-show-pass">
                                <i class="zmdi zmdi-eye"></i>
                            </span>
                            <input class="input100" type="password" name="password_confirm" minlength="6" required />
                            <span class="focus-input100" data-placeholder="Nhập lại mật khẩu mới">
                            </span>
                            @if ($errors->has('password'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ $errors->first('password') }}</b>
                                </span>
                            @endif
                        </div>
                        <div class="login_remember_box">
                            <a href="{{ route('getDangNhapUser') }}" style="text-decoration: none; float: left">
                                Quay về đăng nhập
                                <img src="{{ asset('frontend/img/logout.png') }}" width="15px"
                                    style="
                                        margin-right: 4px;
                                        width: 1.25em;
                                        text-align: center;
                                    " />
                            </a>
                        </div>
                        <br />
                        <div class="container-login100-form-btn">
                            <div class="wrap-login100-form-btn">
                                <div class="login100-form-bgbtn"></div>
                                <button class="login100-form-btn">
                                    Đặt lại
                                </button>
                            </div>
                        </div>
                </form>
                <br />
            </div>
        </div>
    </div>
    <script src="{{ asset('frontend/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/animsition/js/animsition.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('frontend/vendor/countdowntime/countdowntime.js') }}"></script>
    <script src="{{ asset('frontend/js/dangnhap.js') }}"></script>
</body>

</html>
