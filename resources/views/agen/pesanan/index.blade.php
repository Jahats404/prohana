@extends('layout.app')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pesanan</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Pesanan</h6>
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
                                <th>Pesanan</th>
                                <th>Status Pesanan</th>
                                <th>Total Harga</th>
                                <th>Tanggal Pesan</th>
                                <th>Garansi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pesanan as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>#{{ $item->id_pesanan }}</td>
                                    <td class="text-center">
                                        @if ($item->status_pesanan == 'pending')
                                            <span class="badge badge-info">{{ $item->status_pesanan }}</span>
                                        @elseif ($item->status_pesanan == 'accepted')
                                            <span class="badge badge-success">{{ $item->status_pesanan }}</span>
                                        @elseif ($item->status_pesanan == 'rejected')
                                            <span class="badge badge-danger">{{ $item->status_pesanan }}</span>
                                        @else
                                            <span class="badge badge-info">{{ $item->status_pesanan }}</span>
                                        @endif
                                    </td>
                                    <td>Rp. {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                    <td>{{ Carbon\Carbon::parse($item->tanggal_pesan)->translatedFormat('l, d-m-Y') }}</td>
                                    <td>
                                        @if ($item->detail_pesanan && $item->detail_pesanan->tanggal_garansi)
                                            {{ Carbon\Carbon::parse($item->detail_pesanan->tanggal_garansi)->translatedFormat('l, d-m-Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="d-flex justify-content-center">
                                        <a href="{{ route('agen.detail-pesanan', Crypt::encrypt($item->id_pesanan)) }}" class="btn btn-sm btn-info mr-2">Detail</a>
                                    </td>
                                </tr>
                            @endforeach



                                {{-- @include('produsen.pengguna.distributor.edit-distributor', ['item' => $item])
                                @include('produsen.pengguna.distributor.delete-distributor', ['item' => $item]) --}}

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('agen.pesanan.tambah-pesanan')
    @include('validasi.notifikasi')
    @include('validasi.notifikasi-error')
@endsection
