<div class="modal fade" id="modalStok{{ $item->id_produk }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Stok</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('produsen.tambah-stok-produk', $item->id_produk) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Stok</label>
                        <input type="number" class="form-control @error('stok') is-invalid @enderror" name="stok"
                            value="{{ old('stok') }}" min="1">
                        @error('stok')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Ukuran</label>
                        <input type="number" class="form-control @error('ukuran') is-invalid @enderror" name="ukuran"
                            value="{{ old('ukuran') }}" min="1">
                        @error('ukuran')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Warna</label>
                        <input type="text" class="form-control @error('warna') is-invalid @enderror" name="warna"
                            value="{{ old('warna') }}" min="1">
                        @error('warna')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
