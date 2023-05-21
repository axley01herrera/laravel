<div class="row justify-content-center my-auto">
    <div class="col-md-8 col-lg-6 col-xl-4">
        <div class="text-center  py-5">
            <div class="mb-4 mb-md-5">
                <img src="assets/images/logo/logoWhite.png" alt="logo">
            </div>
            <div class="mb-4">
                <h5>Welcome Back !</h5>
                <p>Sign in to continue</p>
            </div>
            <div>
                <div class="form-floating form-floating-custom mb-3">
                    <input type="text" class="form-control required" id="login-txt-user" autocomplete="off" placeholder="Enter User" />
                    <label for="login-txt-user">User</label>
                    <div class="form-floating-icon"><i class="uil uil-users-alt"></i></div>
                </div>

                <div class="form-floating form-floating-custom mb-3">
                    <input type="password" class="form-control required" id="login-txt-password" autocomplete="off" placeholder="Enter Password">
                    <label for="login-txt-password">Password</label>
                    <div class="form-floating-icon"><i class="uil uil-padlock"></i></div>
                </div>

                <div class="mt-3">
                    <button type="button" id="btn-login" class="btn btn-info w-100">
                        <span id="spinner-btn-login" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
                        Log In
                    </button>
                </div>

                <div class="mt-4 text-center">
                    <a id="btn-forgotPassword" href="#" class="text-dark">Forgot your password?</a>
                </div>

            </div>
        </div>
    </div>
</div>
@include('authentication.login.js.loginJS')
