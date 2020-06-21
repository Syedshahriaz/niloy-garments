<script>
    $(document).on("click", "input[name='show_password']", function(event) {
        if($(this).is(":checked") == true){
            $('input[type="password"]').prop("type", "text");
        }
        else{
            $('input[name="password"]').prop("type", "password");
            $('input[name="confirm_password"]').prop("type", "password");
        }
    });

    $(document).on('click', '#image_change_btn', function(){
        $('#image_change_hidden_btn').trigger('click');
    });

    $(document).on('change', '#image_change_hidden_btn', function(){
        readURL(this);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image')
                    .attr('src', e.target.result)
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    function set_teliphone(telephone){
        $(".telephone").intlTelInput("setNumber", telephone);
    }

    /*
    * Create new user js
    * */
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
        var phone = $("#telephone").val();
        var country_code = $(".iti__selected-dial-code").text();
        var re = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        var validate = "";

        if (username.trim() == "") {
            validate = validate + "Username is required</br>";
        }
        if (phone.trim() == "") {
            validate = validate + "Phone is required</br>";
        }

        if (validate == "") {
            var formData = new FormData($("#registration_form")[0]);
            formData.append('country_code', country_code);
            var url = "{{ url('store_new_user') }}";

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

                        $('#user_id').val(data.user_id);
                        window.location.href="{{url('promotion')}}/"+data.user_id;
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

    /*
    * User list js
    * */
    function send_otp(user_id){
        $('#user_id').val(user_id);
        $('#user_otp_modal').modal('show');
    }

    $(document).on("submit", "#user_otp_form", function(event) {
        event.preventDefault();
        return false;
    });

    $(document).on("click", "#send_otp_button", function(event) {
        event.preventDefault();
        user_otp_form_submit();
    });

    function user_otp_form_submit(){
        var options = {
            theme: "sk-cube-grid",
            message: 'Please wait while sending email.....',
            backgroundColor: "#1847B1",
            textColor: "white"
        };

        HoldOn.open(options);

        var user_id = $("#user_id").val();
        var email = $("#email").val();
        var password = $("#password").val();
        var repassword = $("#repassword").val();
        var re = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        var validate = "";

        if (email.trim() == "") {
            validate = validate + "Email is required</br>";
        }
        if(email.trim()!=''){
            if(!re.test(email)){
                validate = validate+'Email is invalid<br>';
            }
        }
        if (password.trim() == "") {
            validate = validate + "Password is required</br>";
        }
        if (password.trim() != "" && password.trim() != repassword.trim()) {
            validate = validate + "Password and retype password not matched</br>";
        }

        if (validate == "") {
            var formData = new FormData($("#user_otp_form")[0]);
            var url = "{{ url('send_user_otp') }}";

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

                        $('#user_otp_form')[0].reset();
                        $("#success_message").hide();
                        $("#success_message").html('');
                        $('#user_otp_modal').modal('hide');

                        $('#send_otp_button_'+user_id).text('Send OTP Again');
                        $('#make_separate_button_'+user_id).removeClass('hidden');
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
    }

    function separate_user(user_id){
        $('#otp').val('');
        $('#separate_user_id').val(user_id);
        $('#separate_user_modal').modal('show');
    }

    $(document).on("submit", "#separate_user_form", function(event) {
        event.preventDefault();
        return false;
    });
    $(document).on("click", "#separate_user_button", function(event) {
        event.preventDefault();
        separate_user_form_submit();
    });

    function separate_user_form_submit(){
        var options = {
            theme: "sk-cube-grid",
            message: 'Please wait while exporting and saving all data.....',
            backgroundColor: "#1847B1",
            textColor: "white"
        };

        HoldOn.open(options);

        var otp = $("#otp").val();
        var re = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        var validate = "";

        if (otp.trim() == "") {
            validate = validate + "OTP is required</br>";
        }

        if (validate == "") {
            var formData = new FormData($("#separate_user_form")[0]);
            var url = "{{ url('separate_user') }}";

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                success: function(data) {
                    HoldOn.close();
                    if (data.status == 200) {
                        $("#separate_success_message").show();
                        $("#separate_error_message").hide();
                        $("#separate_success_message").html(data.reason);
                        setTimeout(function(){
                            location.reload();
                        },2000)
                    } else {
                        $("#separate_success_message").hide();
                        $("#separate_error_message").show();
                        $("#separate_error_message").html(data.reason);
                    }
                },
                error: function(data) {
                    HoldOn.close();
                    $("#separate_success_message").hide();
                    $("#separate_error_message").show();
                    $("#separate_error_message").html(data);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        } else {
            HoldOn.close();
            $("#separate_success_message").hide();
            $("#separate_error_message").show();
            $("#separate_error_message").html(validate);
        }
    }

    /*
    * User edit js
    * */
    $(document).on("submit", "#profile_form", function(event) {
        event.preventDefault();

        var first_name = $("#first_name").val();
        var email = $("#email").val();
        var country_code = $(".iti__selected-dial-code").text();

        var re = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        var validate = "";

        /*if (first_name.trim() == "") {
            validate = validate + "First name is required</br>";
        }*/
        if (email.trim() == "") {
            validate = validate + "Email is required</br>";
        }
        if(email.trim()!=''){
            if(!re.test(email)){
                validate = validate+'Email is invalid<br>';
            }
        }

        if (validate == "") {
            var formData = new FormData($("#profile_form")[0]);
            formData.append('country_code', country_code);
            var url = "{{ url('user_update') }}";

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                success: function(data) {
                    if (data.status == 200) {
                        $("#success_message").show();
                        $("#error_message").hide();
                        $("#success_message").html(data.reason);
                        setTimeout(function(){
                            $("#success_message").hide();
                        },2000)
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

    /*
    * Reset user password js
    * */
    $(document).on("submit", "#reset_password_form", function(event) {
        event.preventDefault();

        var password = $("#password").val();
        var confirm_password = $("#confirm_password").val();

        var validate = "";

        if (password.trim() == "") {
            validate = validate + "Password is required</br>";
        }
        if (password.trim() != "" && password.trim() != confirm_password.trim()) {
            validate = validate + "Password and confirm password not matched</br>";
        }

        if (validate == "") {
            var formData = new FormData($("#reset_password_form")[0]);
            var url = "{{ url('update_password') }}";

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                success: function(data) {
                    if (data.status == 200) {
                        $("#success_message").show();
                        $("#error_message").hide();
                        $("#success_message").html(data.reason);
                        $('#reset_password_form')[0].reset();
                        setTimeout(function(){
                            $("#success_message").hide();
                        },2000)
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

    /*
    * User dashboard js
    * */
    function open_buyer_modal(){
        $('#create_buyer_modal').modal('show');
    }

    $(document).on("click", "#save_buyer_button", function(event) {
        event.preventDefault();

        show_loader();

        var buyer_name = $("#buyer_name").val();
        var buyer_email = $("#buyer_email").val();
        var buying_agent_name = $("#buying_agent_name").val();
        var buying_agent_email = $("#buying_agent_email").val();
        var re = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        var validate = "";

        if (buyer_name.trim() == "") {
            validate = validate + "Buyer name is required</br>";
        }
        /*if (phone.trim() == "") {
            validate = validate + "Phone is required</br>";
        }*/
        if(buyer_email.trim()!=''){
            if(!re.test(buyer_email)){
                validate = validate+'Buyer email is invalid<br>';
            }
        }
        if(buying_agent_email.trim()!=''){
            if(!re.test(buying_agent_email)){
                validate = validate+'Buying agent email is invalid<br>';
            }
        }

        if (validate == "") {
            var formData = new FormData($("#buyer_form")[0]);
            var url = "{{ url('save_buyer') }}";

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                success: function(data) {
                    hide_loader();
                    if (data.status == 200) {
                        $('#create_buyer_modal').modal('hide');
                        populate_buyer_information(data.buyer);
                    } else {
                        $("#success_message").hide();
                        $("#error_message").show();
                        $("#error_message").html(data.reason);
                    }
                },
                error: function(data) {
                    hide_loader();
                    $("#success_message").hide();
                    $("#error_message").show();
                    $("#error_message").html(data);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        } else {
            hide_loader();
            $("#success_message").hide();
            $("#error_message").show();
            $("#error_message").html(validate);
        }
    });

    function populate_buyer_information(buyer){
        $('#buyer_section').removeClass('hidden');
        
        $('#view_buyer_name').text((buyer.buyer_name === null) ? '' : buyer.buyer_name);
        $('#view_buyer_email').text((buyer.buyer_email === null) ? '' : buyer.buyer_email);
        $('#view_buyer_phone').text((buyer.buyer_phone === null) ? '' : buyer.buyer_phone);
        $('#view_buying_agent_name').text((buyer.buying_agent_name === null) ? '' : buyer.buying_agent_name);
        $('#view_buying_agent_email').text((buyer.buying_agent_email === null) ? '' : buyer.buying_agent_email);
        $('#view_buying_agent_phone').text((buyer.buying_agent_phone === null) ? '' : buyer.buying_agent_phone);
        $('#view_address').text((buyer.address === null) ? '' : buyer.address);
    }
</script>
