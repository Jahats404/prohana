<div class="modal fade" id="modalEdit{{ $item->id_produk }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="form-prohana" class="user" action="{{ route('produsen.edit-produk', $item->id_produk) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Produk</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" name="nama_produk" value="{{ $item->nama_produk }}">
                        @error('nama_produk')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kategori</label>
                        <input type="text" class="form-control @error('kategori_produk') is-invalid @enderror" name="kategori_produk" value="{{ $item->kategori_produk }}">
                        @error('kategori_produk')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jenis Produk</label>
                        <input type="text" class="form-control @error('jenis_produk') is-invalid @enderror" name="jenis_produk" value="{{ $item->jenis_produk }}">
                        @error('jenis_produk')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Harga</label>
                        <input type="number" class="form-control @error('harga') is-invalid @enderror" name="harga" value="{{ $item->harga }}">
                        @error('harga')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <input type="hidden" name="produsen_id" value="{{ Auth::user()->produsen->id_produsen }}">

                    <div class="form-group">
                        <label class="form-label">Upload Gambar</label>
                        <input type="file" class="form-control @error('foto_produk') is-invalid @enderror" name="foto_produk" id="gambar{{ $item->id_produk }}">
                        @error('foto_produk')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Preview Gambar</label>
                        <div>
                            <img id="preview{{ $item->id_produk }}" src="{{ asset('storage/produk/' . $item->foto_produk) }}" alt="Preview Gambar" style="max-width: 100%;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="cancelButton{{ $item->id_produk }}" class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('gambar{{ $item->id_produk }}').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('preview{{ $item->id_produk }}');

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

function clearForm{{ $item->id_produk }}() {
    document.getElementById('formEditProhana{{ $item->id_produk }}').reset();
    document.getElementById('preview{{ $item->id_produk }}').style.display = 'none';
}

document.getElementById('cancelButton{{ $item->id_produk }}').addEventListener('click', clearForm{{ $item->id_produk }});
document.querySelector('#modalEdit{{ $item->id_produk }} .close').addEventListener('click', clearForm{{ $item->id_produk }});
</script>
