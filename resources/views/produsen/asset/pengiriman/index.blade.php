@extends('layout.app')
@section('content')
<div class="container-fluid px-4 my-5">
    <h4 class="mb-0 mt-5">Daftar Pengiriman</h4>
    <hr class="mt-2 mb-4">

    <div class="row">
        @forelse ($pengiriman as $item)
        <div class="col-md-6 col-lg-4 mb-4">
            <a class="card card-icon lift lift-sm h-100" href="{{ route('produsen.show-produk', $item->id_pengiriman) }}">
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
                            <h5 class="card-title text-primary mb-2">Pesanan : {{ $item->produk->nama_produk }}</h5>
                            <p class="card-text mb-1">{{ $item->catatan_pesanan }}</p>
                            <p class="card-text mb-1">Status : {{ $item->status_pengiriman }}</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <p class="text-center m-auto">Tidak ada pengiriman</p>
        @endforelse
    </div>

    <!-- Pagination links -->
    <div class="d-flex justify-content-center">
        {{ $pengiriman->links() }}
    </div>
</div>
@endsection
