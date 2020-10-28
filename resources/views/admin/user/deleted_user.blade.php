@extends('layouts.admin_master')
@section('title', 'All User')
@section('content')

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN PAGE BAR -->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{url('/admin')}}">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Deleted Users</span>
                    </li>
                </ul>
                <div class="page-toolbar">
                </div>
            </div>

            <!-- BEGIN PAGE TITLE-->
            <!-- <h3 class="page-title"> Projects
                <small>dashboard &amp; statistics</small>
            </h3> -->
            <!-- END PAGE TITLE-->
            <!-- END PAGE BAR -->
            <!-- END PAGE HEADER-->

            <div class="row mt-3">
                <div class="col-md-12 col-sm-12">
                    <!-- BEGIN PORTLET-->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-share font-red-sunglo hide"></i>
                                <span class="caption-subject font-dark bold uppercase">Deleted users</span>
                                <span class="caption-helper"></span>
                            </div>
                            <div class="actions hidden" id="action_buttons">
                                {{--<button type="button" class="btn btn-transparent theme-btn btn-circle btn-sm" title="Send All Email" id="send_email_all">Send All Email</button>
                                <button type="button" class="btn btn-transparent theme-btn btn-circle btn-sm" title="Send All SMS" id="send_sms_all">Send SMS to User</button>--}}
                                <button type="button" class="btn btn-transparent theme-btn btn-circle btn-sm" title="Restore Users" id="restore_user_all">Restore Users</button>
                            </div>
                            {{--<button type="button" class="btn btn-transparent theme-btn btn-circle btn-sm custom-sms" title="Send Custom SMS" id="send_sms_custom">Send Custom SMS</button>--}}
                        </div>
                        <div class="portlet-body p-relative">
                            <table id="user_list_table" class="table table-striped table-bordered table-hover data-table focus-table">
                                <thead>
                                <tr>
                                    <th style="width: 50px;">
                                        <div class="form-group">
                                            <label class="mt-checkbox">
                                                <input type="checkbox" class="show-password" name="all_user" id="selectall">
                                                <span></span>
                                            </label>
                                        </div>
                                    </th>
                                    <th>User ID</th>
                                    <th>Username</th>
                                    <th>User Email</th>
                                    <th>Payment Status</th>
                                    <th>Birth Date</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach($users as $user){
                                $user_projects = $user->projects;
                                $passed = 0;
                                $upcoming = 0;
                                $test = '';
                                $last = '';
                                if(!empty($user_projects)){
                                    foreach($user_projects as $u_project){
                                        if(!empty($u_project->passed_task)){
                                            $passed = 1;
                                        }
                                    }

                                    foreach($user_projects as $u_project){
                                        if(!empty($u_project->recent_due_task)){
                                            $upcoming = 1;
                                        }
                                    }
                                }
                                ?>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label class="mt-checkbox">
                                                <input type="checkbox" class="show-password name user_checkbox" name="all_user" value="{{$user->id}}" id="checkbox-1-{{$user->id}}">
                                                <span></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>{{$user->unique_id}}</td>
                                    <td>{{$user->username}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->status}}</td>
                                    <td style="min-width: 170px;">
                                        @if($user->shipment_date !='')
                                            {{date('l d, M, Y', strtotime($user->shipment_date))}}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <!-- If Task done-->
                                    {{--<div class="user-status bg-success"></div>--}}
                                    <!-- If Task not done-->
                                        @if($passed==1)
                                            <div class="user-status bg-danger"></div>
                                        @endif
                                        @if($upcoming==1)
                                        <!-- If Task 7days before-->
                                            <div class="user-status bg-warning">
                                                <img class="action-icon" src="{{asset('assets/global/img/icons/tick.png')}}" alt="SMS Sent">
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center" style="min-width: 170px;">
                                        <a href="#" title="Restore User" id="restore_user" onclick="user_status_update_warning({{$user->id}},'active')">
                                            <img class="action-icon" src="{{asset('assets/global/img/icons/restore.jpg')}}" alt="Restore">
                                        </a>
                                        <a href="#" title="Delete User Permanently" id="delete_user" onclick="user_delete_warning({{$user->id}})">
                                            <img class="action-icon" src="{{asset('assets/global/img/icons/trash.png')}}" alt="Delete User">
                                        </a>
                                    </td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END PORTLET-->
                </div>
            </div>

        </div>
        <!-- END CONTENT BODY -->
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // $('#user_list_table').DataTable({
            //     //"paging":   true,
            //     //"ordering": true,
            //     //"info":     true,
            //     //"searching": true
            // });
            $(function() {
                var table = $('#user_list_table').DataTable({
                    "columnDefs": [
                        {
                            "targets": [ 4 ],
                            "visible": false
                        }
                    ]
                });
                $('#payment_check').on( 'change', function () {
                    var select_val = $(this).val();
                    table
                        .columns(4)
                        .search(select_val)
                        .draw();
                });
            });
        });

        $(document).on('click','.offer-option-item',function(){
            $('.offer-item').removeClass('selected-offer')
            $(this).parent('.offer-item').addClass('selected-offer');
            $(this).children('input[type="radio"]').prop('checked',true);
        });

        $(document).ready(function() {
            $('#email_message').summernote({
                height: 130,
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    //['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });


        /* checkbox select all*/

        $('#selectall').on('change', function () {
            $('.name').prop('checked', $(this).prop("checked"));
            if($('.name:checked').length > 0){
                $("#action_buttons").removeClass("hidden");
            }
            else{
                $("#action_buttons").addClass("hidden");
            }
        });

        $('.name').on("click", function () {
            if ($('.name:checked').length == $('.name').length) {
                $('#selectall').prop('checked', true);
            } else {
                $('#selectall').prop('checked', false);
            }

            if($('.name:checked').length > 0){
                $("#action_buttons").removeClass("hidden");
            }
            else{
                $("#action_buttons").addClass("hidden");
            }
        });


        function checkAll(){
            selectedAllValue = [];
            $('input[name="user_id[]"]:checked').each(function () {
                selectedAllValue.push(this.value);
            });
            if (selectedAllValue.length == 0) {
                $("#action_buttons").addClass("hidden");
            } else {
                $("#action_buttons").removeClass("hidden");
            }
        }

        $(document).on('click','#send_email_all',function(){
            var userIDs = $(".user_checkbox:checked").map(function(){
                return $(this).val();
            }).get();

            $('#user_id').val(userIDs);
            $('#subject').val('');
            $("#email_message").summernote("code", "");
            $("#send_email_modal").modal('show');
        });

        $(document).on('click','#send_sms_all',function(){
            var userIDs = $(".user_checkbox:checked").map(function(){
                return $(this).val();
            }).get();

            $('#sms_type').val('bulk');
            $('#sms_user_id').val(userIDs);
            $('#telephone02').val('');
            $('#sms_message').val('');
            $('#telephone_area').addClass('hidden');
            $("#send_sms_modal").modal('show');
        });

        $(document).on('click','#send_sms_custom',function(){
            $('#sms_type').val('single');
            $('#sms_user_id').val('');
            $('#telephone02').val('');
            $('#sms_message').val('');
            $('#telephone_area').removeClass('hidden');
            $("#send_sms_modal").modal('show');
        });

        $(document).on('click','#restore_user_all',function(){
            var userIDs = $(".user_checkbox:checked").map(function(){
                return $(this).val();
            }).get();

            user_status_update_warning(userIDs,'active');
        });

        function user_status_update_warning(user_id,status){
            $(".warning_message").text('Are you sure you want to '+status+' this users?');
            $("#warning_modal").modal('show');
            $('#item_id').val(user_id);
            $('#item_type').val(status);
        }

        function user_delete_warning(user_id){
            $(".warning_message").text('Are you sure you want to delete this users permanently? This can not be undone.');
            $("#warning_modal").modal('show');
            $('#item_id').val(user_id);
            $('#item_type').val('delete');
        }

        $(document).on('click','#warning_ok',function() {
            var user_id = $('#item_id').val();
            var status = $('#item_type').val();

            if(status=='delete'){
                delete_user_permanently(user_id);
            }
            else{
                update_user_status(user_id,status);
            }

        });

        function update_user_status(user_id,status){
            var options = {
                theme:"sk-cube-grid",
                message:'Please wait while saving all data.....',
                backgroundColor:"#1847B1",
                textColor:"white"
            };

            HoldOn.open(options);

            var url = "{{ url('admin/update_user_status')}}";
            $.ajax({
                type: "POST",
                url: url,
                data: {user_id:user_id,status:status,'_token':'{{ csrf_token() }}'},
                success: function (data) {
                    HoldOn.close();

                    if(data.status == 200){
                        $('#warning_modal').modal('hide');
                        //show_success_message('User Successfully '+status);
                        location.reload();
                    }
                    else if(data.status == 402){
                        show_error_message(data.reason);
                        setTimeout(function(){
                            window.location.href="{{url('login')}}";
                        },2000);
                    }
                    else{
                        HoldOn.close();
                        show_error_message(data);
                    }
                },
                error: function (data) {
                    HoldOn.close();
                    show_error_message('Authentication failed. Login again.');
                    setTimeout(function(){
                        //window.location.href="{{url('login')}}";
                    },2000);
                }
            });
        }

        function delete_user_permanently(user_id){
            var options = {
                theme:"sk-cube-grid",
                message:'Please wait while deleting all data.....',
                backgroundColor:"#1847B1",
                textColor:"white"
            };

            HoldOn.open(options);

            var url = "{{ url('admin/delete_user_permanently')}}";
            $.ajax({
                type: "POST",
                url: url,
                data: {user_id:user_id,'_token':'{{ csrf_token() }}'},
                success: function (data) {
                    HoldOn.close();

                    if(data.status == 200){
                        $('#warning_modal').modal('hide');
                        location.reload();
                    }
                    else if(data.status == 402){
                        show_error_message(data.reason);
                        setTimeout(function(){
                            window.location.href="{{url('login')}}";
                        },2000);
                    }
                    else{
                        HoldOn.close();
                        show_error_message(data);
                    }
                },
                error: function (data) {
                    HoldOn.close();
                    show_error_message('Authentication failed. Login again.');
                    setTimeout(function(){
                        //window.location.href="{{url('login')}}";
                    },2000);
                }
            });
        }

        function send_email(user_id){
            $('#user_id').val(user_id);
            $('#subject').val('');
            $("#email_message").summernote("code", "");
            $("#send_email_modal").modal('show');
        }

        $(document).on("click", "#send_email", function(event) {
            event.preventDefault();

            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while sending email.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);

            var subject = $("#subject").val();
            var message = $("#email_message").val();
            var re = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            var validate = "";

            if (subject.trim() == "") {
                validate = validate + "Subject is required</br>";
            }
            if (message.trim() == "") {
                validate = validate + "Message is required</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#email_form")[0]);
                var url = "{{ url('admin/send_user_email') }}";

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
                                location.reload();
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

        function send_sms(user_id,country_code,phone){
            $('#sms_type').val('single');
            $('#sms_user_id').val(user_id);
            $('#telephone_area').removeClass('hidden');
            $('#telephone02').val(phone);
            $('#sms_message').val('');
            $("#send_sms_modal").modal('show');
        }

        $(document).on("click", "#send_sms", function(event) {
            event.preventDefault();

            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while sending sms.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);

            var sms_type = $('#sms_type').val();
            var phone = $("#telephone02").val();
            var message = $("#sms_message").val();
            var re = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            var validate = "";

            if (sms_type == "single" && phone.trim() == "") { // Phone validation fo single sms
                validate = validate + "Phone is required</br>";
            }
            if (message.trim() == "") {
                validate = validate + "Message is required</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#sms_form")[0]);
                var url = "{{ url('admin/send_user_sms') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(data) {
                        HoldOn.close();
                        if (data.status == 200) {
                            $("#sms_success_message").show();
                            $("#sms_error_message").hide();
                            $("#sms_success_message").html(data.reason);
                            setTimeout(function(){
                                location.reload();
                            },2000)
                        } else {
                            $("#sms_success_message").hide();
                            $("#sms_error_message").show();
                            $("#sms_error_message").html(data.reason);
                        }
                    },
                    error: function(data) {
                        HoldOn.close();
                        $("#sms_success_message").hide();
                        $("#sms_error_message").show();
                        $("#sms_error_message").html(data);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            } else {
                HoldOn.close();
                $("#sms_success_message").hide();
                $("#sms_error_message").show();
                $("#sms_error_message").html(validate);
            }
        });

        function send_message(user_id,message_id){
            $('#message_user_id').val(user_id);
            $('#message_id').val(message_id);
            $('#message').val('');
            $('#image_upload_input').val('');
            $("#send_message_modal").modal('show');
        }

        $(document).on("click", "#send_message", function(event) {
            event.preventDefault();

            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while sending email.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);
            var user_id = $("#user_id").val();
            var message = $("#message").val();
            var message_file = $("#image_upload_input").val();

            var validate = "";

            if (message.trim() == "" && message_file=='') {
                validate = validate + "You did not enter any message or file</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#message_form")[0]);
                var url = "{{ url('admin/store_message') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(data) {
                        HoldOn.close();
                        if (data.status == 200) {
                            window.location.href="{{url('admin/message')}}";
                        } else {
                            $("#message_success_message").hide();
                            $("#message_error_message").show();
                            $("#message_error_message").html(data.reason);
                        }
                    },
                    error: function(data) {
                        $("#message_success_message").hide();
                        $("#message_error_message").show();
                        $("#message_error_message").html(data);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            } else {
                HoldOn.close();
                $("#message_success_message").hide();
                $("#message_error_message").show();
                $("#message_error_message").html(validate);
            }
        });

        function change_offer(user_id){
            $('#offer_user_id').val(user_id);
            $("#offer_success_message").hide();
            $("#offer_error_message").hide();
            $("#change_offer_modal").modal('show');
        }

        $(document).on("click", "#update_offer", function(event) {
            event.preventDefault();

            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while sending email.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);

            var offer = $("input[name='offer']:checked").val();

            var validate = "";

            if (offer ===undefined || offer.trim() == "") {
                validate = validate + "Offer is required</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#offer_form")[0]);
                var url = "{{ url('admin/update_user_offer') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(data) {
                        HoldOn.close();
                        if (data.status == 200) {
                            $("#change_offer_modal").modal('hide');
                        } else {
                            $("#offer_success_message").hide();
                            $("#offer_error_message").show();
                            $("#offer_error_message").html(data.reason);
                        }
                    },
                    error: function(data) {
                        HoldOn.close();
                        $("#offer_success_message").hide();
                        $("#offer_error_message").show();
                        $("#offer_error_message").html(data);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            } else {
                HoldOn.close();
                $("#offer_success_message").hide();
                $("#offer_error_message").show();
                $("#offer_error_message").html(validate);
            }
        });

        function unlock_shipping_date(user_id){
            $('#unlock_user_id').val(user_id);
            $("#unlock_shipping_modal").modal('show');
        }

        $(document).on("click", "#unlock_shipping", function(event) {
            event.preventDefault();

            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while sending email.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);

            var user_id = $('#unlock_user_id').val();

            var validate = "";

            if (validate == "") {
                var url = "{{ url('admin/unlock_shipping_date') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: {user_id:user_id,'_token':'{{ csrf_token() }}'},
                    success: function(data) {
                        HoldOn.close();
                        if (data.status == 200) {
                            $("#unlock_shipping_modal").modal('hide');
                            //show_success_message(data.reason);
                        } else {
                            show_error_message('Something went wrong. TRy again later');
                        }
                    },
                    error: function(data) {
                        HoldOn.close();
                        show_error_message('Something went wrong. Try again later');
                    }
                });
            } else {
                HoldOn.close();
                show_error_message('Something went wrong. Try again later');
            }
        });

        function unlock_user_gender(user_id){
            $('#unlock_gender_user_id').val(user_id);
            $("#unlock_user_gender_modal").modal('show');
        }

        $(document).on("click", "#unlock_gender", function(event) {
            event.preventDefault();

            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while sending email.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);

            var user_id = $('#unlock_gender_user_id').val();

            var validate = "";

            if (validate == "") {
                var url = "{{ url('admin/unlock_user_gender') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: {user_id:user_id,'_token':'{{ csrf_token() }}'},
                    success: function(data) {
                        HoldOn.close();
                        if (data.status == 200) {
                            $("#unlock_user_gender_modal").modal('hide');
                            //show_success_message(data.reason);
                        } else {
                            show_error_message('Something went wrong. Try again later');
                        }
                    },
                    error: function(data) {
                        HoldOn.close();
                        show_error_message('Something went wrong. TRy again later');
                    }
                });
            } else {
                HoldOn.close();
                show_error_message('Something went wrong. Try again later');
            }
        });

    </script>
@endsection

