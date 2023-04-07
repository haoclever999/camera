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
            >&nbsp; Tên
        </label>
        <input type="radio" id="sdt" name="don_hang" value="sdt" required />
        <label
            for="sdt"
            style="
                font-weight: normal;
                vertical-align: middle;
                margin-right: 1em;
            "
            >&nbsp; SĐT
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
            >&nbsp; Địa chỉ
        </label>
        <input
            type="search"
            class="form-control bg-light border-0 small"
            placeholder="Tìm kiếm..."
            name="timkiem_dh"
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
                                <th>Hành động</th>
                            </tr>
                            @foreach($dhang as $dh)
                            <tr>
                                <td>{{ +(+$i) }}</td>
                                <td>{{$dh->ten_kh}}</td>
                                <td>{{$dh->sdt_kh}}</td>
                                <td>{{$dh->dia_chi_kh}}</td>
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
                        </table>
                    </div>
                </div>
                <div class="col-md-12">{!! $dhang->links()!!}</div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
