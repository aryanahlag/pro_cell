@php
if (Auth::user()->role == "employee") {
    $employ = \App\Employee::where("user_id", Auth::id())->first();
    $slug = $employ->cabang->slug;
}else{
    $employ = '';
}
@endphp
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
        <a class="nav-link {{ $activePage == 'dashboard' ? ' active' : '' }}" href="" aria-disabled="">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    @if (!Auth::guest())
        @if(Auth::user()->role == 'admin')
        <!-- Nav Item - Tables -->
            <div class="sidebar-heading">
                Transaksi
            </div>
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-shopping-cart"></i>
                    <span>Pembelian</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Pembelian:</h6>
                        <a class="collapse-item {{ $activePage == 'pembelian' ? ' active' : '' }}" href="{{ route('admin.generation.index') }}">Pembelian</a>
                        <a class="collapse-item {{ $activePage == 'stock' ? ' active' : '' }}" href="{{ route('admin.stock-generation.index') }}">Stok</a>
                        <a class="collapse-item {{ $activePage == 'laporan-pembelian' ? ' active' : '' }}" href="utilities-">Laporan Pembelian</a>
                    </div>
                </div>
        </li>
        <li class="nav-item {{ $activePage == 'pengajuan' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('admin.index-sub') }}">
                <i class="fa fa-list-alt"></i>
                <span>Pengajuan</span></a>
        </li>
        <li class="nav-item {{ $activePage == 'pengiriman' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('admin.stock-distribution.shipment.index') }}">
                <i class="fa fa-share-square"></i>
                <span>Pengiriman</span></a>
        </li>
        <div class="sidebar-heading">
                Lainnya
            </div>
            <li class="nav-item {{ $activePage == 'kategori' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('admin.category.index') }}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Kategori</span></a>
            </li>
            <li class="nav-item {{ $activePage == 'merek' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('admin.brand.index') }}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Merek</span></a>
            </li>
            <li class="nav-item {{ $activePage == 'barcode' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('card.index') }}">
                    <i class="fa fa-barcode"></i>
                    <span>Barkode</span></a>
            </li>
            <li class="nav-item {{ $activePage == 'suplier' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('admin.suplier.index') }}">
                    <i class="fa fa-user-plus"></i>
                    <span>Suplier</span></a>
            </li>
            <li class="nav-item {{ $activePage == 'karyawan-buat' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('admin.makeEmployee.index') }}">
                    <i class="fas fa-user-tie"></i>
                    <span>Karyawan</span></a>
            </li>
            <li class="nav-item {{ $activePage == 'cabang' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('admin.cabang.index') }}">
                    <i class="fas fa-store"></i>
                    <span>Cabang</span></a>
            </li>
            {{-- employee --}}
        @elseif(Auth::user()->role == 'employee')
        <div class="sidebar-heading">
            Transaksi
        </div>
        <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Penjualan</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Penjualan:</h6>
                        <a class="collapse-item {{ $activePage == 'penjualan' ? ' active' : '' }}" href="{{ route('employee.selling.create') }}">Penjualan</a>
                        @if($employ->level == "store leader")
                        <a class="collapse-item {{ $activePage == 'laporan-penjualan' ? ' active' : '' }}" href="">Laporan Penjualan</a>
                        @endif
                    </div>
                </div>
        </li>
        <li class="nav-item {{ $activePage == 'service' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('employee.service.index', ["cabang" => $slug]) }}">
                <i class="fas fa-fw fa-chart-area"></i>
            <span>Service</span></a>
        </li>
        @if($employ->level == "store leader")
        <li class="nav-item {{ $activePage == 'stock-distribution' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('employee.stock-distribution.index', ['cabnag' => $slug]) }}">
            <i class="fa fa-dropbox"></i>
            <span>Barang Toko</span></a>
        </li>
        @endif
        @else
        <li class="nav-item">
            <a class="nav-link" href="">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Kamu siapa</span></a>
        </li>
        @endif
    @endif
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
