<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>Registration</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN Favicon -->
    <link rel="shortcut icon" href="{{asset('assets/global/img/icons/favicon.ico')}}" type="image/x-icon">
    <!-- END Favicon -->
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="{{asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{asset('assets/global/plugins/morris/morris.css')}}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{asset('assets/global/css/components-rounded.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{asset('assets/global/css/plugins.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->

    <!-- BEGIN GLOBAL PAGE STYLES -->
    <link href="{{asset('assets/pages/css/login.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/plugins/intl-tel-input-master/css/intlTelInput.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL PAGE STYLES-->

    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{asset('assets/layouts/layout/css/layout.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/layouts/layout/css/themes/blue.min.css')}}" rel="stylesheet" type="text/css" id="style_color" />
    <link href="{{asset('assets/layouts/layout/css/custom.css')}}" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->

    <link href="{{asset('assets/holdon/holdon.min.css')}}" rel="stylesheet" />
</head>

<body class=" login">

<div class="login-header">
    <div class="page-logo">
        <a href="#" class="nav-item ajax_item item-1  " data-name="dashboard" data-item="1">
            <img src="../../assets/layouts/layout/img/logo.png" alt="logo" class="logo-default"> </a>
    </div>
</div>

<!-- BEGIN LOGIN -->
<div class="content">
    <?php
    if(!empty($reffer_user)){
        $email = $reffer_user->email;
        $phone = $reffer_user->phone;
    }
    else{
        $email = '';
        $phone = '';
    }
    ?>
    <!-- BEGIN REGISTRATION FORM -->
    <form id="registration_form" class="register-form" action="index.html" method="post">
        {{csrf_field()}}
        <!-- BEGIN LOGO -->
        <!-- <div class="logo">
            <img src="../../assets/global/img/logo-invert.png" alt="" />
        </div> -->
        <!-- END LOGO -->
        <h3 class="font-theme">Sign Up</h3>

            <div class="alert alert-success" id="success_message" style="display:none"></div>
            <div class="alert alert-danger" id="error_message" style="display: none"></div>

        <p class="hint"> Enter your personal details below: </p>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">User Name*</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="User Name*" name="username" id="username" />
        </div>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Email</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="Email*" name="email" id="email" value="{{$email}}" />
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Phone*</label>
            <input class="form-control placeholder-no-fix" id="telephone" type="text" name="phone" onkeyup="this.value=this.value.replace(/[^\d]/,'')" value="{{$phone}}" />
            <span id="valid-msg" class="hide">✓ Valid</span>
            <span id="error-msg" class="hide">Invalid</span>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <input class="form-control placeholder-no-fix password-field" type="password" autocomplete="off" id="password" placeholder="Password* (At least 5 characters)" name="password" />
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
            <input class="form-control placeholder-no-fix password-field" type="password" autocomplete="off" id="repassword" placeholder="Re-type Your Password*" name="repassword" />
        </div>
        <div class="form-group margin-top-20 margin-bottom-20">
            <label class="mt-checkbox mt-checkbox-outline mb-0">
                <input type="checkbox" class="show-password" name="show_password" /> Show password
                <span></span>
            </label>
            <div id="register_tnc_error"> </div>
        </div>
        <div class="form-actions text-center">
            <button type="submit" id="register-submit-btn" class="btn theme-btn uppercase">Submit</button>
        </div>
    </form>
    <!-- END REGISTRATION FORM -->

    <div class="redirect-text">
        <p>Already have an account? <a href="{{url('login')}}"><b>Login</b></a></p>
    </div>
</div>

<!--[if lt IE 9]>
<script src="{{asset('assets/global/plugins/respond.min.js')}}"></script>
<script src="{{asset('assets/global/plugins/excanvas.min.js')}}"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="{{asset('assets/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{asset('assets/global/plugins/moment.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/morris/morris.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/counterup/jquery.waypoints.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/counterup/jquery.counterup.min.js')}}" type="text/javascript"></script>

<!--For chart START-->
<script src="{{asset('assets/global/plugins/flot/jquery.flot.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/flot/jquery.flot.categories.min.js')}}" type="text/javascript"></script>
<!--For chart END-->
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{asset('assets/global/scripts/app.min.js')}}" type="text/javascript"></script>
<!-- input with country flag & code-->
<!-- input with country flag & code-->
<!-- <script src="https://intl-tel-input.com/node_modules/intl-tel-input/build/js/intlTelInput.js"></script> -->
<script src="{{asset('assets/global/plugins/intl-tel-input-master/js/intlTelInput.js')}}" type="text/javascript"></script>
<!-- <script src="{{asset('assets/global/plugins/intl-tel-input-master/js/intlTelInput.js')}}" type="text/javascript"></script> -->
<!-- For Documentation https://github.com/jackocnr/intl-tel-input#demo-and-examples-->
<!-- END THEME GLOBAL SCRIPTS -->

<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="{{asset('assets/layouts/layout/scripts/layout.min.js')}}" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{asset('assets/pages/scripts/dashboard.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<!-- BEGIN GLOABL CUSTOM SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="{{asset('assets/global/scripts/custom.js')}}" type="text/javascript"></script>
<!-- END GLOABL CUSTOM SCRIPTS -->

<script src="{{ asset('assets/holdon/holdon.min.js')}}"></script>

<script type="text/javascript">
    $(document).on("submit", "#registration_form", function(event) {
        event.preventDefault();

        var options = {
            theme: "sk-cube-grid",
            message: 'Please wait while saving all data.....',
            backgroundColor: "#1847B1",
            textColor: "white"
        };

        HoldOn.open(options);

        var username = $("#username").val();
        var email = $("#email").val();
        var phone = $("#telephone").val();
        var country_code = $(".iti__selected-dial-code").text();
        var password = $("#password").val();
        var repassword = $("#repassword").val();
        var re = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        var validate = "";

        if (username.trim() == "") {
            validate = validate + "Username is required</br>";
        }
        if (password.trim() == "") {
            validate = validate + "Password is required</br>";
        }
        if (password.trim() != "" && password.length<5) {
            validate = validate + "Password length can not be less than 5 character</br>";
        }
        if (password.trim() != "" && password.trim() != repassword.trim()) {
            validate = validate + "Password and retype password not matched</br>";
        }
        if (phone.trim() == "") {
            validate = validate + "Phone is required</br>";
        }
        if (email.trim() == "") {
            validate = validate + "Email is required</br>";
        }
        if(email.trim()!=''){
            if(!re.test(email)){
                validate = validate+'Email is invalid<br>';
            }
        }

        if (validate == "") {
            var formData = new FormData($("#registration_form")[0]);
            formData.append('country_code', country_code);
            var url = "{{ url('user/store') }}";

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                success: function(data) {
                    HoldOn.close();
                    if (data.status == 200) {
                        $("#success_message").show();
                        $("#error_message").hide();
                        $("#success_message").html(data.reason);
                        setTimeout(function(){
                            window.location.href="{{url('thankyou')}}";
                        },2000)
                    } else {
                        $("#success_message").hide();
                        $("#error_message").show();
                        $("#error_message").html(data.reason);
                    }
                },
                error: function(data) {
                    HoldOn.close();
                    $("#success_message").hide();
                    $("#error_message").show();
                    $("#error_message").html(data);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        } else {
            HoldOn.close();
            $("#success_message").hide();
            $("#error_message").show();
            $("#error_message").html(validate);
        }
    });
</script>

</body>

</html>
