<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="user" action="{{ route('produsen.store-distributor') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Distributor</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Nama Distributor</label>
                        <input type="text" class="form-control @error('nama_distributor') is-invalid @enderror" name="nama_distributor" value="{{ old('nama_distributor') }}">
                        @error('nama_distributor')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Alamat Distributor</label>
                        <input type="text" class="form-control @error('alamat_distributor') is-invalid @enderror" name="alamat_distributor" value="{{ old('alamat_distributor') }}">
                        @error('alamat_distributor')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Domisili Distributor</label>
                        <input type="text" class="form-control @error('domisili_distributor') is-invalid @enderror" name="domisili_distributor" value="{{ old('domisili_distributor') }}">
                        @error('domisili_distributor')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">No.Telp Distributor</label>
                        <input type="number" class="form-control @error('notelp_distributor') is-invalid @enderror" name="notelp_distributor" value="{{ old('notelp_distributor') }}">
                        @error('notelp_distributor')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
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
