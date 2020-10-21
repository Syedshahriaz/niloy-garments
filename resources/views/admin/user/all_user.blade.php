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
                                @if(App\Common::can_access('send_email'))
                                    <button type="button" class="btn btn-transparent theme-btn btn-circle btn-sm" title="Send All Email" id="send_email_all">Send All Email</button>
                                @endif
                                @if(App\Common::can_access('send_sms'))
                                    <button type="button" class="btn btn-transparent theme-btn btn-circle btn-sm" title="Send All SMS" id="send_sms_all">Send SMS to User</button>
                                @endif
                                @if(App\Common::can_access('delete_user'))
                                    <button type="button" class="btn btn-transparent theme-btn btn-circle btn-sm" title="Remove Users" id="delete_user_all">Delete Users</button>
                                @endif
                            </div>
                            @if(App\Common::can_access('custom_sms'))
                                <button type="button" class="btn btn-transparent theme-btn btn-circle btn-sm custom-sms" title="Send Custom SMS" id="send_sms_custom">Send Custom SMS</button>
                            @endif
                        </div>
                        <div class="portlet-body p-relative">
                            <div class="all_user_sort">
                                <select class="form-control" id="payment_check">
                                    <option value="">Sort by payment Status</option>
                                    <option value="active">Paid</option>
                                    <option value="pending">Unpaid</option>
                                </select>
                            </div>
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
                                            @if(App\Common::can_access('user_dashboard'))
                                                <a href="{{url('admin/user_dashboard').'?u_id='.$user->id}}" title="User Dashboard">
                                                    <img class="action-icon" src="{{asset('assets/global/img/icons/speed.png')}}" alt="Dashboard">
                                                </a>
                                            @endif
                                            @if(App\Common::can_access('change_offer'))
                                                <a href="#" title="Change Offer" onclick="change_offer({{$user->id}})">
                                                    <img class="action-icon" src="{{asset('assets/global/img/icons/offer.png')}}" alt="Change Offer">
                                                </a>
                                            @endif
                                            @if(App\Common::can_access('unlock_birth_date'))
                                                <a href="#" title="Unlock Birth Date" onclick="unlock_birth_date({{$user->id}})">
                                                    <img class="action-icon" src="{{asset('assets/global/img/icons/date_unlock.png')}}" alt="Change Offer">
                                                </a>
                                            @endif
                                            @if(App\Common::can_access('unlock_user_gender'))
                                                <a href="#" title="Unlock User Gender" onclick="unlock_user_gender({{$user->id}})">
                                                    <img class="action-icon" src="{{asset('assets/global/img/icons/gender.png')}}" alt="Change Offer">
                                                </a>
                                                @endif
                                            @if(App\Common::can_access('send_email'))
                                                <a href="#" title="Send Email" onclick="send_email({{$user->id}})">
                                                    <img class="action-icon" src="{{asset('assets/global/img/icons/mail.png')}}" alt="Email">
                                                </a>
                                            @endif
                                            @if(App\Common::can_access('send_sms'))
                                                <a href="#" title="Send SMS" onclick="send_sms({{$user->id}},'{{$user->country_code}}','{{$user->phone}}')">
                                                    <img class="action-icon" src="{{asset('assets/global/img/icons/sms.png')}}" alt="Email">
                                                </a>
                                            @endif
                                            @if(App\Common::can_access('send_message'))
                                                <a href="#" title="Send Message" onclick="send_message({{$user->id}},{{$user->message_id}})">
                                                    <img class="action-icon" src="{{asset('assets/global/img/icons/message.png')}}" alt="Email">
                                                </a>
                                            @endif
                                            @if(App\Common::can_access('delete_user'))
                                                <a href="#" title="Remove User" id="remove_user" onclick="user_status_update_warning({{$user->id}},'deleted')">
                                                    <img class="action-icon" src="{{asset('assets/global/img/icons/trash.png')}}" alt="Email">
                                                </a>
                                            @endif
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Send email</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="email_form" method="post" action="">
                            <div class="col-md-12">
                                <div class="alert alert-success" id="success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="error_message" style="display: none"></div>
                            </div>
                            {{csrf_field()}}
                            <input type="hidden" name="user_id" id="user_id" value="">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Subject</label>
                                    <input class="form-control placeholder-no-fix" type="text" placeholder="Enter email subject*" name="subject" id="subject" value=""  autocomplete="off"/>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Message</label>
                                    <textarea class="form-control placeholder-no-fix" name="message" id="email_message"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn theme-btn pull-right" id="send_email">Send Email</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    <!-- Modal -->
    <div class="modal fade" id="send_sms_modal" tabindex="-1" role="send_sms_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Send SMS</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="sms_form" method="post" action="">
                            <div class="col-md-12">
                                <div class="alert alert-success" id="sms_success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="sms_error_message" style="display: none"></div>
                            </div>
                            {{csrf_field()}}
                            <input type="hidden" name="user_id" id="sms_user_id" value="">
                            <input type="hidden" name="sms_type" id="sms_type" value="">

                            <div class="col-md-12">
                                <div class="form-group" id="telephone_area">
                                    <label class="control-label">Phone*</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" id="phone-addon">+88</span>
                                        <input class="form-control placeholder-no-fix" id="telephone02" type="text" name="phone" placeholder="017********" aria-describedby="phone-addon" onkeyup="this.value=this.value.replace(/[^\d]/,'')" value="" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Message</label>
                                    <textarea class="form-control placeholder-no-fix" rows="6" name="message" id="sms_message"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn theme-btn pull-right" id="send_sms">Send SMS</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="send_message_modal" tabindex="-1" role="send_message_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Send Message</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="message_form" method="post" action="" enctype="multipart/form-data">
                            <div class="col-md-12">
                                <div class="alert alert-success" id="message_success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="message_error_message" style="display: none"></div>
                            </div>
                            {{csrf_field()}}
                            <input type="hidden" name="user_id" id="message_user_id" value="">
                            <input type="hidden" name="message_id" id="message_id" value="">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Message</label>
                                    <textarea class="form-control placeholder-no-fix" name="message" id="message"></textarea>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">File</label>
                                    <input class="form-control placeholder-no-fix" type="file" name="message_file" id="image_upload_input" value=""  autocomplete="off"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn theme-btn pull-right" id="send_message">Send Message</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- END CONTENT -->

    <!-- Modal -->
    <div class="modal fade" id="change_offer_modal" tabindex="-1" role="change_offer_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Change offer</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="offer_form" method="post" action="">
                            <div class="col-md-12">
                                <div class="alert alert-success" id="offer_success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="offer_error_message" style="display: none"></div>
                            </div>
                            {{csrf_field()}}
                            <input type="hidden" name="user_id" id="offer_user_id" value="">

                            <div class="col-md-12">
                                <div class="admin_offer_change">
                                    <label class="text-center" for=""><b>Choose Offer</b></label>
                                    <div class="offer-itemlist">
                                        <div class="offer-item">
                                            <div class="offer-option-item green-offer-option">
                                                <p>Green</p>
                                                <input type="radio" name="offer" value="1" hidden="">
                                            </div>
                                        </div>
                                        <div class="offer-item">
                                            <div class="offer-option-item red-offer-option">
                                                <p>Red</p>
                                                <input type="radio" name="offer" value="2" hidden="">
                                            </div>
                                        </div>
                                        <div class="offer-item">
                                            <div class="offer-option-item pink-offer-option">
                                                <p>{{$offer->offer3_name}}</p>
                                                <input type="radio" name="offer_3" value="3" disabled="" hidden="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn theme-btn" id="update_offer">Update</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- END CONTENT -->

    <!-- Modal -->
    <div class="modal fade" id="unlock_shipping_modal" tabindex="-1" role="unlock_shipping_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Unlock Birth Date</h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="text-align:center;">
                        <input type="hidden" name="user_id" id="unlock_user_id" value="">
                        <h4>Are you sure you want to unlock this user's birth date update?</h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="button" class="btn theme-btn" id="unlock_shipping">Yes</button>
                        <button type="button" class="btn" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- END CONTENT -->
    <!-- Modal -->
    <div class="modal fade" id="unlock_user_gender_modal" tabindex="-1" role="unlock_user_gender_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Unlock User Gender</h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="text-align:center;">
                        <input type="hidden" name="user_id" id="unlock_gender_user_id" value="">
                        <h4>Are you sure you want to unlock this user's gender update?</h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="button" class="btn theme-btn" id="unlock_gender">Yes</button>
                        <button type="button" class="btn" data-dismiss="modal">No</button>
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

        function unlock_birth_date(user_id){
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
                var url = "{{ url('admin/unlock_birth_date') }}";

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

