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
                        <a class=" ajax_item item-1" href="https://vujadetec.com" target="_blank" data-name="dashboard" data-item="1">Home</a>
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
                                            {{--<input class="form-control date-picker" size="16" type="text" name="" id="shipment_date" value="" placeholder="Select Shipping Date"/>
                                            --}}
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <select name="day" id="day" class="form-control">
                                                        <option value="">Day</option>
                                                        @for($i=1; $i<=31; $i++)
                                                            <option value="{{$i}}" @if($i==date('d')) selected @endif>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                </div>

                                                <div class="col-md-4 form-group">
                                                    <select name="month" id="month" class="form-control">
                                                        <option value="">Month</option>
                                                        <option value="1" @if(date('m')==1) selected @endif>Jan</option>
                                                        <option value="2" @if(date('m')==2) selected @endif>Feb</option>
                                                        <option value="3" @if(date('m')==3) selected @endif>Mar</option>
                                                        <option value="4" @if(date('m')==4) selected @endif>Apr</option>
                                                        <option value="5" @if(date('m')==5) selected @endif>May</option>
                                                        <option value="6" @if(date('m')==6) selected @endif>Jun</option>
                                                        <option value="7" @if(date('m')==7) selected @endif>Jul</option>
                                                        <option value="8" @if(date('m')==8) selected @endif>Aug</option>
                                                        <option value="9" @if(date('m')==9) selected @endif>Sep</option>
                                                        <option value="10" @if(date('m')==10) selected @endif>Oct</option>
                                                        <option value="11" @if(date('m')==11) selected @endif>Nov</option>
                                                        <option value="12" @if(date('m')==12) selected @endif>Dec</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-4 form-group">
                                                    <select name="year" id="year" class="form-control">
                                                        <option value="">Year</option>
                                                        @for($i=date('Y'); $i>=1920; $i--)
                                                            <option value="{{$i}}" @if($i==date('Y')) selected @endif>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>

                                            <input class="date-picker-hidden" type="hidden" name="shipment_date" id="shipment_date" value="{{date('Y-m-d')}}"/>
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
                                    {{--<div class="col-md-10 col-md-offset-1">
                                        <div class="form-group">
                                            <label for=""><b>Choose Offer</b></label>
                                            <div class="offer-itemlist">
                                                <div class="offer-item">
                                                    <p>{{$offer->offer1_name}}</p>
                                                    <input type="radio" name="offer" value="1" hidden>
                                                </div>
                                                <div class="offer-item">
                                                    <p>{{$offer->offer2_name}}</p>
                                                    <input type="radio" name="offer" value="2" hidden>
                                                </div>
                                                <div class="offer-item">
                                                    <p>{{$offer->offer3_name}}</p>
                                                    <input type="radio" name="offer_3" value="3" disabled hidden>
                                                </div>
                                            </div>
                                        </div>
                                    </div>--}}
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
        $(document).on('click','.offer-item',function(){
            $('.offer-item').removeClass('selected-offer')
            $(this).addClass('selected-offer');
            $(this).children('input[type="radio"]').prop('checked',true);
        });
    </script>
@endsection

