<!-- resources/views/child.blade.php -->

@extends('layouts.admin') @section('title')
<title>Quản lý khuyến mãi</title>
@endsection @section('title-action')
<div class="title-action">
    <h2 class="m-0"><b>Danh sách khuyến mãi </b></h2>
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
                <!--xem lai toggle btn  -->

                <div class="col-md-12">
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
                    >
                        <i class="fa fa-check" style="color: #d1a400"></i>
                        {{Session::get('mgs-update')}}
                    </div>
                    @endif

                    <div class="col-md-6" style="float: left">
                        <table class="table">
                            <tr>
                                <th>STT</th>
                                <th>Khuyến mãi (%)</th>
                                <th>Ngày cập nhật</th>
                                <th>Hành động</th>
                            </tr>
                            @foreach($km as $k)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $k-> khuyenmai }}</td>
                                <td>
                                    {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $k->updated_at)->format('H:i:s d/m/Y') }}
                                </td>
                                <td>
                                    <a
                                        style="
                                            min-width: max-content;
                                            padding: 3px 12px;
                                            margin: 3px;
                                        "
                                        class="btn btn-warning"
                                        href="{{ route('khuyenmai.edit', ['id' => $k->id]) }}"
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
                                        data-url="{{ route('khuyenmai.destroy', ['id' => $k->id]) }}"
                                    >
                                        <i class="bi bi-trash"></i>
                                        Xóa
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>

                    <div class="col-md-5" style="float: right">
                        <h2 class="m-0"><b>Thêm khuyến mãi </b></h2>
                        <br />
                        <form
                            action="{{ route('khuyenmai.store') }}"
                            method="post"
                        >
                            @csrf
                            <div class="form-group">
                                <label for="khuyenmai" class="form-label">
                                    <b>Nhập khuyến mãi (%)</b>
                                </label>
                                <input
                                    type="number"
                                    class="form-control @error('khuyenmai') is-invalid @enderror"
                                    id="khuyenmai"
                                    name="khuyenmai"
                                    min="0"
                                    value="{{ old('khuyenmai') }}"
                                    placeholder="Nhập khuyến mãi"
                                    required
                                />
                                @if ($errors->has('khuyenmai'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ $errors->first('khuyenmai') }}</b>
                                </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">
                                Thêm khuyến mãi
                            </button>
                        </form>
                    </div>
                </div>

                <div class="col-md-12">{!! $km->links()!!}</div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
