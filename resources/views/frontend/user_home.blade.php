@extends('layouts.user') @section('title')
<title>Cửa Hàng Camera Quan Sát, Camera An Ninh, Camera Giám Sát</title>
@endsection @section('slider') @include('view-page.user.slider') @endsection
@section('content')
<!-- Sản phẩm mới về -->
<div class="row margin-bottom-40">
    <div class="col-md-12 sale-product">
        <h2><b>Sản phẩm mới về</b></h2>
        @foreach($sp_moi as $sp_m)
        <div class="col-md-3" style="margin-top: 6px">
            <div class="product-item">
                <div class="pi-img-wrapper">
                    <img
                        src="{{$sp_m->hinh_anh_chinh}}"
                        class="img-responsive"
                    />
                    <div>
                        <a
                            href="{{$sp_m->hinh_anh_chinh}}"
                            class="btn btn-default fancybox-button"
                        >
                            Phóng to
                        </a>
                        <a
                            href="{{route('sanpham.chitiet_sp',[$sp_m->id])}}"
                            class="btn btn-default fancybox-fast-view"
                        >
                            Chi tiết
                        </a>
                    </div>
                </div>
                <h3>
                    <a
                        href="{{route('sanpham.chitiet_sp',[$sp_m->id])}}"
                        style="text-decoration: none"
                    >
                        <b> {{$sp_m->ten_sp}} </b>
                    </a>
                </h3>
                <div class="pi-price">
                    {{number_format(($sp_m->gia_ban-($sp_m->gia_ban*$sp_m->giam_gia/100)),0,',','.')
                    }}đ
                </div>
                <div class="price pull-right">
                    <del>
                        <i
                            style="
                                margin-left: 1em;
                                height: 25px;
                                line-height: 2;
                                vertical-align: middle;
                            "
                        >
                            {{number_format($sp_m->gia_ban,0,',','.')}}đ
                        </i>
                    </del>
                </div>
                <div>
                    <p
                        class="btn btn-so-sanh"
                        onclick="ThemSoSanh('{{$sp_m->id}}')"
                    >
                        So sánh
                    </p>
                    <form>
                        @csrf
                        <input type="hidden" id="id_sp" value="{{$sp_m->id}}" />
                        <input
                            type="hidden"
                            id="tensp_{{$sp_m->id}}"
                            value="{{$sp_m->ten_sp}}"
                        />
                        <input
                            type="hidden"
                            id="hinhanh_{{$sp_m->id}}"
                            value="{{$sp_m->hinh_anh_chinh}}"
                        />
                        <input
                            type="hidden"
                            id="giaban_{{$sp_m->id}}"
                            value="{{number_format(($sp_m->gia_ban-($sp_m->gia_ban*$sp_m->giam_gia/100)),0,',','.')}}"
                        />
                        <input
                            type="hidden"
                            id="tinhnang_{{$sp_m->id}}"
                            value="{{$sp_m->tinh_nang}}"
                        />
                        <a
                            id="url_{{$sp_m->id}}"
                            href="{{route('sanpham.chitiet_sp', [$sp_m->id])}}"
                        ></a>
                    </form>
                    <form
                        action="{{ route('giohang.them_giohang') }}"
                        class="them_giohang"
                        method="post"
                    >
                        @csrf
                        <input
                            type="hidden"
                            name="id_sp"
                            value="{{$sp_m->id}}"
                        />
                        <input type="hidden" name="num_so_luong" value="1" />
                        <button class="btn btn-them-gio-hang" type="submit">
                            Thêm vào giỏ
                        </button>
                    </form>
                </div>
                @if($sp_m->giam_gia !=0)
                <div class="giamgia">
                    <span class="chu">GIẢM</span>
                    <span class="phantram">{{$sp_m->giam_gia}}%</span>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Banner quãng cáo -->
<div class="row margin-bottom-40">
    <div class="col-md-12 sale-product">
        <div class="banner_qc">
            <img src=" {{ asset('frontend/img/sliders/slider1.jpg') }}" />
        </div>
    </div>
