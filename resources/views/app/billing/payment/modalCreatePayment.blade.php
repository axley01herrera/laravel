<!--MODAL FADE-->
<div class="modal fade" id="modal-payment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- MODAL HEADER -->
            <div class="modal-header">
                <!--MODAL TITLE-->
                <h5 class="modal-title" id="staticBackdropLabel">Create Payment</h5>
                <button type="button" class="btn-close closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- MODAL BODY -->
            <div class="modal-body">
                <div class="row">

                    <!-- TXT CARD HOLDER NAME -->
                    <div class="col-12 col-md-6 col-lg-6">
                        <label for="txt-holderName"><strong>Card Holder Name</strong></label>
                        <input type="text" id="txt-holderName" class="form-control required" msg="holderName" />
                        <p id="holderName" class="text-end text-danger"></p>
                    </div>

                    <!-- SEL CARD TYPE -->
                    <div class="col-12 col-md-6 col-lg-6">
                        <label for="sel-card"><strong>Card Type</strong></label>
                        <select id="sel-card" class="form-control required" style="width: 100%" msg="cardType" >
                            <option value=""></option>
                        </select>
                        <p id="cardType" class="text-end text-danger"></p>
                    </div>

                    <!-- TXT CARD NUMBER -->
                    <div class="col-12 col-md-6 col-lg-6">
                        <label for="txt-cardNumber"><strong>Card Number</strong></label>
                        <input type="text" id="txt-cardNumber" class="form-control required number disabled" msg="cardNumber" disabled />
                        <p id="cardNumber" class="text-end text-danger"></p>
                    </div>

                    <!-- TXT EXPIRATION DATE -->
                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="txt-expDate"><strong>Expiration Date</strong></label>
                        <input type="text" id="txt-expDate" class="form-control required number disabled" msg="expDate" disabled />
                        <p id="expDate" class="text-end text-danger"></p>
                    </div>

                    <!-- TXT CVV -->
                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="txt-cvv"><strong>CVV</strong></label>
                        <input type="text" id="txt-cvv" class="form-control required number disabled" msg="cvv" disabled />
                        <p id="cvv" class="text-end text-danger"></p>
                    </div>

                    <!-- TXT-LINE 1 -->
                    <div class="col-12 col-md-6 col-lg-6">
                        <label for="txt-line1"><strong>Address line 1</strong></label>
                        <input id="txt-line1" type="text" class="form-control required" msg="line1" />
                        <p id="line1" class="text-end text-danger"></p>
                    </div>
                    <!-- TXT-LINE 2 -->
                    <div class="col-12 col-md-6 col-lg-6">
                        <label for="txt-line2"><strong>Address line 2</strong></label>
                        <input id="txt-line2" type="text" class="form-control" msg="line2" />
                        <p id="line2" class="text-end text-danger"></p>
                    </div>
                    <!-- TXT ZIP -->
                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="txt-zip"><strong>Zip</strong></label>
                        <input id="txt-zip" type="text" class="form-control required zip" msg="zip" maxlength="5" />
                        <p id="zip" class="text-end text-danger"></p>
                    </div>
                    <!-- TXT CITY -->
                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="txt-city"><strong>City</strong></label>
                        <input id="txt-city" type="text" class="form-control required city" msg="city" />
                        <p id="city" class="text-end text-danger"></p>
                    </div>
                    <!-- SEL STATE -->
                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="sel-state"><strong>State</strong></label>
                        <select id="sel-state" class="form-control required state" style="width: 100%" msg="state">
                            <option class="" value=""></option>
                            <option value="AL">Alabama</option>
                            <option value="AK">Alaska</option>
                            <option value="AZ">Arizona</option>
                            <option value="AR">Arkansas</option>
                            <option value="CA">California</option>
                            <option value="CO">Colorado</option>
                            <option value="CT">Connecticut</option>
                            <option value="DE">Delaware</option>
                            <option value="DC">District Of Columbia</option>
                            <option value="FL">Florida</option>
                            <option value="GA">Georgia</option>
                            <option value="HI">Hawaii</option>
                            <option value="ID">Idaho</option>
                            <option value="IL">Illinois</option>
                            <option value="IN">Indiana</option>
                            <option value="IA">Iowa</option>
                            <option value="KS">Kansas</option>
                            <option value="KY">Kentucky</option>
                            <option value="LA">Louisiana</option>
                            <option value="ME">Maine</option>
                            <option value="MD">Maryland</option>
                            <option value="MA">Massachusetts</option>
                            <option value="MI">Michigan</option>
                            <option value="MN">Minnesota</option>
                            <option value="MS">Mississippi</option>
                            <option value="MO">Missouri</option>
                            <option value="MT">Montana</option>
                            <option value="NE">Nebraska</option>
                            <option value="NV">Nevada</option>
                            <option value="NH">New Hampshire</option>
                            <option value="NJ">New Jersey</option>
                            <option value="NM">New Mexico</option>
                            <option value="NY">New York</option>
                            <option value="NC">North Carolina</option>
                            <option value="ND">North Dakota</option>
                            <option value="OH">Ohio</option>
                            <option value="OK">Oklahoma</option>
                            <option value="OR">Oregon</option>
                            <option value="PA">Pennsylvania</option>
                            <option value="RI">Rhode Island</option>
                            <option value="SC">South Carolina</option>
                            <option value="SD">South Dakota</option>
                            <option value="TN">Tennessee</option>
                            <option value="TX">Texas</option>
                            <option value="UT">Utah</option>
                            <option value="VT">Vermont</option>
                            <option value="VA">Virginia</option>
                            <option value="WA">Washington</option>
                            <option value="WV">West Virginia</option>
                            <option value="WI">Wisconsin</option>
                            <option value="WY">Wyoming</option>
                        </select>
                        <p id="state" class="text-end text-danger"></p>
                    </div>
                    <!-- SEL COUNTRY -->
                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="sel-country"><strong>Country</strong></label>
                        <select id="sel-country" class="form-control required" style="width: 100%" msg="country">
                            <option value=""></option>
                            <option selected value="US">United States</option>
                        </select>
                        <p id="country" class="text-end text-danger"></p>
                    </div>
                </div>
            </div>
            <!-- MODAL FOOTER -->
            <div class="modal-footer mt-10">
                <button id="btn-close" type="button" class="btn btn-secondary closeModal" data-bs-dismiss="modal">Close</button>
                <button id="btn-submit" type="button" class="btn btn-primary">
                    <span id="spinner-btn-submit" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" hidden></span>
                    Submit
                </button>
            </div>
        </div>
    </div>
