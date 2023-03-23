<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
<title>Quản lý danh mục</title>
@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Danh sách danh mục sản phẩm </b></h2>
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
                <div>
                    @if(Session::has('mgs'))
                    <div
                        class="alert alert-success alert-dismissible fade show"
                    >
                        <i class="fa fa-check"></i>
                        {{Session::get('mgs')}}
                    </div>

                    @endif @if(Session::has('mgs-update'))
                    <div
                        class="alert alert-warning alert-dismissible fade show"
                        style="color: #d1a400"
                    >
                        <i class="fa fa-check"></i>
                        {{Session::get('mgs-update')}}
                    </div>
                    @endif

                    <div class="col-md-6" style="float: left">
                        <table class="table">
                            <tr>
                                <th>STT</th>
                                <th>Tên danh mục</th>
                                <th>Ngày cập nhật</th>
                                <th>Hành động</th>
                            </tr>
                            @foreach($dm as $d)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $d-> ten_dm }}</td>
                                <td>
                                    {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $d->updated_at)->format('H:i:s d/m/Y') }}
                                </td>
                                <td>
                                    <a
                                        style="
                                            min-width: max-content;
                                            padding: 3px 12px;
                                            margin: 3px;
                                        "
                                        class="btn btn-warning"
                                        href="{{ route('danhmuc.edit', ['id' => $d->id]) }}"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                        Sửa
                                    </a>
                                    <a
                                        style="
                                            min-width: max-content;
                                            padding: 3px 12px;
                                            margin: 3px;
                                        "
                                        class="btn btn-danger action_del"
                                        href=""
                                        data-url="{{ route('danhmuc.destroy', ['id' => $d->id]) }}"
                                    >
                                        <i class="bi bi-trash"></i> Xóa</a
                                    >
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="col-md-5" style="float: right">
                        <h2 class="m-0"><b>Thêm danh mục </b></h2>
                        <br />
                        <form
                            action="{{ route('danhmuc.store') }}"
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
                <div class="col-md-12">{!! $dm->links()!!}</div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
