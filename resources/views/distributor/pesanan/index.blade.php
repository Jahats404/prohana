@extends('layout.app')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Daftar Pesanan</h1>
        </div>

        @if ($pesanan->isNotEmpty())
            <div class="row">
                @foreach($pesanan as $item)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="m-0 font-weight-bold text-primary">Pesanan #{{ $loop->iteration }}</h6>
                                    @if ($item->status_pesanan != 'accepted')
                                        
                                    @else
                                    <a class="btn btn-sm btn-primary" href="#" data-toggle="modal" data-target="#modalKirim{{ $item->id_pesanan }}">
                                        <i class="fas fa-solid fa-paper-plane fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Kirim
                                    </a>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    <strong>ID Pesanan:</strong> {{ $item->id_pesanan }}<br>
                                    <strong>Nama Agen:</strong> {{ $item->agen->nama_agen }}<br>
                                    <strong>Domisili Agen:</strong> {{ $item->agen->domisili_agen }}<br>
                                    <strong>Tanggal Pesan:</strong> {{ \App\Helpers\DateHelper::formatTanggal($item->tanggal_pesanan) }}<br>
                                    <strong>Status:</strong> <span class="badge rounded-pill 
                                        @if ($item->status_pesanan == 'pending')
                                            badge-info 
                                        @elseif ($item->status_pesanan == 'accepted')
                                            badge-success 
                                        @elseif ($item->status_pesanan == 'rejected')
                                            badge-danger
                                        @else
                                            badge-secondary
                                        @endif
                                    "> {{ $item->status_pesanan }}</span>
                                </p>
                                <hr>
                                <a href="{{ route('distributor.show-pesanan', Crypt::encrypt($item->id_pesanan)) }}" class="btn btn-warning">Detail</a>
                            </div>
                        </div>
                    </div>
                    @include('distributor.pesanan.kirim-pesanan', ['item' => $item])
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
