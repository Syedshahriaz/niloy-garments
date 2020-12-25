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
                                <span class="caption-subject font-dark bold uppercase">COVID Vaccine Companies</span>
                                <span class="caption-helper"></span>
                            </div>
<!--                            <div class="actions" id="action_buttons">
                                <button type="button" class="btn btn-transparent theme-btn btn-circle btn-sm" title="Add New COVID Vaccine Company" id="add_new_covid_vaccine_company">Add New COVID Vaccine Company</button>
                            </div>-->
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
                                foreach($covid_vaccine_companies as $key=>$company){
                                ?>
                                <tr id="covid_vaccine_company_{{$company->id}}">
                                    <td style="width: 50px;">{{$key+1}}</td>
                                    <td>{{$company->name}}</td>
                                    <td class="text-center">
                                        <a href="#" title="Edit Offer" onclick="edit_covid_vaccine_company({{$company->id}})">
                                            <img class="action-icon" src="{{asset('assets/global/img/icons/edit.png')}}" alt="Edit Offer">
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
    <div class="modal fade" id="add_covid_vaccine_company_modal" tabindex="-1" role="add_covid_vaccine_company_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Add New COVID Vaccine Company</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="covid_vaccine_company_form" method="post" action="">
                            <div class="col-md-12">
                                <div class="alert alert-success" id="success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="error_message" style="display: none"></div>
                            </div>
                            {{csrf_field()}}

                            <div class="col-md-12">
                                <label class="control-label">COVID Vaccine Company</label> <br>
                                <div class="form-group">
                                    Upto <input class="form-control placeholder-no-fix" type="number" placeholder="Enter name" name="name" id="name" value=""  autocomplete="off"/>
                                    names
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
                        <button type="submit" class="btn theme-btn pull-right" id="save_covid_vaccine_company">Save</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- Modal -->

    <!-- Modal -->
    <div class="modal fade" id="edit_covid_vaccine_company_modal" tabindex="-1" role="edit_covid_vaccine_company_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Edit COVID Vaccine Company</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="edit_covid_vaccine_company_form" method="post" action="">
                            <div class="col-md-12">
                                <div class="alert alert-success" id="edit_success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="edit_error_message" style="display: none"></div>
                            </div>
                            {{csrf_field()}}
                            <input type="hidden" name="covid_vaccine_company_id" id="covid_vaccine_company_id">

                            <div class="col-md-12">
                                <label class="control-label">Name</label> <br>
                                <div class="form-group">
                                    <input class="form-control placeholder-no-fix" type="text" placeholder="Enter name" name="name" id="edit_name" value=""  autocomplete="off"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn theme-btn pull-right" id="update_covid_vaccine_company">Save</button>
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

        function edit_covid_vaccine_company(id){
            var url = "{{ url('admin/get_covid_vaccine_company') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {id:id,'_token':'{{ csrf_token() }}'},
                success: function (data) {

                    if(data.status == 200){
                        $('#covid_vaccine_company_id').val(id);
                        $("#edit_name").val(data.covid_vaccine_company.name);
                        $("#edit_covid_vaccine_company_modal").modal('show');
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
        $(document).on("submit", "#edit_covid_vaccine_company_form", function(event) {
            event.preventDefault();
        });

        $(document).on("click", "#update_covid_vaccine_company", function(event) {
            event.preventDefault();

            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while saving data.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);

            var name = $("#edit_name").val();

            var validate = "";

            if (name.trim() == "") {
                validate = validate + "Name is required</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#edit_covid_vaccine_company_form")[0]);
                var url = "{{ url('admin/update_covid_vaccine_company') }}";

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

    </script>
@endsection

