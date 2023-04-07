<div class="card">
    <div class="card-body">
        <div class="container mb-5 mt-3">
            <div class="container">
                <div class="col-md-12">
                    <div class="text-center">
                        <img src="{{ $logo }}" />
                        <p class="pt-0">{{ $diachi_web }}</p>
                    </div>
                </div>

                <div class="row">
                    @foreach($donhang as $dh)
                    <div class="col-xl-8">
                        <p class="text-muted">Thông tin khách hàng</p>
                        <ul class="list-unstyled">
                            <li class="text-muted">
                                <b> Họ tên: </b> {{$dh->ten_kh}}
                            </li>
                            <li class="text-muted">
                                <b></b> Điện thoại: </b>  {{$dh->sdt_kh}}
                            </li>
                            <li class="text-muted">
                                <b></b> Địa chỉ: </b> {{$dh->dia_chi_kh}}
                            </li>
                        </ul>
                    </div>
                    <div class="col-xl-4">
                        <p class="text-muted">Thông tin đơn hàng</p>
                        <ul class="list-unstyled">
                            <li class="text-muted">
                                <b>ID:</b> {{$dh->id}}
                            </li>
                            <li class="text-muted">
                                <b>Ngày tạo đơn: </b>
                                {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$dh->created_at)->format('H:i:s d/m/Y')}}
                            </li>
                            
                        </ul>
                    </div>
                    @endforeach
                </div>

                <div class="row my-2 mx-1 justify-content-center">
                    <table class="table table-striped table-borderless">
                        <thead
                            style="background-color: #84b0ca"
                            class="text-white"
                        >
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Giá bán</th>
                                <th scope="col">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $count = 1; @endphp
                            @foreach($donhang->DonHangChiTiet as $dhct)
                            <tr>
                                <th scope="row">{{ $count++ }}</th>
                                <td>{{ optional($dhct->SanPham)->ten_sp }}</td>
                                <td>{{$dhct->so_luong_ban}}</td>
                                <td>{{number_format($dhct->gia,0,",",".")}} đ</td>
                                <td>{{number_format($dhct->thanh_tien,0,",",".")}}đ </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-xl-8">
                        <p class="ms-3">
                            <h5>Ghi chú:</h5>
                            @foreach($donhang as $dh) @if(!empty($dh->ghi_chu))
                            {{$dh->ghi_chu}}
                            @endif @endforeach
                        </p>
                    </div>
                    <div class="col-xl-3">
                        <ul>
                            <li>
                                <em>Tổng tiền</em>
                                <strong class="price">
                                    {{Cart::subtotal(0,',','.') }} đ
                                </strong>
                            </li>
                            <li>
                                <em>Thuế</em>
                                <strong class="price">
                                    {{Cart::tax(0,',','.')}} đ 
                                </strong>
                            </li>
                            <li>
                                <em>Phí vận chuyển</em>
                                <strong class="price">Free</strong>
                            </li>
                            <li class="shopping-total-price">
                                <em>Thành tiền</em>
                                <strong class="price">
                                    {{Cart::total(0,',','.') }} đ
                                </strong>
                            </li>
                        </ul>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-xl-10">
                        <p>Cảm ơn bạn đã đặt hàng. Chúc bạn một ngày tốt lành</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
