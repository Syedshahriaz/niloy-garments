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
                        <a href="{{url('/home')}}">Home</a>
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
                        <h4 class="modal-title text-center font-theme uppercase" id="select_ship_dateLabel">Welcome</h4>
                    </div>

                    <form id="shipment_form" method="post" action="">
                        <div class="modal-body">
                                {{csrf_field()}}
                                <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}">

                                <div class="alert alert-success" id="success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="error_message" style="display: none"></div>

                                <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                                        <div class="form-group">
                                            <label for=""><b>Shipping Date</b></label>
                                            <input class="form-control date-picker" size="16" type="text" name="shipment_date" id="shipment_date" value="" placeholder="Select Shipping Date"/>
                                            <input class="date-picker-hidden" type="hidden"/>   
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-md-offset-1">
                                        <div class="form-group">
                                            <label for=""><b>Gender</b></label>
                                            <select name="gender" id="gender" name="user-info-gender" class="form-control">
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn theme-btn">Done</button>
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
        $(document).on("submit", "#shipment_form", function(event) {
            event.preventDefault();

            var shipment_date = $("#shipment_date").val();

            var validate = "";

            if (shipment_date.trim() == "") {
                validate = validate + "Shipment date is required</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#shipment_form")[0]);
                var url = "{{ url('store_shipment') }}";

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
                                window.location.href="{{url('all_project')}}";
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

