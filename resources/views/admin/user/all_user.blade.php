@extends('layouts.admin_master')
@section('title', 'All User')
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
                        <a href="{{url('/admin')}}">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>All Users</span>
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
                                <span class="caption-subject font-dark bold uppercase">All users</span>
                                <span class="caption-helper"></span>
                            </div>
                            <div class="actions">

                            </div>
                        </div>
                        <div class="portlet-body">
                            <table id="user_list_table" class="table table-striped table-bordered table-hover data-table focus-table">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">
                                            <div class="form-group">
                                                <label class="mt-checkbox">
                                                    <input type="checkbox" class="show-password" name="all_user">
                                                    <span></span>
                                                </label>
                                            </div>
                                        </th>
                                        <th>User ID</th>
                                        <th>Username</th>
                                        <th>User Email</th>
                                        <th>Shipment Date</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach($users as $user){ ?>
                                    <tr>
                                        <td style="width: 50px;">
                                            <div class="form-group">
                                                <label class="mt-checkbox">
                                                    <input type="checkbox" class="show-password" name="all_user">
                                                    <span></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>{{$user->unique_id}}</td>
                                        <td>{{$user->username}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>
                                            @if($user->shipment_date !='')
                                                {{date('l d, M, Y', strtotime($user->shipment_date))}}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <!-- If Task 7days before-->
                                            <div class="user-status bg-warning">
                                                <img class="action-icon" src="{{asset('assets/global/img/icons/tick.png')}}" alt="SMS Sent">
                                            </div>
                                            <!-- If Task done-->
                                            <div class="user-status bg-success"></div>
                                            <!-- If Task not done-->
                                            <div class="user-status bg-danger"></div>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{url('admin/user_dashboard').'?u_id='.$user->id}}" title="User Dashboard">
                                                <img class="action-icon" src="{{asset('assets/global/img/icons/meter.png')}}" alt="Dashboard">
                                            </a>
                                            <a href="#" title="Send Email">
                                                <img class="action-icon" src="{{asset('assets/global/img/icons/mail.png')}}" alt="Email">
                                            </a>
                                            <a href="#" title="Remove User" id="remove_user" onclick="user_status_update_warning({{$user->id}},'deleted')">
                                                <img class="action-icon" src="{{asset('assets/global/img/icons/trash.png')}}" alt="Email">
                                            </a>
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

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#user_list_table').DataTable({
                //"paging":   true,
                //"ordering": true,
                //"info":     true,
                //"searching": true
            });
        });

        function user_status_update_warning(user_id,status){
            $(".warning_message").text('Are you sure you want to '+status+' this user? ');
            $("#warning_modal").modal('show');
            $('#item_id').val(user_id);
            $('#item_type').val(status);
        }

        $(document).on('click','#warning_ok',function() {
            var user_id = $('#item_id').val();
            var status = $('#item_type').val();

            update_user_status(user_id,status);
        });

        function update_user_status(user_id,status){
            var options = {
                theme:"sk-cube-grid",
                message:'Please wait while saving all data.....',
                backgroundColor:"#1847B1",
                textColor:"white"
            };

            HoldOn.open(options);

            var url = "{{ url('admin/update_user_status')}}";
            $.ajax({
                type: "POST",
                url: url,
                data: {user_id:user_id,status:status,'_token':'{{ csrf_token() }}'},
                success: function (data) {
                    HoldOn.close();

                    if(data.status == 200){
                        $('#warning_modal').modal('hide');
                        show_success_message('User Successfully '+status);
                        setTimeout(function(){
                            location.reload();
                        },2000);
                    }
                    else if(data.status == 402){
                        show_error_message(data.reason);
                        setTimeout(function(){
                            window.location.href="{{url('login')}}";
                        },2000);
                    }
                    else{
                        HoldOn.close();
                        show_error_message(data);
                    }
                },
                error: function (data) {
                    HoldOn.close();
                    show_error_message('Authentication failed. Login again.');
                    setTimeout(function(){
                        //window.location.href="{{url('login')}}";
                    },2000);
                }
            });
        }
    </script>
@endsection

