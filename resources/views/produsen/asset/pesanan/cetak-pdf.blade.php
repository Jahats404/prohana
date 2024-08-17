<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pesanan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 150px;
        }
        .company-details {
            text-align: center;
            margin-top: -40px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('img/LOGOPRORORO.png') }}" class="rounded mx-auto d-block" height="200px" width="700px" alt="Logo Organisasi">
    </div>
    <div class="company-details">
        <h1>Prohana</h1>
        <p>Cilacap, JL Rinjani</p>
        <p>Telepon: (123) 456-7890</p>
        <p>Email: info@perusahaan.com</p>
    </div>
    <h2>Daftar Pesanan</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                {{-- <th>ID Pesanan</th> --}}
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
                {{-- <td>{{ $pesanan->id_pesanan }}</td> --}}
                <td>{{ $pesanan->agen->nama_agen }}</td>
                <td>{{ \App\Helpers\DateHelper::formatTanggal($pesanan->tanggal_pesan) }}</td>
                <td>{{ ucfirst($pesanan->status_pesanan) }}</td>
                <td>{{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <!-- Baris untuk Total Keseluruhan -->
            <tr>
                <td colspan="4" style="text-align: right; font-weight: bold;">Total Keseluruhan Harga:</td>
                <td style="font-weight: bold;">Rp. {{ number_format($totals, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
    {{-- <p><strong>Total Keseluruhan Harga: Rp. {{ number_format($totals, 0, ',', '.') }}</strong></p> --}}
</body>
</html>
