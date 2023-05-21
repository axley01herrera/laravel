<!--MODAL FADE-->
<div class="modal fade" id="modal-note" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- MODAL HEADER -->
            <div class="modal-header">
                <!--MODAL TITLE-->
                <h5 class="modal-title" id="staticBackdropLabel">{{ $pageTitle }}</h5>
                <button type="button" class="btn-close closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- MODAL BODY -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <label for="txt-description"><strong>Description</strong></label>
                        <textarea id="txt-description" class="form-control required" rows="5" msg="description"></textarea>
                        <p id="description" class="text-end text-danger"></p>
                    </div>
                </div>
            </div>
            <!-- MODAL FOOTER -->
            <div class="modal-footer mt-10">
                <button id="btn-close" type="button" class="btn btn-secondary closeModal" data-bs-dismiss="modal">Close</button>
                <button id="btn-submit" type="button" class="btn btn-primary">
                    <span id="spinner-btn-submit" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
                    Submit
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

        $('#modal-note').modal('show');

        $('#btn-submit').on('click', function () {

            let formRequiredValues = requiredValues();

            if(formRequiredValues === 0) { // NOT REQUIRED VALUES

                $('#btn-submit').attr('disabled', true);
                $('#spinner-btn-submit').removeAttr('hidden');

                let post = {
                    ticketID: "{{ $ticketID }}",
                    description: $('#txt-description').val(),
                    action: "{{ $action }}"
                }

                $.ajax({

                    type: "POST",
                    url: "{{ route('saveNote') }}",
                    data: {post},
                    dataType: "json",

                }).done(function(jsonResponse) { console.log(jsonResponse);

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

                            $('#modal-note').modal('hide');
                            $('#main-modal').html('');

                            let callFrom = "{{ $callFrom }}";

                            if(callFrom == 'ticketDetail') reloadTicketDetail();

                            $('#btn-submit').removeAttr('disabled');
                            $('#spinner-btn-submit').attr('hidden', true);

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

                            $('#btn-submit').removeAttr('disabled');
                            $('#spinner-btn-submit').attr('hidden', true);

                            if(jsonResponse.userMsg == 'Session Expired') { // IF SESSION IS EXPIRED REDIRECT TO LOGIN

                                setTimeout(() => {
                                    window.location.href="{{ route('login') }}";
                                }, "2000");
                            }

                        break
                    }

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

                    $('#btn-submit').removeAttr('disabled');
                    $('#spinner-btn-submit').attr('hidden', true);

                    window.location.reload();

                });

            } else { // ERROR REQUIRED FIELDS

                Swal.fire({
                    title: 'Error required fields',
                    showClass: {popup: 'animate__animated animate__fadeInDown'},
                    hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                    icon: 'error',
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500
                });
            }

        });

        $('.required').on('focus', function () { // CLEAR CLASS IS INVALIS AND MSG LABEL VALIDATION

            $(this).removeClass('is-invalid');

            let msg = $(this).attr('msg');
            $('#' + msg).html('');

        }).on('change', function () { // CLEAR CLASS IS INVALIS AND MSG LABEL VALIDATION

            $(this).removeClass('is-invalid');

            let msg = $(this).attr('msg');
            $('#' + msg).html('');
        });

        $('.required').keyup(function (e) { // VALIDATE REQUIRED VALUES ON KEY UP

            let inputID = $(this).attr('id');
            requiredValuesOnKeyUP(inputID);
        });

        $('.closeModal').on('click', function () {

            $('#modal-note').modal('hide');
            $('#main-modal').html('');

        });

        function reloadTicketDetail() {

            let target = document.getElementById('spinner');
			let spinner = new Spinner(opts).spin(target);

            let post = {
                ticketRecordID: "{{ $ticketRecordID }}"
            }

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

                // window.location.reload();
            });
        }
    });
</script>
