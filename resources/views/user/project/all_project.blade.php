@extends('layouts.master')
@section('title', 'All Projects')
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
                            <div class="">
                                {{$setting->message_to_user}}
                            </div>
                            <div class="caption">
                                <i class="icon-share font-red-sunglo hide"></i>
                                <span class="caption-subject font-dark bold uppercase">All projects</span>
                                <span class="caption-helper">Select to add project</span>
                            </div>
                            <div class="actions">
                                <div class="user-list-tag">
                                    <ul>
                                        @foreach($child_users as $user)
                                            @if($user->shipment_date !='')
                                                <li class="@if($user->id==$user_id) active @endif"><a href="{{url('all_project').'?u_id='.$user->id}}" class="ajax_item item-2" data-name="all_project?u_id={{$user->id}}" data-item="2">{{$user->username}}</a></li>
                                            @else
                                                <li class="@if($user->id==$user_id) active @endif"><a href="{{url('select_shipment',$user->id)}}" class="" >{{$user->username}}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <?php
                                foreach($projects as $project){

                                    if(!empty($project->running_task)){
                                        $task = $project->running_task;
                                    }
                                    else{
                                        $task = $project->last_task;
                                    }

                                    $bg_class = '';

                                    /*
                                     * Calculate number of days left to complete
                                     * */
                                    $now = time();
                                    $datediff = strtotime($task->due_date) - $now;
                                    $day_left = round($datediff / (60 * 60 * 24));

                                    /*
                                     * Create bg class
                                     * */
                                    if($task->status == 'completed'){
                                        $bg_class = 'bg-success';
                                    }
                                    else{
                                        if(strtotime($task->due_date) < time()) {
                                            $bg_class = 'bg-danger';
                                        }
                                        else if($day_left<=7){
                                            $bg_class = 'bg-warning';
                                        }
                                    }
                                ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    @if($project->has_special_date==1 && $project->special_date=='')
                                        <a class="project-item-title" href="javascript:void(0)" title="{{$project->name}}" onclick="show_special_date_modal({{$project->user_project_id}})">
                                    @else
                                        <a class="project-item-title ajax_item item-2" href="{{url('my_project_task',$project->user_project_id)}}" title="{{$project->name}}" data-name="my_project_task/{{$project->user_project_id}}" data-item="2">
                                    @endif
                                        <div class="dashboard-stat2 project-item {{$bg_class}}">
                                            <div class="display title-section">
                                                <div class="number">
                                                    <h5 class="font-theme project-item-name">
                                                        {{$project->name}}
                                                    </h5>
                                                </div>
                                                <div class="icon">
                                                    <!-- <a href="javascript:;" title="Favourite" class="add_to_fav">
                                                        <i class="icon-heart"></i>
                                                    </a> -->
                                                    <i class="icon-arrow-right"></i>
                                                </div>
                                            </div>
                                            <div class="display">
                                                <p class="project-item-sub" title="This is a sub title">{{$project->sub_title}}</p>
                                                <p class="project-item-task font-theme">{{$task->title}}</p>
                                            </div>
                                            <div class="progress-info">
                                                <div class="progress">
                                                    <span style="width: 100%;" class="progress-bar theme-bg"></span>
                                                </div>
                                                <div class="status">
                                                    <div class="status-title"> Due Date </div>
                                                    <div class="status-number"> {{date('l M d, Y', strtotime($task->original_delivery_date))}}</div>
                                                    <input type="hidden" name="start_dates[]" value="{{date('Y-m-d', strtotime($task->original_delivery_date))}}">
                                                </div>
                                            </div>
                                            <input type="hidden" class="project-item-check" name="project_check[]" value="0">
                                            <input type="hidden" class="project-item-id" name="project_id[]" value="{{$project->id}}">
                                        </div>
                                    </a>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
                            <!-- <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn green">Add Selected Project</button>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <!-- END PORTLET-->
                </div>
            </div>

        </div>
        <!-- END CONTENT BODY -->
    </div>

    <!-- START special date MODAL -->
    <div class="modal fade" id="special_date_modal" tabindex="-1" role="special_date_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Add Special Date</h4>
                </div>
                <form id="special_date_form" method="post" action="">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_project_id" id="user_project_id" value="">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="alert alert-success" id="success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="error_message" style="display: none"></div>
                            </div>

                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label for=""><b>Special Date</b></label>
                                    <input class="form-control date-picker" size="16" type="text" name="sp_date" id="sp_date" value="" placeholder="Select Special Date"/>
                                    <input class="date-picker-hidden" type="hidden" name="special_date"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn theme-btn" id="special_date_submit_button">Submit</button>
                    </div>
                </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- END special date MODAL -->

    <!-- END CONTENT -->
@endsection

@section('js')
    <script>

    </script>
@endsection

