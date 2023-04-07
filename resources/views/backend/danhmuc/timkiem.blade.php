<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
<title>Quản lý danh mục</title>
@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Kết quả tìm kiếm </b></h2>
</div>
<form
    action="{{ route('danhmuc.timkiem') }}"
    class="d-none d-sm-inline-block form-inline ml-md-3 my-2 my-md-0 mw-100 navbar-search"
>
    @csrf
    <div class="input-group">
        <input
            type="search"
            class="form-control bg-light border-0 small"
            placeholder="Tìm kiếm..."
            name="timkiem_dm"
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
        <div class="container-fluid">
            <br />
            <div class="row">
                <div>
                    <div class="col-md-8" style="float: left">
                        @if(count($timkiem)>0)
                        <table class="table">
                            <tr>
                                <th>STT</th>
                                <th>Tên danh mục</th>
                                <th>Ngày cập nhật</th>
                                <th>Hành động</th>
                            </tr>
                            @foreach($timkiem as $tk)
                            <tr>
                                <td>{{ +(+$i) }}</td>
                                <td>{{ $tk-> ten_dm }}</td>
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
                                        href="{{ route('danhmuc.getSua', ['id' => $tk->id]) }}"
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
                                        data-url="{{ route('danhmuc.xoa', ['id' => $tk->id]) }}"
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
                        <h2 class="m-0"><b>Thêm danh mục </b></h2>
                        <br />
                        <form
                            action="{{ route('danhmuc.postThem') }}"
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
