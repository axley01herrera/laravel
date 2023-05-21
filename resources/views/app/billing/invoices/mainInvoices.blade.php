<!-- PAGE HEADER -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h3>Invoices List</h3>
        </div>
    </div>
</div>
<!-- PAGE CONTENT -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive mt-3" style="width: 100%;">
                            <!-- DATA TABLE -->
                            <table id="dataTable-invoices" class="table" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Invoice #</th>
                                        <th>Invoice Date</th>
                                        <th>Due Date</th>
                                        <th class="text-center">Status</th>
                                        <th style="width: 120px" class="text-end">Amount</th>
                                        <th style="width: 120px" class="text-end">Balance</th>
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

        let invoicesDT = $('#dataTable-invoices').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            responsive: true,
            bAutoWidth: true,
            pageLength: 10,
            lengthMenu: [[5, 10, 20, 25, 50, 100], [5, 10, 20, 25, 50, 100]],

            ajax : {
                url: "{{ route('invoicesDataTable') }}",
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
                    data: 'invoiceDate',
                },
                {
                    data: 'dueDate',
                },
                {
                    data: 'status',
                    class: 'text-center',
                },
                {
                    data: 'amount',
                    class: 'text-end',
                },
                {
                    data: 'balance',
                    class: 'text-end',
                },
                {
                    data: 'file',
                    class: 'text-center',
                    orderable: false
                }
            ],
        });

        invoicesDT.on('click', '.invoice', function(event) { // LINK DETAIL INVOICE

            event.preventDefault();

            let target = document.getElementById('spinner');
			let spinner = new Spinner(opts).spin(target);

            let post = { invoiceRecordID: $(this).attr('data-recordid') }

            $.ajax({

                type: "post",
                url: "{{ route('invoiceDetail') }}",
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

        invoicesDT.on('error', function () {

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
