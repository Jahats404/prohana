<div class="modal fade" id="modalEdit{{ $item->id_agen }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="form-prohana" class="user" action="{{ route('produsen.update-agen', $item->id_agen) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Agen</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Nama Agen</label>
                        <input type="text" class="form-control @error('nama_agen') is-invalid @enderror" name="nama_agen" value="{{ $item->nama_agen }}">
                        @error('nama_agen')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Alamat Agen</label>
                        <input type="text" class="form-control @error('alamat_agen') is-invalid @enderror" name="alamat_agen" value="{{ $item->alamat_agen }}">
                        @error('alamat_agen')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Domisili Agen</label>
                        <input type="text" class="form-control @error('domisili_agen') is-invalid @enderror" name="domisili_agen" value="{{ $item->domisili_agen }}">
                        @error('domisili_agen')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">No.Telp Agen</label>
                        <input type="number" class="form-control @error('notelp_agen') is-invalid @enderror" name="notelp_agen" value="{{ $item->notelp_agen }}">
                        @error('notelp_agen')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $item->user->email }}">
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
