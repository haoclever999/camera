<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
<title>Quản lý người dùng</title>
@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Cập nhật người dùng </b></h2>
</div>
@endsection @section('title-content')
<ol
    class="breadcrumb float-sm-right"
    style="padding: 8px 16px; margin: 12px auto; height: 1%"
>
    <li class="breadcrumb-item">
        <a href="{{ route('nguoidung.index') }}">Người dùng</a>
    </li>
    <li class="breadcrumb-item active">Cập nhật hồ sơ</li>
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
            Cập nhật hồ sơ thất bại!
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
                        action="{{ route('nguoidung.posthoso', ['id' => $user->id] ) }}"
                        method="post"
                    >
                        @csrf

                        <div class="form-group">
                            <label for="ho_ten" class="form-label">
                                <b>Tên người dùng</b>
                            </label>
                            <input
                                type="text"
                                class="form-control @error('ho_ten') is-invalid @enderror"
                                id="ho_ten"
                                name="ho_ten"
                                placeholder="Nhập tên người dùng"
                                value="{{ $user->ho_ten }}"
                                required
                            />
                            @if ($errors->has('ho_ten'))
                            <span class="help-block" style="color: #ff3f3f">
                                <b>{{ $errors->first('ho_ten') }}</b>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">
                                <b>Email</b>
                            </label>
                            <input
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email"
                                name="email"
                                placeholder="Nhập Email"
                                value="{{ $user->email }}"
                                required
                            />
                            @if ($errors->has('email'))
                            <span class="help-block" style="color: #ff3f3f">
                                <b>{{ $errors->first('email') }}</b>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="sdt" class="form-label">
                                <b>Số điện thoại</b>
                            </label>
                            <input
                                type="text"
                                class="form-control @error('sdt') is-invalid @enderror"
                                id="sdt"
                                name="sdt"
                                placeholder="Nhập số điện thoại"
                                value="{{ $user->sdt }}"
                                required
                            />
                            @if ($errors->has('sdt'))
                            <span class="help-block" style="color: #ff3f3f">
                                <b>{{ $errors->first('sdt') }}</b>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="dia_chi" class="form-label">
                                <b>Địa chỉ</b>
                            </label>
                            <input
                                type="dia_chi"
                                class="form-control @error('dia_chi') is-invalid @enderror"
                                id="dia_chi"
                                name="dia_chi"
                                placeholder="Nhập địa chỉ"
                                value="{{ $user->dia_chi }}"
                                required
                            />
                            @if ($errors->has('dia_chi'))
                            <span class="help-block" style="color: #ff3f3f">
                                <b>{{ $errors->first('dia_chi') }}</b>
                            </span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Cập nhật hồ sơ
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
