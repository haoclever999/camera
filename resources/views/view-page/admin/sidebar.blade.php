<ul
    class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
    id="accordionSidebar"
>
    <!-- Sidebar - Brand -->
    <!-- <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.index') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a> -->
    <a
        class="sidebar-brand d-flex align-items-center justify-content-center"
        href="{{ route('admin.index') }}"
    >
        <img
            src="{{ asset('frontend/img/Logo_trong.png') }}"
            alt="HaoNganTelecom"
            width="100"
        />
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0" />

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Trang quản trị</span></a
        >
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider" />

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('thuonghieu.index') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Thương hiệu</span></a
        >
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('danhmuc.index') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Danh mục sản phẩm</span></a
        >
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('sanpham.index') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Sản phẩm</span></a
        >
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('donhang.index') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Đơn đặt hàng</span></a
        >
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider" />
    @if(auth()->check() && auth()->user()->quyen=='Quản trị')
    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('nguoidung.index') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Quản lý người dùng</span></a
        >
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider" />
    @endif
    <li class="nav-item">
        <a class="nav-link" href="{{ route('cauhinh.index') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Cấu hình</span></a
        >
    </li>

    <hr class="sidebar-divider d-none d-md-block" />

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
