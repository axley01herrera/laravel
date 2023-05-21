<!-- PAGE HEADER -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h3>Contracts List</h3>
        </div>
    </div>
</div>
<!-- PAGE CONTENT -->
<div class="row">
    <div class="col-12">
        <!-- SECTION KEYS -->
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive mt-3" style="width: 100%;">
                            <!-- DATA TABLE -->
                            <table id="dataTable-contracts" class="table" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Contract #</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th class="text-center">PDF</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

        let contractsDT = $('#dataTable-contracts').DataTable({ // SERVER SIDE DATA TABLE
            destroy: true,
            processing: true,
            serverSide: true,
            responsive: true,
            bAutoWidth: true,
            pageLength: 10,
            lengthMenu: [[5, 10, 20, 25, 50, 100], [5, 10, 20, 25, 50, 100]],

            ajax : {
                url: "{{ route('contractsDataTable') }}",
                type: "POST"
            },

            "order": [
                [1, 'desc']
            ],

            columns: [
                {
                    data: 'number',
                },
                {
                    data: 'dateStart',
                },
                {
                    data: 'dateExpire',
                },
                {
                    data: 'file',
                    class: 'text-center',
                    orderable: false
                }
            ],
        });

        contractsDT.on('click', '.contract', function(event) { // GO TO DETAIL

            event.preventDefault();

            let target = document.getElementById('spinner');
			let spinner = new Spinner(opts).spin(target);

            let post = {
                contractRecordID: $(this).attr('data-recordid')
            }

            $.ajax({

                type: "post",
                url: "{{ route('contractDetail') }}",
                data: {post},
                dataType: "html",

            }).done(function(htmlResponse) {

                spinner.stop();
                $('#main-container').html(htmlResponse);

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

        contractsDT.on('error', function () { // DT ON ERROR

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
