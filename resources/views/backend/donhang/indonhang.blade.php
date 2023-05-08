<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>In đơn hàng</title>
        <style>
            body {
                color: #000;
                font-family: "DejaVu Sans", Arial, sans-serif;
            }
            .container {
                width: 80%;
                margin: auto;
            }
            .text-center {
                text-align: center !important;
            }
            .text-center img {
                vertical-align: middle;
                width: 100px;
            }
            .row {
                width: 100% !important;
            }
            .col-xl-8 {
                flex: 0 0 auto;
                width: 66.66666667%;
            }
            .ms-3 {
                margin-left: 1rem !important;
            }
            .list-unstyled {
                padding-left: 20px;
                list-style: none;
            }
            .col-xl-3 {
                flex: 0 0 auto;
                width: 25%;
            }
            .col-xl-4 {
                flex: 0 0 auto;
                width: 33.33333333%;
            }
            .col-xl-10 {
                flex: 0 0 auto;
                width: 83.33333333%;
            }
            .justify-content-center {
                margin: 0.5rem 0.25rem !important;
                justify-content: center !important;
            }
            .table {
                width: 100%;
                margin-bottom: 1rem;
                color: rgba(255, 255, 255, 0.8);
                vertical-align: top;
                border-color: rgba(255, 255, 255, 1);
                background-color: rgba(204, 204, 204, 0.5);
            }
            .thead {
                background-color: #84b0ca;
                color: #fff;
            }
            .tbody tr td {
                vertical-align: inherit;
            }
            td {
                color: rgba(0, 0, 0, 0.8) !important;
            }
            td:first-child {
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="text-center">
                <img src="{{ public_path('frontend/img/logo.jpg') }}" />
                <h3
                    style="
                        width: 70%;
                        vertical-align: middle;
                        margin-left: 15%;
                        margin-right: 15%;
                    "
                >
                    Cửa Hàng Camera Quan Sát, <br />
                    Camera An Ninh, Camera Giám Sát
                </h3>
            </div>
            <div class="row">
                <div class="col-xl-10">
                    <p class="text-muted"><b>Thông tin khách hàng</b></p>
                    <ul class="list-unstyled">
                        <li class="text-muted">Họ tên: {{$dhang->ten_kh}}</li>
                        <li class="text-muted">
                            Điện thoại: {{$dhang->sdt_kh}}
                        </li>
                        <li class="text-muted">
                            Địa chỉ: {{$dhang->dia_chi_kh}}
                        </li>
                    </ul>
                </div>

                <div class="col-xl-8">
                    <p class="text-muted"><b> Thông tin đơn hàng </b></p>
                    <ul class="list-unstyled">
                        <li class="text-muted">ID: {{$dhang->id}}</li>

                        <li class="text-muted">
                            Ngày tạo đơn:
                            {{Carbon\Carbon::createFromFormat("Y-m-d H:i:s",$dhang->created_at)->format("H:i:s d/m/Y")}}
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row my-2 mx-1 justify-content-center">
                <table class="table table-striped table-borderless">
                    <thead style="background-color: #84b0ca" class="text-white">
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Giá bán</th>
                            <th scope="col">Thành tiền</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php $count=1; @endphp @foreach($dhang->DonHangChiTiet
                        as $dhct)
                        <tr>
                            <td scope="row" style="width: 1%">{{$count++}}</td>
                            <td style="width: 40%">
                                {{$dhct->SanPham->ten_sp}}
                            </td>
                            <td style="width: 15%; text-align: right">
                                {{$dhct->so_luong_ban}}
                            </td>
                            <td style="width: 20%; text-align: right">
                                {{number_format($dhct->gia,0,",",".")}}đ
                            </td>
                            <td style="width: 24%; text-align: right">
                                {{number_format($dhct->thanh_tien,0,",",".")}}đ
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div style="width: 55%; float: left">
                    <h5>Ghi chú:</h5>
                    @if(!empty($dhang))
                    {{$dhang->ghi_chu}}
                    @endif
                </div>
                <div style="width: 45%; float: left">
                    <ul class="list-unstyled">
                        @php $t=0; foreach($dhang->DonHangChiTiet as $dhct) $t
                        += $dhct->thanh_tien @endphp
                        <li>
                            <em>Tổng tiền:</em>
                            <strong class="price" style="float: right">
                                {{ number_format($t, 0, ",", ".") }}đ
                            </strong>
                        </li>
                        <li>
                            <em>Thuế:</em>
                            <strong class="price" style="float: right">
                                {{ number_format($dhang->thue, 0, ",", ".") }}đ
                            </strong>
                        </li>

                        <li class="shopping-total-price">
                            <em>Thành tiền:</em>

                            <strong class="price" style="float: right">
                                {{number_format($dhang->tong_tien, 0, ",", ".")}}đ
                            </strong>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row" style="clear: both">
                <hr />
                <p style="text-align: center">
                    Cảm ơn bạn đã đặt hàng. Chúc bạn một ngày tốt lành
                </p>
            </div>
        </div>
    </body>
</html>
