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
                                <span class="caption-subject font-dark bold uppercase">Coupons</span>
                                <span class="caption-helper"></span>
                            </div>
                            <div class="actions" id="action_buttons">
                                <button type="button" class="btn btn-transparent theme-btn btn-circle btn-sm" title="Add New coupon" id="add_new_coupon">Add New Coupon</button>
                            </div>
                        </div>
                        <div class="portlet-body p-relative">
                            <table id="user_list_table" class="table table-striped table-bordered table-hover data-table focus-table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Coupon Code</th>
                                    <th>Discount(%)</th>
                                    <th>Available for</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach($coupons as $key=>$coupon){
                                ?>
                                <tr id="coupon_{{$coupon->id}}">
                                    <td style="width: 50px;">{{$key+1}}</td>
                                    <td>{{$coupon->code}}</td>
                                    <td>{{$coupon->discount}}</td>
                                    <td>{{$coupon->availability}}</td>
                                    <td class="text-center">
                                        <a href="#" title="Edit Offer" onclick="edit_coupon({{$coupon->id}})">
                                            <img class="action-icon" src="{{asset('assets/global/img/icons/edit.png')}}" alt="Edit Offer">
                                        </a>
                                        <a href="#" title="Delete Offer" onclick="delete_coupon({{$coupon->id}})">
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
    <div class="modal fade" id="add_coupon_modal" tabindex="-1" role="add_coupon_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Add New coupon</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="coupon_form" method="post" action="">
                            <div class="col-md-12">
                                <div class="alert alert-success" id="success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="error_message" style="display: none"></div>
                            </div>
                            {{csrf_field()}}

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Coupon Code</label>
                                    <input class="form-control placeholder-no-fix" type="text" placeholder="Enter code*" name="code" id="code" value=""  autocomplete="off"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Discount</label>
                                    <input class="form-control placeholder-no-fix" type="number" placeholder="Enter discount" name="discount" id="discount" value=""  autocomplete="off"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Available for</label>
                                    <input class="form-control placeholder-no-fix" type="number" placeholder="Enter availability" name="availability" id="availability" value=""  autocomplete="off"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn theme-btn pull-right" id="save_coupon">Save</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- Modal -->

    <!-- Modal -->
    <div class="modal fade" id="edit_coupon_modal" tabindex="-1" role="edit_coupon_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Edit coupon</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="edit_coupon_form" method="post" action="">
                            <div class="col-md-12">
                                <div class="alert alert-success" id="edit_success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="edit_error_message" style="display: none"></div>
                            </div>
                            {{csrf_field()}}
                            <input type="hidden" name="coupon_id" id="coupon_id">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Coupon Code</label>
                                    <input class="form-control placeholder-no-fix" type="text" placeholder="Enter code*" name="code" id="edit_code" value=""  autocomplete="off"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Discount</label>
                                    <input class="form-control placeholder-no-fix" type="number" placeholder="Enter discount" name="discount" id="edit_discount" value=""  autocomplete="off"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Available for</label>
                                    <input class="form-control placeholder-no-fix" type="number" placeholder="Enter availability" name="availability" id="edit_availability" value=""  autocomplete="off"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn theme-btn pull-right" id="update_coupon">Save</button>
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
                //     //"paging":   true,
                //     //"ordering": true,
                //     //"info":     true,
                //     //"searching": true
            });
        });

        $(document).on('click','#add_new_coupon',function(){
            $("#add_coupon_modal").modal('show');
        });

        $(document).on("click", "#save_coupon", function(event) {
            event.preventDefault();

            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while saving data.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);

            var code = $("#code").val();
            var discount = $("#discount").val();
            var availability = $("#availability").val();

            var validate = "";

            if (code.trim() == "") {
                validate = validate + "Coupon code is required</br>";
            }
            if (discount.trim() == "") {
                validate = validate + "Discount amount is required</br>";
            }
            if (availability.trim() == "") {
                validate = validate + "Availability is required</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#coupon_form")[0]);
                var url = "{{ url('admin/save_coupon') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(data) {
                        HoldOn.close();
                        if (data.status == 200) {
                            $("#add_coupon_modal").modal('hide');

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

        function edit_coupon(id){
            var url = "{{ url('admin/get_coupon') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {id:id,'_token':'{{ csrf_token() }}'},
                success: function (data) {

                    if(data.status == 200){
                        $('#coupon_id').val(id);
                        $("#edit_code").val(data.coupon.code);
                        $("#edit_discount").val(data.coupon.discount);
                        $("#edit_availability").val(data.coupon.availability);
                        $("#edit_coupon_modal").modal('show');
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

        $(document).on("click", "#update_coupon", function(event) {
            event.preventDefault();

            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while saving data.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);

            var code = $("#edit_code").val();
            var discount = $("#edit_discount").val();
            var availability = $("#edit_availability").val();

            var validate = "";

            if (code.trim() == "") {
                validate = validate + "Coupon code is required</br>";
            }
            if (discount.trim() == "") {
                validate = validate + "Discount amount is required</br>";
            }
            if (availability.trim() == "") {
                validate = validate + "Availability is required</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#edit_coupon_form")[0]);
                var url = "{{ url('admin/update_coupon') }}";

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

        function delete_coupon(id){
            $(".warning_message").text('Are you sure you delete this coupon? ');
            $("#warning_modal").modal('show');
            $( "#warning_ok" ).on('click',function() {
                event.preventDefault();

                show_loader();

                var url = "{{ url('admin/delete_coupon')}}";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {id:id,'_token':'{{ csrf_token() }}'},
                    async: false,
                    success: function (data) {
                        hide_loader();

                        if(data.status == 200){
                            $('#warning_modal').modal('hide');
                            $('#coupon_'+id).remove();
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

