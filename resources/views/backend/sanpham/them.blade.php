<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
<title>Quản lý sản phẩm</title>
@endsection @section('css')
<link href="{{ asset('frontend/css/select2.min.css') }}" rel="stylesheet" />

@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Thêm sản phẩm </b></h2>
</div>
@endsection @section('title-content')
<ol
    class="breadcrumb float-sm-right"
    style="padding: 8px 16px; margin: 12px auto; height: 1%"
>
    <li class="breadcrumb-item">
        <a href="{{ route('sanpham.index') }}">Sản phẩm</a>
    </li>
    <li class="breadcrumb-item active">Thêm</li>
</ol>
@endsection @section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form
                        action="{{ route('sanpham.postThem') }}"
                        method="post"
                        enctype="multipart/form-data"
                    >
                        @csrf
                        <div class="col-md-6" style="float: left">
                            <div class="form-group">
                                <label for="ten_sp" class="form-label">
                                    <b>Tên sản phẩm</b>
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('ten_sp') is-invalid @enderror"
                                    name="ten_sp"
                                    id="ten_sp"
                                    value="{{ old('ten_sp') }}"
                                    placeholder="Nhập tên sản phẩm"
                                    required
                                />
                                @if ($errors->has('ten_sp'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ $errors->first('ten_sp') }}</b>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="num_so_luong" class="form-label">
                                    <b>Số lượng</b>
                                </label>
                                <input
                                    type="number"
                                    class="form-control @error('num_so_luong') is-invalid @enderror"
                                    id="num_so_luong"
                                    name="num_so_luong"
                                    value="{{ old('num_so_luong') }}"
                                    max="999999"
                                    min="1"
                                    step="1"
                                    placeholder="Nhập số lượng"
                                    required
                                />
                            </div>

                            <div class="form-group">
                                <label for="num_gia_nhap" class="form-label">
                                    <b>Giá nhập (đ)</b>
                                </label>
                                <input
                                    type="number"
                                    class="form-control @error('num_gia_nhap') is-invalid @enderror"
                                    id="num_gia_nhap"
                                    name="num_gia_nhap"
                                    value="{{ old('num_gia_nhap') }}"
                                    max="999999999"
                                    min="1000"
                                    step="1"
                                    placeholder="Nhập giá nhập"
                                    required
                                />
                            </div>
                            <div class="form-group">
                                <label for="num_gia_ban" class="form-label">
                                    <b>Giá bán (đ)</b>
                                </label>
                                <input
                                    type="number"
                                    class="form-control @error('num_gia_ban') is-invalid @enderror"
                                    id="num_gia_ban"
                                    name="num_gia_ban"
                                    value="{{ old('num_gia_ban') }}"
                                    max="999999999"
                                    min="1000"
                                    step="1"
                                    placeholder="Nhập giá bán"
                                    required
                                />
                                @if ($errors->has('num_gia_ban'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ $errors->first('num_gia_ban') }}</b>
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="num_giam_gia" class="form-label">
                                    <b>Giảm giá (%)</b>
                                </label>
                                <input
                                    type="number"
                                    class="form-control @error('num_giam_gia') is-invalid @enderror"
                                    id="num_giam_gia"
                                    name="num_giam_gia"
                                    value="{{ old('num_giam_gia') }}"
                                    max="100"
                                    min="0"
                                    step="1"
                                    placeholder="Nhập giảm giá"
                                    required
                                />
                            </div>
                        </div>
                        <div class="col-md-6" style="float: right">
                            <div class="form-group">
                                <label for="num_bao_hanh" class="form-label">
                                    <b>Bảo hành (tháng)</b>
                                </label>
                                <input
                                    type="number"
                                    class="form-control @error('num_bao_hanh') is-invalid @enderror"
                                    name="num_bao_hanh"
                                    id="num_bao_hanh"
                                    value="{{ old('num_bao_hanh') }}"
                                    placeholder="Nhập bảo hành"
                                    max="99"
                                    min="0"
                                    step="1"
                                    required
                                />
                            </div>
                            <div class="form-group">
                                <label class="form-label">
                                    <b>Nhập tag cho sản phẩm</b>
                                </label>
                                <select
                                    name="opt_tagsp[]"
                                    class="form-control @error('opt_tagsp') is-invalid @enderror tag_select"
                                    multiple="multiple"
                                ></select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <b>Chọn thương hiệu</b>
                                </label>
                                <select
                                    class="form-control @error('opt_th') is-invalid @enderror"
                                    name="opt_th"
                                    required
                                >
                                    <option disabled selected value="">
                                        - Chọn thương hiệu -
                                    </option>
                                    {!! $ThOpt !!}
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">
                                    <b>Chọn danh mục</b>
                                </label>
                                <select
                                    class="form-control @error('opt_dm') is-invalid @enderror"
                                    name="opt_dm"
                                    required
                                >
                                    <option disabled selected value="">
                                        - Chọn danh mục -
                                    </option>
                                    {!! $DmOpt !!}
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-12" style="float: left">
                            <div class="form-group">
                                <label for="fdaidien" class="form-label">
                                    <b> Ảnh đại diện</b>
                                </label>
                                <input
                                    type="file"
                                    class="form-control-file"
                                    id="fdaidien"
                                    name="fdaidien"
                                    accept="image/jpg, image/png, image/jpeg"
                                    onchange="preview(event)"
                                    required
                                />
                                <div
                                    class="fdaidien_container col-md-3"
                                    id="container_preview"
                                ></div>
                            </div>
                            <div class="form-group">
                                <label for="fchitiet" class="form-label">
                                    <b>Ảnh chi tiết</b>
                                </label>
                                <input
                                    type="file"
                                    class="form-control-file"
                                    id="fchitiet"
                                    name="fchitiet[]"
                                    required
                                    onchange="preview_Multiple()"
                                    multiple
                                    accept="image/jpg, image/png, image/jpeg, video/mp4"
                                />
                                <div class="col-md-12 fchitiet_container">
                                    <div
                                        class="row"
                                        id="container_previewMultiple"
                                    ></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="txt_mo_ta" class="form-label">
                                    <b>Mô tả</b>
                                </label>
                                <textarea
                                    class="form-control @error('txt_mo_ta') is-invalid @enderror mo_ta_editor"
                                    id="txt_mo_ta"
                                    name="txt_mo_ta"
                                    required
                                >
                                {{ old("txt_mo_ta") }} 
                                </textarea>
                            </div>

                            <div class="form-group">
                                <label for="txt_tinh_nang" class="form-label">
                                    <b>Tính năng</b>
                                </label>
                                <textarea
                                    class="form-control @error('txt_tinh_nang') is-invalid @enderror mo_ta_editor"
                                    id="txt_tinh_nang"
                                    name="txt_tinh_nang"
                                    required
                                >
                                {{ old("txt_tinh_nang") }}
                            </textarea
                                >
                            </div>
                            <button
                                style="float: left"
                                type="submit"
                                class="btn btn-primary"
                            >
                                Thêm sản phẩm
                            </button>
                        </div>
                    </form>
                </div>
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
    CKEDITOR.replace("txt_mo_ta");
    CKEDITOR.replace("txt_tinh_nang");

    function preview(event) {
        var image = document.createElement("img");
        image.setAttribute("class", "sp_img_dai_dien");
        image.setAttribute("id", "img_preview");

        document.getElementById("container_preview").appendChild(image);

        var img_preview = document.getElementById("img_preview");
        img_preview.src = URL.createObjectURL(event.target.files[0]);
    }

    var images = [];
    function preview_Multiple() {
        var img_previewMultiple = document.getElementById("fchitiet").files;
        for (i = 0; i < img_previewMultiple.length; i++) {
            images.push({
                url: URL.createObjectURL(img_previewMultiple[i]),
            });
        }
        document.getElementById("container_previewMultiple").innerHTML =
            show_previewMultiple();
    }

    function show_previewMultiple() {
        var img = "";
        images.forEach((i) => {
            img +=
                ` <div id="pre_Multiple">
                    <img
                        class="sp_img_chi_tiet"
                        src="` +
                i.url +
                `"
                    />
                </div>`;
        });
        return img;
    }
</script>
@endsection
