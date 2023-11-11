@extends('layouts.user') @section('title')
    <title>Cửa Hàng Camera Quan Sát, Camera An Ninh, Camera Giám Sát</title>
    @endsection @section('slider')
    @include('view-page.user.slider')
@endsection
@section('css')
    <style>
        .form-group input:focus,
        .form-group textarea:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
        }
    </style>
    @endsection @section('content')
    <!-- Liên hệ -->
    <div class="row margin-bottom-40">
        <div class="col-md-12" style="margin-top: 40px">
            <h1>Liên hệ</h1>
            <div class="col-md-6">
                @if (Session::has('thongbao'))
                    <h4 style="color: green; font-size: 16px; font-weight: bold">
                        {{ Session::get('thongbao') }}
                    </h4>
                @endif

                <h5>(*) Thông tin bắt buộc</h5>
                <form action="{{ route('postLienHe') }} " method="post" id="myform">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Tiêu đề" id="tieu_de" name="tieu_de"
                            value="{{ old('tieu_de') }}" />
                    </div>
                    <div class="form-group">
                        <input type="text" placeholder="Họ tên (*)" class="form-control" id="ho_ten" name="ho_ten"
                            value="{{ old('ho_ten') }}" maxlength="191" required />
                    </div>
                    @if ($errors->has('ho_ten'))
                        <span class="help-block" style="color: #ff3f3f">
                            <b>{{ $errors->first('ho_ten') }}</b>
                        </span>
                    @endif
                    <div class="form-group">
                        <input type="email" placeholder="Email (*)" class="form-control" id="email" name="email"
                            value="{{ old('email') }}" maxlength="191" required />
                    </div>
                    @if ($errors->has('email'))
                        <span class="help-block" style="color: #ff3f3f">
                            <b>{{ $errors->first('email') }}</b>
                        </span>
                    @endif
                    <div class="form-group">
                        <input type="text" placeholder="Số điện thoại (*)" class="form-control" id="sdt"
                            name="sdt" maxlength="10" value="{{ old('sdt') }}" onblur="kiemTraSDT(event)" required />
                    </div>
                    <div class="form-group">
                        <input type="text" placeholder="Địa chỉ (*)" class="form-control" id="dia_chi" name="dia_chi"
                            value="{{ old('dia_chi') }}" required />
                    </div>
                    @if ($errors->has('dia_chi'))
                        <span class="help-block" style="color: #ff3f3f">
                            <b>{{ $errors->first('dia_chi') }}</b>
                        </span>
                    @endif
                    <div class="form-group">
                        <textarea placeholder="Nội dung (*)" class="form-control" cols="5" rows="5" id="noi_dung" name="noi_dung"
                            value="{{ old('noi_dung') }}" required></textarea>
                    </div>
                    @if ($errors->has('noi_dung'))
                        <span class="help-block" style="color: #ff3f3f">
                            <b>{{ $errors->first('noi_dung') }}</b>
                        </span>
                    @endif
                    <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_KEY') }}"></div>
                    @if ($errors->has('g-recaptcha-response'))
                        <span class="help-block" style="color: #ff3f3f; font-size: 14px">
                            <b> {{ $errors->first('g-recaptcha-response') }}</b>
                        </span>
                    @endif
                    <div class="padding-top-20" style="float: right">
                        <button type="submit" class="btn btn-primary">
                            Gửi liên hệ
                        </button>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
            <div class="col-md-6">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3924.6272291436976!2d105.4297639739395!3d10.371661066531471!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x310a731e7546fd7b%3A0x953539cd7673d9e5!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBBbiBHaWFuZyAtIMSQSFFHIFRQSENN!5e0!3m2!1svi!2s!4v1681797359979!5m2!1svi!2s"
                    width="100%" height="450" style="border: 0" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
    @endsection @section('js')
    <script>
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
            } else if (dt.length != "10") {
                event.preventDefault();
                dt2.setCustomValidity("Số điện thoại phải đủ 10 số");
                dt2.reportValidity();
            } else if (kt == false) {
                event.preventDefault();
                dt2.setCustomValidity("Định dạng số điện thoại không đúng");
                dt2.reportValidity();
            } else {
                dt2.setCustomValidity("");
                dt2.reportValidity();
            }
        }
    </script>
@endsection
