<!--MODAL FADE-->
<div class="modal fade" id="modal-editCompanyPerson" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- MODAL HEADER -->
            <div class="modal-header">
                <!--MODAL TITLE-->
                <h5 class="modal-title" id="staticBackdropLabel">Edit Main Contact</h5>
                <button type="button" class="btn-close closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- MODAL BODY -->
            <div class="modal-body">
                <div class="row">
                    <!-- TXT NAME -->
                    <div class="col-12 col-md-6 col-lg-6">
                        <label for="txt-editCP-name"><strong>Name</strong></label>
                        <input type="text" id="txt-editCP-name" class="form-control required" msg="editCPName" value="{{$company['contact']['person']['name']}}" />
                        <p id="editCPName" class="text-end text-danger"></p>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <!-- TXT EMAIL -->
                        <label for="txt-editCP-email"><strong>Email</strong></label>
                        <input id="txt-editCP-email" type="text" class="form-control required email" value="{{$company['contact']['person']['email']}}" msg="editCPEmail" />
                        <p id="editCPEmail" class="text-end text-danger"></p>
                    </div>
                </div>
                <div class="row">
                    <!-- TXT PHONE C-->
                    <div class="col-12 col-md-4 col-lg-4">
                        <label for="txt-editCP-phonec"><strong>Phone Cell</strong></label>
                        <input id="txt-editCP-phonec" type="text" class="form-control required phone" value="{{$company['contact']['person']['phoneC']}}" msg="editCPPhonec" />
                        <p id="editCPPhonec" class="text-end text-danger"></p>
                    </div>
                    <!-- TXT PHONE W-->
                    <div class="col-12 col-md-4 col-lg-4">
                        <label for="txt-editCP-phonew"><strong>Phone Work</strong></label>
                        <input id="txt-editCP-phonew" type="text" class="form-control required phone" value="{{$company['contact']['person']['phoneW']}}" msg="editCPPhonew" />
                        <p id="editCPPhonew" class="text-end text-danger"></p>
                    </div>
                    <!-- TXT EXT -->
                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="txt-editCP-phoneExt"><strong>Ext</strong></label>
                        <input id="txt-editCP-phoneExt" type="text" class="form-control" value="{{$company['contact']['person']['phoneExt']}}" msg="editCPPhonephoneExt" />
                        <p id="editCPPhonephoneExt" class="text-end text-danger"></p>
                    </div>
                </div>
            </div>
            <!-- MODAL FOOTER -->
            <div class="modal-footer mt-10">
                <button id="btn-editCPClose" type="button" class="btn btn-secondary closeModal" data-bs-dismiss="modal">Close</button>
                <button id="btn-editCPSave" type="button" class="btn btn-primary">
                    <span id="spinner-btn-editCPSave" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
                    Save
                </button>
            </div>
        </div>
    </div>
</div>
<script src="assets/customFunction/mask.js"></script>
<script>
    $(document).ready(function () {

        $('#modal-editCompanyPerson').modal('show');

        $('#btn-editCPSave').on('click', function () {

            let formRequiredValues = requiredValues();
            let formPhoneValidation = phoneFormatValidation();
            let formEmailValidation = emailFormatValidation();

            if(formRequiredValues == 0 && formPhoneValidation == 0 && formEmailValidation == 0) {

                $('#btn-editCPSave').attr('disabled', true);
                $('#spinner-btn-editCPSave').removeAttr('hidden');

                let post = {
                    companyRecordID: "{{$company['recordID']}}",
                    personName: {
                        field: 'd_Main_ContactPerson',
                        value: $('#txt-editCP-name').val()
                    },
                    personEmail: {
                        field: 'd_Main_ContactPerson_Email',
                        value: $('#txt-editCP-email').val()
                    },
                    personC: {
                        field: 'd_Main_ContactPerson_Phone_Cell',
                        value: $('#txt-editCP-phonec').val()
                    },
                    personW: {
                        field: 'd_Main_ContactPerson_Phone',
                        value: $('#txt-editCP-phonew').val()
                    },
                    personExt: {
                        field: 'd_Main_ContactPerson_Phone_Ext',
                        value: $('#txt-editCP-phoneExt').val()
                    }
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

                            $('#modal-editCompanyPerson').modal('hide');
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

                            $('#spinner-btn-editCPSave').attr('hidden', true);
                            $('#btn-editCPSave').removeAttr('disabled');

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

                    $('#spinner-btn-editCPSave').attr('hidden', true);
                    $('#btn-editCPSave').removeAttr('disabled');

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

        $('.required').on('focus', function () {

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
            $('#modal-editCompanyPerson').modal('hide');
            $('#main-modal').html('');
        });

        $('.phone').on('input', function () {
            jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
        });

        function reloadMainProfile() {

            var target = document.getElementById('spinner');
			var spinner = new Spinner(opts).spin(target);

            $.ajax({

                type: "post",
                url: "{{ route('profile') }}",
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
