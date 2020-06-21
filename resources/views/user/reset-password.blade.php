@extends('layouts.master')
@section('title', 'Reset Password')
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
                        <a class=" ajax_item item-5" href="{{url('profile')}}" data-name="profile" data-item="5">Profile</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Reset Password</span>
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
                <div class="col-md-6 col-md-offset-3">
                    <!-- BEGIN PROFILE CONTENT -->
                    <div class="profile-content">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN PORTLET -->
                                <div class="portlet light ">
                                    <div class="portlet-title">
                                        <div class="caption caption-md">
                                            <i class="icon-bar-chart theme-font hide"></i>
                                            <span class="caption-subject font-blue-madison bold uppercase">Reset Password</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                    <form id="reset_password_form" method="post" action="">
                                        {{csrf_field()}}
                                        <input type="hidden" name="user_id" id="user-id" value="{{$user->id}}">

                                        <div class="alert alert-success" id="success_message" style="display:none"></div>
                                        <div class="alert alert-danger" id="error_message" style="display: none"></div>

                                        <div class="form-group">
                                            <label for=""><b>New password</b></label>
                                            <input type="password" class="form-control password-field" name="password" id="password" value="">
                                        </div>

                                        <div class="form-group">
                                            <label for=""><b>Confirm password</b></label>
                                            <input type="password" class="form-control password-field" name="confirm_password" id="confirm_password" value="">
                                        </div>
                                        <div class="form-group margin-top-20 margin-bottom-20">
                                            <label class="mt-checkbox mt-checkbox-outline mb-0">
                                                <input type="checkbox" class="show-password" name="show_password" /> Show password
                                                <span></span>
                                            </label>
                                        </div>

                                        <div class="form-group text-right">
                                            <button type="submit" class="btn green">Reset</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                                <!-- END PORTLET -->
                            </div>
                        </div>
                    </div>
                    <!-- END PROFILE CONTENT -->
                </div>
            </div>

        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
@endsection

@section('js')
    <!-- Scripts for registration START-->
    <script>
        $(document).ready(function(){

        });


    </script>
    <!-- Scripts for registration END-->
@endsection

