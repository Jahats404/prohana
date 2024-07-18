<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="form-prohana" class="user" action="{{ route('agen.store-pesanan') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Pesanan</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Pilih Produk</label>
                        <select name="produk_id" class="custom-select" aria-label="Default select example">
                            <option selected>Pilih Produk</option>
                            @foreach ($produks as $item)
                                <option value="{{ $item->id_produk }}">{{ $item->nama_produk }}</option>
                            @endforeach
                        </select>
                        @error('nama_distributor')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Pesanan</label>
                        <input type="date" class="form-control @error('tanggal_pesan') is-invalid @enderror" name="tanggal_pesan" value="{{ old('tanggal_pesan') }}">
                        @error('tanggal_pesan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <input type="hidden" name="status_pesanan" value="pending">
                    <div class="form-group">
                        <label class="form-label">Jumlah</label>
                        <input type="number" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ old('jumlah') }}">
                        @error('jumlah')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Total Harga</label>
                        <input type="text" class="form-control" id="formatted_total_harga" value="{{ old('total_harga') }}" readonly>
                        <input type="hidden" class="form-control @error('total_harga') is-invalid @enderror" name="total_harga" value="{{ old('total_harga') }}">
                        @error('total_harga')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('select[name="produk_id"], input[name="jumlah"]').on('change input', function() {
        var produkId = $('select[name="produk_id"]').val();
        var jumlah = parseInt($('input[name="jumlah"]').val());
        var totalHargaInput = $('input[name="total_harga"]');
        var formattedTotalHargaInput = $('#formatted_total_harga');

        if (produkId && jumlah && jumlah > 0) {
            $.getJSON(`/api/product-price/${produkId}`, function(data) {
                if (data.harga) {
                    var total = data.harga * jumlah;
                    // Format as Rupiah currency for display
                    var formattedTotal = new Intl.NumberFormat('id-ID', {
                        style: 'decimal',
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }).format(total);
                    formattedTotalHargaInput.val('Rp ' + formattedTotal);
                    totalHargaInput.val(total); // Update the hidden input to be submitted with the form
                }
            }).fail(function() {
                console.log("Error retrieving product price.");
            });
        } else {
            formattedTotalHargaInput.val(''); // Clear the field if inputs are not valid
            totalHargaInput.val('');
        }
    });
});
</script>



