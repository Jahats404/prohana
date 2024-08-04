@extends('layout.app')

@section('content')
    <div class="container-fluid px-4">
        <!-- Knowledge base article-->
        <h1>Detail : {{ $product->nama_produk }}</h1>
    <p><strong>Harga:</strong> Rp. {{ number_format($product->harga, 2, ',', '.') }}</p>

    <h2>Detail Produk</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Warna</th>
                <th>Ukuran</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detailProdukGrouped as $detail)
                <tr>
                    <td>{{ $detail['warna'] }}</td>
                    <td>{{ $detail['ukuran'] }}</td>
                    <td>{{ $detail['stok'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
        <a href="{{ url()->previous() }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-3" id="checkout-button"> Kembali</a>
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

    @include('validasi.notifikasi')
    @include('validasi.notifikasi-error')
@endsection
