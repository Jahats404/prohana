@extends('layout.app')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Daftar Pemasukan</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Pemasukan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Agen</th>
                                <th>Tanggal Pesan</th>
                                <th>Status Pesanan</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pesanans as $pesanan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pesanan->agen->nama_agen }}</td>
                                    <td>{{ \App\Helpers\DateHelper::formatTanggal($pesanan->tanggal_pesan) }}</td>
                                    <td>{{ ucfirst($pesanan->status_pesanan) }}</td>
                                    <td>{{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            {{-- <tr>
                                <td colspan="4" class="text-right"><strong>Total Keseluruhan Harga:</strong></td>
                                <td><strong>Rp. {{ number_format($pesanans->sum('total_harga'), 0, ',', '.') }}</strong></td>
                            </tr> --}}
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
