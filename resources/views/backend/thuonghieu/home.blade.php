<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
<title>Quản lý thương hiệu</title>
@endsection @section('css')
<style>
    .timkiem {
        width: 25rem !important;
        margin-left: 1rem !important;
        right: -10.9rem !important;
        border: 0.1rem solid rgba(78, 115, 223, 0.25) !important;
        border-radius: 0.35rem !important;
    }
    .timkiem > .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
    }
</style>
@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Danh sách thương hiệu </b></h2>
</div>

<div class="input-group timkiem">
    <input
        type="search"
        class="form-control bg-light border-0 small"
        placeholder="Tìm kiếm..."
        name="timkiem_th"
        id="timkiem_th"
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
                <div class="col-md-12">
                    <div class="col-md-8" style="float: left">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="1%">STT</th>
                                    <th width="30%">Tên thương hiệu</th>
                                    <th width="28%">Logo</th>
                                    <th width="31%">Ngày cập nhật</th>
                                    <th width="10%">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($th as $t)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>
                                        {{ $t->ten_thuong_hieu}}
                                    </td>
                                    <td>
                                        <img
                                            class="list_sp_img_150"
                                            src="{{ $t->logo}}"
                                            alt="HaoNganTelecom"
                                        />
                                    </td>
                                    <td>
                                        {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $t->updated_at)->format('H:i:s d/m/Y') }}
                                    </td>
                                    <td>
                                        <a
                                            style="
                                                width: 88px;
                                                padding: 3px 10px;
                                                margin: 3px;
                                            "
                                            class="btn btn-warning"
                                            href="{{ route('thuonghieu.getSua', ['id' => $t->id]) }}"
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
                                            data-url="{{ route('thuonghieu.xoa', ['id' => $t->id]) }}"
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
                        <h2 class="m-0"><b>Thêm thương hiệu </b></h2>
                        <br />

                        <form
                            action="{{ route('thuonghieu.postthem') }}"
                            method="post"
                            enctype="multipart/form-data"
                        >
                            @csrf
                            <div class="form-group">
                                <label for="ten_thuong_hieu" class="form-label">
                                    <b> Tên thương hiệu </b>
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('ten_thuong_hieu') is-invalid @enderror"
                                    id="ten_thuong_hieu"
                                    name="ten_thuong_hieu"
                                    placeholder="Nhập tên thương hiệu"
                                    value="{{ old('ten_thuong_hieu') }}"
                                    required
                                />
                                @if ($errors->has('ten_thuong_hieu'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>
                                        {{ $errors->first('ten_thuong_hieu') }}
                                    </b>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label
                                    for="logo_thuong_hieu"
                                    class="form-label"
                                >
                                    <b> Logo thương hiệu</b>
                                </label>
                                <input
                                    type="file"
                                    class="form-control-file"
                                    id="logo_thuong_hieu"
                                    name="logo_thuong_hieu"
                                    accept="image/jpg, image/png, image/jpeg"
                                    required
                                />
                                <div
                                    class="logo_container col-md-3"
                                    id="container_preview"
                                    style="margin-top: 1rem"
                                ></div>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                Thêm thương hiệu
                            </button>
                        </form>
                    </div>
                </div>

                <div class="col-md-12 phantrang" style="margin-top: 1rem">
                    {!! $th->links()!!}
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
        $("#timkiem_th").val("");

        $("#timkiem_th").on("keyup", function (e) {
            e.preventDefault();

            let timkiem_th = $("#timkiem_th").val();
            $.ajax({
                url: "{{ route('thuonghieu.timkiem') }}",
                method: "GET",
                data: { timkiem_th: timkiem_th },
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
                    if (timkiem_th == "") $(".phantrang").show();
                },
            });
        });

        $("#logo_thuong_hieu").on("change", function (e) {
            if ($("#img_preview").length > 0) {
                $("#img_preview").remove();
            }
            $("#container_preview").append(
                '<image src="" class="sp_img_dai_dien" id="img_preview"/>'
            );

            $("#img_preview").attr(
                "src",
                URL.createObjectURL(e.target.files[0])
            );
        });
    });
</script>
@endsection
