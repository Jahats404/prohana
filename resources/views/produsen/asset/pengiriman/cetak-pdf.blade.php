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
    <h2>Daftar Pengiriman</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Pengiriman</th>
                <th>Nama Agen</th>
                <th>Tanggal Pengiriman</th>
                <th>Jenis Pengiriman</th>
                <th>Status Pesanan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengirimans as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->id_pengiriman }}</td>
                @if ($item->pesanan)
                    <td>{{ $item->pesanan->agen?->nama_agen }}</td>
                @elseif ($item->garansi)
                    <td>{{ $item->garansi->detail_pesanan?->pesanan?->agen?->nama_agen }}</td>
                @else
                    {{ 'Data tidak tersedia' }}
                @endif
                <td>{{ \App\Helpers\DateHelper::formatTanggal($item->tanggal_pesan) }}</td>
                <td>{{ $item->jenis_pengiriman }}</td>
                <td>{{ ucfirst($item->status_pengiriman) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
