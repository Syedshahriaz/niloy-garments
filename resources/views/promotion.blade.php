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

                    <h2 class="text-center mt-5">Choose your offer - We kept price 11 BDT for testing purpose</h2>

                    <div class="offer-option mb-5 animate__animated animate__fadeInUp">
                        <form id="payment_form" class="login-form" action="{{url('initiate_payment',$user->id)}}" method="get">
                            <div class="form-group">
                                <div class="offer-itemlist">
                                    <div class="offer-option-item green-offer-option active_offer_option">
                                        <p>{{$offer->offer1_name}}</p>
                                        <input type="radio" name="offer" value="1" hidden="">
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
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="page-footer">
        <div class="page-footer-inner text-center w-100"> © All rights reserved to <a target="_blank" href="https://vujadetec.com/"><strong>vujadetec</strong></a></div>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <script>
        $(document).on('click','.offer-option-item',function(){
            $('.offer-option-item').removeClass('selected-offer')
            $(this).addClass('selected-offer');
            $(this).children('input[type="radio"]').prop('checked',true);
        });

         $(document).on('click','.active_offer_option', function(){
             $('#payment_form').submit();
         });

        /*
       * Reloading page on browser back and forth button click
       * */
        $(window).on('popstate', function(event) {
            window.location.reload();
        });

    </script>
</body>

</html>
