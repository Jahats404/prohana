@extends('layout.app')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Kelola Distributor</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Distributor</h6>
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
                            @foreach ($distributor as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->nama_distributor }}</td>
                                    <td>{{ $item->alamat_distributor }}</td>
                                    <td>{{ $item->domisili_distributor }}</td>
                                    <td>{{ $item->notelp_distributor }}</td>
                                    <td class="d-flex justify-content-center">

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tambah --}}
    <div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="user" action="{{ route('produsen.store-distributor') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Distributor</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">Nama Distributor</label>
                            <input type="text" class="form-control @error('nama_distributor') is-invalid @enderror" name="nama_distributor">
                            @error('nama_distributor')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Alamat Distributor</label>
                            <input type="text" class="form-control @error('alamat_distributor') is-invalid @enderror" name="alamat_distributor">
                            @error('alamat_distributor')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Domisili Distributor</label>
                            <input type="text" class="form-control @error('domisili_distributor') is-invalid @enderror" name="domisili_distributor">
                            @error('domisili_distributor')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">No.Telp Distributor</label>
                            <input type="number" class="form-control @error('notelp_distributor') is-invalid @enderror" name="notelp_distributor">
                            @error('notelp_distributor')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('validasi.notifikasi')
    @include('validasi.notifikasi-error')
@endsection
