<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
<title>Quản lý khuyến mãi</title>
@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Cập nhật khuyến mãi </b></h2>
</div>
@endsection @section('title-content')
<ol
    class="breadcrumb float-sm-right"
    style="padding: 8px 16px; margin: 12px auto; height: 1%"
>
    <li class="breadcrumb-item">
        <a href="{{ route('khuyenmai.index') }}">Khuyến mãi</a>
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
            Cập nhật khuyến mãi thất bại!
        </div>
        @endif
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <form
                        action="{{ route('khuyenmai.update', ['id' => $km->id] ) }}"
                        method="post"
                    >
                        @csrf
                        <div class="form-group">
                            <label for="khuyenmai" class="form-label"
                                >Nhập khuyến mãi (%)</label
                            >
                            <input
                                type="number"
                                class="form-control @error('khuyenmai') is-invalid @enderror"
                                id="khuyenmai"
                                name="khuyenmai"
                                min="0"
                                max="100"
                                step="1"
                                value="{{ $km->khuyenmai}}"
                                required
                            />
                            @if ($errors->has('khuyenmai'))
                            <span class="help-block" style="color: #ff3f3f">
                                <b>{{ $errors->first('khuyenmai') }}</b>
                            </span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Cập nhật khuyến mãi
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
