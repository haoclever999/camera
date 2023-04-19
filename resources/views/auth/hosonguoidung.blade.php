@extends('layouts.user') @section('title')
<title>Hồ sơ cá nhân</title>
@endsection @section('slider') @include('view-page.user.slider') @endsection
@section('content')

<div class="row margin-bottom-40" style="margin-top: 40px">
    @include('view-page.user.sidebar_menu')
    <div class="col-md-9 col-sm-7">
        
        <div class="content">
            <div class="container-fluid">
                <div class="col-md-7 col-sm-7">
                    <h2 style="text-align: center"><b>Hồ sơ cá nhân</b></h2>
                    <br>
                    @if($errors->any() || Session::has('err'))
                        <h3 style="color: red; font-size: 17px; font-weight: bold">
                            Cập nhật hồ sơ thất bại!
                        </h3>
                    @endif
                    @if(Session::has('success'))
                        <h3 style="color: green; font-size: 17px; font-weight: bold">
                            {{ Session::get('success')}}
                        </h3>
                    @endif
                </div>
                <div class="row product-list" style="min-height: 300px">
                    <div class="col-md-10">
                        <form
                            action="{{ route('nguoidung.posthosoUser', ['id' => $user->id] ) }}"
                            method="post" 
                            
                        >
                            @csrf
                        <br>
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
                                    placeholder="Nhập số điện thoại"
                                    value="{{ $user->sdt }}"
                                    maxlength="10"
                                    onblur="kiemTraSDT(event)"
                                    required
                                />
                            </div>
                            <div class="form-group">
                                <label class="form-label">
                                    <b>Địa chỉ</b>
                                </label>
                                
                                @if($dc[0]!="")
                                <div class="form-group col-md-12 col-sm-12 " style="padding-left: 10px;">
                                    <div class="col-md-4 col-sm-4" style="padding-left: 0;">
                                        <label for="opt_Tinh"> Chọn Tỉnh/Thành phố </label><br>
                                        <select class="opt_select opt_Tinh" name="opt_Tinh" id="opt_Tinh" style="width: 100%; " required  >
                                            <option value="">--Tỉnh/Thành phố--</option>
                                            @foreach($tinh_tp as $tinh)
                                            <option value="{{$tinh->id}}" {{$tinh->ten_tp==$dc[3] ?'selected':''}}>{{$tinh->ten_tp}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-sm-4" style="padding-left: 0;">
                                        <label for="opt_Huyen"> Chọn Quận/Huyện </label><br>
                                        
                                        <select class="opt_select opt_Huyen" name="opt_Huyen" id="opt_Huyen" style="width: 100%; margin-left: 0; " required>
                                            @foreach($huyen as $h)
                                            <option value="{{$h->id}}"{{$h->ten_qh==$dc[2]?'selected':''}}>{{$h->ten_qh}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-sm-4" style="padding-left: 0; padding-right: 0;">
                                        <label for="opt_Xa"> Chọn Xã phường/Thị trấn </label><br>
                                        <select class="opt_Xa" name="opt_Xa" id="opt_Xa" style="width: 100%; " required>
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

<script src="{{asset('frontend/js/jquery.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $('.opt_select').on('change',function(){
            var action = $(this).attr('id');
            var id_diachi =$(this).val();
            var _token = $('input[name="_token"]').val();
            var kq='';
            if(action=="opt_Tinh")
                kq='opt_Huyen';
            else
                kq='opt_Xa';
            $.ajax({
                url:'{{route("diachi")}}',
                method: 'POST',
                data:{action:action,id_diachi:id_diachi,_token:_token},
                success: function(data){
                    $('#'+kq).html(data);
                }
            })
        });
        $('#ho_ten').on('change',function(){
            document.getElementById("ho_ten").setAttribute("name", "ho_ten");
        });
        $('#sdt').on('change',function(){
            document.getElementById("sdt").setAttribute("name", "sdt");
        });
    });
    function kiemTraSDT(event) {
            var dt = document.getElementById("sdt").value;
            var dt2 = document.getElementById("sdt");
            var kt =
                /^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}$/.test(
                    dt
                );
            if (isNaN(dt)) {
                event.preventDefault();
                dt2.setCustomValidity("Giá trị phải là số");
                dt2.reportValidity();
                return false;
            } else if (dt.length != "10") {
                event.preventDefault();
                dt2.setCustomValidity("Số điện thoại phải đủ 10 số");
                dt2.reportValidity();
                return false;
            } else if (kt == false) {
                event.preventDefault();
                dt2.setCustomValidity("Định dạng số điện thoại không đúng");
                dt2.reportValidity();
                return false;
            } else {
                dt2.setCustomValidity("");
                dt2.reportValidity();
                return true;
            }
        }
</script>
@endsection
