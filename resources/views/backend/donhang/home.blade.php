<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
<title>Quản lý đơn hàng</title>
@endsection @section('css')
<style>
    .timkiem {
        width: 25rem !important;
        margin-left: 1rem !important;
        right: -13.3rem !important;
        border: 0.1rem solid rgba(78, 115, 223, 0.25) !important;
        border-radius: 0.35rem !important;
    }
    .timkiem > .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
    }
</style>
@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Danh sách đơn hàng </b></h2>
</div>

<div class="input-group timkiem">
    <input
        type="search"
        class="form-control bg-light border-0 small"
        placeholder="Tìm kiếm..."
        name="timkiem_dh"
        id="timkiem_dh"
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
                <div class="col-sm-12" style="float: right">
                    <a
                        href="{{ route('donhang.xuatdonhnag') }}"
                        class="btn btn-success float-right m-2"
                    >
                        Xuất excel
                    </a>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="tbl-fixed">
                    <div class="col-md-12">
                        <table class="table" style="min-width: max-content">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên khách hàng</th>
                                    <th>Số điện thoại</th>
                                    <th>Địa chỉ</th>
                                    <th>Tổng số lượng</th>
                                    <th>Tổng tiền</th>
                                    <th>Hình thức</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dhang as $dh)
                                <tr>
                                    <td>{{ +(+$i) }}</td>
                                    <td>{{$dh->ten_kh}}</td>
                                    <td>{{$dh->sdt_kh}}</td>
                                    <td style="text-align: left">
                                        {{$dh->dia_chi_kh}}
                                    </td>
                                    <td>{{$dh->tong_so_luong}}</td>
                                    <td>
                                        {{number_format($dh->tong_tien,0,",",".")}}
                                    </td>
                                    <td>
                                        {{$dh->hinh_thuc}}
                                    </td>

                                    <td>{{$dh->trang_thai}}</td>
                                    <td>
                                        {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $dh->created_at)->format('H:i:s d/m/Y')}}
                                    </td>

                                    <td>
                                        <a
                                            style="
                                                min-width: 110px;
                                                padding: 3px 12px;
                                                margin: 3px;
                                            "
                                            class="btn btn-success"
                                            href="{{ route('donhang.chitiet', ['id' => $dh->id]) }}"
                                        >
                                            Chi tiết
                                        </a>
                                        <br />
                                        @if(auth()->check() &&
                                        auth()->user()->quyen=='Quản trị' &&
                                        $dh->trang_thai!='Đã xoá')
                                        <a
                                            style="
                                                min-width: 110px;
                                                padding: 3px 12px;
                                                margin: 3px;
                                            "
                                            class="btn btn-danger action_del"
                                            href=""
                                            data-url="{{ route('donhang.xoa', ['id' => $dh->id]) }}"
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
                    {!! $dhang->links()!!}
                </div>
                <div style="margin-bottom: 1rem"></div>
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
        $("#timkiem_dh").val("");

        $("#timkiem_dh").on("keyup", function (e) {
            e.preventDefault();

            let timkiem_dh = $("#timkiem_dh").val();
            $.ajax({
                url: "{{ route('donhang.timkiem') }}",
                method: "GET",
                data: { timkiem_dh: timkiem_dh },
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
                    if (timkiem_dh == "") $(".phantrang").show();
                },
            });
        });
    });
</script>
@endsection
