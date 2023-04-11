@extends('layouts.user') @section('title')
<title>Cửa Hàng Camera Quan Sát, Camera An Ninh, Camera Giám Sát</title>
@endsection @section('slider') @include('view-page.user.slider') @endsection
@section('content')
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <form
                        action="{{ route('nguoidung.postdoimatkhauUser', ['id' => $user->id] ) }}"
                        method="post"
                    >
                        @csrf

                        <div class="form-group">
                            <label for="email" class="form-label">
                                <b>Email</b>
                            </label>
                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                value="{{ $user->email }}"
                                style="cursor: no-drop"
                                disabled
                            />
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">
                                <b>Mật khẩu cũ</b>
                            </label>
                            <input
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="password"
                                name="password"
                                placeholder="Nhập mật khẩu"
                                required
                            />
                            @if ($errors->has('password'))
                            <span class="help-block" style="color: #ff3f3f">
                                <b>{{ $errors->first('password') }}</b>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password_new" class="form-label">
                                <b>Mật khẩu mới</b>
                            </label>
                            <input
                                type="password"
                                class="form-control @error('password_new') is-invalid @enderror"
                                id="password_new"
                                name="password_new"
                                placeholder="Nhập mật khẩu mới"
                                required
                            />
                            @if ($errors->has('password_new'))
                            <span class="help-block" style="color: #ff3f3f">
                                <b>{{ $errors->first('password_new') }}</b>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password_confirm" class="form-label">
                                <b>Nhập lại mật khẩu mới</b>
                            </label>
                            <input
                                type="password"
                                class="form-control @error('password_confirm') is-invalid @enderror"
                                id="password_confirm"
                                name="password_confirm"
                                placeholder="Nhập lại mật khẩu mới"
                                required
                            />
                            @if ($errors->has('password_confirm'))
                            <span class="help-block" style="color: #ff3f3f">
                                <b>{{ $errors->first('password_confirm') }}</b>
                            </span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Đổi mật khẩu
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

@endsection
