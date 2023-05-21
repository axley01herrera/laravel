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
        <link href="assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link href="assets/css/bootstrap.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <link href="assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="assets/libs/flatpickr/flatpickr.min.css">
        <link href="assets/css/custom.css" rel="stylesheet" type="text/css" />
        <link href="assets/libs/alertifyjs/build/css/alertify.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/libs/alertifyjs/build/css/themes/default.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/spinner/animate.css" rel="stylesheet" type="text/css" />
        <link href="assets/newplugins/datatable/datatables.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/switchery.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/newplugins/animate/animate.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <link href="assets/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="assets/libs/glightbox/css/glightbox.min.css">

        <style>
            label {
                font-weight: 500;
                margin-top: 0.5rem;
                margin-bottom: 0px;
            }

            .drop_container_scroll {
                max-height: 300px;
                height: auto;
                overflow-y: scroll;
                width: 100%;
            }
        </style>

        <!-- JAVASCRIPT -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenujs/metismenujs.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/feather-icons/feather.min.js"></script>
        <script src="assets/libs/alertifyjs/build/alertify.min.js"></script>
        <script src="assets/spinner/spin.min.js"></script>
        <script src="assets/spinner/option.js"></script>
        <script src="assets/newplugins/datatable/datatables.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/bootstrap-datepicker.min.js"></script>
        <script src="assets/js/jquery-asColorPicker.min.js"></script>
        <script src="assets/js/jquery-clockpicker.min.js"></script>
        <script src="assets/js/switchery.min.js"></script>
        <script src="assets/js/jquery.inputmask.bundle.min.js"></script>
        <script src="assets/plugins/sweetalert/sweetalert2.js"></script>
        <script src="assets/plugins/select2/js/select2.min.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/libs/dropzone/min/dropzone.min.js"></script>
        <script src="assets/customFunction/requiredValues.js"></script>
        <script src="assets/libs/glightbox/js/glightbox.min.js"></script>
        <script src="assets/libs/isotope-layout/isotope.pkgd.min.js"></script>
        <script src="assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
        <script src="assets/libs/flatpickr/flatpickr.min.js"></script>
        <script src="assets/newplugins/clipboard/dist/clipboard.min.js"></script>
        <script>$.fn.dataTable.ext.errMode = 'none'; // DISABLED DT ERRORS</script>
        <script src="assets/libs/apexcharts/apexcharts.min.js"></script>

        <!-- CSRF-TOKEN -->
        <script>$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});</script>

    </head>
    <body id="app-body">
        <!--SPINNER-->
        <div id="spinner" style="position: absolute; top:50%; left:50%; z-index: 100"></div>
        <div id="layout-wrapper">
            @include('app.menu.topBar')
            @include('app.menu.leftSideBar')
            <!--MAIN MODAL-->
            <div id="main-modal"></div>
            <div class="main-content">
                <div class="page-content">
                    <!--MAIN CONTAINER-->
                    <div id="main-container" class="container-fluid"></div>
                </div>
            </div>
        </div>
    </body>
</html>
<script src="assets/js/app.js"></script>
<script>
    $(document).ready(function () {

        loadNotifications();
        loadDashboard();

        function loadDashboard() {

            let target = document.getElementById('spinner');
            let spinner = new Spinner(opts).spin(target);

            $.ajax({

                type: "post",
                url: "{{ route('dashboard') }}",
                dataType: "html",

            }).done(function(htmlResponse) {

                spinner.stop();
                $('#main-container').html(htmlResponse);

            }).fail(function(error) {

                Swal.fire({
                    title: 'An error has ocurred',
                    showClass: {popup: 'animate__animated animate__fadeInDown'},
                    hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                    position: 'top-end',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1500
                });

                spinner.stop();

            });
        }

        function loadNotifications() {

            $.ajax({

                type: "post",
                url: "{{ route('getNotifications') }}",
                dataType: "html",

            }).done(function(htmlResponse) {

                $('#main-notification').html(htmlResponse);

            }).fail(function(error) {
                Swal.fire({
                    title: 'An error has ocurred',
                    showClass: {popup: 'animate__animated animate__fadeInDown'},
                    hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                    position: 'top-end',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        }
    });
</script>
