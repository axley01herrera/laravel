<script>
    $(document).ready(function () {

        $('#newUser-btn-save').on('click', function () {

            let formRequiredValues = requiredValues();

            if(formRequiredValues === 0) {

                let password = $('#newUser-input-password').val();
                let passwordC = $('#newUser-input-passwordC').val();

                if(password === passwordC) {

                    $('#newUser-btn-save').attr('disabled', true);
                    $('#newUser-spinner-button-save').removeAttr('hidden');

                    let post = {
                        contactRecordID: '{{ $contactRecordID }}',
                        user: $('#newUser-input-user').val(),
                        password: $('#newUser-input-password').val()
                    }

                    $.ajax({

                        type: "post",
                        url: "{{ route('createCredentials') }}",
                        data: {post},
                        dataType: "json",

                    }).done(function(jsonResponse) { console.log(jsonResponse);

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

                                $('#newUser-spinner-button-save').attr('hidden', true);

                                setTimeout(() => {
                                    window.location.href="{{ route('login') }}";
                                }, "2000")

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

                                $('#newUser-btn-save').removeAttr('disabled');
                                $('#newUser-spinner-button-save').attr('hidden', true);

                            break
                        }

                    }).fail(function(error) {

                        Swal.fire({
                            title: 'An error has ocurred',
                            showClass: {popup: 'animate__animated animate__fadeInDown'},
                            hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                            icon: 'error',
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        $('#newUser-btn-save').removeAttr('disabled');
                        $('#newUser-spinner-button-save').attr('hidden', true);

                        console.log('Method: Save new user');
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

                    $('#newUser-input-passwordC').addClass('is-invalid');
                }
            } else {

                Swal.fire({
                    title: 'Fields required',
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

        });

    });
</script>
