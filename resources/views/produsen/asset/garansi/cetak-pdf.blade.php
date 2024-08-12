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
    <h2>Daftar Garansi</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Garansi</th>
                <th>Nama Produk</th>
                <th>Resi</th>
                <th>Ukuran</th>
                <th>Warna</th>
                <th>Status Garansi</th>
                <th>Catatan Garansi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($garansi as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->id_garansi }}</td>
                <td>{{ $item->detail_pesanan->detail_produk->produk->nama_produk }}</td>
                <td>{{ $item->detail_pesanan->detail_produk->resi }}</td>
                <td>{{ $item->detail_pesanan->detail_produk->ukuran }}</td>
                <td>{{ $item->detail_pesanan->detail_produk->warna }}</td>
                <td>{{ $item->status_garansi }}</td>
                @if ($item->catatan_garansi == NULL)
                    <td>-</td>
                @else
                    <td>{{ $item->catatan_garansi }}</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
