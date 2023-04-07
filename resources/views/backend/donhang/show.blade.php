<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
<title>Quản lý đơn hàng</title>
@endsection @section('css')
<link href="{{ asset('frontend/css/select2.min.css') }}" rel="stylesheet" />

@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Chi tiết đơn hàng </b></h2>
</div>
@endsection @section('title-content')
<ol
    class="breadcrumb float-sm-right"
    style="padding: 8px 16px; margin: 12px auto; height: 1%"
>
    <li class="breadcrumb-item">
        <a href="{{ route('donhang.index') }}">Đơn hàng</a>
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
                <div class="col-sm-12" style="float: right">
                    @if($dhang->trang_thai=='Đang chờ xử lý')
                    <a
                        class="btn btn-danger action_huy float-right m-2"
                        data-url="{{ route('donhang.huy', ['id' => $dhang->id]) }}"
                    >
                        Huỷ đơn
                    </a>
                    <a
                        class="btn btn-primary float-right m-2"
                        href="{{ route('donhang.xacnhan', ['id' => $dhang->id]) }}"
                    >
                        Xác nhận
                    </a>
                    @else
                    <a
                        target="_blank"
                        class="btn btn-primary float-right m-2"
                        href="{{ route('donhang.indonhang', ['id' => $dhang->id]) }}"
                    >
                        In đơn hàng
                    </a>
                    @endif
                </div>
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
                <div class="tbl-fixed">
                    <div class="col-md-12">
                        <table class="table" style="min-width: max-content">
                            <tr>
                                <th>STT</th>
                                <th>ID đơn hàng</th>
                                <th>Tên sản phẩm</th>
                                <th>Hình ảnh</th>
                                <th>Số lượng</th>
                                <th>Giá bán</th>
                                <th>Thành tiền</th>
                                <th>Ngày tạo</th>
                            </tr>
                            @php $count = 1; @endphp @foreach(
                            $dhang->DonHangChiTiet as $dhct)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>
                                    {{$dhct->don_hang_id }}
                                </td>
                                <td>{{ optional($dhct->SanPham)->ten_sp }}</td>
                                <td>
                                    <img
                                        class="list_sp_img_150"
                                        src="{{ optional($dhct->SanPham)->hinh_anh_chinh}}"
                                    />
                                </td>
                                <td>
                                    {{$dhct->so_luong_ban}}
                                </td>
                                <td>
                                    {{number_format($dhct->gia,0,",",".")}} đ
                                </td>
                                <td>
                                    {{number_format($dhct->thanh_tien,0,",",".")}}
                                    đ
                                </td>

                                <td>
                                    {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $dhct->created_at)->format('H:i:s d/m/Y')}}
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <br />
            <h5>Ghi chú:</h5>
            @foreach($dhang as $dh) @if(!empty($dh->ghi_chu))
            {{$dh->ghi_chu}}
            @endif @endforeach
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
