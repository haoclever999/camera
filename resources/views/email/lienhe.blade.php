<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Liên hệ</title>
</head>

<body>
    <h1>{{ $data['tieu_de'] }}</h1>
    <p>Họ tên khách hàng: {{ $data['ho_ten'] }}</p>
    <p>Email: {{ $data['email'] }}</p>
    <p>Số điện thoại: {{ $data['sdt'] }}</p>
    <p>Địa chỉ: {{ $data['dia_chi'] }}</p>
    <p>Nội dung: {{ $data['noi_dung'] }}</p>
</body>

</html>
