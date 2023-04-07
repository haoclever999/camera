<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
<title>Quản lý sản phẩm</title>
@endsection @section('css')
<link rel="stylesheet" href="{{ asset('frontend/css/camera.css') }}" />
@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Danh sách sản phẩm </b></h2>
</div>
<form
    action="{{ route('sanpham.timkiem') }}"
    class="d-none d-sm-inline-block form-inline ml-md-3 my-2 my-md-0 mw-100 navbar-search"
    style="width: 35rem"
>
    @csrf
    <div class="input-group">
        <input
            type="radio"
            id="ten_sp"
            name="san_pham"
            value="ten_sp"
            checked
            required
        />
        <label
            for="ten_sp"
            style="
                font-weight: normal;
                vertical-align: middle;
                margin-right: 1em;
            "
        >
            &nbsp; Tên
        </label>
        <input
            type="radio"
            id="danh_muc"
            name="san_pham"
            value="danh_muc"
            required
        />
        <label
            for="danh_muc"
            style="
                font-weight: normal;
                vertical-align: middle;
                margin-right: 1em;
            "
        >
            &nbsp; Danh mục
        </label>
        <input
            type="radio"
            id="thuong_hieu"
            name="san_pham"
            value="thuong_hieu"
            required
        />
        <label
            for="thuong_hieu"
            style="
                font-weight: normal;
                vertical-align: middle;
                margin-right: 1em;
            "
        >
            &nbsp; Thương hiệu
        </label>
        <input
            type="search"
            class="form-control bg-light border-0 small"
            placeholder="Tìm kiếm..."
            name="timkiem_sp"
        />
        <button class="btn btn-primary" type="submit">
            <i class="fas fa-search fa-sm"></i>
        </button>
    </div>
</form>
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
                        href="{{ route('sanpham.xuatsp') }}"
                        class="btn btn-success float-right m-2"
                    >
                        Xuất excel danh sách
                    </a>
                    <form
                        action="{{ route('sanpham.nhapsp') }}"
                        method="post"
                        id="fnhapexcel"
                        class="float-right m-2"
                    >
                        @csrf
                        <input type="file" accept=".xlsx" />
                        <button type="submit" class="btn btn-info">Nhập</button>
                    </form>
                    <a
                        onclick="HienFormNhap()"
                        id="nhapexcel"
                        class="btn btn-info float-right m-2"
                    >
                        Nhập excel sản phẩm
                    </a>
                    <a
                        href="{{ route('sanpham.getThem') }}"
                        class="btn btn-primary float-right m-2"
                    >
                        Thêm sản phẩm
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
        <div class="container-fluid" style="padding-left: -24px">
            <div class="row">
                <div class="tbl-fixed">
                    <div class="col-md-12">
                        <table class="table" style="min-width: max-content">
                            <tr>
                                <th>STT</th>
                                <th>Tên sản phẩm</th>
                                <th>Hình ảnh</th>
                                <th>Giá bán</th>

                                <th>Danh mục</th>
                                <th>Thương hiệu</th>
                                <th>Ngày cập nhật</th>
                                <th>Hành động</th>
                            </tr>
                            @foreach($sp as $s)
                            <tr>
                                <td>{{ +(+$i) }}</td>
                                <td>{{$s->ten_sp}}</td>
                                <td>
                                    <img
                                        class="list_sp_img_150"
                                        src="{{$s->hinh_anh_chinh}}"
                                    />
                                </td>
                                <td>
                                    {{number_format($s->gia_ban,0,",",".")}} đ
                                </td>

                                <td>{{optional($s->DanhMuc)->ten_dm}}</td>
                                <td>
                                    {{optional($s->ThuongHieu)->ten_thuong_hieu}}
                                </td>

                                <td>
                                    {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $s->updated_at)->format('H:i:s d/m/Y')}}
                                </td>
                                <td>
                                    <!-- sua lai -->
                                    <a
                                        style="
                                            min-width: 110px;
                                            padding: 3px 12px;
                                            margin: 3px;
                                        "
                                        class="btn btn-success"
                                        href="{{ route('sanpham.chitiet', ['id' => $s->id]) }}"
                                    >
                                        Chi tiết
                                    </a>
                                    <br />
                                    <a
                                        style="
                                            min-width: 110px;
                                            padding: 3px 12px;
                                            margin: 3px;
                                        "
                                        class="btn btn-warning"
                                        href="{{ route('sanpham.getSua', ['id' => $s->id]) }}"
                                    >
                                        Cập nhật
                                    </a>
                                    <br />
                                    @if(auth()->check() &&
                                    auth()->user()->quyen=='Quản trị')
                                    <a
                                        style="
                                            min-width: 110px;
                                            padding: 3px 12px;
                                            margin: 3px;
                                        "
                                        class="btn btn-danger action_del"
                                        href=""
                                        data-url="{{ route('sanpham.xoa', ['id' => $s->id]) }}"
                                    >
                                        Xóa
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="col-md-12">{!! $sp->links()!!}</div>
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
    $(document).ready(function () {
        document.getElementById("fnhapexcel").style.display = "none";
    });
    function HienFormNhap() {
        document.getElementById("fnhapexcel").style.display = "block";
        document.getElementById("nhapexcel").style.display = "none";
    }
</script>
@endsection
