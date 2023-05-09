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
               
                <div class="col-sm-2">
                    <form>
                        <div class="form-group">
                            <select class="form-select input-sm" onchange="this.form.submit();" name="sapxep">
                                <option {{request('sapxep') == 'mac_dinh' ? 'selected' : ''}} value="mac_dinh"> Mặc định </option>
                                <option {{request('sapxep') == 'cho_xu_ly' ? 'selected' : ''}} value="cho_xu_ly"> Đang chờ xử lý </option>
                                <option {{request('sapxep') == 'xac_nhan' ? 'selected' : ''}} value="xac_nhan"> Đã xác nhận </option>
                                <option {{request('sapxep') == 'van_chuyen' ? 'selected' : ''}} value="van_chuyen"> Đang vận chuyển </option>
                                <option {{request('sapxep') == 'giao' ? 'selected' : ''}} value="giao"> Đã giao </option>
                                <option {{request('sapxep') == 'huy' ? 'selected' : ''}} value="huy"> Đã huỷ </option>
                                <option {{request('sapxep') == 'xoa' ? 'selected' : ''}} value="xoa"> Đã xoá </option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col-sm-8">
                    <form>
                        <div class="form-group row">
                            <label style="padding-top: 1%; width: 12%;" class=" control-label" for="tu_ngay">Từ ngày</label>
                            <input type="date" class="col-md-3 form-control" name="tu_ngay" id="tu_ngay" value="{{request('tu_ngay') ?? ''}}">
                            
                            <label style="padding-top: 1%; width: 14%;" class="control-label" for="den_ngay">Đến ngày</label>
                            <input type="date" class="col-md-3 form-control" name="den_ngay" id="den_ngay" value="{{request('den_ngay') ?? ''}}">

                            <button type="submit" class="col-md-1 btn btn-primary" style="margin-left: 2%; width: max-content;">
                                Lọc
                            </button>
                        </div>                        
                    </form>
                </div>
                <div class="col-sm-2" style="float: right; margin-top: -1%;">
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
                        @if(count($dhang)>0)
                        <table class="table" style="min-width: max-content">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên khách hàng</th>
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
                                    <td>{{ ++$i }}</td>
                                    <td>{{$dh->ten_kh}}</td>
                                    <td>{{$dh->tong_so_luong}}</td>
                                    <td>
                                        {{number_format($dh->tong_tien,0,",",".")}}
                                    </td>
                                    <td>
                                        {{$dh->hinh_thuc}}
                                    </td>
                                    @if($dh->trang_thai=="Đang chờ xử lý")
                                    <td style="color: rgb(17, 136, 192);">{{$dh->trang_thai}}</td>
                                    @elseif($dh->trang_thai=="Đã xoá" || $dh->trang_thai=="Đã huỷ đơn")
                                    <td style="color: rgba(255, 0, 0,0.8)">{{$dh->trang_thai}}</td>
                                    @else
                                    <td>{{$dh->trang_thai}}</td>
                                    @endif
                                    <td>
                                        {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $dh->created_at)->format('H:i:s d/m/Y')}}
                                    </td>

                                    <td>
                                        <a
                                            style="
                                                min-width: 80px;
                                                padding: 3px 12px;
                                                margin: 3px;
                                            "
                                            class="btn btn-primary"
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
                                                min-width: 80px;
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
                        @else
                        <div>
                            <h4>Không có đơn hàng</h4>
                        </div>
                        @endif
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
        
        let now = new Date();
        let y = now.getFullYear();
        let m = now.getMonth() + 1;
        let d = now.getDate();

        m = m < 10 ? "0" + m : m;
        d = d < 10 ? "0" + d : d;
        let today=y + "-" + m + "-" + d;
        if($("input[type=date]").val()=='')
            $("input[type=date]").val(today);
        $("input[type=date]").change(function(){
            let tu_ngay = $("input#tu_ngay").val();
            let den_ngay = $("input#den_ngay").val();
            if(den_ngay < tu_ngay)
                alert("từ ngày phải nhỏ hơn đến ngày ");
        })
       
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
