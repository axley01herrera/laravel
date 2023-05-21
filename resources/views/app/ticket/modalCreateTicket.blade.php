<style>
    textarea.form-control {
        min-height: calc(1.5em + 0.94rem + 2px);
        height: calc(100% - 2.8rem);
    }
</style>
<!--MODAL FADE-->
<div class="modal fade" id="modal-ticket" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
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
                        <label for="txt-ticketTitle"><strong>Subject</strong></label>
                        <input type="text" id="txt-ticketTitle" class="form-control required" msg="ticketTitle" />
                        <p id="ticketTitle" class="text-end text-danger"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6 mt-2">
                        <div class="row">
                            <div class="col-12">
                                <label for="txt-ticketContact"><strong>Contact</strong></label>
                                <!-- TXT CONTACT -->
                                <input id="txt-ticketContact" type="text" class="form-control required" value="{{ $contact['peopleName'] }}" msg="ticketContact" readonly />
                                <p id="ticketContact" class="text-end text-danger"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="txt-ticketPhone"><strong>Phone</strong></label>
                                 <!-- TXT PHONE -->
                                <input id="txt-ticketPhone" type="text" class="form-control number required phone" value="{{ $contact['peoplePhone'] }}" msg="ticketPhone" readonly />
                                <p id="ticketPhone" class="text-end text-danger"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="txt-ticketEmail"><strong>Email</strong></label>
                                <!-- TXT EMAIL -->
                                <input id="txt-ticketEmail" type="text" class="form-control required email" value="{{ $contact['peopleEmail'] }}" msg="ticketEmail" readonly />
                                <p id="ticketEmail" class="text-end text-danger"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="sel-ticketSupportSeverity"><strong>Support Severity</strong></label>
                                <!-- SEL SUPPORT SEVERITY -->
                                <select id="sel-ticketSupportSeverity" class="form-control required" style="width: 100%" msg="ticketSupportSeverity">
                                    <option value=""></option>
                                    @for ($i = 0; $i < $totalSupportSeverityDropdown; $i++)
                                        <option value="{{ $supportSeverityDropdown[$i]['id'] }}">{{ $supportSeverityDropdown[$i]['text'] }}</option>
                                    @endfor
                                </select>
                                <p id="ticketSupportSeverity" class="text-end text-danger"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="sel-ticketSupportPriority"><strong>Support Priority</strong></label>
                                <!-- SEL SUPPORT PRIORITY -->
                                <select id="sel-ticketSupportPriority" class="form-control required" style="width: 100%" msg="ticketSupportPriority">
                                    <option value=""></option>
                                    @for ($i = 0; $i < $totalSupportPriorityDropdown; $i++)
                                        <option value="{{ $supportPriorityDropdown[$i]['id'] }}">{{ $supportPriorityDropdown[$i]['text'] }}</option>
                                    @endfor
                                </select>
                                <p id="ticketSupportPriority" class="text-end text-danger"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="sel-ticketSupportType"><strong>Support Type</strong></label>
                                <!-- SEL SUPPORT TYPE -->
                                <select id="sel-ticketSupportType" class="form-control required" style="width: 100%" msg="ticketSupportType">
                                    <option value=""></option>
                                    @for ($i = 0; $i < $totalSupportTicketTypeDropdown; $i++)
                                        <option value="{{ $supportTicketTypeDropdown[$i]['id'] }}">{{ $supportTicketTypeDropdown[$i]['text'] }}</option>
                                    @endfor
                                </select>
                                <p id="ticketSupportType" class="text-end text-danger"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mt-2">
                        <label for="txt-ticketDescription"><strong>Description</strong></label>
                        <!-- TXT DESCRIPTION -->
                        <textarea id="txt-ticketDescription" class="form-control required" msg="ticketDescription"></textarea>
                        <p id="ticketDescription" class="text-end text-danger"></p>
                    </div>
                </div>
                <!-- UPLOAD FILES -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12">
                                <form id="uploadImage" action="#" class="dropzone">
                                    <div class="dz-message needsclick">
                                        <div>
                                            <i class="display-4 text-muted uil uil-cloud-upload"></i>
                                        </div>
                                        <h4>Drop screenshot here or click to upload.</h4>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- MODAL FOOTER -->
            <div class="modal-footer mt-10">
                <button id="btn-ticketClose" type="button" class="btn btn-secondary closeModal" data-bs-dismiss="modal">Close</button>
                <button id="btn-ticketSubmit" type="button" class="btn btn-primary">
                    <span id="spinner-btn-ticketSubmit" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
                    Submit
                </button>
            </div>
        </div>
    </div>
