@extends('layout.app')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Produk {{ $produk->nama_produk }}</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Produk {{ $produk->nama_produk }}</h6>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kategori</th>
                                <th>Jenis</th>
                                <th>Harga</th>
                                <th>Warna</th>
                                <th>Ukuran</th>
                                <th>Stok</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detailProdukGrouped as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->produk->kategori_produk }}</td>
                                    <td>{{ $item->produk->jenis_produk }}</td>
                                    <td>Rp. {{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                                    <td>{{ $item->warna }}</td>
                                    <td>{{ $item->ukuran }}</td>
                                    <td>{{ $item->count }}</td>
                                    <td class="d-flex justify-content-center">
                                        <a href="#" class="btn btn-sm btn-info mr-2" data-toggle="modal" data-target="#modalDetail{{ $item->id_produk }}">Detail</a>
                                        <a href="#" class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-target="#modalEdit{{ $item->id_produk }}">Edit</a>
                                        <a href="#" class="btn btn-sm btn-danger mr-2" data-toggle="modal" data-target="#modalDelete{{ $item->id_produk }}">Delete</a>
                                    </td>
                                {{-- </tr>
                                @include('produsen.asset.produk.edit-produk', ['item' => $item])
                                @include('produsen.asset.produk.detail-produk', ['item' => $item])
                                @include('produsen.asset.produk.delete-produk', ['item' => $item])
                                @include('produsen.asset.produk.tambah-stok', ['item' => $item]) --}}
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ url()->previous() }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-3" id="checkout-button"> Kembali</a>
                </div>
            </div>
        </div>
    </div>

    @include('produsen.asset.produk.tambah-produk')
    @include('validasi.notifikasi')
    @include('validasi.notifikasi-error')
    
@endsection
