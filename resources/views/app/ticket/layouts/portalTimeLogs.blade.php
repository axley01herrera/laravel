<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h5>Notes</h5>
            <div class="row">
                <div class="col-12 text-end">
                    <!-- BTN ADD NOTE -->
                    <button type="button" id="btn-addNote" class="btn btn-primary">
                        <span id="spinner-btn-addNote" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
                        Add Note
                    </button>
                </div>
                <div class="col-12">
                    <div class="table-responsive mt-3" style="width: 100%;">
                        <!-- DATA TABLE -->
                        <table id="dataTable-timeLogs" class="table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>By</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 0 ; $i < $countTimeLogs; $i++)

                                <tr>
                                    <td>{{ $portalTimeLogs[$i]['by'] }}</td>
                                    <td>{{ $portalTimeLogs[$i]['date'] }} {{ $portalTimeLogs[$i]['time'] }}</td>
                                    <td>{{ $portalTimeLogs[$i]['description'] }}</td>
                                </tr>

                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

        $('#btn-addNote').on('click', function () {

            $('#btn-addNote').attr('disabled', true);
            $('#spinner-btn-addNote').removeAttr('hidden');

            let post = {
                callFrom: 'ticketDetail',
                action: 'add',
                ticketRecordID: "{{ $ticketDetail['recordID'] }}",
                ticketID: "{{ $ticketDetail['ticketID'] }}",
            }

            $.ajax({

                type: "post",
                url: "{{ route('modalNote') }}",
                data: {post},
                dataType: "html",

            }).done(function(htmlResponse) {

                $('#btn-addNote').removeAttr('disabled');
                $('#spinner-btn-addNote').attr('hidden', true);

                $('#main-modal').html(htmlResponse);

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

                $('#btn-addNote').removeAttr('disabled');
                $('#spinner-btn-addNote').attr('hidden', true);

                window.location.reload();
            })

        });
    });
</script>
