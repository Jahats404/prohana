@extends('layout.app')

@section('content')
<div class="container-fluid px-4 mt-4">
    <!-- Account page navigation-->
    <nav class="nav nav-borders">
        <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }} ms-0" href="{{ route('profile') }}">Profile</a>
        <a class="nav-link {{ request()->routeIs('security') ? 'active' : '' }}" href="{{ route('security') }}">Security</a>
    </nav>
    <hr class="mt-0 mb-4">
    <div class="row">
        <div class="col-xl-12">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Account Details</div>
                <div class="card-body">
                    <form id="profileForm" action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- Form Group (username)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputUsername">Nama Lengkap</label>
                            <input class="form-control" id="inputUsername" type="text" placeholder="Enter your username" value="{{ auth()->user()->name }}" name="name">
                        </div>
                        <!-- Form Group (email address)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputEmailAddress">Email address</label>
                            <input class="form-control" name="email" id="inputEmailAddress" type="email" placeholder="Enter your email address" value="{{ auth()->user()->email }}">
                        </div>
                        <!-- Form Group (Address)-->
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Alamat</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Enter your address" name="alamat">@if (auth()->user()->role_id == 1){{ auth()->user()->produsen->alamat_produsen }}@elseif(auth()->user()->role_id == 2){{ auth()->user()->distributor->alamat_distributor }}@elseif (auth()->user()->role_id == 3){{ auth()->user()->agen->alamat_agen }}@endif
                            </textarea>
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (Domisili)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputLocation">Domisili</label>
                                <input class="form-control" id="inputLocation" type="text" placeholder="Enter your location" name="domisili" value="@if (auth()->user()->role_id == 1){{ auth()->user()->produsen->domisili_produsen }}@elseif(auth()->user()->role_id == 2){{ auth()->user()->distributor->domisili_distributor }}@elseif (auth()->user()->role_id == 3){{ auth()->user()->agen->domisili_agen }}@endif
                                ">
                            </div>
                            <!-- Form Group (Number Phone)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputPhone">No Telp</label>
                                <input class="form-control" id="inputPhone" type="number" placeholder="Enter your phone number" name="no_telp" value="@if (auth()->user()->role_id == 1){{ auth()->user()->produsen->notelp_produsen }}@elseif(auth()->user()->role_id == 2){{ auth()->user()->distributor->notelp_distributor }}@elseif (auth()->user()->role_id == 3){{ auth()->user()->agen->notelp_agen }}@endif">
                            </div>
                        </div>
                        <!-- Save changes button-->
                        <button class="btn btn-primary" type="button" onclick="showModal()">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="validationModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Confirm Changes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to update your profile?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="submitForm()">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script>
function showModal() {
    $('#validationModal').modal('show');
}

function submitForm() {
    document.getElementById('profileForm').submit();
}
</script>
@include('validasi.notifikasi')
@include('validasi.notifikasi-error')
@endsection
