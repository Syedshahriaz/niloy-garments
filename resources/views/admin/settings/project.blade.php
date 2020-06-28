@extends('layouts.admin_master')
@section('title', 'Niloy Garments::Project Settings')
@section('content')

    <style>
        .table td, .table th {
            position: relative;
        }
    </style>

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
                        <span>Project Settings</span>
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
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-share font-red-sunglo hide"></i>
                                <span class="caption-subject font-dark bold uppercase">Rename peojects & tasks </span>
                                <span class="caption-helper"></span>
                            </div>
                        </div>
                        <div class="portlet-body" style="padding-top: 0;">
                            <form id="setting_form" class="register-form" action="" method="post">
                                {{csrf_field()}}

                                <div class="alert alert-success" id="success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="error_message" style="display: none"></div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive" style="max-height: 440px; overflow: auto;">
                                            <table class="table table-striped table-bordered table-hover data-table focus-table dt-responsive" id="user_dash_horizontal_task">
                                                <thead>
                                                    <tr>
                                                        <th class="editable-name">Project</th>
                                                        <th class="editable-name">Title</th>
                                                        @foreach($task_titles as $title)
                                                        <th class="editable-name" id="title_{{$title->id}}" onclick="edit_task_title({{$title->id}},'{{$title->name}}')">
                                                            {{$title->name}}</th>
                                                        @endforeach
                                                    </tr>
                                                </thead>

                                                <tbody>

                                                    <?php
                                                    foreach($projects as $project){
                                                        $tasks = $project->tasks;
                                                    ?>
                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td class=""> <b>Project</b>
                                                        </td>
                                                        <td class=""> <b>Rule</b>
                                                        </td>
                                                        @foreach($tasks as $task)
                                                        <td class="editable-name editable-rule" id="rule_{{$task->id}}" data-id="{{$task->id}}" data-rule="{{$task->rule}}"> <b>{{$task->rule}}</b>
                                                        </td>
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2" class="editable-name" id="project_{{$project->id}}" onclick="edit_project({{$project->id}})"> <b>{{$project->name}}</b>
                                                        </td>
                                                        <td> <b>Due Date</b>
                                                        </td>
                                                        @foreach($tasks as $task)
                                                        <td class=""> <b>Wed, Jun 17, 2020</b>
                                                        </td>
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td class=""> <b>Delivery Date</b>
                                                        </td>

                                                        @foreach($tasks as $task)
                                                        <td>
                                                            <div class="">
                                                                Wed, Jun 17, 2020
                                                            </div>
                                                        </td>
                                                        @endforeach
                                                    </tr>

                                                    <?php } // endforeach
                                                    ?>
                                                </tbody>
                                            </table>
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

    <!-- START TASK Delivery date MODAL -->
    <div class="modal fade" id="title_edit_modal" tabindex="-1" role="title_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Edit Title</h4>
                </div>

                <form id="title_edit_form" method="post" action="">
                    {{ csrf_field() }}
                    <input type="hidden" name="title_id" id="title_id" value="">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="alert alert-success text-center" id="title_success_message" style="display:none"></div>
                                <div class="alert alert-danger text-center" id="title_error_message" style="display: none"></div>
                                <div class="form-group">
                                    <label for="">Title name</label>
                                    <input type="text" class="form-control" name="title_name" id="title_name">
                                    <input type="hidden" class="form-control" name="old_title_name" id="old_title_name">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="text-align: center;">
                        <button type="submit" class="btn theme-btn" id="rule_submit_button">submit</button>
                        <button type="button" class="btn btn-danger" id="" data-dismiss="modal" >cancel</button>
                    </div>
                </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- END TASK SUMMERY MODAL -->

    <!-- START TASK Delivery date MODAL -->
    <div class="modal fade" id="rule_edit_modal" tabindex="-1" role="rule_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Edit Task</h4>
                </div>

                <form id="rule_edit_form" method="post" action="">
                    {{ csrf_field() }}
                    <input type="hidden" name="task_id" id="task_id" value="">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="alert alert-success text-center" id="rule_success_message" style="display:none"></div>
                                <div class="alert alert-danger text-center" id="rule_error_message" style="display: none"></div>
                                <div class="form-group">
                                    <label for="">Rule name</label>
                                    <input type="text" class="form-control" name="rule_name" id="rule_name">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="text-align: center;">
                        <button type="submit" class="btn theme-btn" id="rule_submit_button">submit</button>
                        <button type="button" class="btn btn-danger" id="" data-dismiss="modal" >cancel</button>
                    </div>
                </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- END TASK SUMMERY MODAL -->

    <!-- START TASK Delivery date MODAL -->
    <div class="modal fade" id="project_edit_modal" tabindex="-1" role="project_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Edit Projecte</h4>
                </div>

                <form id="project_edit_form" method="post" action="">
                    {{ csrf_field() }}
                    <input type="hidden" name="project_id" id="project_id" value="">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="alert alert-success text-center" id="project_success_message" style="display:none"></div>
                                <div class="alert alert-danger text-center" id="project_error_message" style="display: none"></div>

                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control" name="name" id="project_name">
                                </div>

                                <div class="form-group">
                                    <label for="">Sub Title</label>
                                    <input type="text" class="form-control" name="sub_title" id="project_sub_title">
                                </div>

                                <div class="form-group">
                                    <label for="">Fabrication</label>
                                    <input type="text" class="form-control" name="fabrication" id="project_fabrication">
                                </div>

                                <div class="form-group">
                                    <label for="">Color</label>
                                    <input type="text" class="form-control" name="color" id="project_color">
                                </div>

                                <div class="form-group">
                                    <label for="">Quantity</label>
                                    <input type="text" class="form-control" name="quantity" id="project_quantity">
                                </div>

                                <div class="form-group">
                                    <label for="">Size Range</label>
                                    <input type="text" class="form-control" name="size_range" id="project_size_range">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="text-align: center;">
                        <button type="submit" class="btn theme-btn" id="delivery_submit_button">submit</button>
                        <button type="button" class="btn btn-danger" id="" data-dismiss="modal" >cancel</button>
                    </div>
                </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- END TASK SUMMERY MODAL -->

    <!-- END CONTENT -->
