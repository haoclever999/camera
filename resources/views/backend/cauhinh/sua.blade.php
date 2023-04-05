<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
<title>Quản lý cấu hình</title>
@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Cập nhật cấu hình </b></h2>
</div>
@endsection @section('title-content')
<ol
    class="breadcrumb float-sm-right"
    style="padding: 8px 16px; margin: 12px auto; height: 1%"
>
    <li class="breadcrumb-item">
        <a href="{{ route('cauhinh.index') }}">Cấu hình</a>
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
            >
            </i>
            Cập nhật cấu hình thất bại!
        </div>
        @endif
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <form
                        action="{{ route('cauhinh.postSua', ['id' => $cauhinh->id] ) }}"
                        method="post"
                    >
                        @csrf
                        <div class="form-group">
                            <label for="cau_hinh_key" class="form-label">
                                <b>Tên cấu hình</b>
                            </label>
                            <input
                                type="text"
                                class="form-control @error('cau_hinh_key') is-invalid @enderror"
                                id="cau_hinh_key"
                                name="cau_hinh_key2"
                                value="{{ $cauhinh->cau_hinh_key}}"
                                onchange="changeName()"
                                placeholder="Nhập tên cấu hình"
                                required
                            />
                            @if ($errors->has('cau_hinh_key'))
                            <span class="help-block" style="color: #ff3f3f">
                                <b>{{ $errors->first('cau_hinh_key') }}</b>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="cau_hinh_value" class="form-label">
                                <b>Giá trị của cấu hình</b>
                            </label>
                            <input
                                type="text"
                                class="form-control @error('cau_hinh_value') is-invalid @enderror"
                                id="cau_hinh_value"
                                name="cau_hinh_value"
                                value="{{ $cauhinh->cau_hinh_value}}"
                                placeholder="Nhập giá trị của cấu hình"
                                required
                            />
                            @if ($errors->has('cau_hinh_value'))
                            <span class="help-block" style="color: #ff3f3f">
                                <b>{{ $errors->first('cau_hinh_value') }}</b>
                            </span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Cập nhật cấu hình
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
@endsection @section('js')
<script>
    function changeName() {
        document
            .getElementById("cau_hinh_key")
            .setAttribute("name", "cau_hinh_key");
    }
</script>
@endsection
