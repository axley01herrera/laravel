<script>
    $(document).ready(function () {

        $('#recoverPassword-btn-send').on('click', function (event) {

            event.preventDefault();

            let formRequiredValues = requiredValues();

            if(formRequiredValues === 0) {

                let formEmailFormatValidation = emailFormatValidation();

                if(formEmailFormatValidation === 0) {

                    $('#recoverPassword-btn-send').attr('disabled', true);
                    $('#recoverPassword-spinner-button-register').removeAttr('hidden');

                    let post = {
                        email: $('#recoverPassword-input-email').val()
                    }

                    $.ajax({

                        type: "post",
                        url: "{{ route('sendEmailRecoverPassword') }}",
                        data: {post},
                        dataType: "json",

                    }).done(function(jsonResponse) {

                        switch(jsonResponse.error) {

                            case 0:

                                Swal.fire({
                                    showClass: {popup: 'animate__animated animate__fadeInDown'},
                                    hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                                    position: 'top-end',
                                    icon: 'success',
                                    title: jsonResponse.userMsg,
                                    showConfirmButton: false,
                                    timer: 5500
                                });

                                $('#recoverPassword-spinner-button-register').attr('hidden', true);

                                setTimeout(() => {
                                    window.location.href="{{ route('login') }}";
                                }, "5600")

                            break

                            case 1:

                                Swal.fire({
                                    showClass: {popup: 'animate__animated animate__fadeInDown'},
                                    hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                                    position: 'top-end',
                                    icon: 'error',
                                    title: jsonResponse.userMsg,
                                    showConfirmButton: false,
                                    timer: 3500
                                });

                                $('#recoverPassword-btn-send').removeAttr('disabled');
                                $('#recoverPassword-spinner-button-register').attr('hidden', true);

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

                        $('#recoverPassword-btn-send').removeAttr('disabled');
                        $('#recoverPassword-spinner-button-register').attr('hidden', true);

                    });

                } else {
                    Swal.fire({
                        title: 'Invalid email format',
                        showClass: {popup: 'animate__animated animate__fadeInDown'},
                        hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                        icon: 'error',
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500
                    });
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

        $('.required').keyup(function (e) {

            let inputID = $(this).attr('id');
            requiredValuesOnKeyUP(inputID);
        });

    });
</script>
