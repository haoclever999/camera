<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
<title>Quản lý danh mục</title>
@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Danh mục sản phẩm đã xóa </b></h2>
</div>

@endsection @section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <br />
            <div class="row">
                <div>
                    <div class="col-md-10" style="float: left">
                        @if($dm->count()>0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên danh mục</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dm as $d)
                                <tr>
                                    <td>{{ +(+$i) }}</td>
                                    <td>{{ $d-> ten_dm }}</td>
                                    <td>
                                        <a
                                            class="btn btn-success action_res"
                                            data-url="{{ route('danhmuc.restore', ['id' => $d->id]) }}"
                                        >
                                            Khôi phục
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div>
                            <a href="{{ route('danhmuc.index') }}">
                                <i> Quay lại trang danh mục </i>
                            </a>
                            <br />
                            <br />
                            <h4>Thùng rác trống</h4>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-12 phantrang" style="margin-top: 1rem">
                    {!! $dm->links()!!}
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
    // $(document).on("click", ".action_res", a);
    // function a(even) {
    //     even.preventDefault();
    //     alert("ok");
    // }
</script>
@endsection
