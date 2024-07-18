<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="form-prohana" class="user" action="{{ route('produsen.store-produk') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Produk</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" name="nama_produk" value="{{ old('nama_produk') }}">
                        @error('nama_produk')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jenis Produk</label>
                        <select class="form-control @error('jenis_produk') is-invalid @enderror" name="jenis_produk">
                            <option selected disabled>Pilih Jenis Produk</option>
                            <option value="sepatu" {{ old('jenis_produk') == 'sepatu' ? 'selected' : '' }}>Sepatu</option>
                            <option value="sandal" {{ old('jenis_produk') == 'sandal' ? 'selected' : '' }}>Sandal</option>
                            <option value="tas" {{ old('jenis_produk') == 'tas' ? 'selected' : '' }}>Tas</option>
                            <option value="jaket" {{ old('jenis_produk') == 'jaket' ? 'selected' : '' }}>Jaket</option>
                            <option value="sabuk" {{ old('jenis_produk') == 'sabuk' ? 'selected' : '' }}>Sabuk</option>
                        </select>
                        @error('jenis_produk')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kategori</label>
                        <select class="form-control @error('kategori_produk') is-invalid @enderror" name="kategori_produk">
                            <option selected disabled>Pilih Kategori</option>
                            <option value="pria" {{ old('kategori_produk') == 'pria' ? 'selected' : '' }}>Pria</option>
                            <option value="wanita" {{ old('kategori_produk') == 'wanita' ? 'selected' : '' }}>Wanita</option>
                            <option value="anak" {{ old('kategori_produk') == 'anak' ? 'selected' : '' }}>Anak</option>
                        </select>
                        @error('kategori_produk')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Harga</label>
                        <input type="number" class="form-control @error('harga') is-invalid @enderror" name="harga" value="{{ old('harga') }}">
                        @error('harga')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Upload Gambar</label>
                        <input type="file" class="form-control @error('foto_produk') is-invalid @enderror" name="foto_produk" id="gambar">
                        @error('foto_produk')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Preview Gambar</label>
                        <div>
                            <img id="preview" src="#" alt="Preview Gambar" style="max-width: 100%; display: none;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="cancelButton" class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('gambar').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('preview');

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }

        reader.readAsDataURL(file);
    } else {
        preview.src = '#';
        preview.style.display = 'none';
    }
});
</script>
