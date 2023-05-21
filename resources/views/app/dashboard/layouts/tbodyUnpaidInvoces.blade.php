@for ($i = 0; $i < $countUnpaidInvoices; $i++)
    <tr>
        <td><a href="#" class="invoice" data-recordid="{{ $unpaidInvoices[$i]['recordID'] }}" >{{ $unpaidInvoices[$i]['number'] }}</a></td>
        <td>{{ $unpaidInvoices[$i]['invoiceDate'] }}</td>
        <td>{{ $unpaidInvoices[$i]['dueDate'] }}</td>
        <td class="text-end">$ {{ $unpaidInvoices[$i]['totalAmount'] }}</td>
    </tr>
@endfor
<script>
    $(document).ready(function () {

        let unpaidInvoicesDT = $('#dataTable-unpaidInvoices').DataTable({

            "searching": false,
            "ordering": false,
        });

        unpaidInvoicesDT.on('click', '.invoice', function(event) { // LINK DETAIL INVOICE

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

        unpaidInvoicesDT.on('error', function () {

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
