<div class="sidebar col-md-3 col-sm-4">
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
</div>
