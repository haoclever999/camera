$(function () {
    $(document).on("click", ".action_del", Delete);
    $(".tag_select").select2({
        tags: true,
        placeholder: "-Nhập tag sản phẩm-",
        tokenSeparators: [","],
    });
    var editor_config = {
        path_absolute: "/",
        selector: "textarea.mota_editor",
        height: 350,
        relative_urls: false,
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table directionality",
            "emoticons template paste textpattern",
        ],
        toolbar:
            "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
        file_picker_callback: function (callback, value, meta) {
            var x =
                window.innerWidth ||
                document.documentElement.clientWidth ||
                document.getElementsByTagName("body")[0].clientWidth;
            var y =
                window.innerHeight ||
                document.documentElement.clientHeight ||
                document.getElementsByTagName("body")[0].clientHeight;

            var cmsURL =
                editor_config.path_absolute +
                "/laravel-filemanager?editor=" +
                meta.fieldname;
            if (meta.filetype == "image") {
                cmsURL = cmsURL + "&type=Images";
            } else {
                cmsURL = cmsURL + "&type=Files";
            }

            tinyMCE.activeEditor.windowManager.openUrl({
                url: cmsURL,
                title: "Filemanager",
                width: x * 0.8,
                height: y * 0.8,
                resizable: "yes",
                close_previous: "no",
                onMessage: (api, message) => {
                    callback(message.content);
                },
            });
        },
    };

    tinymce.init(editor_config);
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
        confirmButtonText: "Xóa",
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
