<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Si Client</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="SI Client" name="Isak Computing, LLC" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- App favicon -->
	    <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- CSS -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link href="assets/css/bootstrap.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <link href="assets/newplugins/animate/animate.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css" />

        <!-- JAVASCRIPT -->
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
                    @include('authentication.login.mainLogin')
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
