$(function () {
    $(document).on("click", ".action_del", Delete);
    $(document).on("click", ".action_huy", Huy);
    $(".tag_select").select2({
        tags: true,
        placeholder: " - Nhập tag sản phẩm -",
        tokenSeparators: [","],
    });
});

//sử dụng sweetalert2 để hiện bảng thông báo, ajax
function Delete(even) {
    even.preventDefault();
    let urlRequest = $(this).data("url"); //lấy đường dẫn url
    let that = $(this);
    Swal.fire({
        title: "Bạn có chắc chắn?",
        text: "Nó có thể ảnh hưởng đến dữ liệu khác",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Hủy",
        confirmButtonText: "Xác nhận xóa",
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "GET",
                url: urlRequest,
                success: function (data) {
                    if (data.code == 200) {
                        that.parent().parent().remove();
                        Swal.fire("Đã xóa!", "Dữ liệu đã được xóa.", "success");
                    }
                },
                error: function () {},
            });
        }
    });
}

function Huy(even) {
    even.preventDefault();
    let urlRequest = $(this).data("url"); //lấy đường dẫn url
    Swal.fire({
        title: "Bạn có chắc chắn?",
        text: "Nó không thể khôi phục lại.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Huỷ",
        confirmButtonText: "Xác nhận huỷ",
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "GET",
                url: urlRequest,
                success: function (data) {
                    if (data.code == 200) {
                        Swal.fire(
                            "Đã huỷ!",
                            "Đơn hàng đã được huỷ.",
                            "success"
                        ).then(function () {
                            location.reload();
                        });
                    }
                },
                error: function () {},
            });
        }
    });
}
