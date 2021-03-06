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
                            @if(App\Common::can_access('custom_sms'))
                                <button type="button" class="btn btn-transparent theme-btn btn-circle btn-sm custom-sms" title="Send Custom SMS" id="send_sms_custom">Send Custom SMS</button>
                            @endif
                            <div class="actions hidden" id="action_buttons">
                                @if(App\Common::can_access('send_email'))
                                    <button type="button" class="btn btn-transparent theme-btn btn-circle btn-sm" title="Send All Email" id="send_email_all">Send All Email</button>
                                @endif
                                @if(App\Common::can_access('send_sms'))
                                    <button type="button" class="btn btn-transparent theme-btn btn-circle btn-sm" title="Send All SMS" id="send_sms_all">Send SMS to User</button>
                                @endif
                                @if(App\Common::can_access('delete_user'))
                                    <button type="button" class="btn btn-transparent theme-btn btn-circle btn-sm" title="Remove Users" id="delete_user_all">Delete Users</button>
                                @endif
                            </div>
                        </div>
                        <div class="portlet-body p-relative">
                            <div class="all_user_sort">
                                <select class="form-control" id="payment_check">
                                    <option value="">Sort by payment Status</option>
                                    <option value="active">Paid</option>
                                    <option value="pending">Unpaid</option>
                                </select>
                            </div>
                            <table id="user_list_table" class="table table-striped table-bordered table-hover data-table focus-table">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">
                                            <div class="form-group">
                                                <label class="mt-checkbox">
                                                    <input type="checkbox" class="show-password" name="all_user" id="selectall">
                                                    <span></span>
                                                </label>
                                            </div>
                                        </th>
                                        <th>User ID</th>
                                        <th>Username</th>
                                        <th>User Email</th>
                                        <th>Payment Status</th>
                                        <th>Birth Date</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach($users as $user){
                                    $user_projects = $user->projects;
                                    $passed = 0;
                                    $upcoming = 0;
                                    $test = '';
                                    $last = '';
                                    if(!empty($user_projects)){
                                        foreach($user_projects as $u_project){
                                            if(!empty($u_project->passed_task)){
                                                $passed = 1;
                                            }
                                        }

                                        foreach($user_projects as $u_project){
                                            if(!empty($u_project->recent_due_task)){
                                                $upcoming = 1;
                                            }
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="mt-checkbox">
                                                    <input type="checkbox" class="show-password name user_checkbox" name="all_user" value="{{$user->id}}" id="checkbox-1-{{$user->id}}">
                                                    <span></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>{{$user->unique_id}}</td>
                                        <td>{{$user->username}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>
                                            @if($user->payment_status=='Completed')
                                                active
                                            @else
                                                pending
                                            @endif
                                        </td>
                                        <td style="min-width: 170px;">
                                            @if($user->shipment_date !='')
                                                {{date('l d, M, Y', strtotime($user->shipment_date))}}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <!-- If Task done-->
                                            {{--<div class="user-status bg-success"></div>--}}
                                            <!-- If Task not done-->
                                            @if($passed==1)
                                                <div class="user-status bg-danger"></div>
                                            @endif
                                            @if($upcoming==1)
                                                <!-- If Task 7days before-->
                                                <div class="user-status bg-warning">
                                                    <img class="action-icon" src="{{asset('assets/global/img/icons/tick.png')}}" alt="SMS Sent">
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-center" style="min-width: 170px;">
                                            @if(App\Common::can_access('user_dashboard'))
                                                <a href="{{url('admin/user_dashboard').'?u_id='.$user->id}}" title="User Dashboard">
                                                    <img class="action-icon" src="{{asset('assets/global/img/icons/speed.png')}}" alt="Dashboard">
                                                </a>
                                            @endif
                                            @if(App\Common::can_access('update_payment'))
                                                @if($user->payment_status != 'Completed')
                                                    <a href="#" title="Update Payment" onclick="update_payment({{$user->id}})">
                                                        <img class="action-icon" src="{{asset('assets/global/img/icons/payment_update.png')}}" alt="Change Offer">
                                                    </a>
                                                @endif
                                            @endif
                                            @if(App\Common::can_access('change_offer'))
                                                <a href="#" title="Change Offer" onclick="change_offer({{$user->id}})">
                                                    <img class="action-icon" src="{{asset('assets/global/img/icons/offer.png')}}" alt="Change Offer">
                                                </a>
                                            @endif
                                            @if($user->shipment_date !=''){{-- If covid vaccine(project) already selected --}}
                                                <a href="#" title="Change COVID Vaccine Company" onclick="change_covid_vaccine_company({{$user->id}})">
                                                    <img class="action-icon" src="{{asset('assets/global/img/icons/covid19.png')}}" alt="Change COVID Vaccine Company">
                                                </a>
                                            @endif
                                            @if(App\Common::can_access('edit_email'))
                                                @if($user->parent_id==0)
                                                <a href="#" title="Change Email" onclick="edit_email({{$user->id}},'{{$user->email}}')">
                                                    <img class="action-icon" src="{{asset('assets/global/img/icons/edit_email.png')}}" alt="Change Email">
                                                </a>
                                                @endif
                                            @endif
                                            @if(App\Common::can_access('unlock_birth_date'))
                                                <a href="#" title="Unlock Birth Date" onclick="unlock_birth_date({{$user->id}})">
                                                    <img class="action-icon" src="{{asset('assets/global/img/icons/date_unlock.png')}}" alt="Change Offer">
                                                </a>
                                            @endif
                                            @if(App\Common::can_access('unlock_user_gender'))
                                                <a href="#" title="Unlock User Gender" onclick="unlock_user_gender({{$user->id}})">
                                                    <img class="action-icon" src="{{asset('assets/global/img/icons/gender.png')}}" alt="Change Offer">
                                                </a>
                                                @endif
                                            @if(App\Common::can_access('send_email'))
                                                <a href="#" title="Send Email" onclick="send_email({{$user->id}})">
                                                    <img class="action-icon" src="{{asset('assets/global/img/icons/mail.png')}}" alt="Email">
                                                </a>
                                            @endif
                                            @if(App\Common::can_access('send_sms'))
                                                <a href="#" title="Send SMS" onclick="send_sms({{$user->id}},'{{$user->country_code}}','{{$user->phone}}')">
                                                    <img class="action-icon" src="{{asset('assets/global/img/icons/sms.png')}}" alt="Email">
                                                </a>
                                            @endif
                                            @if(App\Common::can_access('send_message'))
                                                <a href="#" title="Send Message" onclick="send_message({{$user->id}},{{$user->message_id}})">
                                                    <img class="action-icon" src="{{asset('assets/global/img/icons/message.png')}}" alt="Email">
                                                </a>
                                            @endif
                                            @if(App\Common::can_access('delete_user'))
                                                <a href="#" title="Remove User" id="remove_user" onclick="user_status_update_warning({{$user->id}},'deleted')">
                                                    <img class="action-icon" src="{{asset('assets/global/img/icons/trash.png')}}" alt="Email">
                                                </a>
                                            @endif
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
    <div class="modal fade" id="send_email_modal" tabindex="-1" role="send_email_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Send email</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="email_form" method="post" action="">
                            <div class="col-md-12">
                                <div class="alert alert-success" id="success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="error_message" style="display: none"></div>
                            </div>
                            {{csrf_field()}}
                            <input type="hidden" name="user_id" id="user_id" value="">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Subject</label>
                                    <input class="form-control placeholder-no-fix" type="text" placeholder="Enter email subject*" name="subject" id="subject" value=""  autocomplete="off"/>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Message</label>
                                    <textarea class="form-control placeholder-no-fix" name="message" id="email_message"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn theme-btn pull-right" id="send_email">Send Email</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    <!-- Modal -->
    <div class="modal fade" id="send_sms_modal" tabindex="-1" role="send_sms_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Send SMS</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="sms_form" method="post" action="">
                            <div class="col-md-12">
                                <div class="alert alert-success" id="sms_success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="sms_error_message" style="display: none"></div>
                            </div>
                            {{csrf_field()}}
                            <input type="hidden" name="user_id" id="sms_user_id" value="">
                            <input type="hidden" name="sms_type" id="sms_type" value="">

                            <div class="col-md-12">
                                <div class="form-group" id="telephone_area">
                                    <label class="control-label">Phone*</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" id="phone-addon">+88</span>
                                        <input class="form-control placeholder-no-fix" id="phone" type="text" name="phone" placeholder="017********" aria-describedby="phone-addon" onkeyup="this.value=this.value.replace(/[^\d]/,'')" value="" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Message</label>
                                    <textarea class="form-control placeholder-no-fix" rows="6" name="message" id="sms_message"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn theme-btn pull-right" id="send_sms">Send SMS</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="send_custom_sms_modal" tabindex="-1" role="send_custom_sms_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="send_custom_sms_modalLabel">Send SMS</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="custom_sms_form" method="post" action="">
                            <div class="col-md-12">
                                <div class="alert alert-success" id="custom_sms_success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="custom_sms_error_message" style="display: none"></div>
                            </div>
                            {{csrf_field()}}
                            <input type="hidden" name="user_id" id="custom_sms_user_id" value="">
                            <input type="hidden" name="sms_type" id="custom_sms_type" value="">

                            <div class="col-md-12">
                                <div class="form-group" id="">
                                    <label class="control-label">Phone*</label>
                                    {{--<div class="input-group">
                                        <span class="input-group-addon" id="phone-addon">+88</span>
                                        <input class="form-control placeholder-no-fix" id="telephone01" type="text" name="phone" placeholder="017********" aria-describedby="phone-addon" onkeyup="this.value=this.value.replace(/[^\d]/,'')" value="" />
                                    </div>--}}
                                    <div>
                                        <input type="text" class="form-control" name="phone" id="telephone01" onkeyup="this.value=this.value.replace(/[^\d]/,'')" value="">
                                        <span id="valid-msg" class="hide">✓ Valid</span>
                                        <span id="error-msg" class="hide">Invalid</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Message</label>
                                    <textarea class="form-control placeholder-no-fix" rows="6" name="message" id="custom_sms_message"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn theme-btn pull-right" id="send_custom_sms">Send SMS</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="send_message_modal" tabindex="-1" role="send_message_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Send Message</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="message_form" method="post" action="" enctype="multipart/form-data">
                            <div class="col-md-12">
                                <div class="alert alert-success" id="message_success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="message_error_message" style="display: none"></div>
                            </div>
                            {{csrf_field()}}
                            <input type="hidden" name="user_id" id="message_user_id" value="">
                            <input type="hidden" name="message_id" id="message_id" value="">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Message</label>
                                    <textarea class="form-control placeholder-no-fix" name="message" id="message"></textarea>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">File</label>
                                    <input class="form-control placeholder-no-fix" type="file" name="message_file" id="image_upload_input" value=""  autocomplete="off"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn theme-btn pull-right" id="send_message">Send Message</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- END CONTENT -->

    <!-- Modal -->
    <div class="modal fade" id="change_offer_modal" tabindex="-1" role="change_offer_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Change offer</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="offer_form" method="post" action="">
                            <div class="col-md-12">
                                <div class="alert alert-success" id="offer_success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="offer_error_message" style="display: none"></div>
                            </div>
                            {{csrf_field()}}
                            <input type="hidden" name="user_id" id="offer_user_id" value="">

                            <div class="col-md-12">
                                <div class="admin_offer_change">
                                    <label class="text-center" for=""><b>Choose Offer</b></label>
                                    <div class="offer-itemlist">
                                        <div class="offer-item">
                                            <div class="offer-option-item green-offer-option">
                                                <p>Green</p>
                                                <input type="radio" name="offer" value="1" hidden="">
                                            </div>
                                        </div>
                                        <div class="offer-item">
                                            <div class="offer-option-item red-offer-option">
                                                <p>Red</p>
                                                <input type="radio" name="offer" value="2" hidden="">
                                            </div>
                                        </div>
                                        <div class="offer-item">
                                            <div class="offer-option-item pink-offer-option">
                                                <p>{{$offer->offer3_name}}</p>
                                                <input type="radio" name="offer_3" value="3" disabled="" hidden="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn theme-btn" id="update_offer">Update</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- END CONTENT -->

    <!-- START covid vacine company MODAL -->
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
                    <input type="hidden" name="user_id" id="covid_user_id" value="">

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
    <!-- END covid vacine company MODAL -->

    <!-- Modal -->
    <div class="modal fade" id="change_email_modal" tabindex="-1" role="change_email_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Change email</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="email_update_form" method="post" action="">
                            <div class="col-md-12">
                                <div class="alert alert-success" id="email_success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="email_error_message" style="display: none"></div>
                            </div>
                            {{csrf_field()}}
                            <input type="hidden" name="user_id" id="email_user_id" value="">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label ">Email*</label>
                                    <input class="form-control placeholder-no-fix" type="text" placeholder="Email*" name="email" id="user_email" value="" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn theme-btn" id="update_email">Update</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- END CONTENT -->

    <!-- Modal -->
    <div class="modal fade" id="update_payment_modal" tabindex="-1" role="update_payment_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="update_payment_modalLabel">Update payment</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="payment_update_form" method="post" action="">
                            <div class="col-md-12">
                                <div class="alert alert-success" id="payment_success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="payment_error_message" style="display: none"></div>
                            </div>
                            {{csrf_field()}}
                            <input type="hidden" name="user_id" id="payment_user_id" value="">
                            <input type="hidden" name="age" id="age" value="0">

                            <div class="col-md-10 col-md-offset-1">
                                <div class="row">
                                    <div class="col-md-6 col-md-offset-3">
                                        <div class="form-group">
                                            <div class="select-container">
                                                <div class="custom-select-wrapper">
                                                    <div class="custom-select">
                                                        <div class="custom-options">
                                                            <label class="w-100 text-center"><b>Select subscription plan</b></label>
                                                            <select class="form-control" name="subscription_plan_id" id="subscription_plan_id">
                                                                <option value="">Select</option>
                                                                @foreach($subscription_plans as $plan)
                                                                    <option value="{{$plan->id}}">{{$plan->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row mt-1">
                                                <div class="col-md-6 col-md-offset-3 form-group">
                                                    <label class="w-100 text-center"><b>Gender of vaccine</b></label>
                                                    <select name="gender" id="gender" class="form-control">
                                                        <option value="">Select Gender</option>
                                                        <option value="Male">Male</option></option></option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row mt-1">
                                                <div class="col-md-4 form-group">
                                                    <label class="">&nbsp;</label>
                                                    <select name="day" id="day" class="form-control">
                                                        <option disabled="true" value="">Day</option>
                                                        @for($i=1; $i<=31; $i++)
                                                            <option value="{{$i}}" @if($i==date('d')) selected @endif>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                </div>

                                                <div class="col-md-4 form-group">
                                                    <label class="w-100 text-center"><b>Date of birth for vaccine</b></label>
                                                    <select name="month" id="month" class="form-control">
                                                        <option disabled="true" value="">Month</option>
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
                                                    <label class="">&nbsp;</label>
                                                    <select name="year" id="year" class="form-control">
                                                        <option disabled="true" value="">Year</option>
                                                        @for($i=date('Y'); $i>=1920; $i--)
                                                            <option value="{{$i}}" @if($i==date('Y')) selected @endif>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>

                                            <input class="date-picker-hidden" type="hidden" name="shipment_date" id="shipment_date" value="{{date('Y-m-d')}}"/>
                                        </div>

                                        <div class="hidden" id="question_area">
                                            <div class="mb-3">
                                                <h5 class="text-center"><b>Do you take vaccine regularly?</b></h5>
                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-4 form-group text-center">
                                                        <label class="radio-inline mr-3">
                                                            <input class="question_radio" type="radio" name="regular_vaccine" id="regular_vaccine_yes" value="1"> Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input class="question_radio" type="radio" name="regular_vaccine" id="regular_vaccine_no" value="0"> No
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-1">
                                                <h5 class="text-center"><b>Did you miss any vaccine?</b></h5>
                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-4 form-group text-center">
                                                        <label class="radio-inline mr-3">
                                                            <input class="question_radio" type="radio" name="miss_vaccine" id="miss_vaccine_yes" value="1"> Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input class="question_radio" type="radio" name="miss_vaccine" id="miss_vaccine_no" value="0"> No
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group hidden">
                                            <div class="offer-itemlist">
                                                <div class="offer-option-item green-offer-option active_offer_option selected-offer">
                                                    <p>{{$offer->offer1_name}}</p>
                                                    <input type="radio" name="offer" value="1" hidden="" checked >
                                                </div>
                                                <div class="offer-option-item red-offer-option active_offer_option">
                                                    <p>{{$offer->offer2_name}}</p>
                                                    <input type="radio" name="offer" value="2" hidden="">
                                                </div>
                                                <div class="offer-option-item pink-offer-option">
                                                    <p>{{$offer->offer3_name}}</p>
                                                    <input type="radio" name="offer_3" value="3" disabled="" hidden="">
                                                </div>
                                            </div>
                                            <p class="text-center mt-3">Pink is free for female if any female buy green or red offer. </p>

                                        </div>

                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn theme-btn" id="update_payment">Update</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- END CONTENT -->

    <!-- Modal -->
    <div class="modal fade" id="unlock_shipping_modal" tabindex="-1" role="unlock_shipping_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Unlock Birth Date</h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="text-align:center;">
                        <input type="hidden" name="user_id" id="unlock_user_id" value="">
                        <h4>Are you sure you want to unlock this user's birth date update?</h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="button" class="btn theme-btn" id="unlock_shipping">Yes</button>
                        <button type="button" class="btn" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- END CONTENT -->
    <!-- Modal -->
    <div class="modal fade" id="unlock_user_gender_modal" tabindex="-1" role="unlock_user_gender_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Unlock User Gender</h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="text-align:center;">
                        <input type="hidden" name="user_id" id="unlock_gender_user_id" value="">
                        <h4>Are you sure you want to unlock this user's gender update?</h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="button" class="btn theme-btn" id="unlock_gender">Yes</button>
                        <button type="button" class="btn" data-dismiss="modal">No</button>
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

            function init_phone() {
                //Telephone number validation
                var input = document.querySelector("#telephone01");
                if(input != null){
                    var iti = window.intlTelInput(input, {
                        initialCountry: "bd",
                        separateDialCode: true,
                        utilsScript: "../assets/global/plugins/intl-tel-input-master/js/utils.js"
                    });

                    errorMsg = document.querySelector("#error-msg"),
                    validMsg = document.querySelector("#valid-msg");

                    // here, the index maps to the error code returned from getValidationError - see readme
                    var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

                    var reset = function() {
                        input.classList.remove("error");
                        errorMsg.innerHTML = "";
                        errorMsg.classList.add("hide");
                        validMsg.classList.add("hide");
                    };

                    // on blur: validate
                    input.addEventListener('blur', function() {
                        reset();

                        if (input.value.trim()) {
                            if (iti.isValidNumber()) {
                                validMsg.classList.remove("hide");
                            } else {
                                input.classList.add("error");
                                var errorCode = iti.getValidationError();
                                errorMsg.innerHTML = errorMap[errorCode];
                                errorMsg.classList.remove("hide");
                            }
                        }
                    });

                // on keyup / change flag: reset
                    input.addEventListener('change', reset);
                    input.addEventListener('keyup', reset);
                }

                var countryData = iti.getSelectedCountryData();
                if(countryData.iso2 == 'bd'){
                    $('#telephone01').css('padding-left', '82px');
                }

                // 0 1st digit in phone field
                $('#telephone01').on("keyup change", function () {
                    var countryData = iti.getSelectedCountryData();
                    if(countryData.iso2 == 'bd'){
                        var this_val = $(input).val().charAt(0);
                        if(this_val != 0){
                            $('#error-msg').removeClass('hide').text('Enter 0 as first digit');
                        }
                    }
                });

                $('#send_custom_sms_modal').on('hidden.bs.modal', function (e) {
                    var input = document.querySelector("#telephone01");
                    input.classList.remove("error");
                    errorMsg.innerHTML = "";
                    errorMsg.classList.add("hide");
                    validMsg.classList.add("hide");
                });
            };

            setTimeout(() => {
                init_phone();
            }, 100);
        });


        $(document).on('change','#day, #month, #year',function(){
            var day = $('#day').val();
            var month = $('#month').val();
            var year = $('#year').val();
            var date = year+'-'+month+'-'+day;

            var start = new Date(date);
            var end   = new Date();
            var diff  = new Date(end - start);
            var months  = diff/1000/60/60/24/30;

            if(months>=23){
                $('#question_area').removeClass('hidden');
            }
            else{
                $('#question_area').addClass('hidden');
            }
            $('#age').val(months);
        });

        //Auto select offer
        $('.question_radio').on('click',function(){
            var isRegular = $('input[name="regular_vaccine"]:checked').val();
            var isMissed = $('input[name="miss_vaccine"]:checked').val();
            if(isRegular == 1 && isMissed == 1){
                $('.offer-option-item ').each(function(){
                    var filtered_offer =$(this).children('input[name="offer"]').val();
                    if(filtered_offer == 1){
                        $(this).children('input[name="offer"]').prop('checked', true);
                        $('.offer-option-item').removeClass('selected-offer');
                        $(this).addClass('selected-offer');
                        //alert($(this).children('input[name="offer"]:checked').val());
                    }
                });
            }
            else{
                $('.offer-option-item ').each(function(){
                    var filtered_offer =$(this).children('input[name="offer"]').val();
                    if(filtered_offer == 2){
                        $(this).children('input[name="offer"]').prop('checked', true);
                        $('.offer-option-item').removeClass('selected-offer');
                        $(this).addClass('selected-offer');
                        //alert($(this).children('input[name="offer"]:checked').val());
                    }
                });
            }
        });

        $(document).on('click','.offer-option-item',function(){
            $('.offer-item').removeClass('selected-offer')
            $(this).parent('.offer-item').addClass('selected-offer');
            $(this).children('input[type="radio"]').prop('checked',true);
        });

        $(document).ready(function() {
            $('#email_message').summernote({
                height: 130,
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    //['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });


        /* checkbox select all*/

        $('#selectall').on('change', function () {
            $('.name').prop('checked', $(this).prop("checked"));
            if($('.name:checked').length > 0){
                $("#action_buttons").removeClass("hidden");
            }
            else{
                $("#action_buttons").addClass("hidden");
            }
        });

        $('.name').on("click", function () {
            if ($('.name:checked').length == $('.name').length) {
                $('#selectall').prop('checked', true);
            } else {
                $('#selectall').prop('checked', false);
            }

            if($('.name:checked').length > 0){
                $("#action_buttons").removeClass("hidden");
            }
            else{
                $("#action_buttons").addClass("hidden");
            }
        });


        function checkAll(){
            selectedAllValue = [];
            $('input[name="user_id[]"]:checked').each(function () {
                selectedAllValue.push(this.value);
            });
            if (selectedAllValue.length == 0) {
                $("#action_buttons").addClass("hidden");
            } else {
                $("#action_buttons").removeClass("hidden");
            }
        }

        $(document).on('click','#send_email_all',function(){
            var userIDs = $(".user_checkbox:checked").map(function(){
                return $(this).val();
            }).get();

            $('#user_id').val(userIDs);
            $('#subject').val('');
            $("#email_message").summernote("code", "");
            $("#send_email_modal").modal('show');
        });

        $(document).on('click','#send_sms_all',function(){
            var userIDs = $(".user_checkbox:checked").map(function(){
                return $(this).val();
            }).get();

            $('#sms_type').val('bulk');
            $('#sms_user_id').val(userIDs);
            $('#telephone01').val('');
            $('#sms_message').val('');
            $('#telephone_area').addClass('hidden');
            $("#send_sms_modal").modal('show');
        });

        $(document).on('click','#send_sms_custom',function(){
            $('#custom_sms_type').val('single');
            $('#custom_sms_user_id').val('');
            $('#telephone01').val('');
            $('#sms_message').val('');
            $("#send_custom_sms_modal").modal('show');
        });

        $(document).on('click','#delete_user_all',function(){
            var userIDs = $(".user_checkbox:checked").map(function(){
                return $(this).val();
            }).get();

            user_status_update_warning(userIDs,'deleted');
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

            var url = "{{ url('admin/update_user_status')}}";
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

        function send_email(user_id){
            $('#user_id').val(user_id);
            $('#subject').val('');
            $("#email_message").summernote("code", "");
            $("#send_email_modal").modal('show');
        }

        $(document).on("click", "#send_email", function(event) {
            event.preventDefault();

            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while sending email.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);

            var subject = $("#subject").val();
            var message = $("#email_message").val();
            var re = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            var validate = "";

            if (subject.trim() == "") {
                validate = validate + "Subject is required</br>";
            }
            if (message.trim() == "") {
                validate = validate + "Message is required</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#email_form")[0]);
                var url = "{{ url('admin/send_user_email') }}";

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

        function send_sms(user_id,country_code,phone){
            $('#sms_type').val('single');
            $('#sms_user_id').val(user_id);
            $('#telephone_area').removeClass('hidden');
            $('#phone').prop('readonly', true);
            $('#phone').val(phone);
            $('#phone-addon').text(country_code);
            $('#sms_message').val('');
            $("#send_sms_modal").modal('show');
        }

        $(document).on("click", "#send_sms", function(event) {
            event.preventDefault();

            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while sending sms.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);

            var sms_type = $('#sms_type').val();
            var phone = $("#phone").val();
            var country_code = $("#phone-addon").text();
            var message = $("#sms_message").val();
            var re = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            var validate = "";

            if (sms_type == "single" && phone.trim() == "") { // Phone validation fo single sms
                validate = validate + "Phone is required</br>";
            }
            if (message.trim() == "") {
                validate = validate + "Message is required</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#sms_form")[0]);
                formData.append('country_code', country_code);
                var url = "{{ url('admin/send_user_sms') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(data) {
                        HoldOn.close();
                        if (data.status == 200) {
                            $("#sms_success_message").show();
                            $("#sms_error_message").hide();
                            $("#sms_success_message").html(data.reason);
                            setTimeout(function(){
                                location.reload();
                            },2000)
                        } else {
                            $("#sms_success_message").hide();
                            $("#sms_error_message").show();
                            $("#sms_error_message").html(data.reason);
                        }
                    },
                    error: function(data) {
                        HoldOn.close();
                        $("#sms_success_message").hide();
                        $("#sms_error_message").show();
                        $("#sms_error_message").html(data);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            } else {
                HoldOn.close();
                $("#sms_success_message").hide();
                $("#sms_error_message").show();
                $("#sms_error_message").html(validate);
            }
        });

        $(document).on("click", "#send_custom_sms", function(event) {
            event.preventDefault();

            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while sending sms.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);

            var sms_type = $('#custom_sms_type').val();
            var phone = $("#telephone01").val();
            var country_code = $(".iti__selected-dial-code").text();
            var message = $("#custom_sms_message").val();
            var re = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            var validate = "";

            if (sms_type == "single" && phone.trim() == "") { // Phone validation fo single sms
                validate = validate + "Phone is required</br>";
            }
            if (message.trim() == "") {
                validate = validate + "Message is required</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#custom_sms_form")[0]);
                formData.append('country_code', country_code);
                var url = "{{ url('admin/send_user_sms') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(data) {
                        HoldOn.close();
                        if (data.status == 200) {
                            $("#custom_sms_success_message").show();
                            $("#custom_sms_error_message").hide();
                            $("#custom_sms_success_message").html(data.reason);
                            setTimeout(function(){
                                location.reload();
                            },2000)
                        } else {
                            $("#custom_sms_success_message").hide();
                            $("#custom_sms_error_message").show();
                            $("#custom_sms_error_message").html(data.reason);
                        }
                    },
                    error: function(data) {
                        HoldOn.close();
                        $("#custom_sms_success_message").hide();
                        $("#custom_sms_error_message").show();
                        $("#custom_sms_error_message").html(data);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            } else {
                HoldOn.close();
                $("#custom_sms_success_message").hide();
                $("#custom_sms_error_message").show();
                $("#custom_sms_error_message").html(validate);
            }
        });

        function send_message(user_id,message_id){
            $('#message_user_id').val(user_id);
            $('#message_id').val(message_id);
            $('#message').val('');
            $('#image_upload_input').val('');
            $("#send_message_modal").modal('show');
        }

        $(document).on("click", "#send_message", function(event) {
            event.preventDefault();

            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while sending email.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);
            var user_id = $("#user_id").val();
            var message = $("#message").val();
            var message_file = $("#image_upload_input").val();

            var validate = "";

            if (message.trim() == "" && message_file=='') {
                validate = validate + "You did not enter any message or file</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#message_form")[0]);
                var url = "{{ url('admin/store_message') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(data) {
                        HoldOn.close();
                        if (data.status == 200) {
                            window.location.href="{{url('admin/message')}}";
                        } else {
                            $("#message_success_message").hide();
                            $("#message_error_message").show();
                            $("#message_error_message").html(data.reason);
                        }
                    },
                    error: function(data) {
                        $("#message_success_message").hide();
                        $("#message_error_message").show();
                        $("#message_error_message").html(data);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            } else {
                HoldOn.close();
                $("#message_success_message").hide();
                $("#message_error_message").show();
                $("#message_error_message").html(validate);
            }
        });

        function update_payment(user_id){
            $('#payment_user_id').val(user_id);
            $("#payment_success_message").hide();
            $("#payment_error_message").hide();
            $("#update_payment_modal").modal('show');
        }

        $(document).on("click", "#update_payment", function(event) {
            event.preventDefault();

            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while saving data.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);

            var subscription_plan_id = $("#subscription_plan_id").val();
            var gender = $("#gender").val();
            var shipment_date = $("#shipment_date").val();
            var day = $('#day').val();
            var month = $('#month').val();
            var year = $('#year').val();
            var age = $('#age').val();

            var validate = "";

            if (subscription_plan_id.trim() == "") {
                validate = validate + "Subscription plan is required</br>";
            }
            if (gender.trim() == "") {
                validate = validate + "Gender is required</br>";
            }
            if (shipment_date.trim() == "") {
                validate = validate + "Birth date is required</br>";
            }
            if (shipment_date.trim() != "" && isFutureDate(shipment_date)) {
                validate = validate + "You can not select a future date</br>";
            }

            if (day.trim() == "" || month.trim() =='' || year.trim() =='') {
                validate = validate + "Birth date is required</br>";
            }

            if(age>=23){
                if (!$("input[name='regular_vaccine']:checked").val()) {
                    validate = validate + "Please give answer of the question 1</br>";
                }

                if (!$("input[name='miss_vaccine']:checked").val()) {
                    validate = validate + "Please give answer of the question 2</br>";
                }
            }

            if (validate == "") {
                var formData = new FormData($("#payment_update_form")[0]);
                var url = "{{ url('admin/update_user_payment') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(data) {
                        HoldOn.close();
                        if (data.status == 200) {
                            location.reload();

                        } else {
                            $("#payment_success_message").hide();
                            $("#payment_error_message").show();
                            $("#payment_error_message").html(data.reason);
                        }
                    },
                    error: function(data) {
                        HoldOn.close();
                        $("#payment_success_message").hide();
                        $("#payment_error_message").show();
                        $("#payment_error_message").html(data);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            } else {
                HoldOn.close();
                $("#payment_success_message").hide();
                $("#payment_error_message").show();
                $("#payment_error_message").html(validate);
            }
        });

        function change_offer(user_id){
            $('#offer_user_id').val(user_id);
            $("#offer_success_message").hide();
            $("#offer_error_message").hide();
            $("#change_offer_modal").modal('show');
        }

        $(document).on("click", "#update_offer", function(event) {
            event.preventDefault();

            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while sending email.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);

            var offer = $("input[name='offer']:checked").val();

            var validate = "";

            if (offer ===undefined || offer.trim() == "") {
                validate = validate + "Offer is required</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#offer_form")[0]);
                var url = "{{ url('admin/update_user_offer') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(data) {
                        HoldOn.close();
                        if (data.status == 200) {
                            $("#change_offer_modal").modal('hide');
                        } else {
                            $("#offer_success_message").hide();
                            $("#offer_error_message").show();
                            $("#offer_error_message").html(data.reason);
                        }
                    },
                    error: function(data) {
                        HoldOn.close();
                        $("#offer_success_message").hide();
                        $("#offer_error_message").show();
                        $("#offer_error_message").html(data);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            } else {
                HoldOn.close();
                $("#offer_success_message").hide();
                $("#offer_error_message").show();
                $("#offer_error_message").html(validate);
            }
        });

        function change_covid_vaccine_company(user_id){
            var url = "{{ url('admin/get_user_covid_vaccine_company') }}";

            $.ajax({
                type: "POST",
                url: url,
                data: {user_id:user_id,'_token':'{{ csrf_token() }}'},
                success: function(data) {
                    HoldOn.close();
                    var selected_company = data.user_covid_vaccine_company;
                    if (data.status == 200) {
                        if(selected_company !==null){
                            $('#covid_vaccine_company').val(selected_company.company_id);
                        }
                        else{
                            $('#covid_vaccine_company').val('');
                        }
                        $('#covid_user_project_id').val(data.user_project.user_project_id);
                        $('#covid_user_id').val(user_id);
                        $("#covid_company_modal").modal('show');
                    } else {
                        show_error_message('Something went wrong. TRy again later');
                    }
                },
                error: function(data) {
                    HoldOn.close();
                    show_error_message('Something went wrong. Try again later');
                }
            });

        }
        $(document).on("submit", "#covid_company_form", function(event) {
            event.preventDefault();

            show_loader();

            var covid_vaccine_company = $("#covid_vaccine_company").val();
            var user_project_id = $("#covid_user_project_id").val();

            var validate = "";

            if (covid_vaccine_company.trim() == "") {
                validate = validate + "Company is required</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#covid_company_form")[0]);
                var url = "{{ url('admin/update_user_covid_company') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(data) {
                        hide_loader();
                        if (data.status == 200) {
                            $('#covid_company_modal').modal('hide');

                            setTimeout(function(){
                                //location.reload();
                            },200)

                        } else {
                            show_error_message(data.reason);
                        }
                    },
                    error: function(data) {
                        hide_loader();
                        show_error_message(data);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            } else {
                hide_loader();
                $("#covid_success_message").hide();
                $("#covid_error_message").show();
                $("#covid_error_message").html(validate);
            }
        });

        function edit_email(user_id,email){
            $('#email_user_id').val(user_id);
            $('#user_email').val(email);
            $("#email_success_message").hide();
            $("#email_error_message").hide();
            $("#change_email_modal").modal('show');
        }

        $(document).on("click", "#update_email", function(event) {
            event.preventDefault();

            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while sending email.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);

            var email = $("#user_email").val();

            var validate = "";

            if (email.trim() == "") {
                validate = validate + "Email is required</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#email_update_form")[0]);
                var url = "{{ url('admin/update_user_email') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(data) {
                        HoldOn.close();
                        if (data.status == 200) {
                            location.reload();

                        } else {
                            $("#email_success_message").hide();
                            $("#email_error_message").show();
                            $("#email_error_message").html(data.reason);
                        }
                    },
                    error: function(data) {
                        HoldOn.close();
                        $("#email_success_message").hide();
                        $("#email_error_message").show();
                        $("#email_error_message").html(data);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            } else {
                HoldOn.close();
                $("#email_success_message").hide();
                $("#email_error_message").show();
                $("#email_error_message").html(validate);
            }
        });

        function unlock_birth_date(user_id){
            $('#unlock_user_id').val(user_id);
            $("#unlock_shipping_modal").modal('show');
        }

        $(document).on("click", "#unlock_shipping", function(event) {
            event.preventDefault();

            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while sending email.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);

            var user_id = $('#unlock_user_id').val();

            var validate = "";

            if (validate == "") {
                var url = "{{ url('admin/unlock_shipping_date') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: {user_id:user_id,'_token':'{{ csrf_token() }}'},
                    success: function(data) {
                        HoldOn.close();
                        if (data.status == 200) {
                            $("#unlock_shipping_modal").modal('hide');
                            //show_success_message(data.reason);
                        } else {
                            show_error_message('Something went wrong. TRy again later');
                        }
                    },
                    error: function(data) {
                        HoldOn.close();
                        show_error_message('Something went wrong. Try again later');
                    }
                });
            } else {
                HoldOn.close();
                show_error_message('Something went wrong. Try again later');
            }
        });

        function unlock_user_gender(user_id){
            $('#unlock_gender_user_id').val(user_id);
            $("#unlock_user_gender_modal").modal('show');
        }

        $(document).on("click", "#unlock_gender", function(event) {
            event.preventDefault();

            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while sending email.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);

            var user_id = $('#unlock_gender_user_id').val();

            var validate = "";

            if (validate == "") {
                var url = "{{ url('admin/unlock_user_gender') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: {user_id:user_id,'_token':'{{ csrf_token() }}'},
                    success: function(data) {
                        HoldOn.close();
                        if (data.status == 200) {
                            $("#unlock_user_gender_modal").modal('hide');
                            //show_success_message(data.reason);
                        } else {
                            show_error_message('Something went wrong. Try again later');
                        }
                    },
                    error: function(data) {
                        HoldOn.close();
                        show_error_message('Something went wrong. TRy again later');
                    }
                });
            } else {
                HoldOn.close();
                show_error_message('Something went wrong. Try again later');
            }
        });

    </script>
@endsection

