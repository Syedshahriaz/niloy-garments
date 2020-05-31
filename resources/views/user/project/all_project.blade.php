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
                                <div class="user-list-tag">
                                    <ul>
                                        @foreach($child_users as $user)
                                        <li class="@if($user->id==$user_id) active @endif"><a href="{{url('all_project').'?u_id='.$user->id}}" @if($user->shipment_date=='') disabled @endif>{{$user->username}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
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
                                        $datediff = strtotime($task->original_delivery_date) - $now;
                                        $day_left = round($datediff / (60 * 60 * 24));

                                        /*
                                         * Create bg class
                                         * */
                                        if($task->status == 'completed'){
                                            $bg_class = 'bg-success';
                                        }
                                        else{
                                            if(strtotime($task->original_delivery_date) < time()) {
                                                $bg_class = 'bg-danger';
                                            }
                                            else if($day_left<=7){
                                                $bg_class = 'bg-warning';
                                            }
                                        }
                                    ?>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                        <a class="project-item-title" href="{{url('my_project_task',$project->user_project_id)}}" title="{{$project->name}}">
                                            <div class="dashboard-stat2 project-item {{$bg_class}} @if(in_array($project->id,$my_projects)) project_added @endif">
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
                                                        <input type="hidden" name="start_dates[]" value="{{date('Y-m-d', strtotime($task->original_delivery_date))}}" @if(in_array($project->id,$my_projects)) disabled @endif>
                                                    </div>
                                                </div>
                                                <input type="hidden" class="project-item-check" name="project_check[]" value="0" @if(in_array($project->id,$my_projects)) disabled @endif>
                                                <input type="hidden" class="project-item-id" name="project_id[]" value="{{$project->id}}" @if(in_array($project->id,$my_projects)) disabled @endif>
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
            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while saving all data.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);

            var validate = "";

            if (validate == "") {
                var formData = new FormData($("#project_form")[0]);
                var url = "{{ url('add_project') }}";

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
                                window.location.href = "{{ url('my_project') }}";
                            },2000)
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

