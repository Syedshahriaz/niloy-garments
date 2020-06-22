@extends('layouts.admin_master')
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
                        <a href="{{url('admin')}}">Home</a>
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
                                @if(!empty($buyer))
                                    <div class="col-md-4">
                                        <p class="mb-0"><b>Buyer Name:</b> {{$buyer->buyer_name}}</p>
                                        <p class="mb-0"><b>Email:</b> {{$buyer->buyer_email}}</p>
                                        <p class="mb-0"><b>Phone:</b> {{$buyer->buyer_phone}}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-0"><b>Buying Agent Name:</b> {{$buyer->buying_agent_name}}</p>
                                        <p class="mb-0"><b>Email:</b> {{$buyer->buying_agent_email}}</p>
                                        <p class="mb-0"><b>Phone:</b> {{$buyer->buying_agent_phone}}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-0"><b>Address:</b><br> {{$buyer->address}}</p>
                                    </div>
                                @endif
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
                                    <input class="form-control placeholder-no-fix" type="text" name="buyer_phone" id="buyer_phone" onkeyup="this.value=this.value.replace(/[^\d]/,'')" value="@if(!empty($buyer)){{$buyer->buyer_phone}}@endif"/>
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
                                    <input class="form-control placeholder-no-fix" type="text" name="buying_agent_phone" id="buying_agent_phone" onkeyup="this.value=this.value.replace(/[^\d]/,'')" value="@if(!empty($buyer)){{$buyer->buying_agent_phone}}@endif"/>
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

        function open_buyer_modal(){
            $('#create_buyer_modal').modal('show');
        }

        $(document).on("click", "#save_buyer_button", function(event) {
            event.preventDefault();

            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while saving all data.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);

            var buyer_name = $("#buyer_name").val();
            var buyer_email = $("#buyer_email").val();
            var buying_agent_name = $("#buying_agent_name").val();
            var buying_agent_email = $("#buying_agent_email").val();
            var re = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            var validate = "";

            if (buyer_name.trim() == "") {
                validate = validate + "Buyer name is required</br>";
            }
            /*if (phone.trim() == "") {
                validate = validate + "Phone is required</br>";
            }*/
            if(buyer_email.trim()!=''){
                if(!re.test(buyer_email)){
                    validate = validate+'Buyer email is invalid<br>';
                }
            }
            if(buying_agent_email.trim()!=''){
                if(!re.test(buying_agent_email)){
                    validate = validate+'Buying agent email is invalid<br>';
                }
            }

            if (validate == "") {
                var formData = new FormData($("#buyer_form")[0]);
                var url = "{{ url('save_buyer') }}";

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
                                location.reload();
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
