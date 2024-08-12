@extends('layout.app')

@section('content')
    <div class="container-fluid">
        {{-- page header --}}
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            </div>

            <div class="card card-waves mb-4">
                <div class="card-body p-5">
                    <div class="row align-items-center justify-content-between">
                        <div class="col">
                            @if(Auth::check())
                                <h2 class="text-primary"><b>Hai, {{ Auth::user()->name }}!</b></h2>
                                <h4 class="text-primary">Selamat Datang di Prohana</h4>
                                <p class="text-gray-700" style="text-align: justify">Kami berharap Anda menikmati pengalaman
                                    mengelola bisnis bersama kami
                                    dengan fitur-fitur yang sudah kami buat! Salam hangat dari kami!</p>
                            @else
                                <h2 class="text-primary">Welcome to Prohana!</h2>
                                <p class="text-gray-700">Silakan login untuk menikmati pengalaman berjualan yang efektif dengan fitur-fitur kami seperti kelola asset, kelola pengguna, pesanan, dan lebih banyak lagi. Selalu semangat dan jangan ragu untuk menghubungi kami jika Anda memerlukan bantuan!</p>
                            @endif
                        </div>
                        <div class="col d-none d-lg-block mt-xxl-n4 text-center"><img class="img-fluid px-xl-4 mt-xxl-n5" width="400" src="https://sb-admin-pro.startbootstrap.com/assets/img/illustrations/statistics.svg"></div>
                    </div>
                </div>
            </div>
            <!-- Content Row -->
            <div class="row">

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Pesanan</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pesanan }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Produk Terjual</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahTerjual }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Row -->

            <div class="row">

                {{-- trend produk --}}
                <div class="col-xl-8 col-lg-3">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Grafik Trend Produk</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <canvas id="productTrendChart"></canvas>
                        </div>
                    </div>
                </div>


                <div class="col-lg-4 mb-3">

                    {{-- RECENT PRODUCTS --}}
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Produk Baru</h6>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @forelse ($recentProducts as $product)
                                    <a href="{{ route('produsen.kelola-produk') }}"
                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/produk/' . $product->foto_produk) }}"
                                                alt="Product Image" class="img-thumbnail"
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                            <div class="ml-3">
                                                <span class="font-weight-bold">{{ $product->nama_produk }}</span>
                                                <div class="text-muted small">{{ $product->kategori_produk }}</div>
                                            </div>
                                        </div>
                                        <span
                                            class="badge badge-success badge-pill">Rp.{{ number_format($product->harga, 0, ',', '.') }}</span>
                                    </a>
                                @empty
                                    <li class="list-group-item text-center">Tidak Ada Produk</li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('produsen.kelola-produk') }}" class="uppercase">Lihat Semua Produk</a>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/api/product-trends') // URL ke route yang mengembalikan data produk
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => item.nama_produk);
                    const quantities = data.map(item => item.jumlah_terjual);
        
                    const ctx = document.getElementById('productTrendChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Jumlah Terjual',
                                data: quantities,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
@endsection
