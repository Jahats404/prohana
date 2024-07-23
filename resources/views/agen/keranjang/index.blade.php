@extends('layout.app')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Kelola Keranjang</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Keranjang</h6>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($keranjang as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->produk->nama_produk }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td class="d-flex justify-content-center">
                                        <a href="#" class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-target="#modalEdit{{ $item->id_keranjang }}">Edit</a>
                                        <a href="#" class="btn btn-sm btn-danger mr-2" data-toggle="modal" data-target="#modalDelete{{ $item->id_keranjang }}">Delete</a>
                                        <form action="">
                                            <button class="btn btn-sm btn-secondary">Detail</button>
                                        </form>
                                    </td>
                                </tr>
                                @include('agen.keranjang.edit', ['item' => $item])
                                {{-- @include('produsen.pengguna.agen.delete-agen', ['item' => $item]) --}}
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('validasi.notifikasi')
    @include('validasi.notifikasi-error')
@endsection
