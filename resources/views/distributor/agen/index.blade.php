@extends('layout.app')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Kelola Agen</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Agen</h6>
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
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Domisili</th>
                                <th>No Telp</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($agen as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_agen }}</td>
                                    <td>{{ $item->alamat_agen }}</td>
                                    <td>{{ $item->domisili_agen }}</td>
                                    <td>{{ $item->notelp_agen }}</td>
                                    <td class="d-flex justify-content-center">
                                        <a href="#" class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-target="#modalEdit{{ $item->id_agen }}">Edit</a>
                                        <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalDelete{{ $item->id_agen }}">Delete</a>
                                    </td>
                                </tr>
                                {{-- @include('produsen.pengguna.agen.edit-agen', ['item' => $item])
                                @include('produsen.pengguna.agen.delete-agen', ['item' => $item]) --}}
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- @include('produsen.pengguna.agen.tambah-agen') --}}
    @include('validasi.notifikasi')
    @include('validasi.notifikasi-error')
@endsection
