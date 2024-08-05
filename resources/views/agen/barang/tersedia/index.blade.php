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
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Jenis</th>
                                    <th>Resi</th>
                                    <th>Warna</th>
                                    <th>Ukuran</th>
                                    <th>Status Garansi</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detailProduks as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->produk->nama_produk }}</td>
                                        <td>{{ $item->produk->kategori_produk }}</td>
                                        <td>{{ $item->produk->jenis_produk }}</td>
                                        <td>{{ $item->resi }}</td>
                                        <td>{{ $item->warna }}</td>
                                        <td>{{ $item->ukuran }}</td>
                                        <td class="text-center">
                                            @if ($item->detail_pesanan && $item->detail_pesanan->garansi)
                                                {{ $item->detail_pesanan->garansi->status_garansi }}
                                            @else
                                                <span class="text-center">-</span>
                                            @endif
                                        </td>
                                        @php
                                            $detailPesanan = $item->detail_pesanan->first();
                                            $coba = App\Models\DetailProduk::find('SP20240804J44M19');
                                            $garansi = App\Models\DetailPesanan::where('detail_produk_id',$item->resi)->first();
                                            $statusGaransi = isset($garansi->garansi) ? $garansi->garansi->status_garansi : 'Tidak ada data';
                                            $cekGaransi = $garansi->garansi;
                                            // dd($cekGaransi);
                                            // dd(now());
                                            // if ($coba && $detailPesanan) {
                                            //     if ($coba->status == 'Terjual' && $detailPesanan->tanggal_garansi > now()) {
                                            //         dd('dadi');
                                            //     } else {
                                            //         dd('radadi');
                                            //     }
                                            // } else {
                                            //     // Tangani kasus jika DetailProduk atau DetailPesanan tidak ditemukan
                                            //     dd('Data tidak ditemukan');
                                            // }
                                            // dd($detailPesanan->tanggal_garansi);
                                        @endphp
                                        <td class="d-flex justify-content-center">
                                            @if ($item->status == 'Terjual' && $detailPesanan->tanggal_garansi > now() && $cekGaransi == NULL)
                                            <a href="#" class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-target="#modalGaransi{{ $item->resi }}">Klaim Garansi</a>
                                            @elseif ($item->status == 'Dipesan' && $cekGaransi == NULL)
                                            <a href="{{ route('agen.barang-terjual', Crypt::encrypt($item->resi)) }}" class="btn btn-sm btn-primary mr-2">Terjual</a>
                                            @elseif ($statusGaransi == 'Diajukan')
                                            <a href="#" class="btn btn-sm btn-warning mr-2">Menunggu Konfirmasi</a>
                                            @else
                                            <a href="#" class="mr-2">-</a>
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

    @include('validasi.notifikasi')
    @include('validasi.notifikasi-error')
@endsection
