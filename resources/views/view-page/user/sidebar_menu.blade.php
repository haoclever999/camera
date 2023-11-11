<div class="sidebar col-md-3 col-sm-4">
    <link rel="stylesheet" href="{{ asset('frontend/assets_theme/plugins/smoothness/jquery-ui.css') }}" />
    <h4><b> Danh mục sản phẩm</b></h4>
    <ul class="list-group margin-bottom-25 sidebar-menu">
        @foreach ($dm as $d)
            <li
                class="list-group-item clearfix dropdown {{ Request::segment(2) == $d->slug || Request::segment(2) == $d->id ? 'active' : '' }}">
                <a
                    href="{{ route('danhmuc.sanpham', [
                        'slug' => $d->slug,
                        'id' => $d->id,
                    ]) }}">
                    {{ $d->ten_dm }}
                </a>
            </li>
        @endforeach
    </ul>
    @if (!empty($th) || !empty($th_sp))
        <h4><b>Thương hiệu</b></h4>
        <ul class="list-group margin-bottom-25 sidebar-menu">
            <!-- Kiểm tra $th tồn tại  -->
            @if (!empty($th))
                @foreach ($th as $t)
                    <li class="list-group-item clearfix dropdown {{ Request::segment(2) == $t->slug ? 'active' : '' }}">
                        <a
                            href="{{ route('thuonghieu.sanpham_all', [
                                'slug' => $t->slug,
                                'id' => $t->id,
                            ]) }}">
                            {{ $t->ten_thuong_hieu }}
                        </a>
                    </li>
                @endforeach
            @elseif(isset($th_sp))
                @foreach ($th_sp as $th)
                    @foreach ($ten_dm as $ten)
                        <li
                            class="list-group-item clearfix dropdown {{ Request::segment(4) == $th->slug ? 'active' : '' }}">
                            <a
                                href="{{ route('thuonghieu.sanpham', [
                                    'slug' => $th->slug,
                                    'id' => $th->id,
                                    'id_dm' => $ten->id,
                                ]) }}">
                                {{ $th->ten_thuong_hieu }}
                            </a>
                        </li>
                    @endforeach
                @endforeach
            @endif
        </ul>
    @endif
    <h4><b>Lọc giá</b></h4>
    <ul class="col-md-6 col-sm-6">
        <form>
            <select class="form-control input-sm" onchange="this.form.submit();" name="gia" style="width: 10em;">
                <option {{ request('gia') == 'mac_dinh' ? 'selected' : '' }} value="mac_dinh">Tất cả
                </option>
                <option {{ request('gia') == '1' ? 'selected' : '' }} value="1">&lt; 1 triệu</option>
                <option {{ request('gia') == '1-3' ? 'selected' : '' }} value="1-3">1 triệu - 3 triệu</option>
                <option {{ request('gia') == '3-5' ? 'selected' : '' }} value="3-5">3 triệu - 5 triệu
                </option>
                <option {{ request('gia') == '5-8' ? 'selected' : '' }} value="5-8">5 triệu - 8 triệu
                </option>
                <option {{ request('gia') == '8-10' ? 'selected' : '' }} value="8-10">8 triệu - 10 triệu
                </option>
                <option {{ request('gia') == '10' ? 'selected' : '' }} value="10">&gt; 10 triệu
                </option>
            </select>
        </form>
    </ul>
</div>
