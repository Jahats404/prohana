@extends('layout.app')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Kelola Pengiriman</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Pengiriman</h6>
                    {{-- <a class="btn btn-sm btn-primary" href="#" data-toggle="modal" data-target="#modaltambah">
                        <i class="fas fa-solid fa-user-plus fa-sm fa-fw mr-2 text-gray-400"></i>
                        Tambah
                    </a> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Agen</th>
                                <th>Status Pengiriman</th>
                                <th>Jenis Pengiriman</th>
                                <th>Tanggal Pengiriman</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengiriman as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->pesanan->agen->nama_agen }}</td>
                                    <td>
                                        <span class="badge rounded-pill 
                                        @if ($item->status_pengiriman == 'Sedang Diproses')
                                            badge-info 
                                        @elseif ($item->status_pengiriman == 'Dalam Perjalanan')
                                            badge-warning 
                                        @elseif ($item->status_pengiriman == 'Sampai Tujuan')
                                            badge-success
                                        @else
                                            badge-secondary
                                        @endif">
                                            {{ $item->status_pengiriman }}
                                        </span>
                                    </td>
                                    <td>{{ $item->jenis_pengiriman }}</td>
                                    <td>{{ \App\Helpers\DateHelper::formatTanggal($item->tanggal_pengiriman) }}</td>
                                    <td class="d-flex justify-content-center">
                                        <a href="{{ route('distributor.detail-pengiriman', Crypt::encrypt($item->id_pengiriman)) }}" class="btn btn-sm btn-warning mr-2">Detail</a>
            
                                        <div class="dropdown no-arrow mb-1">
                                            <button class="d-none d-sm-inline-block btn btn-primary btn-sm shadow-sm dropdown-toggle" type="button"
                                                id="dropdownMenuButton{{ $item->id_pengiriman }}" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Ubah Status
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $item->id_pengiriman }}">
                                                <form action="{{ route('distributor.status-pengiriman', Crypt::encrypt($item->id_pengiriman)) }}" method="POST" data-current-status="{{ $item->status_pengiriman }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="Dalam Perjalanan">
                                                    <button class="dropdown-item">Dalam Perjalanan</button>
                                                </form>
                                                <form action="{{ route('distributor.status-pengiriman', Crypt::encrypt($item->id_pengiriman)) }}" method="POST" data-current-status="{{ $item->status_pengiriman }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="Sampai Tujuan">
                                                    <button class="dropdown-item">Sampai Tujuan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('.dropdown-menu form');

            forms.forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault(); // Cegah pengiriman form default

                    const currentStatus = form.getAttribute('data-current-status');
                    const newStatus = form.querySelector('input[name="status"]').value;

                    // Cek kondisi validasi
                    if (currentStatus === 'Sedang Diproses' && newStatus === 'Sampai Tujuan') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Status tidak bisa diubah langsung dari "Sedang Diproses" ke "Sampai Tujuan". Harus melalui "Dalam Perjalanan" terlebih dahulu.',
                        });
                    } else if (currentStatus === 'Sampai Tujuan' && newStatus === 'Dalam Perjalanan') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Status sudah "Sampai Tujuan" dan tidak bisa diubah kembali ke "Dalam Perjalanan".',
                        });
                    } else {
                        Swal.fire({
                            title: 'Konfirmasi',
                            text: "Apakah Anda yakin ingin mengubah status pengiriman?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, Ubah!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit(); // Kirim form jika dikonfirmasi
                            }
                        });
                    }
                });
            });
        });
    </script>


    @include('distributor.pengiriman.tambah-pengiriman')
    @include('validasi.notifikasi')
    @include('validasi.notifikasi-error')
@endsection
