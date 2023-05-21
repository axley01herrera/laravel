@for ($i = 0; $i < $countNewTickets; $i++)
    <tr>
        <td><a href="#" class="ticket" data-recordid="{{ $newTickets[$i]['recordID'] }}" >{{ $newTickets[$i]['number'] }}</a></td>
        <td>{{ $newTickets[$i]['subject'] }}</td>
        <td>{{ $newTickets[$i]['createdDate'] }}</td>
        <td>{{ $newTickets[$i]['severiry'] }}</td>
        <td>{{ $newTickets[$i]['type'] }}</td>
    </tr>
@endfor
<script>
    $(document).ready(function () {

        let newTicketDT = $('#dataTable-newTicket').DataTable({

            "searching": false,
            "ordering": false,
        });

        newTicketDT.on('click', '.ticket', function(event) { // LINK TICKET DETAIL

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

        newTicketDT.on('error', function () {

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
