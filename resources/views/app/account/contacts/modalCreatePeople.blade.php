<!--MODAL FADE-->
<div class="modal fade" id="modal-contact" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- MODAL HEADER -->
            <div class="modal-header">
                <!--MODAL TITLE-->
                <h5 class="modal-title" id="staticBackdropLabel">{{ $modalTitle }}</h5>
                <button type="button" class="btn-close closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- MODAL BODY -->
            <div class="modal-body">
                <div class="row">
                    <!-- TXT NAME -->
                    <div class="col-12 col-md-6 col-lg-6">
                        <label for="txt-name"><strong>Name</strong></label>
                        <input id="txt-name" type="text" class="form-control required focus" value="{{@$people['name']}}" msg="inputName" />
                        <p id="inputName" class="text-end text-danger"></p>
                    </div>
                    <!-- TXT LAST NAME -->
                    <div class="col-12 col-md-6 col-lg-6">
                        <label for="txt-lastName"><strong>Last Name</strong></label>
                        <input id="txt-lastName" type="text" class="form-control required focus" value="{{@$people['lastName']}}" msg="inputLastName" />
                        <p id="inputLastName" class="text-end text-danger"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <!-- TXT EMAIL -->
                        <label for="txt-email"><strong>Email</strong></label>
                        <input id="txt-email" type="text" class="form-control required focus email" value="{{@$people['email']}}" msg="inputEmail" />
                        <p id="inputEmail" class="text-end text-danger"></p>
                    </div>

                    @if ($action == 'add')

                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="switch-admin"><strong>Admin</strong></label>
                        <div class="form-check form-switch mb-2" dir="ltr">
                            <!-- CBX ADMIN -->
                            <input id="switch-admin" type="checkbox" class="form-check-input switch" data-value="0">
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="txt-email"><strong>Send Invitation</strong></label>
                        <div class="form-check form-switch mb-2" dir="ltr">
                            <!-- CBX INVITATION -->
                            <input id="switch-invitation" type="checkbox" class="form-check-input switch" checked data-value="1">
                        </div>
                    </div>

                    @endif
                </div>
                <div class="row">
                    <!-- TXT PHONE MOBILE -->
                    <div class="col-12 col-md-6 col-lg-6">
                        <label for="txt-phoneMobile"><strong>Phone Mobile</strong></label>
                        <input id="txt-phoneMobile" type="text" class="form-control phone focus" value="{{@$people['phoneM']}}" msg="inputPhoneMobile" />
                        <p id="inputPhoneMobile" class="text-end text-danger"></p>
                    </div>
                    <!-- TXT PHONE WORK -->
                    <div class="col-12 col-md-6 col-lg-6">
                        <label for="txt-phoneWork"><strong>Phone Work</strong></label>
                        <input id="txt-phoneWork" type="text" class="form-control phone focus" value="{{@$people['phoneW']}}" msg="inputPhoneWork" />
                        <p id="inputPhoneWork" class="text-end text-danger"></p>
                    </div>
                </div>
            </div>
            <!-- MODAL FOOTER -->
            <div class="modal-footer mt-10">
                <button id="btn-modalClose" type="button" class="btn btn-secondary closeModal" data-bs-dismiss="modal">Close</button>
                <button id="btn-modalSubmit" type="button" class="btn btn-primary">
                    <span id="spinner-btn-modalSubmit" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
                    Submit
                </button>
            </div>
        </div>
    </div>
</div>
<script src="assets/customFunction/mask.js"></script>
<script src="assets/customFunction/setCityAndState.js"></script>
<script>
    $(document).ready(function () {

        $('#modal-contact').modal('show');

        $('#btn-modalSubmit').on('click', function () { // SUBMIT

            let formRequiredValues = requiredValues();
            let formPhoneValidation = phoneFormatValidation();
            let formEmailValidation = emailFormatValidation();

            if(formRequiredValues == 0 && formPhoneValidation == 0 && formEmailValidation == 0) {

                $('#btn-modalSubmit').attr('disabled', true);
                $('#spinner-btn-modalSubmit').removeAttr('hidden');

                let post = {
                    name: $('#txt-name').val(),
                    lastName: $('#txt-lastName').val(),
                    email: $('#txt-email').val(),
                    phoneM: $('#txt-phoneMobile').val(),
                    phoneW: $('#txt-phoneWork').val(),
                    admin: $('#switch-admin').attr('data-value'),
                    invitation: $('#switch-invitation').attr('data-value'),
                    peopleRecordID: "{{ @$people['recordID'] }}"
                }

                let action = "{{ $action }}";
                let url = '';

                if(action == 'add')
                    url = "{{ route('createPeople') }}";
                else
                    url = "{{ route('updatePeople') }}";

                $.ajax({

                    type: "post",
                    url: url,
                    data: {post},
                    dataType: "json",

                }).done(function(jsonResponse) {

                    switch(jsonResponse.error) {

                        case 0:
                            Swal.fire({
                                title: jsonResponse.userMsg,
                                showClass: {popup: 'animate__animated animate__fadeInDown'},
                                hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                                icon: 'success',
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            reloadMainContact();

                            $('#modal-contact').modal('hide');
                            $('#main-modal').html('');
                        break

                        case 1:
                            Swal.fire({
                                title: jsonResponse.userMsg,
                                showClass: {popup: 'animate__animated animate__fadeInDown'},
                                hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                                icon: 'error',
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            if(jsonResponse.userMsg == 'Session Expired') { // IF SESSION IS EXPIRED REDIRECT TO LOGIN

                                setTimeout(() => {
                                    window.location.href="{{ route('login') }}";
                                }, "2000");
                            }
                        break

                        $('#spinner-btn-modalSubmit').attr('hidden', true);
                        $('#btn-modalSubmit').removeAttr('disabled');
                    }

                }).fail(function(error) {

                    Swal.fire({
                        title: 'Session Expired',
                        showClass: {popup: 'animate__animated animate__fadeInDown'},
                        hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                        icon: 'error',
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    $('#spinner-btn-modalSubmit').attr('hidden', true);
                    $('#spinner-btn-modalSubmit').removeAttr('disabled');

                    //window.location.reload();

                });

            } else {

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

        $('.switch').on('click', function () {
            let value = $(this).attr('data-value');
            if(value == 1)
                $(this).attr('data-value', '0');
            else
                $(this).attr('data-value', '1');
        });

        $('.focus').on('focus', function () {
            $(this).removeClass('is-invalid');
            let msg = $(this).attr('msg');
            $('#' + msg).html('');
        }).on('change', function () {
            $(this).removeClass('is-invalid');
            let msg = $(this).attr('msg');
            $('#' + msg).html('');
        });

        $('.required').keyup(function (e) {
            let inputID = $(this).attr('id');
            requiredValuesOnKeyUP(inputID);
        });

        $('.closeModal').on('click', function () {
            $('#modal-editPersonalInfo').modal('hide');
            $('#main-modal').html('');
        });

        $('.phone').on('input', function () {
            jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
        });

        function reloadMainContact() {

            var target = document.getElementById('spinner');
			var spinner = new Spinner(opts).spin(target);

            $.ajax({

                type: "post",
                url: "{{ route('contacts') }}",
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

				spinner.stop();

				window.location.reload();

			});
        }
    });
</script>
