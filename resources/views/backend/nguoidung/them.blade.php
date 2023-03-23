<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
<title>Quản lý người dùng</title>
@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Thêm người dùng </b></h2>
</div>
@endsection @section('title-content')
<ol
    class="breadcrumb float-sm-right"
    style="padding: 8px 16px; margin: 12px auto; height: 1%"
>
    <li class="breadcrumb-item">
        <a href="{{ route('nguoidung.index') }}">Người dùng</a>
    </li>
    <li class="breadcrumb-item active">Thêm</li>
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
            >
            </i>
            Thêm người dùng thất bại!
        </div>
        @endif
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('nguoidung.store') }}" method="post">
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
                                value="{{ old('ho_ten') }}"
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
                                value="{{ old('email') }}"
                                required
                            />
                            @if ($errors->has('email'))
                            <span class="help-block" style="color: #ff3f3f">
                                <b>{{ $errors->first('email') }}</b>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">
                                <b>Password</b>
                            </label>
                            <input
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="password"
                                name="password"
                                placeholder="Nhập password"
                                value="{{ old('password') }}"
                            />
                            @if ($errors->has('password'))
                            <span class="help-block" style="color: #ff3f3f">
                                <b>{{ $errors->first('password') }}</b>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="opt_quyen" class="form-label">
                                <b>Quyền</b>
                            </label>
                            <select
                                class="form-control @error('opt_quyen') is-invalid @enderror"
                                name="opt_quyen"
                                value="{{ old('opt_quyen') }}"
                            >
                                <option selected value="">-Chọn quyền-</option>
                                <option value="Quản trị">Quản trị</option>
                                <option value="Nhân viên">Nhân viên</option>
                                <option value="Khách hàng">Khách hàng</option>
                            </select>
                            @if ($errors->has('opt_quyen'))
                            <span class="help-block" style="color: #ff3f3f">
                                <b>{{ $errors->first('opt_quyen') }}</b>
                            </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Thêm người dùng
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