</div>

<!-- Sản phẩm nổi bật -->
<div class="row margin-bottom-40">
    <div class="col-md-12 sale-product">
        <h2><b>Sản phẩm nổi bật</b></h2>
        @foreach($sp_noi_bat as $sp_nb)
        <div class="col-md-3" style="margin-top: 6px">
            <div class="product-item">
                <div class="pi-img-wrapper">
                    <img
                        src="{{$sp_nb->hinh_anh_chinh}}"
                        class="img-responsive"
                    />
                    <div>
                        <a
                            href="{{$sp_nb->hinh_anh_chinh}}"
                            class="btn btn-default fancybox-button"
                        >
                            Phóng to
                        </a>
                        <a
                            href="{{route('sanpham.chitiet_sp',[$sp_nb->id])}}"
                            class="btn btn-default fancybox-fast-view"
                        >
                            Chi tiết
                        </a>
                    </div>
                </div>
                <h3>
                    <a href="{{route('sanpham.chitiet_sp',[$sp_nb->id])}}">
                        <b> {{$sp_nb->ten_sp}} </b>
                    </a>
                </h3>
                <div class="pi-price">
                    {{number_format(($sp_nb->gia_ban-($sp_nb->gia_ban*$sp_nb->giam_gia/100)),0,',','.')

                    }}
                    đ
                </div>
                <div class="price">
                    <del>
                        <i
                            style="
                                margin-left: 1em;
                                height: 25px;
                                line-height: 2;
                                vertical-align: middle;
                            "
                        >
                            {{number_format($sp_nb->gia_ban,0,',','.')}}đ
                        </i>
                    </del>
                </div>
                <div>
                    <p
                        class="btn btn-so-sanh"
                        onclick="ThemSoSanh('{{$sp_nb->id}}')"
                    >
                        So sánh
                    </p>
                    <form>
                        @csrf
                        <input
                            type="hidden"
                            id="id_sp"
                            value="{{$sp_nb->id}}"
                        />
                        <input
                            type="hidden"
                            id="tensp_{{$sp_nb->id}}"
                            value="{{$sp_nb->ten_sp}}"
                        />
                        <input
                            type="hidden"
                            id="hinhanh_{{$sp_nb->id}}"
                            value="{{$sp_nb->hinh_anh_chinh}}"
                        />
                        <input
                            type="hidden"
                            id="giaban_{{$sp_nb->id}}"
                            value="{{number_format(($sp_nb->gia_ban-($sp_nb->gia_ban*$sp_nb->giam_gia/100)),0,',','.')}}"
                        />
                        <input
                            type="hidden"
                            id="tinhnang_{{$sp_nb->id}}"
                            value="{{$sp_nb->tinh_nang}}"
                        />
                        <a
                            id="url_{{$sp_nb->id}}"
                            href="{{route('sanpham.chitiet_sp', [$sp_nb->id])}}"
                        ></a>
                    </form>
                    <form
                        action="{{ route('giohang.them_giohang') }}"
                        class="them_giohang"
                        method="post"
                    >
                        @csrf
                        <input
                            type="hidden"
                            name="id_sp"
                            value="{{$sp_nb->id}}"
                        />
                        <input type="hidden" name="num_so_luong" value="1" />
                        <button class="btn btn-them-gio-hang" type="submit">
                            Thêm vào giỏ
                        </button>
                    </form>
                </div>
                @if($sp_nb->giam_gia !=0)
                <div class="giamgia">
                    <span class="chu">GIẢM</span>
                    <span class="phantram">{{$sp_nb->giam_gia}}%</span>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- Modal so sánh sản phẩm -->
<div class="container">
    <div class="modal fade" id="modal-sosanh" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                    <h4 class="modal-title" id="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <table class="table" id="sosanh">
                        <thead>
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Hình ảnh</th>
                                <th>Tính năng</th>
                                <th>Chi tiết</th>
                                <th>Xoá</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-default"
                        data-dismiss="modal"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection @section('js')
