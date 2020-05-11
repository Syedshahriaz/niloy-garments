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
                        <span>Projects</span>
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
                    <!-- BEGIN PROFILE SIDEBAR -->
                    <div class="profile-sidebar">
                        <!-- PORTLET MAIN -->
                        <div class="portlet light profile-sidebar-portlet ">
                            <!-- SIDEBAR USERPIC -->
                            <div class="profile-userpic">
                                <img src="../../assets/layouts/layout/img/photo3.jpg" id="image" class="img-responsive" alt="user image" style="max-height:150px; max-width:150px;"> </div>
                                <input id="image_change_hidden_btn" type="file" class="hidden">
                            <!-- END SIDEBAR USERPIC -->

                            <!-- SIDEBAR BUTTONS -->
                            <div class="profile-userbuttons">
                                <button id="image_change_btn" type="button" class="btn btn-green green btn-sm">Update Image</a>
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
                                    <form action="">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>User Name</b></label>
                                                    <input type="text" class="form-control" name="user-info-name" value="Marcus Doe">
                                                </div> 
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Gender</b></label>
                                                    <select name="" id="" name="user-info-gender" class="form-control">
                                                        <option value="">Select Gender</option>
                                                        <option value="1">Male</option>
                                                        <option value="2">Female</option>
                                                        <option value="3">Others</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Email Address</b></label>
                                                    <input type="email" class="form-control" name="user-info-email" value="marcus@gmail.com">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Shipping Date</b></label>
                                                    <input class="form-control date-picker" size="16" type="text" value="" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Phone Number</b></label>
                                                    <input type="phone" class="form-control" name="user-info-phone" value="+8801614355552">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group text-right">
                                            <button type="submit" class="btn green btn-sm">Update Info</button>
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
    <script>
        $(document).ready(function(){
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
    </script>
@endsection

