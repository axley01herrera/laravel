<!--MODAL FADE-->
<div class="modal fade" id="modal-editPersonalInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- MODAL HEADER -->
            <div class="modal-header">
                <!--MODAL TITLE-->
                <h5 class="modal-title" id="staticBackdropLabel">Edit Personal Information</h5>
                <button type="button" class="btn-close closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- MODAL BODY -->
            <div class="modal-body">
                <div class="row">
                    <!-- TXT NAME -->
                    <div class="col-12 col-md-4 col-lg-4">
                        <label for="txt-editPI-name"><strong>Name</strong></label>
                        <input id="txt-editPI-name" type="text" class="form-control required" value="{{$people['name']}}" msg="editPIName" />
                        <p id="editPIName" class="text-end text-danger"></p>
                    </div>
                    <!-- TXT LAST NAME -->
                    <div class="col-12 col-md-5 col-lg-5">
                        <label for="txt-editPI-lastName"><strong>Last Name</strong></label>
                        <input id="txt-editPI-lastName" type="text" class="form-control required" value="{{$people['lastName']}}" msg="editPILastName" />
                        <p id="editPILastName" class="text-end text-danger"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <!-- TXT EMAIL -->
                        <label for="txt-editPI-email"><strong>Email</strong></label>
                        <input id="txt-editPI-email" type="text" class="form-control required email" value="{{$people['email']}}" msg="editPIEmail" />
                        <p id="editPIEmail" class="text-end text-danger"></p>
                    </div>
                </div>
                <div class="row">
                    <!-- TXT PHONE MOBILE -->
                    <div class="col-12 col-md-4 col-lg-4">
                        <label for="txt-editPI-PhoneMobile"><strong>Phone Mobile</strong></label>
                        <input id="txt-editPI-PhoneMobile" type="text" class="form-control required phone" value="{{$people['phoneM']}}" msg="editPIPhoneMobile" />
                        <p id="editPIPhoneMobile" class="text-end text-danger"></p>
                    </div>
                    <!-- TXT PHONE WORK -->
                    <div class="col-12 col-md-4 col-lg-4">
                        <label for="txt-editPI-PhoneWork"><strong>Phone Work</strong></label>
                        <input id="txt-editPI-PhoneWork" type="text" class="form-control required phone" value="{{$people['phoneW']}}" msg="editPIPhoneWork" />
                        <p id="editPIPhoneWork" class="text-end text-danger"></p>
                    </div>
                </div>
                <div class="row">
                    <!-- TXT ADDRESS LINE 1 -->
                    <div class="col-12 col-md-6 col-lg-6">
                        <label for="txt-editPI-AddressLine1"><strong>Address line 1</strong></label>
                        <input id="txt-editPI-AddressLine1" type="text" class="form-control required" value="{{$people['address']['line1']}}" msg="editPIAddressLine1" />
                        <p id="editPIAddressLine1" class="text-end text-danger"></p>
                    </div>
                    <!-- TXT ADDRESS LINE 2 -->
                    <div class="col-12 col-md-6 col-lg-6">
                        <label for="txt-editPI-AddressLine2"><strong>Address line 2</strong></label>
                        <input id="txt-editPI-AddressLine2" type="text" class="form-control" value="{{$people['address']['line2']}}" msg="editPIAddressLine2" />
                        <p id="editPIAddressLine2" class="text-end text-danger"></p>
                    </div>
                    <!-- TXT ZIP -->
                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="txt-editPI-Zip"><strong>Zip</strong></label>
                        <input id="txt-editPI-Zip" type="text" class="form-control required zip" value="{{$people['address']['zip']}}" msg="editPIZip" maxlength="5" />
                        <p id="editPIZip" class="text-end text-danger"></p>
                    </div>
                    <!-- TXT CITY -->
                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="txt-editPI-City"><strong>City</strong></label>
                        <input id="txt-editPI-City" type="text" class="form-control required city" value="{{$people['address']['city']}}" msg="editPICity" />
                        <p id="editPICity" class="text-end text-danger"></p>
                    </div>
                    <!-- SEL STATE -->
                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="sel-editPI-State"><strong>State</strong></label>
                        <select id="sel-editPI-State" class="form-control required state" style="width: 100%" msg="editPIState">
                            <option class="" value=""></option>
                            <option <?php if($people['address']['state'] == 'AL')echo 'selected';?> value="AL">Alabama</option>
                            <option <?php if($people['address']['state'] == 'AK')echo 'selected';?> value="AK">Alaska</option>
                            <option <?php if($people['address']['state'] == 'AZ')echo 'selected';?> value="AZ">Arizona</option>
                            <option <?php if($people['address']['state'] == 'AR')echo 'selected';?> value="AR">Arkansas</option>
                            <option <?php if($people['address']['state'] == 'CA')echo 'selected';?> value="CA">California</option>
                            <option <?php if($people['address']['state'] == 'CO')echo 'selected';?> value="CO">Colorado</option>
                            <option <?php if($people['address']['state'] == 'CT')echo 'selected';?> value="CT">Connecticut</option>
                            <option <?php if($people['address']['state'] == 'DE')echo 'selected';?> value="DE">Delaware</option>
                            <option <?php if($people['address']['state'] == 'DC')echo 'selected';?> value="DC">District Of Columbia</option>
                            <option <?php if($people['address']['state'] == 'FL')echo 'selected';?> value="FL">Florida</option>
                            <option <?php if($people['address']['state'] == 'GA')echo 'selected';?> value="GA">Georgia</option>
                            <option <?php if($people['address']['state'] == 'HI')echo 'selected';?> value="HI">Hawaii</option>
                            <option <?php if($people['address']['state'] == 'ID')echo 'selected';?> value="ID">Idaho</option>
                            <option <?php if($people['address']['state'] == 'IL')echo 'selected';?> value="IL">Illinois</option>
                            <option <?php if($people['address']['state'] == 'IN')echo 'selected';?> value="IN">Indiana</option>
                            <option <?php if($people['address']['state'] == 'IA')echo 'selected';?> value="IA">Iowa</option>
                            <option <?php if($people['address']['state'] == 'KS')echo 'selected';?> value="KS">Kansas</option>
                            <option <?php if($people['address']['state'] == 'KY')echo 'selected';?> value="KY">Kentucky</option>
                            <option <?php if($people['address']['state'] == 'LA')echo 'selected';?> value="LA">Louisiana</option>
                            <option <?php if($people['address']['state'] == 'ME')echo 'selected';?> value="ME">Maine</option>
                            <option <?php if($people['address']['state'] == 'MD')echo 'selected';?> value="MD">Maryland</option>
                            <option <?php if($people['address']['state'] == 'MA')echo 'selected';?> value="MA">Massachusetts</option>
                            <option <?php if($people['address']['state'] == 'MI')echo 'selected';?> value="MI">Michigan</option>
                            <option <?php if($people['address']['state'] == 'MN')echo 'selected';?> value="MN">Minnesota</option>
                            <option <?php if($people['address']['state'] == 'MS')echo 'selected';?> value="MS">Mississippi</option>
                            <option <?php if($people['address']['state'] == 'MO')echo 'selected';?> value="MO">Missouri</option>
                            <option <?php if($people['address']['state'] == 'MT')echo 'selected';?> value="MT">Montana</option>
                            <option <?php if($people['address']['state'] == 'NE')echo 'selected';?> value="NE">Nebraska</option>
                            <option <?php if($people['address']['state'] == 'NV')echo 'selected';?> value="NV">Nevada</option>
                            <option <?php if($people['address']['state'] == 'NH')echo 'selected';?> value="NH">New Hampshire</option>
                            <option <?php if($people['address']['state'] == 'NJ')echo 'selected';?> value="NJ">New Jersey</option>
                            <option <?php if($people['address']['state'] == 'NM')echo 'selected';?> value="NM">New Mexico</option>
                            <option <?php if($people['address']['state'] == 'NY')echo 'selected';?> value="NY">New York</option>
                            <option <?php if($people['address']['state'] == 'NC')echo 'selected';?> value="NC">North Carolina</option>
                            <option <?php if($people['address']['state'] == 'ND')echo 'selected';?> value="ND">North Dakota</option>
                            <option <?php if($people['address']['state'] == 'OH')echo 'selected';?> value="OH">Ohio</option>
                            <option <?php if($people['address']['state'] == 'OK')echo 'selected';?> value="OK">Oklahoma</option>
                            <option <?php if($people['address']['state'] == 'OR')echo 'selected';?> value="OR">Oregon</option>
                            <option <?php if($people['address']['state'] == 'PA')echo 'selected';?> value="PA">Pennsylvania</option>
                            <option <?php if($people['address']['state'] == 'RI')echo 'selected';?> value="RI">Rhode Island</option>
                            <option <?php if($people['address']['state'] == 'SC')echo 'selected';?> value="SC">South Carolina</option>
                            <option <?php if($people['address']['state'] == 'SD')echo 'selected';?> value="SD">South Dakota</option>
                            <option <?php if($people['address']['state'] == 'TN')echo 'selected';?> value="TN">Tennessee</option>
                            <option <?php if($people['address']['state'] == 'TX')echo 'selected';?> value="TX">Texas</option>
                            <option <?php if($people['address']['state'] == 'UT')echo 'selected';?> value="UT">Utah</option>
                            <option <?php if($people['address']['state'] == 'VT')echo 'selected';?> value="VT">Vermont</option>
                            <option <?php if($people['address']['state'] == 'VA')echo 'selected';?> value="VA">Virginia</option>
                            <option <?php if($people['address']['state'] == 'WA')echo 'selected';?> value="WA">Washington</option>
                            <option <?php if($people['address']['state'] == 'WV')echo 'selected';?> value="WV">West Virginia</option>
                            <option <?php if($people['address']['state'] == 'WI')echo 'selected';?> value="WI">Wisconsin</option>
                            <option <?php if($people['address']['state'] == 'WY')echo 'selected';?> value="WY">Wyoming</option>
                        </select>
                        <p id="editPIState" class="text-end text-danger"></p>
                    </div>
                    <!-- SEL COUNTRY -->
                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="sel-editPI-Country"><strong>Country</strong></label>
                        <select id="sel-editPI-Country" class="form-control required" style="width: 100%" msg="editPICountry">
                            <option value=""></option>
                            <option <?php if($people['address']['country'] == 'US')echo 'selected';?> value="US">United States</option>
                        </select>
                        <p id="editPICountry" class="text-end text-danger"></p>
                    </div>
                </div>
            </div>
            <!-- MODAL FOOTER -->
            <div class="modal-footer mt-10">
                <button id="btn-editPIClose" type="button" class="btn btn-secondary closeModal" data-bs-dismiss="modal">Close</button>
                <button id="btn-editPISave" type="button" class="btn btn-primary">
                    <span id="spinner-btn-editPISave" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
                    Save
                </button>
            </div>
        </div>
    </div>
