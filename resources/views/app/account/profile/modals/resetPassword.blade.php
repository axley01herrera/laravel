<!--MODAL FADE-->
<div class="modal fade" id="modal-resetPassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <!-- MODAL HEADER -->
            <div class="modal-header">
                <!--MODAL TITLE-->
                <h5 class="modal-title" id="staticBackdropLabel">Reset Password</h5>
                <button type="button" class="btn-close closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- MODAL BODY -->
            <div class="modal-body">
                <div class="row">
                    <!-- CURRENT PASSWORS -->
                    <div class="col-12">
                        <label for="txt-resetPassword-currentPassword"><strong>Current Password</strong></label>
                        <input id="txt-resetPassword-currentPassword" type="password" class="form-control required" value="" msg="resetPasswordCurrentPassword" />
                        <p id="resetPasswordCurrentPassword" class="text-end text-danger"></p>
                    </div>
                    <!-- NEW PASSWORD -->
                    <div class="col-12">
                        <label for="txt-resetPassword-newPassword"><strong>New Password</strong></label>
                        <input id="txt-resetPassword-newPassword" type="password" class="form-control required" value="" msg="resetPasswordNewPassword" />
                        <p id="resetPasswordNewPassword" class="text-end text-danger"></p>
                    </div>
                    <!-- CONFIRMATION NEW PASSWORD -->
                    <div class="col-12">
                        <label for="txt-resetPassword-newPasswordC"><strong>New Password Confirmation</strong></label>
                        <input id="txt-resetPassword-newPasswordC" type="password" class="form-control required" value="" msg="resetPasswordNewPasswordC" />
                        <p id="resetPasswordNewPasswordC" class="text-end text-danger"></p>
                    </div>
                </div>
                
            </div>
            <!-- MODAL FOOTER -->
            <div class="modal-footer mt-10">
                <button id="btn-resetPasswordClose" type="button" class="btn btn-secondary closeModal" data-bs-dismiss="modal">Close</button>
                <button id="btn-resetPasswordSave" type="button" class="btn btn-primary">
                    <span id="spinner-btn-resetPasswordSave" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
                    Save
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

        $('#modal-resetPassword').modal('show');

        $('#btn-resetPasswordSave').on('click', function () { // BTN SAVE

            let formRequiredValues = requiredValues();

            if(formRequiredValues === 0) { // NOT REQUIRED VALUES

                let newPassword = $('#txt-resetPassword-newPassword').val();
                let newPasswordC = $('#txt-resetPassword-newPasswordC').val();

                if(newPassword == newPasswordC) {

                    $('#btn-resetPasswordSave').attr('disabled', true);
                    $('#spinner-btn-resetPasswordSave').removeAttr('hidden');

                    let post = {
                        contactRecordID: '{{$contact['recordID']}}',
                        currentPassword: $('#txt-resetPassword-currentPassword').val(),
                        newPassword: newPassword
                    }

                    $.ajax({

                        type: "post",
                        url: "{{route('updatePassword')}}",
                        data: {post},
                        dataType: "json",
                        
                    }).done(function(jsonResponse) {

                        switch(jsonResponse.error) {

                            case 0: // SUCCESS

                                Swal.fire({
                                    title: jsonResponse.userMsg,
                                    showClass: {popup: 'animate__animated animate__fadeInDown'},
                                    hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                                    icon: 'success',
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                                $('#modal-resetPassword').modal('hide');
                                $('#main-modal').html('');

                            break

                            case 1: // ERROR

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

                                if(jsonResponse.userMsg == 'Invalid current password') {

                                    $('#txt-resetPassword-currentPassword').addClass('is-invalid');
                                    $('#resetPasswordCurrentPassword').html('Invalid current password');

                                }

                                $('#spinner-btn-resetPasswordSave').attr('hidden', true);
                                $('#btn-resetPasswordSave').removeAttr('disabled');
                                    
                            break
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

                        $('#spinner-btn-resetPasswordSave').attr('hidden', true);
                        $('#btn-resetPasswordSave').removeAttr('disabled');

                        window.location.reload();

                    });

                } else { // ERROR NEW PASSWORD

                    Swal.fire({
                        title: 'The passwords do not match',
                        showClass: {popup: 'animate__animated animate__fadeInDown'},
                        hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                        icon: 'error',
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    $('#txt-resetPassword-newPasswordC').addClass('is-invalid');
                    $('#resetPasswordNewPasswordC').html('The passwords do not match');

                }

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

        $('.required').on('focus', function () { 
            $(this).removeClass('is-invalid');
            let msg = $(this).attr('msg');
            $('#' + msg).html('');
        });

        $('.focus').on('focus', function () { 
            $(this).removeClass('is-invalid');
            let msg = $(this).attr('msg');
            $('#' + msg).html('');
        });

        $('.required').keyup(function (e) { 
            let inputID = $(this).attr('id');
            requiredValuesOnKeyUP(inputID);
        });

        $('.closeModal').on('click', function () {
            $('#modal-resetPassword').modal('hide');
            $('#main-modal').html('');
        });

    });
</script>