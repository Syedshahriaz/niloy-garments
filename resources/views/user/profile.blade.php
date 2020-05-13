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
                                <img src="../../assets/layouts/layout/img/photo3.jpg" class="img-responsive" alt="">
                            </div>
                            <!-- END SIDEBAR USERPIC -->
                            <!-- SIDEBAR USER TITLE -->
                            <div class="profile-usertitle">
                                <div class="profile-usertitle-name"> {{$user->first_name." ".$user->last_name}} </div>
                            </div>
                            <!-- END SIDEBAR USER TITLE -->
                            <!-- SIDEBAR BUTTONS -->
                            <div class="profile-userbuttons">
                                <a href="{{url('profile-edit')}}" class="btn blue btn-sm">Update Info</a>
                                <a href="{{url('reset-password')}}" class="btn red btn-sm">Reset password</a>
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
                                        <div class="user-info">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h5 class="mb-0"><b>User Name</b></h5>
                                                    <p>{{$user->first_name." ".$user->last_name}}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <h5 class="mb-0"><b>Gender</b></h5>
                                                    <p>{{$user->gender}}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <h5 class="mb-0"><b>Phone Number</b></h5>
                                                    <p>{{$user->phone}}</p>
                                                </div>

                                                <div class="col-md-6">
                                                    <h5 class="mb-0"><b>Email Address</b></h5>
                                                    <p>{{$user->email}}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <h5 class="mb-0"><b>Shipping Date</b></h5>
                                                    @if($user->shipment_date !='')
                                                        <p>{{date('l d, M, Y', strtotime($user->shipment_date))}}</p>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
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

    </script>
@endsection

