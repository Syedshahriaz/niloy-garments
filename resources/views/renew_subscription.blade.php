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
    <title>Prmotion</title>
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
                <form id="payment_form" class="login-form" action="{{url('initiate_payment',$user->id)}}" method="get">
                    <input type="hidden" name="subscription_type" value="new">

                    <div class="mb-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <h4 class="mb-4 text-center">Select your subscription plan</h4>
                                    <div class="select-container">
                                        <div class="custom-select-wrapper">
                                            <div class="custom-select">
                                                <div class="custom-select__trigger"><span>Select</span>
                                                    <div class="arrow"></div>
                                                </div>
                                                <div class="custom-options">
                                                    <span class="custom-option selected" data-id="">Select</span>
                                                    @foreach($subscription_plans as $plan)
                                                        <span class="custom-option" data-id="{{$plan->id}}" data-price="{{$plan->offer_price}}">{{$plan->name}}</span>
                                                    @endforeach
                                                    <input type="hidden" name="subscription_plan_id" id="subscription_plan_id" value="">
                                                    <input type="hidden" name="currency" id="currency" value="{{$plan->currency}}">
                                                    <input type="hidden" name="subscription_price" id="subscription_price" value="">
                                                    <input type="hidden" name="coupon_id" id="coupon_id" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="promotion-address-field">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label visible-ie8 visible-ie9">Do you have promo?</label>
                                    <div class="input-group">
                                        <input class="form-control placeholder-no-fix" type="text" placeholder="Enter your promo code" name="promo" id="promo" />
                                        <span class="input-group-btn">
                                                <button class="btn btn-primary" type="button" id="coupon_apply_button" disabled>Apply</button>
                                            </span>
                                    </div><!-- /input-group -->

                                </div>
                            </div>

                            <div class="col-md-6 d-none" id="price_preview">
                                <p class="mb-0 mt-4">Your total cost is <strong><span class="slected_currensy">BDT</span> <span class="prev_cost">00.00</span></strong></p>
                                <p>After discount your total cost is BDT <strong><span class="slected_currensy">BDT</span> <span class="payable_cost">00.00</span></strong></p>
                            </div>
                        </div>
                    </div>

                    <buton type="button" class="btn btn-lg btn-success" id="payment_button">Submit</buton>
                </form>
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
{{--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>--}}
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
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

    $(document).on('click','.offer-option-item',function(){
        $('.offer-option-item').removeClass('selected-offer')
        $(this).addClass('selected-offer');
        $(this).children('input[type="radio"]').prop('checked',true);
    });

    $(document).on('click','#payment_button', function(event){
        event.preventDefault();

        var subscription_plan_id = $('#subscription_plan_id').val();
        var validate = '';

        if (subscription_plan_id.trim() == "") {
            validate = validate + "Subscription plan is required</br>";
        }

        if (validate == "") {
            $('#payment_form').submit();
        }
        else{
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
                $('#promo').val('');
                if(subscription_id != ''){
                    $('#coupon_apply_button').prop('disabled',false);
                    $('#price_preview').removeClass('d-none');
                    $('#subscription_price').val(subscription_price);
                    $('#coupon_id').val('');
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

    $(document).on('click','#coupon_apply_button',function(){
        var coupon = $('#promo').val();
        if(coupon.trim()==''){
            show_error_message('You did not enter any coupon code');
            return false;
        }

        var url = "{{ url('calculate_coupon_code') }}";
        $.ajax({
            type: "POST",
            url: url,
            data: {coupon:coupon,'_token':'{{ csrf_token() }}'},
            success: function (data) {
                if(data.status == 200){
                    var coupon_discount = data.coupon.discount;
                    var subscription_price = $('#subscription_price').val();
                    var discounted_amount = subscription_price*(coupon_discount/100);
                    var discounted_price = subscription_price-discounted_amount;
                    $('#subscription_price').val(discounted_price);
                    $('.payable_cost').text(discounted_price);
                    $('#coupon_id').val(data.coupon.id);
                    $('#coupon_apply_button').prop('disabled',true);
                }
                else{
                    show_error_message(data.reason);
                }
            },
            error: function (data) {
                show_error_message(data);
            }
        });
    })

</script>
</body>

</html>
