<!-- BTN CREATE TICKET -->
@if (empty($defaultPayment))

    <div class="row">
        <div class="col-12 text-center">
            <p class="font-size-18">You don't have any default payment method</p>
        </div>
        <div class="col-12 mt-2 text-end">
            <button type="button" id="btn-create" class="btn btn-primary">
                <span id="spinner-btn-create" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
                Create
            </button>
        </div>
    </div>

@else

    <div class="row">
        <div class="col-12">
            @switch($defaultPayment[0]['cardType'])

                @case('American Express')
                    <h4 class="mt-4 font-weight-bold mb-2 d-flex align-items-center">
                        <span><img width="50px" src="assets/images/creditcard/1.png" alt="American Express"> **** **** {{ $defaultPayment[0]['lastFour'] }}</span>
                    </h4>

                @break

                @case('Discovery Card')
                    <h4 class="mt-4 font-weight-bold mb-2 d-flex align-items-center">
                        <span><img width="50px" src="assets/images/creditcard/2.png" alt="Discovery Card"> **** **** {{ $defaultPayment[0]['lastFour'] }}</span>
                    </h4>
                @break

                @case('Diners')
                    <h4 class="mt-4 font-weight-bold mb-2 d-flex align-items-center">
                        <span><img width="50px" src="assets/images/creditcard/3.png" alt="Diners"> **** **** {{ $defaultPayment[0]['lastFour'] }}</span>
                    </h4>
                @break

                @case('Master Card')
                    <h4 class="mt-4 font-weight-bold mb-2 d-flex align-items-center">
                        <span><img width="50px" src="assets/images/creditcard/4.png" alt="Master Card"> **** **** {{ $defaultPayment[0]['lastFour'] }}</span>
                    </h4>
                @break

                @case('Visa')
                    <h4 class="mt-4 font-weight-bold mb-2 d-flex align-items-center">
                        <span><img width="50px" src="assets/images/creditcard/5.png" alt="Visa"> **** **** {{ $defaultPayment[0]['lastFour'] }}</span>
                    </h4>
                @break

            @endswitch
        </div>
    </div>

@endif
<script>
    $(document).ready(function () {

        $('#btn-create').on('click', function () { // GO TO CREATE PAYMENT

            $('#btn-create').attr('disabled', true);
            $('#spinner-btn-create').removeAttr('hidden');

            let post = {
                callFrom: 'dashboard'
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

    });
</script>


