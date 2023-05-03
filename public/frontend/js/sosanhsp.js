$(document).ready(function (event) {
    $("form").submit(function () {
        var form = $(this);
        var actionUrl = form.attr("action");
        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form.serialize(),
            success: function (data) {
                if (data.status === "Thêm thành công") {
                    location.reload(false);
                }
            },
        });
    });
    $("form.them_giohang").submit(function () {
        var form = $(this);
        var actionUrl = form.attr("action");
        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form.serialize(),
            success: function (data) {
                if (data.status === "Thêm thành công") {
                    location.reload(false);
                }
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
