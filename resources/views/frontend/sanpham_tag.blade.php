@extends('layouts.user') @section('title')
<title>Sản phẩm</title>
@endsection @section('content')

<div class="row margin-bottom-40" style="margin-top: 40px">
    @include('view-page.user.sidebar_menu')
    <div class="col-md-9 col-sm-7">
        <div class="row list-view-sorting clearfix">
            <div class="col-md-7 col-sm-7">
                <h3>Sản phẩm cho tag {{$tags->ten_tag}}</h3>
            </div>
        </div>
        <!-- BEGIN PRODUCT LIST -->
        <div class="row product-list" style="min-height: 300px">
            <!-- PRODUCT ITEM START -->

            @if($tags->count()>0) @foreach($tags->SanPhamTag as $s)
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="product-item">
                    <div class="pi-img-wrapper">
                        <img
                            src="{{$s->hinh_anh_chinh}}"
                            class="img-responsive"
                        />
                        <div>
                            <a
                                href="{{$s->hinh_anh_chinh}}"
                                class="btn btn-default fancybox-button"
                            >
                                Phóng to
                            </a>
                            <a
                                href="{{route('sanpham.chitiet_sp',[$s->id])}}"
                                class="btn btn-default fancybox-fast-view"
                            >
                                Chi tiết
                            </a>
                        </div>
                    </div>
                    <h3>
                        <a href="{{route('sanpham.chitiet_sp',[$s->id])}}">
                            <b> {{$s->ten_sp}} </b>
                        </a>
                    </h3>
                    <div class="pi-price">
                        {{number_format(($s->gia_ban-($s->gia_ban*$s->giam_gia/100)),0,',','.')
                        }}đ
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
                                {{number_format($s->gia_ban,0,',','.')



                                }}đ
                            </i>
                        </del>
                    </div>
                    @if($s->giam_gia !=0)
                    <div class="giamgia">
                        <span class="chu">GIẢM</span>
                        <span class="phantram">{{$s->giam_gia}}%</span>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
            <!-- PRODUCT ITEM END -->
            @else
            <div>
                <h3>Không có sản phẩm</h3>
            </div>
            @endif
        </div>

        <!-- END PRODUCT LIST -->
    </div>
</div>
@endsection
