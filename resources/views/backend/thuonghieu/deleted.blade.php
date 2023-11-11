<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
    <title>Quản lý thương hiệu</title>
    @endsection @section('title-action')
    <div class="title-action">
        <h2 class="m-0"><b>Danh sách thương hiệu đã xóa </b></h2>
    </div>
    @endsection @section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <br />
                <div class="row">
                    <div class="col-md-12">
                        @if ($th->count() > 0)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên thương hiệu</th>
                                        <th>Logo</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($th as $t)
                                        <tr>
                                            <td>{{ +(+$i) }}</td>
                                            <td>
                                                {{ $t->ten_thuong_hieu }}
                                            </td>
                                            <td>
                                                <img class="list_sp_img_150" src="{{ $t->logo }}" alt="HaoNganTelecom" />
                                            </td>
                                            <td>
                                                <a class="btn btn-success action_res"
                                                    data-url="{{ route('thuonghieu.restore', ['id' => $t->id]) }}">
                                                    Khôi phục
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div>
                                <a href="{{ route('thuonghieu.index') }}">
                                    <i> Quay lại trang thương hiệu </i>
                                </a>
                                <br />
                                <br />
                                <h4>Thùng rác trống</h4>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-12 phantrang" style="margin-top: 1rem">
                        {!! $th->links() !!}
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
@endsection
