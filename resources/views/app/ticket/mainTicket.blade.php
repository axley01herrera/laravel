<!-- PAGE HEADER -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h3>Ticket List</h3>
        </div>
    </div>
</div>
<!-- PAGE CONTENT -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#open" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">Open</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#history" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">History</span>
                        </a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content p-3 text-muted">
                    <div class="tab-pane active" id="open" role="tabpanel">
                        @include('app.ticket.tabs.open')
                    </div>
                    <div class="tab-pane" id="history" role="tabpanel">
                        @include('app.ticket.tabs.history')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

        $('.createTicket').on('click', function () { // GO TO CRATE TICKET

            $('.createTicket').attr('disabled', true);
            $('.spinner-btn-createTicket').removeAttr('hidden');

            let post = {action: 'add'}

            $.ajax({

                type: "post",
                url: "{{ route('ticketCreate') }}",
                data: {post},
                dataType: "html",

            }).done(function(htmlResponse) {

                $('#main-modal').html(htmlResponse);
                $('.createTicket').removeAttr('disabled');
                $('.spinner-btn-createTicket').attr('hidden', true);

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

        let ticketsOpenDT = $('#dataTable-open').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            responsive: true,
            bAutoWidth: true,
            pageLength: 10,
            lengthMenu: [[5, 10, 20, 25, 50, 100], [5, 10, 20, 25, 50, 100]],

            ajax : {
                url: "{{ route('ticketDataTableOpen') }}",
                type: "POST"
            },

            "order": [
                [2, 'desc']
            ],

            columns: [
                {
                    data: 'number',
                },
                {
                    data: 'title',
                },
                {
                    data: 'createdDate',
                },
                {
                    data: 'severity',
                },
                {
                    data: 'priority',
                },
                {
                    data: 'type',
                },
                {
                    data: 'status',
                    class: 'text-center'
                }
            ],
        });

        ticketsOpenDT.on('click', '.ticket', function(event) { // LINK TICKET DETAIL

            event.preventDefault();

            let target = document.getElementById('spinner');
			let spinner = new Spinner(opts).spin(target);

            let post = { ticketRecordID: $(this).attr('data-recordid') }

            $.ajax({

                type: "post",
                url: "{{ route('ticketDetail') }}",
                data: {post},
                dataType: "html",

            }).done(function(htmlResponse) {

                spinner.stop();
                $('#main-container').html(htmlResponse);


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

        ticketsOpenDT.on('error', function () {
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
            }, "2000")
        });

        let ticketsHistoryDT = $('#dataTable-history').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            responsive: true,
            bAutoWidth: true,
            pageLength: 10,
            lengthMenu: [[5, 10, 20, 25, 50, 100], [5, 10, 20, 25, 50, 100]],

            ajax : {
                url: "{{ route('ticketDataTableHistory') }}",
                type: "POST"
            },

            "order": [
                [2, 'desc']
            ],

            columns: [
                {
                    data: 'number',
                },
                {
                    data: 'title',
                },
                {
                    data: 'createdDate',
                },
                {
                    data: 'severity',
                },
                {
                    data: 'priority',
                },
                {
                    data: 'type',
                },
                {
                    data: 'status',
                    class: 'text-center'
                }
            ],
        });

        ticketsHistoryDT.on('click', '.ticket', function(event) { // LINK TICKET DETAIL

            event.preventDefault();

            let target = document.getElementById('spinner');
            let spinner = new Spinner(opts).spin(target);

            let post = { ticketRecordID: $(this).attr('data-recordid') }

            $.ajax({

                type: "post",
                url: "{{ route('ticketDetail') }}",
                data: {post},
                dataType: "html",

            }).done(function(htmlResponse) {

                spinner.stop();
                $('#main-container').html(htmlResponse);


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

        ticketsHistoryDT.on('error', function () {
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
            }, "2000")
        });

    });
</script>
