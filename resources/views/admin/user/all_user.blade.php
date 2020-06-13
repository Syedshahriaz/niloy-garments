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
                        <span>All Users</span>
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
                                <span class="caption-subject font-dark bold uppercase">All users</span>
                                <span class="caption-helper"></span>
                            </div>
                            <div class="actions hidden" id="action_buttons">
                               <button type="button" class="btn btn-transparent theme-btn btn-circle btn-sm" title="Send Email" id="send_email_all">Send Email</button>
                               <button type="button" class="btn btn-transparent theme-btn btn-circle btn-sm" title="Remove Users" id="delete_user_all">Delete Users</button>
                            </div>
                        </div>
                        <div class="portlet-body">
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
                                        <th>Shipment Date</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach($users as $user){ ?>
                                    <tr>
                                        <td style="width: 50px;">
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
                                        <td>
                                            @if($user->shipment_date !='')
                                                {{date('l d, M, Y', strtotime($user->shipment_date))}}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <!-- If Task 7days before-->
                                            <div class="user-status bg-warning">
                                                <img class="action-icon" src="{{asset('assets/global/img/icons/tick.png')}}" alt="SMS Sent">
                                            </div>
                                            <!-- If Task done-->
                                            <div class="user-status bg-success"></div>
                                            <!-- If Task not done-->
                                            <div class="user-status bg-danger"></div>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{url('admin/user_dashboard').'?u_id='.$user->id}}" title="User Dashboard">
                                                <img class="action-icon" src="{{asset('assets/global/img/icons/meter.png')}}" alt="Dashboard">
                                            </a>
                                            <a href="#" title="Send Email" onclick="send_email({{$user->id}})">
                                                <img class="action-icon" src="{{asset('assets/global/img/icons/mail.png')}}" alt="Email">
                                            </a>
                                            <a href="#" title="Remove User" id="remove_user" onclick="user_status_update_warning({{$user->id}},'deleted')">
                                                <img class="action-icon" src="{{asset('assets/global/img/icons/trash.png')}}" alt="Email">
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

    <!-- Modal -->
    <div class="modal fade" id="send_email_modal" tabindex="-1" role="send_email_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Send email</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="email_form" method="post" action="">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="alert alert-success" id="success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="error_message" style="display: none"></div>
                            </div>
                            {{csrf_field()}}
                            <input type="hidden" name="user_id" id="user_id" value="">

                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label class="control-label">Subject</label>
                                    <input class="form-control placeholder-no-fix" type="text" placeholder="Enter email subject*" name="subject" id="subject" value=""  autocomplete="off"/>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Message</label>
                                    <textarea class="form-control placeholder-no-fix" name="message" id="message"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn theme-btn" id="send_email">Send</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- END CONTENT -->

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#user_list_table').DataTable({
                //"paging":   true,
                //"ordering": true,
                //"info":     true,
                //"searching": true
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
            $("#send_email_modal").modal('show');
        });

        $(document).on('click','#delete_user_all',function(){
            var userIDs = $(".user_checkbox:checked").map(function(){
                return $(this).val();
            }).get();

            user_status_update_warning(userIDs,'deleted');
        });

        function user_status_update_warning(user_id,status){
            $(".warning_message").text('Are you sure you want to '+status+' this users? This can not be undone in future.');
            $("#warning_modal").modal('show');
            $('#item_id').val(user_id);
            $('#item_type').val(status);
        }

        $(document).on('click','#warning_ok',function() {
            var user_id = $('#item_id').val();
            var status = $('#item_type').val();

            update_user_status(user_id,status);
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
                        show_success_message('User Successfully '+status);
                        setTimeout(function(){
                            location.reload();
                        },2000);
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
            var message = $("#message").val();
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

    </script>
@endsection

