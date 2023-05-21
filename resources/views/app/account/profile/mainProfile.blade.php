<!-- PAGE HEADER -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h3>Profile</h3>
        </div>
    </div>
</div>
<!-- PAGE CONTENT -->
<div class="row">
    <div class="col-12 col-md-12 col-lg-4">
        @include('app.account.profile.layouts.cardUser')
        @include('app.account.profile.layouts.cardPeople')
    </div>

    @if (!empty($company))

    <div class="col-12 col-md-12 col-lg-4">
        @include('app.account.profile.layouts.cardCompany')
        {{--@include('app.account.profile.layouts.cardMainContact')--}}
    </div>
    <div class="col-12 col-md-12 col-lg-4">
        @include('app.account.profile.layouts.cardBillingAddress')
        @include('app.account.profile.layouts.cardShippingAddress')
    </div>

    @endif
</div>
<script src="assets/customFunction/mask.js"></script>
<script>
    $(document).ready(function () {

        $('#btn-resetPassword').on('click', function () { // RESET PASSORD

            $('#btn-resetPassword').attr('disabled', true);
            $('#spinner-btn-resetPassword').removeAttr('hidden');

            $.ajax({

                type: "post",
                url:"{{ route('resetPassword') }}",
                dataType: "html",

            }).done(function(htmlResponse) {

                $('#btn-resetPassword').removeAttr('disabled');
                $('#spinner-btn-resetPassword').attr('hidden', true);

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

                window.location.reload();
            });
        });

        $('#btn-editPersonalInfo').on('click', function () { // EDIT PEOPLE

            $('#btn-editPersonalInfo').attr('disabled', true);
            $('#spinner-btn-editPersonalInfo').removeAttr('hidden');

            $.ajax({

                type: "post",
                url: "{{ route('editPeople') }}",
                dataType: "html",

            }).done(function(htmlResponse) {

                $('#btn-editPersonalInfo').removeAttr('disabled');
                $('#spinner-btn-editPersonalInfo').attr('hidden', true);

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

                $('#btn-editPersonalInfo').removeAttr('disabled');
                $('#spinner-btn-editPersonalInfo').attr('hidden', true);

                window.location.reload();
            });
        });

        $('#btn-editCompanyInfo').on('click', function () { // EDIT COMPANY

            $('#btn-editCompanyInfo').attr('disabled', true);
            $('#spinner-btn-editCompanyInfo').removeAttr('hidden');

            $.ajax({

                type: "post",
                url: "{{ route('editCompanyInfo') }}",
                dataType: "html",

            }).done(function(htmlResponse) {

                $('#btn-editCompanyInfo').removeAttr('disabled');
                $('#spinner-btn-editCompanyInfo').attr('hidden', true);

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

                $('#btn-editCompanyInfo').removeAttr('disabled');
                $('#spinner-btn-editCompanyInfo').attr('hidden', true);

                window.location.reload();
            });

        });

        $('#btn-editCompanyContactPerson').on('click', function () { // EDIT MAIN CONTACT

            $('#btn-editCompanyContactPerson').attr('disabled', true);
            $('#spinner-btn-editCompanyContactPerson').removeAttr('hidden');

            $.ajax({

                type: "post",
                url: "{{route('editCompanyContactPerson')}}",
                data: "",
                dataType: "html",

            }).done(function(htmlResponse) {

                $('#btn-editCompanyContactPerson').removeAttr('disabled');
                $('#spinner-btn-editCompanyContactPerson').attr('hidden', true);

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

                $('#btn-editCompanyContactPerson').removeAttr('disabled');
                $('#spinner-btn-editCompanyContactPerson').attr('hidden', true);

                window.location.reload();
            });
        });

        $('#btn-editCompanyBillingAddress').on('click', function () { // EDIT BILLING ADDRESS

            $('#btn-editCompanyBillingAddress').attr('disabled', true);
            $('#spinner-btn-editCompanyBillingAddress').removeAttr('hidden');

            $.ajax({

                type: "post",
                url: "{{route('editCompanyBilling')}}",
                data: "",
                dataType: "html",

            }).done(function(htmlResponse) {

                $('#btn-editCompanyBillingAddress').removeAttr('disabled');
                $('#spinner-btn-editCompanyBillingAddress').attr('hidden', true);

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

                $('#btn-editCompanyBillingAddress').removeAttr('disabled');
                $('#spinner-btn-editCompanyBillingAddress').attr('hidden', true);

                window.location.reload();
            });

        });

        $('#btn-editCompanyShippingAddress').on('click', function () { // EDIT SHIPPING ADDRESS

            $('#btn-editCompanyShippingAddress').attr('disabled', true);
            $('#spinner-btn-editCompanyShippingAddress').removeAttr('hidden');

            $.ajax({

                type: "post",
                url: "{{route('editCompanyShipping')}}",
                dataType: "html",

            }).done(function(htmlResponse) {

                $('#btn-editCompanyShippingAddress').removeAttr('disabled');
                $('#spinner-btn-editCompanyShippingAddress').attr('hidden', true);

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

                $('#btn-editCompanyShippingAddress').removeAttr('disabled');
                $('#spinner-btn-editCompanyShippingAddress').attr('hidden', true);

                window.location.reload();
            });

        });

        $('#btn-setBillingAddress').on('click', function () { // SET BILLING ADDRESS

            $('#btn-setBillingAddress').attr('disabled', true);
            $('#spinner-btn-setBillingAddress').removeAttr('hidden');

            let post = {
                companyRecordID: "{{ @$company['recordID'] }}",
                billingLine1: {
                    field: 'd_Billing_Address1',
                    value: "{{ @$company['address']['line1']}} "
                },
                billingLine2: {
                    field: 'd_Billing_Address2',
                    value: "{{ @$company['address']['line2'] }}"
                },
                billingZip: {
                    field: 'd_Billing_Address_Zip',
                    value: "{{ @$company['address']['zip'] }}"
                },
                billingCity: {
                    field: 'd_Billing_Address_City',
                    value: "{{ @$company['address']['city'] }}"
                },
                billingState: {
                    field: 'd_Billing_Address_State',
                    value: "{{ @$company['address']['state']}} "
                },
                billingCountry: {
                    field: 'd_Billing_Country',
                    value: "{{ @$company['address']['country'] }}"
                },
            }

            $.ajax({

                    type: "post",
                    url: "{{route('updateCompany')}}",
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

                            $('#modal-editCompanyShipping').modal('hide');
                            $('#main-modal').html('');

                            reloadMainProfile();

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

                            $('#spinner-btn-setBillingAddress').attr('hidden', true);
                            $('#btn-setBillingAddress').removeAttr('disabled');

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
                        icon: 'error',
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    $('#spinner-btn-setBillingAddress').attr('hidden', true);
                    $('#btn-setBillingAddress').removeAttr('disabled');

                    window.location.reload();

                });

        });

        $('#btn-setShippingAddress').on('click', function () { // SET SHIPPING ADDRESS

            $('#btn-setShippingAddress').attr('disabled', true);
            $('#spinner-btn-setShippingAddress').removeAttr('hidden');

            let post = {
                companyRecordID: "{{ @$company['recordID'] }}",
                shippingLine1: {
                    field: 'd_Shipping_Address1',
                    value: "{{ @$company['billing']['address']['line1']}} "
                },
                shippingLine2: {
                    field: 'd_Shipping_Address2',
                    value: "{{ @$company['billing']['address']['line2'] }}"
                },
                shippingZip: {
                    field: 'd_Shipping_Address_Zip',
                    value: "{{ @$company['billing']['address']['zip'] }}"
                },
                shippingCity: {
                    field: 'd_Shipping_Address_City',
                    value: "{{ @$company['billing']['address']['city'] }}"
                },
                shippingState: {
                    field: 'd_Shipping_Address_State',
                    value: "{{ @$company['billing']['address']['state']}} "
                },
                shippingCountry: {
                    field: 'd_Shipping_Country',
                    value: "{{ @$company['billing']['address']['country'] }}"
                },
            }

            $.ajax({

                    type: "post",
                    url: "{{ route('updateCompany') }}",
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

                            reloadMainProfile();

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

                            $('#spinner-btn-setShippingAddress').attr('hidden', true);
                            $('#btn-setShippingAddress').removeAttr('disabled');

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
                        icon: 'error',
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    $('#spinner-btn-setShippingAddress').attr('hidden', true);
                    $('#btn-setShippingAddress').removeAttr('disabled');

                    window.location.reload();

                });

        });

        function reloadMainProfile() {

            let target = document.getElementById('spinner');
			let spinner = new Spinner(opts).spin(target);

            $.ajax({

                type: "post",
                url: "{{ route('profile') }}",
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

				window.location.reload();
			});
        }
    });
</script>
