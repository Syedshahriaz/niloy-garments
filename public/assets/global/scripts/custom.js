// init input for phone with code and flag
$("#telephone").intlTelInput({
    initialCountry:"BD",
    separateDialCode: true
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

//User task page
$('#vertical_view_btn').click(function(){
    $(this).removeClass('btn-outline');
    $('#horzon_view_btn').addClass('btn-outline');
    $('#user_horizontal_task').addClass('hidden');
    $('#user_vertical_task').removeClass('hidden');
});
$('#horzon_view_btn').click(function(){
    $(this).removeClass('btn-outline');
    $('#vertical_view_btn').addClass('btn-outline');
    $('#user_vertical_task').addClass('hidden');
    $('#user_horizontal_task').removeClass('hidden');
});
