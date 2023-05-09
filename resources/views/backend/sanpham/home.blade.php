<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
<title>Quản lý sản phẩm</title>
@endsection @section('css')
<style>
    .timkiem {
        width: 25rem !important;
        margin-left: 1rem !important;
        right: -13rem !important;
        border: 0.1rem solid rgba(78, 115, 223, 0.25) !important;
        border-radius: 0.35rem !important;
    }
    .timkiem > .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
    }
</style>
@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Danh sách sản phẩm </b></h2>
</div>

<div class="input-group timkiem">
    <input
        type="search"
        class="form-control bg-light border-0 small"
        placeholder="Tìm kiếm..."
        name="timkiem_sp"
        id="timkiem_sp"
    />
</div>

@endsection @section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <!-- /.col -->
                <div class="col-sm-4">
                    <form>
                        <div class="form-group">
                            <select class="form-select input-sm" onchange="this.form.submit();" name="sapxep">
                                <option {{request('sapxep') == 'mac_dinh' ? 'selected' : ''}} value="mac_dinh"> Mặc định
                                </option>
                                <option {{request('sapxep') == 'a_z' ? 'selected' : ''}} value="a_z"> Tên sản phẩm (A - Z) </option>
                                <option {{request('sapxep') == 'z_a' ? 'selected' : ''}} value="z_a"> Tên sản phẩm (Z - A) </option>
                                <option {{request('sapxep') == 'thap_cao' ? 'selected' : ''}} value="thap_cao"> Giá sản phẩm (Thấp &gt; Cao)
                                </option>
                                <option {{request('sapxep')=='cao_thap'?'selected' : ''}} value="cao_thap"> Giá sản phẩm (Cao &gt; Thấp)
                                </option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col-sm-8" style="float: right">
                    <form
                        action="{{ route('sanpham.nhapsp') }}"
                        method="post"
                        enctype="multipart/form-data"
                        style="display: none"
                        id="fnhapexcel"
                        class="float-right m-2"
                    >
                        @csrf
                        <input type="file" name="file" id="file" required />
                        <button type="submit" class="btn btn-primary">
                            Nhập
                        </button>
                    </form>
                    <a class="btn btn-success float-right m-2" id="nhapexcel">
                        Nhập sản phẩm
                    </a>
                    <form
                        action="{{ route('sanpham.nhap_hinhanh') }}"
                        method="post"
                        enctype="multipart/form-data"
                        style="display: none"
                        id="fnhap_hinhanh"
                        class="float-right m-2"
                    >
                        @csrf
                        <input
                            type="file"
                            name="file_Hinhanh"
                            id="file_Hinhanh"
                            required
                        />
                        <button type="submit" class="btn btn-primary">
                            Nhập
                        </button>
                    </form>
                    <a
                        class="btn btn-success float-right m-2"
                        id="nhap_hinhanh"
                    >
                        Nhập hình ảnh chi tiết
                    </a>
                    <a
                        href="{{ route('sanpham.getThem') }}"
                        class="btn btn-primary float-right m-2"
                        id="themsp"
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
                        <table
                            class="table"
                            style="min-width: max-content; margin-left: -2em"
                        >
                            <thead>
                                <tr>
                                    <th style="width: 3em">STT</th>
                                    <th style="width: 18em">Tên sản phẩm</th>
                                    <th style="width: 8em">Hình ảnh</th>
                                    <th style="width: 7.5em">Giá bán</th>
                                    <th style="width: 6.2em">Danh mục</th>
                                    <th style="width: 7.5em">Thương hiệu</th>
                                    <th style="width: 8.2em">Ngày cập nhật</th>
                                    <th style="width: 6.8em; padding-right: 0"> Hành động </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sp as $s)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{$s->ten_sp}}</td>
                                    <td>
                                        <img
                                            class="list_sp_img_150"
                                            src="{{$s->hinh_anh_chinh}}"
                                        />
                                    </td>
                                    <td>
                                        {{number_format($s->gia_ban,0,",",".")}}
                                        đ
                                    </td>

                                    <td>{{optional($s->DanhMuc)->ten_dm}}</td>
                                    <td>
                                        {{optional($s->ThuongHieu)->ten_thuong_hieu}}
                                    </td>

                                    <td>
                                        {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $s->updated_at)->format('H:i:s d/m/Y')}}
                                    </td>
                                    <td>
                                        <a
                                            style="
                                                width: 100%;
                                                padding: 3px 8px;
                                                margin: 3px;
                                            "
                                            class="btn btn-primary"
                                            href="{{ route('sanpham.chitiet', ['id' => $s->id]) }}"
                                        >
                                            Chi tiết
                                        </a>
                                        <br />
                                        <a
                                            style="
                                                width: 100%;
                                                padding: 3px 8px;
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
                                                width: 100%;
                                                padding: 3px 8px;
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
                            </tbody>
                        </table>
                        <div id="khongtimthay"></div>
                    </div>
                </div>
                <div class="col-md-12 phantrang" style="margin-top: 1rem">
                    {!! $sp->links()!!}
                </div>
                <div style="margin-bottom: 1rem"></div>
                <br />
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
        $("#nhapexcel").click(function () {
            document.getElementById("fnhapexcel").style.display = "block";
            document.getElementById("nhapexcel").style.display = "none";
            document.getElementById("themsp").style.display = "none";
            document.getElementById("fnhap_hinhanh").style.display = "none";
            document.getElementById("nhap_hinhanh").style.display = "none";
        });

        $("#nhap_hinhanh").click(function () {
            document.getElementById("fnhap_hinhanh").style.display = "block";
            document.getElementById("nhap_hinhanh").style.display = "none";
            document.getElementById("fnhapexcel").style.display = "none";
            document.getElementById("nhapexcel").style.display = "none";
            document.getElementById("themsp").style.display = "none";
        });

        $("#timkiem_sp").val("");

        $("#timkiem_sp").on("keyup", function (e) {
            e.preventDefault();

            let timkiem_sp = $("#timkiem_sp").val();
            $.ajax({
                url: "{{ route('sanpham.timkiem') }}",
                method: "GET",
                data: { timkiem_sp: timkiem_sp },
                success: function (res) {
                    $("tbody").html(res);
                    $(".phantrang").hide();
                    if (res.status === "Không tìm thấy") {
                        $("#khongtimthay").html(
                            "<h4>Không tìm thấy kết quả</h4>"
                        );
                        $("thead").hide();
                    } else {
                        $("#khongtimthay").html("");
                        $("thead").show();
                    }
                    if (timkiem_sp == "") $(".phantrang").show();
                },
            });
        });
    });
</script>
@endsection