</div>
<script src="assets/customFunction/mask.js"></script>
<script src="assets/customFunction/setCityAndState.js"></script>
<script>
    $(document).ready(function () {

        $('#modal-editPersonalInfo').modal('show');

        $('#sel-editPI-State').select2({ // SEL STATE

            placeholder: {
                id: '',
                text: 'Select'
            },
            dropdownParent: $("#modal-editPersonalInfo")

        });

        $('#sel-editPI-Country').select2({ // SEL COUNTRY

            placeholder: {
                id: '',
                text: 'Select'
            },

            dropdownParent: $("#modal-editPersonalInfo"),
            minimumResultsForSearch: Infinity
        });

        $('#btn-editPISave').on('click', function () { // BTN SAVE

            let formRequiredValues = requiredValues();
            let formPhoneValidation = phoneFormatValidation();
            let formEmailValidation = emailFormatValidation();

            if(formRequiredValues === 0 && formPhoneValidation === 0 && formEmailValidation === 0) { // NOT REQUIRED VALUES

                $('#btn-editPISave').attr('disabled', true);
                $('#spinner-btn-editPISave').removeAttr('hidden');

                let post = {
                    peopleRecordID: '{{$people['recordID']}}',
                    name: $('#txt-editPI-name').val(),
                    lastName: $('#txt-editPI-lastName').val(),
                    phoneM: $('#txt-editPI-PhoneMobile').val(),
                    phoneW: $('#txt-editPI-PhoneWork').val(),
                    addressLine1: $('#txt-editPI-AddressLine1').val(),
                    addresLine2: $('#txt-editPI-AddressLine2').val(),
                    city: $('#txt-editPI-City').val(),
                    state: $('#sel-editPI-State').val(),
                    zip: $('#txt-editPI-Zip').val(),
                    country: $('#sel-editPI-Country').val(),
                    email: $('#txt-editPI-email').val()
                }

                $.ajax({

                    type: "post",
                    url: "{{route('updatePersonalInformation')}}",
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

                            $('#modal-editPersonalInfo').modal('hide');
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

                            $('#spinner-btn-editPISave').attr('hidden', true);
                            $('#btn-editPISave').removeAttr('disabled');

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

                    $('#spinner-btn-editPISave').attr('hidden', true);
                    $('#btn-editPISave').removeAttr('disabled');

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
            $('#modal-editPersonalInfo').modal('hide');
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
