<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa fa-phone-square"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Zena<sup>cell</sup></div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link {{ $activePage == 'dashboard' ? ' active' : '' }}" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Transaksi
    </div>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Penjualan</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Penjualan:</h6>
                <a class="collapse-item {{ $activePage == 'penjualan' ? ' active' : '' }}" href="">Penualan</a>
                <a class="collapse-item {{ $activePage == 'laporan-penjualan' ? ' active' : '' }}" href="">Laporan Penjualan</a>
            </div>
        </div>
    </li>
    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Pembelian</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pembelian:</h6>
                <a class="collapse-item {{ $activePage == 'pembelian' ? ' active' : '' }}" href="utilities-">Pembelian</a>
                <a class="collapse-item {{ $activePage == 'laporan-pembelian' ? ' active' : '' }}" href="utilities-">Laporan Pembelian</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Service
    </div>
    <!-- Nav Item - Pages Collapse Menu -->
   {{--  <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Login Screens:</h6>
                <a class="collapse-item" href="">Login</a>
                <a class="collapse-item" href="">Register</a>
                <a class="collapse-item" href="forgot-">Forgot Password</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="">404 Page</a>
                <a class="collapse-item" href="">Blank Page</a>
            </div>
        </div>
    </li> --}}
    <!-- Nav Item - Charts -->
    <li class="nav-item {{ $activePage == 'service' ? ' active' : '' }}">
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Service</span></a>
    </li>
    <!-- Nav Item - Tables -->
    <div class="sidebar-heading">
        Lainnya
    </div>
    <li class="nav-item {{ $activePage == 'kategori' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('category.index') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>Kategori</span></a>
    </li>
    <li class="nav-item {{ $activePage == 'merek' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('brand.index') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>Merek</span></a>
    </li>
    {{-- <li class="nav-item">
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-table"></i>
            <span>Kategori</span></a>
    </li> --}}
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
