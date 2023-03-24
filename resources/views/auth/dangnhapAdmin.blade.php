<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Đăng nhập Admin</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link
            rel="stylesheet"
            type="text/css"
            href="{{
                asset('frontend/vendor/bootstrap/css/bootstrap.min.css')
            }}"
        />

        <link
            rel="stylesheet"
            type="text/css"
            href="{{
                asset(
                    'frontend/vendor/fontawesome-free/css/font-awesome.min.css'
                )
            }}"
        />
        <link
            rel="stylesheet"
            type="text/css"
            href="{{
                asset(
                    'frontend/vendor/iconic/css/material-design-iconic-font.min.css'
                )
            }}"
        />
        <link
            rel="stylesheet"
            type="text/css"
            href="{{ asset('frontend/css/animate.css') }}"
        />
        <link
            rel="stylesheet"
            type="text/css"
            href="{{
                asset('frontend/vendor/css-hamburgers/hamburgers.min.css')
            }}"
        />
        <link
            rel="stylesheet"
            type="text/css"
            href="{{
                asset('frontend/vendor/animsition/css/animsition.min.css')
            }}"
        />
        <link
            rel="stylesheet"
            type="text/css"
            href="{{ asset('frontend/css/select2.min.css') }}"
        />
        <link
            rel="stylesheet"
            type="text/css"
            href="{{
                asset('frontend/vendor/daterangepicker/daterangepicker.css')
            }}"
        />
        <link
            rel="stylesheet"
            type="text/css"
            href="{{ asset('frontend/css/util.css') }}"
        />
        <link
            rel="stylesheet"
            type="text/css"
            href="{{ asset('frontend/css/dangnhap.css') }}"
        />
    </head>
    <body>
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100" style="padding-top: 55px">
                    <form
                        class="login100-form validate-form was-validated"
                        action="{{ route('postDangNhap') }}"
                        method="post"
                    >
                        @csrf
                        <h1 style="text-align: center"><b>Đăng nhập</b></h1>
                        <br />
                        @if(Session::has('mgs'))
                        <span class="help-block" style="color: #ff3f3f">
                            {{Session::get('mgs')}}
                        </span>
                        <br />
                        <br />
                        @endif

                        <div
                            class="wrap-input100 validate-input"
                            data-validate="Email đúng dạng là: abc@gmail.com"
                        >
                            <input class="input100" type="text" name="email" />
                            <span
                                class="focus-input100"
                                data-placeholder="Email"
                            >
                            </span>
                            @if ($errors->has('email'))
                            <span class="help-block" style="color: #ff3f3f">
                                <b>{{ $errors->first('email') }}</b>
                            </span>
                            @endif
                        </div>

                        <div
                            class="wrap-input100 validate-input"
                            data-validate="Nhập password"
                        >
                            <span class="btn-show-pass">
                                <i class="zmdi zmdi-eye"></i>
                            </span>
                            <input
                                class="input100"
                                type="password"
                                name="password"
                                minlength="6"
                            />
                            <span
                                class="focus-input100"
                                data-placeholder="Password"
                            >
                            </span>
                            @if ($errors->has('password'))
                            <span class="help-block" style="color: #ff3f3f">
                                <b>{{ $errors->first('password') }}</b>
                            </span>
                            @endif
                        </div>

                        <div class="container-login100-form-btn">
                            <div class="wrap-login100-form-btn">
                                <div class="login100-form-bgbtn"></div>
                                <button class="login100-form-btn">
                                    Đăng nhập
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="{{
                asset('frontend/vendor/jquery/jquery.min.js')
            }}"></script>
        <script src="{{
                asset('frontend/vendor/animsition/js/animsition.min.js')
            }}"></script>
        <script src="{{
                asset('frontend/vendor/bootstrap/js/popper.js')
            }}"></script>
        <script src="{{
                asset('frontend/vendor/bootstrap/js/bootstrap.min.js')
            }}"></script>
        <script src="{{
                asset('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js')
            }}"></script>
        <script src="{{ asset('frontend/js/select2.min.js') }}"></script>
        <script src="{{
                asset('frontend/vendor/daterangepicker/moment.min.js')
            }}"></script>
        <script src="{{
                asset('frontend/vendor/daterangepicker/daterangepicker.js')
            }}"></script>
        <script src="{{
                asset('frontend/vendor/countdowntime/countdowntime.js')
            }}"></script>
        <script src="{{ asset('frontend/js/dangnhap.js') }}"></script>
    </body>
</html>
