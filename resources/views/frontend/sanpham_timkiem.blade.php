@extends('layouts.user') @section('title')
<title>Tìm kiếm sản phẩm</title>
@endsection @section('content')

<div class="row margin-bottom-40" style="margin-top: 40px">
    @include('view-page.user.sidebar_menu')
    <div class="col-md-9 col-sm-7">
        <div class="row list-view-sorting clearfix">
            <div class="col-md-7 col-sm-7">
                <h3><b>Kết quả tìm kiếm</b></h3>
            </div>
            <div class="col-md-5 col-sm-5">
                <div class="pull-right">
                    <label class="control-label">Lọc:</label>
                    <select class="form-control input-sm">
                        <option
                            value="#?sort=p.sort_order&amp;order=ASC"
                            selected="selected"
                        >
                            Default
                        </option>
                        <option value="#?sort=pd.name&amp;order=ASC">
                            Tên (A - Z)
                        </option>
                        <option value="#?sort=pd.name&amp;order=DESC">
                            Tên (Z - A)
                        </option>
                        <option value="#?sort=p.price&amp;order=ASC">
                            Giá (Thấp &gt; Cao)
                        </option>
                        <option value="#?sort=p.price&amp;order=DESC">
                            Giá (Cao &gt; Thấp)
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <!-- BEGIN PRODUCT LIST -->
        <div class="row product-list" style="min-height: 300px">
            <!-- PRODUCT ITEM START -->

            @if($timkiem->count()>0) @foreach($timkiem as $tk)
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="product-item">
                    <div class="pi-img-wrapper">
                        <img
                            src="{{$tk->hinh_anh_chinh}}"
                            class="img-responsive"
                        />
                        <div>
                            <a
                                href="{{$tk->hinh_anh_chinh}}"
                                class="btn btn-default fancybox-button"
                            >
                                Phóng to
                            </a>
                            <a
                                href="{{route('sanpham.chitiet_sp',[$tk->id])}}"
                                class="btn btn-default fancybox-fast-view"
                            >
                                Chi tiết
                            </a>
                        </div>
                    </div>
                    <h3>
                        <a href="{{route('sanpham.chitiet_sp',[$tk->id])}}">
                            <b> {{$tk->ten_sp}} </b>
                        </a>
                    </h3>
                    <div class="pi-price">
                        {{number_format(($tk->gia_ban-($tk->gia_ban*$tk->giam_gia/100)),0,',','.')
                        }}
                        đ
                    </div>

                    <form
                        action="{{ route('giohang.them_giohang') }}"
                        method="post"
                    >
                        @csrf
                        <input type="hidden" name="id_sp" value="{{$tk->id}}" />
                        <input
                            type="hidden"
                            name="gia"
                            value="{{number_format(($tk->gia_ban-($tk->gia_ban*$tk->giam_gia/100)),0,',','.')}}"
                        />
                        <div class="product-quantity">
                            <input
                                name="num_so_luong"
                                type="hidden"
                                value="1"
                            />
                        </div>
                        <button
                            class="btn add2cart"
                            type="submit"
                            style="background-color: rgba(204, 204, 204, 0.5)"
                        >
                            Thêm vào giỏ
                        </button>
                    </form>
                    @if($tk->giam_gia !=0)
                    <div class="giamgia">
                        <span class="chu">GIẢM</span>
                        <span class="phantram">{{$tk->giam_gia}}%</span>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
            <!-- PRODUCT ITEM END -->
            @else
            <div>
                <h3>Không tìm thấy sản phẩm</h3>
            </div>
            @endif
        </div>

        <!-- END PRODUCT LIST -->
        <!-- BEGIN PAGINATOR -->
        <div class="row">
            <div class="col-md-4 col-sm-4 items-info"></div>
            <div class="col-md-8 col-sm-8" style="float: right">
                {!! $timkiem->links()!!}
            </div>
        </div>
        <!-- END PAGINATOR -->
    </div>
</div>

@endsection @section('js')
<script
    src="{{
        asset('frontend/assets_theme/plugins/uniform/jquery.uniform.min.js')
    }}"
    type="text/javascript"
></script>
<script
    src="{{
        asset('frontend/assets_theme/plugins/rateit/src/jquery.rateit.js')
    }}"
    type="text/javascript"
></script>
<script
    src="{{ asset('frontend/assets_theme/plugins/jquery-ui.js') }}"
    type="text/javascript"
></script>
<!-- for slider-range -->
@endsection
