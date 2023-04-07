@extends('layouts.admin') @section('title')
<title>Quản lý người dùng</title>
@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Danh sách người dùng </b></h2>
</div>
<form
    action="{{ route('nguoidung.timkiem') }}"
    class="d-none d-sm-inline-block form-inline ml-md-3 my-2 my-md-0 mw-100 navbar-search"
>
    @csrf
    <div class="input-group">
        <input
            type="search"
            class="form-control bg-light border-0 small"
            placeholder="Tìm kiếm..."
            name="timkiem_nd"
        />
        <button class="btn btn-primary" type="submit">
            <i class="fas fa-search fa-sm"></i>
        </button>
    </div>
</form>
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

                                    @if($id_sua==$u->id && $capnhatquyen=='capnhatquyen')
                                        <td>
                                            <form action="{{ route('nguoidung.postcapnhatquyen', ['id' => $id_sua]) }}" method="post">
                                                @csrf
                                                <select
                                                    id="opt_quyen"
                                                    name="opt_quyen"
                                                >
                                                @if($u->quyen=="Quản trị") 
                                                    <option selected value="Quản trị">Quản trị</option>
                                                    <option value="Nhân viên">Nhân viên</option>
                                                    <option value="Khách hàng">Khách hàng</option>
                                                @elseif($u->quyen=="Nhân viên")
                                                    <option value="Quản trị">Quản trị</option>
                                                    <option selected value="Nhân viên">Nhân viên</option>
                                                    <option  value="Khách hàng">Khách hàng</option>
                                                @else
                                                    <option value="Quản trị">Quản trị</option>
                                                    <option value="Nhân viên">Nhân viên</option>
                                                    <option selected value="Khách hàng">Khách hàng</option>
                                                @endif
                                                </select>
                                                
                                                <button style="
                                                    min-width: max-content;
                                                    padding: 3px 12px;
                                                    margin: 3px;" 
                                                    type="submit" class="btn btn-warning"> Cập nhật
                                                </button>
                                            </form>                              
                                        </td>
                                    @else
                                        <td>
                                            <a                                         
                                                style="
                                                    min-width: max-content;
                                                    padding: 3px 12px;
                                                    margin: 3px;
                                                "
                                                class="btn btn-warning"
                                                href="{{ route('nguoidung.getcapnhatquyen', ['id' => $u->id]) }}"
                                            >
                                                
                                                Cập nhật 
                                            </a>                       
                                        </td>
                                    @endif
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
                        <table>
                    </div>
                </div>
                <div class="col-md-12">{!! $users->links()!!}</div>
                
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection