<div class="row justify-content-center my-auto">
    <div class="col-md-8 col-lg-6 col-xl-4">
        <div class="text-center py-5">
            <div class="mb-4 mb-md-5">
                <img src="assets/images/logo/logoWhite.png" alt="logo">
            </div>
            <div class="text-muted mb-4">
                <h5>Reset Password</h5>
                <p>Re-Password.</p>
            </div>
            <div class="alert alert-success text-center mb-4" role="alert">
                Enter your Email and instructions will be sent to you!
            </div>
            <div>
                <div class="form-floating form-floating-custom mb-3">
                    <input type="email" class="form-control required email" id="recoverPassword-input-email" placeholder="Enter Email">
                    <label for="input-email">Email</label>
                    <div class="form-floating-icon"><i class="uil uil-envelope-alt"></i></div>
                </div>
                <div class="mt-3">
                    <button type="button" id="recoverPassword-btn-send" class="btn btn-info w-100">
                        <span id="recoverPassword-spinner-button-register" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
                        Send
                    </button>
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('login') }}" class="text-dark">Go back!</a>
                </div>
            </div>
        </div>
    </div>
</div>
@include('authentication.recoverPassword.js.recoverPasswordJS')