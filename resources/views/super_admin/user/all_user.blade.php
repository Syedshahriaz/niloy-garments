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
                        </div>
                        <div class="portlet-body p-relative">
                            <div class="all_user_sort">
                            </div>
                            <table id="user_list_table" class="table table-striped table-bordered table-hover data-table focus-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>User Email</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach($users as $user){
                                ?>
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->username}}</td>
                                        <td>{{$user->email}}</td>
                                        <td class="text-center" style="min-width: 170px;">
                                            <a href="#" title="Edit User" id="remove_user" onclick="edit_user({{$user->id}},'deleted')">
                                                <img class="action-icon" src="{{asset('assets/global/img/icons/edit.png')}}" alt="Email">
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


    <div class="modal fade" id="edit_user_modal" tabindex="-2" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Edit User </h4>

                </div>
                <div class="modal-body">
                    <form id="edit_user_form" class="mt-20" method="post" action="" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="user_id" id="user_id">
                        <div class="alert alert-success" id="edit_success_message" style="display:none"></div>
                        <div class="alert alert-danger" id="edit_error_message" style="display: none"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">User Name</label>
                                    <input type="text" class="form-control" placeholder="Full Name" name="username"
                                           id="edit_username" readonly>
                                </div>
                            </div>

                            <div class="col-md-12 mt-10">
                                <strong class="bdr-btm">Permission:</strong>
                            </div>


                            @foreach($permissions as $key => $permission)
                                <div class="col-md-12">
                                    <h3> {{ ucfirst($key) }}</h3>
                                    <div class="row">
                                        @foreach($permission as $key2=>$value)
                                            <div class="col-md-3">
                                                <div class="form-group" id="list">
                                                    <input type="checkbox" class="name" value="{{ $value["id"]}}"
                                                           name="permission[]"
                                                           id="permission_{{$value['id']}}"/>
                                                    <label for="permission_{{$value['id']}}">{{ $value["details"] }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="update_button">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end confirm modal -->

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // $('#user_list_table').DataTable({
            //     //"paging":   true,
            //     //"ordering": true,
            //     //"info":     true,
            //     //"searching": true
            // });
            $(function() {
                var table = $('#user_list_table').DataTable({
                    "columnDefs": [
                        {
                            "targets": [ 4 ],
                            "visible": false
                        }
                    ]
                });
                $('#payment_check').on( 'change', function () {
                    var select_val = $(this).val();
                    table
                        .columns(4)
                        .search(select_val)
                        .draw();
                });
            });
        });

        $(document).on('click','.offer-option-item',function(){
            $('.offer-item').removeClass('selected-offer')
            $(this).parent('.offer-item').addClass('selected-offer');
            $(this).children('input[type="radio"]').prop('checked',true);
        });

        $(document).ready(function() {
        });

        /* checkbox select all*/


        function edit_user(user_id){
            var url = "{{ url('admin/edit_admin_user')}}";
            $.ajax({
                type: "POST",
                url: url,
                data: {user_id:user_id,'_token':'{{ csrf_token() }}'},
                success: function (data) {
                    HoldOn.close();

                    if(data.status == 200){
                        var user = data.user;
                        var permissions = data.user.permissions;
                        $("#user_id").val(user.id);
                        $("#edit_username").val(user.username);

                        /*
                        * Make selected permission checkbox checked for this user
                        * */
                        $('.name').prop('checked',false);
                        $.each(permissions, function( index, value ) {
                            $('#permission_'+value.permission_id).prop('checked',true);
                        });

                        $("#edit_user_modal").modal("show");
                    }
                    else{
                        show_error_message(data.reason);
                    }
                },
                error: function (data) {
                    show_error_message(data);
                }
            });
        }

        $(document).on('click','#update_button', function(event){
            event.preventDefault();

            var validate = "";

            if (validate == "") {
                var formData = new FormData($("#edit_user_form")[0]);
                var url = "{{ url('admin/update_admin_user') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(data) {
                        if (data.status == 200) {
                            location.reload();
                        } else {

                        }
                    },
                    error: function(data) {
                        $("#success_message").hide();
                        $("#error_message").show();
                        $("#error_message").html(data.reason);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            } else {
                $("#success_message").hide();
                $("#error_message").show();
                $("#error_message").html(validate);
            }
        });

        function user_status_update_warning(user_id,status){
            $(".warning_message").text('Are you sure you want to '+status+' this users? This can not be undone in future.');
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

            var url = "{{ url('admin/update_admin_user_status')}}";
            $.ajax({
                type: "POST",
                url: url,
                data: {user_id:user_id,status:status,'_token':'{{ csrf_token() }}'},
                success: function (data) {
                    HoldOn.close();

                    if(data.status == 200){
                        $('#warning_modal').modal('hide');
                        //show_success_message('User Successfully '+status);
                        location.reload();
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