</div>
<script src="assets/customFunction/mask.js"></script>
@csrf
<script>
    $(document).ready(function () {

        $('#modal-ticket').modal('show');

        $('#sel-ticketSupportSeverity').select2({ // SEL SUPPORT SEVERITY

            placeholder: {
                id: '',
                text: 'Select'
            },
            //dropdownParent: $("#modal-ticket"),
            minimumResultsForSearch: Infinity
        });

        $('#sel-ticketSupportPriority').select2({ // SEL SUPPORT PRIORITY

            placeholder: {
                id: '',
                text: 'Select'
            },
            //dropdownParent: $("#modal-ticket"),
            minimumResultsForSearch: Infinity
        });

        $('#sel-ticketSupportType').select2({ // SEL SUPPORT TYPE

            placeholder: {
                id: '',
                text: 'Select'
            },
            //dropdownParent: $("#modal-ticket"),
            minimumResultsForSearch: Infinity
        });

        $('#btn-ticketSubmit').on('click', function () { // SUBMIT TICKET

            let formRequiredValues = requiredValues();

            if(formRequiredValues === 0) { // NOT REQUIRED VALUES

                let formEmailFormatValidation = emailFormatValidation();

                if(formEmailFormatValidation === 0) { // VALID EMAIL FORMAT

                    $('#btn-ticketSubmit').attr('disabled', true);
                    $('#spinner-btn-ticketSubmit').removeAttr('hidden');

                    let post = {
                        title: $('#txt-ticketTitle').val(),
                        supportSeverity: $('#sel-ticketSupportSeverity').val(),
                        supportPriority: $('#sel-ticketSupportPriority').val(),
                        supportType: $('#sel-ticketSupportType').val(),
                        description: $('#txt-ticketDescription').val(),
                        action: '{{ $action }}'
                    }

                    $.ajax({

                        type: "post",
                        url: "{{route('ticketSubmit')}}",
                        data: {post},
                        dataType: "json",

                    }).done(function(jsonResponse) { console.log(jsonResponse);

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

                                uploadImages(jsonResponse.recordID);
                                sendEmail(jsonResponse.recordID);

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

                                $('#spinner-btn-ticketSubmit').attr('hidden', true);
                                $('#btn-ticketSubmit').removeAttr('disabled');

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

                        window.location.reload();

                    });

                } else { // ERROR EMAIL INVALID FORMAT

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

        Dropzone.options.uploadImage = { // DROPZONE UPLOAD SCREEMSHOT

            url: "{{ route('ticketUploadScreemshot') }}",
            method: 'post',
            acceptedFiles: 'image/*',
            uploadMultiple: true,
            addRemoveLinks: true,
            autoProcessQueue: false,
            paramName: 'fileImage',

            init: function() {

                globalThis.uploadImage = this;

                this.on("sending", function(file, xhr, formData) {

                    formData.append("recordID", globalThis.imagesRecordID);
                    formData.append("_token", "{{ csrf_token() }}");
                });
            }
        };

        function uploadImages(recordID) {

            if(globalThis.uploadImage.files.length > 0) {

                globalThis.imagesRecordID = recordID;
                globalThis.uploadImage.processQueue();

                globalThis.uploadImage.on("complete", function(file ,response) {

                    console.log(response);

                });

            }
        }

        function sendEmail(recordID) {

            let post = {
                ticketRecordID: recordID
            }

            $.ajax({

                type: "post",
                url: "{{ route('ticketSendEmail') }}",
                data: {post},
                dataType: "json",

            }).done(function() {

                $('#modal-ticket').modal('hide');
                $('#main-modal').html('');

                $('#link-ticket').trigger('click');

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

            });

        }

        Dropzone.discover();

        $('.number').on('input', function () {

            jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
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

            $('#modal-ticket').modal('hide');
            $('#main-modal').html('');

        });
    });
</script>
