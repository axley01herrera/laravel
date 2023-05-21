<script>
    $(document).ready(function () {

        $('#newPassword-btn-save').on('click', function () {

            let formRequiredValues = requiredValues();

            if(formRequiredValues === 0) {

                let password = $('#newPassword-input-password').val();
                let confirmPassword = $('#newPassword-input-confirmPassword').val();

                if(password === confirmPassword) {

                    $('#newPassword-btn-save').attr('disabled', true);
                    $('#newPassword-spinner-button-save').removeAttr('hidden');

                    let post = {
                        recordID: "{{ $recordID }}",
                        password: password
                    }

                    console.log(post);

                    $.ajax({

                        type: "post",
                        url: "{{ route('setNewPassword') }}",
                        data: {post},
                        dataType: "json",

                    }).done(function(jsonResponse) { console.log(jsonResponse);

                        switch(jsonResponse.error) {

                            case 0:

                                Swal.fire({
                                    showClass: {popup: 'animate__animated animate__fadeInDown'},
                                    hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                                    position: 'top-end',
                                    icon: 'success',
                                    title: jsonResponse.userMsg,
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                                $('#newPassword-spinner-button-save').attr('hidden', true);

                                setTimeout(() => {
                                    window.location.href="{{ route('login') }}";
                                }, "2000")

                            break

                            case 1:

                                $('#newPassword-btn-save').removeAttr('disabled');
                                $('#newPassword-spinner-button-save').attr('hidden', true);

                                Swal.fire({
                                    showClass: {popup: 'animate__animated animate__fadeInDown'},
                                    hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                                    position: 'top-end',
                                    icon: 'error',
                                    title: jsonResponse.userMsg,
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                            break
                        }

                    }).fail(function(error) {

                        $('#newPassword-btn-save').removeAttr('disabled');
                        $('#newPassword-spinner-button-save').attr('hidden', true);

                        Swal.fire({
                            title: 'An error has ocurred',
                            showClass: {popup: 'animate__animated animate__fadeInDown'},
                            hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 1500
                        });

                    });

                } else {

                    Swal.fire({
                        title: 'Passwords do not match',
                        showClass: {popup: 'animate__animated animate__fadeInDown'},
                        hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                        icon: 'error',
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    $('#newPassword-input-confirmPassword').addClass('is-invalid');
                }

            } else {

                Swal.fire({
                    title: 'Fields required',
                    showClass: {popup: 'animate__animated animate__fadeInDown'},
                    hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500
                });
            }

        });

        $('.required').on('focus', function () {

            $(this).removeClass('is-invalid');
        });

    });
</script>
