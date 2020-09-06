@extends('layouts.admin_master')
@section('title', 'Common Settings')
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
                        <span>Report</span>
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
                    <!-- BEGIN PORTLET-->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-share font-red-sunglo hide"></i>
                                <span class="caption-subject font-dark bold uppercase">Gender Report</span>
                                <span class="caption-helper"></span>
                            </div>
                            <div class="actions hidden" id="action_buttons">
                               <button type="button" class="btn btn-transparent theme-btn btn-circle btn-sm" title="Send Email" id="send_email_all">Send Email</button>
                               {{--<button type="button" class="btn btn-transparent theme-btn btn-circle btn-sm" title="Remove Users" id="delete_user_all">Delete Users</button>--}}
                            </div>
                        </div>
                        <div class="portlet-body p-relative">
                            <table id="report_table" class="table table-striped table-bordered table-hover data-table focus-table">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            Total Visitor
                                        </th>
                                        <th class="text-center">Total Male Visitor</th>
                                        <th class="text-center">Total Female Visitor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">
                                            2000
                                        </td>
                                        <td class="text-center">
                                            1200
                                        </td>
                                        <td class="text-center">
                                            800
                                        </td>
                                    </tr>
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
    </script>
@endsection

