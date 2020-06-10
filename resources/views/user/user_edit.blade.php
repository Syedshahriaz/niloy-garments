@extends('layouts.master')
@section('title', 'Profile Update')
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
                        <span>Profile Update</span>
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
                <div class="col-md-12">
                    <form  id="profile_form" method="post" action="" enctype="multipart/form-data">
                    {{csrf_field()}}
                        <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}">
                        <div class="alert alert-success" id="success_message" style="display:none"></div>
                        <div class="alert alert-danger" id="error_message" style="display: none"></div>
                    <!-- BEGIN PROFILE SIDEBAR -->
                    <div class="profile-sidebar">
                        <!-- PORTLET MAIN -->
                        <div class="portlet light profile-sidebar-portlet ">
                            <!-- SIDEBAR USERPIC -->
                            <div class="profile-userpic">
                                @if($user->photo !='')
                                    <img src="{{asset($user->photo)}}" id="image" class="img-responsive" alt="user image" style="max-height:150px; max-width:150px;">
                                @else
                                    <img src="{{asset('assets/layouts/layout/img/emptyuserphoto.png')}}" id="image" class="img-responsive" alt="user image" style="max-height:150px; max-width:150px;">
                                @endif
                            </div>

                                <input name="photo" id="image_change_hidden_btn" type="file" class="hidden">
                            <!-- END SIDEBAR USERPIC -->

                            <!-- SIDEBAR BUTTONS -->
                            <div class="profile-userbuttons">
                                <button id="image_change_btn" type="button" class="btn blue btn-sm">Update Image</button>
                            </div>
                            <!-- END SIDEBAR BUTTONS -->
                        </div>
                        <!-- END PORTLET MAIN -->
                    </div>
                    <!-- END BEGIN PROFILE SIDEBAR -->
                    <!-- BEGIN PROFILE CONTENT -->
                    <div class="profile-content">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN PORTLET -->
                                <div class="portlet light ">
                                    <div class="portlet-title">
                                        <div class="caption caption-md">
                                            <i class="icon-bar-chart theme-font hide"></i>
                                            <span class="caption-subject font-blue-madison bold uppercase">User Information</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>First Name</b></label>
                                                    <input type="text" class="form-control" name="first_name" id="first_name" value="{{$user->first_name}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Last Name</b></label>
                                                    <input type="text" class="form-control" name="last_name" id="last_name" value="{{$user->last_name}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Username</b></label>
                                                    <input type="text" class="form-control" name="username" id="username" value="{{$user->username}}" disabled >
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Phone Number</b></label>
                                                    <input type="phone" class="form-control" name="phone" id="telephone" value="{{$user->phone}}">
                                                </div>
                                            </div> -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Phone Number</b></label>
                                                    <input type="text" class="form-control" name="phone" id="telephone" onkeyup="this.value=this.value.replace(/[^\d]/,'')" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Gender</b></label>
                                                    <select name="gender" id="gender" class="form-control">
                                                        <option value="Male" @if($user->gender=='Male') selected @endif>Male</option>
                                                        <option value="Female" @if($user->gender=='Female') selected @endif>Female</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Email Address</b></label>
                                                    <input type="email" class="form-control" name="email" id="email" value="{{$user->email}}" disabled>
                                                </div>
                                            </div>
                                            {{--<div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Shipping Date</b></label>
                                                    <input class="form-control date-picker" size="16" type="text" value="" />
                                                </div>
                                            </div>--}}


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Profession</b></label>
                                                    <select name="profession" id="profession" class="form-control">
                                                        <option value="">Select</option>
                                                        @foreach($professions as $profession)
                                                            <option value="{{$profession->id}}" @if($profession->id == $user->profession) selected @endif>{{$profession->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group text-right">
                                            <button type="submit" class="btn green" id="profile_button">Update Info</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- END PORTLET -->
                            </div>
                        </div>
                    </div>
                    <!-- END PROFILE CONTENT -->
                    </form>
                </div>
            </div>

        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->

@endsection

@section('js')
    <script>
        $(document).ready(function(){

            $("#telephone").intlTelInput("setNumber", "{{$user->country_code.$user->phone}}");

            /*
            * Set selected country code in teliphone
            * */
            $(".iti__selected-dial-code").text('{{$user->country_code}}');

            $('#image_change_btn').click(function(){
                $('#image_change_hidden_btn').trigger('click');
            });
            $('#image_change_hidden_btn').change(function(){
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

        });

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
                                location.reload();
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


    </script>
@endsection

