@extends('layout.app')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pesanan</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="checkout-button"><i
                    class="fas fa-solid fa-cart-arrow-down fa-sm text-white-50"></i> Keranjang <span id="cart-count"
                    class="badge badge-light">0</span></a>

            {{-- Form Checkout --}}
            <form id="checkout-form" action="{{ route('agen.store-keranjang') }}" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="cart" id="cart-input">
            </form>
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
                            <h5 class="card-title text-primary">{{ $item->nama_produk }}</h5>
                            <p class="card-text">{{ $item->kategori_produk }} - {{ $item->jenis_produk }}</p>
                            <p class="card-text">Rp. {{ number_format($item->harga, 0, ',', '.') }}</p>
                            <!-- Inputan Warna -->
                            <div class="mb-2">
                                <label for="color-{{ $item->id_produk }}" class="form-label">Warna</label>
                                    @php
                                        $warna = App\Models\DetailProduk::where('produk_id', $item->id_produk)->where('status', 'Tersedia')->pluck('warna')->unique();
                                        $ukuran = App\Models\DetailProduk::where('produk_id', $item->id_produk)->where('status', 'Tersedia')->pluck('ukuran')->unique();
                                    @endphp
                                <select name="warna" id="color-{{ $item->id_produk }}" class="custom-select color">
                                    <option value="">-- Pilih Warna --</option>
                                    @foreach ($warna as $w)
                                        <option value="{{ $w }}">{{ $w }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Inputan Ukuran -->
                            <div class="mb-2">
                                <label for="size-{{ $item->id_produk }}" class="form-label">Ukuran</label>
                                <select name="ukuran" id="size-{{ $item->id_produk }}" class="custom-select size">
                                    <option value="">-- Pilih ukuran --</option>
                                    @foreach ($ukuran as $u)
                                        <option value="{{ $u }}">{{ $u }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a href="{{ route('agen.detail-produk', ['id' => $item->id_produk]) }}" class="btn btn-sm btn-outline-secondary mr-1">Detail</a>
                                    <button type="button" class="btn btn-sm btn-outline-secondary add-to-cart"
                                        data-id="{{ $item->id_produk }}"><i
                                            class="fas fa-solid fa-cart-arrow-down fa-sm fa-fw mr-2 text-gray-400"></i>Masukkan Keranjang</button>
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
                    const colorInput = cardBody.querySelector('.color');
                    const sizeInput = cardBody.querySelector('.size');
                    const quantity = parseInt(quantityInput.value);
                    const color = colorInput.value.trim();
                    const size = sizeInput.value.trim();
                    const productId = this.getAttribute('data-id');

                    if (!color) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian!',
                            text: 'Masukkan warna produk!'
                        });
                        return;
                    }

                    if (!size) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian!',
                            text: 'Masukkan ukuran produk!'
                        });
                        return;
                    }

                    if (!quantity || quantity < 1) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian!',
                            text: 'Masukkan jumlah item yang valid terlebih dahulu!'
                        });
                        return;
                    }

                    cartCount += quantity;
                    cart.push({
                        id_produk: productId,
                        jumlah: quantity,
                        warna: color,
                        ukuran: size
                    });
                    document.getElementById('cart-count').innerText = cartCount;
                    console.log('Item added to cart:', {
                        id_produk: productId,
                        jumlah: quantity,
                        warna: color,
                        ukuran: size
                    });

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Produk berhasil ditambahkan ke keranjang. Silahkan klik tombol Keranjang dipojok kanan atas',
                        showConfirmButton: true,
                    });
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

                // Set cart data to hidden input
                document.getElementById('cart-input').value = JSON.stringify(cart);

                // Submit the form
                document.getElementById('checkout-form').submit();
            });
        });
    </script>
    @include('agen.pesanan.tambah-pesanan')
    @include('validasi.notifikasi')
    @include('validasi.notifikasi-error')
@endsection
