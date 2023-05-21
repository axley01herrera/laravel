<!--MODAL FADE-->
<div class="modal fade" id="modal-editCompanyInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- MODAL HEADER -->
            <div class="modal-header">
                <!--MODAL TITLE-->
                <h5 class="modal-title" id="staticBackdropLabel">Edit Company</h5>
                <button type="button" class="btn-close closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- MODAL BODY -->
            <div class="modal-body">
                <div class="row">
                    <!-- TXT NAME -->
                    <div class="col-12 col-md-6 col-lg-6">
                        <label for="txt-editCI-name"><strong>Name</strong></label>
                        <input type="text" id="txt-editCI-name" class="form-control required" msg="editCIName" value="{{$company['name']}}" />
                        <p id="editCIName" class="text-end text-danger"></p>
                    </div>
                    <!-- TXT PHONE -->
                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="txt-editCI-phone"><strong>Primary Phone</strong></label>
                        <input id="txt-editCI-phone" type="text" class="form-control required phone" value="{{$company['phone']}}" msg="editCIPhone" />
                        <p id="editCIPhone" class="text-end text-danger"></p>
                    </div>
                    <!-- SEL PHONE TYPE -->
                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="txt-editCI-phone"><strong>Type</strong></label>
                        <select id="sel-editCI-phoneType" class="form-control required" msg="editCIPhoneType" style="width: 100%">
                            <option value=""></option>
                            <option @if ($company['phoneType'] == 'Mobile') {{'selected'}} @endif value="Mobile">Mobile</option>
                            <option @if ($company['phoneType'] == 'Work') {{'selected'}} @endif value="Work">Work</option>
                            <option @if ($company['phoneType'] == 'Home') {{'selected'}} @endif value="Home">Home</option>
                        </select>
                        <p id="editCIPhoneType" class="text-end text-danger"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <!-- TXT EMAIL -->
                        <label for="txt-editCI-email"><strong>Email</strong></label>
                        <input id="txt-editCI-email" type="text" class="form-control required email" value="{{$company['email']}}" msg="editCIEmail" />
                        <p id="editCIEmail" class="text-end text-danger"></p>
                    </div>
                </div>
                <div class="row">
                    <!-- TXT-LINE 1 -->
                    <div class="col-12 col-md-6 col-lg-6">
                        <label for="txt-editCI-addressLine1"><strong>Address line 1</strong></label>
                        <input id="txt-editCI-addressLine1" type="text" class="form-control required" value="{{$company['address']['line1']}}" msg="editCIAddressLine1" />
                        <p id="editCIAddressLine1" class="text-end text-danger"></p>
                    </div>
                    <!-- TXT-LINE 2 -->
                    <div class="col-12 col-md-6 col-lg-6">
                        <label for="txt-editCI-addressLine2"><strong>Address line 2</strong></label>
                        <input id="txt-editCI-addressLine2" type="text" class="form-control" value="{{$company['address']['line2']}}" msg="editCIAddressLine2" />
                        <p id="editCIAddressLine2" class="text-end text-danger"></p>
                    </div>
                    <!-- TXT ZIP -->
                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="txt-editCI-zip"><strong>Zip</strong></label>
                        <input id="txt-editCI-zip" type="text" class="form-control required zip" value="{{$company['address']['zip']}}" msg="editCIZip" maxlength="5" />
                        <p id="editCIZip" class="text-end text-danger"></p>
                    </div>
                    <!-- TXT CITY -->
                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="txt-editCI-city"><strong>City</strong></label>
                        <input id="txt-editCI-city" type="text" class="form-control required city" value="{{$company['address']['city']}}" msg="editCICity" />
                        <p id="editCICity" class="text-end text-danger"></p>
                    </div>
                    <!-- SEL STATE -->
                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="sel-editCI-state"><strong>State</strong></label>
                        <select id="sel-editCI-state" class="form-control required state" style="width: 100%" msg="editCIState">
                            <option class="" value=""></option>
                            <option <?php if($company['address']['state'] == 'AL')echo 'selected';?> value="AL">Alabama</option>
                            <option <?php if($company['address']['state'] == 'AK')echo 'selected';?> value="AK">Alaska</option>
                            <option <?php if($company['address']['state'] == 'AZ')echo 'selected';?> value="AZ">Arizona</option>
                            <option <?php if($company['address']['state'] == 'AR')echo 'selected';?> value="AR">Arkansas</option>
                            <option <?php if($company['address']['state'] == 'CA')echo 'selected';?> value="CA">California</option>
                            <option <?php if($company['address']['state'] == 'CO')echo 'selected';?> value="CO">Colorado</option>
                            <option <?php if($company['address']['state'] == 'CT')echo 'selected';?> value="CT">Connecticut</option>
                            <option <?php if($company['address']['state'] == 'DE')echo 'selected';?> value="DE">Delaware</option>
                            <option <?php if($company['address']['state'] == 'DC')echo 'selected';?> value="DC">District Of Columbia</option>
                            <option <?php if($company['address']['state'] == 'FL')echo 'selected';?> value="FL">Florida</option>
                            <option <?php if($company['address']['state'] == 'GA')echo 'selected';?> value="GA">Georgia</option>
                            <option <?php if($company['address']['state'] == 'HI')echo 'selected';?> value="HI">Hawaii</option>
                            <option <?php if($company['address']['state'] == 'ID')echo 'selected';?> value="ID">Idaho</option>
                            <option <?php if($company['address']['state'] == 'IL')echo 'selected';?> value="IL">Illinois</option>
                            <option <?php if($company['address']['state'] == 'IN')echo 'selected';?> value="IN">Indiana</option>
                            <option <?php if($company['address']['state'] == 'IA')echo 'selected';?> value="IA">Iowa</option>
                            <option <?php if($company['address']['state'] == 'KS')echo 'selected';?> value="KS">Kansas</option>
                            <option <?php if($company['address']['state'] == 'KY')echo 'selected';?> value="KY">Kentucky</option>
                            <option <?php if($company['address']['state'] == 'LA')echo 'selected';?> value="LA">Louisiana</option>
                            <option <?php if($company['address']['state'] == 'ME')echo 'selected';?> value="ME">Maine</option>
                            <option <?php if($company['address']['state'] == 'MD')echo 'selected';?> value="MD">Maryland</option>
                            <option <?php if($company['address']['state'] == 'MA')echo 'selected';?> value="MA">Massachusetts</option>
                            <option <?php if($company['address']['state'] == 'MI')echo 'selected';?> value="MI">Michigan</option>
                            <option <?php if($company['address']['state'] == 'MN')echo 'selected';?> value="MN">Minnesota</option>
                            <option <?php if($company['address']['state'] == 'MS')echo 'selected';?> value="MS">Mississippi</option>
                            <option <?php if($company['address']['state'] == 'MO')echo 'selected';?> value="MO">Missouri</option>
                            <option <?php if($company['address']['state'] == 'MT')echo 'selected';?> value="MT">Montana</option>
                            <option <?php if($company['address']['state'] == 'NE')echo 'selected';?> value="NE">Nebraska</option>
                            <option <?php if($company['address']['state'] == 'NV')echo 'selected';?> value="NV">Nevada</option>
                            <option <?php if($company['address']['state'] == 'NH')echo 'selected';?> value="NH">New Hampshire</option>
                            <option <?php if($company['address']['state'] == 'NJ')echo 'selected';?> value="NJ">New Jersey</option>
                            <option <?php if($company['address']['state'] == 'NM')echo 'selected';?> value="NM">New Mexico</option>
                            <option <?php if($company['address']['state'] == 'NY')echo 'selected';?> value="NY">New York</option>
                            <option <?php if($company['address']['state'] == 'NC')echo 'selected';?> value="NC">North Carolina</option>
                            <option <?php if($company['address']['state'] == 'ND')echo 'selected';?> value="ND">North Dakota</option>
                            <option <?php if($company['address']['state'] == 'OH')echo 'selected';?> value="OH">Ohio</option>
                            <option <?php if($company['address']['state'] == 'OK')echo 'selected';?> value="OK">Oklahoma</option>
                            <option <?php if($company['address']['state'] == 'OR')echo 'selected';?> value="OR">Oregon</option>
                            <option <?php if($company['address']['state'] == 'PA')echo 'selected';?> value="PA">Pennsylvania</option>
                            <option <?php if($company['address']['state'] == 'RI')echo 'selected';?> value="RI">Rhode Island</option>
                            <option <?php if($company['address']['state'] == 'SC')echo 'selected';?> value="SC">South Carolina</option>
                            <option <?php if($company['address']['state'] == 'SD')echo 'selected';?> value="SD">South Dakota</option>
                            <option <?php if($company['address']['state'] == 'TN')echo 'selected';?> value="TN">Tennessee</option>
                            <option <?php if($company['address']['state'] == 'TX')echo 'selected';?> value="TX">Texas</option>
                            <option <?php if($company['address']['state'] == 'UT')echo 'selected';?> value="UT">Utah</option>
                            <option <?php if($company['address']['state'] == 'VT')echo 'selected';?> value="VT">Vermont</option>
                            <option <?php if($company['address']['state'] == 'VA')echo 'selected';?> value="VA">Virginia</option>
                            <option <?php if($company['address']['state'] == 'WA')echo 'selected';?> value="WA">Washington</option>
                            <option <?php if($company['address']['state'] == 'WV')echo 'selected';?> value="WV">West Virginia</option>
                            <option <?php if($company['address']['state'] == 'WI')echo 'selected';?> value="WI">Wisconsin</option>
                            <option <?php if($company['address']['state'] == 'WY')echo 'selected';?> value="WY">Wyoming</option>
                        </select>
                        <p id="editCIState" class="text-end text-danger"></p>
                    </div>
                    <!-- SEL COUNTRY -->
                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="sel-editCI-country"><strong>Country</strong></label>
                        <select id="sel-editCI-country" class="form-control required" style="width: 100%" msg="editCICountry">
                            <option value=""></option>
                            <option <?php if($company['address']['country'] == 'US')echo 'selected';?> value="US">United States</option>
                        </select>
                        <p id="editCICountry" class="text-end text-danger"></p>
                    </div>
                    <div class="col-12">
                        <!-- TXT WEB SITE -->
                        <label for="txt-editCI-web"><strong>Web Site</strong></label>
                        <input type="text" id="txt-editCI-web" class="form-control" msg="editCIWeb" value="{{$company['url']}}" />
                        <p id="editCIWeb" class="text-end text-danger"></p>
                    </div>
                </div>
            </div>
            <!-- MODAL FOOTER -->
            <div class="modal-footer mt-10">
                <button id="btn-editCIClose" type="button" class="btn btn-secondary closeModal" data-bs-dismiss="modal">Close</button>
                <button id="btn-editCISave" type="button" class="btn btn-primary">
                    <span id="spinner-btn-editCISave" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
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

        $('#modal-editCompanyInfo').modal('show');

        $('#btn-editCISave').on('click', function () {

            let formRequiredValues = requiredValues();
            let formPhoneValidation = phoneFormatValidation();
            let formEmailValidation = emailFormatValidation();

            if(formRequiredValues == 0 && formPhoneValidation == 0 && formEmailValidation == 0) {

                $('#btn-editCISave').attr('disabled', true);
                $('#spinner-btn-editCISave').removeAttr('hidden');

                let post = {
                    companyRecordID: "{{$company['recordID']}}",
                    name: {
                        field: 'd_Name_Company',
                        value: $('#txt-editCI-name').val()
                    },
                    phone: {
                        field: 'd_Prime_PhoneNumber1',
                        value: $('#txt-editCI-phone').val()
                    },
                    email: {
                        field: 'd_Prime_Email',
                        value: $('#txt-editCI-email').val()
                    },
                    addressLine1: {
                        field: 'd_Prime_Address1',
                        value: $('#txt-editCI-addressLine1').val()
                    },
                    addressLine2: {
                        field: 'd_Prime_Address2',
                        value: $('#txt-editCI-addressLine2').val()
                    },
                    zip: {
                        field: 'd_Prime_Address_Zip',
                        value: $('#txt-editCI-zip').val()
                    },
                    city: {
                        field: 'd_Prime_Address_City',
                        value: $('#txt-editCI-city').val()
                    },
                    state: {
                        field: 'd_Prime_Address_State',
                        value: $('#sel-editCI-state').val()
                    },
                    country: {
                        field: 'd_Prime_Country',
                        value: $('#sel-editCI-country').val()
                    },
                    web: {
                        field: 'd_Prime_URL',
                        value: $('#txt-editCI-web').val()
                    },
                    phoneType: {
                        field: 'd_Prime_PhoneNumber1_Type',
                        value: $('#sel-editCI-phoneType').val()
                    }
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

                            $('#modal-editCompanyInfo').modal('hide');
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

                            $('#spinner-btn-editCISave').attr('hidden', true);
                            $('#btn-editCISave').removeAttr('disabled');

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

                    $('#spinner-btn-editCISave').attr('hidden', true);
                    $('#btn-editCISave').removeAttr('disabled');

                    window.location.reload();
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

        $('#sel-editCI-phoneType').select2({ // SEL STATE
            placeholder: {id: '', text: 'Select'},
            dropdownParent: $("#modal-editCompanyInfo"),
            minimumResultsForSearch: Infinity
        });

        $('#sel-editCI-state').select2({ // SEL STATE
            placeholder: {id: '', text: 'Select'},
            dropdownParent: $("#modal-editCompanyInfo")
        });

        $('#sel-editCI-country').select2({ // SEL COUNTRY
            placeholder: {id: '', text: 'Select'},
            dropdownParent: $("#modal-editCompanyInfo"),
            minimumResultsForSearch: Infinity
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
            $('#modal-editCompanyInfo').modal('hide');
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
