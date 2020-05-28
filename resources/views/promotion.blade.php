<!DOCTYPE html>
<html lang="en" class=" no-htmlimports" style="">
    <head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <!-- metas -->

    <meta name="author" content="Chitrakoot Web">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="keywords" content="HTML5 Template Amava">
    <meta name="description" content="Amava - Startup Agency and SasS Business Template">

    <!-- title  -->
    <title>Welcome</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="">
    <link rel="apple-touch-icon" href="">
    <link rel="apple-touch-icon" sizes="72x72" href="">
    <link rel="apple-touch-icon" sizes="114x114" href="">

    <!-- plugins -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css" rel="stylesheet" >
    <link rel="stylesheet" href="{{asset('assets/promotion/assets/plugins.css')}}">

    <!-- search css -->
    <link rel="stylesheet" href="{{asset('assets/promotion/assets/search.css')}}">

    <!-- switcher css -->
    <link href="{{asset('assets/promotion/assets/switcher.css')}}" rel="stylesheet">

    <!-- core style css -->
    <link href="{{asset('assets/promotion/assets/styles-2.css')}}" rel="stylesheet" id="colors">

</head>

<body>

    <!-- start page loading -->

    <!-- end page loading -->

    <!-- start main-wrapper section -->
    <div class="main-wrapper">

        <!-- start header section -->
        <header class="position-absolute width-100 transparent-header sm-bg-theme-solid sm-position-relative fixedHeader">

            <div class="navbar-default">

                <div class="container lg-container">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-12">
                            <div class="menu_area alt-font">
                                <nav class="navbar navbar-expand-lg navbar-light no-padding current">

                                    <div class="navbar-header navbar-header-custom">
                                        <!-- start logo -->
                                        <a href="javascript:;" class="navbar-brand blue-logo"><img id="logo" src="{{asset('assets/promotion/assets/logo-white.png')}}" alt="logo"></a>
                                        <!-- end logo -->
                                    </div>

                                    <div class="navbar-toggler"></div>

                                    <!-- start menu area -->
                                    <ul class="navbar-nav ml-auto" id="nav" style="">

                                        <!-- <li><a class="purchase-btn flash-button butn style-two margin-15px-right vertical-align-middle" href="javascript:;">Purchase</a></li> -->

                                        <div class="content">
                                            <form id="select_user_form" class="login-form" action="{{url('payment_success',$user->id)}}" method="post">
                                                {{csrf_field()}}

                                                <div class="form-actions">
                                                    <button type="submit" class="purchase-btn flash-button butn style-two margin-15px-right vertical-align-middle">Pay Now</button>
                                                </div>
                                            </form>
                                        </div>
                                    </ul>
                                    <!-- end menu area -->

                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </header>
        <!-- end header section -->

        <!-- start main banner area -->
        <div class="creative-banner-area bg-theme full-screen" style="min-height: 754px;">
            <div class="container lg-container">
                <div class="row">

                    <!-- start left banner text -->
                    <div class="col-lg-10 col-md-12 center-col text-center">
                        <div class="header-text margin-90px-bottom md-margin-40px-bottom sm-margin-50px-bottom xs-margin-30px-bottom">
                            <h1 class="wow fadeInUp text-white xs-font-size28" data-wow-delay=".1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">Find the best solution for projects</h1>
                            <p class="center-col text-white font-size16 line-height-28 xs-font-size14 xs-line-height-26 margin-30px-bottom sm-margin-20px-bottom width-55 md-width-75 xs-width-90 wow fadeInUp" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">Strong management and security for powerful features. Clean and creative best software design for your customers.</p>
                            <div class="wow fadeInUp story-video" data-wow-delay=".4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;"><a href="javascript:void(0)" class="butn style-two margin-15px-right vertical-align-middle">Get Started</a>
                                <a href="" class="icon-play video vertical-align-middle"></a>
                            </div>
                        </div>
                    </div>
                    <!-- end banner text -->

                </div>
            </div>
            <div class="banner-content-img wow fadeInUp" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                <img src="{{asset('assets/promotion/assets/banner-content01.png')}}" alt="">
            </div>

            <!-- start shape area -->
            <div class="header-shape">
                <img src="{{asset('assets/promotion/assets/banner-mask.png')}}" class="img-fluid width-100" alt="">
            </div>
            <!-- end shape area -->

        </div>
        <!-- end main banner area -->

        <!-- start service section -->
        <section class="lg margin-90px-top xs-margin-50px-top">
            <div class="container lg-container">
                <div class="section-title text-center position-relative padding-40px-tb sm-padding-20px-top xs-padding-20px-bottom wow fadeInDown" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInDown;">
                    <div class="title-count alt-font">1</div>
                    <h3 class="font-size36 sm-font-size32 xs-font-size28 font-weight-700 margin-10px-bottom">First class useful project features</h3>
                    <p class="font-size16 padding-20px-top xs-no-padding-top">Simple design system that maintains perfect in any design</p>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6 margin-90px-bottom md-margin-60px-bottom sm-margin-50px-bottom wow fadeInUp" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                        <div class="service-block3">
                            <div class="icon-box4 bg1 margin-30px-bottom">
                                <i class="icon-target icons text-white"></i>
                            </div>
                            <h5>Unique &amp; Adaptable</h5>
                            <p class="width-85 md-width-100">The agency will support to develop innovation and technology to startups in many variations.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 margin-90px-bottom md-margin-60px-bottom sm-margin-50px-bottom wow fadeInUp" data-wow-delay=".4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
                        <div class="service-block3">
                            <div class="icon-box4 bg2 margin-30px-bottom">
                                <i class="icon-speedometer icons text-white"></i>
                            </div>
                            <h5>Best Performance</h5>
                            <p class="width-85 md-width-100">The agency will support to develop innovation and technology to startups in many variations.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 margin-90px-bottom md-margin-60px-bottom sm-margin-50px-bottom wow fadeInUp" data-wow-delay=".6s" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInUp;">
                        <div class="service-block3">
                            <div class="icon-box4 bg3 margin-30px-bottom">
                                <i class="icon-note icons text-white"></i>
                            </div>
                            <h5>Easily Control</h5>
                            <p class="width-85 md-width-100">The agency will support to develop innovation and technology to startups in many variations.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 sm-margin-50px-bottom wow fadeInUp" data-wow-delay=".8s" style="visibility: visible; animation-delay: 0.8s; animation-name: fadeInUp;">
                        <div class="service-block3">
                            <div class="icon-box4 bg4 margin-30px-bottom">
                                <i class="icons icon-layers text-white"></i>
                            </div>
                            <h5>Fully Secured</h5>
                            <p class="width-85 md-width-100">The agency will support to develop innovation and technology to startups in many variations.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 mobile-padding-50px-bottom wow fadeInUp" data-wow-delay="1s" style="visibility: visible; animation-delay: 1s; animation-name: fadeInUp;">
                        <div class="service-block3">
                            <div class="icon-box4 bg5 margin-25px-bottom">
                                <i class="icons icon-organization text-white"></i>
                            </div>
                            <h5>Team Collaboration</h5>
                            <p class="width-85 md-width-100">The agency will support to develop innovation and technology to startups in many variations.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 wow fadeInUp" data-wow-delay="1.2s" style="visibility: visible; animation-delay: 1.2s; animation-name: fadeInUp;">
                        <div class="service-block3">
                            <div class="icon-box4 bg6 margin-25px-bottom">
                                <i class="icons icon-briefcase text-white"></i>
                            </div>
                            <h5>Guaranteed Support</h5>
                            <p class="width-85 md-width-100">The agency will support to develop innovation and technology to startups in many variations.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end service section -->

        <!-- start features section -->
        <section class="lg bg-very-light-gray">
            <div class="container lg-container">

                <div class="section-title text-center position-relative padding-40px-tb sm-padding-20px-top xs-padding-20px-bottom wow fadeInDown" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInDown;">
                    <div class="title-count alt-font">2</div>
                    <h3 class="font-size36 sm-font-size32 xs-font-size28 font-weight-700 margin-10px-bottom"> Convert your designs into interactive</h3>
                    <p class="font-size16 padding-20px-top xs-no-padding-top">Simple design system that maintains perfect in any design</p>
                </div>

                <div class="row margin-ten-bottom sm-margin-50px-bottom align-items-center">
                    <div class="col-lg-5 wow fadeInLeft order-2 order-lg-1" data-wow-delay=".1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInLeft;">

                        <div class="padding-40px-right xs-no-padding-right md-padding-25px-right">
                            <span class="icon-square orange margin-25px-bottom xs-margin-20px-bottom">
                                    <i class="ti-bar-chart"></i>
                                </span>
                            <h4 class="font-size28 sm-font-size26 xs-font-size22 margin-30px-bottom sm-margin-20px-bottom line-height-normal xs-margin-15px-bottom">Build your powerful project using advanced Integrate interface</h4>
                            <p class="margin-30px-bottom xs-margin-25px-bottom small-title">Excepteur sint occaecat cupidatat non proident, sunt in officia deserunt.</p>
                            <ul class="list-style6 no-margin-bottom">
                                <li>Strong management &amp; security</li>
                                <li>Your business deserves best software</li>
                                <li>We are working to solve your problem</li>
                                <li>The elements from one design to another</li>

                            </ul>
                        </div>

                    </div>
                    <div class="col-lg-7 text-right sm-margin-40px-bottom wow fadeInRight order-1 order-lg-2" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInRight;">
                        <img src="{{asset('assets/promotion/assets/about-01.png')}}" alt="">
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-7 sm-margin-40px-bottom text-left wow fadeInLeft" data-wow-delay=".1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInLeft;">
                        <img src="{{asset('assets/promotion/assets/about4-01.png')}}" alt="">
                    </div>
                    <div class="col-lg-5 wow fadeInRight" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInRight;">

                        <div class="padding-40px-left xs-no-padding-left md-padding-25px-left">
                            <span class="icon-square blue margin-25px-bottom xs-margin-20px-bottom">
                                    <i class="ti-agenda"></i>
                                </span>
                            <h4 class="font-size28 sm-font-size26 xs-font-size22 margin-30px-bottom line-height-normal sm-margin-20px-bottom xs-margin-15px-bottom">Responsive design for all devices with quality</h4>
                            <p class="margin-30px-bottom xs-margin-25px-bottom small-title">Moditempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>
                            <ul class="list-style6 margin-40px-bottom xs-margin-30px-bottom">
                                <li>Quick &amp; easy process</li>
                                <li>Perfect for small business</li>
                                <li>Complete leave management</li>
                                <li>Simple and smart design integration</li>
                            </ul>
                            <a href="javascript:void(0)" class="butn style-one blue">Get Started</a>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- end features section -->

        <!-- start process section -->
        <section class="lg">
            <div class="container lg-container">

                <div class="section-title text-center position-relative padding-40px-tb sm-padding-20px-top xs-padding-20px-bottom wow fadeInDown" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInDown;">
                    <div class="title-count alt-font">3</div>
                    <h3 class="font-size36 sm-font-size32 xs-font-size28 font-weight-700 margin-10px-bottom">Software that is built to one place</h3>
                    <p class="font-size16 padding-20px-top xs-no-padding-top">Discover a seamless experience in Project Management</p>
                </div>

                <div class="row wow fadeInUp" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                    <div class="col-12">
                        <!--Vertical Tab-->

                        <div class="verticaltab vtab-style1 resp-vtabs hor_1" style="display: block; width: 100%; margin: 0px;">
                            <div class="row align-items-center">
                                <div class="col-lg-4">

                                    <ul class="resp-tabs-list hor_1">
                                        <li id="tab1" class="resp-tab-item hor_1" aria-controls="hor_1_tab_item-0" role="tab">
                                            <span class="icon-circle green vertical-align-middle">
                                                    <span class="icons icon-chart"></span>
                                            </span>
                                            <div class="tab-desc">
                                                Analysis
                                                <p class="font-weight-400 margin-10px-top sm-margin-5px-top no-margin-bottom">A complete analysis ready to help you</p>
                                            </div>
                                        </li>
                                        <li id="tab2" class="resp-tab-item hor_1" aria-controls="hor_1_tab_item-1" role="tab"><span class="icon-circle orange vertical-align-middle">
                                                    <span class="icons icon-energy"></span>
                                            </span>
                                            <div class="tab-desc">
                                                Execution
                                                <p class="font-weight-400 margin-10px-top sm-margin-5px-top no-margin-bottom">A complete execution ready to help you</p>
                                            </div>
                                        </li>
                                        <li id="tab3" class="resp-tab-item hor_1" aria-controls="hor_1_tab_item-2" role="tab"><span class="icon-circle blue vertical-align-middle">
                                                    <span class="icons icon-share-alt"></span>
                                            </span>
                                            <div class="tab-desc">
                                                Release
                                                <p class="font-weight-400 margin-10px-top sm-margin-5px-top no-margin-bottom">A complete feature ready to help you</p>
                                            </div>
                                        </li>
                                    </ul>

                                </div>
                                <div class="col-lg-6 col-md-12 offset-lg-1">
                                    <div class="resp-tabs-container hor_1">
                                        <h2 class="resp-accordion hor_1" role="tab" aria-controls="hor_1_tab_item-0" style="background: none;"><span class="resp-arrow"></span>
                                            <span class="icon-circle green vertical-align-middle">
                                                    <span class="ti-bar-chart"></span>
                                            </span>
                                            <div class="tab-desc">
                                                Analysis
                                                <p class="font-weight-400 margin-10px-top sm-margin-5px-top no-margin-bottom">A complete analysis ready to help you</p>
                                            </div>
                                        </h2><div id="first" class="tabs_div resp-tab-content hor_1" aria-labelledby="hor_1_tab_item-0" style="display: none;">
                                            <img src="{{asset('assets/promotion/assets/banner-content01.png')}}" alt="" class="box-shadow-large">
                                        </div>
                                        <h2 class="resp-accordion hor_1" role="tab" aria-controls="hor_1_tab_item-1"><span class="resp-arrow"></span><span class="icon-circle orange vertical-align-middle">
                                                    <span class="ti-write"></span>
                                            </span>
                                            <div class="tab-desc">
                                                Execution
                                                <p class="font-weight-400 margin-10px-top sm-margin-5px-top no-margin-bottom">A complete execution ready to help you</p>
                                            </div>
                                        </h2><div id="second" class="tabs_div resp-tab-content hor_1 tabs_div_visible" aria-labelledby="hor_1_tab_item-1" style="display: none;">
                                            <img src="{{asset('assets/promotion/assets/tab-04.png')}}" alt="" class="box-shadow-large">
                                        </div>
                                        <h2 class="resp-accordion hor_1 resp-tab-active" role="tab" aria-controls="hor_1_tab_item-2"><span class="resp-arrow"></span><span class="icon-circle blue vertical-align-middle">
                                                    <span class="ti-rocket"></span>
                                            </span>
                                            <div class="tab-desc">
                                                Release
                                                <p class="font-weight-400 margin-10px-top sm-margin-5px-top no-margin-bottom">A complete feature ready to help you</p>
                                            </div>
                                        </h2><div id="third" class="tabs_div resp-tab-content hor_1" aria-labelledby="hor_1_tab_item-2">
                                            <img src="{{asset('assets/promotion/assets/tab-05.png')}}" alt="" class="box-shadow-large">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end process section -->


        <!-- start contact section -->
        <section class="no-padding">
            <div class="container lg-container">
                <div class="parallax text-center cover-background padding-90px-all md-padding-70px-all sm-padding-50px-all xs-padding-50px-tb xs-padding-30px-lr wow fadeInUp theme-overlay-180 border-radius-4 z-index-9" data-wow-delay=".2s" data-overlay-dark="9" data-background="{{asset('assets/promotion/img/content/footer-bg.jpg')}}" style="background-image: url('{{asset('assets/promotion/img/content/footer-bg.jpg')}}'); visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">

                    <div class="position-relative z-index-1">
                        <h3 class="font-size36 sm-font-size32 xs-font-size28 margin-20px-bottom text-white">Start growing your bussiness.</h3>
                        <p class="width-50 md-width-65 sm-width-80 xs-width-95 center-col text-white margin-40px-bottom sm-margin-30px-bottom">Our passion to work hard and deliver excellent results. It could solve the needs of develop innovation.</p>
                        <a href="javascript:void(0)" class="butn style-two">Get Access</a>
                    </div>

                </div>
            </div>
        </section>
        <!-- end contact section -->

        <!-- start footer section -->
        <footer class="footer-style3 bg-white bg-img cover-background" data-background="{{asset('assets/promotion/img/content/footer.png')}}" style="background-image: url('{{asset('assets/promotion/img/content/footer.png')}}');">
            <div class="container lg-container">

                    <div class="row">
                        <div class="col-lg-3 col-md-6 sm-margin-50px-bottom xs-margin-30px-bottom">
                            <span class="footer-logo margin-25px-bottom display-inline-block">
                                <img src="{{asset('assets/promotion/assets/logo-footer-small-white.png')}}" alt="logo">
                            </span>
                            <ul>
                                <li><a href="javascript:void(0)">admin@yourdomain.com</a></li>
                                <li>(+880) 16454564</li>
                            </ul>
                            <div class="footer-icon">
                                <ul class="no-margin-bottom">
                                    <li>
                                        <a href="javascript:void(0)"><i class="icons icon-social-facebook"></i></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)"><i class="icons icon-social-twitter"></i></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)"><i class="icons icon-social-google"></i></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)"><i class="icons icon-social-linkedin"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 sm-margin-50px-bottom xs-margin-30px-bottom">
                            <h4>About Us</h4>
                            <ul class="no-margin-bottom">
                                <li><a href="javascript:void(0)">About Us</a></li>
                                <li><a href="javascript:void(0)">Our Team</a></li>
                                <li><a href="javascript:void(0)">Projects</a></li>
                                <li><a href="javascript:void(0)">FAQ</a></li>
                            </ul>
                        </div>

                        <div class="col-lg-3 col-md-6 xs-margin-30px-bottom">
                            <h4>Support Solutions</h4>
                            <ul class="no-margin-bottom">
                                <li><a href="javascript:void(0)">Pricing</a></li>
                                <li><a href="javascript:void(0)">Tables</a></li>
                                <li><a href="javascript:void(0)">Accordions</a></li>
                                <li><a href="javascript:void(0)">Services</a></li>
                            </ul>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <h4>Quick Links</h4>
                            <ul class="no-margin-bottom">
                                <li><a href="javascript:void(0)">Blog Grid</a></li>
                                <li><a href="javascript:void(0)">Blog Default</a></li>
                                <li><a href="javascript:void(0)">Contact Us</a></li>
                                <li><a href="javascript:void(0)">Blog Post</a></li>
                            </ul>
                        </div>
                    </div>

            </div>
            <div class="footer-style3-bottom">
                <div class="container">

                    <p>© 2020</p>

                </div>
            </div>
        </footer>
        <!-- end footer section -->

    </div>
    <!-- end main-wrapper section -->


    <!-- start scroll to top -->
    <a href="javascript:void(0)" class="scroll-to-top" style="display: none;"><i class="icons icon-arrow-up" aria-hidden="true"></i></a>
    <!-- end scroll to top -->

    <!-- all js include start -->

    <!-- core.min js -->
    <script src="{{asset('assets/promotion/assets/core.min.js')}}"></script>

    <!-- Serch -->
    <script src="{{asset('assets/promotion/assets/search.js')}}"></script>

    <!-- custom scripts -->
    <script src="{{asset('assets/promotion/assets/main.js')}}"></script>

    <!-- contact form scripts -->
    <script src="{{asset('assets/promotion/assets/jquery.form.min.js')}}"></script>
    <script src="{{asset('assets/promotion/assets/jquery.rd-mailform.min.c.js')}}"></script>

    <!-- all js include end -->



</body></html>

