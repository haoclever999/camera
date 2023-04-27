<div class="pre-header">
    <div class="container">
        <div class="row">
            <!-- BEGIN TOP BAR LEFT PART -->
            <div class="col-md-9 col-sm-9 additional-shop-info">
                <ul class="list-unstyled list-inline">
                    <li>
                        <a
                            href="tel:{{$dt->cau_hinh_value}}"
                            style="text-decoration: none"
                        >
                            <i class="fa fa-phone"></i>
                        </a>
                    </li>
                    <li>
                        <a
                            href="mailto:{{$email->cau_hinh_value}}"
                            style="text-decoration: none"
                        >
                            <i class="fa fa-envelope"></i>
                        </a>
                    </li>
                    <li>
                        <a
                            target="_blank"
                            href="{{$fb->cau_hinh_value}}"
                            style="text-decoration: none"
                        >
                            <i class="fa fa-facebook"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- END TOP BAR LEFT PART -->
            <!-- BEGIN TOP BAR MENU -->
            <div class="col-md-3 col-sm-3 additional-nav">
                <ul class="list-unstyled list-inline pull-right">
                    @if(Auth::check())
                    <li class="nav-item dropdown no-arrow">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            id="userDropdown"
                            role="button"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                            style="
                                text-decoration: none;
                                vertical-align: middle;
                                margin: -5px;
                            "
                        >
                            <span
                                style="
                                    vertical-align: middle;
                                    font-size: 1.5rem;
                                "
                            >
                                {{Auth::user()->ho_ten}}
                            </span>
                            <span width="20px">
                                <i class="fa fa-user fa-lg"></i>
                            </span>
                        </a>
                        <!-- Dropdown - User Information -->
                        <div
                            class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown"
                            style="margin-top: 0"
                        >
                            <a
                                class="dropdown-item"
                                href="{{ route('nguoidung.gethosoUser',['id'=>Auth::user()->id]) }}"
                                style="text-decoration: none"
                            >
                                <i class="fa fa-user" aria-hidden="true"></i>
                                Hồ sơ cá nhân
                            </a>
                            <a
                                class="dropdown-item"
                                href="{{ route('nguoidung.getdoimatkhauUser',['id'=>Auth::user()->id]) }}"
                                style="text-decoration: none"
                            >
                                <i class="fa fa-cogs" aria-hidden="true"> </i>
                                Đổi mật khẩu
                            </a>
                            <div class="dropdown-divider"></div>
                            <a
                                class="dropdown-item"
                                href="{{ route('DangXuatUser') }}"
                                style="text-decoration: none"
                            >
                                <img
                                    src="{{ asset('frontend/img/logout.png') }}"
                                    width="15px"
                                    style="
                                        margin-right: 4px;
                                        width: 1.25em;
                                        text-align: center;
                                    "
                                />
                                Đăng xuất
                            </a>
                        </div>
                    </li>
                    @else
                    <li>
                        <a
                            href="{{ route('getDangNhapUser') }}"
                            style="text-decoration: none"
                        >
                            Đăng nhập
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
            <!-- END TOP BAR MENU -->
        </div>
    </div>
</div>