@endsection

@section('js')
    <script>
        $(document).on('click', '.editable-rule', function() {
            var id = $(this).attr('data-id');
            var rule = $(this).attr('data-rule');
            $('#task_id').val(id);
            $('#rule_name').val(rule);
            $('#rule_edit_modal').modal('show');
        });

        function edit_project(project_id){
            var url = "{{ url('admin/get_project_ajax') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {project_id:project_id,'_token':'{{ csrf_token() }}'},
                success: function (data) {
                    HoldOn.close();

                    if(data.status == 200){
                        var project = data.project;
                        $('#project_id').val(project.id);
                        $('#project_name').val(project.name);
                        $('#project_sub_title').val(project.sub_title);
                        $('#project_fabrication').val(project.fabrication);
                        $('#project_color').val(project.color);
                        $('#project_quantity').val(project.quantity);
                        $('#project_size_range').val(project.size_range);
                        $('#project_edit_modal').modal('show');
                    }
                    else{
                        show_error_message(data.reason);
                        setTimeout(function(){
                            window.location.href="{{url('login')}}";
                        },2000);
                    }
                },
                error: function (data) {
                    show_error_message(data);
                }
            });
        }

        function edit_task_title(id,title){
            $('#title_id').val(id);
            alert(title);
            $('#title_name').val(title);
            $('#old_title_name').val(title);
            $('#title_edit_modal').modal('show');
        }

        $(document).on("submit", "#rule_edit_form", function(event) {
            event.preventDefault();

            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while saving all data.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);

            var rule_name = $("#rule_name").val();
            var task_id = $("#task_id").val();

            var validate = "";

            if (rule_name.trim() == "") {
                validate = validate + "Rule name is required</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#rule_edit_form")[0]);
                var url = "{{ url('admin/update_task_rule') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(data) {
                        HoldOn.close();
                        if (data.status == 200) {
                            $("#rule_"+task_id).html('<b>'+rule_name+'</b>');
                            $("#rule_"+task_id).attr('data-rule',rule_name);
                            $('#rule_edit_modal').modal('hide');

                            $("#rule_success_message").show();
                            $("#rule_error_message").hide();
                            $("#rule_success_message").html(data.reason);

                            setTimeout(function(){
                                $("#rule_success_message").hide();
                            },2000);
                        } else {
                            $("#rule_success_message").hide();
                            $("#rule_error_message").show();
                            $("#rule_error_message").html(data.reason);
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
                $("#rule_success_message").hide();
                $("#rule_error_message").show();
                $("#rule_error_message").html(validate);
            }
        });

        $(document).on("submit", "#project_edit_form", function(event) {
            event.preventDefault();

            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while saving all data.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);

            var project_name = $("#project_name").val();
            var project_id = $("#project_id").val();

            var validate = "";

            if (project_name.trim() == "") {
                validate = validate + "Project name is required</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#project_edit_form")[0]);
                var url = "{{ url('admin/update_project') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(data) {
                        HoldOn.close();
                        if (data.status == 200) {
                            $("#project_"+project_id).html('<b>'+project_name+'</b>');
                            $('#project_edit_modal').modal('hide');

                            $("#project_success_message").show();
                            $("#project_error_message").hide();
                            $("#project_success_message").html(data.reason);

                            setTimeout(function(){
                                $("#project_success_message").hide();
                            },2000);
                        } else {
                            $("#project_success_message").hide();
                            $("#project_error_message").show();
                            $("#project_error_message").html(data.reason);
                        }
                    },
                    error: function(data) {
                        HoldOn.close();
                        $("#project_success_message").hide();
                        $("#project_error_message").show();
                        $("#project_error_message").html(data);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            } else {
                HoldOn.close();
                $("#project_success_message").hide();
                $("#project_error_message").show();
                $("#project_error_message").html(validate);
            }
        });

        $(document).on("submit", "#title_edit_form", function(event) {
            event.preventDefault();

            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while saving all data.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);

            var project_name = $("#project_name").val();
            var project_id = $("#project_id").val();

            var validate = "";

            if (project_name.trim() == "") {
                validate = validate + "Project name is required</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#title_edit_form")[0]);
                var url = "{{ url('admin/update_task_title') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(data) {
                        HoldOn.close();
                        if (data.status == 200) {
                            $("#project_"+project_id).html('<b>'+project_name+'</b>');
                            $('#project_edit_modal').modal('hide');

                            $("#project_success_message").show();
                            $("#project_error_message").hide();
                            $("#project_success_message").html(data.reason);

                            setTimeout(function(){
                                $("#project_success_message").hide();
                            },2000);
                        } else {
                            $("#project_success_message").hide();
                            $("#project_error_message").show();
                            $("#project_error_message").html(data.reason);
                        }
                    },
                    error: function(data) {
                        HoldOn.close();
                        $("#project_success_message").hide();
                        $("#project_error_message").show();
                        $("#project_error_message").html(data);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            } else {
                HoldOn.close();
                $("#project_success_message").hide();
                $("#project_error_message").show();
                $("#project_error_message").html(validate);
            }
        });
    </script>
@endsection

