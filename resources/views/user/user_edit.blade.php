@extends('layouts.master')
@section('title', 'Profile Update')
@section('content')

    <?php
        $from = request('frm');
    ?>

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
                        <a class=" ajax_item item-3" href="{{url('user_list')}}" data-name="user_list" data-item="3">Users</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>User Update</span>
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
                        <input type="hidden" name="from" id="from" value="{{$from}}">
                        <input type="hidden" name="" id="existing_phone" value="{{$user->country_code.$user->phone}}">
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
                                                    <input type="text" class="form-control telephone" name="phone" id="telephone" onkeyup="this.value=this.value.replace(/[^\d]/,'')" value="">
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

                                            <div class="col-md-6" id="shipping_date_area">
                                                <div class="form-group">
                                                    <label for=""><b>Shipping Date</b></label>
                                                    <input class="form-control date-picker" size="16" type="text" name="" id="ship_date" @if($user->shipment_date_update_count!=0) value="{{date('l d, M, Y', strtotime($user->shipment_date))}}" disabled @endif />
                                                    <input class="date-picker-hidden" type="hidden" name="shipment_date" id="shipment_date"/>
                                                    <input class="" type="hidden" name="old_shipment_date" id="old_shipment_date" value="{{$user->shipment_date}}"/>
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
            $(".telephone").intlTelInput("setNumber", "{{$user->country_code.$user->phone}}");
        });



    </script>
@endsection

