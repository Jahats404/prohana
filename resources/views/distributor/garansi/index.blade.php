@extends('layout.app')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Daftar Garansi</h1>
        </div>

        @if ($garansi->isNotEmpty())
            <div class="row">
                @foreach($garansi as $item)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="m-0 font-weight-bold text-primary">Garansi #{{ $loop->iteration }}</h6>
                                    @php
                                        // dd($item->status_garansi);
                                    @endphp
                                    @if ($item->status_garansi == 'Diproses')
                                        <a class="btn btn-sm btn-primary" href="#" data-toggle="modal" data-target="#modalKirim{{ $item->id_garansi }}">
                                            <i class="fas fa-solid fa-paper-plane fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Kirim
                                        </a>
                                    @elseif ($item->status_garansi == 'Selesai')
                                    <a class="btn btn-sm btn-primary" href="#" data-toggle="modal" data-target="#modalPengembalian{{ $item->id_garansi }}">
                                        <i class="fas fa-solid fa-paper-plane fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Kirim
                                    </a>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    <strong>ID Garansi:</strong> {{ $item->id_garansi }}<br>
                                    <strong>Nama Agen:</strong> {{ $item->detail_pesanan->pesanan->agen->nama_agen }}<br>
                                    <strong>Domisili Agen:</strong> {{ $item->detail_pesanan->pesanan->agen->domisili_agen }}<br>
                                    {{-- <strong>Tanggal Pesan:</strong> {{ \App\Helpers\DateHelper::formatTanggal($item->tanggal_pesanan) }}<br> --}}
                                    <strong>Status:</strong> <span class="badge rounded-pill 
                                        @if ($item->status_garansi == 'Diproses')
                                            badge-info 
                                        @elseif ($item->status_garansi == 'Aktif' || $item->status_garansi == 'Selesai')
                                            badge-success 
                                        @elseif ($item->status_garansi == 'Kadaluwarsa')
                                            badge-danger
                                        @elseif ($item->status_garansi == 'Pengiriman')
                                            badge-warning
                                        @else
                                            badge-secondary
                                        @endif
                                    "> {{ $item->status_garansi }}</span>
                                </p>
                                <strong>Catatan Garansi :</strong> {{ $item->catatan_garansi }}<br>
                                <hr>
                                {{-- <a href="{{ route('distributor.show-pesanan', Crypt::encrypt($item->id_pesanan)) }}" class="btn btn-warning">Detail</a> --}}
                            </div>
                        </div>
                    </div>
                    @include('distributor.garansi.kirim-garansi', ['item' => $item])
                    @include('distributor.garansi.kirim-pengembalian', ['item' => $item])
                @endforeach
            </div>
        @else
            <hr>
            <p class="text-center">Tidak ada pesanan masuk</p>
        @endif
        
    </div>

    {{-- @include('distributor.pengiriman.tambah-pengiriman') --}}
    @include('validasi.notifikasi')
    @include('validasi.notifikasi-error')
@endsection
