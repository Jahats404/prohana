@extends('layout.app')

@section('content')
    <div class="container-fluid px-4">
        <!-- Knowledge base article-->
        <h1>Detail Pengiriman</h1>
        <div class="card mb-3">
            <div class="card-header">
                <strong>ID Pengiriman:</strong> {{ $pengiriman->id_pengiriman }}
            </div>
            <div class="card-body">
                <p><strong>Distributor:</strong> {{ $pengiriman->distributor->nama_distributor }}</p>
                <p><strong>Nama Agen:</strong> {{ $pengiriman->pesanan->agen->nama_agen }}</p>
                <p><strong>Status Pengiriman:</strong> 
                    <span class="badge rounded-pill 
                        @if ($pengiriman->status_pengiriman == 'Sedang Diproses')
                            badge-info 
                        @elseif ($pengiriman->status_pengiriman == 'Dalam Perjalanan')
                            badge-warning 
                        @elseif ($pengiriman->status_pengiriman == 'Sampai Tujuan')
                            badge-success
                        @else
                            badge-secondary
                        @endif
                    ">
                        {{ $pengiriman->status_pengiriman }}
                    </span>
                </p>
                <p><strong>Jenis Pengiriman:</strong> {{ $pengiriman->jenis_pengiriman }}</p>
                <p><strong>Tanggal Pengiriman:</strong> {{ \App\Helpers\DateHelper::formatTanggal($pengiriman->tanggal_pengiriman) }}</p>
            </div>
        </div>
        <a href="{{ url()->previous() }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-3" id="checkout-button"> Kembali</a>
    </div>
    
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('.validate-button').on('click', function() {
            var status = $(this).data('status');
            console.log(status);
            $('#statusPesanan').text(status);
            $('#statusPesananInput').val(status);
        });
    </script>
    
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusForms = document.querySelectorAll('.dropdown-menu form');
        const currentStatus = '{{ $pesanan->status_pesanan }}';

        statusForms.forEach(form => {
            form.addEventListener('submit', function(event) {
                const newStatus = form.querySelector('input[name="status"]').value;

                if (currentStatus === 'accepted' && (newStatus === 'pending' || newStatus === 'rejected')) {
                    event.preventDefault(); // Prevent form submission

                    Swal.fire({
                        icon: 'warning',
                        title: 'Status Tidak Bisa Diubah',
                        text: 'Pesanan yang sudah diterima tidak bisa diubah ke Pending atau Rejected.',
                        confirmButtonText: 'Tutup'
                    });
                } else if (currentStatus === 'accepted' && newStatus === 'accepted') {
                    event.preventDefault(); // Prevent form submission

                    Swal.fire({
                        icon: 'info',
                        title: 'Info',
                        text: 'Pesanan sudah di-accept.',
                        confirmButtonText: 'Tutup'
                    });
                }
            });
        });
    });
</script> --}}

    @include('validasi.notifikasi')
    @include('validasi.notifikasi-error')
@endsection
