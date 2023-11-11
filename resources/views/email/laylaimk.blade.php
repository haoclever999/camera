<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lấy lại mật khẩu</title>
</head>

<body>
    <h1>Khôi phục mật khẩu</h1>
    <h2>Xin chào {{ $user->ho_ten }}</h2>
    <p>
        Bạn vừa yêu cầu Cửa Hàng Camera Quan Sát, Camera An Ninh, Camera
        Giám Sát khôi phục mật khẩu của mình.
    </p>
    <p>
        Xin vui lòng nhấn vào nút "Đặt lại mật khẩu" bên dưới để tiến hành
        cấp mật khẩu mới.
    </p>
    <p>
        <a href="{{ route('getDatLaiMatKhauUser', ['id' => $user->id, 'token' => $token]) }}"
            style="
                    display: inline-block;
                    color: #fff;
                    background-color: #337ab7;
                    border-color: #2e6da4;
                    padding: 7px 20px;
                    text-decoration: none;
                    vertical-align: middle;
                    font-weight: bold;
                ">
            Đặt lại mật khẩu
        </a>
    </p>
    <p>
        Nếu bạn không yêu cầu đặt lại mật khẩu, xin vui lòng không làm gì
        thêm và báo lại cho quản trị hệ thống về vấn đề này.
    </p>
</body>

</html>
