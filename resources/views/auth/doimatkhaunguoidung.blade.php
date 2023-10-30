@extends('layouts.user') @section('title')
<title>Đổi mật khẩu</title>
@endsection @section('slider') @include('view-page.user.slider') @endsection
@section('content')
<div class="row margin-bottom-40" style="margin-top: 40px">
    @include('view-page.user.sidebar_menu')
    <div class="col-md-9 col-sm-7">
        <div class="content">
            <div class="col-md-7 col-sm-7">
                <h2 style="text-align: center"><b>Đổi mật khẩu</b></h2>
                @if($errors->any() || Session::has('err') ||
                Session::has('err_pw_cu'))
                <h3 style="color: red; font-size: 18px; font-weight: bold">
                    Đổi mật khẩu thất bại!
                </h3>
                @endif @if(Session::has('success'))
                <h3 style="color: green; font-size: 18px; font-weight: bold">
                    {{ Session::get('success')}}
                </h3>
                @endif
            </div>
            <div class="container-fluid">
                <div class="row product-list" style="min-height: 300px">
                    <div class="col-md-10">
                        <form
                            action="{{ route('nguoidung.postdoimatkhauUser', ['id' => $user->id] ) }}"
                            method="post"
                        >
                            @csrf

                            <div class="form-group">
                                <label for="email" class="form-label">
                                    <b>Email</b>
                                </label>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    value="{{ $user->email }}"
                                    style="cursor: no-drop"
                                    disabled
                                />
                            </div>

                            <div class="form-group">
                                <label for="password" class="form-label">
                                    <b>Mật khẩu cũ</b>
                                </label>

                                <input
                                    type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    id="password"
                                    name="password"
                                    placeholder="Nhập mật khẩu cũ"
                                />
                                <span
                                    class="fa fa-fw fa-eye field-icon toggle-password"
                                    style="
                                        float: right;
                                        margin-left: -25px;
                                        margin-right: 5px;
                                        margin-top: -25px;
                                        position: relative;
                                        z-index: 2;
                                        cursor: pointer;
                                    "
                                ></span>
                                @if ($errors->has('password'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ $errors->first('password') }}</b>
                                </span>
                                @endif @if (Session::has('err_pw_cu'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ Session::get('err_pw_cu') }}</b>
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="password_new" class="form-label">
                                    <b>Mật khẩu mới</b>
                                </label>
                                <input
                                    type="password"
                                    class="form-control @error('password_new') is-invalid @enderror"
                                    id="password_new"
                                    name="password_new"
                                    placeholder="Nhập mật khẩu mới"
                                    required
                                />
                                <span
                                    class="fa fa-fw fa-eye field-icon toggle-password"
                                    style="
                                        float: right;
                                        margin-left: -25px;
                                        margin-right: 5px;
                                        margin-top: -25px;
                                        position: relative;
                                        z-index: 2;
                                        cursor: pointer;
                                    "
                                ></span>
                                @if ($errors->has('password_new'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ $errors->first('password_new') }}</b>
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label
                                    for="password_confirm"
                                    class="form-label"
                                >
                                    <b>Nhập lại mật khẩu mới</b>
                                </label>
                                <input
                                    type="password"
                                    class="form-control @error('password_confirm') is-invalid @enderror"
                                    id="password_confirm"
                                    name="password_confirm"
                                    placeholder="Nhập lại mật khẩu mới"
                                    required
                                />
                                <span
                                    class="fa fa-fw fa-eye field-icon toggle-password"
                                    style="
                                        float: right;
                                        margin-left: -25px;
                                        margin-right: 5px;
                                        margin-top: -25px;
                                        position: relative;
                                        z-index: 2;
                                        cursor: pointer;
                                    "
                                ></span>
                                @if ($errors->has('password_confirm'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>
                                        {{ $errors->first('password_confirm') }}</b
                                    >
                                </span>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Đổi mật khẩu
                            </button>
                        </form>
                    </div>
                </div>

                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
    </div>
</div>

@endsection @section('js')
<script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
<script>
    $(".toggle-password").click(function () {
        $(this).toggleClass("fa-eye fa-eye-slash");

        $(this).prev("input").attr("type") === "password"
            ? $(this).prev("input").attr("type", "text")
            : $(this).prev("input").attr("type", "password");
    });
</script>
@endsection
