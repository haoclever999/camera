<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
<title>Quản lý đơn hàng</title>
@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Danh sách đơn hàng </b></h2>
</div>
<form
    action="{{ route('donhang.timkiem') }}"
    class="d-none d-sm-inline-block form-inline ml-md-3 my-2 my-md-0 mw-100 navbar-search"
    style="width: 30rem"
>
    @csrf
    <div class="input-group">
        <input
            type="radio"
            id="ten_kh"
            name="don_hang"
            value="ten_kh"
            checked
            required
        />
        <label
            for="ten_kh"
            style="
                font-weight: normal;
                vertical-align: middle;
                margin-right: 1em;
            "
        >
            &nbsp; Tên
        </label>
        <input type="radio" id="sdt" name="don_hang" value="sdt" required />
        <label
            for="sdt"
            style="
                font-weight: normal;
                vertical-align: middle;
                margin-right: 1em;
            "
        >
            &nbsp; SĐT
        </label>
        <input
            type="radio"
            id="dia_chi"
            name="don_hang"
            value="dia_chi"
            required
        />
        <label
            for="dia_chi"
            style="
                font-weight: normal;
                vertical-align: middle;
                margin-right: 1em;
            "
        >
            &nbsp; Địa chỉ
        </label>
        <input
            type="text"
            class="form-control bg-light border-0 small"
            placeholder="Tìm kiếm..."
            name="timkiem_th"
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
                <div class="tbl-fixed">
                    <div class="col-md-12">
                        @if(count($timkiem)>0)
                        <table class="table" style="min-width: max-content">
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
                                <th>Xác nhận / Hủy</th>
                                <th>Hành động</th>
                            </tr>
                            @foreach($timkiem as $tk)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{$tk->ten_kh}}</td>
                                <td>{{$tk->sdt_kh}}</td>
                                <td>{{$tk->dia_chi_kh}}</td>
                                <td>{{$tk->tong_so_luong}}</td>
                                <td>
                                    {{number_format($tk->tong_tien,0,",",".")}}
                                </td>
                                <td>
                                    {{$tk->hinh_thuc}}
                                </td>

                                <td>{{$tk->trang_thai}}</td>
                                <td>
                                    {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $tk->created_at)->format('H:i:s d/m/Y')}}
                                </td>
                                <td>
                                    @if($tk->trang_thai=='Đang chờ xử lý')
                                    <a
                                        style="
                                            min-width: 110px;
                                            padding: 3px 12px;
                                            margin: 3px;
                                        "
                                        class="btn btn-primary"
                                        href="{{ route('donhang.xacnhan', ['id' => $tk->id]) }}"
                                    >
                                        Xác nhận
                                    </a>
                                    <br />
                                    <a
                                        style="
                                            min-width: 110px;
                                            padding: 3px 12px;
                                            margin: 3px;
                                        "
                                        class="btn btn-danger action_huy"
                                        data-url="{{ route('donhang.huy', ['id' => $tk->id]) }}"
                                    >
                                        Huỷ đơn
                                    </a>
                                    <br />
                                    @endif
                                </td>
                                <td>
                                    <a
                                        style="
                                            min-width: 110px;
                                            padding: 3px 12px;
                                            margin: 3px;
                                        "
                                        class="btn btn-success"
                                        href="{{ route('donhang.show', ['id' => $tk->id]) }}"
                                    >
                                        Chi tiết
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
                                        data-url="{{ route('donhang.destroy', ['id' => $tk->id]) }}"
                                    >
                                        Xóa
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        @else
                        <h4>Không tìm thấy kết quả</h4>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">{!! $timkiem->links()!!}</div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
