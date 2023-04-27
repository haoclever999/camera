<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    </head>
    <body>
        @if($tieude=="Xác nhận" )
        <h2>{{ $tieude }} đơn hàng</h2>
        <h4>
            Đơn hàng của bạn đã được "<b> {{ $tieude }} </b>" bởi cửa hàng
        </h4>
        @elseif($tieude=="Huỷ")
        <h2>{{ $tieude }} đơn hàng</h2>
        <h4>
            Đơn hàng của bạn đã được "<b style="color: red"> {{ $tieude }} </b>"
            bởi cửa hàng
        </h4>
        @elseif($tieude=="Đang vận chuyển")
        <h2>{{ $tieude }}</h2>
        <h4>Đơn hàng của bạn đang được vận chuyển</h4>
        @else
        <h2>{{ $tieude }}</h2>
        <h4>Đơn hàng của bạn đã được giao thành công</h4>
        @endif

        <h3>Thông tin đơn hàng:</h3>
        <h4>ID đơn hàng: {{$data->id}}</h4>
        <h4>Trạng thái đơn hàng: {{$data->trang_thai}}</h4>

        <h4>
            Ngày đặt hàng:
            {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('H:i:s d/m/Y')}}
        </h4>
        @if($tieude!="Huỷ")
        <h4>Tổng tiền: {{number_format($data->tong_tien, 0, ",", ".")}}đ</h4>
        @endif

        <div style="width: 100%">
            <hr />
            <p>
                Mọi thắc mắc vui lòng liên hệ số điện thoại:
                <a style="text-decoration: none" href="tel:{{ $dt }}">{{
                    $dt
                }}</a>
            </p>
            <p>Trân trọng,</p>
        </div>
    </body>
</html>
