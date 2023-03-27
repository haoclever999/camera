<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
<title>Quản lý sản phẩm</title>
@endsection @section('css')
<link href="{{ asset('frontend/css/select2.min.css') }}" rel="stylesheet" />

@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Chi tiết sản phẩm </b></h2>
</div>
@endsection @section('title-content')
<ol
    class="breadcrumb float-sm-right"
    style="padding: 8px 16px; margin: 12px auto; height: 1%"
>
    <li class="breadcrumb-item">
        <a href="{{ route('sanpham.index') }}">Sản phẩm</a>
    </li>
    <li class="breadcrumb-item active">Chi tiết</li>
</ol>
@endsection @section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <!-- /.col -->
                <div class="col-sm-12" style="float: right">
                    <!-- Topbar Search -->
                    <a
                        href="{{ route('sanpham.edit', ['id' => $sp->id]) }}"
                        class="btn btn-warning float-right m-2"
                    >
                        Cập nhật sản phẩm
                    </a>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-6" style="float: left">
                        <div class="form-group">
                            <label class="form-label">
                                <b>Tên sản phẩm: </b>
                                <span>{{$sp->ten_sp}}</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <b>Tên sản phẩm không dấu: </b>
                                <span>{{$sp->slug}}</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <b>Số lượng: </b> <span>{{$sp->so_luong}}</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <b>Tồn kho: </b> <span>{{$sp->ton}}</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <b>Giá nhập: </b>
                                <span>{{$sp->gia_nhap}}</span> VNĐ
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <b>Giá bán: </b
                                ><span>{{$sp->gia_ban}}</span> VNĐ
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <b>Giảm giá: </b>
                                <span>{{$sp->giam_gia}}</span> %
                            </label>
                        </div>
                    </div>

                    <div class="col-md-6" style="float: right">
                        <div class="form-group">
                            <label class="form-label">
                                <b>Bảo hành: </b
                                ><span>{{$sp->bao_hanh}}</span> tháng
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <b>Lượt xem: </b><span>{{$sp->luot_xem}}</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <b>Lượt mua: </b><span>{{$sp->luot_mua}}</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <b>Tag cho sản phẩm: </b>
                                <span id="tag">
                                    @foreach($sp->SanPhamTag as $tagItem )
                                    {{ $tagItem->ten_tag }}, @endforeach
                                </span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <b>Thương hiệu: </b>
                                <span>
                                    {{$sp->ThuongHieu->ten_thuong_hieu}}
                                </span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <b>Danh mục: </b>
                                <span>
                                    {{$sp->DanhMuc->ten_dm}}
                                </span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <b>Người tạo: </b>
                                <span>
                                    {{$sp->User->ho_ten}}
                                </span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group col-md-12" style="float: left">
                        <div class="form-group">
                            <label class="form-label">
                                <b> Ảnh đại diện:</b>
                            </label>
                            <div class="fdaidien_container col-md-3">
                                <img
                                    class="sp_img_dai_dien"
                                    src="{{$sp->hinh_anh_chinh}}"
                                />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <b>Ảnh chi tiết: </b>
                            </label>
                            <div class="col-md-12 fchitiet_container">
                                <div class="row">
                                    @foreach($sp->HinhAnh as $hanh)
                                    <div id="pre_Multiple">
                                        <img
                                            class="sp_img_chi_tiet"
                                            src="{{$hanh->hinh_anh}}"
                                        />
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <b>Mô tả: </b>
                            </label>
                            <br />
                            {!!$sp->mo_ta!!}
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <b>Tính năng: </b>
                            </label>
                            <br />
                            {!!$sp->tinh_nang!!}
                        </div>
                    </div>
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
    const a = $("#tag").text();
    const b = a.lastIndexOf(",");
    window.addEventListener("load", (event) => {
        document.getElementById("tag").innerHTML = a.slice(0, b);
    });
</script>
@endsection
