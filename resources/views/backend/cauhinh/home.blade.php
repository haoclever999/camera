<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
<title>Quản lý cấu hình</title>
@endsection @section('css')
<style>
    .timkiem {
        width: 25rem !important;
        margin-left: 1rem !important;
        right: -15.3rem !important;
        border: 0.1rem solid rgba(78, 115, 223, 0.25) !important;
        border-radius: 0.35rem !important;
    }
    .timkiem > .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
    }
</style>
@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Danh sách cấu hình</b></h2>
</div>

<div class="input-group timkiem">
    <input
        type="search"
        class="form-control bg-light border-0 small"
        placeholder="Tìm kiếm..."
        name="timkiem_cauhinh"
        id="timkiem_cauhinh"
    />
</div>

@endsection @section('content')
<!-- Content Wrapper. Contains page content -->
<div
    class="content-wrapper content container-fluid"
    style="padding-left: 10px; padding-right: 10px"
>
    <!-- Main content -->
    <div class="row">
        <div>
            <div class="col-md-8" style="float: left">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="1%">STT</th>
                            <th width="22%">Tên cấu hình</th>
                            <th width="44%">Giá trị</th>
                            <th width="23%">Ngày cập nhật</th>
                            <th width="10%">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cauhinh as $ch)
                        <tr>
                            <td>{{ +(+$i) }}</td>
                            <td style="text-align: left">
                                {{ $ch-> ten }}
                            </td>
                            <td style="text-align: left">
                                {{ $ch-> gia_tri }}
                            </td>
                            <td>
                                {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $ch->updated_at)->format('H:i:s d/m/Y') }}
                            </td>
                            <td>
                                <a
                                    style="
                                        width: 88px;
                                        padding: 3px 10px;
                                        margin: 3px;
                                    "
                                    class="btn btn-warning"
                                    href="{{ route('cauhinh.getSua', ['id' => $ch->id]) }}"
                                >
                                    Cập nhật
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div id="khongtimthay"></div>
            </div>
            <div class="col-md-4" style="float: right">
                <h2 class="m-0"><b>Thêm cấu hình </b></h2>
                <br />
                <form action="{{ route('cauhinh.postThem') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="ten" class="form-label">
                            <b>Tên cấu hình</b>
                        </label>
                        <input
                            type="text"
                            class="form-control @error('ten') is-invalid @enderror"
                            id="ten"
                            name="ten"
                            value="{{ old('ten') }}"
                            placeholder="Nhập tên cấu hình"
                            required
                        />
                        @if ($errors->has('ten'))
                        <span class="help-block" style="color: #ff3f3f">
                            <b>{{ $errors->first('ten') }}</b>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="gia_tri" class="form-label">
                            <b>Giá trị của cấu hình</b>
                        </label>
                        <input
                            type="text"
                            class="form-control @error('gia_tri') is-invalid @enderror"
                            id="gia_tri"
                            name="gia_tri"
                            value="{{ old('gia_tri') }}"
                            placeholder="Nhập giá trị của cấu hình"
                            required
                        />
                        @if ($errors->has('gia_tri'))
                        <span class="help-block" style="color: #ff3f3f">
                            <b>{{ $errors->first('gia_tri') }}</b>
                        </span>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Thêm cấu hình
                    </button>
                </form>
            </div>
        </div>
        <div class="col-md-12 phantrang" style="margin-top: 1rem">
            {!! $cauhinh->links()!!}
        </div>
        <div style="margin-bottom: 1rem"></div>
    </div>
    <!-- /.row -->

    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection @section('js')
<script>
    $(document).ready(function () {
        $("#timkiem_cauhinh").val("");

        $("#timkiem_cauhinh").on("keyup", function (e) {
            e.preventDefault();

            let timkiem_cauhinh = $("#timkiem_cauhinh").val();
            $.ajax({
                url: "{{ route('cauhinh.timkiem') }}",
                method: "GET",
                data: { timkiem_cauhinh: timkiem_cauhinh },
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
                    if (timkiem_cauhinh == "") $(".phantrang").show();
                },
            });
        });
    });
</script>
@endsection
