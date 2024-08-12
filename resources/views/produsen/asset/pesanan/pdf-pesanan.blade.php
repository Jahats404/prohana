<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Pesanan</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header Styles */
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header .company-info {
            margin-top: -15px;
        }

        .header .company-info img {
            max-width: 150px;
            height: auto;
        }

        .header .company-info h1 {
            margin: 10px 0;
            font-size: 24px;
            color: #333;
        }

        .header .company-info p {
            margin: 5px 0;
        }

        .header .document-title {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin-top: 20px; /* Ensures title is positioned under the border */
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .total-row td {
            font-weight: bold;
        }

        /* Badge Styles */
        .badge {
            padding: 5px 10px;
            border-radius: 12px;
            color: #fff;
            font-size: 14px;
        }

        .badge-info {
            background-color: #17a2b8;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-danger {
            background-color: #dc3545;
        }

        .badge-secondary {
            background-color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <!-- Logo -->
            <div class="logo">
                <img src="{{ public_path('img/LOGOPRORORO.png') }}" class="rounded mx-auto d-block" height="200px" width="200px" alt="Logo Organisasi">
            </div>
            <!-- Company Info -->
            <div class="company-info">
                <h1>Prohana</h1>
                <p>Kabupaten Cilacap</p>
                <p>Telp: (123) 456-7890</p>
            </div>
        </div>
        <!-- Title under the header line -->
        <div class="document-title">
            <h2>Detail Pesanan</h2>
        </div>

        <!-- Pesanan Details -->
        <p><strong>ID Pesanan:</strong> {{ $pesanan->id_pesanan }}</p>
        <p><strong>Tanggal Pesan:</strong> {{ \App\Helpers\DateHelper::formatTanggal($pesanan->tanggal_pesan) }}</p>
        <p><strong>Status Pesanan:</strong> 
            <span class="badge @if ($pesanan->status_pesanan == 'pending')
                badge-info 
            @elseif ($pesanan->status_pesanan == 'accepted')
                badge-success 
            @elseif ($pesanan->status_pesanan == 'rejected')
                badge-danger
            @else
                badge-secondary
            @endif">
            {{ $pesanan->status_pesanan }}
            </span>
        </p>
        <p><strong>Jumlah Pesanan:</strong> {{ $pesanan->detail_pesanan->count() }} Unit</p>

        <!-- Product Details -->
        <h2>Detail Produk</h2>
        <table>
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
                <tr class="total-row">
                    <td colspan="3">Total Keseluruhan:</td>
                    <td>Rp. {{ number_format($totalHarga, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
