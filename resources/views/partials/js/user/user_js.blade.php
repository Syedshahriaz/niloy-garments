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
                        window.location.href="{{url('promotion')}}/"+data.user_id+"?ref=child";
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
    * ******** Verify account js
    * */
    $(document).on("submit", "#verification_form", function(event) {
        event.preventDefault();

        $('#done_button').prop('disabled',true);

        show_loader();

        var user_id = $("#user_id").val();
        var otp = $("#otp").val();

        var validate = "";

        if (otp.trim() == "") {
            validate = validate + "OTP is required</br>";
        }


        if (validate == "") {
            var formData = new FormData($("#verification_form")[0]);
            var url = "{{ url('verify_account') }}";

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                success: function(data) {
                    hide_loader();
                    if (data.status == 200) {
                        $("#success_message").show();
                        $("#error_message").hide();
                        $("#success_message").html(data.reason);
                        setTimeout(function(){
                            window.location.href="{{url('promotion')}}/"+user_id;
                        },2000)
                    } else {
                        $('#done_button').prop('disabled',false);
                        $("#success_message").hide();
                        $("#error_message").show();
                        $("#error_message").html(data.reason);
                    }
                },
                error: function(data) {
                    $('#done_button').prop('disabled',false);
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
            $('#done_button').prop('disabled',false);
            hide_loader();
            $("#success_message").hide();
            $("#error_message").show();
            $("#error_message").html(validate);
        }
    });

    /*
    * ******** Resend registration OTP
    * */
    $(document).on("click", "#resend_registration_otp", function(event) {
        event.preventDefault();

        show_loader();

        var user_id = $("#user_id").val();

        var validate = "";


        if (validate == "") {
            var formData = new FormData($("#verification_form")[0]);
            var url = "{{ url('resend_registration_otp') }}";

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                success: function(data) {
                    hide_loader();
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
                    $('#done_button').prop('disabled',false);
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
            $('#done_button').prop('disabled',false);
            hide_loader();
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

        var user_id = $("#user_id").val();
        var first_name = $("#first_name").val();
        var email = $("#email").val();
        var phone = $("#telephone01").val();
        var country_code = $(".iti__selected-dial-code").text();
        var day = $('#day').val();
        var month = $('#month').val();
        var year = $('#year').val();
        var shipment_date = $("#shipment_date").val();
        var old_shipment_date = $('#old_shipment_date').val();
        var from = $('#from').val();

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
        if (phone.trim() == "") {
            validate = validate + "Phone is required</br>";
        }
        if (shipment_date.trim() != "" && isFutureDate(shipment_date)) {
            validate = validate + "You can not select a future date</br>";
        }

        /*if (day.trim() == "" || month.trim() =='' || year.trim() =='') {
            validate = validate + "Shipment date is required</br>";
        }*/

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
                        $('#old_shipment_date').val(shipment_date);
                        if(shipment_date!=old_shipment_date){
                            $('#shipping_date_area').hide();
                        }

                        $("#success_message").show();
                        $("#error_message").hide();
                        $("#success_message").html(data.reason);
                        setTimeout(function(){
                            if(from=='profile'){
                                if(data.photo_path !=''){
                                    var photo_url = "{{url('/')}}/"+data.photo_path;
                                    $( ".profile_image" ).attr( 'src', photo_url);
                                }
                                var item_name = 'profile';
                            }
                            else{
                                var item_name = 'user_details/'+user_id;
                            }

                            var uri_string = '/'+item_name;
                            var url = "{{url('/')}}"+uri_string;
                            window.location.href=url;
                        },1000)
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
        var from = $('#from').val();

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
                            var item_name = 'profile';
                            var browser_title = 'Profile';
                            var uri_string = '/'+item_name;
                            var url = "{{url('/')}}"+uri_string;
                            load_new_page_content(url,item_name,browser_title);
                        },1000)
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

    /*
    * Message js
    * */
    $(document).on('submit','#message_form', function(){
        submit_message();
    });

    $(document).on('click','#send_btn', function(){
        $('#send_btn').addClass("disable-click");
        submit_message();
    });

    function getAndShowUnreadMessageCount(){
        var url = "{{url('get_unread_message') }}";

        $.ajax({
            type: "POST",
            url: url,
            data: {'_token':'<?php echo e(csrf_token()); ?>'},
            success: function(data) {
                if (data.status == 200) {
                    var message_count = data.messages.length;
                    if(message_count>0){
                        $('.new_message_count').removeClass('hidden');
                        $('.new_message_count').text(data.messages.length);
                    }
                    else{
                        $('.new_message_count').addClass('hidden');
                    }
                } else {
                    //Nothing to do now;
                }
            },
            error: function(data) {
                //Nothing to do now;
            }
        });
    }

    function submit_message(){
        event.preventDefault();
        show_loader();

        var user_id = $("#user_id").val();
        var message = $("#message_input").val();
        var message_file = $("#image_upload_input").val();

        var validate = "";

        if (message.trim() == "" && message_file=='') {
            return false;
        }

        if (validate == "") {
            var formData = new FormData($("#message_form")[0]);
            var url = "{{ url('store_message') }}";

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                success: function(data) {
                    hide_loader();
                    $('#send_btn').removeClass("disable-click");
                    if (data.status == 200) {
                        $("#message_id").val(data.message_id);
                        //appendMessage(data.message,data.photo_path);

                        $("#image_upload_input").val('');
                        $("#message_input").val('');
                        $('#uploaded_img').removeClass('visible');
                        $('#message_input').removeClass('img-added');
                    } else {
                        show_error_message(data.reason);
                    }
                },
                error: function(data) {
                    show_error_message('Something went wrong. Try again later.');
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
    }

    function getAndPopulateSelectedMessage(id){
        var url = "{{url('get_message_details')}}";

        $.ajax({
            type: "POST",
            url: url,
            data: {message_id:id,'_token':'<?php echo e(csrf_token()); ?>'},
            success: function(data) {
                if (data.status == 200) {
                    if(!jQuery.isEmptyObject(data.message)){
                        populateMessage(data.message);
                    }

                    /*
                    * Showing new message count
                    * */
                    var browser_title = document.title;
                    browser_title = browser_title.replace(/ *\([^)]*\) */g, "");

                    var message_count = data.unread_messages.length;
                    if(message_count>0){
                        var previous_unread_message = $('#unread_message').val();
                        $('.new_message_count').removeClass('hidden');
                        $('.new_message_count').text(message_count);
                        document.title=browser_title+"("+message_count+")"; // Set browser title;

                        /*Play message tone*/
                        if(message_count>previous_unread_message){
                            document.getElementById("audio").play();
                            $('#unread_message').val(message_count);
                        }
                    }
                    else{
                        $('.new_message_count').addClass('hidden');
                        document.title=browser_title; // Set browser title;
                    }
                } else {
                    //Nothing to do now;
                }
            },
            error: function(data) {
                //Nothing to do now;
            }
        });
    }

    function appendMessage(message,photo_path) {
        var cont = $('#chats');
        var list = $('.chats', cont);
        var user_name = $('#user_name').val();

        var time = new Date();

        var time_str = getFormattedDate(time,'l M d, Y h:i a');;

        var profile_photo = "{{Session::get('user_photo')}}";

        var tpl = '';
        tpl += '<li class="out">';
        if(profile_photo !=''){
            tpl += '<img class="avatar" alt="" src="{{asset(Session::get('user_photo'))}}"/>';
        }
        else{
            tpl += '<img class="avatar" alt="" src="{{asset('assets/layouts/layout/img/emptyuserphoto.png')}}"/>';
        }
        tpl += '<div class="message">';
        tpl += '<span class="arrow"></span>';
        tpl += '<a href="#" class="name">{{Session::get('username')}}</a>&nbsp;';
        tpl += '<span class="datetime">at ' + time_str + '</span>';
        tpl += '<p class="body">';
        if(photo_path !=''){
            var file_path = "{{url('/')}}/"+photo_path;
            tpl += '<img style="float: right; max-width: 200px;" class="body" src="'+file_path+'">';
        }
        if(message !=''){
            tpl += '<span style="clear: both">'+message+'</span>';
        }
        tpl += '</p>';
        tpl += '</div>';
        tpl += '</li>';

        var msg = list.append(tpl);
        $('#message_input').val("");

        var getLastPostPos = function() {
            var height = 0;
            cont.find("li.out, li.in").each(function() {
                height = height + $(this).outerHeight();
            });

            return height;
        }

        cont.find('.scroller').slimScroll({
            scrollTo: getLastPostPos()
        });
    }

    function populateMessage(message) {
        var cont = $('#chats');
        var list = $('.chats', cont);

        $('#user_id').val(message.user_id);
        $('#message_id').val(message.id);

        var tpl = '';

        $.each(message.message_details, function( index, msg ) {

            var time_str = getFormattedDate(msg.created_at,'l M d, Y h:i a');

            if(msg.type=='received'){
                var message_type = 'in';
                var profile_photo = message.admin_photo;
                var user_name = 'Vujadetec';
            }
            else{
                var message_type = 'out';
                var profile_photo = message.user_photo;
                var user_name = message.user_name;
            }

            var photo_path = msg.file_path;

            tpl += '<li class="'+message_type+'">';
            if (profile_photo != null) {
                var profile_photo_path = "{{url('/')}}/" + profile_photo;
                tpl += '<img class="avatar" alt="" src="'+profile_photo_path+'"/>';
            } else {
                tpl += '<img class="avatar" alt="" src="{{url('/')}}/assets/layouts/layout/img/emptyuserphoto.png"/>';
            }
            tpl += '<div class="message">';
            tpl += '<span class="arrow"></span>';
            tpl += '<a href="#" class="name">'+user_name+'</a>&nbsp;';
            tpl += '<span class="datetime">at ' + time_str + '</span>';
            tpl += '<p class="body">';
            if (photo_path != null) {
                var file_path = "{{url('/')}}/" + photo_path;
                tpl += '<img style="float: right; max-width: 200px;" class="body" src="' + file_path + '">';
            }
            if(msg.message !==null){
                tpl += '<span style="clear: both">' + msg.message + '</span>';
            }
            tpl += '</p>';
            tpl += '</div>';
            tpl += '</li>';
        });

        var msg = list.html(tpl);

        var getLastPostPos = function() {
            var height = 0;
            cont.find("li.out, li.in").each(function() {
                height = height + $(this).outerHeight();
            });

            return height;
        }

        /*cont.find('.scroller').slimScroll({
            scrollTo: getLastPostPos()
        });*/
    }
</script>
