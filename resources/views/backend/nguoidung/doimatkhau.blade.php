<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
<title>Quản lý người dùng</title>
@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Đổi mật khẩu </b></h2>
</div>
@endsection @section('title-content')
<ol
    class="breadcrumb float-sm-right"
    style="padding: 8px 16px; margin: 12px auto; height: 1%"
>
    <li class="breadcrumb-item">
        <a href="{{ route('nguoidung.index') }}">Người dùng</a>
    </li>
    <li class="breadcrumb-item active">Đổi mật khẩu</li>
</ol>
@endsection @section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <i
                class="fas fa-exclamation-circle"
                style="font-size: 25px; color: red"
            ></i>
            Đổi mật khẩu thất bại!
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>
        @endif
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <form
                        action="{{ route('nguoidung.postdoimatkhau', ['id' => $user->id] ) }}"
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
                            <label for="password_old" class="form-label">
                                <b>Mật khẩu cũ</b>
                            </label>
                            <input
                                type="password"
                                class="form-control @error('password_old') is-invalid @enderror"
                                id="password_old"
                                name="password_old"
                                placeholder="Nhập mật khẩu"
                                required
                            />
                            @if ($errors->has('password_old'))
                            <span class="help-block" style="color: #ff3f3f">
                                <b>{{ $errors->first('password_old') }}</b>
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
                            @if ($errors->has('password_new'))
                            <span class="help-block" style="color: #ff3f3f">
                                <b>{{ $errors->first('password_new') }}</b>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password_confirm" class="form-label">
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
                            @if ($errors->has('password_confirm'))
                            <span class="help-block" style="color: #ff3f3f">
                                <b>{{ $errors->first('password_confirm') }}</b>
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
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
