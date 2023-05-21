<!--MODAL FADE-->
<div class="modal fade" id="modal-editCompanyShipping" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- MODAL HEADER -->
            <div class="modal-header">
                <!--MODAL TITLE-->
                <h5 class="modal-title" id="staticBackdropLabel">Edit Shipping Address</h5>
                <button type="button" class="btn-close closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- MODAL BODY -->
            <div class="modal-body">
                <div class="row">
                    <!-- TXT-LINE 1 -->
                    <div class="col-12 col-md-6 col-lg-6">
                        <label for="txt-editSHA-addressLine1"><strong>Address line 1</strong></label>
                        <input id="txt-editSHA-addressLine1" type="text" class="form-control required" value="{{$company['shipping']['address']['line1']}}" msg="editSHAAddressLine1" />
                        <p id="editSHAAddressLine1" class="text-end text-danger"></p>
                    </div>
                    <!-- TXT-LINE 2 -->
                    <div class="col-12 col-md-6 col-lg-6">
                        <label for="txt-editSHA-addressLine2"><strong>Address line 2</strong></label>
                        <input id="txt-editSHA-addressLine2" type="text" class="form-control" value="{{$company['shipping']['address']['line2']}}" msg="editSHAAddressLine2" />
                        <p id="editSHAAddressLine2" class="text-end text-danger"></p>
                    </div>
                    <!-- TXT ZIP -->
                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="txt-editSHA-zip"><strong>Zip</strong></label>
                        <input id="txt-editSHA-zip" type="text" class="form-control required zip" value="{{$company['shipping']['address']['zip']}}" msg="editSHAZip" maxlength="5" />
                        <p id="editSHAZip" class="text-end text-danger"></p>
                    </div>
                    <!-- TXT CITY -->
                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="txt-editSHA-city"><strong>City</strong></label>
                        <input id="txt-editSHA-city" type="text" class="form-control required city" value="{{$company['shipping']['address']['city']}}" msg="editSHACity" />
                        <p id="editSHACity" class="text-end text-danger"></p>
                    </div>
                    <!-- SEL STATE -->
                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="sel-editSHA-state"><strong>State</strong></label>
                        <select id="sel-editSHA-state" class="form-control required state" style="width: 100%" msg="editSHAState">
                            <option class="" value=""></option>
                            <option <?php if($company['shipping']['address']['state'] == 'AL')echo 'selected';?> value="AL">Alabama</option>
                            <option <?php if($company['shipping']['address']['state'] == 'AK')echo 'selected';?> value="AK">Alaska</option>
                            <option <?php if($company['shipping']['address']['state'] == 'AZ')echo 'selected';?> value="AZ">Arizona</option>
                            <option <?php if($company['shipping']['address']['state'] == 'AR')echo 'selected';?> value="AR">Arkansas</option>
                            <option <?php if($company['shipping']['address']['state'] == 'CA')echo 'selected';?> value="CA">California</option>
                            <option <?php if($company['shipping']['address']['state'] == 'CO')echo 'selected';?> value="CO">Colorado</option>
                            <option <?php if($company['shipping']['address']['state'] == 'CT')echo 'selected';?> value="CT">Connecticut</option>
                            <option <?php if($company['shipping']['address']['state'] == 'DE')echo 'selected';?> value="DE">Delaware</option>
                            <option <?php if($company['shipping']['address']['state'] == 'DC')echo 'selected';?> value="DC">District Of Columbia</option>
                            <option <?php if($company['shipping']['address']['state'] == 'FL')echo 'selected';?> value="FL">Florida</option>
                            <option <?php if($company['shipping']['address']['state'] == 'GA')echo 'selected';?> value="GA">Georgia</option>
                            <option <?php if($company['shipping']['address']['state'] == 'HI')echo 'selected';?> value="HI">Hawaii</option>
                            <option <?php if($company['shipping']['address']['state'] == 'ID')echo 'selected';?> value="ID">Idaho</option>
                            <option <?php if($company['shipping']['address']['state'] == 'IL')echo 'selected';?> value="IL">Illinois</option>
                            <option <?php if($company['shipping']['address']['state'] == 'IN')echo 'selected';?> value="IN">Indiana</option>
                            <option <?php if($company['shipping']['address']['state'] == 'IA')echo 'selected';?> value="IA">Iowa</option>
                            <option <?php if($company['shipping']['address']['state'] == 'KS')echo 'selected';?> value="KS">Kansas</option>
                            <option <?php if($company['shipping']['address']['state'] == 'KY')echo 'selected';?> value="KY">Kentucky</option>
                            <option <?php if($company['shipping']['address']['state'] == 'LA')echo 'selected';?> value="LA">Louisiana</option>
                            <option <?php if($company['shipping']['address']['state'] == 'ME')echo 'selected';?> value="ME">Maine</option>
                            <option <?php if($company['shipping']['address']['state'] == 'MD')echo 'selected';?> value="MD">Maryland</option>
                            <option <?php if($company['shipping']['address']['state'] == 'MA')echo 'selected';?> value="MA">Massachusetts</option>
                            <option <?php if($company['shipping']['address']['state'] == 'MI')echo 'selected';?> value="MI">Michigan</option>
                            <option <?php if($company['shipping']['address']['state'] == 'MN')echo 'selected';?> value="MN">Minnesota</option>
                            <option <?php if($company['shipping']['address']['state'] == 'MS')echo 'selected';?> value="MS">Mississippi</option>
                            <option <?php if($company['shipping']['address']['state'] == 'MO')echo 'selected';?> value="MO">Missouri</option>
                            <option <?php if($company['shipping']['address']['state'] == 'MT')echo 'selected';?> value="MT">Montana</option>
                            <option <?php if($company['shipping']['address']['state'] == 'NE')echo 'selected';?> value="NE">Nebraska</option>
                            <option <?php if($company['shipping']['address']['state'] == 'NV')echo 'selected';?> value="NV">Nevada</option>
                            <option <?php if($company['shipping']['address']['state'] == 'NH')echo 'selected';?> value="NH">New Hampshire</option>
                            <option <?php if($company['shipping']['address']['state'] == 'NJ')echo 'selected';?> value="NJ">New Jersey</option>
                            <option <?php if($company['shipping']['address']['state'] == 'NM')echo 'selected';?> value="NM">New Mexico</option>
                            <option <?php if($company['shipping']['address']['state'] == 'NY')echo 'selected';?> value="NY">New York</option>
                            <option <?php if($company['shipping']['address']['state'] == 'NC')echo 'selected';?> value="NC">North Carolina</option>
                            <option <?php if($company['shipping']['address']['state'] == 'ND')echo 'selected';?> value="ND">North Dakota</option>
                            <option <?php if($company['shipping']['address']['state'] == 'OH')echo 'selected';?> value="OH">Ohio</option>
                            <option <?php if($company['shipping']['address']['state'] == 'OK')echo 'selected';?> value="OK">Oklahoma</option>
                            <option <?php if($company['shipping']['address']['state'] == 'OR')echo 'selected';?> value="OR">Oregon</option>
                            <option <?php if($company['shipping']['address']['state'] == 'PA')echo 'selected';?> value="PA">Pennsylvania</option>
                            <option <?php if($company['shipping']['address']['state'] == 'RI')echo 'selected';?> value="RI">Rhode Island</option>
                            <option <?php if($company['shipping']['address']['state'] == 'SC')echo 'selected';?> value="SC">South Carolina</option>
                            <option <?php if($company['shipping']['address']['state'] == 'SD')echo 'selected';?> value="SD">South Dakota</option>
                            <option <?php if($company['shipping']['address']['state'] == 'TN')echo 'selected';?> value="TN">Tennessee</option>
                            <option <?php if($company['shipping']['address']['state'] == 'TX')echo 'selected';?> value="TX">Texas</option>
                            <option <?php if($company['shipping']['address']['state'] == 'UT')echo 'selected';?> value="UT">Utah</option>
                            <option <?php if($company['shipping']['address']['state'] == 'VT')echo 'selected';?> value="VT">Vermont</option>
                            <option <?php if($company['shipping']['address']['state'] == 'VA')echo 'selected';?> value="VA">Virginia</option>
                            <option <?php if($company['shipping']['address']['state'] == 'WA')echo 'selected';?> value="WA">Washington</option>
                            <option <?php if($company['shipping']['address']['state'] == 'WV')echo 'selected';?> value="WV">West Virginia</option>
                            <option <?php if($company['shipping']['address']['state'] == 'WI')echo 'selected';?> value="WI">Wisconsin</option>
                            <option <?php if($company['shipping']['address']['state'] == 'WY')echo 'selected';?> value="WY">Wyoming</option>
                        </select>
                        <p id="editSHAState" class="text-end text-danger"></p>
                    </div>
                    <!-- SEL COUNTRY -->
                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="sel-editSHA-country"><strong>Country</strong></label>
                        <select id="sel-editSHA-country" class="form-control required" style="width: 100%" msg="editSHACountry">
                            <option value=""></option>
                            <option <?php if($company['shipping']['address']['country'] == 'US')echo 'selected';?> value="US">United States</option>
                        </select>
                        <p id="editSHACountry" class="text-end text-danger"></p>
                    </div>
                </div>
            </div>
            <!-- MODAL FOOTER -->
            <div class="modal-footer mt-10">
                <button id="btn-editSHAClose" type="button" class="btn btn-secondary closeModal" data-bs-dismiss="modal">Close</button>
                <button id="btn-editSHASave" type="button" class="btn btn-primary">
                    <span id="spinner-btn-editSHASave" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
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

        $('#modal-editCompanyShipping').modal('show');

        $('#btn-editSHASave').on('click', function () {

            let formRequiredValues = requiredValues();
            let formPhoneValidation = phoneFormatValidation();

            if(formRequiredValues == 0 && formPhoneValidation == 0) {

                $('#btn-editSHASave').attr('disabled', true);
                $('#spinner-btn-editSHASave').removeAttr('hidden');

                let post = {
                    companyRecordID: "{{$company['recordID']}}",
                    shippingLine1: {
                        field: 'd_Shipping_Address1',
                        value: $('#txt-editSHA-addressLine1').val()
                    },
                    shippingLine2: {
                        field: 'd_Shipping_Address2',
                        value: $('#txt-editSHA-addressLine2').val()
                    },
                    shippingZip: {
                        field: 'd_Shipping_Address_Zip',
                        value: $('#txt-editSHA-zip').val()
                    },
                    shippingCity: {
                        field: 'd_Shipping_Address_City',
                        value: $('#txt-editSHA-city').val()
                    },
                    shippingState: {
                        field: 'd_Shipping_Address_State',
                        value: $('#sel-editSHA-state').val()
                    },
                    shippingCountry: {
                        field: 'd_Shipping_Country',
                        value: $('#sel-editSHA-country').val()
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

                            $('#spinner-btn-editSHASave').attr('hidden', true);
                            $('#btn-editSHASave').removeAttr('disabled');

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

                    $('#spinner-btn-editSHASave').attr('hidden', true);
                    $('#btn-editSHASave').removeAttr('disabled');

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

        $('#sel-editSHA-state').select2({ // SEL STATE

            placeholder: {
                id: '',
                text: 'Select'
            },
            dropdownParent: $("#modal-editCompanyShipping")

        });

        $('#sel-editSHA-country').select2({ // SEL COUNTRY

            placeholder: {
                id: '',
                text: 'Select'
            },

            dropdownParent: $("#modal-editCompanyShipping"),
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
            $('#modal-editCompanyShipping').modal('show');
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
