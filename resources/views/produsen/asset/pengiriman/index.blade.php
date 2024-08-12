@extends('layout.app')
@section('content')
<div class="container-fluid px-4 my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Daftar Pengiriman</h4>
        <form action="{{ route('produsen.pengiriman-cetak') }}" method="POST" target="_blank" id="printForm">
            @csrf
            <div class="d-flex align-items-center ms-auto">
                <input type="month" name="bulan" id="bulanFilter" class="form-control" required>
                <button type="submit" class="btn btn-sm btn-primary ml-2 ms-2 d-flex align-items-center" aria-label="Cetak">
                    <i class="fas fa-download fa-sm text-white-50"></i> Cetak
                </button>
            </div>
        </form>
    </div>

    <hr class="mt-2 mb-4">

    <div class="row" id="pengirimanList">
        @forelse ($pengiriman as $item)
        <div class="col-md-6 col-lg-4 mb-4">
            <a class="card card-icon lift lift-sm h-100" href="{{ route('produsen.show-pengiriman', Crypt::encrypt($item->id_pengiriman)) }}">
                <div class="row g-0 h-100">
                    <div class="col-auto card-icon-aside bg-primary d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box text-white-50 m-auto">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73L12 2 4 6.27A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73L12 22l8-4.27A2 2 0 0 0 21 16z"></path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                    </div>
                    <div class="col">
                        <div class="card-body py-2">
                            <h5 class="card-title text-primary mb-2">Distributor: {{ $item->distributor->nama_distributor }}</h5>
                            <p class="card-text mb-1">Tujuan: {{ $item->distributor->domisili_distributor }}</p>
                            <p class="card-text mb-1">Jenis Pengiriman: {{ $item->jenis_pengiriman }}</p>
                            <p class="card-text mb-1">Status Pengiriman: 
                                @if ($item->status_pengiriman == 'Sedang Diproses')
                                    <span class="badge badge-warning">{{ $item->status_pengiriman }}</span>
                                @elseif ($item->status_pengiriman == 'Dalam Perjalanan')
                                    <span class="badge badge-info">{{ $item->status_pengiriman }}</span>
                                @elseif ($item->status_pengiriman == 'Sampai Tujuan')
                                    <span class="badge badge-success">{{ $item->status_pengiriman }}</span>
                                @else
                                    <span class="badge badge-secondary">{{ $item->status_pengiriman }}</span>
                                @endif
                            </p>
                            {{-- <p class="card-text mb-1">Nama Agen: 
                                @if ($item->pesanan)
                                    {{ $item->pesanan->agen?->nama_agen }}
                                @elseif ($item->garansi)
                                    {{ $item->garansi->detail_pesanan?->pesanan?->agen?->nama_agen }}
                                @else
                                    {{ 'Data tidak tersedia' }}
                                @endif
                            </p> --}}
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12">
            <p class="text-center">Tidak ada pengiriman</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination links -->
    <div class="d-flex justify-content-center">
        {{ $pengiriman->links() }}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bulanFilter = document.querySelector('#bulanFilter');
        bulanFilter.addEventListener('change', function(event) {
            const bulan = event.target.value;
            filterDataByMonth(bulan);
        });
    });

    function filterDataByMonth(bulan) {
        console.log(`Filtering data for month: ${bulan}`);
        fetch(`/pengiriman/filter?bulan=${bulan}`)
            .then(response => response.json())
            .then(data => {
                updatePengirimanList(data);
            })
            .catch(error => console.error('Error:', error));
    }

    function updatePengirimanList(pengiriman) {
        const container = document.querySelector('#pengirimanList');

        // HTML Daftar Pengiriman
        const listHtml = pengiriman.length > 0
            ? pengiriman.map(item => `
                <div class="col-md-6 col-lg-4 mb-4">
                    <a class="card card-icon lift lift-sm h-100" href="/produsen/detail-pengiriman/${encodeURIComponent(item.encrypted_id)}">
                        <div class="row g-0 h-100">
                            <div class="col-auto card-icon-aside bg-primary d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box text-white-50 m-auto">
                                    <path d="M21 16V8a2 2 0 0 0-1-1.73L12 2 4 6.27A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73L12 22l8-4.27A2 2 0 0 0 21 16z"></path>
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                </svg>
                            </div>
                            <div class="col">
                                <div class="card-body py-2">
                                    <h5 class="card-title text-primary mb-2">Distributor: ${item.nama_distributor}</h5>
                                    <p class="card-text mb-1">Tujuan: ${item.domisili_distributor}</p>
                                    <p class="card-text mb-1">Jenis Pengiriman: ${item.jenis_pengiriman}</p>
                                    <p class="card-text mb-1">Status Pengiriman: 
                                        <span class="badge badge-${getStatusBadgeClass(item.status_pengiriman)}">${item.status_pengiriman}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            `).join('')
            : '<div class="col-12"><p class="text-center">Tidak ada pengiriman</p></div>';

        // Gabungkan header dan daftar pengiriman
        container.innerHTML = listHtml;
    }

    function getStatusBadgeClass(status) {
        switch (status) {
            case 'Sedang Diproses': return 'warning';
            case 'Dalam Perjalanan': return 'info';
            case 'Sampai Tujuan': return 'success';
            default: return 'secondary';
        }
    }
</script>

@endsection
