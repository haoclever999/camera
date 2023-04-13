<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
<title>Quản lý danh mục</title>
@endsection @section('css')
<style>
    .timkiem {
        width: 25rem !important;
        margin-left: 1rem !important;
        right: -4.5rem !important;
        border: 0.1rem solid rgba(78, 115, 223, 0.25) !important;
        border-radius: 0.35rem !important;
    }
    .timkiem > .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
    }
</style>
@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Danh sách danh mục sản phẩm </b></h2>
</div>

<div class="input-group timkiem">
    <input
        type="search"
        class="form-control bg-light border-0 small"
        placeholder="Tìm kiếm..."
        name="timkiem_dm"
        id="timkiem_dm"
    />
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
                    <div class="col-md-8" style="float: left">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên danh mục</th>
                                    <th>Ngày cập nhật</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dm as $d)
                                <tr>
                                    <td>{{ +(+$i) }}</td>
                                    <td>{{ $d-> ten_dm }}</td>
                                    <td>
                                        {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $d->updated_at)->format('H:i:s d/m/Y') }}
                                    </td>
                                    <td>
                                        <a
                                            style="
                                                width: 88px;
                                                padding: 3px 10px;
                                                margin: 3px;
                                            "
                                            class="btn btn-warning"
                                            href="{{ route('danhmuc.getSua', ['id' => $d->id]) }}"
                                        >
                                            Cập nhật
                                        </a>
                                        @if(auth()->check() &&
                                        auth()->user()->quyen=='Quản trị')
                                        <a
                                            style="
                                                width: 88px;
                                                padding: 3px 10px;
                                                margin: 3px;
                                            "
                                            class="btn btn-danger action_del"
                                            href=""
                                            data-url="{{ route('danhmuc.xoa', ['id' => $d->id]) }}"
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
                    <div class="col-md-4" style="float: right">
                        <h2 class="m-0"><b>Thêm danh mục </b></h2>
                        <br />
                        <form
                            action="{{ route('danhmuc.postThem') }}"
                            method="post"
                        >
                            @csrf
                            <div class="form-group">
                                <label for="ten_dm" class="form-label">
                                    <b>Tên danh mục</b>
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('ten_dm') is-invalid @enderror"
                                    id="ten_dm"
                                    name="ten_dm"
                                    value="{{ old('ten_dm') }}"
                                    placeholder="Nhập tên danh mục"
                                    required
                                />
                                @if ($errors->has('ten_dm'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ $errors->first('ten_dm') }}</b>
                                </span>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Thêm danh mục
                            </button>
                        </form>
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
    $(document).ready(function () {
        $("#timkiem_dm").val("");

        $("#timkiem_dm").on("keyup", function (e) {
            e.preventDefault();

            let timkiem_dm = $("#timkiem_dm").val();
            $.ajax({
                url: "{{ route('danhmuc.timkiem') }}",
                method: "GET",
                data: { timkiem_dm: timkiem_dm },
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
                    if (timkiem_dm == "") $(".phantrang").show();
                },
            });
        });
    });
</script>
@endsection
