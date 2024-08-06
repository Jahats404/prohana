@extends('layout.app')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Barang</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="m-0 font-weight-bold text-primary">Barang Tersedia</h6>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @if($detailProduks->isEmpty())
                    <p class="text-center">
                        Tidak ada produk.
                    </p>
                    @else
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Agen</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Jenis</th>
                                    <th>Resi</th>
                                    <th>Warna</th>
                                    <th>Ukuran</th>
                                    <th>Status Produk</th>
                                    <th>Status Garansi</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detailProduks as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->detail_pesanan->pesanan->agen->nama_agen }}</td>
                                        <td>{{ $item->produk->nama_produk }}</td>
                                        <td>{{ $item->produk->kategori_produk }}</td>
                                        <td>{{ $item->produk->jenis_produk }}</td>
                                        <td>{{ $item->resi }}</td>
                                        <td>{{ $item->warna }}</td>
                                        <td>{{ $item->ukuran }}</td>
                                        <td>
                                            @if ($item->status == 'Dipesan')
                                                Ready
                                            @else
                                                {{ $item->status }}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($item->detail_pesanan && $item->detail_pesanan->garansi)
                                                @if ($item->detail_pesanan->garansi->status_garansi == 'Aktif')
                                                    <span class="badge rounded-pill badge-success">{{ $item->detail_pesanan->garansi->status_garansi }}</span>
                                                @elseif ($item->detail_pesanan->garansi->status_garansi == 'Kadaluwarsa')
                                                <span class="badge rounded-pill badge-danger">{{ $item->detail_pesanan->garansi->status_garansi }}</span>
                                                @elseif ($item->detail_pesanan->garansi->status_garansi == 'Diproses')
                                                <span class="badge rounded-pill badge-info">{{ $item->detail_pesanan->garansi->status_garansi }}</span>
                                                @elseif ($item->detail_pesanan->garansi->status_garansi == 'Diajukan')
                                                <span class="badge rounded-pill badge-warning">{{ $item->detail_pesanan->garansi->status_garansi }}</span>
                                                @endif
                                            @else
                                                <span class="text-center">-</span>
                                            @endif
                                        </td>
                                        @php
                                            $detailPesanan = $item->detail_pesanan->first();
                                            // $coba = App\Models\DetailProduk::find('SP20240804J44M19');
                                            $garansi = App\Models\DetailPesanan::where('detail_produk_id',$item->resi)->first();
                                            $statusGaransi = isset($garansi->garansi) ? $garansi->garansi->status_garansi : 'Tidak ada data';
                                            $cekGaransi = $garansi->garansi;
                                            // dd($cekGaransi->status_garansi);
                                        @endphp
                                        <td class="d-flex justify-content-center">
                                            {{-- @if ($item->status == 'Terjual' && $detailPesanan->tanggal_garansi > now() && $cekGaransi == NULL) --}}
                                            @if ($item->status == 'Terjual' && $cekGaransi->status_garansi == 'Aktif')
                                            <a href="#" class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-target="#modalGaransi{{ $item->resi }}">Klaim Garansi</a>
                                            @elseif ($item->status == 'Dipesan' && $cekGaransi == NULL)
                                            <a href="{{ route('agen.barang-terjual', Crypt::encrypt($item->resi)) }}" id="sell-product" data-resi="{{ Crypt::encrypt($item->resi) }}" class="btn btn-sm btn-primary mr-2">Terjual</a>
                                            @elseif ($statusGaransi == 'Diajukan')
                                            -
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    @include('agen.barang.tersedia.klaim-garansi',['item' => $item])
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('sell-product').addEventListener('click', function(e) {
            e.preventDefault(); // Mencegah pengalihan otomatis

            // Menampilkan SweetAlert konfirmasi
            Swal.fire({
                title: 'Konfirmasi',
                text: "Apakah Anda yakin ingin menjual produk ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, jual!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna mengonfirmasi, arahkan ke URL
                    const resi = this.getAttribute('data-resi');
                    window.location.href = `{{ route('agen.barang-terjual', '') }}/${encodeURIComponent(resi)}`;
                }
            });
        });
    </script>

    @include('validasi.notifikasi')
    @include('validasi.notifikasi-error')
@endsection
