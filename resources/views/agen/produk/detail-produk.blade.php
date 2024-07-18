<div class="modal fade" id="modalDetail{{ $item->id_produk }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Produk</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Produk:</label>
                    <p>{{ $item->nama_produk }}</p>
                </div>
                <div class="form-group">
                    <label class="form-label">Kategori:</label>
                    <p>{{ $item->kategori_produk }}</p>
                </div>
                <div class="form-group">
                    <label class="form-label">Jenis Produk:</label>
                    <p>{{ $item->jenis_produk }}</p>
                </div>
                <div class="form-group">
                    <label class="form-label">Harga:</label>
                    <p>Rp. {{ number_format($item->harga, 0, ',', '.') }}</p>
                </div>
                <div class="form-group">
                    <label class="form-label">Produsen:</label>
                    <p>{{ $item->produsen->nama_produsen }}</p>
                </div>
                <div class="form-group">
                    <label class="form-label">Foto Produk:</label>
                    <div>
                        <img src="{{ asset('storage/produk/' . $item->foto_produk) }}" alt="Foto Produk" style="max-width: 100%;">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
