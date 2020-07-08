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
                        <a class=" ajax_item item-1" href="{{url('dashboard')}}" data-name="dashboard" data-item="1">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a class=" ajax_item item-2" href="{{url('all_project')}}" data-name="all_project" data-item="2">Projects</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>My Project Tasks</span>
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
                                <a title="Vertical View" class="btn btn-transparent theme-btn btn-outline btn-circle btn-sm" href="javascript:;" id="vertical_view_btn">
                                    <!--i class="icon-list icons"></i-->Vertical View
                                </a>
                                <a title="Horizontal View" class="btn btn-transparent theme-btn btn-circle btn-sm" href="javascript:;" id="horzon_view_btn">
                                    <!--i class="icon-grid icons"></i-->Horizontal View
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">

                            <?php
                            $total_task = count($tasks);
                            ?>

                            <table class="table table-striped table-bordered table-hover data-table focus-table dt-responsive" id="user_horizontal_task">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        @foreach($tasks as $task)
                                            @if($task->task_status !='deleted')
                                                <th> {{$task->title}} </th>
                                            @endif
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="focus-tr">
                                        <td> <b>Rule</b></td>
                                        @foreach($tasks as $task)
                                            @if($task->task_status !='deleted')
                                                <td> <b>{{$task->rule}}</b> </td>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td> <b>Due Date</b></td>
                                        @foreach($tasks as $task)
                                            @if($task->task_status !='deleted')
                                                <td>
                                                    @if($task->task_status =='active')
                                                    {{date('D', strtotime($task->due_date))}},<br>
                                                    {{date('F d, Y', strtotime($task->due_date))}}
                                                    @endif
                                                </td>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td> <b>Original Delivery Date</b></td>
                                        <?php foreach($tasks as $task){
                                            $hidden_class = 'hidden';
                                            $bg_class = '';

                                            /*
                                             * Calculate number of days left to complete
                                             * */
                                            $now = time();
                                            $datediff = strtotime($task->due_date) - $now;
                                            $day_left = round($datediff / (60 * 60 * 24));

                                            /*
                                             * Create hidden class
                                             * */
                                            if($task->status == 'processing' && $task->delivery_date_update_count<2){
                                                $hidden_class = '';
                                            }
                                            else if($task->status == 'processing' && $task->delivery_date_update_count>1){
                                                $hidden_class = 'hidden';
                                            }

                                            /*
                                             * Create bg class
                                             * */
                                            if($task->status == 'completed'){
                                                $bg_class = 'bg-success';
                                            }
                                            else{
                                                if($task->has_freeze_rule != 1){
                                                    if(strtotime($task->due_date) < strtotime(date('Y-m-d'))) {
                                                        $bg_class = 'bg-danger';
                                                    }
                                                    else if($day_left<=7){
                                                        $bg_class = 'bg-warning';
                                                    }
                                                }
                                            }
                                            ?>

                                            @if($task->task_status !='deleted')
                                            <td class="@if($task->due_date !='') {{$bg_class}} @endif" style="@if(!\App\Common::task_editable($task) || !\App\Common::task_in_date_range($shipment->shipment_date,$task->days_range_start,$task->days_range_end)) background-color: #efefef;cursor: not-allowed; @endif">{{--bg-success, bg-warning, bg-danger--}}
                                                <div class="edit-table-date">
                                                    @if($task->task_status =='active')
                                                        {{date('D', strtotime($task->original_delivery_date))}},<br>
                                                        {{date('F d, Y', strtotime($task->original_delivery_date))}}<br>
                                                        @if(\App\Common::task_editable($task) && \App\Common::task_in_date_range($shipment->shipment_date,$task->days_range_start,$task->days_range_end))
                                                            <a class="" title="Edit" onclick="select_delivery({{$task->id}},'{{$task->original_delivery_date}}',{{$task->delivery_date_update_count}})"><i class="icons icon-note"></i></a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                            @endif
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
                                        if($task->task_status !='deleted'){
                                            $hidden_class = 'hidden';
                                            $bg_class = '';

                                            /*
                                             * Calculate number of days left to complete
                                             * */
                                            $now = time();
                                            $datediff = strtotime($task->due_date) - $now;
                                            $day_left = round($datediff / (60 * 60 * 24));

                                            /*
                                             * Create hidden class
                                             * */
                                            if($task->status == 'processing' && $task->delivery_date_update_count<2){
                                                $hidden_class = '';
                                            }
                                            else if($task->status == 'processing' && $task->delivery_date_update_count>1){
                                                $hidden_class = 'hidden';
                                            }

                                            /*
                                             * Create bg class
                                             * */
                                            if($task->status == 'completed'){
                                                $bg_class = 'bg-success';
                                            }
                                            else{
                                                if($task->has_freeze_rule != 1){
                                                    if(strtotime($task->due_date) < strtotime(date('Y-m-d'))) {
                                                        $bg_class = 'bg-danger';
                                                    }
                                                    else if($day_left<=7){
                                                        $bg_class = 'bg-warning';
                                                    }
                                                }
                                            }
                                        ?>
                                            <tr>
                                                <td> <b>{{$task->title}}</b></td>
                                                <td> <b>{{$task->rule}}</b></td>
                                                <td>
                                                    @if($task->task_status =='active')
                                                        {{date('D, F d, Y', strtotime($task->due_date))}}
                                                    @endif
                                                </td>
                                                <td class="@if($task->due_date !='') {{$bg_class}} @endif" style="@if(!\App\Common::task_editable($task) || !\App\Common::task_in_date_range($shipment->shipment_date,$task->days_range_start,$task->days_range_end)) background-color: #efefef;cursor: not-allowed; @endif">
                                                    <div class="edit-table-date">
                                                        @if($task->task_status =='active')
                                                            {{date('D, F d, Y', strtotime($task->original_delivery_date))}}
                                                            @if(\App\Common::task_editable($task) && \App\Common::task_in_date_range($shipment->shipment_date,$task->days_range_start,$task->days_range_end))
                                                                <a class="" title="Edit"  onclick="select_delivery({{$task->id}},'{{$task->original_delivery_date}}',{{$task->delivery_date_update_count}})"><i class="icons icon-note"></i></a>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                    <?php } // endif
                                    } // endforeach ?>
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
                    <p class="mt-0 mb-0">
                        <?php echo htmlspecialchars_decode($project->description); ?>
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
                <form id="delivery_form" method="post" action="">
                    {{ csrf_field() }}
                    <input type="hidden" name="project_task_id" id="project_task_id" value="">
                    <input type="hidden" name="user_project_id" id="user_project_id" value="{{$user_project_id}}">

                    <div class="alert alert-success" id="success_message" style="display:none"></div>
                    <div class="alert alert-danger" id="error_message" style="display: none"></div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label for=""><b>Original Delivery Date</b></label>
                                    <input class="form-control date-picker" size="16" type="text" name="org_delivery_date" id="org_delivery_date" value="" placeholder="Select Delivery Date"/>
                                    <input class="date-picker-hidden" type="hidden" name="original_delivery_date"/>
                                    <input class="" type="hidden" name="old_delivery_date" id="old_delivery_date_hidden"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn theme-btn" id="delivery_submit_button">Submit</button>
                    </div>
                </form>

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

