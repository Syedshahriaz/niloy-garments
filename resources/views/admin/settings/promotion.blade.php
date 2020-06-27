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
                            <form id="" class="register-form" action="" method="post">
                                {{csrf_field()}}

                                <div class="alert alert-success" id="success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="error_message" style="display: none"></div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Offer name</label>
                                            <input type="text" class="form-control" value="Green Offer">
                                        </div>
                                        <div class="form-group">
                                            <label>Offer Details</label>
                                            <textarea name="" id="" cols="30" rows="4" class="form-control offer-text"></textarea>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Offer name</label>
                                            <input type="text" class="form-control" value="Red Offer">
                                        </div>
                                        <div class="form-group">
                                            <label>Offer Details</label>
                                            <textarea name="" id="" cols="30" rows="4" class="form-control offer-text"></textarea>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Offer name</label>
                                            <input type="text" class="form-control" value="Pink Offer">
                                        </div>
                                        <div class="form-group">
                                            <label>Offer Details</label>
                                            <textarea name="" id="" cols="30" rows="4" class="form-control offer-text"></textarea>
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
    </script>
@endsection

