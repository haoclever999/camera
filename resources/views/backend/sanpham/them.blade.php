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
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <i
                class="fas fa-exclamation-circle"
                style="font-size: 25px; color: red"
            ></i>
            Thêm sản phẩm thất bại. Hãy kiểm tra lại!
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
                        action="{{ route('sanpham.store') }}"
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
                                <label for="num_soluong" class="form-label">
                                    <b>Số lượng</b>
                                </label>
                                <input
                                    type="number"
                                    class="form-control @error('num_soluong') is-invalid @enderror"
                                    id="num_soluong"
                                    name="num_soluong"
                                    value="{{ old('num_soluong') }}"
                                    onKeyPress="if(this.value.length==6) return false;"
                                    max="999999"
                                    min="1"
                                    placeholder="Nhập số lượng"
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
                                    class="form-control @error('num_gia') is-invalid @enderror"
                                    id="num_gia"
                                    name="num_gia"
                                    value="{{ old('num_gia') }}"
                                    onKeyPress="if(this.value.length==9 ) return false;"
                                    max="999999999"
                                    min="1000"
                                    placeholder="Nhập giá"
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
                                    class="form-control @error('opt_tagsp') is-invalid @enderror tag_select"
                                    multiple="multiple"
                                    value="{{ old('opt_tagsp') }}"
                                    required
                                ></select>
                                @if ($errors->has('opt_tagsp'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ $errors->first('opt_tagsp') }}</b>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="form-label">
                                    <b>Chọn khuyến mãi</b>
                                </label>
                                <select
                                    class="form-control @error('opt_km') is-invalid @enderror"
                                    name="opt_km"
                                    value="{{ old('opt_km') }}"
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
                                    class="form-control @error('opt_th') is-invalid @enderror"
                                    name="opt_th"
                                    value="{{ old('opt_th') }}"
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
                                <label class="form-label">
                                    <b>Chọn danh mục</b>
                                </label>
                                <select
                                    class="form-control @error('opt_dm') is-invalid @enderror"
                                    name="opt_dm"
                                    value="{{ old('opt_dm') }}"
                                    required
                                >
                                    <option selected value="">
                                        -Chọn danh mục-
                                    </option>
                                    {!! $DmOpt !!}
                                </select>
                                @if ($errors->has('opt_dm'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ $errors->first('opt_dm') }}</b>
                                </span>
                                @endif
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
                                    onKeyPress="if(this.value.length==2 ) return false;"
                                    max="99"
                                    min="0"
                                    required
                                />
                            </div>
                            <div class="form-group">
                                <label for="num_goc_camera" class="form-label">
                                    <b>Góc camera (độ)</b>
                                </label>
                                <input
                                    type="number"
                                    class="form-control @error('num_goc_camera') is-invalid @enderror"
                                    name="num_goc_camera"
                                    id="num_goc_camera"
                                    value="{{ old('num_goc_camera') }}"
                                    placeholder="Nhập góc camera"
                                    onKeyPress="if(this.value.length==3 ) return false;"
                                    max="360"
                                    min="0"
                                    required
                                />
                                @if ($errors->has('num_goc_camera'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b
                                        >{{ $errors->first('num_goc_camera') }}</b
                                    >
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="do_phan_giai" class="form-label">
                                    <b>Độ phân giải</b>
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('do_phan_giai') is-invalid @enderror"
                                    name="do_phan_giai"
                                    id="do_phan_giai"
                                    value="{{ old('do_phan_giai') }}"
                                    placeholder="Nhập độ phân giải"
                                    required
                                />
                                @if ($errors->has('do_phan_giai'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ $errors->first('do_phan_giai') }}</b>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="chuan_nen" class="form-label">
                                    <b>Chuẩn nén</b>
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('chuan_nen') is-invalid @enderror"
                                    name="chuan_nen"
                                    id="chuan_nen"
                                    value="{{ old('chuan_nen') }}"
                                    placeholder="Nhập chuẩn nén"
                                    required
                                />
                                @if ($errors->has('chuan_nen'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ $errors->first('chuan_nen') }}</b>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="dam_thoai" class="form-label">
                                    <b>Đàm thoại (chiều)</b>
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('dam_thoai') is-invalid @enderror"
                                    name="dam_thoai"
                                    id="dam_thoai"
                                    value="{{ old('dam_thoai') }}"
                                    placeholder="Nhập đàm thoại"
                                    required
                                />
                                @if ($errors->has('dam_thoai'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ $errors->first('dam_thoai') }}</b>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="nguon_dien" class="form-label">
                                    <b>Nguồn điện</b>
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('nguon_dien') is-invalid @enderror"
                                    name="nguon_dien"
                                    id="nguon_dien"
                                    value="{{ old('nguon_dien') }}"
                                    placeholder="Nhập nguồn điện"
                                    required
                                />
                                @if ($errors->has('nguon_dien'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ $errors->first('nguon_dien') }}</b>
                                </span>
                                @endif
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
                                    required
                                />
                                <div class="preview"></div>
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
                                    multiple
                                    accept="image/jpg, image/png, image/jpeg,video/mp4"
                                />
                                <div class="preview"></div>
                            </div>
                            <div class="form-group">
                                <label for="txt_mota" class="form-label">
                                    <b>Mô tả</b>
                                </label>
                                <textarea
                                    class="form-control @error('txt_mota') is-invalid @enderror mota_editor"
                                    id="txt_mota"
                                    value="{{ old('txt_mota') }}"
                                    name="txt_mota"
                                ></textarea
                                >@if ($errors->has('txt_mota'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ $errors->first('txt_mota') }}</b>
                                </span>
                                @endif
                            </div>
                        </div>
                        <button
                            style="float: left"
                            type="submit"
                            class="btn btn-primary"
                        >
                            Thêm
                        </button>
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
