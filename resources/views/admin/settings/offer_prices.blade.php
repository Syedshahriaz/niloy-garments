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
                                <span class="caption-subject font-dark bold uppercase">Offer prices</span>
                                <span class="caption-helper"></span>
                            </div>
                            <div class="actions" id="action_buttons">
                                <button type="button" class="btn btn-transparent theme-btn btn-circle btn-sm" title="Add New Country" id="add_new_country">Add New Country</button>
                            </div>
                        </div>
                        <div class="portlet-body p-relative">
                            <table id="user_list_table" class="table table-striped table-bordered table-hover data-table focus-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Country Name</th>
                                        <th>Country Code</th>
                                        <th>Currency</th>
                                        <th>Offer 1 Price</th>
                                        <th>Offer 2 Price</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach($offer_prices as $key=>$offer_price){
                                ?>
                                <tr>
                                    <td style="width: 50px;">{{$key+1}}</td>
                                    <td>{{$offer_price->country_name}}</td>
                                    <td>{{$offer_price->country_code}}</td>
                                    <td>{{$offer_price->currency}}</td>
                                    <td>{{$offer_price->offer_1_price}}</td>
                                    <td>{{$offer_price->offer_2_price}}</td>
                                    <td class="text-center">
                                        <a href="#" title="Edit Offer" onclick="edit_offer({{$offer_price->id}})">
                                            <img class="action-icon" src="{{asset('assets/global/img/icons/edit.png')}}" alt="Dashboard">
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
    <div class="modal fade" id="add_country_modal" tabindex="-1" role="add_country_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Add New Country</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="country_form" method="post" action="">
                            <div class="col-md-12">
                                <div class="alert alert-success" id="success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="error_message" style="display: none"></div>
                            </div>
                            {{csrf_field()}}

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Country</label>
                                    <select class="form-control placeholder-no-fix" placeholder="Select country*" name="country" id="country" value=""  autocomplete="off">
                                        <option value="">Select</option>
                                        <option value="Bangladesh#+88">Bangladesh(+88)</option>
                                        <option value="China#+86">China(+86)</option>
                                        <option value="India#+91">India(+91)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Currency</label>
                                    <select class="form-control placeholder-no-fix" placeholder="Select currency*" name="currency" id="currency" value=""  autocomplete="off">
                                        <option value="">Select</option>
                                        <option value="BDT">BDT</option>
                                        <option value="USD">USD</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Offer 1 Price</label>
                                    <input class="form-control placeholder-no-fix" type="text" placeholder="Enter offer price*" name="offer_1_price" id="offer_1_price" value=""  autocomplete="off"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Offer 2 Price</label>
                                    <input class="form-control placeholder-no-fix" type="text" placeholder="Enter offer price*" name="offer_2_price" id="offer_2_price" value=""  autocomplete="off"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn theme-btn pull-right" id="save_country">Save</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- Modal -->

    <!-- Modal -->
    <div class="modal fade" id="edit_country_modal" tabindex="-1" role="edit_country_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Add New Country</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="edit_country_form" method="post" action="">
                            <div class="col-md-12">
                                <div class="alert alert-success" id="edit_success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="edit_error_message" style="display: none"></div>
                            </div>
                            {{csrf_field()}}
                            <input type="hidden" name="country_id" id="country_id">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Country</label>
                                    <select class="form-control placeholder-no-fix" placeholder="Select country*" name="country" id="edit_country" value="" disabled autocomplete="off">
                                        <option value="">Select</option>
                                        <option value="Bangladesh#+88">Bangladesh(+88)</option>
                                        <option value="China#+86">China(+86)</option>
                                        <option value="India#+91">India(+91)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Currency</label>
                                    <select class="form-control placeholder-no-fix" placeholder="Select currency*" name="currency" id="edit_currency" value=""  autocomplete="off">
                                        <option value="">Select</option>
                                        <option value="BDT">BDT</option>
                                        <option value="USD">USD</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Offer 1 Price</label>
                                    <input class="form-control placeholder-no-fix" type="text" placeholder="Enter offer price*" name="offer_1_price" id="edit_offer_1_price" value=""  autocomplete="off"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Offer 2 Price</label>
                                    <input class="form-control placeholder-no-fix" type="text" placeholder="Enter offer price*" name="offer_2_price" id="edit_offer_2_price" value=""  autocomplete="off"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn theme-btn pull-right" id="update_country">Save</button>
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

        $(document).on('click','#add_new_country',function(){
            $("#add_country_modal").modal('show');
        });

        $(document).on("click", "#save_country", function(event) {
            event.preventDefault();

            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while sending email.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);

            var country = $("#country").val();
            var currency = $("#currency").val();
            var offer_1_price = $("#offer_1_price").val();
            var offer_2_price = $("#offer_2_price").val();

            var validate = "";

            if (country.trim() == "") {
                validate = validate + "Country is required</br>";
            }
            if (currency.trim() == "") {
                validate = validate + "Currency is required</br>";
            }
            if (offer_1_price.trim() == "") {
                validate = validate + "Offer 1 price is required</br>";
            }
            if (offer_2_price.trim() == "") {
                validate = validate + "Offer 2 price is required</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#country_form")[0]);
                var url = "{{ url('admin/save_country_offer') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(data) {
                        HoldOn.close();
                        if (data.status == 200) {
                            $("#add_country_modal").modal('hide');

                            $("#success_message").show();
                            $("#error_message").hide();
                            $("#success_message").html(data.reason);
                            setTimeout(function(){
                                $("#add_country_modal").modal('hide');
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

        function edit_offer(id){
            var url = "{{ url('admin/get_country_offer') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {id:id,'_token':'{{ csrf_token() }}'},
                success: function (data) {

                    if(data.status == 200){
                        $('#country_id').val(id);
                        $('#edit_country').val(data.offer_price.country_name+'#'+data.offer_price.country_code);
                        $('#edit_currency').val(data.offer_price.currency);
                        $('#edit_offer_1_price').val(data.offer_price.offer_1_price);
                        $('#edit_offer_2_price').val(data.offer_price.offer_2_price);
                        $("#edit_country_modal").modal('show');
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

        $(document).on("click", "#update_country", function(event) {
            event.preventDefault();

            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while sending email.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);

            var country = $("#edit_country").val();
            var currency = $("#edit_currency").val();
            var offer_1_price = $("#edit_offer_1_price").val();
            var offer_2_price = $("#edit_offer_2_price").val();

            var validate = "";

            if (country.trim() == "") {
                validate = validate + "Country is required</br>";
            }
            if (currency.trim() == "") {
                validate = validate + "Currency is required</br>";
            }
            if (offer_1_price.trim() == "") {
                validate = validate + "Offer 1 price is required</br>";
            }
            if (offer_2_price.trim() == "") {
                validate = validate + "Offer 2 price is required</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#edit_country_form")[0]);
                var url = "{{ url('admin/update_country_offer') }}";

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
                                $("#add_country_modal").modal('hide');
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

    </script>
@endsection

