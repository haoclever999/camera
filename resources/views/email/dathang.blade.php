<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Đặt hàng thành công - {{ config('app.name', 'Laravel') }}</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        p {
            margin-top: 3px;
            margin-bottom: 3px;
        }
    </style>
</head>

<body>
    <p>Xin chào {{ Auth::user()->ho_ten }}!</p>
    <p>
        Cảm ơn bạn đã đặt hàng tại Cửa Hàng Camera Quan Sát, Camera An Ninh,
        Camera Giám Sát.
    </p>
    <p>Thông tin giao hàng:</p>

    <p style="margin-left: 2em">
        - Điện thoại: <strong>{{ $data->sdt_kh }}</strong>
    </p>
    <p style="margin-left: 2em">
        - Địa chỉ giao hàng: <strong>{{ $data->dia_chi_kh }}</strong>
    </p>
    <p style="margin-left: 2em">
        - Hình thức thanh toán: <strong>{{ $data->hinh_thuc }}</strong>
    </p>
    <p>Thông tin đơn hàng bao gồm:</p>
    <table border="1">
        <thead>
            <tr>
                <th width="1%">STT</th>
                <th width="49%">Sản phẩm</th>
                <th width="10%">Số lượng</th>
                <th width="20%">Đơn giá</th>
                <th width="20%">Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1; @endphp @foreach ($data->DonHangChiTiet as $chitiet)
                <tr>
                    <td style="text-align: center">{{ $i++ }}</td>
                    <td>{{ $chitiet->SanPham->ten_sp }}</td>
                    <td style="text-align: right">
                        {{ $chitiet->so_luong_ban }}
                    </td>
                    <td style="text-align: right">
                        {{ number_format($chitiet->gia, 0, ',', '.') }}đ
                    </td>
                    <td style="text-align: right">
                        {{ number_format($chitiet->thanh_tien, 0, ',', '.') }}đ
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div style="width: 100%">
        <div style="width: 70%; float: left; text-align: justify">
            <h5>Ghi chú:</h5>
            @if (!empty($data))
                {{ $data->ghi_chu }}
            @endif
        </div>
        <div style="width: 20%; float: right; padding-right: 20px">
            <ul style="padding-left: 20px; list-style: none">
                <li>
                    <em>Thuế:</em>
                    <strong class="price" style="float: right">
                        {{ number_format($data->thue, 0, ',', '.') }}đ
                    </strong>
                </li>

                <li class="shopping-total-price">
                    <em>Thành tiền:</em>
                    <strong class="price" style="float: right">
                        {{ number_format($data->tong_tien, 0, ',', '.') }}đ
                    </strong>
                </li>
            </ul>
        </div>
    </div>
    <div style="width: 100%; clear: both">
        <hr />
        <p>Mọi thắc mắc vui lòng liên hệ số điện thoại: {{ $dt }}</p>
        <p>Trân trọng,</p>
    </div>
</body>

</html>
