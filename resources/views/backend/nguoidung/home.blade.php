@extends('layouts.admin') @section('title')
<title>Quản lý người dùng</title>
@endsection @section('css')
<style>
    .timkiem {
        width: 25rem !important;
        margin-left: 1rem !important;
        right: -12.6rem !important;
        border: 0.1rem solid rgba(78, 115, 223, 0.25) !important;
        border-radius: 0.35rem !important;
    }
    .timkiem > .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
    }
</style>
@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Danh sách người dùng </b></h2>
</div>
<div class="input-group timkiem">
    <input
        type="search"
        class="form-control bg-light border-0 small"
        placeholder="Tìm kiếm..."
        name="timkiem_nd"
        id="timkiem_nd"
    />
</div>

@endsection @section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <a
                        href="{{ route('nguoidung.getThem') }}"
                        class="btn btn-primary float-right m-2"
                    > 
                    Thêm người dùng 
                    </a>
                </div>
                <div class="tbl-fixed">
                    <div class="col-md-12">
                        <table class="table" style="min-width: max-content">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Người dùng</th>
                                    <th>Email</th>
                                    <th>Quyền</th>
                                    <th>Ngày cập nhật</th>
                                    <th>Trạng thái</th>
                                    <th>Khóa</th>
                                    <th>Cập nhật quyền</th>
                                    <th>Xóa</th>
                                </tr>
                            </thead> 
                            <tbody>
                                @foreach($users as $u)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $u->ho_ten }}</td>
                                        <td>{{ $u->email }}</td>
                                        <td>{{ $u->quyen }}</td>
                                        <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $u->updated_at)->format('H:i:s d/m/Y') }}</td>
                                        @if($u->trang_thai==1)
                                            <td> Kích hoạt </td>
                                        @else
                                            <td> Khóa </td>                                            
                                        @endif
                                        @if($u->quyen!="Quản trị")
                                            @if($u->trang_thai==1)
                                                <td> 
                                                    <form action="{{ route('nguoidung.trangthai', ['id' => $u->id]) }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name = "khoa" value="0">
                                                        <button type="submit" class="btn btn-danger action_edit" >Khóa</button>
                                                    </form>
                                                </td>
                                            @else
                                                <td>
                                                    <form action="{{ route('nguoidung.trangthai', ['id' => $u->id]) }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name = "khoa" value="1">
                                                        <button type="submit" class="btn btn-primary">Kích hoạt</button>
                                                    </form>
                                                </td>                                            
                                            @endif
                                        @else
                                        <td></td>
                                        @endif
                                        <td>
                                            <form action="{{ route('nguoidung.postcapnhatquyen', ['id' => $u->id]) }}" method="post" style="display: none;" class="fcapnhatquyen">
                                                @csrf
                                                <select
                                                    id="opt_quyen"
                                                    name="opt_quyen"
                                            >
                                                    <option {{$u->quyen=="Quản trị" ?'selected':''}} value="Quản trị">Quản trị</option>
                                                    <option {{$u->quyen=="Nhân viên" ?'selected':''}} value="Nhân viên">Nhân viên</option>
                                                    <option {{$u->quyen=="Khách hàng" ?'selected':''}} value="Khách hàng">Khách hàng</option>
                                                </select>
                                                
                                                <button style="
                                                    min-width: max-content;
                                                    padding: 3px 12px;
                                                    margin: 3px;" 
                                                    type="submit" class="btn btn-warning"> Cập nhật
                                                </button>
                                            </form>                              
                                        
                                            <a                                         
                                                style="
                                                    min-width: max-content;
                                                    padding: 3px 12px;
                                                    margin: 3px;
                                                "
                                                class="btn btn-warning capnhatquyen"
                                            >
                                                
                                                Cập nhật 
                                            </a>                       
                                        </td>
                                       
                                        <td>
                                            <a 
                                                class="btn btn-danger action_del" 
                                                style="
                                                        min-width: max-content;
                                                        padding: 3px 12px;
                                                        margin: 3px;
                                                    "
                                                href="" 
                                                data-url="{{ route('nguoidung.xoa', ['id' => $u->id]) }}" 
                                                >
                                                    Xóa
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        <table>
                        <div id="khongtimthay"></div>
                    </div>
                </div>
                <div class="col-md-12 phantrang" style="margin-top: 1rem"> {!! $users->links()!!} </div>
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
        $("#timkiem_nd").val("");

        $("#timkiem_nd").on("keyup", function (e) {
            e.preventDefault();

            let timkiem_nd = $("#timkiem_nd").val();
            $.ajax({
                url: "{{ route('nguoidung.timkiem') }}",
                method: "GET",
                data: { timkiem_nd: timkiem_nd },
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
                    if (timkiem_nd == "") $(".phantrang").show();
                },
            });
        });
        $("table").on('click','.capnhatquyen',function(){
            $("table").find(">tbody > tr").each(function(){
                $(this).find("td:eq(7) >.fcapnhatquyen").hide(); 
                $(this).find("td:eq(7) >.capnhatquyen").show(); 
            });
            $(this).closest("tr").find("td:eq(7) >.fcapnhatquyen").show(); 
            $(this).closest("tr").find("td:eq(7) >.capnhatquyen").hide(); 
        });
    });
</script>
@endsection
