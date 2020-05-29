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
                        <span>My Projects</span>
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
                                <span class="caption-subject font-dark bold uppercase">Tasks for {{$project->name}} </span>
                                <span class="caption-helper"></span>
                            </div>

                            <div class="actions">
                                <a data-toggle="modal" href="#task_summery_modal" class="btn btn-transparent green btn-circle btn-sm">View Summery</a>
                                <a title="List View" class="btn btn-transparent theme-btn btn-outline btn-circle btn-sm" href="javascript:;" id="vertical_view_btn">
                                    <i class="icon-list icons"></i>
                                </a>
                                <a title="Grid View" class="btn btn-transparent theme-btn btn-circle btn-sm" href="javascript:;" id="horzon_view_btn">
                                    <i class="icon-grid icons"></i>
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                    
                            <table class="table table-striped table-bordered table-hover data-table focus-table dt-responsive" id="user_horizontal_task">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        @foreach($tasks as $task)
                                        <th> {{$task->title}} </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="focus-tr">
                                        <td> <b>Rule</b></td>
                                        @foreach($tasks as $task)
                                            <th> {{$task->rule}} </th>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td> <b>Due Date</b></td>
                                        @foreach($tasks as $task)
                                            <th>
                                                {{date('l', strtotime($task->due_date))}},<br>
                                                {{date('F d, Y', strtotime($task->due_date))}}
                                            </th>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td> <b>Original Delivery Date</b></td>
                                        <?php foreach($tasks as $task){
                                            $hidden_class = 'hidden';
                                            $bg_class = '';
                                            if($task->status == 'processing' && $task->delivery_date_update_count<2){
                                                $hidden_class = '';
                                            }
                                            else if($task->status == 'processing' && $task->delivery_date_update_count>1){
                                                $hidden_class = 'hidden';
                                            }
                                            if($task->status == 'completed'){
                                                $bg_class = 'bg-success';
                                            }
                                            ?>
                                            <td class="{{$bg_class}}">{{--bg-warning, bg-danger--}}
                                                <div class="edit-table-date">
                                                    {{date('l', strtotime($task->original_delivery_date))}},<br>
                                                    {{date('F d, Y', strtotime($task->original_delivery_date))}}<br>
                                                    <a class="{{$hidden_class}}" data-toggle="modal" href="#select_delivery_modal" title="Edit"><i class="icons icon-note"></i></a>
                                                </div>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                </tbody>
                            </table>


                            <table class="table table-striped table-bordered table-hover data-table focus-table hidden" id="user_vertical_task">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th> Role </th>
                                        <th> Due Date </th>
                                        <th> Original Delivery Date </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($tasks as $task){
                                        $hidden_class = 'hidden';
                                        $bg_class = '';
                                        if($task->status == 'processing' && $task->delivery_date_update_count<2){
                                            $hidden_class = '';
                                        }
                                        else if($task->status == 'processing' && $task->delivery_date_update_count>1){
                                            $hidden_class = 'hidden';
                                        }
                                        if($task->status == 'completed'){
                                            $bg_class = 'bg-success';
                                        }
                                    ?>
                                    <tr>
                                        <td> <b>{{$task->title}}</b></td>
                                        <td> <b>{{$task->rule}}</b></td>
                                        <td>
                                            {{date('l, F d, Y', strtotime($task->due_date))}}
                                        </td>
                                        <td class="{{$bg_class}}">
                                            <div class="edit-table-date">
                                                {{date('l, F d, Y', strtotime($task->original_delivery_date))}}
                                                <a class="{{$hidden_class}}" data-toggle="modal" href="#select_delivery_modal" title="Edit"><i class="icons icon-note"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END PORTLET-->
                </div>
            </div>

        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->

    <!-- START TASK SUMMERY MODAL -->
    <div class="modal fade" id="task_summery_modal" tabindex="-1" role="task_summery_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Summery of product</h4>
                </div>
                <div class="modal-body">
                    <p class="mt-0 mb-0">Description: {{$project->description}}<br>
                    Fabrication: {{$project->fabrication}}<br>
                    Colour: {{$project->color}} <br>
                    Quantity: {{$project->quantity}}<br>
                    Size range: {{$project->size_range}}<br>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn blue" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- END TASK SUMMERY MODAL -->

    <!-- START TASK Delivery date MODAL -->
    <div class="modal fade" id="select_delivery_modal" tabindex="-1" role="select_delivery_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Update task</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="form-group">
                                <label for=""><b>Original Delivery Date</b></label>
                                <input class="form-control date-picker" size="16" type="text" name="org_delivery_date" id="org_delivery_date" value="" placeholder="Select Delivery Date"/>
                                <input class="date-picker-hidden" type="hidden" name="org_delivery_date_hidden"/>
                            </div>

                            <div class="form-group margin-top-20 margin-bottom-20">
                                <label class="mt-checkbox mt-checkbox-outline mb-0">
                                    <input type="checkbox" class="show-password" name="task-done" /> Task Done
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn theme-btn">Submit</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- END TASK SUMMERY MODAL -->
@endsection

@section('js')
    <!-- <script src="https://cdn.datatables.net/responsive/2.2.4/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.4/js/responsive.bootstrap.min.js"></script> -->
    <script>
        $(document).ready(function() {
            $('#user_horizontal_task, #user_vertical_task').DataTable({
                "paging":   false,
                "ordering": false,
                "info":     false,
                "searching": false,
                //"responsive": true
            });
        });
    </script>
@endsection

