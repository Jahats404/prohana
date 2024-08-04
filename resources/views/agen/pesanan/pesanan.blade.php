@extends('layout.app')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pesanan</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="checkout-button"><i
                    class="fas fa-solid fa-cart-arrow-down fa-sm text-white-50"></i> Keranjang <span id="cart-count"
                    class="badge badge-light">0</span></a>
        </div>

        <div class="row">
            @foreach ($produks as $item)
                @php
                    $warna = App\Models\DetailProduk::where('produk_id', $item->id_produk)->where('status', 'Tersedia')->pluck('warna')->unique();
                    $warnaUkuran = App\Models\DetailProduk::where('produk_id', $item->id_produk)
                                    ->where('status', 'Tersedia')
                                    ->get()
                                    ->groupBy('warna')
                                    ->map(function($group) {
                                        return $group->pluck('ukuran')->unique();
                                    });
                                    // dd($warnaUkuran);
                @endphp
                <div class="col-md-4">
                    <div class="card shadow mb-2">
                        <div class="card-header py-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="m-0 font-weight-bold text-primary">{{ $item->nama_produk }}</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <img src="{{ asset('storage/produk/' . $item->foto_produk) }}" height="300" class="card-img-top mb-2"
                                alt="{{ $item->nama_produk }}">
                            <h5 class="card-title text-primary">{{ $item->nama_produk }}</h5>
                            <p class="card-text">{{ $item->kategori_produk }} - {{ $item->jenis_produk }}</p>
                            <p class="card-text product-price">Rp. {{ number_format($item->harga, 0, ',', '.') }}</p>
                            <!-- Inputan Warna -->
                            <div class="mb-2">
                                <label for="color-{{ $item->id_produk }}" class="form-label">Warna</label>
                                <select name="warna" id="color-{{ $item->id_produk }}" class="custom-select color" data-id="{{ $item->id_produk }}" data-ukuran="{{ json_encode($warnaUkuran) }}">
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
                                </select>
                            </div>
                            <!-- Tampilkan Stok -->
                            <div id="stock-info-{{ $item->id_produk }}" class="mb-2">
                                <p>Stok: <span id="stock-{{ $item->id_produk }}">-- --</span></p>
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

    <!-- Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cartModalLabel">Detail Keranjang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul id="cart-details" class="list-group">
                        <!-- Detail keranjang akan ditambahkan di sini -->
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <form id="checkout-form" method="POST" action="{{ route('agen.store-pesanan') }}">
                        @csrf
                        <input type="hidden" name="cart" id="cart-input">
                        <button type="submit" class="btn btn-primary">Checkout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cartButtons = document.querySelectorAll('.add-to-cart');
            const checkoutButton = document.getElementById('checkout-button');
            const cartDetailsList = document.getElementById('cart-details');
            let cartCount = 0;
            let cart = [];
            let stockAvailable = 0; // Variabel untuk menyimpan stok yang tersedia
    
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
                    const productName = cardBody.querySelector('.card-title').innerText;
                    const productPriceText = cardBody.querySelector('.product-price').innerText.replace('Rp. ', '').replace(/\./g, '');
                    const productPrice = parseFloat(productPriceText);
    
                    // Check for valid quantity
                    if (!quantity || quantity < 1) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Masukkan jumlah item yang valid terlebih dahulu!'
                        });
                        return;
                    }
    
                    // Check for valid color
                    if (!color) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian!',
                            text: 'Masukkan warna produk!'
                        });
                        return;
                    }
    
                    // Check for valid size
                    if (!size) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian!',
                            text: 'Masukkan ukuran produk!'
                        });
                        return;
                    }
    
                    // Check for valid price
                    if (isNaN(productPrice)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Harga produk tidak valid!'
                        });
                        return;
                    }
    
                    // Fetch stock information before adding to cart
                    fetch(`/stok/${productId}/${color}/${size}`)
                        .then(response => response.json())
                        .then(data => {
                            stockAvailable = data.stok || 0; // Update the available stock
                            
                            // Check if the requested quantity exceeds the available stock
                            if (quantity > stockAvailable) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Stok tidak mencukupi',
                                    text: `Jumlah yang diminta (${quantity}) melebihi stok yang tersedia (${stockAvailable}).`
                                });
                                return;
                            }
    
                            const totalHarga = productPrice * quantity;
    
                            cartCount += quantity;
                            cart.push({
                                id_produk: productId,
                                nama_produk: productName,
                                jumlah: quantity,
                                warna: color,
                                ukuran: size,
                                harga: productPrice,
                                total_harga: totalHarga
                            });
                            document.getElementById('cart-count').innerText = cartCount;
                            console.log('Item added to cart:', {
                                id_produk: productId,
                                nama_produk: productName,
                                jumlah: quantity,
                                warna: color,
                                ukuran: size,
                                harga: productPrice,
                                total_harga: totalHarga
                            });
    
                            // Show success alert
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Produk berhasil ditambahkan ke keranjang. Silahkan klik tombol Keranjang di pojok kanan atas',
                                showConfirmButton: true,
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching stock:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan saat memeriksa stok.'
                            });
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
    
                // Clear previous cart details
                cartDetailsList.innerHTML = '';
    
                // Add cart details to modal
                cart.forEach(item => {
                    const listItem = document.createElement('li');
                    listItem.classList.add('list-group-item');
                    listItem.innerHTML = `
                        <strong>Nama Produk:</strong> ${item.nama_produk} <br>
                        <strong>Jumlah:</strong> ${item.jumlah} <br>
                        <strong>Warna:</strong> ${item.warna} <br>
                        <strong>Ukuran:</strong> ${item.ukuran} <br>
                        <strong>Harga:</strong> Rp. ${item.harga.toLocaleString()} <br>
                        <strong>Total Harga:</strong> Rp. ${(item.total_harga).toLocaleString()} <br>
                        <input type="hidden" name="id_produk[]" value="${item.id_produk}">
                        <input type="hidden" name="harga[]" value="${item.harga}">
                        <input type="hidden" name="jumlah[]" value="${item.jumlah}">
                        <input type="hidden" name="total_harga[]" value="${item.total_harga}">
                    `;
                    cartDetailsList.appendChild(listItem);
                });
    
                // Set cart data to hidden input
                document.getElementById('cart-input').value = JSON.stringify(cart);
    
                // Show the modal
                $('#cartModal').modal('show');
            });
    
            // Update size dropdown and stock based on color selection
            document.querySelectorAll('.color').forEach(colorSelect => {
                const ukuranSelect = colorSelect.closest('.card-body').querySelector('.size');
                const stockInfo = colorSelect.closest('.card-body').querySelector(`#stock-${colorSelect.dataset.id}`);
                const warnaUkuran = JSON.parse(colorSelect.getAttribute('data-ukuran'));
    
                colorSelect.addEventListener('change', function() {
                    const selectedWarna = colorSelect.value;
                    ukuranSelect.innerHTML = '<option value="">-- Pilih ukuran --</option>'; // Clear previous options
                    stockInfo.textContent = '-- --'; // Reset stock info
    
                    if (selectedWarna && warnaUkuran[selectedWarna]) {
                        // Convert the sizes object to an array of values
                        const sizes = Object.values(warnaUkuran[selectedWarna]);
                        console.log(sizes); // Debugging purpose
    
                        if (sizes.length > 0) {
                            sizes.forEach(function(ukuran) {
                                const option = document.createElement('option');
                                option.value = ukuran;
                                option.textContent = ukuran;
                                ukuranSelect.appendChild(option);
                            });
                        } else {
                            // Option to indicate no sizes available for selected color
                            const option = document.createElement('option');
                            option.value = '';
                            option.textContent = '-- Ukuran tidak tersedia --';
                            ukuranSelect.appendChild(option);
                        }
                    } else {
                        // Handle case when selectedWarna does not have any sizes or not found
                        const option = document.createElement('option');
                        option.value = '';
                        option.textContent = '-- Pilih ukuran --';
                        ukuranSelect.appendChild(option);
                    }
                });
    
                // Update stock info based on size selection
                ukuranSelect.addEventListener('change', function() {
                    const selectedSize = ukuranSelect.value;
                    const selectedWarna = colorSelect.value;
                    const produkId = colorSelect.dataset.id;
    
                    if (selectedSize && selectedWarna && produkId) {
                        // Fetch stock information based on color and size
                        fetch(`/stok/${produkId}/${selectedWarna}/${selectedSize}`)
                            .then(response => response.json())
                            .then(data => {
                                stockAvailable = data.stok || 0; // Update the available stock
                                stockInfo.textContent = data.stok ? `Stok: ${data.stok}` : 'Data tidak tersedia';
                            })
                            .catch(error => {
                                console.error('Error fetching stock:', error);
                                stockInfo.textContent = 'Error fetching stock';
                            });
                    } else {
                        stockInfo.textContent = '-- --';
                    }
                });
            });
        });
    </script>
    
    
    @include('agen.pesanan.tambah-pesanan')
    @include('validasi.notifikasi')
    @include('validasi.notifikasi-error')
@endsection
