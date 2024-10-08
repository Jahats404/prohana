@extends('layout.app')

@section('content')
    <div class="container-fluid px-4">
        <!-- Knowledge base article-->
        <h1>Detail Produk</h1>
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <strong>ID Garansi: {{ $dtProduk->garansi->id_garansi }}</strong>
                @if ($dtProduk->garansi->status_garansi == 'Diajukan')
                    <form action="{{ route('produsen.verifikasi-garansi', Crypt::encrypt($dtProduk->garansi->id_garansi)) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="Diproses">
                        <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" type="submit">
                                Terima
                            </button>
                    </form>
                @elseif ($dtProduk->garansi->status_garansi == 'Pengiriman ke Produsen')
                    <form action="{{ route('produsen.verifikasi-garansi', Crypt::encrypt($dtProduk->garansi->id_garansi)) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="Selesai">
                        <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" type="submit">
                                Selesai
                            </button>
                    </form>
                @endif
            </div>
            <div class="card-body">
                <p><strong>Nama Produk : </strong> {{ $dtProduk->detail_produk->produk->nama_produk }}</p>
                <p><strong>Resi : </strong> {{ $dtProduk->detail_produk->resi }}</p>
                {{-- <p><strong>Tanggal Pesan:</strong> {{ \App\Helpers\DateHelper::formatTanggal($dtProduk->tanggal_pesan) }}</p> --}}
                <p><strong>Status Garansi:</strong>
                    @if ($dtProduk->garansi->status_garansi == 'Diajukan')
                        <span class="badge badge-info">{{ $dtProduk->garansi->status_garansi }}</span>
                    @elseif ($dtProduk->garansi->status_garansi == 'Aktif' || $dtProduk->garansi->status_garansi == 'Selesai')
                        <span class="badge badge-success">{{ $dtProduk->garansi->status_garansi }}</span>
                    @elseif ($dtProduk->garansi->status_garansi == 'Kadaluwarsa')
                        <span class="badge badge-danger">{{ $dtProduk->garansi->status_garansi }}</span>
                    @elseif ($dtProduk->garansi->status_garansi == 'Diproses')
                        <span class="badge badge-warning">{{ $dtProduk->garansi->status_garansi }}</span>
                    @elseif ($dtProduk->garansi->status_garansi == NULL)
                        <span class="badge badge-danger">{{ $dtProduk->garansi->status_garansi }}</span>
                    @else
                        <span class="badge badge-secondary">{{ $dtProduk->garansi->status_garansi }}</span>
                    @endif
                </p>
                <p><strong>Warna : </strong> {{ $dtProduk->detail_produk->warna }}</p>
                <p><strong>Ukuran : </strong> {{ $dtProduk->detail_produk->ukuran }}</p>
                <p><strong>Catatan Garansi : </strong> {{ $dtProduk->garansi->catatan_garansi }}</p>
            </div>
        </div>
        <a href="{{ route('produsen.kelola-garansi') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-3" id="checkout-button"> Kembali</a>
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
    
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusForms = document.querySelectorAll('.dropdown-menu form');
        const currentStatus = '{{ $dtProduk->status_pesanan }}';

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
</script>

    @include('validasi.notifikasi')
    @include('validasi.notifikasi-error')
@endsection
