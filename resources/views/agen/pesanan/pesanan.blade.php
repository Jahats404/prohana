@extends('layout.app')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pesanan</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="checkout-button"><i
                    class="fas fa-solid fa-cart-arrow-down fa-sm text-white-50"></i> Checkout <span id="cart-count"
                    class="badge badge-light">0</span></a>
        </div>

        <div class="row">
            @foreach ($produks as $item)
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="m-0 font-weight-bold text-primary">{{ $item->nama_produk }}</h6>
                                {{-- <a class="btn btn-sm btn-primary" href="#" data-toggle="modal" data-target="#modalKirim{{ $item->id_pesanan }}">
                                    <i class="fas fa-solid fa-paper-plane fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Kirim
                                </a> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <img src="{{ asset('storage/produk/' . $item->foto_produk) }}" class="card-img-top"
                                alt="{{ $item->nama_produk }}">
                            <h5 class="card-title">{{ $item->nama_produk }}</h5>
                            <p class="card-text">{{ $item->kategori_produk }} - {{ $item->jenis_produk }}</p>
                            <p class="card-text">Rp. {{ number_format($item->harga, 0, ',', '.') }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary mr-1">Detail</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary add-to-cart"><i
                                            class="fas fa-solid fa-cart-arrow-down fa-sm fa-fw mr-2 text-gray-400"></i>Keranjang</button>
                                </div>
                                <input type="number" min="1" placeholder="Jumlah"
                                    class="form-control w-25 quantity">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cartButtons = document.querySelectorAll('.add-to-cart');
            const checkoutButton = document.getElementById('checkout-button');
            let cartCount = 0;
            let cart = [];

            cartButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const cardBody = this.closest('.card-body');
                    const quantityInput = cardBody.querySelector('.quantity');
                    const quantity = parseInt(quantityInput.value);
                    const productId = cardBody.closest('.card').dataset.productId;

                    if (!quantity || quantity < 1) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Masukkan jumlah item yang valid terlebih dahulu!'
                        });
                    } else {
                        cartCount += quantity;
                        cart.push({
                            id_produk: productId,
                            jumlah: quantity
                        });
                        document.getElementById('cart-count').innerText = cartCount;
                        console.log('Item added to cart:', quantity);
                    }
                });
            });

            checkoutButton.addEventListener('click', function() {
                if (cart.length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Keranjang Anda kosong!'
                    });
                    return;
                }

                fetch('/checkout', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(cart)
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Produk berhasil ditambahkan ke keranjang.'
                        });
                        console.log('Success:', data);
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>
    @include('agen.pesanan.tambah-pesanan')
    @include('validasi.notifikasi')
    @include('validasi.notifikasi-error')
@endsection
