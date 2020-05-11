// init input for phone with code and flag
$("#telephone").intlTelInput({
    initialCountry:"BD",
    separateDialCode: true
});
//$('#iti-0__item-bd').find('.iti__dial-code').text('+88');
//$('.iti__selected-dial-code').text('+88');

//project selection action
$(document).on('click','.project-item',function(){
    var check_status = $(this).find('.project-item-check').val();
    if(check_status == '0'){
        $(this).find('.project-item-check').val('1');
        $(this).addClass('project_added');
    }
    else{
        $(this).find('.project-item-check').val('0');
        $(this).removeClass('project_added');
    }
});