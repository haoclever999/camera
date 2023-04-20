<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    </head>
    <body>
        <h1>{{ $tieude }}</h1>

        <p>
            Đơn hàng của bạn đã được "<b> {{ $tieude }} </b>" bởi cửa hàng
        </p>
        <h3>Thông tin đơn hàng:</h3>
        <h4>ID đơn hàng: {{$data->id}}</h4>
        <h4>
            Ngày đặt hàng:
            {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('H:i:s d/m/Y')}}
        </h4>
        @if($tieude!="Huỷ đơn hàng")
        <h4>Tổng tiền: {{number_format($data->tong_tien, 0, ",", ".")}}đ</h4>
        @endif
        <div style="width: 100%">
            <hr />
            <p>Mọi thắc mắc vui lòng liên hệ số điện thoại: {{ $dt }}</p>
            <p>Trân trọng,</p>
        </div>
    </body>
</html>
