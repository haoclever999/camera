<div class="sidebar col-md-3 col-sm-4">
    <link
        rel="stylesheet"
        href="{{
            asset('frontend/assets_theme/plugins/smoothness/jquery-ui.css')
        }}"
    />
    <h4><b> Danh mục sản phẩm</b></h4>
    <ul class="list-group margin-bottom-25 sidebar-menu">
        @foreach($dm as $d)
        <li class="list-group-item clearfix dropdown">
            <a
                href="{{route('danhmuc.sanpham',
            [
            'slug'=>$d->slug,'id'=>$d->id
            ]
            )}}"
            >
                {{$d->ten_dm}}
            </a>
        </li>

        @endforeach
    </ul>

    <h4><b>Thương hiệu</b></h4>
    <ul class="list-group margin-bottom-25 sidebar-menu">
        <!-- Kiểm tra $th tồn tại  -->
        @if(!empty($th)) @foreach($th as $t)

        <li class="list-group-item clearfix dropdown">
            <a
                href="{{route('thuonghieu.sanpham_all',
            [
            'slug'=>$t->slug,'id'=>$t->id
            ]
            )}}"
            >
                {{$t->ten_thuong_hieu}}
            </a>
        </li>
        @endforeach @elseif(isset($th_sp)) @foreach($th_sp as $th)
        @foreach($ten_dm as $ten)

        <li class="list-group-item clearfix dropdown">
            <a
                href="{{route('thuonghieu.sanpham',
            [
            'slug'=>$th->slug,'id'=>$th->id,'id_dm'=>$ten->id
            ]
            )}}"
            >
                {{$th->ten_thuong_hieu}}
            </a>
        </li>
        @endforeach @endforeach @endif
    </ul>

    <h4><b>Lọc giá</b></h4>
    <ul class="col-md-6 col-sm-6">
        <form>
            <div id="loc_gia"></div>
            <input type="hidden" id="tu_gia" />
            <input type="hidden" id="den_gia" />
            <p>
                <input
                    type="text"
                    id="amount"
                    style="border: 0; color: #f6931f; font-weight: bold"
                />
            </p>
        </form>
    </ul>

    <script>
        $(document).ready(function () {
            $("#loc_gia").slider({
                orientation: "horizontal",
                range: true,
                values: [0, 10000000],
                slide: function (event, ui) {
                    $("#amount").val(
                        ui.values[0] + "đ" + " - " + ui.values[1] + "đ"
                    );
                    $("#tu_gia").val(ui.values[0]);
                    $("#den_gia").val(ui.values[1]);
                },
            });
            $("#amount").val(
                $("#loc_gia").slider("values", 0) +
                    "đ" +
                    " - " +
                    $("#loc_gia").slider("values", 1) +
                    "đ"
            );
        });
    </script>
</div>
