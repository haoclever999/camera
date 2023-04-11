@extends('layouts.user') @section('title')
<title>Hồ sơ cá nhân</title>
@endsection @section('slider') @include('view-page.user.slider') @endsection
@section('content')

<div class="row margin-bottom-40" style="margin-top: 40px">
    @include('view-page.user.sidebar_menu')
    <div class="col-md-9 col-sm-7">
        <div class="col-md-7 col-sm-7">
            <h2 style="text-align: center"><b>Hồ sơ cá nhân</b></h2>
        </div>
        <div class="content">
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <i
                    class="fas fa-exclamation-circle"
                    style="font-size: 25px; color: red"
                ></i>
                Cập nhật hồ sơ thất bại!
            </div>
            @endif
            <div class="container-fluid">
                <div class="row product-list" style="min-height: 300px">
                    <div class="col-md-6">
                        <form
                            action="{{ route('nguoidung.posthosoUser', ['id' => $user->id] ) }}"
                            method="post"
                        >
                            @csrf

                            <div class="form-group">
                                <label for="ho_ten" class="form-label">
                                    <b>Tên người dùng</b>
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('ho_ten') is-invalid @enderror"
                                    id="ho_ten"
                                    name="ten_nd"
                                    placeholder="Nhập tên người dùng"
                                    onchange="changeName()"
                                    value="{{ $user->ho_ten }}"
                                    required
                                />
                                @if ($errors->has('ten_nd'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ $errors->first('ten_nd') }}</b>
                                </span>
                                @endif @if ($errors->has('ho_ten'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ $errors->first('ho_ten') }}</b>
                                </span>
                                @endif
                            </div>
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
                                <label for="sdt" class="form-label">
                                    <b>Số điện thoại</b>
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('sdt') is-invalid @enderror"
                                    id="sdt"
                                    name="sodt"
                                    onchange="changeSDT()"
                                    placeholder="Nhập số điện thoại"
                                    value="{{ $user->sdt }}"
                                    required
                                />
                                @if ($errors->has('sdt'))
                                <span class="help-block" style="color: #ff3f3f">
                                    <b>{{ $errors->first('sdt') }}</b>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="dia_chi" class="form-label">
                                    <b>Địa chỉ</b>
                                </label>
                                @if($dc[0]!="")
                    <div class="form-group col-md-12 col-sm-12 " style="padding-left: 10px;">
                        <div class="col-md-4 col-sm-4" style="padding-left: 0;">
                            <label for="opt_Tinh"> Chọn Tỉnh/Thành phố </label><br>
                            <select class="opt_select opt_Tinh" name="opt_Tinh" id="opt_Tinh" style="width: 160px; " required  >
                                <option value="">--Tỉnh/Thành phố--</option>
                                @foreach($tinh_tp as $tinh)
                                <option value="{{$tinh->id}}" {{$tinh->ten_tp==$dc[3] ?'selected':''}}>{{$tinh->ten_tp}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-4" style="padding-left: 0;">
                            <label for="opt_Huyen"> Chọn Quận/Huyện </label><br>
                            
                            <select class="opt_select opt_Huyen" name="opt_Huyen" id="opt_Huyen" style="width: 160px; margin-left: 0; " required>
                                @foreach($huyen as $h)
                                <option value="{{$h->id}}"{{$h->ten_qh==$dc[2]?'selected':''}}>{{$h->ten_qh}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-4" style="padding-left: 0; padding-right: 0;">
                             <label for="opt_Xa"> Chọn Xã phường/Thị trấn </label><br>
                            <select class="opt_Xa" name="opt_Xa" id="opt_Xa" style="width: 160px; " required>
                                @foreach($xa as $x)
                                <option value="{{$x->id}}"{{$x->ten_xa==$dc[1]?'selected':''}}>{{$x->ten_xa}}</option>
                                @endforeach
                            </select>
                        </div> 
                    </div>
                    @else
                    <div class="form-group col-md-12 col-sm-12 " style="padding-left: 10px;">
                        <div class="col-md-4 col-sm-4" style="padding-left: 0;">
                            <label for="opt_Tinh"> Chọn Tỉnh/Thành phố </label><br>
                            <select class="opt_select opt_Tinh" name="opt_Tinh" id="opt_Tinh" style="width: 160px; " required  >
                                <option value="">--Tỉnh/Thành phố--</option>
                                @foreach($tinh_tp as $tinh)
                                <option value="{{$tinh->id}}" >{{$tinh->ten_tp}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-4" style="padding-left: 0;">
                            <label for="opt_Huyen"> Chọn Quận/Huyện </label><br>
                            <select class="opt_select opt_Huyen" name="opt_Huyen" id="opt_Huyen" style="width: 160px; margin-left: 0; " required>                    
                                <option value="">--Quận/Huyện--</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-4" style="padding-left: 0; padding-right: 0;">
                            <label for="opt_Xa"> Chọn Xã phường/Thị trấn </label><br>
                            <select class="opt_Xa" name="opt_Xa" id="opt_Xa" style="width: 160px; " required>
                                <option value="">--Xã phường/Thị trấn--</option>
                            </select>
                        </div> 
                    </div>
                    @endif
                    
                    <div class="form-group" style="padding-left: 10px;">
                        <label for="dia_chi">Số nhà, khóm/ấp</label>
                        <input
                            type="text"
                            class="form-control"
                            name="dia_chi"
                            id="dia_chi"
                            value="{{$dc[0]}}"
                            placeholder="Nhập số nhà, khóm/ấp"
                            required
                        >
                        </input>
                    </div>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Cập nhật hồ sơ
                            </button>
                        </form>
                    </div>
                </div>

                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
    </div>
</div>

@endsection @section('js')
<script>
    function changeName() {
        document.getElementById("ho_ten").setAttribute("name", "ho_ten");
    }
    function changeSDT() {
        document.getElementById("sdt").setAttribute("name", "sdt");
    }
</script>
@endsection
