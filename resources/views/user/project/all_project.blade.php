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
                        <span>All Projects</span>
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
                                <span class="caption-subject font-dark bold uppercase">All projects</span>
                                <span class="caption-helper">Select to add project</span>
                            </div>
                            <div class="actions">

                            </div>
                        </div>
                        <div class="portlet-body">
                            <form id="project_form" method="post" action="">
                                {{csrf_field()}}

                                <div class="alert alert-success" id="success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="error_message" style="display: none"></div>
                                <div class="row">
                                    <?php
                                    foreach($projects as $project){
                                    ?>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                        <div class="dashboard-stat2 project-item">
                                            <div class="display">
                                                <div class="number">
                                                    <h5 class="font-theme project-item-name">
                                                        {{$project->name}}
                                                    </h5>
                                                </div>
                                                <div class="icon">
                                                    <i class="icon-check"></i>
                                                </div>
                                            </div>
                                            <div class="progress-info">
                                                <div class="progress">
                                                    <span style="width: 100%;" class="progress-bar theme-bg"></span>
                                                </div>
                                                <div class="status">
                                                    <div class="status-title"> Due Date </div>
                                                    <div class="status-number"> Wed Jun 20, 2020 </div>
                                                    <input type="hidden" name="start_dates[]" value="2020-05-18">
                                                </div>
                                            </div>
                                            <input type="hidden" class="project-item-check" name="project_check[]" value="0">
                                            <input type="hidden" class="project-item-id" name="project_id[]" value="{{$project->id}}">
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn green">Add Selected Project</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- END PORTLET-->
                </div>
            </div>

        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
@endsection

@section('js')
    <script>
        $(document).on("submit", "#project_form", function(event) {
            event.preventDefault();

            var validate = "";

            if (validate == "") {
                var formData = new FormData($("#project_form")[0]);
                var url = "{{ url('add_project') }}";

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
                                window.location.href = "{{ url('my_project') }}";
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

