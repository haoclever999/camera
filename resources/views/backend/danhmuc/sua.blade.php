<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
<title>Quản lý danh mục</title>
@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Cập nhật danh mục </b></h2>
</div>
@endsection @section('title-content')
<ol
    class="breadcrumb float-sm-right"
    style="padding: 8px 16px; margin: 12px auto; height: 1%"
>
    <li class="breadcrumb-item">
        <a href="{{ route('danhmuc.index') }}">Danh mục</a>
    </li>
    <li class="breadcrumb-item active">Cập nhật</li>
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
            Cập nhật danh mục thất bại!
        </div>
        @endif
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <form
                        action="{{ route('danhmuc.update', ['id' => $dm->id] ) }}"
                        method="post"
                    >
                        @csrf
                        <div class="form-group">
                            <label for="ten_dm" class="form-label">
                                <b>Tên danh mục</b>
                            </label>
                            <input
                                type="text"
                                class="form-control @error('ten_dm') is-invalid @enderror"
                                id="ten_dm"
                                name="ten_dm"
                                value="{{ $dm->ten_dm}}"
                                placeholder="Nhập tên danh mục"
                                required
                            />
                            @if ($errors->has('ten_dm'))
                            <span class="help-block" style="color: #ff3f3f">
                                <b>{{ $errors->first('ten_dm') }}</b>
                            </span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Cập nhật danh mục
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
