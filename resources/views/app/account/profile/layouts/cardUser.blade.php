<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12 text-center">
                <div class="avatar-xl mx-auto mb-4">
                    <img src="{{ url('assets/images/users/avatar.png') }}" alt="" class="rounded-circle img-thumbnail">
                </div>
                <h5 class="mb-1">{{$contact['user']}}</h5>
                <p>
                    <button id="btn-resetPassword" type="button" class="btn btn-outline-primary">
                        <span id="spinner-btn-resetPassword" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
                        <i class="bx bx bx-key "></i> Reset Password
                    </button>
                </p>
            </div>
        </div>
    </div>
</div>
