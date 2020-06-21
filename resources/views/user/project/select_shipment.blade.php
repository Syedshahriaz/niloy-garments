@extends('layouts.master')
@section('title', 'Select Shipment')
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
                        <span>Select Shipment</span>
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
                                <span class="caption-subject font-dark bold uppercase">Select Shipment</span>
                                <span class="caption-helper"></span>
                            </div>
                            <div class="actions">

                            </div>
                        </div>
                        <div class="portlet-body">

                        </div>
                    </div>
                    <!-- END PORTLET-->
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="select_ship_date" tabindex="-1" role="dialog" aria-labelledby="select_ship_dateLabel" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center font-theme uppercase" id="select_ship_dateLabel">Welcome {{$user->username}}</h4>
                    </div>

                    <form id="shipment_form" method="post" action="">
                        <div class="modal-body">
                                {{csrf_field()}}
                                <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}">

                                <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                                        <div class="alert alert-success" id="success_message" style="display:none"></div>
                                        <div class="alert alert-danger" id="error_message" style="display: none"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                                        <div class="form-group">
                                            <label for=""><b>Shipping Date for {{$user->username}}</b></label>
                                            <input class="form-control date-picker" size="16" type="text" name="" id="shipment_date" value="" placeholder="Select Shipping Date"/>
                                            <input class="date-picker-hidden" type="hidden" name="shipment_date"/>
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-md-offset-1">
                                        <div class="form-group">
                                            <label for=""><b>Gender</b></label>
                                            <select name="gender" id="gender" class="form-control">
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-md-offset-1">
                                        <div class="form-group">
                                            <input type="radio" name="offer" value="1"> Offer 1 <br>
                                            <input type="radio" name="offer" value="2"> Offer 2 <br>
                                            <input type="radio" name="offer_3" value="3" disabled> Offer 3
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn theme-btn" id="done_button">Done</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>

        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
@endsection

@section('js')
    <script type="text/javascript">

    </script>
@endsection

