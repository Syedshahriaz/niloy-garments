@extends('layouts.master')
@section('title', 'Vaccine schedule')
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
                        <a class=" item-1" href="https://vujadetec.com" target="_blank" data-name="dashboard" data-item="1">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Vaccine schedule</span>
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

            <div class="row mt-1">
                <div class="col-md-12 col-sm-12">
                    <div class="admin-common-message">
                        <marquee>
                        <p><?php echo htmlspecialchars_decode($setting->message_to_user); ?></p>
                        </marquee>
                    </div>
                </div>
            </div>

            <div class="row mt-1">
                <div class="col-md-12 col-sm-12">
                    <!-- BEGIN PORTLET-->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-share font-red-sunglo hide"></i>
                                <span class="caption-subject font-dark bold">Vaccine schedule &nbsp;</span>
                                <span class="caption-helper"> Click & update from below</span>
                            </div>
                            <div class="caption" style="padding-left:20px; color:red">
                                @if($user->user_type=='free')
                                    Upgrade your account to <a href="{{url('upgrade_account',$user_id)}}">premium</a> to see all vaccine.
                                @endif
                            </div>
                            <div class="actions">
                                <div class="user-list-tag">
                                    <ul>
                                        @foreach($child_users as $c_user)
                                            @if($c_user->shipment_date !='')
                                                <li class="@if($c_user->id==$user_id) active @endif project_list_item"><a href="{{url('all_project').'?u_id='.$c_user->id}}" class="item-2" data-name="all_project?u_id={{$c_user->id}}" data-item="2">{{$c_user->username}}</a></li>
                                            @else
                                                <li class="@if($c_user->id==$user_id) active @endif project_list_item"><a href="{{url('select_offer',$c_user->id)}}" class="" >{{$c_user->username}}</a></li>
                                                {{--<li class="@if($c_user->id==$user_id) active @endif"><a href="{{url('select_offer',$c_user->id)}}" class="ajax_item item-7" data-segment="select_offer" data-name="select_offer/{{$c_user->id}}" data-item="7">{{$c_user->username}}</a></li>--}}
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body p-relative">
                            @if($user->status!='expired' && !App\Common::checkIfUserSubscriptionExpired($user))
                                <div class="row">
                                    <!-- For Free projects -->
                                    <?php
                                    foreach($free_projects as $project){

                                    $task = '';
                                    $premium_class = '';
                                    $selected_vaccine_company = '';
                                    if(!empty($project->free_running_task)){
                                        $task = $project->free_running_task;
                                    }
                                    else{
                                        $task = $project->free_last_task;
                                    }

                                    // If last task is completed then use this task
                                    if(!empty($project->free_last_task) && $project->free_last_task->status=='completed'){
                                        $task = $project->free_last_task;
                                    }

                                    if(!empty($project->free_running_task)){
                                        $task = $project->free_running_task;
                                    }

                                    $bg_class = '';

                                    if($task !=''){ // Free task date already added
                                        /*
                                     * Calculate number of days left to complete
                                     * */
                                        $now = time();
                                        $datediff = strtotime($task->due_date) - $now;
                                        $day_left = $datediff / (60 * 60 * 24);

                                        $covid_company_changable = 1;

                                        $selected_vaccine_company = $task->company_name;

                                        /*
                                         * Create bg class
                                         * */
                                        if(count($project->free_completed_tasks) > 0){
                                            $covid_company_changable = 0;
                                        }
                                        if($project->type=='upcoming'){
                                            $bg_class = 'bg-upcoming';
                                        }
                                        else if($task->status == 'completed'){
                                            $bg_class = 'bg-success';
                                        }
                                        else{
                                            if($task->due_date==''){ // If no due date found
                                                $bg_class = '';
                                            }
                                            else if(!\App\Common::task_editable($task,$shipment->shipment_date) && count($project->completed_tasks) !=0){ // If task is freezed and any previous task completed
                                                $bg_class = 'bg-success';
                                            }
                                            /*else if($task->has_freeze_rule == 1 && $task->skip_background_rule==0){ // If has freeze rule and background rule not skipped
                                                $bg_class = '';
                                            }*/
                                            /*else if($task->has_freeze_rule == 1 && $task->skip_background_rule==1){ // If has freeze rule and background rule skipped
                                                $bg_class = 'bg-success';
                                            }*/
                                            else if(strtotime($task->due_date) < strtotime(date('Y-m-d'))) {
                                                $bg_class = 'bg-danger';
                                            }
                                            else if($day_left<=7){
                                                $bg_class = 'bg-warning';
                                            }

                                            if($user->user_type=='free' && $project->type !='free'){
                                                $premium_class= 'only-premium';
                                            }
                                            else{
                                                $premium_class= '';
                                            }
                                        }
                                    }
                                    else{
                                        $bg_class = '';
                                        $premium_class= '';
                                    }
                                    if($task !=''){  // Free task date already added
                                    ?>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                        @if($project->type=='upcoming')
                                            <a class="project-item-title {{$premium_class}}" href="javascript:void(0)" title="{{$project->name}}">
                                        @elseif($project->has_special_date==1 && $project->special_date=='')
                                            <a class="project-item-title {{$premium_class}}" href="javascript:void(0)" title="{{$project->name}}" onclick="show_special_date_modal({{$project->user_project_id}})">
                                        @else
                                            <a class="project-item-title item-2 {{$premium_class}}" href="{{url('my_project_task',$project->user_project_id)}}" title="{{$project->name}}" data-name="my_project_task/{{$project->user_project_id}}" data-item="2">
                                        @endif
                                        <div class="dashboard-stat2 project-item @if($project->has_offer_3==1)bg-pink extra-offer @endif {{$bg_class}}">
                                            <div class="display title-section">
                                                <div class="number">
                                                    <h5 class="font-theme project-item-name">
                                                        {{$project->name}}
                                                        @if($selected_vaccine_company != '')
                                                        -{{$selected_vaccine_company}}
                                                        @endif
                                                    </h5>
                                                </div>
                                                @if($project->has_special_date==1 && $project->special_date_update_count < 4)
                                                    <div class="icon change_special_date" data-id="{{$project->user_project_id}}" title="Change special date">
                                                        <i class="icon-settings"></i>
                                                        @elseif($project->type=='free' && $covid_company_changable==1)
                                                            <div class="icon change_covid_company" data-id="{{$project->user_project_id}}" data-company="{{$user_covid_vaccine_company->company_id}}" data-date="{{$user_covid_vaccine_company->dose_date}}" title="Change COVID company">
                                                                <i class="icon-settings"></i>
                                                                @else
                                                                    <div class="icon">
                                                                        <i class="icon-arrow-right"></i>
                                                                        @endif
                                                                    </div>
                                                            </div>
                                                            <div class="display">
                                                                <p class="project-item-sub">{{$project->sub_title}}</p>
                                                                <p class="project-item-task font-theme">
                                                                    @if($bg_class !='bg-success' && $bg_class !='bg-upcoming')
                                                                        {{$task->title}}
                                                                    @endif
                                                                </p>
                                                            </div>
                                                            @if($bg_class=='bg-success')
                                                                <div class="progress-info">
                                                                    <div class="progress">
                                                                        <span style="width: 100%;" class="progress-bar theme-bg"></span>
                                                                    </div>
                                                                    <div class="status">
                                                                        <div class="status-title"> Course Completed </div>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="progress-info">
                                                                    <div class="progress">
                                                                        <span style="width: 100%;" class="progress-bar theme-bg"></span>
                                                                    </div>
                                                                    <div class="status">
                                                                        @if($bg_class !='bg-upcoming')
                                                                            <div class="status-title"> Due Date </div>
                                                                            <div class="status-number">
                                                                                @if($task->original_delivery_date !='')
                                                                                    {{date('l M d, Y', strtotime($task->original_delivery_date))}}
                                                                                @else
                                                                                    Special Date
                                                                                @endif
                                                                            </div>
                                                                            <input type="hidden" name="start_dates[]" value="@if($task->original_delivery_date !=''){{date('Y-m-d', strtotime($task->original_delivery_date))}}@endif">
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            <input type="hidden" class="project-item-check" name="project_check[]" value="0">
                                                            <input type="hidden" class="project-item-id" name="project_id[]" value="{{$project->id}}">
                                                    </div>
                                    </a>
                                    </div>
                                    <?php
                                    } // End if
                                    else{  // Free task date not added yet
                                    ?>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                        @if($project->type=='upcoming')
                                            <a class="project-item-title {{$premium_class}}" href="javascript:void(0)" title="{{$project->name}}">
                                        @elseif($project->has_special_date==1 && $project->special_date=='')
                                            <a class="project-item-title {{$premium_class}}" href="javascript:void(0)" title="{{$project->name}}" onclick="show_special_date_modal({{$project->user_project_id}})">
                                        @elseif($project->type=='free')
                                            <a class="project-item-title {{$premium_class}}" href="javascript:void(0)" title="{{$project->name}}" onclick="show_covid_company_modal({{$project->user_project_id}})">
                                        @else
                                            <a class="project-item-title item-2 {{$premium_class}}" href="{{url('my_project_task',$project->user_project_id)}}" title="{{$project->name}}" data-name="my_project_task/{{$project->user_project_id}}" data-item="2">
                                        @endif
                                        <div class="dashboard-stat2 project-item @if($project->has_offer_3==1)bg-pink extra-offer @endif {{$bg_class}}">
                                            <div class="display title-section">
                                                <div class="number">
                                                    <h5 class="font-theme project-item-name">
                                                        {{$project->name}}
                                                    </h5>
                                                </div>
                                                @if($project->has_special_date==1 && $project->special_date_update_count < 4)
                                                    <div class="icon change_special_date" data-id="{{$project->user_project_id}}" title="Change special date">
                                                        <i class="icon-settings"></i>
                                                        @elseif($project->type=='free')
                                                            <div class="icon change_covid_company" data-id="{{$project->user_project_id}}" data-company="" data-date="" title="Change COVID company">
                                                                <i class="icon-settings"></i>
                                                                @else
                                                                    <div class="icon">
                                                                        <i class="icon-arrow-right"></i>
                                                                        @endif
                                                                    </div>
                                                            </div>
                                                            <div class="display">
                                                                <p class="project-item-sub">{{$project->sub_title}}</p>
                                                                <p class="project-item-task font-theme">
                                                                    @if($bg_class !='bg-success' && $bg_class !='bg-upcoming')
                                                                        {{-- Task title --}}
                                                                    @endif
                                                                </p>
                                                            </div>
                                                            @if($bg_class=='bg-success')
                                                                <div class="progress-info">
                                                                    <div class="progress">
                                                                        <span style="width: 100%;" class="progress-bar theme-bg"></span>
                                                                    </div>
                                                                    <div class="status">
                                                                        <div class="status-title"> Course Completed </div>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="progress-info">
                                                                    <div class="progress">
                                                                        <span style="width: 100%;" class="progress-bar theme-bg"></span>
                                                                    </div>
                                                                    <div class="status">
                                                                        @if($bg_class !='bg-upcoming')
                                                                            <div class="status-title"> Due Date </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            <input type="hidden" class="project-item-check" name="project_check[]" value="0">
                                                            <input type="hidden" class="project-item-id" name="project_id[]" value="{{$project->id}}">
                                                    </div>
                                    </a>
                                    </div>
                                    <?php } // end else
                                    }
                                    ?>

                                    <!-- For Premium projects -->
                                    <?php
                                    foreach($projects as $project){

                                        if(!empty($project->running_task)){
                                            $task = $project->running_task;
                                        }
                                        else{
                                            $task = $project->last_task;
                                        }

                                        // If last task is completed then use this task
                                        if(!empty($project->last_task) && $project->last_task->status=='completed'){
                                            $task = $project->last_task;
                                        }

                                        $bg_class = '';

                                        /*
                                         * Calculate number of days left to complete
                                         * */
                                        $now = time();
                                        $datediff = strtotime($task->due_date) - $now;
                                        $day_left = $datediff / (60 * 60 * 24);

                                        /*
                                         * Create bg class
                                         * */
                                        if(empty($project->completed_tasks)){

                                        }
                                        if($project->type=='upcoming'){
                                            $bg_class = 'bg-upcoming';
                                        }
                                        else if($task->status == 'completed'){
                                            $bg_class = 'bg-success';
                                        }
                                        else{
                                            if($task->due_date==''){ // If no due date found
                                                $bg_class = '';
                                            }
                                            else if(!\App\Common::task_editable($task,$shipment->shipment_date) && count($project->completed_tasks) !=0){ // If task is freezed and any previous task completed
                                                $bg_class = 'bg-success';
                                            }
                                            /*else if($task->has_freeze_rule == 1 && $task->skip_background_rule==0){ // If has freeze rule and background rule not skipped
                                                $bg_class = '';
                                            }*/
                                            /*else if($task->has_freeze_rule == 1 && $task->skip_background_rule==1){ // If has freeze rule and background rule skipped
                                                $bg_class = 'bg-success';
                                            }*/
                                            else if(strtotime($task->due_date) < strtotime(date('Y-m-d'))) {
                                                $bg_class = 'bg-danger';
                                            }
                                            else if($day_left<=7){
                                                $bg_class = 'bg-warning';
                                            }

                                            if($user->user_type=='free' && $project->type !='free'){
                                                $premium_class= 'only-premium';
                                                $bg_class = '';
                                            }
                                            else{
                                                $premium_class= '';
                                            }
                                        }
                                    ?>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                        @if($project->type=='upcoming')
                                            <a class="project-item-title {{$premium_class}}" href="javascript:void(0)" title="{{$project->name}}">
                                        @elseif($project->has_special_date==1 && $project->special_date=='')
                                            <a class="project-item-title {{$premium_class}}" href="javascript:void(0)" title="{{$project->name}}" onclick="show_special_date_modal({{$project->user_project_id}})">
                                        @elseif($project->type=='free')
                                            <a class="project-item-title {{$premium_class}}" href="javascript:void(0)" title="{{$project->name}}" onclick="show_covid_company_modal({{$project->user_project_id}})">
                                        @else
                                            <a class="project-item-title item-2 {{$premium_class}}" href="{{url('my_project_task',$project->user_project_id)}}" title="{{$project->name}}" data-name="my_project_task/{{$project->user_project_id}}" data-item="2">
                                        @endif
                                            <div class="dashboard-stat2 project-item @if($project->has_offer_3==1)bg-pink extra-offer @endif {{$bg_class}}">
                                                <div class="display title-section">
                                                    <div class="number">
                                                        <h5 class="font-theme project-item-name">
                                                            {{$project->name}}
                                                        </h5>
                                                    </div>
                                                    @if($project->has_special_date==1 && $project->special_date_update_count < 4)
                                                    <div class="icon change_special_date" data-id="{{$project->user_project_id}}" title="Change special date">
                                                            <i class="icon-settings"></i>
                                                    @elseif($project->type=='free')
                                                        <div class="icon change_covid_company" data-id="{{$project->user_project_id}}" data-company="{{$user_covid_vaccine_company->company_id}}" title="Change COVID company">
                                                            <i class="icon-settings"></i>
                                                    @else
                                                    <div class="icon">
                                                            <i class="icon-arrow-right"></i>
                                                    @endif
                                                    </div>
                                                </div>
                                                <div class="display">
                                                    <p class="project-item-sub">{{$project->sub_title}}</p>
                                                    <p class="project-item-task font-theme">
                                                        @if($bg_class !='bg-success' && $bg_class !='bg-upcoming')
                                                        {{$task->title}}
                                                        @endif
                                                    </p>
                                                </div>
                                                @if($bg_class=='bg-success')
                                                    <div class="progress-info">
                                                        <div class="progress">
                                                            <span style="width: 100%;" class="progress-bar theme-bg"></span>
                                                        </div>
                                                        <div class="status">
                                                            <div class="status-title"> Course Completed </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="progress-info">
                                                        <div class="progress">
                                                            <span style="width: 100%;" class="progress-bar theme-bg"></span>
                                                        </div>
                                                        <div class="status">
                                                            @if($bg_class !='bg-upcoming')
                                                                <div class="status-title"> Due Date </div>
                                                                <div class="status-number">
                                                                    @if($task->original_delivery_date !='')
                                                                        {{date('l M d, Y', strtotime($task->original_delivery_date))}}
                                                                    @else
                                                                        Special Date
                                                                    @endif
                                                                </div>
                                                                <input type="hidden" name="start_dates[]" value="@if($task->original_delivery_date !=''){{date('Y-m-d', strtotime($task->original_delivery_date))}}@endif">
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif

                                                <input type="hidden" class="project-item-check" name="project_check[]" value="0">
                                                <input type="hidden" class="project-item-id" name="project_id[]" value="{{$project->id}}">
                                            </div>
                                        </a>
                                    </div>
                                    <?php
                                    }
                                    ?>

                                </div>
                            @endif

                            @if($user->status=='expired' || App\Common::checkIfUserSubscriptionExpired($user))
                                <div class="renewal-notice">
                                    <p>Your subscription is over. To renew subscription please <a href="{{url('expired_account',$user->id)}}">Click here.</a></p>
                                </div>
                            @endif
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
                    <input type="hidden" name="user_id" id="user_id" value="{{$user_id}}">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="alert alert-success" id="success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="error_message" style="display: none"></div>
                            </div>

                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label for=""><b>Special Date</b></label>
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
                                    <input class="date-picker-hidden" type="hidden" name="special_date" id="shipment_date" value="{{date('Y-m-d')}}"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="text-align: center;">
                        <button type="submit" class="btn theme-btn" id="special_date_submit_button">Submit</button>
                    </div>
                </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- END special date MODAL -->

    <!-- START special date MODAL -->
    <div class="modal fade" id="covid_company_modal" tabindex="-1" role="covid_company_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="covid_company_modalLabel">Select COVID Vaccine Company</h4>
                </div>
                <form id="covid_company_form" method="post" action="">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_project_id" id="covid_user_project_id" value="">
                    <input type="hidden" name="user_id" id="covid_user_id" value="{{$user_id}}">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="alert alert-success" id="covid_success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="covid_error_message" style="display: none"></div>
                            </div>

                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label for=""><b>COVID Vaccine Company</b></label>
                                    <select name="covid_vaccine_company" id="covid_vaccine_company" class="form-control">
                                        <option value="">Select Company</option>
                                        @foreach($covid_vaccine_companies as $company)
                                            <option value="{{$company->id}}">{{$company->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="text-align: center;">
                        <button type="submit" class="btn theme-btn" id="covid_vaccine_company_submit_button">Submit</button>
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
        $(document).on('change','#covid_day, #covid_month, #covid_year',function(){
            var day = $('#covid_day').val();
            var month = $('#covid_month').val();
            var year = $('#covid_year').val();
            var date = year+'-'+month+'-'+day;

            $('#covid_vaccine_date').val(date);
        });

        $(document).on('click','.extra-offer .change_special_date',function(e){
            e.stopPropagation();
            e.preventDefault();
            $('#special_date_modal').modal('show');
        });

        $(document).on('click','.project_list_item',function(e){
            show_content_loader();
        });

        $(document).on('click','.change_covid_company',function(e){
            e.stopPropagation();
            e.preventDefault();
            var id = $(this).attr('data-id');
            var company_id = $(this).attr('data-company');
            var date = $(this).attr('data-date');
            if(date !=''){
                $('#covid_vaccine_date').val(date);
            }
            $('#covid_user_project_id').val(id);
            $('#covid_vaccine_company').val(company_id);
            $('#covid_company_modal').modal('show');
        });
    </script>
@endsection

