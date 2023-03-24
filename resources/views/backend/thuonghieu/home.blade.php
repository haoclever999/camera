<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
<title>Quản lý thương hiệu</title>
@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Danh sách thương hiệu </b></h2>
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
        <div class="container-fluid">
            <br />
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-6" style="float: left">
                        <table class="table">
                            <tr>
                                <th>STT</th>
                                <th>Tên thương hiệu</th>
                                <th>Ngày cập nhật</th>
                                <th>Hành động</th>
                            </tr>
                            @foreach($th as $t)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $t-> slug }}</td>
                                <td>
                                    {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $t->updated_at)->format('H:i:s d/m/Y') }}
                                </td>
                                <td>
                                    <a
                                        style="
                                            min-width: max-content;
                                            padding: 3px 12px;
                                            margin: 3px;
                                        "
                                        class="btn btn-warning"
                                        href="{{ route('thuonghieu.edit', ['id' => $t->id]) }}"
                                    >
                                        Cập nhật
                                    </a>
                                    <a
                                        style="
                                            min-width: max-content;
                                            padding: 3px 12px;
                                            margin: 3px;
                                        "
                                        class="btn btn-danger action_del"
                                        href=""
                                        data-url="{{ route('thuonghieu.destroy', ['id' => $t->id]) }}"
                                    >
                                        Xóa
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>

                    <div class="col-md-5" style="float: right">
                        <h2 class="m-0"><b>Thêm thương hiệu </b></h2>
                        <br />

                        <form
                            action="{{ route('thuonghieu.store') }}"
                            method="post"
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
                            <button type="submit" class="btn btn-primary">
                                Thêm thương hiệu
                            </button>
                        </form>
                    </div>
                </div>

                <div class="col-md-12">{!! $th->links()!!}</div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
