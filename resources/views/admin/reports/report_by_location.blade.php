@extends('layouts.admin_master')
@section('title', 'Report by Location')
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
                                <span class="caption-subject font-dark bold uppercase">Location Report</span>
                                <span class="caption-helper font-dark bold uppercase">
                                    <a class="btn btn-xs btn-success " id="summary_table_excel_button" onclick="download_visitor_by_location()"> <i class="fa fa-download"></i> Download Excel </a>
                                </span>
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
                                    <th class="text-center">Location</th>
                                    <th class="text-center">Visitor</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $total_visitor = 0;
                                foreach($locations as $key=>$location){
                                    $total_visitor = $total_visitor+$location['sessions'];
                                ?>
                                    <tr>
                                        <td class="text-center">
                                            {{$location['country']}}
                                        </td>
                                        <td class="text-center">
                                            {{$location['sessions']}}
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-center">
                                            <b>Total</b>
                                        </td>
                                        <td class="text-center">
                                            {{$total_visitor}}
                                        </td>
                                    </tr>
                                </tfoot>
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
        function download_visitor_by_location() {
            var url = "{{ url("admin/download_report_location_excel") }}";
            window.open(url);
        }
    </script>
@endsection

