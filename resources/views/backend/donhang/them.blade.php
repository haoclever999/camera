<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
<title>Quản lý danh mục</title>
@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Thêm đơn hàng </b></h2>
</div>
@endsection @section('title-content')
<ol
    class="breadcrumb float-sm-right"
    style="padding: 8px 16px; margin: 12px auto; height: 1%"
>
    <li class="breadcrumb-item">
        <a href="{{ route('donhang.index') }}">Đơn hàng</a>
    </li>
    <li class="breadcrumb-item active">Thêm</li>
</ol>
@endsection @section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <form>
                        <div class="form-group">
                            <label for="txt_ten_dm" class="form-label"
                                >Tên danh mục</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="txttendm"
                                placeholder="Nhập tên danh mục"
                            />
                        </div>
                        <div class="form-group">
                            <label for="txt_slug" class="form-label"
                                >Slug</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="txt_slug"
                                placeholder="Nhập slug"
                            />
                        </div>
                        <div class="form-group">
                            <label for="opt_dm_cha" class="form-label"
                                >Chọn danh mục cha</label
                            >
                            <select class="form-control" name="opt_dm_cha">
                                <option selected>Chọn danh mục cha</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Submit
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
