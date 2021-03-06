@extends('layouts.master')
@section('title', 'Dashboard')
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
                            <div class="text-right">
                                <button type="button" class="btn btn-transparent theme-btn btn-circle btn-sm" title="Save buyer" onclick="open_buyer_modal()">Add/Update Buyer</button>
                            </div>
                            <div class="row">
                                <div class="@if(empty($buyer)) hidden @endif" id="buyer_section">
                                    <div class="col-md-4">
                                        <p class="mb-0"><b>Buyer Name:</b> <span id="view_buyer_name">@if(!empty($buyer)){{$buyer->buyer_name}}@endif</span></p>
                                        <p class="mb-0"><b>Email:</b> <span id="view_buyer_email">@if(!empty($buyer)){{$buyer->buyer_email}}@endif</span></p>
                                        <p class="mb-0"><b>Phone:</b> <span id="view_buyer_phone">@if(!empty($buyer)){{$buyer->buyer_phone}}@endif</span></p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-0"><b>Buying Agent Name:</b> <span id="view_buying_agent_name">@if(!empty($buyer)){{$buyer->buying_agent_name}}@endif</span></p>
                                        <p class="mb-0"><b>Email:</b> <span id="view_buying_agent_email">@if(!empty($buyer)){{$buyer->buying_agent_email}}@endif</span></p>
                                        <p class="mb-0"><b>Phone:</b> <span id="view_buying_agent_phone">@if(!empty($buyer)){{$buyer->buying_agent_phone}}@endif</span></p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-0"><b>Address:</b><br> <span id="view_address">@if(!empty($buyer)){{$buyer->address}}@endif</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BEGIN DASHBOARD STATS 1-->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-share font-red-sunglo hide"></i>
                                <span class="caption-subject font-dark bold uppercase">All Project Review </span>
                                <span class="caption-helper"></span>
                            </div>

                            <div class="actions">
                                <a title="Vertical View" class="btn btn-transparent theme-btn btn-outline btn-circle btn-sm" href="javascript:;" id="vertical_dash_view_btn">
                                    <!--i class="icon-list icons"></i-->Vertical View
                                </a>
                                <a title="Horizontal View" class="btn btn-transparent theme-btn btn-circle btn-sm" href="javascript:;" id="horzon_dash_view_btn">
                                    <!--i class="icon-grid icons"></i-->Horizontal View
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive" style="max-height: 440px; overflow: auto;">
                                        <table class="table table-striped table-bordered table-hover data-table focus-table dt-responsive" id="user_dash_horizontal_task">
                                            <thead>
                                                <tr>
                                                    <th>Project</th>
                                                    <th>Title</th>
                                                    <th>Cotton</th>
                                                    <th>Spinning</th>
                                                    <th>Knitting</th>
                                                    <th>Dying</th>
                                                    <th>Finising </th>
                                                    <th>Test</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($projects as $project)

                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td> <b>Project</b></td>
                                                        <td> <b>Rule</b></td>
                                                        @foreach($project->tasks as $task)
                                                            @if($task->task_status !='deleted')
                                                                <td> <b>{{$task->rule}}</b> </td>
                                                            @endif
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2"> <b>{{$project->name}}</b>
                                                        <td> <b>Due Date</b>
                                                        </td>
                                                        @foreach($project->tasks as $task)
                                                            @if($task->task_status !='deleted')
                                                                <td>
                                                                    @if($task->task_status =='active')
                                                                        {{date('D', strtotime($task->due_date))}},
                                                                        {{date('M d, Y', strtotime($task->due_date))}}
                                                                    @endif
                                                                </td>
                                                            @endif
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td> <b>Delivery Date</b></td>
                                                        <?php foreach($project->tasks as $task){
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
                                                            if(strtotime($task->due_date) < time()) {
                                                                $bg_class = 'bg-danger';
                                                            }
                                                            else if($day_left<=7){
                                                                $bg_class = 'bg-warning';
                                                            }
                                                        }
                                                        ?>

                                                        @if($task->task_status !='deleted')
                                                            <td class="@if($task->due_date !='') {{$bg_class}} @endif">{{--bg-success, bg-warning, bg-danger--}}
                                                                <div class="edit-table-date">
                                                                    @if($task->task_status =='active')
                                                                        {{date('D', strtotime($task->original_delivery_date))}},
                                                                        {{date('M d, Y', strtotime($task->original_delivery_date))}}
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        @endif
                                                        <?php } ?>
                                                    </tr>

                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>


                                    <table class="table table-striped table-bordered table-hover data-table focus-table hidden" id="user_dash_vertical_task">
                                        <thead>
                                            <tr>
                                                <th>Project</th>
                                                <th>Title</th>
                                                <th> Role </th>
                                                <th> Due Date </th>
                                                <th> Original Delivery Date </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($projects as $project)
                                                <?php foreach($project->tasks as $task){
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
                                                            if(strtotime($task->due_date) < time()) {
                                                                $bg_class = 'bg-danger';
                                                            }
                                                            else if($day_left<=7){
                                                                $bg_class = 'bg-warning';
                                                            }
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td> <b>{{$project->name}}</b></td>
                                                            <td> <b>{{$task->title}}</b></td>
                                                            <td> <b>{{$task->rule}}</b></td>
                                                            <td>
                                                                @if($task->task_status =='active')
                                                                    {{date('D, F d, Y', strtotime($task->due_date))}}
                                                                @endif
                                                            </td>
                                                            <td class="@if($task->due_date !='') {{$bg_class}} @endif">
                                                                <div class="edit-table-date">
                                                                    @if($task->task_status =='active')
                                                                        {{date('D, F d, Y', strtotime($task->original_delivery_date))}}
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php } // endif
                                                } // endforeach ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <!-- END DASHBOARD STATS 1-->
                </div>
            </div>

        </div>
        <!-- END CONTENT BODY -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="create_buyer_modal" tabindex="-1" role="create_buyer_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Buyer Details</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="buyer_form" method="post" action="">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="alert alert-success" id="success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="error_message" style="display: none"></div>
                            </div>
                            {{csrf_field()}}
                            <input type="hidden" name="buyer_id" id="buyer_id" value="@if(!empty($buyer)){{$buyer->id}}@endif">
                            <input type="hidden" name="user_id" id="user_id" value="{{$user_id}}">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="form-group">
                                    <label class="control-label">Buyer Name</label>
                                    <input class="form-control placeholder-no-fix" type="text" placeholder="Enter buyer name*" name="buyer_name" id="buyer_name" value="@if(!empty($buyer)){{$buyer->buyer_name}}@endif"  autocomplete="off"/>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Buyer email</label>
                                    <input class="form-control placeholder-no-fix" type="text" placeholder="Enter buyer email*" name="buyer_email" id="buyer_email" value="@if(!empty($buyer)){{$buyer->buyer_email}}@endif"  autocomplete="off"/>
                                </div>

                                <div class="form-group">
                                    <label class="control-label visible-ie8 visible-ie9">Buyer phone</label>
                                    <input class="form-control placeholder-no-fix telephone" type="text" name="buyer_phone" id="buyer_phone" onkeyup="this.value=this.value.replace(/[^\d]/,'')" value="@if(!empty($buyer)){{$buyer->buyer_phone}}@endif"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Buying Agent Name</label>
                                    <input class="form-control placeholder-no-fix" type="text" placeholder="Enter buying agent name*" name="buying_agent_name" id="buying_agent_name" value="@if(!empty($buyer)){{$buyer->buying_agent_name}}@endif"  autocomplete="off"/>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Buying Agent email</label>
                                    <input class="form-control placeholder-no-fix" type="text" placeholder="Enter buying agent email*" name="buying_agent_email" id="buying_agent_email" value="@if(!empty($buyer)){{$buyer->buying_agent_email}}@endif"  autocomplete="off"/>
                                </div>

                                <div class="form-group">
                                    <label class="control-label visible-ie8 visible-ie9">Buying Agent phone</label>
                                    <input class="form-control placeholder-no-fix telephone" type="text" name="buying_agent_phone" id="buying_agent_phone" onkeyup="this.value=this.value.replace(/[^\d]/,'')" value="@if(!empty($buyer)){{$buyer->buying_agent_phone}}@endif"/>
                                </div>

                                <div class="form-group">
                                    <label class="control-label visible-ie8 visible-ie9">Address</label>
                                    <input class="form-control placeholder-no-fix" type="text" name="address" id="address" value="@if(!empty($buyer)){{$buyer->address}}@endif"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn theme-btn" id="save_buyer_button">Submit</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- END CONTENT -->
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // $('#user_dash_horizontal_task, #user_vertical_task').DataTable({
            //     "paging":   false,
            //     "ordering": false,
            //     "info":     false,
            //     "searching": false,
            //     "responsive": true,
            //     "scrollY": "200px",
            //     "scrollCollapse": true,
            //     "paging": false
            // });
        });

    </script>
@endsection

