@extends('layouts.admin_master')
@section('title', 'Niloy Garments::Settings')
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
                        <a href="{{url('admin')}}">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Settings</span>
                    </li>
                </ul>
                <div class="page-toolbar">
                </div>
            </div>
            <!-- END PAGE BAR -->

            <!-- END PAGE HEADER-->

            <div class="row mt-3">
                <div class="col-md-12 col-sm-12">
                    <!-- BEGIN PORTLET-->
                    <div class="portlet light ">
                        <div class="portlet-body" style="padding-top: 0;">
                            <form id="setting_form" class="register-form" action="" method="post">
                                {{csrf_field()}}

                                <div class="alert alert-success" id="success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="error_message" style="display: none"></div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Common message to all user</label>
                                            <textarea rows="4" class="form-control placeholder-no-fix summernote" name="message_to_user" id="message_to_user" >{{$settings->message_to_user}}</textarea>
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
        <!-- END CONTENT BODY -->
    </div>

    <!-- END CONTENT -->
@endsection

@section('js')
    <script>
        $(document).ready(function() {

        });
        $(document).on("submit", "#setting_form", function(event) {
            event.preventDefault();

            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while saving all data.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);

            //var username = $("#username").val();

            var validate = "";

            /*if (username.trim() == "") {
                validate = validate + "Username is required</br>";
            }*/

            if (validate == "") {
                var formData = new FormData($("#setting_form")[0]);
                var url = "{{ url('admin/update_settings') }}";

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
                                $("#success_message").hide();
                            },2000);
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

