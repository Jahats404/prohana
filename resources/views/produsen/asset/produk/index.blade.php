@extends('layout.app')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Kelola Produk</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Produk</h6>
                    <a class="btn btn-sm btn-primary" href="#" data-toggle="modal" data-target="#modaltambah">
                        <i class="fas fa-solid fa-user-plus fa-sm fa-fw mr-2 text-gray-400"></i>
                        Tambah
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Jenis</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produk as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_produk }}</td>
                                    <td>{{ $item->kategori_produk }}</td>
                                    <td>{{ $item->jenis_produk }}</td>
                                    <td>Rp. {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td class="d-flex justify-content-center">
                                        <a href="#" class="btn btn-sm btn-info mr-2" data-toggle="modal" data-target="#modalDetail{{ $item->id_produk }}">Detail</a>
                                        <a href="#" class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-target="#modalEdit{{ $item->id_produk }}">Edit</a>
                                        <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalDelete{{ $item->id_produk }}">Delete</a>
                                    </td>
                                </tr>
                                @include('produsen.asset.produk.edit-produk', ['item' => $item])
                                @include('produsen.asset.produk.detail-produk', ['item' => $item])
                                @include('produsen.asset.produk.delete-produk', ['item' => $item])
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('produsen.asset.produk.tambah-produk')
    @include('validasi.notifikasi')
    @include('validasi.notifikasi-error')
@endsection
