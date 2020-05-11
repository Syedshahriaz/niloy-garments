<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>Select User</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
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
</head>

<body class=" login">

<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN REGISTRATION FORM -->
    <form id="registration_form" class="register-form" action="index.html" method="post">
        {{csrf_field()}}
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="index.html">
                <img src="../../assets/global/img/logo-invert.png" alt="" /> </a>
        </div>
        <!-- END LOGO -->
        <h3 class="font-theme">Sign Up</h3>

            <div class="alert alert-success" id="success_message" style="display:none"></div>
            <div class="alert alert-danger" id="error_message" style="display: none"></div>

        <p class="hint"> Enter your personal details below: </p>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">User Name*</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="User Name*" name="username" id="username" />
            <small id="fullname-error" class="help-block text-danger">Enter your user name.</small>
        </div>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Email</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="Email*" name="email" id="email" />
            <small id="Email-error" class="help-block text-danger">Enter your email address.</small>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Phone*</label>
            <input class="form-control placeholder-no-fix" id="telephone" type="text" name="phone" id="phone" />
            <small id="Phone-error" class="help-block text-danger">Enter your phone number</small>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="password" placeholder="Password*" name="password" />
            <small id="password-error" class="help-block text-danger">Enter your Password</small>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="repassword" placeholder="Re-type Your Password*" name="repassword" />
            <small id="repassword-error" class="help-block text-danger">Reenter your password</small>
        </div>
        <div class="form-group margin-top-20 margin-bottom-20">
            <label class="mt-checkbox mt-checkbox-outline mb-0">
                <input type="checkbox" name="show_password" /> Show password
                <span></span>
            </label>
            <div id="register_tnc_error"> </div>
        </div>
        <div class="form-actions">
            <button type="submit" id="register-submit-btn" class="btn theme-btn uppercase pull-right">Submit</button>
        </div>
    </form>
    <!-- END REGISTRATION FORM -->
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
<script src="{{asset('assets/global/plugins/intl-tel-input-master/js/intlTelInput-jquery.min.js')}}" type="text/javascript"></script>
<!-- For Documentation https://github.com/jackocnr/intl-tel-input#demo-and-examples-->
<!-- END THEME GLOBAL SCRIPTS -->

<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="{{asset('assets/layouts/layout/scripts/layout.min.js')}}" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{asset('assets/pages/scripts/dashboard.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<!-- BEGIN GLOABL CUSTOM SCRIPTS -->
<script src="{{asset('assets/global/scripts/custom.js')}}" type="text/javascript"></script>
<!-- END GLOABL CUSTOM SCRIPTS -->

<script type="text/javascript">
    $(document).on("submit", "#registration_form", function(event) {
        event.preventDefault();

        var username = $("#username").val();
        var email = $("#email").val();
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
        if (password.trim() != "" && password.trim() != repassword.trim()) {
            validate = validate + "Password and retype password not matched</br>";
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
            var url = "{{ url('user/store') }}";

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                success: function(data) {
                    if (data.status == 200) {
                        $("#success_message").show();
                        $("#error_message").hide();
                        $("#success_message").html(data.reason);
                    } else {
                        $("#success_message").hide();
                        $("#error_message").show();
                        $("#error_message").html(data.reason);
                    }
                },
                error: function(data) {
                    $("#success_message").hide();
                    $("#error_message").show();
                    $("#error_message").html(data);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        } else {
            $("#success_message").hide();
            $("#error_message").show();
            $("#error_message").html(validate);
        }
    });
</script>

</body>

</html>
