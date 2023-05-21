<!-- PAGE HEADER -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h3>API Configuration</h3>
        </div>
    </div>
</div>
@if (session('accessAPI') != 1)

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <h5>To request access to the API click on the button.</h5>
                        <div class="col-12">
                            <!-- BTN REQUEST API ACCESS -->
                            <button type="button" id="btn-requestApiAccess" class="btn btn-primary">
                                <span id="spinner-btn-requestApiAccess" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
                                Request
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {

            $('#btn-requestApiAccess').on('click', function () { // REQUEST ACCESS API

                $('#btn-requestApiAccess').attr('disabled', true);
                $('#spinner-btn-requestApiAccess').removeAttr('hidden');

                $.ajax({

                    type: "post",
                    url: "{{ route('requestApiAccess') }}",
                    dataType: "json",

                }).done(function(jsonResponse) {

                    switch(jsonResponse.error) {

                        case 0:
                            Swal.fire({
                                title: jsonResponse.userMsg,
                                showClass: {popup: 'animate__animated animate__fadeInDown'},
                                hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                                position: 'top-end',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        break

                        case 1:
                            Swal.fire({
                                title: jsonResponse.userMsg,
                                showClass: {popup: 'animate__animated animate__fadeInDown'},
                                hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                                position: 'top-end',
                                icon: 'error',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            if(jsonResponse.userMsg == 'Session Expired')
                                window.location.reload();
                        break
                    }

                    $('#btn-requestApiAccess').removeAttr('disabled');
                    $('#spinner-btn-requestApiAccess').attr('hidden', true);

                }).fail(function(error) {

                    Swal.fire({
                        title: 'Session Expired',
                        showClass: {popup: 'animate__animated animate__fadeInDown'},
                        hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                        position: 'top-end',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    $('#btn-requestApiAccess').removeAttr('disabled');
                    $('#spinner-btn-requestApiAccess').attr('hidden', true);

                    window.location.reload();

                });
            });
        });
    </script>

@else

    <div id="main-configAPI"></div>

    <script>
        $(document).ready(function () { // GET CONTENT COFIG API

            getContentConfigApi();

            function getContentConfigApi() {

                $.ajax({

                    type: "post",
                    url: "{{route('getContentConfigApi')}}",
                    dataType: "html",

                }).done(function(htmlResponse) {

                    $('#main-configAPI').html(htmlResponse);

                }).fail(function(error) {

                    Swal.fire({
                        title: 'Session Expired',
                        showClass: {popup: 'animate__animated animate__fadeInDown'},
                        hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                        position: 'top-end',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    window.location.reload();

                });
            }
        });
    </script>

@endif
