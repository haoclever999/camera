<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
    <title>Quản lý sản phẩm</title>
    @endsection @section('title-action')
    <div class="title-action">
        <h2 class="m-0"><b>Danh sách sản phẩm đã xóa </b></h2>
    </div>
    @endsection @section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid" style="padding-left: -24px">
                <div class="row">
                    <div class="tbl-fixed">
                        <div class="col-md-12">
                            @if ($sp->count() > 0)
                                <table class="table" style="min-width: max-content; margin-left: -2em">
                                    <thead>
                                        <tr>
                                            <th style="width: 3em">STT</th>
                                            <th style="width: 18em">Tên sản phẩm</th>
                                            <th style="width: 8em">Hình ảnh</th>
                                            <th style="width: 7.5em">Giá bán</th>
                                            <th style="width: 6.2em">Danh mục</th>
                                            <th style="width: 7.5em">Thương hiệu</th>
                                            <th style="width: 6.8em">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sp as $s)
                                            <tr>
                                                <td>{{ +(+$i) }}</td>
                                                <td>{{ $s->ten_sp }}</td>
                                                <td>
                                                    <img class="list_sp_img_150" src="{{ $s->hinh_anh_chinh }}" />
                                                </td>
                                                <td>
                                                    {{ number_format($s->gia_ban, 0, ',', '.') }}
                                                    đ
                                                </td>

                                                <td>{{ optional($s->DanhMuc)->ten_dm }}</td>
                                                <td>
                                                    {{ optional($s->ThuongHieu)->ten_thuong_hieu }}
                                                </td>
                                                <td>
                                                    <a class="btn btn-success action_res"
                                                        data-url="{{ route('sanpham.restore', ['id' => $s->id]) }}">
                                                        Khôi phục
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div>
                                    <a href="{{ route('sanpham.index') }}">
                                        <i> Quay lại trang sản phẩm </i>
                                    </a>
                                    <br />
                                    <br />
                                    <h3>Thùng rác trống</h3>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12 phantrang" style="margin-top: 1rem">
                        {!! $sp->links() !!}
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
@endsection
