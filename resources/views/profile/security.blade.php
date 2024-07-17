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
            <!-- Security card-->
            <div class="card mb-4">
                <div class="card-header">Security</div>
                <div class="card-body">
                    <form id="securityForm" action="{{ route('security.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- Form Group (username)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputUsername">Current Password</label>
                            <input class="form-control" id="inputUsername" type="password" placeholder="Enter your current password" name="current_password">
                        </div>
                        <!-- Form Group (new password)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputNewPassword">New Password</label>
                            <input class="form-control" name="new_password" id="inputNewPassword" type="password" placeholder="Enter your new password">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="inputConfirmPassword">Confirm Password</label>
                            <input class="form-control" name="new_password_confirmation" id="inputConfirmPassword" type="password" placeholder="Confirm your new password">
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
        Are you sure you want to update your password?
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
    document.getElementById('securityForm').submit();
}
</script>
@include('validasi.notifikasi')
@include('validasi.notifikasi-error')
@endsection
