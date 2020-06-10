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
                        <a href="index.html">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Dashboard</span>
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
                            <div class="row">
                                <div class="col-md-4">
                                    <p class="mb-0"><b>Buyer Name:</b> Marcel Holcaustan</p>
                                    <p class="mb-0"><b>Email:</b> marcel@gmail.com</p>
                                    <p class="mb-0"><b>Phone:</b> +112131333334</p>
                                </div>
                                <div class="col-md-4">
                                    <p class="mb-0"><b>Buying Agent Name:</b> Marcel Holcaustan</p>
                                    <p class="mb-0"><b>Email:</b> marcel@gmail.com</p>
                                    <p class="mb-0"><b>Phone:</b> +112131333334</p>
                                </div>
                                <div class="col-md-4">
                                    <p class="mb-0"><b>Address:</b><br> House-3, Road-3, Sec-3, Mirpur, Dhaka-1230</p>
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
                                                                        {{date('l', strtotime($task->due_date))}},
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
                                                                        {{date('l', strtotime($task->original_delivery_date))}},
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
                                            <tr>
                                                <td><b>A</b></td>  
                                                <td><b>Cotton</b></td>  
                                                <td><b>Cutting</b></td>  
                                                <td>Wednesday,July 29, 2020</td>  
                                                <td>Wednesday,July 29, 2020</td>  
                                            </tr>  
                                            <tr>
                                                <td><b>B</b></td>  
                                                <td><b>Cotton</b></td>  
                                                <td><b>Cutting</b></td>  
                                                <td>Wednesday,July 29, 2020</td>  
                                                <td>Wednesday,July 29, 2020</td>  
                                            </tr>
                                            <tr>
                                                <td><b>C</b></td>  
                                                <td><b>Cotton</b></b></td>  
                                                <td><b>Cutting</b></b></td>  
                                                <td>Wednesday,July 29, 2020</td>  
                                                <td>Wednesday,July 29, 2020</td>  
                                            </tr>  
                                            <tr>
                                                <td><b>C</b></td>  
                                                <td><b>Spinning</b></td>  
                                                <td><b>Sweing</b></td>  
                                                <td>Wednesday,July 29, 2020</td>  
                                                <td>Wednesday,July 29, 2020</td>  
                                            </tr> 
                                            <tr>
                                                <td><b>C</b></td>  
                                                <td><b>Knitting</b></td>  
                                                <td><b>Finishing</b></td>  
                                                <td>Wednesday,July 29, 2020</td>  
                                                <td>Wednesday,July 29, 2020</td>  
                                            </tr> 
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

