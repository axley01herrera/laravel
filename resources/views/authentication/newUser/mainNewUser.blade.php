<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Si Client - New User</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="SI Client" name="Isak Computing, LLC" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

	    <link rel="shortcut icon" href="assets/images/favicon.ico">

        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link href="assets/css/bootstrap.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <link href="assets/newplugins/animate/animate.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css" />

        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/customFunction/requiredValues.js"></script>
        <script src="assets/plugins/sweetalert/sweetalert2.js"></script>

        <script>$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});</script>
    </head>
    <body>
        <div class="authentication-bg min-vh-100">
            <div class="bg-overlay bg-white"></div>
            <div class="container">
                <div id="content" class="d-flex flex-column min-vh-100 px-3 pt-4">
                    <div class="row justify-content-center my-auto">
                        <div class="col-md-8 col-lg-6 col-xl-4">
                            <div class="text-center  py-5">
                                <div class="mb-4 mb-md-5">
                                    <img src="assets/images/logo/logoWhite.png" alt="logo">
                                </div>
                                <div class="text-white-50 mb-4">
                                    <h5 class="text-dark">{{ $people }}</h5>
                                    <p>Create your credentials</p>
                                </div>
                                <div>
                                    <div class="form-floating form-floating-custom mb-3">
                                        <input type="text" class="form-control required" id="newUser-input-user" placeholder="User" />
                                        <label for="newUser-input-user">
                                            User
                                        </label>
                                        <div class="form-floating-icon">
                                            <i class="uil uil-users-alt"></i>
                                        </div>
                                    </div>
                                    <div class="form-floating form-floating-custom mb-3">
                                        <input type="password" class="form-control required" id="newUser-input-password" placeholder="Password" />
                                        <label for="newUser-input-password">
                                            Password
                                        </label>
                                        <div class="form-floating-icon">
                                            <i class="uil uil-padlock"></i>
                                        </div>
                                    </div>
                                    <div class="form-floating form-floating-custom mb-3">
                                        <input type="password" class="form-control required" id="newUser-input-passwordC" placeholder="Password Confirmation" />
                                        <label for="newUser-input-passwordC">
                                            Password Confirmation
                                        </label>
                                        <div class="form-floating-icon">
                                            <i class="uil uil-padlock"></i>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button type="button" id="newUser-btn-save" class="btn btn-info w-100">
                                            <span id="newUser-spinner-button-save" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center text-muted p-4">
                                <p class="mb-0">&copy; <script>document.write(new Date().getFullYear())</script> Powered by Isak Computing, LLC</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
@include('authentication.newUser.js.mainNewUserjs')