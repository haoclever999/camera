<nav
    class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"
>
    <!-- Sidebar Toggle (Topbar) -->
    <button
        id="sidebarToggleTop"
        class="btn btn-link d-md-none rounded-circle mr-3"
    >
        <i class="fa fa-bars"></i>
    </button>
    @yield('title-action')
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto" style="max-width: 26rem">
        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a
                class="nav-link dropdown-toggle"
                href="#"
                id="searchDropdown"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
            >
                <i class="fas fa-search fa-fw"></i>
            </a>
        </li>
        @yield('title-content')
        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a
                class="nav-link dropdown-toggle"
                href="#"
                id="userDropdown"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
            >
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    @if(Auth::check()) {{Auth::user()->ho_ten}} @else Họ tên
                    @endif
                </span>
                <img
                    class="img-profile rounded-circle"
                    src="{{ asset('frontend/img/undraw_profile.svg') }}"
                />
            </a>
            <!-- Dropdown - User Information -->
            <div
                class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown"
                style="margin-top: 0"
            >
                <a
                    class="dropdown-item"
                    href="{{ route('nguoidung.gethoso',['id'=>Auth::user()->id]) }}"
                >
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray"></i>
                    Hồ sơ cá nhân
                </a>
                <a
                    class="dropdown-item"
                    href="{{ route('nguoidung.getdoimatkhau',['id'=>Auth::user()->id]) }}"
                >
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray"></i>
                    Đổi mật khẩu
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('DangXuat') }}">
                    <i
                        class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray"
                    ></i>
                    Đăng xuất
                </a>
            </div>
        </li>
    </ul>
</nav>
