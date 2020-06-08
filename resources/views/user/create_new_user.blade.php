@extends('layouts.master')
@section('title', 'Niloy Garments::Dashboard')
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
                        <a href="index.html">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Create User</span>
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

            <div class="profile-content">
                <div class="row mt-3">
                    <div class="col-md-6 col-md-offset-3">
                        <!-- BEGIN PORTLET -->
                        <div class="portlet light ">
                            <div class="portlet-title">
                                <div class="caption caption-md">
                                    <i class="icon-bar-chart theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">New User Information</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <form id="registration_form" class="register-form" action="index.html" method="post">
                                {{csrf_field()}}

                                <div class="alert alert-success" id="success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="error_message" style="display: none"></div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label visible-ie8 visible-ie9">User Name*</label>
                                            <input class="form-control placeholder-no-fix" type="text" placeholder="User Name*" name="username" id="username" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label visible-ie8 visible-ie9">Phone*</label>
                                            <input class="form-control placeholder-no-fix" id="telephone" type="text" name="phone" id="phone" onkeyup="this.value=this.value.replace(/[^\d]/,'')" value="{{$user->phone}}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-actions">
                                            <button type="submit" id="register-submit-btn" class="btn theme-btn uppercase pull-right">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="profile-sidebar">

                    </div>
                </div>
            </div>

            {{--<div class="hidden">
                <form id="select_user_form" class="login-form" action="{{url('multi_tinent')}}" method="post">
                {{csrf_field()}}
                    <div class="form-group">
                        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                        <label class="control-label visible-ie8 visible-ie9">User</label>
                        <input type="hidden" name="user_id" id="user_id">
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn uppercase theme-btn pull-right">Submit</button>
                        <!-- <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a> -->
                    </div>
                </form>
            </div>--}}

        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
@endsection

@section('js')
    <script>
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
    </script>
@endsection

