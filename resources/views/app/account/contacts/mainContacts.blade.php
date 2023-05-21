<!-- PAGE HEADER -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h3>Contacts List</h3>
        </div>
    </div>
</div>
<!-- PAGE CONTENT -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if (session('role') == 'admin')

                <div class="row">
                    <div class="col-12">
                        <!-- BTN CREATE -->
                        <button type="button" id="btn-create" class="btn btn-primary">
                            <span id="spinner-btn-create" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
                            Create
                        </button>
                    </div>
                </div>

                @endif
                <div class="table-responsive mt-3" style="width: 100%;">
                     <!-- DATA TABLE -->
                    <table id="dataTable-contacts" class="table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Admin</th>
                                <th>Access</th>
                                <th class="text-end"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

        let session = "{{ session('role') }}";

        $('#btn-create').on('click', function () { // CRATE CONTACT

            $('#btn-create').attr('disabled', true);
            $('#spinner-btn-create').removeAttr('hidden');

            let post = {
                action: 'add'
            }

            $.ajax({

                type: "post",
                url: "{{ route('contactCreate') }}",
                data: {post},
                dataType: "html",

            }).done(function(htmlResponse) {

                $('#main-modal').html(htmlResponse);
                $('#btn-create').removeAttr('disabled');
                $('#spinner-btn-create').attr('hidden', true);

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
        });

        let contactsDT = $('#dataTable-contacts').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            responsive: true,
            bAutoWidth: true,
            pageLength: 10,
            lengthMenu: [[5, 10, 20, 25, 50, 100], [5, 10, 20, 25, 50, 100]],

            ajax : {
                url: "{{ route('contactsDataTable') }}",
                type: "POST"
            },

            "order": [
                [0, 'desc']
            ],

            columns: [
                {
                    data: 'name',
                },
                {
                    data: 'email',
                },
                {
                    data: 'phone',
                },
                {
                    data: 'isMainContact',
                    orderable: false
                },
                {
                    data: 'switch',
                    orderable: false
                },
                {
                    data: 'buttons',
                    class: 'text-end',
                    orderable: false
                }
            ],

            initComplete: function (data) { // ADD MASK TO DT
                $(".phoneMask").inputmask("(999) 999-9999");
            }
        });

        contactsDT.on('click', '.contact', function(event) { // LINK CONTACT DETAIL

            event.preventDefault();

            let target = document.getElementById('spinner');
			let spinner = new Spinner(opts).spin(target);

            let post = { peopleID: $(this).attr('data-recordid') }

            $.ajax({

                type: "post",
                url: "{{ route('contactDetail') }}",
                data: {post},
                dataType: "html",

            }).done(function(htmlResponse) {

                $('#main-container').html(htmlResponse);
				spinner.stop();

            }).fail(function(error) {

                spinner.stop();

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

        });

        contactsDT.on('click', '.switchMain', function(event) { // ADMIN SWITCH

            if(session == 'admin')
            {
                let elementID = $(this).attr('id');
                let currentValue = $(this).attr('data-value');
                let newValue = '';

                if(currentValue == 0)
                    newValue = 1;
                else if(currentValue == 1)
                    newValue = 0;

                let target = document.getElementById('spinner');
                let spinner = new Spinner(opts).spin(target);

                let post = {
                    peopleID: $(this).attr('data-recordid'),
                    value: newValue
                }

                $.ajax({

                    type: "post",
                    url: "{{ route('actionAdminSwitch') }}",
                    data: {post},
                    dataType: "json",

                }).done(function(jsonResponse) {

				    spinner.stop();

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

                            $('#' + elementID).attr('data-value', newValue);

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

                }).fail(function(error) {

                    spinner.stop();

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
            } else {

                event.preventDefault();

                Swal.fire({
                    title: "You don't have enough privileges",
                    showClass: {popup: 'animate__animated animate__fadeInDown'},
                    hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                    position: 'top-end',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });

        contactsDT.on('click', '.switch', function(event) { // ACTIVE OR DESACTIVE WEB PORTAL

            if(session == 'admin')
            {
                let elementID = $(this).attr('id');
                let currentValue = $(this).attr('data-value');
                let newValue = '';

                if(currentValue == 0)
                    newValue = 1;
                else if(currentValue == 1)
                    newValue = 0;

                let target = document.getElementById('spinner');
                let spinner = new Spinner(opts).spin(target);

                let post = {
                    peopleID: $(this).attr('data-recordid'),
                    value: newValue
                }

                $.ajax({

                    type: "post",
                    url: "{{ route('activeInactiveUser') }}",
                    data: {post},
                    dataType: "json",

                }).done(function(jsonResponse) {

				    spinner.stop();

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

                            $('#' + elementID).attr('data-value', newValue);

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

                }).fail(function(error) {

                    spinner.stop();

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
            } else {

                event.preventDefault();

                Swal.fire({
                    title: "You don't have enough privileges",
                    showClass: {popup: 'animate__animated animate__fadeInDown'},
                    hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                    position: 'top-end',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });

        contactsDT.on('click', '.send', function(event) { // LINK SEND INVITATION

            event.preventDefault();

            if(session == 'admin')
            {
                let target = document.getElementById('spinner');
                let spinner = new Spinner(opts).spin(target);

                let post = {
                    peopleID: $(this).attr('data-recordid'),
                    email: $(this).attr('data-email')
                }

                $.ajax({

                    type: "post",
                    url: "{{ route('sendInvitation') }}",
                    data: {post},
                    dataType: "json",

                }).done(function(jsonResponse) {

				    spinner.stop();

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

                }).fail(function(error) {

                    spinner.stop();

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

            } else {

                event.preventDefault();

                Swal.fire({
                    title: "You don't have enough privileges",
                    showClass: {popup: 'animate__animated animate__fadeInDown'},
                    hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                    position: 'top-end',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });

        contactsDT.on('click', '.edit', function(event) { // EDIT CONTACT

            event.preventDefault();

            if(session == 'admin')
            {
                let target = document.getElementById('spinner');
                let spinner = new Spinner(opts).spin(target);

                let post = {
                    peopleID: $(this).attr('data-recordid'),
                    action: 'edit'
                }

                $.ajax({

                    type: "post",
                    url: "{{ route('contactCreate') }}",
                    data: {post},
                    dataType: "html",

                }).done(function(htmlResponse) {

                    spinner.stop();
                    $('#main-modal').html(htmlResponse);

                }).fail(function(error) {

                    spinner.stop();

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
            } else {

                event.preventDefault();

                Swal.fire({
                    title: "You don't have enough privileges",
                    showClass: {popup: 'animate__animated animate__fadeInDown'},
                    hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                    position: 'top-end',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });

        contactsDT.on('error', function () { // ON ERROR SESSION EXPIRED

            Swal.fire({
                showClass: {popup: 'animate__animated animate__fadeInDown'},
                hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                position: 'top-end',
                icon: 'error',
                title: 'Session Expired',
                showConfirmButton: false,
                timer: 1500
            });

            setTimeout(() => {
                window.location.href="{{ route('login') }}";
            }, "2000");

        });
    });
</script>
