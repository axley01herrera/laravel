<script>
    $(document).ready(function () {

        $('#btn-login').on('click', function () {

            let formRequiredValues = requiredValues();

            if(formRequiredValues === 0) {

                $('#btn-login').attr('disabled', true);
                $('#spinner-btn-login').removeAttr('hidden');

                let post = {
                    user: $('#login-txt-user').val(),
                    password: $('#login-txt-password').val(),
                    url: "{{ route('newLogin') }}"
                }

                $.ajax({

                    type: "post",
                    url: "{{ route('newLogin') }}",
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

                            setTimeout(() => {
                                window.location.href="{{ route('app') }}";
                            }, "2000");
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

                            $('#btn-login').removeAttr('disabled');
                            $('#spinner-btn-login').attr('hidden', true);

                        break

                        case 'Invalid_Request':

                            Swal.fire({
                                title: jsonResponse.userMsg,
                                showClass: {popup: 'animate__animated animate__fadeInDown'},
                                hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            $('#btn-login').removeAttr('disabled');
                            $('#spinner-btn-login').attr('hidden', true);

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

                    $('#btn-login').removeAttr('disabled');
                    $('#spinner-btn-login').attr('hidden', true);

                });

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

        $('#btn-forgotPassword').on('click', function (event) {

            event.preventDefault();

            $.ajax({

                type: "post",
                url: "{{ route('recoverPassword') }}",
                dataType: "html",

            }).done(function(htmlResponse) {

                $('#content').html(htmlResponse);

            }).fail(function(error) {

                Swal.fire({
                    title: 'An error has ocurred',
                    showClass: {popup: 'animate__animated animate__fadeInDown'},
                    hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500
                });

            });

        });

        $('.required').keypress(function (e){ // SIGN IN PRESS ENTER

            var key = e.which;

            if(key == 13){  // the enter key code

                $('#btn-login').trigger('click');
                return false;
            }
        });
    });
</script>