</div>
<script src="assets/customFunction/mask.js"></script>
<script src="assets/customFunction/setCityAndState.js"></script>
<script>
    $(document).ready(function () {

        $('#modal-payment').modal('show');
        $('#txt-expDate').inputmask("99/9999");

        let callFrom = "{{ $callFrom }}";

        $('#btn-submit').on('click', function () { // SUBMIT

            let formRequiredValues = requiredValues();

            if(formRequiredValues === 0) {

                let formValidateCard = validateCard();

                if(formValidateCard == 0) {

                    $('#btn-submit').attr('disabled', true);
                    $('#spinner-btn-submit').removeAttr('hidden');

                    let cardID = $('#sel-card').val();
                    let cardType = '';

                    switch(cardID) {

                        case '1': // AMERICAN EXPRESS
                            cardType = "American Express"
                        break

                        case '2': // DISCOVERY CARD
                            cardType = "Discovery Card"
                        break

                        case '3': // DINERS
                            cardType = "Diners"
                        break

                        case '4': // MASTER CARD
                            cardType = "Master Card"
                        break

                        case '5': // VISA
                            cardType = "Visa"
                        break
                    }

                    let expDate = $('#txt-expDate').val().replace('_', '');
                    let inputMonth = expDate.substr(0, 2);
                    let inputYear = expDate.substr(3, 7);

                    let post = {
                        holderName: $('#txt-holderName').val(),
                        cardType: cardType,
                        number: $('#txt-cardNumber').val(),
                        expMont: inputMonth,
                        expYear: inputYear,
                        cvv: $('#txt-cvv').val(),
                        line1: $('#txt-line1').val(),
                        line2: $('#txt-line2').val(),
                        zip: $('#txt-zip').val(),
                        city: $('#txt-city').val(),
                        state: $('#sel-state').val(),
                        country: $('#sel-country').val()
                    }

                    $.ajax({

                        type: "post",
                        url: "{{ route('saveCard') }}",
                        data: {post},
                        dataType: "json",

                    }).done(function(jsonResponse) {

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

                                $('#modal-payment').modal('hide');
                                $('#main-modal').html('');

                                if(callFrom == 'mainPayment') $('#link-payments').trigger('click');
                                if(callFrom == 'dashboard') getDefaultPaymentMethod();
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
                            break
                        }

                        $('#btn-submit').removeAttr('disabled');
                        $('#spinner-btn-submit').attr('hidden', true);

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

                        $('#btn-submit').removeAttr('disabled');
                        $('#spinner-btn-submit').attr('hidden', true);

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

            } else { // ERROR REQUIRED FIELDS

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

        let selCard = "{{ $selCard }}";
        let dataSelCard = JSON.parse(selCard.replace(/&quot;/g,'"'));

        $('#sel-card').select2({ // SEL CARD

            placeholder: {id: '', text: 'Select'},
            dropdownParent: $("#modal-payment"),
            data: dataSelCard,
            templateResult: formatRepoSelCard,
            minimumResultsForSearch: Infinity

        }).on('change', function() {

            let cardID = $(this).val();

            switch(cardID) {

                case '1': // AMERICAN EXPRESS
                    $('#txt-cardNumber').inputmask("9999 999999 99999");
                    $('#txt-cvv').inputmask("9999");
                break

                case '2': // DISCOVERY CARD
                    $('#txt-cardNumber').inputmask("9999 9999 9999 9999");
                    $('#txt-cvv').inputmask("999");
                break

                case '3': // DINERS
                    $('#txt-cardNumber').inputmask("9999 999999 99999");
                    $('#txt-cvv').inputmask("999");
                break

                case '4': // MASTER CARD
                    $('#txt-cardNumber').inputmask("9999 9999 9999 9999");
                    $('#txt-cvv').inputmask("999");
                break

                case '5': // VISA
                    $('#txt-cardNumber').inputmask("9999 9999 9999 9999");
                    $('#txt-cvv').inputmask("999");
                break
            }

            $('.disabled').each(function() {

                $(this).removeAttr('disabled');

            });
        });

        function formatRepoSelCard (card) {

            if (!card.id)
                return card.text;

            let baseUrl = "assets/images/creditcard";
            let $card = $('<span><img width="25px" src="' + baseUrl + '/' + card.element.value.toLowerCase() + '.png" class="img-flag" /> ' + card.text + '</span>');

            return $card;
        };

        $('#sel-state').select2({ // SEL STATE

            placeholder: {
                id: '',
                text: 'Select'
            },
            dropdownParent: $("#modal-payment")

        });

        $('#sel-country').select2({ // SEL COUNTRY

            placeholder: {
                id: '',
                text: 'Select'
            },

            dropdownParent: $("#modal-payment"),
            minimumResultsForSearch: Infinity
        });

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

            $('#modal-payment').modal('hide');
            $('#main-modal').html('');

        });

        function validateCard() {

            let cardID = $('#sel-card').val();
            let cardNumber = $('#txt-cardNumber').val().replace('_', '');
            let cardNumberInitial = cardNumber.substr(0, 1);
            let expDate = $('#txt-expDate').val().replace('_', '');
            let inputMonth = expDate.substr(0, 2);
            let inputYear = expDate.substr(3, 7);
            let cvv = $('#txt-cvv').val().replace('_', '');

            let newDate = new Date();
            let currentMonth = newDate.getMonth() + 1;
            let currentYear = newDate.getFullYear();

            let msg = '';

            let resultValidationCardNumber = 0;
            let resultValidationExpDate = 0;
            let resultValidationCVV = 0;

            let formValidateExpDate = validateInputDateExp(currentMonth, currentYear, inputMonth, inputYear);

            if(Number(expDate.length) != 7 || Number(formValidateExpDate) == 1) { // EXP DATE

                $('#txt-expDate').addClass('is-invalid');
                msg = $('#txt-expDate').attr('msg');
                $('#' + msg).html('Invalid Exp Date');

                resultValidationExpDate = 1;
            }

            switch(cardID) {

                case '1': // AMERICAN EXPRESS

                    if(Number(cardNumber.length) != 17 || Number(cardNumberInitial) != 3) { // CARD NUMBER

                        $('#txt-cardNumber').addClass('is-invalid');
                        msg = $('#txt-cardNumber').attr('msg');
                        $('#' + msg).html('Invalid Card Number');

                        resultValidationCardNumber = 1;
                    }

                    if(Number(cvv.length != 4)) { // CVV

                        $('#txt-cvv').addClass('is-invalid');
                        msg = $('#txt-cvv').attr('msg');
                        $('#' + msg).html('Invalid CVV');

                        resultValidationCVV = 1;
                    }

                break

                case '2': // DISCOVERY CARD
                    if(Number(cardNumber.length) != 19 || Number(cardNumberInitial) != 6) { // CARD NUMBER

                        $('#txt-cardNumber').addClass('is-invalid');
                        msg = $('#txt-cardNumber').attr('msg');
                        $('#' + msg).html('Invalid Card Number');

                        resultValidationCardNumber = 1;
                    }

                    if(Number(cvv.length != 3)) { // CVV

                        $('#txt-cvv').addClass('is-invalid');
                        msg = $('#txt-cvv').attr('msg');
                        $('#' + msg).html('Invalid CVV');

                        resultValidationCVV = 1;
                    }
                break

                case '3': // DINERS
                    if(Number(cardNumber.length) != 17 || Number(cardNumberInitial) != 3) { // CARD NUMBER

                        $('#txt-cardNumber').addClass('is-invalid');
                        msg = $('#txt-cardNumber').attr('msg');
                        $('#' + msg).html('Invalid Card Number');

                        resultValidationCardNumber = 1;
                    }

                    if(Number(cvv.length != 3)) { // CVV

                        $('#txt-cvv').addClass('is-invalid');
                        msg = $('#txt-cvv').attr('msg');
                        $('#' + msg).html('Invalid CVV');

                        resultValidationCVV = 1;
                    }
                break

                case '4': // MASTER CARD
                    if(Number(cardNumber.length) != 19 || Number(cardNumberInitial) != 5) { // CARD NUMBER

                        $('#txt-cardNumber').addClass('is-invalid');
                        msg = $('#txt-cardNumber').attr('msg');
                        $('#' + msg).html('Invalid Card Number');

                        resultValidationCardNumber = 1;
                    }

                    if(Number(cvv.length != 3)) { // CVV

                        $('#txt-cvv').addClass('is-invalid');
                        msg = $('#txt-cvv').attr('msg');
                        $('#' + msg).html('Invalid CVV');

                        resultValidationCVV = 1;
                    }
                break

                case '5': // VISA

                    if(Number(cardNumber.length) != 19 || Number(cardNumberInitial) != 4) { // CARD NUMBER

                        $('#txt-cardNumber').addClass('is-invalid');
                        msg = $('#txt-cardNumber').attr('msg');
                        $('#' + msg).html('Invalid Card Number');

                        resultValidationCardNumber = 1;
                    }

                    if(Number(cvv.length != 3)) { // CVV

                        $('#txt-cvv').addClass('is-invalid');
                        msg = $('#txt-cvv').attr('msg');
                        $('#' + msg).html('Invalid CVV');

                        resultValidationCVV = 1;
                    }

                break
            }

            /* 1 = error, 0 = success*/

            if(resultValidationCardNumber == 0 && resultValidationExpDate == 0 && resultValidationCVV == 0) return 0; else return 1;

        }

        function validateInputDateExp(currentMonth, currentYear, inputMonth, inputYear) {

            /* 1 = error, 0 = success */
            let response = 1;

            if(currentYear <= inputYear){
                if(currentYear == inputYear){
                    if(currentMonth < inputMonth)
                        response = 0;
                }
                else
                    response = 0;
            }

            return response;
        }

        function getDefaultPaymentMethod() { // TO RELOAD CARD IN DASHBOARD

            $.ajax({

                type: "post",
                url: "{{ route('defaultPaymentMethod') }}",
                dataType: "html",

            }).done(function(htmlResponse) {

                $('#main-paymentMethod').html(htmlResponse);

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

            });

        }

    });
</script>
