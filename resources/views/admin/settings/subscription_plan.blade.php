@extends('layouts.admin_master')
@section('title', 'All County Price')
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
                        <span>Settings</span>
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
                                <span class="caption-subject font-dark bold uppercase">Subscription Plans</span>
                                <span class="caption-helper"></span>
                            </div>
                            <div class="actions" id="action_buttons">
                                <button type="button" class="btn btn-transparent theme-btn btn-circle btn-sm" title="Add New Subscription Plan" id="add_new_subscription_plan">Add New Subscription Plan</button>
                            </div>
                        </div>
                        <div class="portlet-body p-relative">
                            <table id="user_list_table" class="table table-striped table-bordered table-hover data-table focus-table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach($subscription_plans as $key=>$subscription_plan){
                                ?>
                                <tr id="subscription_plan_{{$subscription_plan->id}}">
                                    <td style="width: 50px;">{{$key+1}}</td>
                                    <td>{{$subscription_plan->name}}</td>
                                    <td class="text-center">
                                        <a href="#" title="Edit Offer" onclick="edit_subscription_plan({{$subscription_plan->id}})">
                                            <img class="action-icon" src="{{asset('assets/global/img/icons/edit.png')}}" alt="Edit Offer">
                                        </a>
                                        <a href="#" title="Delete Offer" onclick="delete_subscription_plan({{$subscription_plan->id}})">
                                            <img class="action-icon" src="{{asset('assets/global/img/icons/trash.png')}}" alt="Delete Offer">
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

    <!-- Modal -->
    <div class="modal fade" id="add_subscription_plan_modal" tabindex="-1" role="add_subscription_plan_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Add New Subscription Plan</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="subscription_plan_form" method="post" action="">
                            <div class="col-md-12">
                                <div class="alert alert-success" id="success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="error_message" style="display: none"></div>
                            </div>
                            {{csrf_field()}}

                            <div class="col-md-12">
                                <label class="control-label">Subscription Plan</label> <br>
                                <div class="form-group">
                                    Upto <input class="form-control placeholder-no-fix" type="number" placeholder="Enter year" name="year" id="year" value=""  autocomplete="off"/>
                                    Years
                                </div>
                                <div class="form-group">
                                    <input class="" type="checkbox" name="is_lifetime" id="is_lifetime" value="1"  autocomplete="off"/> <label for="is_lifetime">Is Lifetime </label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn theme-btn pull-right" id="save_subscription_plan">Save</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- Modal -->

    <!-- Modal -->
    <div class="modal fade" id="edit_subscription_plan_modal" tabindex="-1" role="edit_subscription_plan_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Edit Subscription Plan</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="edit_subscription_plan_form" method="post" action="">
                            <div class="col-md-12">
                                <div class="alert alert-success" id="edit_success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="edit_error_message" style="display: none"></div>
                            </div>
                            {{csrf_field()}}
                            <input type="hidden" name="subscription_plan_id" id="subscription_plan_id">

                            <div class="col-md-12">
                                <label class="control-label">Subscription Plan</label> <br>
                                <div class="form-group">
                                    Upto <input class="form-control placeholder-no-fix" type="number" placeholder="Enter year" name="year" id="edit_year" value=""  autocomplete="off"/>
                                    Years
                                </div>
                                <div class="form-group">
                                    <input class="" type="checkbox" name="is_lifetime" id="edit_is_lifetime" value="1"  autocomplete="off"/> <label for="edit_is_lifetime">Is Lifetime </label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn theme-btn pull-right" id="update_subscription_plan">Save</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- Modal -->

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#user_list_table').DataTable({
                "paging":   false,
                //     //"ordering": true,
                //     //"info":     true,
                //     //"searching": true
            });
        });

        $(document).on('click','#add_new_subscription_plan',function(){
            $("#add_subscription_plan_modal").modal('show');
        });

        $(document).on("click", "#save_subscription_plan", function(event) {
            event.preventDefault();

            $('#save_subscription_plan').prop('disabled',true);

            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while saving data.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);

            var year = $("#year").val();

            var validate = "";

            if(!$('#is_lifetime').is(":checked")){
                if (year.trim() == "") {
                    validate = validate + "Year is required</br>";
                }
            }

            if (validate == "") {
                var formData = new FormData($("#subscription_plan_form")[0]);
                var url = "{{ url('admin/save_subscription_plan') }}";

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
                            $('#save_subscription_plan').prop('disabled',false);

                            $("#success_message").hide();
                            $("#error_message").show();
                            $("#error_message").html(data.reason);
                        }
                    },
                    error: function(data) {
                        $('#save_subscription_plan').prop('disabled',false);
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
                $('#save_subscription_plan').prop('disabled',false);
                HoldOn.close();
                $("#success_message").hide();
                $("#error_message").show();
                $("#error_message").html(validate);
            }
        });

        function edit_subscription_plan(id){
            var url = "{{ url('admin/get_subscription_plan') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {id:id,'_token':'{{ csrf_token() }}'},
                success: function (data) {

                    if(data.status == 200){
                        $('#subscription_plan_id').val(id);
                        $("#edit_year").val(data.subscription_plan.year);
                        if(data.subscription_plan.name=='Lifetime'){
                            $('#edit_is_lifetime').prop('checked',true);
                        }
                        $("#edit_subscription_plan_modal").modal('show');
                    }
                    else{
                        //
                    }
                },
                error: function (data) {
                    show_error_message(data);
                }
            });
        }

        $(document).on("click", "#update_subscription_plan", function(event) {
            event.preventDefault();

            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while saving data.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);

            var year = $("#edit_year").val();

            var validate = "";

            if(!$('#edit_is_lifetime').is(":checked")){
                if (year.trim() == "") {
                    validate = validate + "Year is required</br>";
                }
            }

            if (validate == "") {
                var formData = new FormData($("#edit_subscription_plan_form")[0]);
                var url = "{{ url('admin/update_subscription_plan') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(data) {
                        HoldOn.close();
                        if (data.status == 200) {
                            $("#edit_success_message").show();
                            $("#edit_error_message").hide();
                            $("#edit_success_message").html(data.reason);
                            setTimeout(function(){
                                location.reload();
                            },2000)
                        } else {
                            $("#edit_success_message").hide();
                            $("#edit_error_message").show();
                            $("#edit_error_message").html(data.reason);
                        }
                    },
                    error: function(data) {
                        HoldOn.close();
                        $("#edit_success_message").hide();
                        $("#edit_error_message").show();
                        $("#edit_error_message").html(data);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            } else {
                HoldOn.close();
                $("#edit_success_message").hide();
                $("#edit_error_message").show();
                $("#edit_error_message").html(validate);
            }
        });

        function delete_subscription_plan(id){
            $(".warning_message").text('Are you sure you delete this subscription plan? ');
            $("#warning_modal").modal('show');
            $( "#warning_ok" ).on('click',function() {
                event.preventDefault();

                show_loader();

                var url = "{{ url('admin/delete_subscription_plan')}}";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {id:id,'_token':'{{ csrf_token() }}'},
                    async: false,
                    success: function (data) {
                        hide_loader();

                        if(data.status == 200){
                            $('#warning_modal').modal('hide');
                            $('#subscription_plan_'+id).remove();
                        }
                        else{
                            show_error_message(data);
                        }
                    },
                    error: function (data) {
                        show_authentication_error_message();
                    }
                });
            });
        }

    </script>
@endsection

