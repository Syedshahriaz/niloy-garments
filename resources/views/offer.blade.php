<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- BEGIN Favicon -->
    <link rel="shortcut icon" href="{{asset('assets/global/img/icons/favicon.ico')}}" type="image/x-icon">
    <!-- END Favicon -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"/>
    <link rel="stylesheet" href="{{asset('assets/promotion/assets/css/promotion.css')}}">
    <title>Offer</title>
</head>

<body>
<div class="prmotion-header">
    <a href="https://vujadetec.com/" target="_blank" data-name="dashboard" data-item="1">
        <img src="https://vujadetec.net/assets/layouts/layout/img/logoVujade.jpg" alt="Vujadetec logo" class="logo-default">
    </a>
    <a href="{{ route('logout') }}"  class="logout btn btn-danger" >Logout</a>
</div>

<div class="container">
    <div class="row">
        <div class="col" style="margin-top:25px;">
            <div class="offer-option mb-5">

                <form id="offer_form" class="login-form" action="{{url('save_offer')}}" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}">
                    <input type="hidden" name="age" id="age" value="0">

                    <div class="">
                        <div class="row">
                            <div class="col-md-8 offset-2">
                                <div class="form-group offer-item">
                                    <h5 class="text-center mb-3">Gender of vaccine</h5>
                                    <div class="row mb-4">
                                        <div class="col-md-4 offset-4 form-group">
                                            <select name="gender" id="gender" class="form-control">
                                                <option value="">Select Gender</option>
                                                <option value="Male">Male</option></option></option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>

                                    <h5 class="text-center mb-4">Date of birth for vaccine</h5>
                                    {{--<input class="form-control date-picker" size="16" type="text" name="" id="shipment_date" value="" placeholder="Select Shipping Date"/>
                                    --}}
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <select name="day" id="day" class="form-control">
                                                <option disabled="true" value="">Day</option>
                                                @for($i=1; $i<=31; $i++)
                                                    <option value="{{$i}}" @if($i==date('d')) selected @endif>{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <select name="month" id="month" class="form-control">
                                                <option disabled="true" value="">Month</option>
                                                <option value="1" @if(date('m')==1) selected @endif>Jan</option>
                                                <option value="2" @if(date('m')==2) selected @endif>Feb</option>
                                                <option value="3" @if(date('m')==3) selected @endif>Mar</option>
                                                <option value="4" @if(date('m')==4) selected @endif>Apr</option>
                                                <option value="5" @if(date('m')==5) selected @endif>May</option>
                                                <option value="6" @if(date('m')==6) selected @endif>Jun</option>
                                                <option value="7" @if(date('m')==7) selected @endif>Jul</option>
                                                <option value="8" @if(date('m')==8) selected @endif>Aug</option>
                                                <option value="9" @if(date('m')==9) selected @endif>Sep</option>
                                                <option value="10" @if(date('m')==10) selected @endif>Oct</option>
                                                <option value="11" @if(date('m')==11) selected @endif>Nov</option>
                                                <option value="12" @if(date('m')==12) selected @endif>Dec</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <select name="year" id="year" class="form-control">
                                                <option disabled="true" value="">Year</option>
                                                @for($i=date('Y'); $i>=1920; $i--)
                                                    <option value="{{$i}}" @if($i==date('Y')) selected @endif>{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>

                                    <input class="date-picker-hidden" type="hidden" name="shipment_date" id="shipment_date" value="{{date('Y-m-d')}}"/>
                                </div>

                                <div class="d-none" id="question_area">
                                    <div class="offer-item">
                                        <h5 class="text-center mb-3">Do you take vaccine regularly?</h5>
                                        <div class="row">
                                            <div class="col-md-4 offset-4 form-group text-center mb-0">
                                                <label class="radio-inline mr-3">
                                                    <input class="question_radio" type="radio" name="regular_vaccine" id="regular_vaccine_yes" value="1"> Yes
                                                </label>
                                                <label class="radio-inline">
                                                    <input class="question_radio" type="radio" name="regular_vaccine" id="regular_vaccine_no" value="0"> No
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="offer-item">
                                        <h5 class="text-center mb-3">Did you miss any vaccine?</h5>
                                        <div class="row">
                                            <div class="col-md-4 offset-4 form-group text-center mb-0">
                                                <label class="radio-inline mr-3">
                                                    <input class="question_radio" type="radio" name="miss_vaccine" id="miss_vaccine_yes" value="1"> Yes
                                                </label>
                                                <label class="radio-inline">
                                                    <input class="question_radio" type="radio" name="miss_vaccine" id="miss_vaccine_no" value="0"> No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <h2 class="text-center mt-3 mb-4">{{--Choose your offer--}}</h2>

                    <div class="form-group">
                        <div class="offer-itemlist">
                            <div class="offer-option-item green-offer-option active_offer_option selected-offer">
                                <p>{{$offer->offer1_name}}</p>
                                <input type="radio" name="offer" value="1" hidden="" checked >
                            </div>
                            <div class="offer-option-item red-offer-option active_offer_option">
                                <p>{{$offer->offer2_name}}</p>
                                <input type="radio" name="offer" value="2" hidden="">
                            </div>
                            <div class="offer-option-item pink-offer-option">
                                <p>{{$offer->offer3_name}}</p>
                                <input type="radio" name="offer_3" value="3" disabled="" hidden="">
                            </div>
                        </div>
                        <p class="text-center mt-3">Pink is free for female if any female buy green or red offer. </p>

                        <div class="text-center">
                            <button type="button" class="btn btn-primary" id="offer_submit_btn">Submit</button>
                        </div>
                    </div>
                </form>
            </div>


            <span style="font-weight: bold;background-color:black; color:white;">&nbsp;Vujade<span style="font-weight: bold;color:#bf945b;">tec&nbsp;</span></span> has 3 offers <span style="font-weight: bold;color:#599a13;">&nbsp;Green&nbsp;</span>-<span style="font-weight: bold;color:#d61919;">&nbsp;<b>Red&nbsp;</b></span>-<span style="font-weight: bold;color:#fc0aa6;">&nbsp;Pink&nbsp;</span> which cover all ages, all gender including pregnant women. Pink offer are related to females and completely FREE if you buy Green or Red.
            <br><br>
            It is for those:
            <ul>
                <li>Who are taking regular vaccines. </li>
                <li>Who missed the vaccine.</li>
                <li>Who does not know or remember what vaccine was given during childhood.</li>
            </ul>
            <div class="Offer-info mt-5">
                <div class="offer-item green-offer animate__animated animate__fadeInLeft">
                    <h3>{{$offer->offer1_name}}</h3>
                    <p><?php echo htmlspecialchars_decode($offer->offer1_details); ?></p>
                </div>

                <div class="offer-item red-offer  animate__animated animate__fadeInRight">
                    <h3>{{$offer->offer2_name}}</h3>
                    <p><?php echo htmlspecialchars_decode($offer->offer2_details); ?></p>
                </div>

                <div class="offer-item pink-offer animate__animated animate__fadeInLeft">
                    <h3>{{$offer->offer3_name}}</h3>
                    <p><?php echo htmlspecialchars_decode($offer->offer3_details); ?></p>
                </div>

                <div>
                    <p>So, please register to know more about vaccines of all ages &amp; buy vaccine-care tracker only ৳0 for Bangladesh &amp; $0 for other countries per person for the next 2 years. You can extend it up to a whole lifetime if you are happy with our service.</p>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- alert message START -->
<div class="modal fade alert global-warning" role="dialog" id="alert-modal" style="z-index: 99999">
    <div class="modal-dialog modal-sm modal-dialog-centered">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body text-center">
                <div id="alert-error-msg">
                    <i class="fa fa-exclamation-triangle fa-3x text-danger"></i> <br>  <br>
                    <p class="text-danger"></p>
                </div>

                <div id="alert-success-msg">
                    <i class="fa fa-check-circle text-success fa-3x"></i>
                    <p class="text-success"></p>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal" id="alert-ok">ok</button>
            </div>
        </div>

    </div>
</div>
<!-- alert message End -->



<div class="page-footer">
    <div class="page-footer-inner text-center w-100"> © All rights reserved to <a target="_blank" href="https://vujadetec.com/"><strong>vujadetec</strong></a></div>
</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<script>
    function show_success_message($message){
        $('#alert-modal').modal('show');
        $('#alert-error-msg').hide();
        $('#alert-success-msg').show();
        $('#alert-success-msg p').html($message);
    }
    function show_error_message(message){
        $('#alert-modal').modal('show');
        $('#alert-error-msg').show();
        $('#alert-success-msg').hide();
        $('#alert-error-msg p').html(message);
    }

   /* $(document).on('click','.offer-option-item',function(){
        $('.offer-option-item').removeClass('selected-offer')
        $(this).addClass('selected-offer');
        $(this).children('input[type="radio"]').prop('checked',true);
    });*/

    $(document).on('change','#day, #month, #year',function(){
        var day = $('#day').val();
        var month = $('#month').val();
        var year = $('#year').val();
        var date = year+'-'+month+'-'+day;

        var start = new Date(date);
        var end   = new Date();
        var diff  = new Date(end - start);
        var years  = diff/1000/60/60/24/365;

        if(years>=2){
            $('#question_area').removeClass('d-none');
        }
        else{
            $('#question_area').addClass('d-none');
        }
        $('#age').val(years);
    });

    $(document).on('click','#offer_submit_btn', function(event){
        event.preventDefault();

        $('#offer_submit_btn').prop('disabled',true);

        //show_loader();

        var gender = $("#gender").val();
        var shipment_date = $("#shipment_date").val();
        var day = $('#day').val();
        var month = $('#month').val();
        var year = $('#year').val();
        var age = $('#age').val();

        var validate = "";

        if (gender.trim() == "") {
            validate = validate + "Gender is required</br>";
        }
        if (shipment_date.trim() == "") {
            validate = validate + "Birth date is required</br>";
        }
        if (shipment_date.trim() != "" && isFutureDate(shipment_date)) {
            validate = validate + "You can not select a future date</br>";
        }

        if (day.trim() == "" || month.trim() =='' || year.trim() =='') {
            validate = validate + "Birth date is required</br>";
        }

        if(age>=2){
            if (!$("input[name='regular_vaccine']:checked").val()) {
                validate = validate + "Please give answer of the question 1</br>";
            }

            if (!$("input[name='miss_vaccine']:checked").val()) {
                validate = validate + "Please give answer of the question 2</br>";
            }
        }

        if (validate == "") {
            $('#offer_form').submit();
        }
        else{
            $('#offer_submit_btn').prop('disabled',false);
            show_error_message(validate);
        }
    });

    /*
   * Reloading page on browser back and forth button click
   * */
    $(window).on('popstate', function(event) {
        window.location.reload();
    });


    //custom select
    for (const dropdown of document.querySelectorAll(".custom-select-wrapper")) {
        dropdown.addEventListener('click', function () {
            this.querySelector('.custom-select').classList.toggle('open');
        })
    }

    for (const option of document.querySelectorAll(".custom-option")) {
        option.addEventListener('click', function () {
            if (!this.classList.contains('selected')) {
                this.parentNode.querySelector('.custom-option.selected').classList.remove('selected');
                this.classList.add('selected');
                this.closest('.custom-select').querySelector('.custom-select__trigger span').textContent = this.textContent;

                var subscription_id = $(this).attr('data-id');
                var subscription_price = $(this).attr('data-price');
                $('#subscription_plan_id').val(subscription_id);
                if(subscription_id != ''){
                    $('#coupon_apply_button').prop('disabled',false);
                    $('#price_preview').removeClass('d-none');
                    $('#subscription_price').val(subscription_price);
                    $('.prev_cost').text(subscription_price);
                    $('.payable_cost').text(subscription_price);
                }
                else{
                    $('#subscription_price').val(0);
                    $('#coupon_apply_button').prop('disabled',true);
                    $('#price_preview').addClass('d-none');
                }
            }
        })
    }

    window.addEventListener('click', function (e) {
        for (const select of document.querySelectorAll('.custom-select')) {
            if (!select.contains(e.target)) {
                select.classList.remove('open');
            }
        }
    });

    //Auto select offer
    $('.question_radio').on('click',function(){
        var isRegular = $('input[name="regular_vaccine"]:checked').val();
        var isMissed = $('input[name="miss_vaccine"]:checked').val();
        if(isRegular == 1 && isMissed == 1){
            $('.offer-option-item ').each(function(){
                var filtered_offer =$(this).children('input[name="offer"]').val();
                if(filtered_offer == 1){
                    $(this).children('input[name="offer"]').prop('checked', true);
                    $('.offer-option-item').removeClass('selected-offer');
                    $(this).addClass('selected-offer');
                    //alert($(this).children('input[name="offer"]:checked').val());
                }
            });
        }
        else{
            $('.offer-option-item ').each(function(){
                var filtered_offer =$(this).children('input[name="offer"]').val();
                if(filtered_offer == 2){
                    $(this).children('input[name="offer"]').prop('checked', true);
                    $('.offer-option-item').removeClass('selected-offer');
                    $(this).addClass('selected-offer');
                    //alert($(this).children('input[name="offer"]:checked').val());
                }
            });
        }
    });

</script>

@include('partials.js.user.common_js')
</body>

</html>
