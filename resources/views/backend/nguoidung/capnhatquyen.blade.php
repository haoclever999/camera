<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
<title>Quản lý người dùng</title>
@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Cập nhật quyền </b></h2>
</div>
@endsection @section('title-content')
<ol
    class="breadcrumb float-sm-right"
    style="padding: 8px 16px; margin: 12px auto; height: 1%"
>
    <li class="breadcrumb-item">
        <a href="{{ route('danhmuc.index') }}">Người dùng</a>
    </li>
    <li class="breadcrumb-item active">Cập nhật quyền</li>
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
            Cập nhật quyền thất bại!
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>
        @endif
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <form
                        action="{{ route('nguoidung.capnhatquyen', ['id' => $user->id] ) }}"
                        method="post"
                    >
                        @csrf
                        <!-- <div class="form-group">
                            <label class="form-label">
                                <b>Người dùng: </b>{{ $dm->ten_dm}}
                            </label>
                        </div> -->
                        <!-- <div class="form-group">
                            <label for="opt_quyen" class="form-label">
                                <b>Quyền</b>
                            </label>
                            <input
                                type="text"
                                class="form-control @error('opt_quyen') is-invalid @enderror"
                                id="opt_quyen"
                                name="opt_quyen"
                                value="{{ $dm->opt_quyen}}"
                                placeholder="Nhập tên danh mục"
                                required
                            />
                            @if ($errors->has('opt_quyen'))
                            <span class="help-block" style="color: #ff3f3f">
                                <b>{{ $errors->first('opt_quyen') }}</b>
                            </span>
                            @endif
                        </div> -->
                        <button type="submit" class="btn btn-primary">
                            Sửa danh mục
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
