function requiredValues() {

    let inputValue = '';
    let response = 0;
    let msg = '';

    $('.required').each(function() {

        inputValue = $(this).val();
        msg = $(this).attr('msg');

        if(inputValue === '') {

            $(this).addClass('is-invalid');
            response = 1;

            if(msg != '' && msg != undefined && msg != 'undefined') {

                $('#' + msg).html('Required');
            }

        } 
    });

    return response;
}

function requiredValuesOnKeyUP(inputID) {

    let inputValue = $('#' + inputID).val();

    if(inputValue === '')
        $('#' + inputID).addClass('is-invalid');
    else
        $('#' + inputID).removeClass('is-invalid');
}

function emailFormatValidation() {

    let inputValue = '';
    let response = 1;
    let validEmail =  /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
    let msg = '';
    
    $('.email').each(function() {

        inputValue = $(this).val();
        msg = $(this).attr('msg');

        if(validEmail.test(inputValue)) {

            $(this).removeClass('is-invalid');
            response = 0;

            if(msg != '' && msg != undefined && msg != 'undefined') 
                $('#' + msg).html('');
            
        } else {

            $(this).addClass('is-invalid');
            
            if(msg != '' && msg != undefined && msg != 'undefined') 
                $('#' + msg).html('Invalid');
        }
    });

    return response;
}

function phoneFormatValidation() {

    let response = 0;
    let value = '';
    let msg = '';

    $('.phone').each(function() {

        value = $(this).val();
        msg = $(this).attr('msg');

        if(value != '') {

            value = value.replace('_','');

            if(Number(value.length) != 14) {

                $(this).addClass('is-invalid');
                $('#' + msg).html('Invalid Phone.');
                response = 1;
            }
        }
    });

    return response;
}



