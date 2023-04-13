<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Đặt hàng thành công - {{ config("app.name", "Laravel") }}</title>
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
        <p>Xin chào {{ Auth::user()->name }}!</p>
        <p>
            Xin cảm ơn bạn đã đặt hàng tại {{ config("app.name", "Laravel") }}.
        </p>
        <p>Thông tin giao hàng:</p>
        <p>
            - Điện thoại: <strong>{{ $donhang->dienthoaigiaohang }}</strong>
        </p>
        <p>
            - Địa chỉ giao: <strong>{{ $donhang->diachigiaohang }}</strong>
        </p>
        <p>Thông tin đơn hàng bao gồm:</p>
        <table border="1">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th>Sản phẩm</th>
                    <th width="5%">SL</th>
                    <th width="15%">Đơn giá</th>
                    <th width="20%">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @php $tongtien = 0; @endphp @foreach($donhang->DonHang_ChiTiet
                as $chitiet)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $chitiet->SanPham->tensanpham }}</td>
                    <td>{{ $chitiet->soluongban }}</td>
                    <td style="text-align: right">
                        {{ number_format($chitiet->dongiaban)
                        }}<sup><u>đ</u></sup>
                    </td>
                    <td style="text-align: right">
                        {{ number_format($chitiet->soluongban * $chitiet->dongiaban)
                        }}<sup><u>đ</u></sup>
                    </td>
                </tr>
                @php $tongtien += $chitiet->soluongban * $chitiet->dongiaban;
                @endphp @endforeach
                <tr>
                    <td colspan="4">Tổng tiền sản phẩm:</td>
                    <td style="text-align: right">
                        <strong>{{ number_format($tongtien) }}</strong
                        ><sup><u>đ</u></sup>
                    </td>
                </tr>
            </tbody>
        </table>
        <p>Trân trọng,</p>
        <p>{{ config("app.name", "Laravel") }}</p>
    </body>
</html>
