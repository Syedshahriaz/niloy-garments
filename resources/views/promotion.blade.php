<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"/>
    <link rel="stylesheet" href="{{asset('assets/promotion/assets/css/promotion.css')}}">
    <title>Prmotion</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
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

                    <h2 class="text-center mt-5">Choose your offer</h2>

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
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
         })
    </script>
</body>

</html>
