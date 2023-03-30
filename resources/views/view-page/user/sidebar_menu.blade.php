<div class="sidebar col-md-3 col-sm-4">
    <h4><b> Danh mục sản phẩm</b></h4>
    <ul class="list-group margin-bottom-25 sidebar-menu">
        @foreach($dm as $d) @if($d->DanhMucCon->count())
        <li class="list-group-item clearfix dropdown">
            <a href="">
                <i class="fa fa-angle-right"></i>

                {{$d->ten_dm}}
            </a>
            <ul class="dropdown-menu" id="danhmuc_{{$d->id}}">
                @foreach($d->DanhMucCon as $dmc)
                <li class="list-group-item dropdown clearfix">
                    <a
                        href="{{route('danhmuc.sanpham',
                    [
                    'slug'=>$dmc->slug,'id'=>$dmc->id
                    ]
                    )}}"
                    >
                        @if($dmc->DanhMucCon->count())
                        <i class="fa fa-angle-right"></i>
                        @endif {{$dmc->ten_dm}}
                    </a>
                </li>
                @endforeach
            </ul>
        </li>
        @else
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
            @endif
        </li>

        @endforeach
    </ul>

    <h4><b>Thương hiệu</b></h4>
    <ul class="list-group margin-bottom-25 sidebar-menu">
        @foreach($th_sp as $th)
        <li class="list-group-item clearfix dropdown">
            <a
                href="{{route('thuonghieu.sanpham',
            [
            'slug'=>$th->slug,'id'=>$th->id
            ]
            )}}"
            >
                {{$th->ten_thuong_hieu}}
            </a>
        </li>
        @endforeach
    </ul>
</div>