<script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function (event) {
        $("form.them_giohang").submit(function () {
            var form = $(this);
            var actionUrl = form.attr("action");
            $.ajax({
                type: "POST",
                url: actionUrl,
                data: form.serialize(),
                success: function (data) {
                    if (data.status === "Thêm thành công") {
                        alert("Đã thêm vào giỏ hàng");
                        location.reload(false);
                    } else alert("Thêm vào giỏ hàng thất bại");
                },
            });
        });
    });
    XemSoSanh();
    function XemSoSanh() {
        if (localStorage.getItem("sosanh_sp") != null) {
            var data = JSON.parse(localStorage.getItem("sosanh_sp"));
            for (var i = 0; i < data.length; i++) {
                var id = data[i].id;
                var tensp = data[i].tensp;
                var hinhanh = data[i].hinhanh;
                var giaban = data[i].giaban;
                var tinhnang = data[i].tinhnang;
                var url = data[i].url;
                $("#sosanh")
                    .find("tbody")
                    .append(
                        `
                    <tr id="row_sosanh_` +
                            id +
                            `">
                        <td>` +
                            tensp +
                            `</td>
                        <td>` +
                            giaban +
                            `đ</td>
                        <td><img width="100px" src="` +
                            hinhanh +
                            `"/></td>
                        <td>` +
                            tinhnang +
                            `</td>
                        <td> <a style="text-decoration: none;" href="` +
                            url +
                            `"> Xem </a></td>
                            <td><a style="cursor:pointer; text-decoration: none;" onclick="XoaSoSanh(` +
                            id +
                            `)">Xoá</a></td>
                    </tr>
                `
                    );
            }
        }
    }

    function ThemSoSanh(id_sp) {
        $("#modal-title").text("So sánh tối đa 3 sản phẩm");
        var id = id_sp;
        var tensp = $("#tensp_" + id).val();
        var hinhanh = $("#hinhanh_" + id).val();
        var giaban = $("#giaban_" + id).val();
        var tinhnang = $("#tinhnang_" + id).val();
        var url = $("#url_" + id).attr("href");
        var newItems = {
            id: id,
            tensp: tensp,
            hinhanh: hinhanh,
            giaban: giaban,
            tinhnang: tinhnang,
            url: url,
        };
        console.log(newItems);

        if (localStorage.getItem("sosanh_sp") == null)
            localStorage.setItem("sosanh_sp", "[]");

        var ds_sosanh = JSON.parse(localStorage.getItem("sosanh_sp"));
        var kt_sosanh = $.grep(ds_sosanh, function (obj) {
            return obj.id == id;
        });

        if (kt_sosanh.length) {
        } else {
            if (ds_sosanh.length <= 2) {
                ds_sosanh.push(newItems);
                $("#sosanh")
                    .find("tbody")
                    .append(
                        `
                    <tr id="row_sosanh_` +
                            newItems.id +
                            `">
                        <td>` +
                            newItems.tensp +
                            `</td>
                        <td>` +
                            newItems.giaban +
                            `đ</td>
                        <td><img width="100px" src="` +
                            newItems.hinhanh +
                            `"/></td>
                        <td>` +
                            newItems.tinhnang +
                            `</td>
                        <td> <a style="text-decoration: none;" href="` +
                            newItems.url +
                            `"> Xem </a></td>
                        <td><a style="cursor:pointer; text-decoration: none;" onclick="XoaSoSanh(` +
                            newItems.id +
                            `)">Xoá</a></td>
                    </tr>
                `
                    );
            }
        }
        localStorage.setItem("sosanh_sp", JSON.stringify(ds_sosanh));
        $("#modal-sosanh").modal();
    }
    function XoaSoSanh(id) {
        if (localStorage.getItem("sosanh_sp") != null) {
            var data = JSON.parse(localStorage.getItem("sosanh_sp"));
            var index = data.findIndex((item) => item.id === id);
            data.splice(index, 1);
            localStorage.setItem("sosanh_sp", JSON.stringify(data));
            $("#row_sosanh_" + id).remove();
        }
    }
</script>
@endsection
