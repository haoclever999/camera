<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
<title>Quản lý thương hiệu</title>
@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Cập nhật thương hiệu </b></h2>
</div>
@endsection @section('title-content')
<ol
    class="breadcrumb float-sm-right"
    style="padding: 8px 16px; margin: 12px auto; height: 1%"
>
    <li class="breadcrumb-item">
        <a href="{{ route('thuonghieu.index') }}">Thương hiệu</a>
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
            Cập nhật thương hiệu thất bại!
        </div>
        @endif
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <form
                        action="{{ route('thuonghieu.update', ['id' => $th->id] ) }}"
                        method="post"
                        enctype="multipart/form-data"
                    >
                        @csrf
                        <div class="form-group">
                            <label for="ten_thuong_hieu" class="form-label"
                                >Tên thương hiệu</label
                            >
                            <input
                                type="text"
                                class="form-control @error('ten_thuong_hieu') is-invalid @enderror"
                                id="ten_thuong_hieu"
                                name="ten_thuong_hieu2"
                                value="{{ $th->ten_thuong_hieu}}"
                                onchange="changeName()"
                                placeholder="Nhập tên thương hiệu"
                            />
                            @if ($errors->has('ten_thuong_hieu'))
                            <span class="help-block" style="color: #ff3f3f">
                                <b>{{ $errors->first('ten_thuong_hieu') }}</b>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="logo_thuong_hieu" class="form-label">
                                <b> Logo thương hiệu</b>
                            </label>
                            <input
                                type="file"
                                class="form-control-file"
                                id="logo_thuong_hieu"
                                name="logo_thuong_hieu"
                                accept="image/jpg, image/png, image/jpeg"
                                onchange="preview(event)"
                            />
                            <div
                                class="logo_container col-md-3"
                                id="container_preview"
                            >
                                <img
                                    id="img_logo"
                                    class="img_logo"
                                    src="{{$th->logo}}"
                                />
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Cập nhật thương hiệu
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
    function preview(event) {
        var img_preview = document.getElementById("img_logo");
        img_preview.src = URL.createObjectURL(event.target.files[0]);
    }
    function changeName() {
        document
            .getElementById("ten_thuong_hieu")
            .setAttribute("name", "ten_thuong_hieu");
    }
</script>
@endsection
