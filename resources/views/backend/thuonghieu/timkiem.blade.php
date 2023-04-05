<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
<title>Quản lý thương hiệu</title>
@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Kết quả tìm kiếm </b></h2>
</div>
<form
    action="{{ route('thuonghieu.timkiem') }}"
    class="d-none d-sm-inline-block form-inline ml-md-3 my-2 my-md-0 mw-100 navbar-search"
>
    @csrf
    <div class="input-group">
        <input
            type="text"
            class="form-control bg-light border-0 small"
            placeholder="Tìm kiếm..."
            aria-describedby="basic-addon2"
            name="timkiem_th"
        />
        <div class="input-group-append">
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-search fa-sm"></i>
            </button>
        </div>
    </div>
</form>
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
                        @if(count($timkiem)>0)
                        <table class="table">
                            <tr>
                                <th>STT</th>
                                <th>Tên thương hiệu</th>
                                <th>Logo</th>
                                <th>Ngày cập nhật</th>
                                <th>Hành động</th>
                            </tr>
                            @foreach($timkiem as $tk)
                            <tr>
                                <td>{{ +(+$i) }}</td>
                                <td>{{ $tk->ten_thuong_hieu}}</td>
                                <td>
                                    <img
                                        class="list_sp_img_150"
                                        src="{{ $tk->logo}}"
                                        alt="HaoNganTelecom"
                                    />
                                </td>
                                <td>
                                    {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $tk->updated_at)->format('H:i:s d/m/Y') }}
                                </td>
                                <td>
                                    <a
                                        style="
                                            width: 88px;
                                            padding: 3px 10px;
                                            margin: 3px;
                                        "
                                        class="btn btn-warning"
                                        href="{{ route('thuonghieu.getSua', ['id' => $tk->id]) }}"
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
                                        data-url="{{ route('thuonghieu.xoa', ['id' => $tk->id]) }}"
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
                                    onchange="preview(event)"
                                    required
                                />
                                <div
                                    class="logo_container col-md-3"
                                    id="container_preview"
                                ></div>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                Thêm thương hiệu
                            </button>
                        </form>
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
@endsection @section('js')
<script>
    function preview(event) {
        var image = document.createElement("img");
        image.setAttribute("class", "sp_img_dai_dien");
        image.setAttribute("id", "img_preview");

        document.getElementById("container_preview").appendChild(image);

        var img_preview = document.getElementById("img_preview");
        img_preview.src = URL.createObjectURL(event.target.files[0]);
    }
</script>
@endsection
