<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    @php
        $user = Auth()->user()->role->level;
        $level = strtolower($user);
    @endphp
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route($level.'.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-hand-spock"></i>
        </div>
        <div class="sidebar-brand-text mx-3">PROHANA</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">


    <!-- Heading -->
    {{-- <div class="sidebar-heading">
        Addons
    </div>

    <!-- Nav Item - Charts -->
    <li class="nav-item {{ Request::is('charts') ? 'active' : '' }}">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Charts</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item {{ Request::is('tables') ? 'active' : '' }}">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span></a>
    </li> --}}


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    @auth
        @if (Auth::user()->role_id == 1)
            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ Request::routeIs('produsen.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('produsen.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <!-- Heading -->
            <div class="sidebar-heading">
                Kelola Pengguna
            </div>

            <!-- Nav Item - Distributor -->
            <li class="nav-item {{ Request::routeIs('produsen.kelola-distributor') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('produsen.kelola-distributor') }}">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Distributor</span>
                </a>
            </li>

            <!-- Nav Item - Agen -->
            <li class="nav-item {{ Request::routeIs('produsen.kelola-agen') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('produsen.kelola-agen') }}">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Agen</span>
                </a>
            </li>
            <!-- Heading -->
            <div class="sidebar-heading">
                Asset
            </div>
            <li class="nav-item {{ Request::routeIs('produsen.kelola-produk') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('produsen.kelola-produk') }}">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Produk</span></a>
            </li>
            <li class="nav-item {{ Request::routeIs('produsen.kelola-pesanan') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('produsen.kelola-pesanan') }}">
                    <i class="fas fa-fw fa-archive"></i>
                    <span>Pesanan</span></a>
            </li>

            <div class="sidebar-heading">
                Garansi
            </div>
            <li class="nav-item {{ Request::routeIs('produsen.kelola-garansi') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('produsen.kelola-garansi') }}">
                    <i class="fas fa-fw fa-truck"></i>
                    <span>Daftar Garansi</span></a>
            </li>

            <div class="sidebar-heading">
                Pengiriman
            </div>
            <li class="nav-item {{ Request::routeIs('produsen.kelola-pengiriman') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('produsen.kelola-pengiriman') }}">
                    <i class="fas fa-fw fa-truck"></i>
                    <span>Pengiriman</span></a>
            </li>
        @endif
    @endauth

    @auth
        @if (Auth::user()->role_id == 2)
            <!-- Heading -->
            <li class="nav-item {{ Request::routeIs('distributor.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('distributor.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <div class="sidebar-heading">
                Asset
            </div>
            <!-- Nav Item - Agen -->
            <li class="nav-item {{ Request::routeIs('distributor.agen') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('distributor.agen') }}">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Agen</span>
                </a>
            </li>
            <li class="nav-item {{ Request::routeIs('distributor.pesanan') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('distributor.pesanan') }}">
                    <i class="fas fa-fw fa-archive"></i>
                    <span>Daftar Pesanan</span>
                </a>
            </li>
            <li class="nav-item {{ Request::routeIs('distributor.garansi') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('distributor.garansi') }}">
                    <i class="fas fa-fw fa-archive"></i>
                    <span>Daftar Garansi</span>
                </a>
            </li>
            <li class="nav-item {{ Request::routeIs('distributor.pengiriman') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('distributor.pengiriman') }}">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Kelola Pengiriman</span></a>
            </li>
            {{-- <li class="nav-item {{ Request::is('produsen.kelola-produk') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('produsen.kelola-produk') }}">
                <i class="fas fa-fw fa-box"></i>
                <span>Kelola Produk</span></a>
        </li>
        <li class="nav-item {{ Request::is('produsen.kelola-pesanan') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('produsen.kelola-pesanan') }}">
                <i class="fas fa-fw fa-archive"></i>
                <span>Pesanan</span></a>
        </li>
        <li class="nav-item {{ Request::is('produsen.kelola-pengiriman') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('produsen.kelola-pengiriman') }}">
                <i class="fas fa-fw fa-truck"></i>
                <span>Pengiriman Produk</span></a>
        </li> --}}
        @endif
    @endauth

    @auth
        @if (Auth::user()->role_id == 3)
            <!-- Heading -->
            <li class="nav-item {{ Request::routeIs('agen.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('agen.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="nav-item {{ Request::routeIs('agen.distributor') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('agen.distributor') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Distributor</span></a>
            </li>
            <div class="sidebar-heading">
                Pesanan
            </div>
            {{-- <li class="nav-item {{ Request::routeIs('agen.produk') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('agen.produk') }}">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Produk</span></a>
            </li> --}}
            <li class="nav-item {{ Request::routeIs('agen.pesanan') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('agen.pesanan') }}">
                    <i class="fas fa-fw fa-archive"></i>
                    <span>Daftar Produk</span></a>
            </li>
            {{-- <li class="nav-item {{ Request::routeIs('agen.keranjang') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('agen.keranjang') }}">
                    <i class="fas fa-fw fa-cart-arrow-down"></i>
                    <span>Daftar Keranjang</span></a>
            </li> --}}
            <li class="nav-item {{ Request::routeIs('agen.daftar-pesanan') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('agen.daftar-pesanan') }}">
                    <i class="fas fa-fw fa-archive"></i>
                    <span>Daftar Pesanan</span></a>
            </li>
            {{-- <li class="nav-item {{ Request::is('produsen.kelola-pesanan') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('produsen.kelola-pesanan') }}">
                    <i class="fas fa-fw fa-archive"></i>
                    <span>Pesanan</span></a>
            </li> --}}
            <div class="sidebar-heading">
                Pengiriman
            </div>
            <li class="nav-item {{ Request::RouteIs('agen.pengiriman') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('agen.pengiriman') }}">
                    <i class="fas fa-fw fa-truck"></i>
                    <span>Pengiriman Produk</span></a>
            </li>
            <li class="nav-item {{ Request::RouteIs('agen.pengiriman-garansi') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('agen.pengiriman-garansi') }}">
                    <i class="fas fa-fw fa-truck"></i>
                    <span>Pengiriman Garansi</span></a>
            </li>
            <div class="sidebar-heading">
                Barang
            </div>
            <li class="nav-item {{ Request::RouteIs('agen.barang-tersedia') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('agen.barang-tersedia') }}">
                    <i class="fas fa-fw fa-truck"></i>
                    <span>Barang Tersedia</span></a>
            </li>
            <div class="sidebar-heading">
                Garansi
            </div>
            <li class="nav-item {{ Request::RouteIs('agen.all-produk') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('agen.all-produk') }}">
                    <i class="fas fa-fw fa-truck"></i>
                    <span>Barang Tersedia</span></a>
            </li>
        @endif
    @endauth

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
