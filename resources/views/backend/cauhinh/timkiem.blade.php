<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
<title>Quản lý cấu hình</title>
@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Kết quả tìm kiếm</b></h2>
</div>
<form
    action="{{ route('cauhinh.timkiem') }}"
    class="d-none d-sm-inline-block form-inline ml-md-3 my-2 my-md-0 mw-100 navbar-search"
    style="width: 30rem"
>
    @csrf

    <div class="input-group">
        <input
            type="radio"
            id="cau_hinh_key"
            name="cau_hinh"
            value="cau_hinh_key"
            checked
            required
        />
        <label
            for="cau_hinh_key"
            style="
                font-weight: normal;
                vertical-align: middle;
                margin-right: 1em;
            "
            >&nbsp; Tên
        </label>
        <input
            type="radio"
            id="cau_hinh_value"
            name="cau_hinh"
            value="cau_hinh_value"
            required
        />
        &nbsp;
        <label
            for="cau_hinh_value"
            style="
                font-weight: normal;
                vertical-align: middle;
                margin-right: 1em;
            "
        >
            Giá trị
        </label>
        <input
            type="text"
            class="form-control bg-light border-0 small"
            placeholder="Tìm kiếm..."
            name="timkiem_th"
        />
        <button class="btn btn-primary" type="submit">
            <i class="fas fa-search fa-sm"></i>
        </button>
    </div>
</form>
@endsection @section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid" style="padding-left: -24px">
            <div class="row">
                <div>
                    <div class="col-md-8" style="float: left">
                        @if(count($timkiem)>0)
                        <table class="table">
                            <tr>
                                <th>STT</th>
                                <th>Tên cấu hình</th>
                                <th>Giá trị</th>
                                <th>Ngày cập nhật</th>
                                <th>Hành động</th>
                            </tr>
                            @foreach($timkiem as $tk)
                            <tr>
                                <td>{{ +(+$i) }}</td>
                                <td>{{ $tk-> cau_hinh_key }}</td>
                                <td>{{ $tk-> cau_hinh_value }}</td>
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
                                        href="{{ route('cauhinh.getSua', ['id' => $tk->id]) }}"
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
                                        data-url="{{ route('cauhinh.xoa', ['id' => $tk->id]) }}"
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
                        <h2 class="m-0"><b>Thêm cấu hình </b></h2>
                        <br />
                        <form
                            action="{{ route('cauhinh.postThem') }}"
                            method="post"
                        >
                            @csrf
                            <div class="form-group">
                                <label for="cau_hinh_key" class="form-label">
                                    <b>Tên cấu hình</b>
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('cau_hinh_key') is-invalid @enderror"
                                    id="cau_hinh_key"
                                    name="cau_hinh_key"
                                    value="{{ old('cau_hinh_key') }}"
                                    placeholder="Nhập tên cấu hình"
                                    required
                                />
                                @if ($errors->has('cau_hinh_key'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ $errors->first('cau_hinh_key') }}</b>
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="cau_hinh_value" class="form-label">
                                    <b>Giá trị của cấu hình</b>
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('cau_hinh_value') is-invalid @enderror"
                                    id="cau_hinh_value"
                                    name="cau_hinh_value"
                                    value="{{ old('cau_hinh_value') }}"
                                    placeholder="Nhập giá trị của cấu hình"
                                    required
                                />
                                @if ($errors->has('cau_hinh_value'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b
                                        >{{ $errors->first('cau_hinh_value') }}</b
                                    >
                                </span>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Thêm cấu hình
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
@endsection
