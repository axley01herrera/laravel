<!-- UNPAID INVOICES-->
@if ($countUnpaidInvoices > 0)

    <h6 class="dropdown-header bg-light">Invoices</h6>

    @for ($i = 0; $i < $countUnpaidInvoices; $i++)

        <a href="#" class="text-reset notification-item invoiceNot" data-recordid="{{ $unpaidInvoices[$i]['recordID'] }}">
            <div class="d-flex border-bottom align-items-start">
                <div class="flex-shrink-0">
                    <img src="assets/images/logo/logoInvoice.png" class="me-3 rounded-circle avatar-sm" alt="user-pic">
                </div>
                <div class="flex-grow-1">
                    <h6 class="mb-1">Invoice # {{ $unpaidInvoices[$i]['number'] }}</h6>
                    <div class="text-muted">
                        <p class="mb-1 font-size-13">{{ $unpaidInvoices[$i]['terms']}}
                            <span class="badge badge-soft-danger">{{ $unpaidInvoices[$i]['labelStatus'] }}</span>
                        </p>
                        <p class="mb-0 font-size-10 text-uppercase fw-bold">
                            <i class="mdi mdi-calendar-clock"></i> {{ $unpaidInvoices[$i]['dueDate'] }}
                        </p>
                    </div>
                </div>
            </div>
        </a>

    @endfor

@endif

@if ($flag == 0)

    <div class="text-center">
        There are no notifications to show
    </div>

@endif
<script>
    $(document).ready(function () {

        let flag = "{{ $flag }}";

        if(flag == 1)
            $('#flag-not').removeAttr('hidden');
        else
            $('#flag-not').attr('hidden', true);


        $('.invoiceNot').on('click', function (event) {

            event.preventDefault();

            let accessAPI = '<?php echo session('accessAPI')?>';
            if (accessAPI === '1'){
                globalThis.chartOrder.destroy();
            }

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
    });
</script>
