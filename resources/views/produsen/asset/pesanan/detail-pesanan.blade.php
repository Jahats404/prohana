@extends('layout.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Knowledge base article-->
    <div class="card mb-4">
        <div class="card-header d-flex align-items-center">
            <a class="btn btn-transparent-dark btn-icon" href="{{ url()->previous() }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </a>
            <div class="ms-3">
                <h2 class="my-3">Detail Pesanan: #{{ $pesanan->id_pesanan }}</h2>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label class="form-label">Foto Produk:</label>
                <div>
                    <img src="{{ asset('storage/produk/' . $pesanan->produk->foto_produk) }}" alt="Foto Produk" style="max-width: 100%;">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Nama Produk:</label>
                <p>{{ $pesanan->produk->nama_produk }}</p>
            </div>
            <div class="form-group">
                <label class="form-label">Kategori:</label>
                <p>{{ $pesanan->produk->kategori_produk }}</p>
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal Pemesanan:</label>
                <p>{{ Carbon\Carbon::parse($pesanan->tanggal_pesan)->translatedFormat('l, d-m-Y') }}</p>
            </div>
            <div class="form-group">
                <label class="form-label">Status Pesanan:</label>
                <p class="badge
                @if ($pesanan->status_pesanan == 'pending')
                    badge-info
                @elseif ($pesanan->status_pesanan == 'accepted')
                    badge-success
                @elseif ($pesanan->status_pesanan == 'rejected')
                    badge-danger
                @else
                    badge-secondary
                @endif
                ">{{ $pesanan->status_pesanan }}</p>
                @if ($pesanan->status_pesanan == 'pending')
                    <div class="form-group">
                        <button type="button" class="validate-button btn btn-primary" data-toggle="modal" data-target="#statusModal" data-status="accepted">Accepted</button>
                        <button type="button" class="validate-button btn btn-danger" data-toggle="modal" data-target="#statusModal" data-status="rejected">Rejected</button>
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal Garansi:</label>
                <p>
                    @if ($pesanan->detail_pesanan && $pesanan->detail_pesanan->tanggal_garansi)
                        {{ Carbon\Carbon::parse($pesanan->detail_pesanan->tanggal_garansi)->translatedFormat('l, d-m-Y') }}
                    @else
                        -
                    @endif
                </p>
            </div>
            <div class="form-group">
                <label class="form-label">Total Harga:</label>
                <p>Rp. {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Validasi Status Pesanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin mengubah status pesanan ini menjadi <span id="statusPesanan"></span>?
            </div>
            <div class="modal-footer">
                <form id="statusForm" action="{{ route('produsen.update-status-pesanan', $pesanan->id_pesanan) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status_pesanan" id="statusPesananInput">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ya, Ubah</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('.validate-button').on('click', function() {
        var status = $(this).data('status');
        console.log(status);
        $('#statusPesanan').text(status);
        $('#statusPesananInput').val(status);
    });
</script>
@endsection
