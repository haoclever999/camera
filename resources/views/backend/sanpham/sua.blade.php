<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
<title>Quản lý sản phẩm</title>
@endsection @section('css')
<link href="{{ asset('frontend/css/select2.min.css') }}" rel="stylesheet" />

@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Sửa sản phẩm </b></h2>
</div>
@endsection @section('title-content')
<ol
    class="breadcrumb float-sm-right"
    style="padding: 8px 16px; margin: 12px auto; height: 1%"
>
    <li class="breadcrumb-item">
        <a href="{{ route('sanpham.index') }}">Sản phẩm</a>
    </li>
    <li class="breadcrumb-item active">Sửa</li>
</ol>
@endsection @section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <i
                class="fas fa-exclamation-circle"
                style="font-size: 25px; color: red"
            ></i>
            Cập nhật sản phẩm thất bại. Hãy kiểm tra lại!
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>
        @endif
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form
                        action="{{ route('sanpham.update', ['id' => $sp->id]) }}"
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
                                    class="form-control{{ $errors->has('ten_sp') ? ' has-error' : '' }}"
                                    name="ten_sp"
                                    id="ten_sp"
                                    placeholder="Nhập tên sản phẩm"
                                    value="{{$sp->ten_sp}}"
                                    required
                                />
                                @if ($errors->has('ten_sp'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ $errors->first('ten_sp') }}</b>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="ten_sp" class="form-label">
                                    <b>Tên sản phẩm không dấu</b>
                                </label>
                                <input
                                    type="text"
                                    class="form-control"
                                    value="{{$sp->slug}}"
                                    disabled
                                />
                            </div>
                            <div class="form-group">
                                <label for="num_soluong" class="form-label">
                                    <b> Số lượng</b>
                                </label>
                                <input
                                    type="number"
                                    class="form-control{{ $errors->has('num_soluong') ? ' has-error' : '' }}"
                                    id="num_soluong"
                                    name="num_soluong"
                                    value="{{$sp->so_luong}}"
                                    maxlength="5"
                                    required
                                />
                                @if ($errors->has('num_soluong'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ $errors->first('num_soluong') }}</b>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="num_gia" class="form-label">
                                    <b>Giá</b>
                                </label>
                                <input
                                    type="number"
                                    class="form-control{{ $errors->has('num_gia') ? ' has-error' : '' }}"
                                    id="num_gia"
                                    name="num_gia"
                                    maxlength="9"
                                    value="{{$sp->gia}}"
                                    required
                                />
                                @if ($errors->has('num_gia'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ $errors->first('num_gia') }}</b>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="form-label">
                                    <b>Nhập tag cho sản phẩm</b>
                                </label>
                                <select
                                    name="opt_tagsp[]"
                                    class="form-control{{ $errors->has('opt_tagsp') ? ' has-error' : '' }} tag_select2"
                                    multiple="multiple"
                                    required
                                >
                                    @foreach($sp->SanPhamTag as $tagItem )
                                    <option value="{{ $tagItem->id }}" selected>
                                        {{ $tagItem->ten_tag }}
                                    </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('opt_tagsp'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ $errors->first('opt_tagsp') }}</b>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6" style="float: right">
                            <div class="form-group">
                                <label class="form-label">
                                    <b>Chọn khuyến mãi</b>
                                </label>
                                <select
                                    class="form-control{{ $errors->has('opt_km') ? ' has-error' : '' }}"
                                    name="opt_km"
                                >
                                    <option selected value="">
                                        -Chọn khuyến mãi-
                                    </option>
                                    {!! $KmOpt !!}
                                </select>
                                @if ($errors->has('opt_km'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ $errors->first('opt_km') }}</b>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="form-label">
                                    <b>Chọn thương hiệu</b>
                                </label>
                                <select
                                    class="form-control{{ $errors->has('opt_th') ? ' has-error' : '' }} "
                                    name="opt_th"
                                    required
                                >
                                    <option selected value="">
                                        -Chọn thương hiệu-
                                    </option>
                                    {!! $ThOpt !!}
                                </select>
                                @if ($errors->has('opt_th'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ $errors->first('opt_th') }}</b>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="form-label"
                                    ><b>Chọn danh mục</b></label
                                >
                                <select
                                    class="form-control{{ $errors->has('opt_dm') ? ' has-error' : '' }} "
                                    name="opt_dm"
                                    required
                                >
                                    <option selected value="">
                                        -Chọn danh mục-
                                    </option>
                                    {!! $htmlOpt !!}
                                </select>
                                @if ($errors->has('opt_dm'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ $errors->first('opt_dm') }}</b>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="ten_sp" class="form-label">
                                    <b>Đã bán: </b> <span>{{$sp->slug}}</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="ten_sp" class="form-label">
                                    <b>Lượt xem: </b>
                                    <span>{{$sp->luot_xem}}</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="ten_sp" class="form-label">
                                    <b>Người tạo: </b>
                                    <span>{{optional($sp->User)->ho_ten}}</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-md-12" style="float: left">
                            <div class="form-group">
                                <label for="fdaidien" class="form-label">
                                    <b>Ảnh đại diện</b>
                                </label>
                                <div class="col-md-3 fdaidien_container">
                                    <div class="row">
                                        <img
                                            class="sp_img_daidien"
                                            src="{{$sp->hinh_anh_chinh}}"
                                            alt="HaoNganTelecom"
                                        />
                                    </div>
                                </div>
                                <input
                                    type="file"
                                    class="form-control-file"
                                    id="fdaidien"
                                    name="fdaidien"
                                />
                            </div>
                            <div class="form-group">
                                <label for="fchitiet" class="form-label">
                                    <b>Ảnh chi tiết</b>
                                </label>
                                <div class="col-md-12 fchitiet_container">
                                    <div class="row">
                                        @foreach($sp->HinhAnh as $hanh)
                                        <div class="col-md-3">
                                            <img
                                                class="sp_img_chitiet"
                                                src="{{$hanh->hinh_anh}}"
                                                alt="HaoNganTelecom"
                                            />
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <input
                                    multiple
                                    type="file"
                                    class="form-control-file"
                                    id="fchitiet"
                                    name="fchitiet[]"
                                />
                            </div>
                            <div class="form-group">
                                <label for="txt_mota" class="form-label">
                                    <b>Mô tả</b>
                                </label>
                                <textarea
                                    class="form-control{{ $errors->has('opt_dm') ? ' has-error' : '' }} mota_editor"
                                    id="txt_mota"
                                    name="txt_mota"
                                >
                                {{$sp->mo_ta}}
                                </textarea
                                >@if ($errors->has('opt_dm'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ $errors->first('opt_dm') }}</b>
                                </span>
                                @endif
                            </div>
                            <button
                                style="float: left"
                                type="submit"
                                class="btn btn-primary"
                            >
                                Sửa
                            </button>
                        </div>
                        <br />
                        <br />
                        <br />
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
<script src="{{ asset('frontend/js/select2.min.js') }}"></script>
<script src="{{ asset('frontend/js/tinymce.min.js') }}"></script>
@endsection
