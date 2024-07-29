@extends('layout.app')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Produk</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $produk->nama_produk }}</h6>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <img src="{{ asset('storage/produk/' . $produk->foto_produk) }}" class="img-fluid" alt="{{ $produk->nama_produk }}">
                    </div>
                    <div class="col-md-6">
                        <h1 class="text-primary">{{ $produk->nama_produk }}</h1>
                        <p>Kategori: {{ $produk->kategori_produk }}</p>
                        <p>Jenis: {{ $produk->jenis_produk }}</p>
                        <p>Stok: {{ $produk->stok }}</p>
                        <p>Harga: Rp. {{ number_format($produk->harga, 0, ',', '.') }}</p>
                        <p>{{ $produk->deskripsi }}</p>
                        <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('validasi.notifikasi')
    @include('validasi.notifikasi-error')
@endsection
