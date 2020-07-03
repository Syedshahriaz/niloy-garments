@extends('layouts.master')
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
                        <a class=" ajax_item item-1" href="{{url('dashboard')}}" data-name="dashboard" data-item="1">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>All User</span>
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
                                <span class="caption-subject font-dark bold uppercase">All user</span>
                                <span class="caption-helper">Select to separate user</span>
                            </div>
                            <div class="actions">

                            </div>
                        </div>
                        <div class="portlet-body">
                            <table id="user_manage_table" class="table table-striped table-bordered table-hover data-table focus-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Shipment Date</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($users as $user){
                                    ?>
                                    <tr>
                                        <td>{{$user->unique_id}}</td>
                                        <td>{{$user->username}}</td>
                                        <td>
                                            @if($user->shipment_date !='')
                                                {{date('l d, M, Y', strtotime($user->shipment_date))}}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{url('user_details',$user->id)}}" type="button" class="btn blue action-btn ajax_item item-3" data-name="user_details/{{$user->id}}" data-item="3" title="Dashboard" title="Profile"><i class="icon-user"></i> Profile</a>
                                            <button type="button" class="btn green action-btn" title="Send OTP to separate this user" id="send_otp_button_{{$user->id}}" onclick="send_otp({{$user->id}})"><i class="icon-action-redo"></i>
                                                @if($user->otp =='')
                                                    Send OTP
                                                @else
                                                    Send OTP Again
                                                @endif
                                            </button>
                                            <button type="button" class="btn red action-btn @if($user->otp =='') hidden @endif" title="Make Separate" id="make_separate_button_{{$user->id}}" onclick="separate_user({{$user->id}})"><i class="icon-user-unfollow"></i> Make Separate</button>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
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
    <!-- END CONTENT -->

    <!-- Modal -->
    <div class="modal fade" id="user_otp_modal" tabindex="-1" role="select_delivery_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Send OTP</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="user_otp_form" method="post" action="">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="alert alert-success" id="success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="error_message" style="display: none"></div>
                            </div>
                            {{csrf_field()}}
                            <input type="hidden" name="user_id" id="user_id">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="alert alert-danger" role="alert"> <strong><i class="icons icon-info"></i> Warning!</strong> By submitting form, user will get a <strong>24 hours valid OTP.</strong> </div>
                                <div class="form-group">
                                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                                    <label class="control-label">New user email</label>
                                    <input class="form-control placeholder-no-fix" type="text" placeholder="Enter new user email*" name="email" id="email" value=""  autocomplete="off"/>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Your Current Password</label>
                                    <input class="form-control placeholder-no-fix password-field" type="password" autocomplete="off" id="password" placeholder="Enter your current password*" name="password" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Re-type Your Current Password</label>
                                    <input class="form-control placeholder-no-fix password-field" type="password" autocomplete="off" id="repassword" placeholder="Re-type your current password*" name="repassword" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn theme-btn" id="send_otp_button">Submit</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="separate_user_modal" tabindex="-1" role="select_delivery_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">One Time Password(OTP)</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="separate_user_form" method="post" action="">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="alert alert-success" id="separate_success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="separate_error_message" style="display: none"></div>
                            </div>
                            {{csrf_field()}}
                            <input type="hidden" name="user_id" id="separate_user_id">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="alert alert-danger" role="alert"> <strong><i class="icons icon-info"></i> Warning!</strong> By submitting form, this user will be <strong>separated</strong> from your account. You will not be able to access this user anymore. </div>
                                <div class="form-group">
                                    <label class="control-label visible-ie8 visible-ie9">OTP</label>
                                    <input class="form-control placeholder-no-fix password-field" type="password" autocomplete="off" id="otp" placeholder="OTP*" name="otp" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn theme-btn" id="separate_user_button">Submit</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#user_manage_table').DataTable({
                "paging":   true,
                "lengthChange": false,
                "info":     false,
                "searching": true,
            });
        });

    </script>
@endsection

