<div class="modal fade" id="modalKirim{{ $item->id_pesanan }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="user" action="{{ route('distributor.store-pengiriman') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h6 class="m-0 font-weight-bold text-primary">ID Pesanan #{{ $item->id_pesanan }}</h6>
                    <input value="{{ $item->id_pesanan }}" name="pesanan_id" id="" hidden>
                    <input value="Pesanan" name="jenis_pengiriman" id="" hidden>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Tanggal Pengiriman</label>
                        <input type="date" class="form-control @error('tanggal_pesan') is-invalid @enderror" name="tanggal_pengiriman" value="{{ old('tanggal_pengiriman') }}">
                        @error('tanggal_pengiriman')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <input type="hidden" name="status_pengiriman" value="pending">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-solid fa-paper-plane fa-sm fa-fw mr-2 text-gray-400"></i>Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>