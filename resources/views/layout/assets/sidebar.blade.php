<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    

    <!-- Divider -->
    <hr class="sidebar-divider">


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
    @if(Auth::user()->role_id == 1)
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
        <li class="nav-item {{ Request::routeIs('produsen.kelola-pengiriman') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('produsen.kelola-pengiriman') }}">
                <i class="fas fa-fw fa-truck"></i>
                <span>Pengiriman</span></a>
        </li>
    @endif
@endauth

@auth
    @if(Auth::user()->role_id == 2)
        <!-- Heading -->
        <li class="nav-item {{ Request::routeIs('distributor.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('distributor.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
        <div class="sidebar-heading">
            Asset
        </div>
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
    @if(Auth::user()->role_id == 3)
        <!-- Heading -->
        <li class="nav-item {{ Request::routeIs('agen.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('agen.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
        <div class="sidebar-heading">
            Pesanan
        </div>
        <li class="nav-item {{ Request::is('agen.pesanan') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('agen.pesanan') }}">
                <i class="fas fa-fw fa-box"></i>
                <span>Kelola Pesanan</span></a>
        </li>
        {{-- <li class="nav-item {{ Request::is('produsen.kelola-pesanan') ? 'active' : '' }}">
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

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
