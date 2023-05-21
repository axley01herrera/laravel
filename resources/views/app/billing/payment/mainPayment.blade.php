<!-- PAGE HEADER -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h3>Payments Methods</h3>
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
                        <!-- BTN CREATE TICKET -->
                        <button type="button" id="btn-create" class="btn btn-primary">
                            <span id="spinner-btn-create" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
                            Create
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive mt-3" style="width: 100%;">
                            <!-- DATA TABLE -->
                            <table id="dataTable-payments" class="table" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Last Four</th>
                                        <th>Expiration Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @for ($i = 0; $i < $countPayments; $i++)

                                    <tr>
                                        <td>
                                            @switch($payments[$i]['cardType'])

                                                @case('American Express')
                                                    <span><img width="25px" src="assets/images/creditcard/1.png" alt="American Express"></span>
                                                @break

                                                @case('Discovery Card')
                                                    <span><img width="25px" src="assets/images/creditcard/2.png" alt="Discovery Card"></span>
                                                @break

                                                @case('Diners')
                                                    <span><img width="25px" src="assets/images/creditcard/3.png" alt="Diners"></span>
                                                @break

                                                @case('Master Card')
                                                    <span><img width="25px" src="assets/images/creditcard/4.png" alt="Master Card"></span>
                                                @break

                                                @case('Visa')
                                                    <span><img width="25px" src="assets/images/creditcard/5.png" alt="Visa"></span>
                                                @break


                                            @endswitch

                                            {{ $payments[$i]['lastFour'] }}
                                        </td>
                                        <td>{{ $payments[$i]['cardExpirationM'] }}/{{ $payments[$i]['cardExpirationY'] }}</td>
                                        <td>
                                            @if ($payments[$i]['isExpired'] <> 1)


                                                @if ($payments[$i]['default'] == 1)
                                                    <div class="form-check form-switch mb-2" dir="ltr">
                                                        <input
                                                            id="switch{{ $i }}"
                                                            type="checkbox"
                                                            class="form-check-input switch"
                                                            data-recordid="{{ $payments[$i]['recordID'] }}"
                                                            data-value="{{ $payments[$i]['default'] }}"
                                                            checked
                                                        >
                                                    </div>
                                                @endif
                                                @if ($payments[$i]['default'] == 0)
                                                    <div class="form-check form-switch mb-2" dir="ltr">
                                                        <input
                                                            id="switch{{ $i }}"
                                                            type="checkbox"
                                                            class="form-check-input switch"
                                                            data-recordid="{{ $payments[$i]['recordID'] }}"
                                                            data-value="{{ $payments[$i]['default'] }}">
                                                        </div>
                                                @endif
                                            @endif
                                            @if ($payments[$i]['isExpired'] == 1)
                                                <span class="badge badge-soft-danger">expired</span>
                                            @endif
                                        </td>
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
</div>
<script>
    $(document).ready(function () {

        $('#btn-create').on('click', function () { // GO TO CREATE PAYMENT

            $('#btn-create').attr('disabled', true);
            $('#spinner-btn-create').removeAttr('hidden');

            let post = {
                callFrom: 'mainPayment'
            }

            $.ajax({

                type: "post",
                url: "{{ route('modalCreatePayment') }}",
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

                $('#btn-create').removeAttr('disabled');
                $('#spinner-btn-create').attr('hidden', true);

                window.location.reload();

            });
        });

        let paymentsDT = $('#dataTable-payments').DataTable({

            "searching": false,
            "ordering": false,

        });

        paymentsDT.on('error', function () {

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

        paymentsDT.on('click', '.switch', function(event) { // ACTIVE OR DESACTIVE WEB PORTAL

            let currentValue = $(this).attr('data-value');
            if(currentValue == 1)
                event.preventDefault()
            else {
                let elementID = $(this).attr('id');
                let newValue = '';

                if(currentValue == 0)
                    newValue = 1;
                else if(currentValue == 1)
                    newValue = 0;

                let target = document.getElementById('spinner');
                let spinner = new Spinner(opts).spin(target);

                let post = {paymentRecordID: $(this).attr('data-recordid'),}

                $.ajax({

                    type: "post",
                    url: "{{ route('setDefaultPayment') }}",
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

                            $('#link-payments').trigger('click');
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
            }
        });

    });
</script>
