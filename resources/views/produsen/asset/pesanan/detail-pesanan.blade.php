@extends('layout.app')

@section('content')
    <div class="container-fluid px-4">
        <!-- Knowledge base article-->
        <h1>Detail Pesanan</h1>
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>ID Pesanan: {{ $pesanan->id_pesanan }}</strong>
                <div class="d-flex ms-auto">
                    @if ($pesanan->status_pesanan == 'accepted')
                        <a target="_blank" href="{{ route('produsen.pesanan-cetak-pdf', ['id' => $pesanan->id_pesanan]) }}" class="btn btn-sm btn-primary me-2 shadow-sm">
                            <i class="fas fa-download fa-sm text-white-50"></i> Cetak
                        </a>
                    @endif
                    <div class="dropdown no-arrow">
                        <button style="margin-left: 3px" class="btn btn-sm btn-primary shadow-sm dropdown-toggle" type="button"
                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            Verifikasi
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <form action="{{ route('produsen.update-status-pesanan', ['id' => $pesanan->id_pesanan]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="pending">
                                <button class="dropdown-item" type="submit">Pending</button>
                            </form>
                            <form action="{{ route('produsen.update-status-pesanan', ['id' => $pesanan->id_pesanan]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="accepted">
                                <button class="dropdown-item" type="submit">Accepted</button>
                            </form>
                            <form action="{{ route('produsen.update-status-pesanan', ['id' => $pesanan->id_pesanan]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="rejected">
                                <button class="dropdown-item" type="submit">Rejected</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <p><strong>Tanggal Pesan:</strong> {{ \App\Helpers\DateHelper::formatTanggal($pesanan->tanggal_pesan) }}</p>
                <p><strong>Status Pesanan:</strong> <span class="badge rounded-pill @if ($pesanan->status_pesanan == 'pending')
                    badge-info 
                @elseif ($pesanan->status_pesanan == 'accepted')
                    badge-success 
                @elseif ($pesanan->status_pesanan == 'rejected')
                    badge-danger
                @else
                    badge-secondary
                @endif" >{{ $pesanan->status_pesanan }}</span></p>
                @php
                    $jmlhPesanan = $pesanan->detail_pesanan->count();
                @endphp
                <p><strong>Jumlah Pesanan: </strong> {{ $jmlhPesanan }} Unit</p>
            </div>
        </div>

        <h2>Detail Produk</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Warna</th>
                    <th>Ukuran</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalHarga = 0;
                @endphp
                @foreach ($pesanan->detail_pesanan as $detail)
                    <tr>
                        <td>{{ $detail->detail_produk->produk->nama_produk }}</td>
                        <td>{{ $detail->detail_produk->warna }}</td>
                        <td>{{ $detail->detail_produk->ukuran }}</td>
                        <td>Rp. {{ number_format($detail->detail_produk->produk->harga, 0, ',', '.') }}</td>
                    </tr>
                    @php
                        $totalHarga += $detail->detail_produk->produk->harga;
                    @endphp
                @endforeach
                <tr>
                    <td colspan="3" class="text-end font-weight-bolder">Total Keseluruhan :</td>
                    <td colspan="2" class="font-weight-bolder">Rp. {{ number_format($totalHarga, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
        <a href="{{ route('produsen.kelola-pesanan') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-3" id="checkout-button"> Kembali</a>
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
</script>

    @include('validasi.notifikasi')
    @include('validasi.notifikasi-error')
@endsection
