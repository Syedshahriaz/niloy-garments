@extends('layouts.admin_master')
@section('title', 'Niloy Garments::Promotion Settings')
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
                        <span>Promotion</span>
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
                            <form id="offer_form" class="register-form" action="" method="post">
                                {{csrf_field()}}

                                <div class="alert alert-success" id="success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="error_message" style="display: none"></div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Green Offer</label>
                                            <input type="text" class="form-control" name="offer1_name" id="offer1_name" value="{{$offer->offer1_name}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Offer Details</label>
                                            <textarea cols="30" rows="4" name="offer1_details" id="offer1_details" class="form-control offer-text">{{$offer->offer1_details}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Red Offer</label>
                                            <input type="text" class="form-control" name="offer2_name" id="offer2_name" value="{{$offer->offer2_name}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Offer Details</label>
                                            <textarea cols="30" rows="4" name="offer2_details" id="offer2_details" class="form-control offer-text">{{$offer->offer2_details}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Yellow Offer</label>
                                            <input type="text" class="form-control" name="offer3_name" id="offer3_name" value="{{$offer->offer3_name}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Offer Details</label>
                                            <textarea cols="30" rows="4" name="offer3_details" id="offer3_details" class="form-control offer-text">{{$offer->offer3_details}}</textarea>
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
            $('.offer-text').summernote({
                placeholder: 'Enter offer details',
                height: 100,
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    //['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    //['height', ['height']]
                ]
            });
        });

        $(document).on("submit", "#offer_form", function(event) {
            event.preventDefault();

            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while saving all data.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);

            var offer1_name = $("#offer1_name").val();
            var offer2_name = $("#offer2_name").val();
            var offer3_name = $("#offer3_name").val();

            var validate = "";

            if (offer1_name.trim() == "") {
                validate = validate + "Green offer name is required</br>";
            }
            if (offer2_name.trim() == "") {
                validate = validate + "Red offer name is required</br>";
            }
            if (offer3_name.trim() == "") {
                validate = validate + "Yellow offer name is required</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#offer_form")[0]);
                var url = "{{ url('admin/update_offer') }}";

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

