// init input for phone with code and flag
$(".telephone").intlTelInput({
    initialCountry:"BD",
    separateDialCode: true
    //dialCode: "+88",
});
//$('#iti-0__item-bd').find('.iti__dial-code').text('+88');
//$('.iti__selected-dial-code').text('+88');

//User registration show password
$('.show-password').click(function(){
    if($(this).is(":checked") == true){
        $(this).parents('form').find('.password-field').prop("type", "text");
    }
    else{
        $(this).parents('form').find('.password-field').prop("type", "password");
    }
});


//project selection action
$(document).on('click','.project-item .add_to_fav',function(){
    var check_status = $(this).parents('.project-item').find('.project-item-check').val();
    if(check_status == '0'){
        $(this).parents('.project-item').find('.project-item-check').val('1');
        $(this).parents('.project-item').addClass('project_added');
    }
    else{
        $(this).parents('.project-item').find('.project-item-check').val('0');
        $(this).parents('.project-item').removeClass('project_added');
    }
});

//Select shipment date modal
$(window).on('load',function(){
    $('#select_ship_date').modal('show');
});
$('#select_ship_date').on('show.bs.modal', function (e) {
    $('body').addClass('shipment_modal-open');
});
$('#select_ship_date').on('hidden.bs.modal', function (e) {
    $('body').removeClass('shipment_modal-open');
});

