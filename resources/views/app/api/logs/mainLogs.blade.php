<!-- PAGE HEADER -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h3>Logs</h3>
        </div>
    </div>
</div>
<!-- PAGE CONTENT -->
<div class="row">
    <div class=" col-12">
        <div class="card">
            <div class="card-body">
                <!-- DATA TABLE -->
                <div class="table-responsive mt-3" style="width: 100%;">
                    <table id="dataTable-logs" class="table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-start">Creation Date</th>
                                <th class="text-start">Description</th>
                                <th class="text-start">Table</th>
                                <th class="text-start">Modified RecordID</th>
                                <th class="text-center">Sql Command</th>
                                <th class="text-end"></th>
                                <th hidden>Request</th>
                                <th hidden>Respond </th>
                                <th hidden>Old data</th>
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

        let logsDT = $('#dataTable-logs').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            responsive: true,
            bAutoWidth: true,
            pageLength: 10,
            lengthMenu: [[5, 10, 20, 25, 50, 100], [5, 10, 20, 25, 50, 100]],

            ajax : {
                url: "{{ route('logsDataTable') }}",
                type: "POST"
            },

            "order": [
                [0, 'desc']
            ],

            columns: [
                {
                    data: 'createdDate',
                },
                {
                    data: 'description',
                },
                {
                    data: 'table',
                },
                {
                    data: 'modifiedRecordID',
                },
                {
                    data: 'sqlCommand',
                    class: 'text-center'
                },
                {
                    data: 'btnDetail',
                    class: 'text-center',
                    orderable: false
                },
                {
                    data: 'request',
                    visible: false
                },
                {
                    data: 'response',
                    visible: false
                },
                {
                    data: 'jsonOldData',
                    visible: false
                }
            ],

        });

        logsDT.on('error', function () {

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

        logsDT.on('click', '.log', function() {

            let target = document.getElementById('spinner');
			let spinner = new Spinner(opts).spin(target);

            let post = { logRecordID: $(this).attr('data-recordid')}

            $.ajax({

                type: "post",
                url: "{{ route('logDetail') }}",
                data: {post},
                dataType: "html",

            }).done(function(htmlResponse) {

                $('#main-container').html(htmlResponse);
				spinner.stop();

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

    });
</script>
