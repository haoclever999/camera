<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
<title>Quản lý cấu hình</title>
@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Danh sách cấu hình</b></h2>
</div>
<form
    class="d-none d-sm-inline-block form-inline ml-md-3 my-2 my-md-0 mw-100 navbar-search"
>
    <div class="input-group">
        <input
            type="text"
            class="form-control bg-light border-0 small"
            placeholder="Search for..."
            aria-label="Search"
            aria-describedby="basic-addon2"
        />
        <div class="input-group-append">
            <button class="btn btn-primary" type="button">
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
        <div class="container-fluid" style="padding-left: -24px">
            <div class="row">
                <div>
                    <div class="col-md-8" style="float: left">
                        <table class="table">
                            <tr>
                                <th>STT</th>
                                <th>Tên</th>
                                <th>Giá trị</th>
                                <th>Ngày cập nhật</th>
                                <th>Hành động</th>
                            </tr>
                            @foreach($cauhinh as $ch)
                            <tr>
                                <td>{{ +(+$i) }}</td>
                                <td>{{ $ch-> config_key }}</td>
                                <td>{{ $ch-> config_value }}</td>
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
                                        href="{{ route('cauhinh.edit', ['id' => $ch->id]) }}"
                                    >
                                        Cập nhật
                                    </a>
                                    <a
                                        style="
                                            width: 88px;
                                            padding: 3px 10px;
                                            margin: 3px;
                                        "
                                        class="btn btn-danger action_del"
                                        href=""
                                        data-url="{{ route('cauhinh.destroy', ['id' => $ch->id]) }}"
                                    >
                                        Xóa
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="col-md-4" style="float: right">
                        <h2 class="m-0"><b>Thêm cấu hình </b></h2>
                        <br />
                        <form
                            action="{{ route('cauhinh.store') }}"
                            method="post"
                        >
                            @csrf
                            <div class="form-group">
                                <label for="config_key" class="form-label">
                                    <b>Tên cấu hình</b>
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('config_key') is-invalid @enderror"
                                    id="config_key"
                                    name="config_key"
                                    value="{{ old('config_key') }}"
                                    placeholder="Nhập tên cấu hình"
                                    required
                                />
                                @if ($errors->has('config_key'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ $errors->first('config_key') }}</b>
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="config_value" class="form-label">
                                    <b>Giá trị của cấu hình</b>
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('config_value') is-invalid @enderror"
                                    id="config_value"
                                    name="config_value"
                                    value="{{ old('config_value') }}"
                                    placeholder="Nhập giá trị của cấu hình"
                                    required
                                />
                                @if ($errors->has('config_value'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ $errors->first('config_value') }}</b>
                                </span>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Thêm cấu hình
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col-md-12">{!! $cauhinh->links()!!}</div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection